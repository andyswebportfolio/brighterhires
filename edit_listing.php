<?php 
session_start();
define('unlock_includes', TRUE);
include 'functions.php';
include 'ip_security_lockout.php';
//Security


//If a is not set or blank


//If a user is not logged in

if(!isset($_SESSION['logged_in'])) {
    $_SESSION['list_a_job_not_logged_in'] = 1;
    push_back_instant('../popup_page.php');
    exit();
}

//If unique url is not set

if (!isset($_SESSION['unique_url'])) {
 //unique url does not have username match in db
 //listing does not exist.
 $_SESSION['link_invalid_2'] = 1;
 push_back_instant('../popup_page.php');
 exit();
}

//If a is not in the database at all

$listing_username = pdo_return("SELECT `username` FROM `listed_jobs` WHERE `page_link` = '".$_SESSION['unique_url']."' ");

if (empty($listing_username)) {
 //unique url does not have username match in db
 //listing does not exist.
 $_SESSION['link_invalid_2'] = 1;
 push_back_instant('../popup_page.php');
 exit();
}

//If the user is logged in, but it's the wrong user

$listing_username = pdo_return("SELECT `username` FROM `listed_jobs` WHERE `page_link` = '".$_SESSION['unique_url']."' ")[0];

if ($listing_username !== $_SESSION['username']) {
 $_SESSION['wrong_account'] = 1;
 push_back_instant('../popup_page.php');
 exit();
}

?>

<!doctype html>
<html>
    <?php require 'head_tag.php';?>
    <body>
        
        <?php include 'header.php';?>
        <?php include_error_reporting(); ?>
        <?php $arr = get_job_listing_details($_SESSION['unique_url']);
        ?>
        <div class="content" id="list_a_job">
            
            <div class="form_container">
                <form id="list_job_form" action="submit/edit_listing.php" method="post" enctype="multipart/form-data">
                    <h1>Edit your listing</h1>
                    
                    <p>Job Title:</p>
                    <input type="text" name="job_title" maxlength="60"  autofocus  value="<?php echo $arr[0]; ?>"><br><br>
                    
                    Job Description: (Max 500 words)
                    <textarea id="job_description_textarea" name="job_description" form="list_job_form" ><?php echo $arr[1];?></textarea><br><br>  
                    
                    <p>Company Name:</p>
                    <input type="text" name="company_name" maxlength="40" value="<?php echo $arr[2]; ?>"  autofocus><br><br>

                    
                    <!--Company Logo:<br>(Min 300x300px)
                    <div class="form_input">
                        <div class="choose_file">
                            <label for="file" class="button glow">Choose a file</label>
                            <input type='file' id="file" onchange="readURL(this);" id="upload-photo" class="inputfile" name="company_logo" />
                        </div>
                        <div class="uploaded_image">
                            <img id="image_upload_box" src="/img/forms/logo_blank.png" alt="company_logo"/>
                        </div>
                    </div>            
                    <br><br>-->
                    
                    Contact Email:
                    <input type="text" name="contact_email" maxlength="350" value="<?php echo $arr[3]; ?>" ><br><br>
                    
                    Contact Phone:
                    <input type="text" name="contact_phone" maxlength="25" value="<?php echo $arr[4]; ?>" ><br><br>
                    
                    Further Contact Details: (Max 250 Words)
                    <textarea id="contact_details_textarea" name="further_contact_details" form="list_job_form" placeholder="(Optional. For example: Skype name, WhatsApp name, Social Media links.)" onchange="checkWordLen500(this);"><?php echo $arr[5];?></textarea><br><br>
                   
                    <p>Job Location:</p>
                    <input type="text" name="job_location" placeholder="Town, City, or Village" value="<?php echo $arr[6]; ?>" maxlength="60"  autofocus><br><br>
                    <p>Job Postcode:</p>
                    <input type="text" name="job_postcode" maxlength="12" value="<?php echo $arr[7]; ?>"  autofocus><br><br>
                    
                    <p>Working Hours:</p>

                    <div class="form_container_item">
                        <p>Full Time (35 Hours + each week)</p>
                        
                          <input type="radio" <?php if ($arr[8] == 'full_time') { echo 'checked="checked"'; }?> name="working_hours" value="full_time">
                        <br>
                        Part Time (Under 35 Hours weekly)
                          <input type="radio" <?php if ($arr[8] == 'part_time') { echo 'checked="checked"'; }?> name="working_hours" value="part_time">
                        <br>
                        Zero Hours (No guaranteed hours weekly)
                          <input type="radio" <?php if ($arr[8] == 'zero_hours') { echo 'checked="checked"'; }?> name="working_hours" value="zero_hours">
                    </div>  
                    <br>
                 
                    Job Category:
                        <div class="custom-select" style="max-width:200px; position:relative; left:calc(50% - 100px); font-size:0.7em;">
                            <select name="job_cat_1" >
                             <option value="<?php echo get_existing_category_x('1');?>" selected><?php echo get_existing_category_x('1');?></option>
                             <?php select_job_categories(get_existing_category_x('1'));?>
                            </select>
                        </div>
                        
                       
                    <br><br>

                    <input class="button1" type="submit" value="Submit">
                    
                </form>
            </div>
            
            
            
            
            
        </div>
        
        <?php include 'footer.php'?>
        <?php include 'functions_js.php'?>
        
    </body>
</html>