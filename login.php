<?php 
session_start();
define('unlock_includes', TRUE);
include 'functions.php';
include 'ip_security_lockout.php';
if (isset($_SESSION['logged_in'])) {
    echo "<script>
    window.location = '/my_account.php';
    </script>";
}
?>

<!doctype html>
<html>
    <head>
        <?php require 'head_tag.php';?>   
    </head>
    <body>
        
        <?php include 'header.php';?>
        
        <?php if (isset($_SESSION['first_login'])) {
                include 'popup.php';
                unset($_SESSION['first_login']);
            }
        ?>
        
        <div class="content" id="login">
            <?php include_error_reporting(); ?>
                <div class="form_container">
                    <form action="submit/login_submit.php" method="post">
                        <h1>Login</h1>
                        Username or Email:
                        <input type="text" name="username_or_email" maxlength="35" autofocus required><br>
                        Password:
                        <input type="password" name="password" required><br>
                        <input type="submit" value="Submit">
                        <br><br>
                        <input type="checkbox" name="stay_logged_in" value="1" checked> Stay Logged In<br><br>

                        <div id="forgot_container">
                            <a id="forgot" href="reset_password.php">Forgot your details?</a>
                        </div>
                     <br>
                        <div id="create_account_container">
                            <a id="create_acc_button" href="create_account.php">Create Account</a>
                        </div>
                     <br>

                    </form>
                </div>
        </div>
        
        <?php include 'footer.php'?>
        <?php include 'functions_js.php'?>
        
    </body>
</html>