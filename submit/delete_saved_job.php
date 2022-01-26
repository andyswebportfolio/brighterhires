<?php
session_start();
define('unlock_includes', TRUE);
include '../functions.php';

//Security

//check user is logged in

if(!isset($_SESSION['logged_in'])) {
 $_SESSION['login_required_message'] = 1;
 push_back_instant('../index.php');
 exit();
}

//if a is not set do not allow

if (!isset($_GET['a'])) {
 http_response_code(404);
 push_back_instant('../404.php');
 die();
}



$json = pdo_return("SELECT `saved_jobs` FROM `users` WHERE `username` = '".$_SESSION['username']."'" )[0];
$array = (json_decode($json, true));


//If it is found in the array, return a var
for ($i=0; $i<count($array); $i++) {
 if ($array[$i] == $_GET['a']) {
  //found in array
  $found = 1;
 }
}
 
 //if not found in array, tell user it was not in array

 if (!isset($found)) {
  push_back_instant('../my_account.php');
  $_SESSION['saved_job_not_found'] = 1;
  exit();
 }
 
 
 //If it is found in the array, remove it from the array

 if ($found == 1) {
  $test = in_array($_GET['a'],$array);
  if ($test == 1) {
   //get which number in the array $_GET['a'] is
   $key = array_search($_GET['a'],$array);
   
   //remove it from the array
   unset($array[$key]);
   
   //encode to JSON
   $json = json_encode(array_values($array));
   
   //return the array to sql
   pdo_delete_or_update_v1("UPDATE `users` SET `saved_jobs`='".$json."' WHERE `username` = '".$_SESSION['username']."' ");
   
   //All tested and working. It removes the item from the array when you click the delete button!
   
   //push back to my account page with success message
   
   push_back_instant('../my_account.php');
   $_SESSION['saved_job_removed'] = 1;
  }
          
 }

?>