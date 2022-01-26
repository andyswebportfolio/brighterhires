<?php
session_start();
define('unlock_includes', TRUE);
include '../functions.php';
include '../ip_security_lockout.php';

//Show 404 if a is not found
if (!isset($_GET['a'])) {
 http_response_code(404);
 include('../404.php'); // provide your own HTML for the error page
 die();
}

//Show Spinner
$_SESSION['show_loading'] = 1;
include '../loading.php';
unset($_SESSION['show_loading']);

//Push back if not logged in
if (!isset($_SESSION['logged_in'])) {
 $_SESSION['save_not_logged_in'] = 1;
 redirect_delay('../popup_page.php',1000);
}

//Get whatever is in the users saved array of saved jobs
$existing_saved_jobs = pdo_return("SELECT `saved_jobs` FROM `users` WHERE `username` = '".$_SESSION['username']."' ")[0];

//If it's nothing, make a new array
//Otherwise add to the existing one
if ($existing_saved_jobs !== '') {
 $run_existing_array = 1;
} else {
 $run_new_array = 1;
}

//If it's already saved, do not add it again

//echo $existing_saved_jobs;
if (strpos($existing_saved_jobs,$_GET['a']) !== false) {
 //was found
 $_SESSION['already_saved'] = 1;
 redirect_delay('../popup_page.php',1000);
 die();
} else {
 //was not found. continue
}

///create an array
///upload it
if (isset($run_new_array)) {
 $array = 'testtext';
 $arr = array(
  $_GET['a'],
 );

 $array = json_encode($arr);
}

if (isset($run_existing_array)) {
 ///download array
 //echo $existing_saved_jobs;
 $array = json_decode($existing_saved_jobs);
 ///update it
 array_push($array,$_GET['a']);
 $array = json_encode($array);
}

///Update the array into the users sql entry

 $servername = $_SESSION['pdo_servername'];
 $username = $_SESSION['pdo_username'];
 $password = $_SESSION['pdo_password'];
 $dbname = $_SESSION['pdo_database'];

 try {
     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
     // set the PDO error mode to exception
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     $sql = "UPDATE users SET saved_jobs='".$array."' WHERE username='".$_SESSION['username']."'";

     // Prepare statement
     $stmt = $conn->prepare($sql);

     // execute the query
     $stmt->execute();

     // echo a message to say the UPDATE succeeded
     //echo $stmt->rowCount() . " records UPDATED successfully";
     }
 catch(PDOException $e)
     {
     //echo $sql . "<br>" . $e->getMessage();
     }

 $conn = null;

//If it all went fine

$_SESSION['saved_jobs_updated'] = 1;
redirect_delay('../popup_page.php',1000);
die();

?>