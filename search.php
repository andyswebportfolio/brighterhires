<?php 
session_start();
define('unlock_includes', TRUE);
include 'functions.php';
include 'ip_security_lockout.php';
?>

<!doctype html>
<html>
    <head>
        <?php require 'head_tag.php';?>   
    </head>
    <body>
        
        <?php include 'header.php';?>
        <?php include_error_reporting(); ?>
       
        <div id="nav_footer">



        <?php
        /*
            //php echo it out

            if (location_data_bar() !== 0) {
                echo '

                <p class="greytext" id="location_data_display">Location: '. location_data_bar()[0].', '.location_data_bar()[2].' ('.location_data_bar()[1].')</p>
                <br><!--
                 <p class="greytext" id="remove_location" style="position:relative; top:-2px; font-size:0.8em">&nbsp;&nbsp;&nbsp;&nbsp;Use My Location</p>
                 <label class="switch" style="position:relative; bottom:-20px; left:10px">
                  <input type="checkbox" id="slider_1" <?php set_slider();?>>
                  <span class="slider round" onclick=location_data_switch();></span>
                  </label>-->
                 </div>
    
                ';
            }
            */


        ?>
       
       <?php
       
       //If the location wasn't found, hide the bar above
            /*
        echo "
        <script>
        
        var testElem = document.getElementById('location_data_display');
        
        if (testElem.innerHTML == 0 || testElem.innerHTML == '' || testElem.innerHTML == undefined || testElem.innerHTML == null ) {
        //alert ('nothing found');
        document.getElementById('nav_footer').style.display = 'none';
        //document.getElementById('location_data_display').innerHTML = ' Connection Error.<br>Refresh Page to use Auto-Location';
        }
 
        </script>";
       */

       
       ?>
       
        <div class="content" id="search_results">
            
        <div id="search_results_container">
         
        </div>
            
        <div id="loaderContainer2">  
         <div id="loader"> 
         </div>
        </div>
            
        </div>
        
        <!---removed if content is finished loading-->

        <!-- -->
        
        <?php include 'footer.php'?>
        <?php include 'functions_js.php'?>
        
    </body>
</html>