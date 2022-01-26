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
                
        <div class="content" id="reset_password">
            <?php include_error_reporting(); ?>
            <div class="form_container">
                <form action="submit/reset_password.php" method="post">
                    <h1>Reset Password</h1>
                    <p>Enter your email address or username<br> to reset your password.
                    </p>
                    <br><br>
                    Username or Email:
                    <input type="text" name="username_or_email" maxlength="350" autofocus required>
                    
                    <input type="submit" value="Reset">
                    
                </form>
            </div>
        </div>
        
        <?php include 'footer.php'?>
        <?php include 'functions_js.php'?> 
        
    </body>
</html>