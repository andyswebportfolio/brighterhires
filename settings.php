<?php

if(!defined('unlock_includes')) {
 http_response_code(404);
 include('404.php'); // provide your own HTML for the error page
 die();
}

//Settings [session vars]

//PDO Login Settings

//If it's offline, do this


//! Needs to be copied manually for CRON Jobs {
////////////////////////////////////////
if ($_SERVER['HTTP_HOST'] == 'localhost:8888') {
 $_SESSION['pdo_servername'] = 'localhost';
 $_SESSION['pdo_username'] = 'root';
 $_SESSION['pdo_password'] = 'root';
 $_SESSION['pdo_database'] = 'brighter_hires';
} else {
 //If it's online, connect to online database
 $_SESSION['pdo_servername'] = 'localhost';
 $_SESSION['pdo_username'] = 'u221194601_root';
 $_SESSION['pdo_password'] = 'Cube=c00l';
 $_SESSION['pdo_database'] = 'u221194601_brighter_hires';
}
////////////////////////////////////////
//}

//Stripe Keys
$_SESSION['stripe_public_key'] = 'pk_live_i6DkhFTYlCg0vaxEWMctlwws';
$_SESSION['stripe_private_key'] = 'sk_live_HtXeVOMan5WLsWVEWGacE1Yc';

//** Version for GitHub */

//! Needs to be copied manually for CRON Jobs {
////////////////////////////////////////
/*

//Fill these in to connect database

    $_SESSION['pdo_servername'] = '';
    $_SESSION['pdo_username'] = '';
    $_SESSION['pdo_password'] = '';
    $_SESSION['pdo_database'] = '';

   //Stripe Keys
   $_SESSION['stripe_public_key'] = '';
   $_SESSION['stripe_private_key'] = '';
*/

?>