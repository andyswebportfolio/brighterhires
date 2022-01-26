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
        
        <?php include 'header_plain.php';?>
        <div class="content white" id="terms">
         
        <?php include 'privacy_policy_text.php';?>
        
         <div class="button_array_1">
             <div class="button_container">
                <button class="button1b" id="back_to_home" onclick='goBack()'>Go Back</button>
             </div>
            </div>
            
        </div>
        
        
        <?php include 'footer.php'?>
        <?php include 'functions_js.php'?> 
        
    </body>
</html>

