<?php 
session_start();
define('unlock_includes', TRUE);
include 'functions.php';
include 'ip_security_lockout.php';
if (isset($_SESSION['logged_in'])) {
    push_back_instant('/index.php');
}
?>

<!doctype html>
<html>
    <head>
        <?php require 'head_tag.php';?>   
    </head>
    <body>
        
        <?php include 'header.php';?>
        
        <div class="content" id="create_account">
            
            <?php include_error_reporting(); ?>
            
            <div class="form_container">
                <form id="create_account_form" action="submit/create_account_submit.php" method="post">
                    <h1>Create Account</h1>
                    First name:
                    <input type="text" name="first_name" maxlength="35" required><br>
                    Middle name(s):
                    <input type="text" name="middle_name" maxlength="35"><br>
                    Surname:
                    <input type="text" name="last_name" maxlength="35" required><br>
                    Username:
                    <input type="text" name="username" maxlength="35" required><br>
                    Email:
                    <input type="email" name="email" maxlength="350" required><br>
                    Password:
                    <input type="password" name="password" maxlength="75" required><br>
                    Gender:
                    <div class="custom-select" style="max-width:200px; position:relative; left:calc(50% - 100px); font-size:0.7em;">
                        <select name="gender" required>
                            <option value="" disabled selected hidden></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <br><br>
                    <input class="button1" type="submit" value="Submit">
                </form>
            </div>
        </div>
        <?php include 'footer.php'?>
        <?php include 'functions_js.php'?>
        
    </body>
</html>