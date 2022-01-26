<?php
session_start();
define('unlock_includes', TRUE);
include '../functions.php';

//// Security ////

//It security string from Javascript incorrect, push back

$security_string = file_get_contents('php://input');
if ($security_string !== '3254') {
 include('../404.php');
 exit();
}

//If not logged in, push back

if (!isset($_SESSION['logged_in'])) {
 include('../404.php');
 exit();
}

////


//Get data
//Download
$arr = pdo_return("SELECT `saved_jobs` FROM `users` WHERE `username` = '".$_SESSION['username']."'");

//Check it's not empty
if (empty($arr[0])) {
 $json = new \stdClass();
 $json->error = '1';
 $json->errorType = 'empty';
 $json = json_encode($json);
 echo $json;
 exit();
}

//Convert JSON to PHP Array
$arr = (json_decode($arr[0], true));

//Get listings data, push each to an array
$listing_array = array();

for ($i=0; $i<count($arr); $i++) {
 //Get listing data for each listing
 
 //If the listing has been deleted or is not live, remove it from the list

 
 
 //Assign it to an array
 
 //Check the listing has not been deleted and is listed
 
 $deleted = pdo_return("SELECT `user_delete_marked` FROM `listed_jobs` WHERE `page_link` = '".$arr[$i]."'")[0];
 //Sets deleted to 0 or 1 as set on other pages of the site
 
 $listed = pdo_return("SELECT `listing_live` FROM `listed_jobs` WHERE `page_link` = '".$arr[$i]."'")[0];
 
 if($deleted == 0 && $listed == 1) {
  $listing_data = pdo_return_arr("SELECT `company_name`,`job_title`,`job_description`,`company_logo`,`working_hours`,`unix_time`,`page_link` FROM `listed_jobs` WHERE `page_link` = '".$arr[$i]."' ")[0];
 } else {
  $listing_data = '';
 }
 

 
 //Shorten strings
 if(isset($listing_data['job_description'])) {
  $listing_data['job_description'] = substr($listing_data['job_description'],0,221).'...';
 }

 if ($listing_data !== '') {
  array_push($listing_array,$listing_data);
 }
 
}


//Add security string data so it can be see in javascript after being sent from javascript
array_push($listing_array,$security_string);

//output the array data in JSON format
echo json_encode($listing_array);

?>