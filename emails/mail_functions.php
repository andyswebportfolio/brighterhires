<?php

if(!defined('unlock_includes')) {
 http_response_code(404);
 include('../404.php'); // provide your own HTML for the error page
 die();
}


 if (!function_exists('verify_account_detail')) { 
  function verify_account_detail($item) {

  $servername = "localhost";
  $username = "u221194601_root";
  $password = "Cube=c00l";
  $dbname = "u221194601_brighter_hires";

  try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $conn->prepare("SELECT ".$item." FROM verify_account"); 
      $stmt->execute();

      // set the resulting array to associative
      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 

      foreach($stmt as $x) {
          foreach ($x as $item) {
              return $item;
          }
      }
  }
  catch(PDOException $e) {
      echo "Error: " . $e->getMessage();
  }
  $conn = null;

  }
 }  

if (!function_exists('pdo_statement_v2')) { 
 function pdo_statement_v2($pdo_statement_v2) {
     require '../settings.php';
 /*using select * from only returns the first field it finds, 
 so be specific.*/

 $servername = $_SESSION['pdo_servername'];
 $username = $_SESSION['pdo_username'];
 $password = $_SESSION['pdo_password'];
 $dbname = $_SESSION['pdo_database'];

 try {
     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $stmt = $conn->prepare($pdo_statement_v2); 
     $stmt->execute();

     // set the resulting array to associative
     $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 

     foreach($stmt as $x) {
         foreach ($x as $item) {
             return $item;
         }
     }
 }
 catch(PDOException $e) {
     echo "<br>Error: " . $e->getMessage();
 }
 $conn = null;

 }
}

if (!function_exists('pre')) { 
 function pre($array) {
     //prints a formatted array
     print "<pre>";
     print_r($array);
     print "<pre>";

 }
}

if (!function_exists('pdo_return')) { 
 function pdo_return($pdo_stmt) {

     $servername = $_SESSION['pdo_servername'];
     $dbname = $_SESSION['pdo_database'];
     $username = $_SESSION['pdo_username'];
     $password = $_SESSION['pdo_password'];

     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $sth = $conn->prepare("".$pdo_stmt.""); 
     $sth->execute();

     /* Fetch all of the remaining rows in the result set */
     $result = $sth->fetchAll();

     //get the amount of results
     $result_amount = count($result);
     $results = array();

     for ( $i=0; $i < $result_amount; $i++) {
         array_push($results,$result[$i][0]);
     }

     return $results;

 }
}




?>
