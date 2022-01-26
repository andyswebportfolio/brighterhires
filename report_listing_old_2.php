<?php

session_start();
define('unlock_includes', TRUE);
include 'functions.php';

//Push back if not logged in
/*
if (!isset ($_SESSION['logged_in'])) {
   push_back_instant('index.php');
}
*/

//Import the existing array of reporting users

$reporting_array = pdo_return(
   "SELECT `reporting_users` FROM `listed_jobs` WHERE `page_link` = '".$_GET['a']."'"
)[0];

$reporting_array = (json_decode($reporting_array, true));
pre($reporting_array);

//If the current username is not in the string, take the current array, upload it
$username = $_SESSION['username'];
echo $username;

//Check the array for current usernames

$current_usernames = array() {
 for($i=0; $i<count($reporting_array); $i++) {
    echo $current_usernames[$i];
    /*
  if ($current_usernames[$i] == $username) {
     echo 'username_found';
  } else {
     //push the username to the array
     /*
   array_push($current_usernames, $username);
   $json_encode($current_usernames);
   pdo_delete_or_update_v1("UPDATE `listed_jobs` SET `reporting_users`='".$array."' WHERE `page_link` = '".$_GET['a']."' ");
   */
     echo 'username not found';
  }
 }
}




?>