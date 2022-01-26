<?php 
session_start();
define('unlock_includes', TRUE);
include 'functions.php';
include 'ip_security_lockout.php';
login_redirect();


?>



<!doctype html>
<html>
    <head>
        <?php require 'head_tag.php';?>   
    </head>
    <body>
        
        <?php include 'header.php';?>
        
        <div class="content" id="my_account">
            
            <div class="outer">
            
                
                
                
                <br>
                
                
                <div class="row_container">
                

                        <div class="account_column" id="close_account">
                            <div class="column_title_1">
                                Close My Account
                                <div class="underline2_1"></div>
                            </div>
                            
                            
                            <br>

                          
                            <p>We are sorry to see you go.<br><br>If you would like to send us a message with any feedback,<br>you can find links to contact us in the bar at the bottom of the page.</p>
                            <br><br>
                            <p>Clicking the button below will securely and permanently delete your account.<br><br></p>
                            Thank you for using Brighter Hires.
                            <br>
                            <br>
                            
                            
                            
                            
                            <div class="underline2_1"></div>
                            
                            <div class="column_footer_1">
                                <div class="button_array_1">
                                    <a href="submit/close_account_submit.php">Close Account</a>
                                    
                                    
                                </div>
                            </div><br>
                        </div>
                    
                        <br>
                    
                </div>
            
            </div>    <br>
        </div>
        

        <?php include 'footer.php'?>

        <?php include 'functions_js.php'?>
        
        <script>
        
        </script>
        
        <script>
            
            
            
        </script>
        

        
    </body>
</html>