<?php 


if(!defined('unlock_includes')) {
 define('unlock_includes', TRUE);
}


foreach (get_included_files() as $item ) {        
    $string = 'functions.php';
    $string2 = 'settings.php';
    if (strpos($item, $string) == false) {
        include_once 'functions.php';
    }
    unset($string);
    if (strpos($item, $string2) == false) {
        include_once 'settings.php';
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
           <h1>Error</h1>
          <div class="underline2"></div>
          </div>
             
          <div class="content_inner_1">
              
            <p class="sub_header_1">You have been blocked.</p>
            <br><br>
            <p>Your IP Address has tried to access the site too many times, too quickly. You may need to speak to your network administrator, as another computer on your network could be causing the problem.</p>
            <br><br>
            <p>Alternatively, please contact us at thejobswhale@gmail.com to resolve the issue, quoting your ip address. <br><br>You can find this information by asking a search engine, which will tell you how to access it using your browser.</p>

          </div>
            
        </div>
        </div>
        
        
        <?php include 'footer_plain.php'?>
        <?php include 'functions_js.php'?> 
        
    </body>
</html>

