<?php
session_start();
define('unlock_includes', TRUE);
include 'functions.php';
include 'ip_security_lockout.php';
// Build something that takes all the inputs
// and makes a chain of pages to visit based on the input

//Set up security for $_GET['a']
if(!isset($_GET['a'])) {
 push_back_instant('/index.php');
}
$_SESSION['test_unique_col'] = $_GET['a'];
require_once ('security_a.php');
// If security passed, assign and run
$_SESSION['unique_url'] = $_GET['a'];
unset ($_SESSION['test_unique_col']);

//Unset session vars the submit page for this page can create

if(isset($_SESSION['update_text'])) {
 unset($_SESSION['update_text']);
}

if(isset($_SESSION['update_image'])) {
 unset($_SESSION['update_image']);
}

if(isset($_SESSION['update_payment_plan'])) {
 unset($_SESSION['update_payment_plan']);
}

//If there is no image on the listing

$is_image = pdo_return("SELECT `company_logo` FROM `listed_jobs` WHERE `page_link` = '".$_GET['a']."' ")[0];



 // do not allow update payment plan to be selected unless update image is selected first

?>

<!doctype html>
<html>
    <?php require 'head_tag.php';?>
 <style>
     /* The container */
.container {
  display: block;
  position: relative;
  padding-left: 55px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 20px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 5px;
  left: 20px;
  height: 25px;
  width: 25px;
  background-color: #eee;
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;   
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;   
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color:silver; 
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
  
.label_text {
 position:relative;
 top:2px;
}
  
</style>
    <body>
        
        <?php include 'header_plain.php';?>
        <?php include_error_reporting(); 
         if (isset ($_SESSION['error'])) {
          unset ($_SESSION['error']);
         }
        ?>
        
        <div class="content white" id="update_listing_select">
         
        <div id="checkboxes_container">
         

         
         <form action="submit/update_listing_select.php" method="post">
          <label class="container"><p class="label_text">Update Text</p>
            <input type="checkbox" name="update_text" value="1">
            <span class="checkmark"></span>
          </label>
          <!--
          <label class="container"><p class="label_text">Update Image</p>
            <input id="image_checkbox" type="checkbox" name="update_image" value="1" onclick="checkUpdateImage()">
            <span class="checkmark"></span>
          </label>
          <label class="container"><p class="label_text">Update Payment Plan</p>
            <input id="payment_plan_checkbox" type="checkbox" name="update_payment_plan" value="1" onclick="checkBox()">
            <span class="checkmark"></span>
           </label>-->
          <?php 
           if ($is_image == '') {
            echo '
            <script>
             
             function checkUpdateImage() {
               //if update payment plan is selected
               //deeselect it
               var x = document.getElementById("payment_plan_checkbox").checked;
               if (x == true) {
                var x = document.getElementById("payment_plan_checkbox").checked = false;
               }
               
              }
             
             function checkBox() {
              var x = document.getElementById("image_checkbox").checked;
              if (x == false) {
               document.getElementById("image_checkbox").checked = true;
              }

             }
             
            </script>
           ';
           } 
          ?>
          <br>
          <input type="submit" value="Submit" class="button1c" style="position:relative; left:20px;">
          </form>
          
         </div>
         
        </div>
        
        <?php include 'footer_plain.php'?>
        <?php include 'functions_js.php'?> 
        
    </body>
</html>