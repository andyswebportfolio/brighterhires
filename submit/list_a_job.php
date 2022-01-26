<?php
session_start();
define('unlock_includes', TRUE);
include '../functions.php';
include '../settings.php';
include '../ip_security_lockout.php';



/*Reset Session Error, just in case*/

unset($_SESSION['error']);
unset($_SESSION['error_type']);

//Check there actually is anything

$required_inputs = array(
 'job_title',
 'job_description',
 'company_name',
 'contact_email',
 'contact_phone',
 'job_location',
 'job_postcode',
 'working_hours',
 'job_cat_1',
);

//Check if the title of the posted info is one of the required inputs

for ($i=0; $i<count($required_inputs); $i++) {
 if ($_POST[$required_inputs[$i]] == '' || !isset($_POST[$required_inputs[$i]]) ) {
  
  //echo the name of the input(s) that was/were missing, from the array
  
  /*
  
  $_SESSION['error'] = 1;
  $_SESSION['error_type'] = $required_inputs[$i].'_missing';
  push_back_instant ('/list_a_job.php');
  
  */
  
 }
}


// fail if input not present

if(!isset($_POST['job_title'])) {
    push_back_instant('../index.php');
}

//show spinner 

$_SESSION['show_loading'] = 1;
include '../loading.php';
unset($_SESSION['show_loading']);


// standard security

type_check_array($_POST,'string');
xss_protection_array($_POST);

//Check all the required inputs are not nothing

$missing_details = array(
 input_exists($_POST['job_title'],'job_title'),
 input_exists($_POST['job_description'],'job_description'),
 input_exists($_POST['company_name'],'company_name'),
 input_exists($_POST['contact_email'],'contact_email'),
 input_exists($_POST['contact_phone'],'contact_phone'),
 //Further Contact Details not required
 input_exists($_POST['job_location'],'job_location'),
 input_exists($_POST['job_postcode'],'job_postcode'),
 input_exists($_POST['working_hours'],'working_hours'),
 input_exists($_POST['job_cat_1'],'job_cat_1')
);

$missing_details = remove_empty_values_from_array($missing_details); 

//If there are any missing details, push back, return the formatted name

if (count($missing_details)>0) {
 $missing_details = (switch_underscore_for_space_and_capitalise($missing_details));
 $_SESSION['error'] = 1;
 $_SESSION['error_type'] = 'required_input_missing';
}



// specific security
list_a_job_length_checks();


if (!isset($_SESSION['error'])) {
    
    $expected_items = array(
    'username',
    'job_title',
    'job_description',
    //"$new_file_path",
    'contact_email',
    'contact_phone',
    'further_contact_details',
    'job_location',
    'job_postcode',
    'working_hours',
    'job_cat_1',
    'page_link',
    'company_name'
    );
    
    foreach ($expected_items as $item) {
        if (!isset($_POST[$item])) {
            $_POST[$item] = '';
        }
    }
    
    // Add extra columns for time and date
    
    $_SESSION['year'] = date('Y');
    $_SESSION['month'] = date('n');
    $_SESSION['day'] = date('j');
    $_SESSION['unix_time'] = time();
    
    //Create extra hard coded inputs
    
    $_SESSION['listing_live'] = 0;
    
    
    
    // create 11 letter unique url for job post
    
    require_once("../profanity_filter.php"); 
    do {
      // set some text to scan 
      $temp_url = random_url_string(10);
      $ft = new profanityFilter(); 
    
      $contentRating = $ft->scanText($temp_url); 
  
    if ($contentRating > 0) { 
        $profanity_check = 1;
        
    } else { 
        $profanity_check = 0;
    } 
     
    } while (unique_in_column('listed_jobs','page_link',$temp_url) == 1 && $profanity_check == 1 );
    
    $_SESSION['unique_url'] = $temp_url;
    

    // Insert
    pdo_in_v2();
 
   //Set unix expiry(extra)
   
   set_expiry_sql();
    
    // Unset extra column session data
    unset($_SESSION['year']);
    unset($_SESSION['month']);
    unset($_SESSION['day']);
    unset($_SESSION['unix_time']);
    
    
   //unlock the payment page since this is a fresh listing
  $_SESSION['update_payment_plan'] = 1;
 
   redirect_delay('../image_processing.php',2000);

} else {
    redirect_delay('../list_a_job.php',200);
}

//print_r(array_values($inputs));

?>