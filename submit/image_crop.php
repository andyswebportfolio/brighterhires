<?php
session_start();
define('unlock_includes', TRUE);
include '../functions.php';
//var_dump ($_POST);

if(!isset($_SESSION['unique_url'])) {
 push_back_instant('../index.php');
}

//Show Spinner
$_SESSION['show_loading'] = 1;
include '../loading.php';
unset($_SESSION['show_loading']);


if(isset ($_POST['javascript_image_base64']) ) {
 
 //process the front off of the string
 
 $str = $_POST['javascript_image_base64'];
 $str = substr( $str, ( $pos = strpos( $str, ',' ) ) === false ? 0 : $pos + 1 );
 
 
 //print the file if you choose to
 
 // SET IMAGE TYPE CORRECTLY HERE
 //header("Content-type: image/gif");
 //
 //echo base64_decode($str); 
 //otherwise, save the file to a folder
 $data = $_POST['javascript_image_base64'];
  if($_POST['javascript_image_base64'] !== 'javascript string') {
  list($type, $data) = explode(';', $data);
  list(, $data)      = explode(',', $data);
  $data = base64_decode($data);
 } else {
  push_back_instant('../image_processing.php');
  $_SESSION['error'] = 1;
  $_SESSION['error_type'] = 'data_type';
  $_SESSION['box_type'] = 'image_processing.php';
  exit();
 }


 //Set Filename
 $filename = $_SESSION['unique_url'];
 
 
 //Clear any old images from the same directory of different file types
 
 if (file_exists('../user_uploads/company_logos/'.$_SESSION['unique_url'].'.jpg')) {
   unlink ('../user_uploads/company_logos/'.$_SESSION['unique_url'].'.jpg');
 }
 
 if (file_exists('../user_uploads/company_logos/'.$_SESSION['unique_url'].'.png')) {
   unlink ('../user_uploads/company_logos/'.$_SESSION['unique_url'].'.png');
 }
 
 if (file_exists('../user_uploads/company_logos/'.$_SESSION['unique_url'].'.jpeg')) {
   unlink ('../user_uploads/company_logos/'.$_SESSION['unique_url'].'.jpeg');
 }
 
 if (file_exists('../user_uploads/company_logos/'.$_SESSION['unique_url'].'.jpe')) {
   unlink ('../user_uploads/company_logos/'.$_SESSION['unique_url'].'.jpe');
 }
 
 
 // Save the new file

 file_put_contents('../user_uploads/company_logos/'.$filename.'.'.$_SESSION['file_ext'], $data);
 
 
 /*update db with new link*/
    
 $link = '/user_uploads/company_logos/'.$_SESSION['unique_url'].'.'.$_SESSION['file_ext'];
 update_db("u221194601_brighter_hires","listed_jobs","page_link = '".$_SESSION['unique_url']."'","company_logo ='".$link."'");
 
 //Clear any temporary images
 
 if (file_exists('../uploads/'.$_SESSION['unique_url'].'.jpg')) {
   unlink ('../uploads/'.$_SESSION['unique_url'].'.jpg');
 }
 
 if (file_exists('../uploads/'.$_SESSION['unique_url'].'.png')) {
   unlink ('../uploads/'.$_SESSION['unique_url'].'.png');
 }
 
 if (file_exists('../uploads/'.$_SESSION['unique_url'].'.jpeg')) {
   unlink ('../uploads/'.$_SESSION['unique_url'].'.jpeg');
 }
 
 if (file_exists('../uploads/'.$_SESSION['unique_url'].'.jpe')) {
   unlink ('../uploads/'.$_SESSION['unique_url'].'.jpe');
 }
 
 //Unset this for if you want to change it later
 unset ($_SESSION['uploaded_file_path']);
 unset ($_SESSION['ext_file_upload_check']);
 unset ($_SESSION['file_ext']);



 //Check the chain
 
 //unset the one for this page
 unset ($_SESSION['update_image']);
 
 //Check for payment update request
 if (isset($_SESSION['update_payment_plan'])) {
  redirect_delay('../payment.php',2000);
  //If there are no pages left, push to my account with update message
  //Set the existing page to zero
  } else {
   $_SESSION['listing_updated'] = 1;
   redirect_delay('/my_account.php',2000);
  }

    

    

    $_SESSION['unlock_payment'] = 1;
 
 
 
} else {
 redirect_delay('../index.php',2000);
}


?>