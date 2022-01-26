<?php 

//Free Version

session_start();
define('unlock_includes', TRUE);
include 'functions.php';
include 'ip_security_lockout.php';

if(!isset($_SESSION['unlock_payment'])) {
    $_SESSION['payment_fail'] = 1;
    push_back_instant('popup_page.php');
    exit();
} else {
    unset($_SESSION['unlock_payment']);
}




//Tell the listing to be live

  sql_update("UPDATE `listed_jobs` SET `listing_live`='1' WHERE `page_link`= '".$_SESSION['unique_url']."' ");

//Tell the listing how long to be live for

set_expiry_sql();


//Set free listing to 1 (defaults to 0)

sql_update("UPDATE `listed_jobs` SET `free_listing`='1' WHERE `page_link`= '".$_SESSION['unique_url']."' ");


//Set for popup page message
$_SESSION['free_pass'] = 1;

//Add 1 to the lising created counter

$listing_counter = pdo_return("SELECT `listings_created` FROM `site_data` WHERE `sql_id` = 0 ")[0];

$listing_counter++;

sql_update("UPDATE `site_data` SET `listings_created`='".$listing_counter."' WHERE `sql_id`= 0 ");



?>

<!doctype html>
<html>
    <?php require 'head_tag.php';?>
    <body>
        
        <?php include 'header_plain.php';?>
        <div id="popup_test">
            <!--include popup.php-->
         <?php include 'popup.php'?>
        </div>
        
        <div class="content" id="index">
        
        </div>
        
        
        <?php include 'footer.php'?>
        <?php include 'functions_js.php'?>
        
        
    </body>
</html>
        