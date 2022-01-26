<?php
if(!defined('unlock_includes')) {
 http_response_code(404);
 include('404.php'); // provide your own HTML for the error page
 die();
}

?> 

<div id="footer">
    <div class="row">
        <div class="footer_column">
            <ul>
                <li><a href="search.php?search=''">Find A Job</a></li>
                <li><a href="list_a_job.php">List A Job</a></li> 
                <li><a href="cookies.php">Cookies Info</a></li>
                <li><a href="contact_us.php">Get in Touch</a></li>

            </ul>
        </div>
        <div class="footer_column">
            <ul>
                <li><a href="my_account.php">My Account</a></li>
                <li><a href="ts_and_cs.php">Terms of Use</a></li>
                <li><a href="privacy_policy.php">Privacy Policy</a></li>
                <li><a href="credits.php">Credits</a></li>
            </ul>
        </div>
        <div class="footer_column" id="footer_column_4">
           <br>
           <!--<a href="report_a_problem.php">Report a problem</a>-->
           
            <br><br>
            <p>This site &copy; Brighter Hires <?php echo date("Y");?><br> All Rights Reserved</p>
        </div>
    </div>
   
    <div class="row" id="footer_bottom">
    </div>
</div>