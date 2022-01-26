<?php

//////////////////////////////////////////////////////////////////////////////////////
//Contents
//////////////////////////////////////////////////////////////////////////////////////
/*

0. Initialise

1. Security
 1a. If link is invalid, push to 404 page

2. Logic

//Contains fuck knows what at this point
 


*/
//////////////////////////////////////////////////////////////////////////////////////
//Initialise
//////////////////////////////////////////////////////////////////////////////////////

session_start();
define('unlock_includes', TRUE);
include 'functions.php';

//////////////////////////////////////////////////////////////////////////////////////
//Spinner Animation
//////////////////////////////////////////////////////////////////////////////////////

$_SESSION['show_loading'] = 1;
include 'loading.php';
unset($_SESSION['show_loading']);

//////////////////////////////////////////////////////////////////////////////////////
//1. Security // ! OFF
//////////////////////////////////////////////////////////////////////////////////////

//If link is invalid, push to 404 page

$page_link = pdo_return("SELECT `id` FROM `listed_jobs` WHERE `page_link` = '".$_GET['a']."'")[0];

if ($page_link == '') {
 $_SESSION['pushx2'] = 1;
 http_response_code(404);
 push_back_instant('/404.php'); // provide your own HTML for the error page
 die();
}

//////////////////////////////////////////////////////////////////////////////////////
//2. Logic
//////////////////////////////////////////////////////////////////////////////////////

 //21a.

 //Checks if the user's ip has reported the listing before. If it has not, update the unique ip reports number in the table. This is an output to be plugged in to a cron job later.

 //Record the User's IP Address
 $user_ip = get_real_ip_return();
 //echo $user_ip;
 //Check if this IP has seen the page before
 $ip_array = pdo_return("SELECT `ips_reported` FROM `listed_jobs` WHERE `page_link` = '".$_GET['a']."'")[0];
 $ip_array = json_decode($ip_array, true);
 //pre( $ip_array );

 //Find out if it has seen this ip before
 
 for($i=0; $i<count($ip_array); $i++) {
    if ($ip_array[$i] == $user_ip) {
       $ignore_ip = 1;
    }
 }
 if (!isset($ignore_ip)) {
  $ignore_ip = 0;
 }

 //Only push the ip to the array and update the counter if it's not been counted already
  //If it has, do not update the counter
 if ($ignore_ip == 0) {
  //If it has not, update the counter, push the IP to an array
    
    function update_array() {
       
      //Redeclare user IP
      $user_ip = get_real_ip_return();
       
      $column = 'ips_reported';
      $table = 'listed_jobs';
      $unique_column = 'page_link';
    
      //Download Column
      $data = pdo_return("SELECT `".$column."` FROM `".$table."` WHERE `".$unique_column."` = '".$_GET['a']."' ")[0];

      //Process Column
      $data = json_decode($data, true);
      array_push($data,$user_ip);
      $data = json_encode($data);
      //Upload Column
      pdo_delete_or_update_v1("UPDATE `".$table."` SET `".$column."`='".$data."' WHERE `".$unique_column."` = '".$_GET['a']."' ");
    }
    update_array();
    sql_update_by_1('unique_ip_reports','listed_jobs','page_link');
 }

$_SESSION['ip_report_made'] = 1;
push_back_instant('/popup_page.php');

   
?>