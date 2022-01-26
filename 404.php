<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(!defined('unlock_includes')) {
 define('unlock_includes', TRUE);
}


foreach (get_included_files() as $item ) {        
    $string = 'functions.php';
    $string2 = 'settings.php';
    $string3 = 'ip_security_lockout.php';
 
    if (strpos($item, $string) == false) {
        include_once 'functions.php';
    }
    unset($string);
    if (strpos($item, $string2) == false) {
        include_once 'settings.php';
    }
 
    if (strpos($item, $string3) == false) {
        include_once 'ip_security_lockout.php';
    }

}

?>

<!doctype html>
<html>
    <?php require 'head_tag.php';?>
    <body>
        

        <div style="height:80px;"></div>
        <div class="content plain" id="cookies">
            
         <div class="content_bg">     
          <div class="title">
           <h1>Error 404</h1>
          <div class="underline2"></div>
          </div>
             
          <div class="content_inner_1">
              
            <p class="sub_header_1">This page was not found.</p>

           <div class="column_footer_1">
            <div class="button_array_1">
             <div class="button_container">
                <?php
                 if (isset($_SESSION['pushx2']) ) {
                    unset ($_SESSION['pushx2']);
                  echo "<button class='button1b' id='back_to_home' onclick='goBack2()'>Go Back</button>";
                 } else if (isset($_SESSION['push_to_home'])) {
                  echo "<button class='button1b' id='back_to_home' onclick='popup_fadeout_redirect_upOneLevel()'>Continue</button>";
                 } else {
                    echo "<button class='button1b' id='back_to_home' onclick='popup_fadeout_redirect_upOneLevel()'>Go Back</button>";
                 }
                 
                ?>

             </div>
            </div>
           </div>
          </div>
            
        </div>
        </div>
        
        
        <?php include 'footer_plain.php'?>
        <?php include 'functions_js.php'?> 
        
    </body>
</html>

