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
        
        <?php include 'header.php';?>    
         <?php include_error_reporting();
         ?>
        
        <div class="content" id="index">

           <div class="row_b">
              <div class="column_b left_b"></div>
              <div class="column_b middle_b" id="middle_column_desktop">
                 
                 <!--3 Header Images -->
                 
                 <img id="hero_image_desktop" src="img/content/index/hero_image_2500_nobg_v2.png"/>
                 
                 <img id="hero_image_tablet" src="img/content/index/hero_image_2500_nobg_v2.png"/>
                 
                 <img id="hero_image_mobile" src="img/content/index/hero_image_2500_nobg_v2.png"/>
                 
                 
              </div>
              <div class="column_b right_b"></div>
            </div>
           
           <div id="search_form_container">
               <form class="index_search" id="index_search_desktop" action="search.php">
                <input autofocus type="text" name="search" placeholder="Search Jobs...">
                 <button type="submit" id="index_search_button"></button>
               </form>
           </div>

        <?php include 'footer.php'?>
        <?php include 'functions_js.php'?>
        
    </body>
</html>