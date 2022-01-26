<?php
if(!defined('unlock_includes')) {
 http_response_code(404);
 include('404.php'); // provide your own HTML for the error page
 die();
}
?>        

         <div id="header">

            <div class="row" id="nav_bar">
                <div class="section" id="nav_logo">
                    <a href="/">
                     <img id="logo_desktop" src="img/header/logo.png" alt="logo">
                     <img id="logo_mobile" src="img/header/logo_mobile.png" alt="logo">
                    </a>
                </div>
            </div>
        </div>
            
        <?php header_placeholder_display();?>
