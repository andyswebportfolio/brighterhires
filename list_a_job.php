<?php 
session_start();
define('unlock_includes', TRUE);
include 'functions.php';
include 'ip_security_lockout.php';

if(!isset($_SESSION['logged_in'])) {
    $_SESSION['list_a_job_not_logged_in'] = 1;
    push_back_instant('popup_page.php');
}

?>

<!doctype html>
<html>
    <?php require 'head_tag.php';?>
    <body>
        
        <?php include 'header.php';?>
        <?php include_error_reporting(); ?>
        <div class="content" id="list_a_job">
            
            <div class="form_container">
                <form id="list_job_form" action="submit/list_a_job.php" method="post" enctype="multipart/form-data">
                    <h1>List a job</h1>
                 
                    <div class="top_box">
                     <p>Please fill in all of the boxes.</p>
                    </div>
                    <br>
                    
                    <p>Job Title:</p>
                    <input type="text" name="job_title" maxlength="60"  autofocus ><br><br>
                    
                    Job Description: (Max 500 words)
                    <textarea id="job_description_textarea" name="job_description" form="list_job_form" ></textarea><br><br>  
                    
                    <p>Company Name:</p>
                    <input type="text" name="company_name" maxlength="40"  autofocus ><br><br>
                    
                    Contact Email:
                    <input type="text" name="contact_email" maxlength="350" ><br><br>
                    
                    Contact Phone:
                    <input type="text" name="contact_phone" maxlength="25" ><br><br>
                    
                    Further Contact Details: (Max 250 Words, Optional*)
                    <textarea id="contact_details_textarea" name="further_contact_details" form="list_job_form" placeholder="(*Optional. For example: Skype name, WhatsApp name, Social Media links.)" onchange="checkWordLen500(this);"></textarea><br><br>
                   
                    <p>Job Location:</p>
                    <input type="text" name="job_location" placeholder="Town, City, or Village" maxlength="60"  autofocus><br><br>
                    <p>Job Postcode:</p>
                    <input type="text" name="job_postcode" maxlength="12"  autofocus><br><br>
                    
                    <p>Working Hours:</p>
                    <div class="form_container_item">
                     <br>
                        <p>Full Time</p><br>
                          <input type="radio" checked="checked" name="working_hours" value="full_time">
                        <br><br>
                        Part Time
                       <br>
                          <input type="radio" name="working_hours" value="part_time">
                        <br><br>
                        Zero Hours
                       <br>
                          <input type="radio" name="working_hours" value="zero_hours">
                     <br><br>
                    </div>  
                    <br>
                    
                    Job Category:
                        <div class="custom-select" style="max-width:200px; position:relative; left:calc(50% - 100px); font-size:0.7em;">
                            <select name="job_cat_1" >
                                <option value=""selected hidden></option>
                                <?php select_job_categories();?>
                            </select>
                        </div>
                        <br>
                       
                    <br><br>

                    <input class="button1" type="submit" value="Submit">
                    
                </form>
            </div>
            
            
            
            
            
        </div>
        
        <?php include 'footer.php'?>
        <?php include 'functions_js.php'?>
        
    </body>
</html>