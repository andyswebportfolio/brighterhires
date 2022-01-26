<?php

ob_start();
session_start();

define('unlock_includes', TRUE);
include 'functions.php';
include 'ip_security_lockout.php';
if (!isset($_SESSION['logged_in'])) {
    push_back_instant('/index.php');
}

$_SESSION['show_loading'] = 1;
include 'loading.php';
unset($_SESSION['show_loading']);

unset ($_SESSION['logged_in']);

if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}

//session is destroyed on next page
$_SESSION['logged_out'] = 1;



echo "<script>setTimeout(function(){window.location = 'logged_out.php';}, 2000)</script>";
ob_end_flush();
?>