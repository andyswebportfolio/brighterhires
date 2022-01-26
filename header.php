<?php
if(!defined('unlock_includes')) {
 http_response_code(404);
 include('404.php'); // provide your own HTML for the error page
 die();
}
?>

       <div id="header">
        <?php cookie_login_check();?> 
            <div class="row" id="nav_bar">
                <div class="section" id="nav_logo">
                    <a href="/">
                     <img id="logo_desktop" src="img/header/logo.png" alt="logo">
                     <img id="logo_mobile" src="img/header/logo_mobile.png" alt="logo">
                    </a>

                </div>
               
                <div class="section" id="nav_links">
                    <ul>
                        <a href="list_a_job.php"><li class="button2">List a Job</li></a>
                        <a href="search.php"><li class="button1">Latest Jobs</li></a>

                    </ul>
                </div>
                <div class="section" id="nav_user">
                    <?php id_nav_user();?>
                </div>
                <div class="section" id="nav_icons">
                        <img id="search_icon" src="img/header/magnifying-glass.png" onclick="toggle_search_bar();" alt="search button"/>
                        <img id="menu_icon" src="img/header/burger_icon.png" onclick="toggle_menu_bar();" alt="menu button"/>
                </div>
            </div>
            
            <!--only visible when buttons are clicked-->
            <div id="search_bar" style="height: 0px;">
                <form action="search.php" onsubmit="">
                    <input id="dropdown_search_bar" type="text" name="search" placeholder="Search Jobs..." maxlength="75" style="display: none; height: 0px;">
                        <button id="dropdown_search_button" type="submit" style="display: none; height: 0px; opacity: 0;">Search</button>
                        <div id="button_cover">
                        </div>
                </form>
            </div>
            
            <div id="menu_dropdown">
               
                <h2></h2>
                <span></span>
               <ul><li style="font-size:1.5em"><a href="contact_us.php">How can I help?</a></li>
                    <br><br>
                    <li><?php dropdown_bar_top();?></li>
                    <br>
                    <li><a href="search.php">Latest Jobs</a></li>
                    <li><a href="list_a_job.php">List A Job</a></li> 
                    <li><a onclick="toggle_search_bar();">Search Jobs</a></li>
                    <br>
                    <?php login_switch_items();?>
                </ul>
            </div>
        </div>
            
        <?php header_placeholder_display();?>
