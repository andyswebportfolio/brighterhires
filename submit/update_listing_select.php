<?php
session_start();
define('unlock_includes', TRUE);
include '../functions.php';

//Security
if (!isset($_POST)) {
 $_SESSION['error'] = 1;
 $_SESSION['error_type'] = 'link_invalid_2';
 push_back_instant('/index.php');
 exit();
}

//set this for security purposes
$_GET['a'] = $_SESSION['unique_url'];
require_once('../security_a.php');
unset($_GET['a']);

//Push to the first box that is ticked
if(isset($_POST['update_text'])) {
 $_SESSION['update_text'] = 1;
 push_back_instant('../edit_listing.php');
}

if(isset($_POST['update_image'])) {
 $_SESSION['update_image'] = 1;
 push_back_instant('../image_processing.php');
}

if(isset($_POST['update_payment_plan'])) {
 $_SESSION['update_payment_plan'] = 1;
 $_SESSION['unlock_payment'] = 1;
 push_back_instant('../payment.php');
}

if( !isset($_POST['update_text']) && !isset($_POST['update_image']) && !isset($_POST['update_payment_plan']) ) {
 $_SESSION['error'] = 1;
 $_SESSION['error_type'] = 'box_blank';
 $_SESSION['box_type'] = 'update_listing_select.php';
 push_back_instant('../update_listing_select.php?a='.$_SESSION['unique_url']);
}

//

?>