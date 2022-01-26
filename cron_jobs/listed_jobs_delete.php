<?php

session_start();
define('unlock_includes', TRUE);
include '../functions.php';
//Only turn this line on when you upload the cron job!
//$_SESSION['maintenance'] = 1;

//Clears out things marked for deletion

//User account
//Jobs created by user
//References to job created by user
//Deletes Jobs and Removes Saved Listings from Users Saved Jobs Arrays


//***************************************************
// Mark jobs associated with deletable user accounts for deletion

//for every username that is set to be deleted

$jobs_to_delete = array();

$output_array = array();

$deleted_accounts_usernames = pdo_return("SELECT `username` FROM `users` WHERE `deleted` = '1' ");

//pre($deleted_accounts_usernames);

for ($i=0; $i<count($deleted_accounts_usernames); $i++) {
 //return every job that user has listed
 $jobs_by_user = pdo_return("SELECT `sql_id` FROM `listed_jobs` WHERE `username` = '".$deleted_accounts_usernames[$i]."' ");
 
 for ($j=0; $j<count($jobs_by_user); $j++) {
  array_push($output_array,$jobs_by_user[$j]);
 }
 
 //push it to an array
}

//
//
//pre ($output_array);
//***************************************************
//For every job in the database with that username attached to it

for ($i=0; $i<count($output_array); $i++) {
 pdo_delete_or_update_v1("UPDATE `listed_jobs` SET `user_delete_marked`='1' WHERE `sql_id` = '".$output_array[$i]."' ");
}

//***************************************************

// Get an array of every sql id that is to be deleted
 // remove each from each user's saved jobs array

//Get length of users table

$users_table_length = count(pdo_return('SELECT `sql_id` FROM `users`'));

//Get the deleted page links
$deleted_page_links = pdo_return("SELECT `page_link` FROM `listed_jobs` WHERE `user_delete_marked` = '1' ");

//
//pre($deleted_page_links);


//*****
 //for every result in the users table
for ($i=0; $i<$users_table_length; $i++) {
 
 //Get the saved jobs array
 $saved_jobs_array = pdo_return("SELECT `saved_jobs` FROM `users` WHERE `id` = '".$i."' ");
 //Decode the array 
  if(isset($saved_jobs_array[0])) {
   $saved_jobs_array = json_decode($saved_jobs_array[0]);
  } else {
   $saved_jobs_array = array();
  }
  
  
  for ($j=0; $j<count($saved_jobs_array); $j++) {
  //echo $saved_jobs_array[$j].'<br>';
  
  for ($k=0; $k<count($deleted_page_links); $k++) {
   
   if ($saved_jobs_array[$j] == $deleted_page_links[$k]) {
     $saved_jobs_array[$j] = '';
   }
   
  }

 }
  
 

 //Check each item in the saved jobs array
 //for a match with each item in the deleted page links array
 
 if ($saved_jobs_array == null) {
  $saved_jobs_array = array();
 }
 
 $saved_jobs_array = array_filter($saved_jobs_array);
 $saved_jobs_array = array_values($saved_jobs_array);
 $saved_jobs_array = json_encode($saved_jobs_array);
 
 //
 //
 //******
 //pre($saved_jobs_array);
 
 //Upload that array to each user
 
  sql_update("UPDATE `users` SET `saved_jobs`='".$saved_jobs_array."' WHERE id= '".$i."' ");
 
 
}


//***************************************************
// Deleting Job Listings that are marked to delete
// This can be done by users, and is also done by this script
// if it detects a username is set to be deleted when this runs

//Step 0 Delete files associated with deleted rows

$get_page_links = pdo_return("SELECT `company_logo` FROM `listed_jobs` WHERE `user_delete_marked` = 1 ");

for ($i=0; $i<count($get_page_links); $i++) {
  //add the correct file path beginning on to the get page links strings
  $get_page_links[$i] = '..'.$get_page_links[$i];
  if (is_file($get_page_links[$i])) {
   unlink($get_page_links[$i]);
  }
}

//Step 1: Delete all offending rows

$rows_marked = pdo_return("SELECT `sql_id` FROM `listed_jobs` WHERE `user_delete_marked` = 1 ");

for ($i=0; $i<count($rows_marked); $i++) {
 sql_delete("DELETE FROM `listed_jobs` WHERE sql_id = '".$rows_marked[$i]."' ");
}

//Step 2: Reset the table

$table_sql_ids = pdo_return("SELECT `sql_id` FROM `listed_jobs` ");
$table_length = count(pdo_return("SELECT `sql_id` FROM `listed_jobs` "));

for ($i=0; $i<count($table_sql_ids); $i++) {
 sql_update("UPDATE `listed_jobs` SET `id`='".$i."' WHERE sql_id= '".$table_sql_ids[$i]."' ");
}

//***************************************************
// Deleting user accounts

sql_delete("DELETE FROM `users` WHERE `deleted` = '1' ");

//Reset id number so it can be used in programming loops

$table_sql_ids = pdo_return("SELECT `id` FROM `users` ");
$table_length = count(pdo_return("SELECT `id` FROM `users` "));

for ($i=0; $i<count($table_sql_ids); $i++) {
 sql_update("UPDATE `users` SET `id`='".$i."' WHERE  id= '".$table_sql_ids[$i]."' ");
}


?>