<?php 

session_start();
define('unlock_includes', TRUE);
include 'functions.php';
include 'ip_security_lockout.php';
?>

<!doctype html>
<html>
    <?php require 'head_tag.php';?>
    <body>
        
        <?php include 'header.php';?>    
         <?php include_error_reporting();?>
     
         <?php
       
       echo 'yee claw';
       
       if ($_SERVER['HTTP_HOST'] == 'localhost:8888') {
          
        } else {
        
       }
       
       ?>
     
     
        <?php include 'functions_js.php'?>

    </body>
</html>