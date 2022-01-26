<?php

session_start();
define('unlock_includes', TRUE);
include '../functions.php';
include '../settings.php';


//Reset Session Error, just in case

if (!isset($_POST['new_password'])) {
    http_response_code(404);
    push_back_instant('../404.php');
    die();
}


unset ($_SESSION['error']);
unset ($_SESSION['error_type']);



//show loading wheel

$_SESSION['show_loading'] = 1;
include '../loading.php';
unset($_SESSION['show_loading']);




//get link to use from url in bar on previous page
//$_SESSION['username'} and //$_SESSION['pass_reset_hash']
$username = $_SESSION['username_bus'];
$reset_hash = $_SESSION['hash_bus'];
unset($_SESSION['hash_bus']);

//Set up a back link for functions written later on
$back_link = $_SERVER['HTTP_HOST']."/change_password.php?y=".$username."&z=".$reset_hash;


/* BOOKMARK. Tested and working up to here */

// Validate the new password


//Filter the password for weird characters

$_POST['new_password'] = htmlentities($_POST['new_password'], ENT_QUOTES, 'UTF-8');
$username = $_SESSION['username_bus'];
// Check the username and password don't match

if ($username == $_POST['new_password']) {
   //Do the error routine
   $_SESSION['usr_and_pass_match_reset_password'] = 1;
   push_back_instant('../popup_page.php');
}

//Check password is not longer than 75 chars


$strings = array($_POST['new_password']);
$limit = 75;
foreach($strings as $testcase) {
    $length = strlen($testcase);
    if ($length < $limit) {
        //echo 'limit check pass';
    } else {
        //echo 'limit check fail';;
       $_SESSION['length_check_password'] = 1;
       push_back_instant('../popup_page.php');
    }
}


//Check password is a string

$type = gettype($_POST['new_password']);
if ($type === "string") {
 //Do nothing, it's all good
} else {
 $_SESSION['string_type_fail_change_password'] = 1;    push_back_instant('../popup_page.php');
}

// Check the password is not the same as the last password
/*
$last_password = pdo_return("SELECT `password` FROM `users` WHERE `username` = '".$username."' ")[0];

if (password_verify($_POST['new_password'],$last_password)) {
         //It's the same. push back
         $_SESSION['password_matches_old_password'] = 1;   push_back_instant('../popup_page.php');
        }
*/

//Make sure the password doesn't match a bunch of the other details

 // declare data to compare with password

$arr1 = array (
    $first_name = pdo_statement_v1("SELECT first_name FROM users WHERE username ='".$username."'"),
    $middle_name = pdo_statement_v1("SELECT middle_name FROM users WHERE username ='".$username."'"),
    $last_name = pdo_statement_v1("SELECT last_name FROM users WHERE username ='".$username."'"),
    $username,
    $email = pdo_statement_v1("SELECT email FROM users WHERE username ='".$username."'"),
    $password = pdo_statement_v1("SELECT password FROM users WHERE username ='".$username."'"),
);

foreach ($arr1 as $item) {
    if ($item == $_POST['new_password']) {
     $_SESSION['key_detail_matches_new_password'] = 1;   push_back_instant('../popup_page.php');
    }
}


//Send the new password to the database, if it got this far

    //hash the password
    $pass = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

  
    //update the database {
      //check the username is in the database, + if statement
    //}

 $username_in_database = pdo_return("SELECT `id` FROM `users` WHERE `username` = '".$_SESSION['username_bus']."' ");

if (isset($username_in_database[0])) {

} else {
 //the username is not in the database!
 //Push back
 $_SESSION['username_not_found'] = 1;   
 push_back_instant('../popup_page.php');
}


     update_db('u221194601_brighter_hires','users',"username='".$_SESSION['username_bus']."'","password='".$pass."'");

    //check if the user is logged in, if they are not, log them in
    if (!isset($_SESSION['logged_in'])) {
        $_SESSION['username'] = $_SESSION['username_bus'];
        $_SESSION['logged_in'] = 1;
    }

    //clear the password reset link
    delete_row_from_db('u221194601_brighter_hires','reset_password','username',$_SESSION['username_bus']);
 

   
    //push to my account page with message saying password has been updated successfully
    unset($_SESSION['username_bus']);
    unset($_SESSION['hash_bus']);

    $_SESSION['password_changed'] = 1;

    redirect_delay('../my_account.php',2000);
 
   
?>