<?php
session_start();
define('unlock_includes', TRUE);
include '../functions.php';
include '../ip_security_lockout.php';

// Security

if (!isset($_SESSION['a'])) {
 push_back_instant('../index.php');
}

//

// Show Loading Wheel

$_SESSION['show_loading'] = 1;
include '../loading.php';
unset($_SESSION['show_loading']);

// Cancel Stripe Subscription (External)

 //Check for stripe subscription first

 $stripe_id = pdo_return("SELECT `stripe_id` FROM `listed_jobs` WHERE page_link = '".$_SESSION['a']."'")[0];


if ($stripe_id !== '') {
 require_once('../stripe/init.php');
 \Stripe\Stripe::setApiKey($_SESSION['stripe_private_key']);

 $sub_id = pdo_return("SELECT `stripe_id` FROM `listed_jobs` WHERE page_link = '".$_SESSION['a']."'")[0];

 $subscription = \Stripe\Subscription::retrieve($sub_id);

 $subscription->cancel();
}




//Mark as deleted in delete column in db

pdo_delete_or_update_v1("UPDATE `listed_jobs` SET `user_delete_marked` = '1' WHERE `page_link` = '".$_SESSION['a']."'");

//Unset session var from previous page

unset($_SESSION['a']);

// Push to popup page, after 0.5s delay

$_SESSION['listing_deleted_success'] = 1;
redirect_delay('../popup_page.php',500);

?>