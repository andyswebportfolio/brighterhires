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
        <div class="content plain" id="report_a_problem">
            
         <div class="content_bg">     
          <div class="title">
           <h1>Report A Problem</h1>
          <div class="underline2"></div>
          </div>
             
          <div class="content_inner_1">
              
           <p>Thank you for taking the time to notify us of a problem with the site. Please use the email address provided to help us fix what's going on. <br><br> We take all issues seriously and aim to solve any problems as soon as we can.<br><br>We are happy to credit you for finding bugs in our site on the credits page once we have solved and tested them.
              <br><br>
            
           Thank you for your support in improving the site.<br>
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