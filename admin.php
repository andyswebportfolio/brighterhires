<?php 
session_start();
define('unlock_includes', TRUE);
include 'functions.php';
include 'ip_security_lockout.php';

//Check the user is an admin, otherwise show 404

$admin = pdo_return("SELECT `admin` FROM `users` WHERE `username` = '".$_SESSION['username']."'")[0];
     
if ($admin !== '1') { 
 include('404.php');
 die();
}

?>

<!doctype html>
<html>
    <?php require 'head_tag.php';?>
    <body>
        
        <?php include 'header.php';?>    
         <?php include_error_reporting();
     

         ?>
     
        
        <div class="content" id="admin">
         
         Things
         <br><br>
         1) Display any jobs that are reported less than limit
         <br>
         2) Display any jobs that are more than limit
         <br>
         4) Delete any job from the system, (and run the cron job to actually delete it)
            
        </div>
        
        <?php include 'footer.php'?>
        <?php include 'functions_js.php'?>
        
    </body>
</html>