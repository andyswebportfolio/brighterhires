<?php

if(!defined('unlock_includes')) {
 define('unlock_includes', TRUE);
}

include 'ip_security_lockout.php';

//Security_a

//Designed to work with the a string in the address bar

//Protect string against script injection

if (!isset ($_GET['a'])) {
 $_SESSION['error'] = 1;
 $_SESSION['error_type'] = 'link_invalid';
 push_back_instant('/index.php');
}

//If string is the wrong length
$correct_length = 11;
if (strlen($_GET['a']) > 11 || strlen($_GET['a']) < 10 ) {
 $_SESSION['error'] = 1;
 $_SESSION['error_type'] = 'link_invalid';
 push_back_instant('/index.php');
}
 
//If string containes any invalid characters, stop that
htmlentities($_GET['a'], ENT_QUOTES, 'UTF-8');

//Push back to index if not logged in
logged_in_check();

//Do not allow any unspecial characters to prevent sql injection

//Check if the listing exists

$id = count(pdo_return_secure('id','listed_jobs','page_link',$_GET['a']));


if ($id == 0) {
  $_SESSION['error'] = 1;
 $_SESSION['error_type'] = 'link_invalid';
 push_back_instant('/index.php');
 exit();
}

//Push back if the username
//does not match the hash from a
$listing_username = pdo_return_secure
 ('username','listed_jobs','page_link',$_GET['a'])[0];

if ( $listing_username !== $_SESSION['username'] ) {
 //push the user to index, show the error message
 $_SESSION['error'] = 1;
 $_SESSION['error_type'] = 'wrong_account';
 push_back_instant('/index.php');
}



?>