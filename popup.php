


<!-- This file is either included directly, or by a function. An error does not have to be set. -->
<?php



foreach (get_included_files() as $item ) {        
    $string = 'functions.php';
    if (strpos($item, $string) == false) {
     if(!defined('unlock_includes')) {
      define('unlock_includes', TRUE);
     }
     include_once 'functions.php';
    }
    unset($string);
}

//if none of the other things are set push a 404 out
//idk






/*if ( !isset($_SESSION['error']) && !isset($_SESSION['error_type']) ) {
    push_back_instant('/index.php');
}*/

//if any of the existing session vars are set

//spoof it


?>

<div id="popup">
    <div id="popup_background">
</div>
    
    <div id="popup_center">
        
        <div id="popup_box">
            <?php
            
            
            
            /*!!!! Popup MUST include at least 2 nodes due to javascript.
            Make a blank one if you have to.*/
            
            
            
            //max 2 lines or 60 chars for messages
            
                if (isset($_SESSION['error'])) {
                 
                 
                    echo '<p>There has been a problem.<br></p>
                    <br>';
                 
                    get_error_message();
                 
                    //Put in here the url of where you want the button to redirect to
                 
                    //Accepts a 1 to push back only 1 page
                 
                    // box type is set in get_error_message function at message level
                    //functions.php / [search] get_error_message
                 
                    //Give box type a default
                    
                    if(!isset($_SESSION['box_type'])) {
                     $_SESSION['box_type'] = '';
                    }
                    
                    button_box_redirect($_SESSION['box_type']);
                    unset($_SESSION['box_type']);

                 
                     unset($_SESSION['error']);
                }
            
            //Custom boxes, same rules apply, check each individually
            //! CAN ONLY DONE INSIDE POPUP PAGE
            
                if (isset($_SESSION['first_login'])) {
                    echo'<h1 class="popup_h1">Welcome!</h1>';
                    echo'<br>';
                    echo '<p>Your account has been verified!<br></p>';
                    
                    
                    
                    echo'<br><br>';
                    
                    echo '<div onclick="redirect_my_account()" class="button1" id="popup_button">Continue </div>';
                    
                   
                    
                    unset($_SESSION['email_verification_url']);
                    unset($_SESSION['first_login']);
                    
                    
                }

                if (isset($_SESSION['logged_out'])) {
                    echo'<h1 class="popup_h1">Goodbye</h1>';
                    echo'<br>';
                    echo '<p>Thank you for using Brighter Hires!<br></p>';
                    
                    echo '<p id="popup_error_message">You have now logged out of the site.</p><br><br>';
                    
                    echo '<div onclick="popup_fadeout_redirect()" class="button1" id="popup_button">Continue</div>';
                    unset($_SESSION['logged_out']);
                }
                if (isset($_SESSION['list_a_job_not_logged_in'])) {
                    unset($_SESSION['list_a_job_not_logged_in']);
                    echo'<h1 class="popup_h1">Welcome!</h1><br>';

                    echo '<p id="popup_error_message">You need to log in or create<br>an account to use the site.</p>';
                    
                    echo'<br><br>';
                    
                    echo '<div onclick="redirect_login()" class="button1" id="popup_button">Ok</div>';

                }
                if (isset($_SESSION['password_changed'])) {
                    unset($_SESSION['password_changed']);
                    echo'<h1 class="popup_h1">Brighter Hires</h1>';
                    echo'<br>';
                    
                    echo '<p id="popup_error_message">Your password has been updated.</p>';
                    
                    echo'<br><br>';
                    
                    echo '<div onclick="redirect_my_account();" class="button1" id="popup_button">Ok</div>';

                }
                if (isset($_SESSION['email_link_invalid'])) {
                    unset($_SESSION['email_link_invalid']);
                    echo'<h1 class="popup_h1">Brighter Hires</h1>';
                    echo'<br>';
                    
                    echo '<p id="popup_error_message">Your account is already verified. You can log in using your username or email, and password.';
                    
                    echo'<br><br>';
                    
                    echo '<div onclick="redirect_login();" class="button1" id="popup_button">Ok</div>';

                }

                if (isset($_SESSION['payment_fail'])) {
                    unset($_SESSION['payment_fail']);
                    echo'<h1 class="popup_h1">Brighter Hires</h1>';
                    echo'<br>';
                
                    

                    
                    if (isset($_SESSION['logged_in'])) {
                        
                        echo '<p id="popup_error_message_payment">There has been a problem in your browser.<br><br> 

                        You can visit the my account page to work on your listing.

                        ';

                        echo'<br><br>';
                        
                            echo '<div onclick="redirect_my_account();" class="button1" id="popup_button">My Account</div>';
                    } else {
                        
                        echo '<p id="popup_error_message_payment">There has been a problem in your browser.<br><br> 

                        You can visit the my account page to complete your listing.

                        ';

                        echo'<br><br>';
                        
                        echo '<div onclick="popup_fadeout_redirect();" class="button1" id="popup_button">Ok</div>';
                    }
                }
            
                if (isset($_SESSION['listing_deleted_success'])) {
                    unset($_SESSION['listing_deleted_success']);
                    
                    echo'<h1 class="popup_h1">Brighter Hires</h1>';
                    echo'<br>';
                    
                    echo '<p id="popup_error_message">Your listing was successfully deleted,<br> and any charges for this listing have been cancelled.';
                    
                    echo'<br><br>';
                    
                    echo '<div onclick="redirect_my_account_login_2();" class="button1" id="popup_button">Ok</div>';
                }
            
                if (isset($_SESSION['listing_unfinished'])) {
                    unset($_SESSION['listing_unfinished']);
                    
                    echo'<h1 class="popup_h1">Brighter Hires</h1>';
                    echo'<br>';
                    
                    echo '<p id="popup_error_message">You have a listing in progress, which has been saved to your account. To continue making it, select it from the listed jobs on this page.';
                    
                    echo'<br><br>';
                    
                    echo '<div onclick="redirect_my_account_login_2();" class="button1" id="popup_button">Ok</div>';
                }
         
                if (isset($_SESSION['link_invalid_2'])) {
                    unset($_SESSION['link_invalid_2']);
                    
                    echo'<h1 class="popup_h1">Brighter Hires</h1>';
                    echo'<br>';
                    
                    echo '<p id="popup_error_message">This page was not found, or has been removed.';
                    
                    echo'<br><br>';
                    
                    echo '<div onclick="popup_fadeout_redirect();" class="button1" id="popup_button">Ok</div>';
                }
                 if (isset($_SESSION['wrong_account'])) {
                    unset($_SESSION['wrong_account']);
                    
                    echo'<h1 class="popup_h1">Brighter Hires</h1>';
                    echo'<br>';
                    
                    echo '<p id="popup_error_message">This page can only be accessed when logged in as the correct user.';
                    
                    echo'<br><br>';
                    
                    echo '<div onclick="popup_fadeout_redirect();" class="button1" id="popup_button">Ok</div>';
                }
                  if (isset($_SESSION['no_edit_selected'])) {
                    unset($_SESSION['no_edit_selected']);
                    
                    echo'<h1 class="popup_h1">Brighter Hires</h1>';
                    echo'<br>';
                    
                    echo '<p id="popup_error_message">You need to select at least one box<br>to make an edit on your listing.';
                    
                    echo'<br><br>';
                    
                    echo '<div onclick="redirect_my_account();" class="button1" id="popup_button">Ok</div>';
                }
         
                   if (isset($_SESSION['listing_updated'])) {
                    unset($_SESSION['listing_updated']);
                    
                    echo'<h1 class="popup_h1">Brighter Hires</h1>';
                    echo'<br>';
                    
                    echo '<p id="popup_error_message">Your listing has been updated.';
                    
                    echo'<br><br><br>';
                    
                    echo '<div onclick="redirect_my_account();" class="button1" id="popup_button">Continue</div>';
                }
         
                if (isset($_SESSION['save_not_logged_in'])) {
                    unset($_SESSION['save_not_logged_in']);
                    echo'<h1 class="popup_h1">Welcome!</h1><br>';

                    echo '<p id="popup_error_message">You need to log in or create<br>an account to save jobs.</p>';
                    
                    echo'<br><br>';
                    
                    echo '<div onclick="popup_fadeout_redirect()" class="button1" id="popup_button">Ok</div>';
                }
         
                if (isset($_SESSION['already_saved'])) {
                    unset($_SESSION['already_saved']);
                    echo'<h1 class="popup_h1">Error</h1><br>';

                    echo '<p id="popup_error_message">You have already saved this job.</p>';
                    
                    echo'<br><br>';
                    
                    echo '<div onclick="goBack2()" class="button1" id="popup_button">Ok</div>';
                }
                
                if (isset($_SESSION['saved_jobs_updated'])) {
                    unset($_SESSION['saved_jobs_updated']);
                    echo'<h1 class="popup_h1">Success</h1><br>';

                    echo '<p id="popup_error_message">This job has been saved to your account.</p>';
                    
                    echo'<br><br>';
                    
                    echo '<div onclick="goBack2()" class="button1" id="popup_button">Ok</div>';
                }
                if (isset($_SESSION['saved_job_removed'])) {
                    unset($_SESSION['saved_job_removed']);
                    echo'<h1 class="popup_h1">Success</h1><br>';

                    echo '<p id="popup_error_message">You have removed one of your saved jobs.</p>';
                    
                    echo'<br><br>';
                    
                    echo '<div onclick="redirect_my_account()" class="button1" id="popup_button">Ok</div>';
                }
                if (isset($_SESSION['saved_job_not_found'])) {
                    unset($_SESSION['saved_job_not_found']);
                    echo'<h1 class="popup_h1">Success</h1><br>';

                    echo '<p id="popup_error_message">You have removed one of your saved jobs.</p>';
                    
                    echo'<br><br>';
                    
                    echo '<div onclick="redirect_my_account()" class="button1" id="popup_button">Ok</div>';
                } 
                if (isset($_SESSION['free_pass'])) {
                    unset($_SESSION['free_pass']);
                    echo'<h1 class="popup_h1">Success</h1><br>';

                    echo '<p id="popup_error_message">Your job has been listed!</p>';
                    
                    echo'<br><br>';
                    
                    echo '<div onclick="redirect_my_account()" class="button1" id="popup_button">Ok</div>';
                }
                if (isset($_SESSION['create_account'])) {
                    unset($_SESSION['create_account']);
                    echo'<h1 class="popup_h1">Information</h1><br>';

                    echo '<p id="popup_error_message">To report a listing, you need to create an account, or log in.</p>';
                    
                    echo'<br><br>';
                    
                    echo '<div onclick="redirect_create_account()" class="button1" id="popup_button">Continue</div>';
                } 
                if (isset($_SESSION['already_reported'])) {
                    unset($_SESSION['already_reported']);
                    $_SESSION['unlock_send_report'] = 1;
                    echo'<h1 class="popup_h1">Information</h1><br>';

                    echo '<p id="popup_error_message">Thank you for reporting this listing. You can explain your decision to report the listing below. Your valuable information is helping to keep the site safe.</p>
                    <br><br>
                    
                    <textarea name="comment" form="report_send_form" id="report_send_form_textarea" placeholder="Enter text here... (Max 1024 Characters)" maxlength="1024"></textarea>
                    
                    <form action="/emails/send_email_report.php" id="report_send_form" method="post" onsubmit="popup_button_submit.disabled=true;">
                       <input type="submit" value="Submit" id="popup_button_submit">
                     </form>
                     



                    
                    ';
                    
                    echo'<br><br>';
                    
                    echo '<div onclick="window.history.back()" class="button1" id="popup_button">Back</div>';
                } 
                if (isset($_SESSION['reported_message_emailled'])) {
                    unset($_SESSION['reported_message_emailled']);
                   
                    echo'<h1 class="popup_h1">Report Sent</h1><br>';

                    echo '<p id="popup_error_message">Your report has been sent successfully.</p>
                    <br><br>';
                    
                    echo '<div onclick="popup_fadeout_redirect()" class="button1" id="popup_button">Ok</div>';
                } 
                if (isset($_SESSION['logged_in_report_1'])) {
                    unset($_SESSION['logged_in_report_1']);
                   
                    echo'<h1 class="popup_h1">Report Sent</h1><br>';

                    echo '<p id="popup_error_message">Your report has been sent successfully.</p>
                    <br><br>';
                    
                    echo '<div onclick="popup_fadeout_redirect()" class="button1" id="popup_button">Ok</div>';
                }
                if (isset($_SESSION['ip_report_made'])) {
                    unset($_SESSION['ip_report_made']);
                   
                    echo'<h1 class="popup_h1">Report Sent</h1><br>';

                    echo '<p id="popup_error_message">Your report has been sent successfully. The safety of our users is of the upmost importance, and we have a solid system in place to ensure your report is counted and acted upon safely.<br><br>We take every report seriously and will deal with any problems on the site in the best way possible.</p>
                    <br><br>';
                    
                    echo '<div onclick="popup_fadeout_redirect()" class="button1" id="popup_button">Ok</div>';
                }
                if (isset($_SESSION['user_not_found'])) {
                    unset($_SESSION['user_not_found']);
                   
                    echo'<h1 class="popup_h1">User Not Found</h1><br>';

                    echo '<p id="popup_error_message">We could not find that account.</p>
                    <br><br>';
                    
                    echo '<div onclick="reset_password_redirect()" class="button1" id="popup_button">Ok</div>';
                }
                if (isset($_SESSION['email_sent_2'])) {
                    unset($_SESSION['email_sent_2']);
                   
                   echo'<h1 class="popup_h1">Email Sent</h1>';
            echo'<br>';
            echo '<p>You need to check your email inbox.<br><br></p>';
                    
            echo '<p id="popup_error_message">Your email may take a little time to arrive.<br>You may need to check your spam folder.</p>';
            echo '<br><br>';
                    
                    
            echo '<div onclick="popup_fadeout_redirect()" class="button1" id="popup_button">Continue </div>';
                }
           
             if (isset($_SESSION['usr_and_pass_match_reset_password'])) {
                unset($_SESSION['usr_and_pass_match_reset_password']);
                    echo'<h1 class="popup_h1">Error</h1>';
                    echo'<br>';
                    echo '<p>Your username and password cannot be the same.<br></p>';

                    echo'<br><br>';
                    
                    echo '<div onclick="goBack1()" class="button1" id="popup_button">Ok</div>';
  
                }
           if (isset($_SESSION['usr_and_pass_match_reset_password'])) {
                unset($_SESSION['usr_and_pass_match_reset_password']);
                    echo'<h1 class="popup_h1">Error</h1>';
                    echo'<br>';
                    echo '<p>Your username and password cannot be the same.<br></p>';

                    echo'<br><br>';
                    
                    echo '<div onclick="goBack1()" class="button1" id="popup_button">Ok</div>';
  
                }
           if (isset($_SESSION['length_check_password'])) {
                unset($_SESSION['length_check_password']);
                    echo'<h1 class="popup_h1">Error</h1>';
                    echo'<br>';
                    echo '<p>Your password is too long. Try something a little shorter.<br></p>';

                    echo'<br><br>';
                    
                    echo '<div onclick="goBack1()" class="button1" id="popup_button">Ok</div>';
  
                }
           
           if (isset($_SESSION['string_type_fail_change_password'])) {
                unset($_SESSION['string_type_fail_change_password']);
                    echo'<h1 class="popup_h1">Error</h1>';
                    echo'<br>';
                    echo '<p>Your password contains invalid characters.<br></p>';

                    echo'<br><br>';
                    
                    echo '<div onclick="goBack1()" class="button1" id="popup_button">Ok</div>';
  
                }
           if (isset($_SESSION['password_matches_old_password'])) {
                unset($_SESSION['password_matches_old_password']);
                    echo '<h1 class="popup_h1">Error</h1>';
                    echo '<br>';
                    echo '<p>Your new password cannot be the same as your old password.<br></p>';

                    echo'<br><br>';
                    
                    echo '<div onclick="goBack1()" class="button1" id="popup_button">Ok</div>';
  
                }
           if (isset($_SESSION['key_detail_matches_new_password'])) {
                unset($_SESSION['key_detail_matches_new_password']);
                    echo '<h1 class="popup_h1">Error</h1>';
                    echo '<br>';
                    echo '<p>Your password cannot match one of your other details, such as your name or email address.<br></p>';

                    echo'<br><br>';
                    
                    echo '<div onclick="goBack1()" class="button1" id="popup_button">Ok</div>';
  
                }
           if (isset($_SESSION['username_not_found'])) {
                unset($_SESSION['username_not_found']);
                    echo '<h1 class="popup_h1">Error</h1>';
                    echo '<br>';
                    echo "<p>The username can't be found.<br></p>";

                    echo'<br><br>';
                    
                    echo '<div onclick="goBack1()" class="button1" id="popup_button">Ok</div>';
  
                }
           if (isset($_SESSION['password_reset_hash_not_found'])) {
                unset($_SESSION['password_reset_hash_not_found']);
                    echo '<h1 class="popup_h1">Page Not Found</h1>';
                    echo '<br>';
                    echo "<p>For better security, you need to reset your password again using the website.<br></p>";

                    echo'<br><br>';
                    
                    echo '<div onclick="redirect_reset_password()" class="button1" id="popup_button">Ok</div>';
  
                }
           


            ?>
        </div>
    </div>
</div>

<!--Custom popup box sizes-->

<?php
if (isset($_SESSION['email_sent'])) {
    echo '<div id="popup_center">';
    echo '<div id="popup_box_large">';
        
        if (isset($_SESSION['email_sent'])) {
            echo'<h1 class="popup_h1">Email Sent</h1>';
            echo'<br>';
            echo '<p>You need to check your email inbox.<br><br></p>';
                    
            echo '<p id="popup_error_message">Your email may take a little time to arrive.<br>You may need to check your spam folder.</p>';
            echo '<br><br>';
                    
                    
            echo '<div onclick="popup_fadeout_redirect()" class="button1" id="popup_button">Continue</div>';
                    
            unset($_SESSION['email_sent']);
                    
        }
        
    echo'</div>';
echo'</div>';
}

?>





                