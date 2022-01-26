<?php
session_start();
define('unlock_includes', TRUE);
include '../functions.php';

//*Check if request if from javascript or just some ruffian */


$passcode = file_get_contents('php://input');

if ($passcode !== '3254') {
 push_back_instant('../index.php');
 exit();
}
    //x is the row id in the database
if (!isset($_SESSION['logged_in'])) {
  echo '<meta http-equiv="refresh" content="0;url=index.php">';
  exit();
}



    
    //Getting total rows from PHP
    $row_count = count(pdo_return("SELECT `id` FROM `listed_jobs` WHERE `username` = '".$_SESSION['username']."' "));

    
    
    //Set up array
    $array = array();
    
  //Reverse or unreverse the order
  //for ($i=0; $i<$row_count; $i++) {
    for ($i=$row_count-1; $i>-1; $i--) {
     
     //Get the first rows sql id
     $sql_id = pdo_return("SELECT `sql_id` FROM `listed_jobs` WHERE `username` = '".$_SESSION['username']."' ")[$i];
     
     
     //Check it hasn't been deleted
     $test_1 = pdo_return("SELECT `user_delete_marked` FROM `listed_jobs` WHERE `username` = '".$_SESSION['username']."' ")[$i];
     
     if ($test_1 == 0) {
      
      $id_number = pdo_return("SELECT `id` FROM `listed_jobs` WHERE `sql_id` = '".$sql_id."' ")[0];
      
      $data = get_listed_jobs_data('my_account.php',$id_number)[0];
      $data['unix_time'] = 'Posted on '.date('j/n/y',$data['unix_time']);
      array_push($array,$data);
     } 
     
    }
    
    
    
    //pre($array);
     
    
     echo json_encode($array);

?>