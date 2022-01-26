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
        <div class="content plain" id="cookies">
            
         <div class="content_bg">     
          <div class="title">
           <h1>Cookies</h1>
          <div class="underline2"></div>
          </div>
             
          <div class="content_inner_1">
              
            <p class="sub_header_1">This site uses cookies.</p>
              <br><br> 
              <p>The only cookie in use is an anonymous token that tells the website if you were logged in on your device. You can delete it using your browser settings.<br>
            </p>
               
               
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