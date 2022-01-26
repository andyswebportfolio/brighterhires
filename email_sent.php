<?php 
session_start();
define('unlock_includes', TRUE);
include 'functions.php';
include 'ip_security_lockout.php';
if (!isset($_SESSION['email_sent'])) {
    push_back_instant('/index.php');
}
?>



<!doctype html>
<html>
    <?php require 'head_tag.php';?>
    <body>
        
        <?php include 'header.php';?>
        
        <?php include 'popup.php';?>
        
        <div class="content" id="index">
        
        </div>
        
        
        <?php include 'footer.php'?>
        <?php include 'functions_js.php'?>
        
    </body>
</html>