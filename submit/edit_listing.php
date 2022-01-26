<?php
session_start();
define('unlock_includes', TRUE);
include '../functions.php';

//show spinner 

$_SESSION['show_loading'] = 1;
include '../loading.php';
unset($_SESSION['show_loading']);

//begin with no errors
unset($_SESSION['error']);
if(!isset($_SESSION['unique_url'])) {
 $_SESSION['error'] = 1;
 $_SESSION['error_type'] = 'link_invalid_2';
 //$_SESSION['box_type'] = 'edit_listing.php';
 push_back_instant('/index.php');
 exit();
}

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
  
  $_SESSION['error'] = 1;
  $_SESSION['error_type'] = 'required_input_missing';
  $_SESSION['box_type'] = 'edit_listing.php';
  push_back_instant ('/edit_listing.php');
   
 }
}


type_check_array($_POST,'string');
xss_protection_array($_POST);
list_a_job_length_checks();
//Remove emojis

//Add nulls if anything is missing

//Hard code in the username + page link
$_POST['username'] = $_SESSION['username'];
$_POST['page_link'] = $_SESSION['unique_url'];

//Insert
date_default_timezone_set('Europe/London');
$datestamp = date("d/m/y @ H:i");

if (!isset($_SESSION['error'])) {
 
 pdo_delete_or_update_v1("UPDATE `listed_jobs` SET `job_title` = '".$_POST['job_title']."' WHERE `listed_jobs`.`page_link` = '".$_SESSION['unique_url']."'");
 
  pdo_delete_or_update_v1("UPDATE `listed_jobs` SET `job_description` = '".$_POST['job_description']."' WHERE `listed_jobs`.`page_link` = '".$_SESSION['unique_url']."'");
 
  pdo_delete_or_update_v1("UPDATE `listed_jobs` SET `company_name` = '".$_POST['company_name']."' WHERE `listed_jobs`.`page_link` = '".$_SESSION['unique_url']."'");
 
  pdo_delete_or_update_v1("UPDATE `listed_jobs` SET `contact_email` = '".$_POST['contact_email']."' WHERE `listed_jobs`.`page_link` = '".$_SESSION['unique_url']."'");
 
  pdo_delete_or_update_v1("UPDATE `listed_jobs` SET `contact_phone` = '".$_POST['contact_phone']."' WHERE `listed_jobs`.`page_link` = '".$_SESSION['unique_url']."'");
 
  pdo_delete_or_update_v1("UPDATE `listed_jobs` SET `further_contact_details` = '".$_POST['further_contact_details']."' WHERE `listed_jobs`.`page_link` = '".$_SESSION['unique_url']."'");
 
  pdo_delete_or_update_v1("UPDATE `listed_jobs` SET `job_location` = '".$_POST['job_location']."' WHERE `listed_jobs`.`page_link` = '".$_SESSION['unique_url']."'");
 
  pdo_delete_or_update_v1("UPDATE `listed_jobs` SET `working_hours` = '".$_POST['working_hours']."' WHERE `listed_jobs`.`page_link` = '".$_SESSION['unique_url']."'");
 
  pdo_delete_or_update_v1("UPDATE `listed_jobs` SET `job_cat_1` = '".$_POST['job_cat_1']."' WHERE `listed_jobs`.`page_link` = '".$_SESSION['unique_url']."'");
 
   pdo_delete_or_update_v1("UPDATE `listed_jobs` SET `job_postcode` = '".$_POST['job_postcode']."' WHERE `listed_jobs`.`page_link` = '".$_SESSION['unique_url']."'");
 
    pdo_delete_or_update_v1("UPDATE `listed_jobs` SET `last_updated` = '".$datestamp."' WHERE `listed_jobs`.`page_link` = '".$_SESSION['unique_url']."'");
 
 //Check the chain
 
 //unset the one for this page
 unset ($_SESSION['update_text']);
 
 //Check for picture update request
 if (isset($_SESSION['update_image'])) {
  redirect_delay('/image_processing.php',2000);
  //Check for payment update request
 } else if (isset($_SESSION['update_payment_plan'])) {
  redirect_delay('../payment.php',2000);
  //If there are no pages left, push to my account with update message
 //Set the existing page to zero
 } else {
  $_SESSION['listing_updated'] = 1;
  redirect_delay('/my_account.php',2000);
 }
 
 
 
 
 
 
 
} else {
   
 $_SESSION['box_type'] = 'edit_listing.php';
 redirect_delay('../edit_listing.php',500);
 
}

   

?>