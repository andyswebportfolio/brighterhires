<?php
ob_start(); // this is required at the beginning and end
// to set cookies during the code instead of at the start
session_start();
define('unlock_includes', TRUE);
require '../functions.php';
require '../settings.php';
include '../ip_security_lockout.php';
/*pushback if page is wrong*/
if (!isset($_POST['username_or_email'])) {
     echo "<script>
            window.location = '../index.php';
            </script>";
}
    $error = NULL;
    
$_SESSION['show_loading'] = 1;
include '../loading.php';
unset($_SESSION['show_loading']);
    

        //echo '<h1>Report Mode</h1>';
    
        $user_input = array( 
        "username_or_email" => $_POST['username_or_email'],
        "password" => $_POST['password']
        );

    

    //echo '<h1>Input Data Recieved:</h1>';
    //echo 'Username or email: '.$user_input["username_or_email"].'<br>';
    //echo 'Password: '.$user_input["password"];

    
/*******************************************************************************************
    
/*Prevent XSS, Javascript Injection*/
$user_input["username_or_email"] = htmlentities($user_input["username_or_email"], ENT_QUOTES, 'UTF-8');
$user_input["password"] = htmlentities($user_input["password"], ENT_QUOTES, 'UTF-8');
    
/*Test Script Protection*/
//test_htmlentities();


    //echo '<br><h1>XSS Protection active</h1></br>';


/*******************************************************************************************
    
/*Data Type*/
/* checks whether the data is a string, integer, float, array and so on. */
    
//echo '<h1>Data Type Check</h1>';
    
foreach ($user_input as $testcase) {
    $type = gettype($testcase);
    if ($type === "string") {

            //echo 'Data: ['. $testcase."] ... Data Type check passed!";

    } else {
        login_error('data_type');
    }
    //echo "<br>";
}

    
/*******************************************************************************************
    

/*Allowed Characters [aka regex]*/
/*Could use php ctype, this allows all languages though, but no numbers or symbols/**/
    

    //echo '<br>';
    //echo "<h1>Allowed Characters Check</h1>";
    //echo "<br>";



if (preg_match('/[\p{Latin}[A-Za-z0-9-._@]*$/', $user_input['username_or_email'])) {
    //echo 'Data: ['. $user_input['username_or_email']."] ... Allowed characters check passed!";
} else {
    //echo "The string $testcase does not consist of all letters. Reject.\n";
    login_error('allowed_characters_username'); 
}
    

    //echo '<br>Password ['.$user_input["password"]. '] allows any character. Do not test.';
    //echo '<br>';




/*******************************************************************************************
    
/*Limit Check*/
/*Check size does not go over a set limit of characters*/


    //echo '<br>';
    //echo "<h1>Limit Check</h1>";


$limit = 35;

$length = strlen($user_input["username_or_email"]);
if ($length < $limit) {
   //echo $user_input["username_or_email"].' limit check pass, length = '.$length;
} else {
    //echo 'limit check fail';
    login_error('length_check');
}

    //echo '<br>';

    

$limit = 75;

$length = strlen($user_input["password"]);
if ($length < $limit) {
   //echo $user_input["password"].' limit check pass, length = '.$length;}
} else {
    //echo 'limit check fail';
    login_error('length_check');
}

    //echo '<br>';

    

/******************************************************************************************/
//flood_check();
/******************************************************************************************/
        

/* If email, return username */
    //echo '<br>............................<br>';
    //echo '<h1>If Email, Return Username</h1>';

            
if (strpos($user_input["username_or_email"], '@') !== false) {

        //echo $user_input["username_or_email"];
        //echo ' is an email address<br>';
    $is_email = 1;
} else {
   //echo $user_input["username_or_email"].' is a username. Continue';
}

if (isset($is_email)) {
    $username = pdo_statement_v1("SELECT username FROM users where email='".$user_input["username_or_email"]."';");
        //echo $username.' is username for email<br>'; 
    unset ($is_email);
} else {
    $username = $user_input["username_or_email"];
}


            
/*check if verify lock is on for that user*/
            

    //echo '<h1>Check Account Verify Lock</h1>';

            
$verify_lock = pdo_statement_v1("SELECT verify_lock FROM verify_account WHERE username = '".$username."'");
            
if ($verify_lock == 1) {

        //echo 'is present and locked. Fail check';

    $_SESSION['error'] = 1;
    set_error_type('verify_account');
    push_back('../login.php');
} else {
    //echo 'is not present and unlocked. continue';
}


    //echo '<br>............................<br>';


/*check if the account has been deleted*/

$deleted = pdo_statement_v1("SELECT `deleted` FROM `users` WHERE username = '".$username."'");

if ($deleted == 1) {
    $_SESSION['error'] = 1;
    set_error_type('login_invalid');
    push_back('../login.php');
}

/******************************************************************************************/
/*Security Passed!/*****\/Email converted + assigned to username!/*
/******************************************************************************************/

/*Check if username exists*/
//$user_input['username'] = 'moocow';
$user_input['username'] = $username;


if (!isset($_SESSION['error'])) {

        //echo '<h1>Verify User Details</h1>';
        //echo '<br>';


    $user_check = pdo_statement_v1("SELECT username FROM users WHERE username = '".$user_input['username']."'");

    if ($user_check ==!NULL) {

            //echo 'user '.$user_input['username'].' found!';

        $user_found = 1;
    } else {

            //echo 'user '.$user_input['username'].' not found.';
       
        login_error('login_invalid');
    }


        //echo '<br>';

    if (isset($user_found)) {
        $user_password = pdo_statement_v1("SELECT password FROM users WHERE username = '".$user_input['username']."'");

       if (password_verify($user_input['password'],$user_password)) {

          //echo "Password verified";

           $login_success = 1;
        } else {

          //echo "Password Not verified";

           login_error('login_invalid');
        }
    }

    if (isset($login_success)) {

            //echo '<br><br>login success!';

        //Assign username to session variable
        if (isset($user_input['username'])) {
            $_SESSION['username'] = $user_input['username'];
        }
        
        $_SESSION['logged_in'] = 1;
        
         /*Check for login box. If ticked, store login cookie on device.*/
        if( isset($_POST['stay_logged_in']) && $_POST['stay_logged_in']==1 ) {
           if(!isset($_COOKIE['cookie_1'])) {
                $login_token = pdo_statement_v1("SELECT login_token FROM users where username = '".$_SESSION['username']."'");
                set_login_cookie($login_token);
            } 
        }
        
        push_back('/my_account.php');
    }
}
ob_end_flush();



?>