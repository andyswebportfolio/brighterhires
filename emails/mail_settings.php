<?php

if(!defined('unlock_includes')) {
 http_response_code(404);
 include('../404.php'); // provide your own HTML for the error page
 die();
}

$_SESSION['force_view'] = NULL;
$_SESSION['send_email'] = 1; 
$_SESSION['localhost'] = 1;
?>

