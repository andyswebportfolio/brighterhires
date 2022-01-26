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

         <div class="content" id="create_account">
            
            <?php include_error_reporting(); ?>
            <?php $arr = get_account_details($_SESSION['username']);?>
            
            <div class="form_container">
                
                <form id="create_account_form" action="submit/edit_account_details_submit.php" method="post">
                    
                    <h1>Edit Details</h1>
                    
                    First name:
                    <input type="text" name="first_name" maxlength="35" value="<?php echo $arr[0];?>" required><br>
                    Middle name(s):
                    <input type="text" name="middle_name" maxlength="35" value="<?php echo $arr[1];?>"><br>
                    Surname:
                    <input type="text" name="last_name" maxlength="35" value="<?php echo $arr[2];?>" required><br>
                    Username:
                    <input type="text" name="username" maxlength="35" value="<?php echo $arr[3];?>" required><br>
                    Email:
                    <input type="email" name="email" maxlength="350" value="<?php echo $arr[4];?>" required><br> 
                    Password:
                    <input type="password" name="password" maxlength="75" required><br>
                    Gender:
                    <div class="custom-select" style="max-width:200px; position:relative; left:calc(50% - 100px); font-size:0.7em;">
                        <select name="gender" id="gender_select">
                            <option id="existing_value_gender" value="<?php echo $arr[5];?>" selected><?php echo $arr[5];?></option>
                            <option value="Male" id="male_gender_value">Male</option>
                            <option value="Female" id="female_gender_value">Female</option>
                            <option value="Other" id="other_gender_value">Other</option>
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