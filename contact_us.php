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
        <div class="content plain" id="contact_us">
            
         <div class="content_bg">     
          <div class="title">
           <h1>Get In Touch</h1>
          <div class="underline2"></div>
          </div>
             
          <div class="content_inner_1">
           <p>Thank you for taking the time to get in touch. Whether you need help, have some feedback or wish to submit a complaint, or for any other reason, please use the email address provided to send your message. <br>
               <br>
               <p id="support_email_address">msg.brighterhires@gmail.com</p>
            
               
               
           <div class="column_footer_1">
            <div class="button_array_1">
             <div class="button_container">
                <button class="button1b" id="back_to_home" onclick='goBack()'>Go Back</button>
             </div>
            </div>
           </div>
          </div>
            
        </div>
        </div>
        
        
        <?php include 'footer.php'?>
        <?php include 'functions_js.php'?> 
        
    </body>
</html>