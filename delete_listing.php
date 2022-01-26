<?php 
session_start();
define('unlock_includes', TRUE);
include 'functions.php';
include 'ip_security_lockout.php';
login_redirect();

//if not logged in, push back

if (!isset($_SESSION['logged_in'])) {
 $_SESSION['login_required_message'];
 push_back_instant('../index.php');
 exit();
}

//Security for a
require_once('security_a.php');

//Check it hasn't been deleted

$deleted = pdo_return("SELECT `user_delete_marked` FROM `listed_jobs` WHERE `page_link` = '".$_GET['a']."' ")[0];

if ($deleted == 1) {
 $_SESSION['link_invalid_2'] = 1;
 push_back_instant('/popup_page.php');
 exit();
}

//if a is set, check the hash matches the username
//if it does not, exit, and push back to index

$username_for_listing = pdo_return("SELECT `username` FROM `listed_jobs` WHERE `page_link`='".$_GET['a']."'")[0];

if (isset($_GET['a'])) {
 if ($_SESSION['username'] !== $username_for_listing) {
  push_back_instant('../index.php');
  exit();
 }
}



//if all of that passes, assign it in to session var

$_SESSION['a'] = $_GET['a'];

?>



<!doctype html>
<html>
    <head>
        <?php require 'head_tag.php';?>   
    </head>
    <body>
        
        <?php include 'header.php';?>
        <?php 
        
        //Get Data
        
        $job_title = pdo_return("SELECT `job_title` FROM `listed_jobs` WHERE `page_link` = '".$_GET['a']."' ")[0];
        
        $company_name = pdo_return("SELECT `company_name` FROM `listed_jobs` WHERE `page_link` = '".$_GET['a']."' ")[0];
        
        $unix_time = pdo_return("SELECT `unix_time` FROM `listed_jobs` WHERE `page_link` = '".$_GET['a']."' ")[0];

        
        ?>
        <div class="content" id="my_account">
            
            <div class="outer">
                <br>
                <div class="row_container">
                
                        <div class="account_column" id="delete_listing">
                            <div class="column_title_1">
                                Delete this listing    
                            </div>
                            
                                <div id="delete_listing_container">
                                    <div class="data_box_1 green"><div class="data_box_header_1"><?php echo $job_title;?><div class="data_box_header_1_a"><?php echo $company_name;?></div><br><p class="highlight_green">Last Updated <?php echo date("j/m/y",$unix_time);?></p></div><div class="button_array_1"></div></div>
                                </div>
                            <br>
                          
                            <p>This page allows you to delete your listing completely.  
                                
                            <br>Any payment will be cancelled within 24 hours<br> and the listing will be permanently deleted from our system.<br><br>
                            <!--If you need a copy of the listing, you can download it using the button below.
                            <br>
                                <div class="button_array_1">
                                    <a href="submit/download_listing.php">Download Listing</a>        
                                </div>
                            <br>-->

                            Thank you for using Brighter Hires.
                            <br>
                            <br>
                            
                            <div class="underline2_1"></div>
                            
                            <div class="column_footer_1">
                                <div class="button_array_1">
                                    <a href="submit/delete_listing.php">Delete Listing</a>        
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