<?php 
session_start();
define('unlock_includes', TRUE);
include 'functions.php';
include 'ip_security_lockout.php';

    /* Stops email page being seen, is a hack, this is set on both payment pages*/
    if(!isset($_SESSION['period'])) {
        unset($_SESSION['period']);
    }
    


//Security

/*
    if (!isset ($_SESSION['checkout_complete'])) {
        push_back_instant('/');
    }
    
    unset ($_SESSION['checkout_complete']);

*/

?>

<!doctype html>
<html>
    <?php require 'head_tag.php';?>
    <body>
        
        <?php include 'header_plain.php';?>
        <?php include_error_reporting(); ?>  
        <div class="content" id="thankyou">
            
         <div class="content_bg plain">     
          <div class="title">
           <h1>Thank you</h1>
          <div class="underline2"></div>
          </div>
             
          <div class="content_inner_1">
              
            <p class="sub_header_1">Your listing is now live!</p>
              <br><br> 
              <p>We have sent an email receipt to the address used on your account.<br>
            <br>
            Thank you for choosing Brighter Hires.
            </p>
               
               
           <div class="column_footer_1">
            <div class="button_array_1">
             <a href="/">Home</a>
            </div>
           </div>
          </div>
   
         </div>
            
        </div>
        
        <?php include 'footer_plain.php'?>
        <?php include 'functions_js.php'?> 
        <?php
         if(isset($_SESSION['unique_url'])) {
         unset($_SESSION['unique_url']);
         }
        ?>
        
    </body>
</html>