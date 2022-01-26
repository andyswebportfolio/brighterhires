<?php

//---------------------------------------------------------
//0. Init and Security
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//! pushback is off! based on post, line 23~
//---------------------------------------------------------

///////////////////////////////////////////////////////////
//1. Initialise
//////////////////////////////////////////////

session_start();
define('unlock_includes', TRUE);
include '../functions.php';
include '../settings.php';

///////////////////////////////////////////////////////////
//2. Secure
//////////////////////////////////////////////

// fail if input not correct 

if(!isset($_POST['username_or_email'])) {
    //push_back_instant('../index.php');
}

// declare data 

$inputs = array (
 $_POST['username_or_email']
);



//standard security
type_check_array($inputs,'string');

xss_protection_array($inputs);

length_limit_array($inputs,350);

//specific security
$type = email_or_username($inputs[0]); // Returns 'email' or 'username'

   
//Set Up Error Pushback for the above security
if (isset($_SESSION['error'])) {
    $_SESSION['custom_redirect'] = '/reset_password.php';
    push_back_instant('../popup_page.php');
}

//check if user exists (Always returns the email address)
//AND //If it's a username, look for the email address

//Returns the email address if a username was typed,
//email address if email address was typed and is in database,
//fails otherwise

if (isset($inputs[0])) {
 $user_email = pdo_return("SELECT email FROM users WHERE ".$type. "  ='".$inputs[0]."'");
}

if (sizeof($user_email) < 1) {
   $_SESSION['user_not_found'] = 1;
   push_back_instant('../popup_page.php');
} else {
   $user_email = $user_email[0];
}

///////////////////////////////////////////////////////////
//3. Logic
//////////////////////////////////////////////

//Use The Data you have checked to process the output


//Get username for email url
$username_from_sql = pdo_return("SELECT username FROM users WHERE email  ='".$user_email."'")[0];

//Check if the username is in the password reset table
$username_in_table = pdo_return("SELECT `id` FROM `reset_password` WHERE `username` = '".$username_from_sql."' ");
//pre($username_in_table);

//If there is no entry for the user, generate a hash and add it to the password reset table
if (!isset($username_in_table[0])) {
 //Create one and add it to the database

   $reset_hash = generate_unique_password_token();
   //echo $reset_hash;
   
   //Post hash and username to reset_password table

       //Connect to SQL

       $pdo_servername = $_SESSION['pdo_servername'];
       $pdo_username = $_SESSION['pdo_username'];
       $pdo_password = $_SESSION['pdo_password'];
       $pdo_dbname = $_SESSION['pdo_database'];

       try {
           $conn = new PDO("mysql:host=$pdo_servername;dbname=$pdo_dbname", $pdo_username, $pdo_password);
           // set the PDO error mode to exception
           $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

           // prepare sql and bind parameters
           $stmt = $conn->prepare("INSERT INTO reset_password (username, reset_hash) 
           VALUES (:username, :reset_hash)");
           $stmt->bindParam(':username', $insert_username);
           $stmt->bindParam(':reset_hash', $insert_reset_hash);

           // insert a row
           $insert_username = $username_from_sql;
           $insert_reset_hash = $reset_hash;

           $stmt->execute();

           //echo "Details Posted to users database!";
           }
       catch(PDOException $e)
           {
           //echo "Error: " . $e->getMessage();
           }
       $conn = NULL;
   
       //Set the username based on what was just posted to SQL
   
} else {
      //Set the reset hash to what is found for that username in the sql table
      $reset_hash = pdo_return("select reset_hash from reset_password where username ='".$username_from_sql."' ")[0];
      
}

//Assign variable name used in email file
$username = $username_from_sql;

//Unlock and include the email file
$_SESSION['unlock_email'] = 1;
include '../emails/reset_password.php';


///////////////////////////////////////////////////////////
//4. Display
//////////////////////////////////////////////
   
//Show spinning thing

$_SESSION['show_loading'] = 1;
include '../loading.php';
unset($_SESSION['show_loading']);

?>