<?php

//////////////////////////////////////////////////////////////////////////////////////////
//1. Initialise
///////////////

session_start();
define('unlock_includes', TRUE);
include 'functions.php';
include 'ip_security_lockout.php';

//////////////////////////////////////////////////////////////////////////////////////////
//2. Security
///////////////

//If either one is not set, push back

if ( (!isset($_GET['y'])) || (!isset($_GET['z'])) ) {
    push_back_instant('../index.php');
}

//Format it for some error encountered by the verify_account.php page, which this is based on
$_GET['z'] = urlencode($_GET['z']);



//If either one is not in the table, push back

//Check if username is in table
$check1 = pdo_return("select id from reset_password where username = '".$_GET['y']."' ");

//If it's not, push to index
if (!isset($check1[0])) {
 $_SESSION['password_reset_hash_not_found'] = 1;
 push_back_instant('../popup_page.php');
}


//Check if hash is in table
$check2 = pdo_return("select id from reset_password where reset_hash = '".$_GET['z']."' ");

if (!isset($check2[0])) {
 $_SESSION['password_reset_hash_not_found'] = 1;
 push_back_instant('../popup_page.php');
}

//Assign data to post to next page

$_SESSION['username_bus'] = $_GET['y'];
$_SESSION['hash_bus'] = $_GET['z'];


//////////////////////////////////////////////////////////////////////////////////////////
//3. Display
///////////////

?>

<!doctype html>
<html>
    <?php require 'head_tag.php';?>
    <body>
        
        <?php include 'header_plain.php';?>
                
        <div class="content" id="change_password">
            <?php include_error_reporting(); ?>
            <div class="form_container">
                <form action="submit/change_password.php" method="post">
                    <h1>New Password</h1>
                    <p>Enter your new password.
                    </p>
                    
                    <input type="password" name="new_password" autofocus required>
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
        
        <?php include 'footer_plain.php'?>
        <?php include 'functions_js.php'?>
        
    </body>
</html>