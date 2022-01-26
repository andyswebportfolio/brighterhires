<?php

//Set pdo session vars
include 'settings.php';

if(!defined('unlock_includes')) {
 http_response_code(404);
 include('404.php'); // provide your own HTML for the error page
 die();
}

if (isset($_SESSION['maintenance'])) {
 echo '<meta http-equiv="refresh" content="0;url=/maintenance.php">';   
}

// include classes 

foreach (get_included_files() as $item ) {        
   $string = 'functions.php';
    if (strpos($item, $string) == false) {
        include_once 'functions.php';
    }
    unset($string);
}

function pdo_return($pdo_stmt) {
    
    $servername = $_SESSION['pdo_servername'];
    $dbname = $_SESSION['pdo_database'];
    $username = $_SESSION['pdo_username'];
    $password = $_SESSION['pdo_password'];
    
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sth = $conn->prepare("".$pdo_stmt.""); 
    $sth->execute();

    // Fetch all of the remaining rows in the result set
    $result = $sth->fetchAll();
    
    //get the amount of results
    $result_amount = count($result);
    $results = array();
    
    for ( $i=0; $i < $result_amount; $i++) {
        array_push($results,$result[$i][0]);
    }
    
    return $results;
        
}

function header_placeholder_display() {
    $page = $_SERVER['PHP_SELF'];
    if ($page == '/index.php') {
        return 0;
    } else {
        echo '<div id="header_placeholder">
            </div>';
    }
}


function get_real_ip(){
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    //return $ip;
    echo $ip;
}

function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function get_real_ip_return(){
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    //return $ip;
    return $ip;
}

function hash_string($x) {
    $hash_string = password_hash($x, PASSWORD_DEFAULT);
    return $hash_string;
}

function return_username() {
    require_once ('database.php');
    try {
        echo '<pre>';
        $results = $db->query('select * from users');
    }
    catch(Exception $e) {
        echo $e->getMessage();
        die();
    }
$items = $results->fetchAll(PDO::FETCH_ASSOC);
    foreach ($items as $item) {
        echo $item["username"];
        echo '<br>';
    }
}

function test_htmlentities() {
    //force test mode on
    $test_mode = 1; 
    if ($test_mode !=NULL) {
    $test_string = "<script>alert('injection test')</script>";
    echo '<h2>Test Script Protection</h2>';
    echo '<p>If script shows, test was successful, If script runs, it was not</p>';
    $test_string = htmlentities($test_string, ENT_QUOTES, 'UTF-8');
    echo $test_string;
    }
}

function include_error_reporting() {
    //custom messages inside a popup are echoed here
 

    if (isset($_SESSION['error'])) {
        include 'popup.php';
        unset($_SESSION["error"]);
        if (isset($_SESSION["error_description"])) {
         unset($_SESSION["error_description"]);
        }
        if (isset($_SESSION["error_type"])) {
         unset($_SESSION["error_type"]);
        }
     exit();
    }
    
    if (isset($_SESSION['login_required_message'])) {
     
        
        echo '<div id="popup">
                <div id="popup_background">
            </div>

                <div id="popup_center">
                    <div id="popup_box">
                        <h1 class="popup_h1">Brighter Hires</h1>
                        <br>
                        <p>Your need to log in to view this page.<br></p>

                        <br><br>

                        <div onclick="redirect_login()" class="button1" id="popup_button">Continue</div>
                    </div>
                </div>
            ';
        
        unset($_SESSION['login_required_message']);
    }  
  //Do not use this make a fresh one
    if (isset($_SESSION['user_message_custom'])) {
     
           echo '<div id="popup">
                   <div id="popup_background">
               </div>

                   <div id="popup_center">
                       <div id="popup_box">
                           <h1 class="popup_h1">Brighter Hires</h1>
                           <br>
                           <p>'.$_SESSION['user_message'].'<br></p>

                           <br><br>

                           <div onclick="redirect_login()" class="button1" id="popup_button">Continue</div>
                       </div>
                   </div>
               ';

           unset($_SESSION['user_message_custom']);
       }
 
      if (isset($_SESSION['saved_job_not_found'])) {
     
        
        echo '<div id="popup">
                <div id="popup_background">
            </div>

                <div id="popup_center">
                    <div id="popup_box">
                        <h1 class="popup_h1">Brighter Hires</h1>
                        <br>
                        <p>This saved job was not found on your account.</p>

                        <br><br>

                        <div onclick="redirect_my_account()" class="button1" id="popup_button">Continue</div>
                    </div>
                </div>
            ';
        
        unset($_SESSION['saved_job_not_found']);
    }  
 if (isset($_SESSION['saved_job_removed'])) {
     
        
        echo '<div id="popup">
                <div id="popup_background">
            </div>

                <div id="popup_center">
                    <div id="popup_box">
                        <h1 class="popup_h1">Job Removed</h1>
                        <br>
                        <p>This job was removed from your saved jobs.</p>

                        <br><br>

                        <div onclick="redirect_my_account()" class="button1" id="popup_button">Continue</div>
                    </div>
                </div>
            ';
        
        unset($_SESSION['saved_job_removed']);
    }
 
  if (isset($_SESSION['job_already_reported'])) {
     
        
        echo '<div id="popup">
                <div id="popup_background">
            </div>

                <div id="popup_center">
                    <div id="popup_box">
                        <h1 class="popup_h1">Job Reported</h1>
                        <br>
                        <p>Thank you for reporting this listing.<br>If you need to add further information, please use the <a href="/contact_us.php" style="color:blue; text-decoration: underline">contact us</a> page.</p>

                        <br><br>

                        <div onclick="goBack1()" class="button1" id="popup_button">Continue</div>
                    </div>
                </div>
            ';
        
        unset($_SESSION['job_already_reported']);
    }
 
 
   
}



//come back to this tommorow

function send_verification_email() {
    // the message
    $msg = "First line of text\nSecond line of text";

    // use wordwrap() if lines are longer than 70 characters
    $msg = wordwrap($msg,70);

    // send email
    mail("andrew.wells@hotmail.co.uk","My subject",$msg);
}

//required for pdo functions to work

class TableRows extends RecursiveIteratorIterator { 
        function __construct($it) { 
            parent::__construct($it, self::LEAVES_ONLY); 
        }

        function current() {
            return parent::current();
        }
    }


function return_user_detail($user_detail) {
    
    //$user detail is the name of the mysql row you want to echo
    //Requires Session at top of page

    $servername = "localhost";
    $username = $_SESSION['pdo_username'];
    $password = $_SESSION['pdo_password'];
    $dbname = $_SESSION['pdo_database'];

    $session_username = $_SESSION['username'];

    $sql_statement = "SELECT $user_detail FROM users where username ='$session_username'";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare($sql_statement); 
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
        foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
            return $v;
        }
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
}

function check_users_detail_unique($detail,$user_entry) {
    
//return a 1 if the detail exists
//return null if it doesn't
 
 $data = pdo_return("SELECT `id` FROM `users` WHERE ".$detail." = '".$user_entry."' ");
 
 if (count($data) > 0) {
  return 1;
 } else {
  return null;
 }
 
}


function check_detail_unique_in_column ($id_column_name,$table,$column_name,$string) {
    
    $result = pdo_return("SELECT `".$id_column_name."` FROM ".$table." WHERE `".$column_name."`='".$string."' ");
    
    if (count($result) > 1) {
     return 1;
    } else {
     return 0;
    }
    
}

//create a view counter
function view_counter() {
    if (isset($_SESSION['counter'])) {
        return $_SESSION['counter'];
    }
}
    
function view_counter_add($add = 1) {
    if (isset($_SESSION['counter'])) {
        $_SESSION['counter'];
        $_SESSION['counter'] += $add;
        return $_SESSION['counter'];
    }
}
    
function set_view_counter($set) {
    $_SESSION['counter'] = $set;
}

function run_view_counter() {
    //Uses $_SESSION["attempt_limit"]
    
    if (!isset($_SESSION['counter'])) {
        $_SESSION['counter'] = 0;
    }
    
    

        //echo '<h1>View Counter</h1>';

    
    if (view_counter() < $_SESSION['attempt_limit']) {

    view_counter_add(1);
    } else {

            //echo 'Limit hit! Reset.<br>';

        set_view_counter(1);
    }

        //echo 'Counter = '.view_counter();

}



function button_box_redirect($param = '') {
 
 //Param 1 is go back 1 instead of 2
 
 //Set a url, or don't.
 //Without it, it does it's default potentially broken behavior
 
 //With it, you can tell the site where to go exactly
 
 if ($param =='update_listing_select.php') {
   //Button Box Code
 echo'<br><br>';
                     
 echo '<script>
 function clearMessage() {
 window.location = "/update_listing_select.php?a='.$_SESSION['unique_url'].'";
 }
 </script>
                     
 ';
                 
 echo '<div onclick="clearMessage();" class="button1" id="popup_button">Continue </div>';
 }
 
 if($param == 'image_processing.php') {
  //Button Box Code
 echo'<br><br>';
                     
 echo '<script>
 function clearMessage() {
 window.location = "/image_processing.php";
 }
 </script>
                     
 ';
                 
 echo '<div onclick="clearMessage();" class="button1" id="popup_button">Continue </div>';
 
 }
 
  if($param == 'edit_listing.php') {
  //Button Box Code
 echo'<br><br>';
                     
 echo '<script>
 function clearMessage() {
 window.location = "/edit_listing.php";
 }
 </script>
                     
 ';
                 
 echo '<div onclick="clearMessage();" class="button1" id="popup_button">Continue </div>';
 
 }
 
 
 
 //Go back 1 is 1
 if ($param == 1) {
   //Button Box Code
 echo'<br><br>';
                     
 echo '<script>
 function clearMessage() {
 window.history.go(-1);
 }
 </script>
                     
 ';
                 
 echo '<div onclick="clearMessage();" class="button1" id="popup_button">Continue </div>';
 
 }

 
 
 if ($param == '') {
    if(isset($_SESSION['custom_redirect'])) {
       if ($_SESSION['custom_redirect'] == '/reset_password.php') {
      unset ($_SESSION['custom_redirect']);
      echo'<br><br>';
      echo '<div onclick="jumpToPasswordReset()" class="button1" id="popup_button">Back</div>'; 
    } 
  } else {
  
    //Button Box Code
    echo'<br><br>';

    echo '<script>
    function clearMessage() {
    window.history.go(-2);
    }
    </script>

    ';

    echo '<div onclick="clearMessage();" class="button1" id="popup_button">Continue </div>';

    }
 }
}

function get_error_message() {
    
    if (isset($_SESSION['error_type'])) {
        echo '<p id="popup_error_message">';
        
        
        //MAX 60 CHARS for each popup_error_message
        
        if ($_SESSION['error_type'] == 'data_type') {
            echo '<p id="popup_error_message">The data type is invalid.</p>';
            echo '<br><br>'; 
        } else if ($_SESSION['error_type'] == 'password_too_short') {
            echo '<p id="popup_error_message">Your password is too short.<br>Use at least 8 characters.</p><br>';
            echo '<br>';
        } else if ($_SESSION['error_type'] == 'length_check') {
            echo '<p id="popup_error_message">One of the details was too long.</p>';
            echo '<br><br>';
        } else if ($_SESSION['error_type'] == 'allowed_characters_gender') {
            echo '<p id="popup_error_message">You made an invalid selection.</p>';
            echo '<br><br>'; 
        } else if ($_SESSION['error_type'] == 'allowed_characters_name') {
            echo '<p id="popup_error_message">Names can only contain letters and dashes.</p>';
            echo '<br><br>';
        } else if ($_SESSION['error_type'] == 'allowed_characters_username') {
            echo '<p id="popup_error_message">Your username can only use letters, <br>numbers, dashes and underscores.</p>';
            echo '<br>';
        } else if ($_SESSION['error_type'] == 'username_not_unique') {
            echo '<p id="popup_error_message">That username is already in use.</p>';
            echo '<br><br>'; 
        } else if ($_SESSION['error_type'] == 'name_match') {
            echo '<p id="popup_error_message">Username and password cannot be your name.</p>';
            echo '<br><br>'; 
        } else if ($_SESSION['error_type'] == 'login_invalid') {
            echo '<p id="popup_error_message">Your login details are not correct.</p>';
            echo '<br><br>'; 
        } else if ($_SESSION['error_type'] == 'username_and_password_match') {
            echo '<p id="popup_error_message">Your username and password cannot match.</p>';
            echo '<br><br>'; 
        } else if ($_SESSION['error_type'] == 'verify_account') {
            echo '<p id="popup_error_message">Your account is not verified.<br>';
            echo ' Check your email address and spam folder.</p>';
            echo '<br>';
        } else if ($_SESSION['error_type'] == 'invalid_image') {
            echo '<p id="popup_error_message">Image type is invalid.<br>';
            echo 'You need to use JPEG, GIF or PNG images.</p>';
            echo '<br>';
        } else if ($_SESSION['error_type'] == 'user_not_exist') {
            echo '<p id="popup_error_message">That user was not found.<br> Try checking your spelling.<br>';
        } else if ($_SESSION['error_type'] == 'password_match') {
            echo '<p id="popup_error_message">You cannot change your password <br>to the same password.<br>';
        } else if ($_SESSION['error_type'] == 'password_match_other') {
            echo '<p id="popup_error_message">You cannot use one of your other details<br> as your password.<br>';
        } else if ($_SESSION['error_type'] == 'image_file_size_over_limit') {
            echo '<p id="popup_error_message">The image file is too large.<br> The limit is 10mb. <br>';
        }  else if ($_SESSION['error_type'] == 'email_not_unique') {
            echo '<p id="popup_error_message">That email address is already registered.<br><br>
            If you have already signed up using that email address, please check your inbox and junk or spam folder to verify your account.<br><br>
            You can edit your account details once the account has been verified.
            ';
        }  else if ($_SESSION['error_type'] == 'image_height_too_small') {
            echo '<p id="popup_error_message">The Image is too small. At least 300px x 300px is required.<br>';
        }  else if ($_SESSION['error_type'] == 'image_width_too_small') {
            echo '<p id="popup_error_message">The Image is too small.<br>At least 300px x 300px is required.<br>';
        }   else if ($_SESSION['error_type'] == 'logo_not_uploaded') {
            echo '<p id="popup_error_message">You have not selected an image.<br>';
        } else if ($_SESSION['error_type'] == 'name_match_2') {
            echo '<p id="popup_error_message">Your password cannot be the same as any of your other details.</p>';
            echo '<br><br>'; 
        } else if ($_SESSION['error_type'] == 'length_check_name') {
            echo '<p id="popup_error_message">Part of your name, or username, is too long.</p>';
            echo '<br><br>';
        } else if ($_SESSION['error_type'] == 'length_check_email') {
            echo '<p id="popup_error_message">Your email address is too long.</p>';
            echo '<br><br>';
        } else if ($_SESSION['error_type'] == 'length_check_password') {
            echo '<p id="popup_error_message">Your password is too long.</p>';
            echo '<br><br>';
        } else if ($_SESSION['error_type'] == 'allowed_characters_email') {
            echo '<p id="popup_error_message">That email address is invalid. Please try again.</p>';
            echo '<br>';
        } else if ($_SESSION['error_type'] == 'box_blank') {
            echo '<p id="popup_error_message">At least one of the required boxes is empty.</p>';
            echo '<br>';
        } else if ($_SESSION['error_type'] == 'password_not_present') {
            echo '<p id="popup_error_message">Either enter your existing password,<br>or choose yourself a new one.</p>';
            echo '<br>';
        }  else if ($_SESSION['error_type'] == 'not_logged_in') {
            echo '<p id="popup_error_message">You need to log in to view this page.</p>';
            echo '<br>';
        }  else if ($_SESSION['error_type'] == 'link_invalid') {
            echo '<p id="popup_error_message">This page was not found. <br>It may have been removed, or does not exist.</p>';
            echo '<br>';
        }  else if ($_SESSION['error_type'] == 'wrong_account') {
            echo '<p id="popup_error_message">You are not authorized to use this page.<br> You may be logged in as the wrong user.<br></p>';
            echo '<br>';
        }  else if ($_SESSION['error_type'] == 'link_invalid_2') {
            echo '<p id="popup_error_message">There has been a problem with your browser.<br>You have been returned to the home page.</p>';
            echo '<br>';
        }  else if ($_SESSION['error_type'] == 'required_input_missing') {
            echo '<p id="popup_error_message">One or more of the boxes you need to fill are still empty.<br> Have another go!</p>';
            echo '<br>';
         
         // Now for all the custom error boxes for the list a job input, in reverse order
         
        }  else if ($_SESSION['error_type'] == 'job_cat_1_missing') {
            echo '<p id="popup_error_message">Please enter a job category for your listing.</p>';
            echo '<br>';
        }  else if ($_SESSION['error_type'] == 'working_hours_missing') {
            echo '<p id="popup_error_message">Please enter working hours for your listing.</p>';
            echo '<br>';
        }  else if ($_SESSION['error_type'] == 'job_postcode_missing') {
            echo '<p id="popup_error_message">Please enter a postcode for your listing.</p>';
            echo '<br>';
        }  else if ($_SESSION['error_type'] == 'job_location_missing') {
            echo '<p id="popup_error_message">Please enter a job location for your listing.</p>';
            echo '<br>';
        }  else if ($_SESSION['error_type'] == 'contact_phone_missing') {
            echo '<p id="popup_error_message">Please enter a contact phone number for your listing.</p>';
            echo '<br>';
        }  else if ($_SESSION['error_type'] == 'contact_email_missing') {
            echo '<p id="popup_error_message">Please enter a contact email for your listing.</p>';
            echo '<br>';
        }  else if ($_SESSION['error_type'] == 'company_name_missing') {
            echo '<p id="popup_error_message">Please enter a company name for your listing.</p>';
            echo '<br>';
        }  else if ($_SESSION['error_type'] == 'job_description_missing') {
            echo '<p id="popup_error_message">Please enter a job description for your listing.</p>';
            echo '<br>';
        }  else if ($_SESSION['error_type'] == 'job_title_missing') {
            echo '<p id="popup_error_message">Please enter a job title for your listing.</p>';
            echo '<br>';
        }  else if ($_SESSION['error_type'] == 'bad_file_type') {
            echo 
             '<p id="popup_error_message">You cannot upload files of this type.
             <br>
             You need a JPG, JPEG, JPE, or PNG File.</p>';
            echo '<br>';
         $_SESSION['box_type'] = 'image_processing.php';
        }  else if ($_SESSION['error_type'] == 'upload_error') {
            echo 
             '<p id="popup_error_message">There has been a problem with your upload.
             <br>
             Please try again.
             </p>';
            echo '<br>';
            $_SESSION['box_type'] = 'image_processing.php';
        }  else if ($_SESSION['error_type'] == 'file_too_large') {
            echo 
             '<p id="popup_error_message">Your file is too big. The largest file size is 1024mb.
             </p>';
            echo '<br>';
            //Make a custom button appear that pushes back once not twice
            $_SESSION['box_type'] = 'image_processing.php';
        }  else if ($_SESSION['error_type'] == 'file_sig_invalid') {
            echo 
             '<p id="popup_error_message">The file signature is invalid.
             <br>
             The file may have been tampered with. Please try another.
             <br>
             </p>';
            echo '<br>';
            $_SESSION['box_type'] = 'image_processing.php';
        }  else if ($_SESSION['error_type'] == 'saved_job_not_found') {
            echo 
             '<p id="popup_error_message">This job has already been removed.
             </p>';
            echo '<br>';
         
            //Custom button
           

            echo'<br><br>';
            echo '<div onclick="goBack1()" class="button1" id="popup_button">Back </div>'; 


           


        }
     
     
     
     
     
     
     
        echo '</p>';
        }
    
    //echo 'Error: '.$_SESSION['error_type'];
    unset($_SESSION['error_type']);
    unset($_SESSION['error']);
    
    //character limit for error messages is 42//
    
}

function unix_time() {
    return date_timestamp_get(date_create());
}

function reset_counters() {
    unset($_SESSION['page_visits']);
    unset($_SESSION['unix_time_frozen']);
}

function post_user_verify_to_sql() {
    
    $username = $_SESSION['username'];
    $random_number = rand(1,100000);
    $signup_hash = urlencode(password_hash($random_number, PASSWORD_DEFAULT));
    $verify_lock = 1;
        

        //echo '<br>Local Signup Hash is '.$signup_hash.'<br>';
    


    
       //Connect to SQL
    $pdo_servername = $_SESSION['pdo_servername'];
    $pdo_username = $_SESSION['pdo_username'];
    $pdo_password = $_SESSION['pdo_password'];
    $pdo_dbname = $_SESSION['pdo_database'];

    try {
        $conn = new PDO("mysql:host=$pdo_servername;dbname=$pdo_dbname", $pdo_username, $pdo_password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepare sql and bind parameters
        $stmt = $conn->prepare("INSERT INTO verify_account (signup_hash, username,verify_lock) 
        VALUES (:signup_hash, :username, :verify_lock)");
        
        $stmt->bindParam(':signup_hash', $insert_signup_hash);
        $stmt->bindParam(':username', $insert_username);
        $stmt->bindParam(':verify_lock', $verify_lock);

        // insert a row
        $insert_signup_hash = $signup_hash;
        $insert_username = $username;
        $insert_verify_lock = $verify_lock;

        $stmt->execute();

        //echo "Details Posted to verify_account database!";
        }
    catch(PDOException $e)
        {
        //echo "Error: " . $e->getMessage();
        }
    $conn = NULL;
}

function verify_account_detail($item) {

$servername = $_SESSION['pdo_servername'];
$username = $_SESSION['pdo_username'];
$password = $_SESSION['pdo_password'];
$dbname = $_SESSION['pdo_database'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT ".$item." FROM verify_account"); 
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
    
    foreach($stmt as $x) {
        foreach ($x as $item) {
            return $item;
        }
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;

}

function redirect_delay($path,$milli) {
    echo "<script>setTimeout(function(){ window.location = '$path'; }, ".$milli."); </script>";
}

function remove_verify_record($usr) {
    $servername = $_SESSION['pdo_servername'];
    $username = $_SESSION['pdo_username'];
    $password = $_SESSION['pdo_password'];
    $dbname = $_SESSION['pdo_database'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM verify_account WHERE username = '".$usr."'";

        // Prepare statement
        $stmt = $conn->prepare($sql);

        // execute the query
        $stmt->execute();

        // echo a message to say the UPDATE succeeded


            echo $stmt->rowCount() . " records UPDATED successfully";
        

        }
    catch(PDOException $e)
        {

            //echo $sql . "<br>" . $e->getMessage();
        
        }

    $conn = null;
}

function set_error() {
    $_SESSION['error'] = 1;
}

function set_error_type($x) {
    $_SESSION['error'] = 1;
    $_SESSION['error_type'] = $x;
}

function user_message_custom($ref) {
 $_SESSION['user_message_custom'] = 1;
 $_SESSION['user_message'] = $ref;
}

function error_pushback($err_type,$milliseconds,$page) {
    $_SESSION['error'] = 1;
    $_SESSION['error_type'] = $err_type;

    push_back($page,$milliseconds);
    
    //include_error_reporting unsets errors
}



function popup_pushback($popup_type,$milliseconds,$page) {
    include 'popup.php';

    push_back($page,$milliseconds);
    
    //include_error_reporting unsets errors
}


function match_check_top_3($required_inputs) {

        //echo '<br>';
        //echo "<h1>Match Check Top 3</h1>";
    

    $test_items = array (
        $required_inputs[0],
        $required_inputs[1],
        $required_inputs[2],
        $required_inputs[3],
        $required_inputs[4],
        $required_inputs[5],
    );

    for ($i = 0; $i < 5; $i++) {
        $current_item = $required_inputs[$i];
        unset ($test_items[$i]);

        foreach ($test_items as $test_item) {
            if ($test_item == $current_item) {
                    //echo '<br>match found: '.$current_item.' = '.$test_item;
                    //echo ' Throw error.';
                
                
                set_error();
                set_error_type('match_check');
            } else {

                    //echo '<br>No match found: '.$current_item.' != '.$test_item;
                
            }
        }

            //echo '<br><br>....................................<br><br>';
        
    }
    unset($other_item);
}

function limit_length($x) {
    if (strlen($x) == 6) {
        $x = substr($x, 0, 6);
    }
    echo $x.'...';
}

function header_name($var = '') {
 
    if ($var == '') {
     $string = return_user_detail('first_name');
     $string = dotted_limit($string,9);
     echo $string;
    }
 
    if ($var == 1) {
     $string .= ' Admin';
     $string = dotted_limit($string,9);
     echo $string;
    }
 

}

function id_nav_user() {
    if ( (isset($_SESSION['logged_in']) AND $_SESSION['logged_in'] == 1) ) {
        /*
        //Check if it's an admin account
        $admin = pdo_return("SELECT `admin` FROM `users` WHERE `username` = '".$_SESSION['username']."'")[0];
        
        if (isset($admin) && $admin == '1') {
         echo '<p>Hi</p>, <a href="/admin.php" style="color:green">'; header_name(1); echo '</a><p>!</p>';
         echo '<br>';
         echo '<a class="small_font" href="/my_account.php">My Account</a> <p class="small_font">|</p> <a class="small_font" href="/log_out.php">Log Out</a>';
         
        } else {
            */
         echo '<p>Hi</p>, <a href="/my_account.php">'; header_name(); echo '</a><p>!</p>';
         echo '<br>';
         echo '<a class="small_font" href="/my_account.php">My Account</a> <p style="font-size: 0.5em">|</p> <a class="small_font" href="/log_out.php">Log Out</a>';
        /*}*/
    } else {
        
        echo '<div style="height:14px"></div>';
        echo '<a href="/login.php">Login</a>';
        echo ' | ';
        echo '<a href="/create_account.php">Create Account</a>';
        
        }
}

function login_redirect() {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] == 0) {
    echo '<script>window.location = "/index.php";</script>';
        //show a login message
        $_SESSION['login_required_message'] = 1;
    }
}

function dropdown_bar_top() {
 
    //Check if it's an admin account
   
    /*
    if (isset($_SESSION['username'])) {
     $admin = pdo_return("SELECT `admin` FROM `users` WHERE `username` = '".$_SESSION['username']."'")[0];
    }
    */
     /*
    if ($admin == '1') {
     if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
        echo '<p>Hi, <a href="/admin.php" style="color:#9dff85">Admin</a>!';
        echo ' | ';
        echo '<a href="/my_account.php">My Account</a></p>';
    } else {
        
        echo '<a class="white_text" href="/login.php">Login</a>';
        echo ' | ';
        echo '<a href="/create_account.php">Create Account</a>';
     }
    } else {*/
     if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 1) {
        echo '<p>Hi, <a href="/my_account.php" style=color:"green">';header_name();echo '</a>!';
        echo ' | ';
        echo '<a href="/my_account.php">My Account</a></p>';
    } else {
        echo '<a class="white_text" href="/login.php">Login</a>';
        echo ' | ';
        echo '<a href="/create_account.php">Create Account</a>';
     }
    /*}*/
    
    
 

}

function pdo_statement_v1($pdo_statement_v1) {
    require 'settings.php';
//using select * from only returns the first field it finds, 
//so be specific.

$servername = $_SESSION['pdo_servername'];
$username = $_SESSION['pdo_username'];
$password = $_SESSION['pdo_password'];
$dbname = $_SESSION['pdo_database'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare($pdo_statement_v1); 
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
    
    foreach($stmt as $x) {
        foreach ($x as $item) {
            return $item;
        }
    }
}
catch(PDOException $e) {
    echo "<br>Error: " . $e->getMessage();
}
$conn = null;

}

function pdo_statement_v2($pdo_statement_v2) {
    require 'settings.php';
//using select * from only returns the first field it finds, 
//so be specific.

$servername = $_SESSION['pdo_servername'];
$username = $_SESSION['pdo_username'];
$password = $_SESSION['pdo_password'];
$dbname = $_SESSION['pdo_database'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare($pdo_statement_v2); 
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 
    
    foreach($stmt as $x) {
        foreach ($x as $item) {
            return $item;
        }
    }
}
catch(PDOException $e) {
    echo "<br>Error: " . $e->getMessage();
}
$conn = null;

}

function return1() {
   echo 'we are number one';
}

function pdo_delete_or_update_v1($pdo_delete_v1) {
    require 'settings.php';
//using select * from only returns the first field it finds, 
//so be specific.

$servername = $_SESSION['pdo_servername'];
$username = $_SESSION['pdo_username'];
$password = $_SESSION['pdo_password'];
$dbname = $_SESSION['pdo_database'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare($pdo_delete_v1); 
    $stmt->execute();
}
catch(PDOException $e) {
    echo "<br>Error: " . $e->getMessage();
}
$conn = null;

}

function push_back($address, $time = 2000) {

        //echo "<script>
       // setTimeout(function(){window.location = '".$address."';}, ".$time.");
       //</script>";
        echo '<meta http-equiv="refresh" content="0;url='.$address.'">';
    
}

function push_back_instant($address) {
    

        echo "<script>
        window.location = '".$address."';
        </script>";

}

function push_back_v2($time_milli) {
    echo "<script>setTimeout(function(){window.history.back();}, ".$time_milli.");</script>";
}

function login_error($x) {
    $_SESSION['error'] = 1;
    set_error_type($x);
    push_back('../login.php');
}

function set_login_cookie($value) {
    $cookie_name = "cookie_1";
    $cookie_value = $value;
    $days = 3650;
    $dir = "/";
    setcookie($cookie_name, $cookie_value, time() + (86400 * $days), $dir); 
    // 86400 = 1 day
}

function generate_unique_token() {

    // generate a hash
    $hash = bin2hex(random_bytes(16));
    
    //Spoof the hash!
    //$hash = 'test_token';
    
    $test = pdo_statement_v1("SELECT COUNT('login_token') FROM users WHERE login_token ='".$hash."'");
    
    //spoof test
    //$test = 0;
    
    if ($test >= 1) {
        for ($i=0; $i<$test; $i++) {
        }
        $hash = $i.$hash;
    }
    
        //echo '<br> unique hash is '.$hash;
    
    return $hash;
}

function generate_unique_password_token() {

    //tested and working 21/aug/18
    
    // generate a hash
    $hash = bin2hex(random_bytes(16));
    
    //Spoof the hash!
    //$hash = 'test_token';
    
    $test = pdo_statement_v1("SELECT COUNT('reset_hash') FROM reset_password WHERE reset_hash ='".$hash."'");
    
    //spoof test
    //$test = 0;
    
    if ($test >= 1) {
        for ($i=0; $i<$test; $i++) {
        }
        $hash = $i.$hash;
    }
    
 
        //echo '<br> unique hash is '.$hash;
    
    return $hash;
}

function hash_splitter($min_length = 64) {
    
    //deprecated
    
    
    $random_number = random_int(1,($min_length-1));
    
    $insert = 'inserted_string';
    
    $hash_part_1 = bin2hex(random_bytes($random_number));
    $remaining_bytes = $min_length - $random_number;
    $hash_part_2 = bin2hex(random_bytes($remaining_bytes));
    //$matching_hashes = '1';
    //return $hash_part_1.'<br>'.$insert.'<br>'.$hash_part_2;
    return $hash_part_1.$insert.$hash_part_2;
    
}

function cookie_login_check() {
    if (isset($_COOKIE['cookie_1']) AND $_COOKIE['cookie_1']==!null) {
        
        //echo '<h1>login cookie set on user device</h1>';
        
        $foreign_hash = $_COOKIE['cookie_1'];
        
        //spoof hash
        //$foreign_hash = '=' ;
        
        $_SESSION['$db_hash_match'] = pdo_statement_v1("SELECT login_token FROM users WHERE login_token = \"".$foreign_hash."\"");
        
        //echo $db_hash_match;
        
        $username =  pdo_statement_v1("SELECT username FROM users WHERE login_token = \"".$_SESSION['$db_hash_match']."\"");
        
        if ($_SESSION['$db_hash_match'] ==!null) {
            if (hash_equals($_SESSION['$db_hash_match'],$foreign_hash)) {
                
                    //echo 'the hash is found.';
                    //echo 'the username is '.$username;
                    //echo 'log in user ';
                    log_user_in_cookie();
                
            } 
        }

        
        //try injecting sql yourself, create code first
        
        
        
    } else {
        //echo '<h1>nobody was logged in on this machine.</h1>';
    }
}

function log_user_in_cookie() {
    if (!isset($_SESSION['logged_in'])) {
        
        $username = pdo_statement_v1("SELECT username from users where login_token = \"".$_SESSION['$db_hash_match']."\"");
        
        //Assign username to session variable
        $_SESSION['username'] = $username;
        //Set log in to true
        $_SESSION['logged_in'] = 1;
    }      
}

function login_switch_items() {
    if (isset($_SESSION['logged_in'])) {
        echo '<li><a href="/log_out.php">Log Out</a></li>';
    } else {
        echo '<li><a onclick="toggle_menu_bar();">Close Menu</a></li>';
    }
}

function dotted_limit($string,$limit) {
    if (strlen($string) > $limit) {
        $string = substr($string, 0, $limit).'...';
    }
    return $string;
}

function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

function rate_limit_check() {
    $_SESSION['time1'] = time();
}

function pdo_in($table,$column,$data) {

    $servername = $_SESSION['pdo_servername'];
    $username = $_SESSION['pdo_username'];
    $password = $_SESSION['pdo_password'];
    $dbname = $_SESSION['pdo_database'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepare sql and bind parameters
        $stmt = $conn->prepare("INSERT INTO ".$table." (".$column.") 
        VALUES (:".$column.")");
        $stmt->bindParam(":".$column."", $data);

        // insert a row
        $column = $data;
        
        $stmt->execute();

        echo "New records created successfully<br>";
        }
    catch(PDOException $e)
        {
        echo "Error: " . $e->getMessage();
        }
    $conn = null;
}

function xss_protection_array(array &$x) {
    for ($i=0; $i<count($x); $i++) {
        $key = key($x);
        $current_item = array_shift($x);
        $current_item = htmlentities($current_item, ENT_QUOTES, 'UTF-8');
        $x[$key] = $current_item;
    }
    
    return $x;
}

function xss_protection($x) {
    $x = htmlentities($x, ENT_QUOTES, 'UTF-8');
    return $x;
}

function length_limit_array(array &$x,$max_length) {
    for ($i=0; $i<count($x); $i++) {
        $key = key($x);
        $current_item = array_shift($x);
        // process
        
        if (strlen($current_item) > $max_length) {
            $current_item = NULL;
            if(!isset($_SESSION['error'])) {
                $_SESSION['error'] = 1;
                $_SESSION['error_type'] = 'length_check';
            }
        }
        
        
        $x[$key] = $current_item;
    }
    
    return $x;
}

function type_check_array(array &$x,$type) {
    for ($i=0; $i<count($x); $i++) { 
        $key = key($x);
        $current_item = array_shift($x);
        // process
        if(gettype($current_item) == $type) {
            //do nothing
        } else {
            $current_item = NULL;
            if(!isset($_SESSION['error'])) {
                $_SESSION['error'] = 1;
                $_SESSION['error_type'] = 'data_type';
            }
        }
   
        $x[$key] = $current_item;
    }
    return $x;
}

function email_or_username($input) {
    
    if (strpos($input, '@') !== false) {
        $is_email = 1;
    } else {
        $is_username = 1;
    }
    
    if (isset($is_email)) {
        return 'email';
    } else if (isset($is_username)) {
        return 'username';
    } else {
        return 0;
    }
}

function select_job_categories($exclude1 = '',$exclude2 = '') {
$options = array (
'Accountancy',
'Administration',
'Advertising',
'Aerospace',
'Apprenticeships',
'Automotive',
'Agriculture',
'Banking',
'Beauty & Fitness',
'Call Centre',
'Care & Social Care',
'Catering',
'Charity',
'Cleaning',
'Construction',
'Contract',
'Creative',
'Customer Service',
'Design',
'Digital',
'Driving',
'Education',
'Engineering',
'Estate Agency',
'Finance',
'FMCG',
'Graduate',
'Healthcare',
'Hospitality',
'HR & Recruitment',
'Insurance',
'IT',
'Labour',
'Landscaping',
'Legal',
'Leisure',
'Logistics',
'Management',
'Management Consultancy',
'Manufacturing',
'Marketing',
'Media',
'Multilingual',
'Not For Profit',
'Nursing',
'Oil & Gas',
'Other',
'PA',
'Pharmaceutical',
'PR',
'Property',
'Public Sector',
'Purchasing & Procurement',
'Recruitment Sales',
'Remote',
'Renewable Energy',
'Retail',
'Sales',
'Security',
'Science',
'Secretarial',
'Senior Appointments',
'Social Work',
'Teaching',
'Temporary',
'Trainee',
'Transport',
'Travel & Tourism',
'Utilities',
'Warehouse',
'Wholesale',
'Work From Home'
);
 
//Remove any already set options
 
if (get_existing_category_x('1') === $exclude1) {
 $options = \array_diff($options, [$exclude1]);
}

                            
    foreach ($options as $option) {
        echo '<option value="'.$option.'">'.$option.'</option>';
    }
}

function get_existing_category_x($x) {
 $var = pdo_return_secure
 ('job_cat_'.$x,'listed_jobs','page_link',$_SESSION['unique_url'])[0];
 
 return $var;
 
}

function length_limit($x,$max_length) {
    if (strlen($x) > $max_length) {
        if(!isset($_SESSION['error'])) {
            $_SESSION['error'] = 1;
            $_SESSION['error_type'] = 'length_check';
        }
    }
    //return $x;
}

function word_count_limit($x,$max_length) {
    if (str_word_count($x) > $max_length) {
        if(!isset($_SESSION['error'])) {
            $_SESSION['error'] = 1;
            $_SESSION['error_type'] = 'length_check';
        }
    }
    //return $x;
}

function error_report() {
    if (isset($_SESSION['error'])) {
        echo '<br>error: '.$_SESSION['error'];
        echo '<br>error_type = '.$_SESSION['error_type'].'<br>';
    } else {
        echo '<br>No session errors found<br>';
    }
}

function echo_array($arr) {
    echo '<pre>';
    var_dump($arr); 
    echo '</pre>';
}

function list_a_job_length_checks() {
    length_limit($_POST['job_title'],60);
    word_count_limit($_POST['job_description'],500);
    //length_limit($_FILES['company_logo']['name'],255);
    length_limit($_POST['contact_email'],350);

    if (isset($_POST['contact_phone'])) {
        length_limit($_POST['contact_phone'],25);
    }


    if (isset($_POST['further_contact_details'])) {
        word_count_limit($_POST['further_contact_details'],250);
    }

    length_limit($_POST['job_location'],60);
    length_limit($_POST['job_postcode'],12);
    length_limit($_POST['working_hours'],10);
    length_limit($_POST['job_cat_1'],60); 

    if (isset($_POST['remote_working'])) {
        length_limit($_POST['remote_working'],1);
    }

    if (isset($_POST['temporary'])) {
        length_limit($_POST['temporary'],1);
    }
    
    length_limit($_POST['company_name'],40);
}

function all_array_keys(array $x) {
    
    for ($i=0; $i<count($x); $i++) { 
        $keys[$i] = key($x);
        next($x);
    }

    reset($x);
    return $keys;

}

function pdo_return_arr($pdo_stmt) {
    
    $servername = $_SESSION['pdo_servername'];
    $dbname = $_SESSION['pdo_database'];
    $username = $_SESSION['pdo_username'];
    $password = $_SESSION['pdo_password'];
    
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sth = $conn->prepare("".$pdo_stmt.""); 
    $sth->execute();

    // Fetch all of the remaining rows in the result set
    $result = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $result;
        
}

function pdo_in_v2() {
    
    //Get last row of table
 

    //Table length is greater than 0, do this, otherwise don't
   
    $last_row = pdo_return("SELECT `id` FROM listed_jobs ORDER BY id DESC LIMIT 1")[0];
   
   if ($last_row === NULL) {
      $last_row = 0;
   } else {
      $last_row = $last_row + 1;
   }

   
    //
    

    $pdo_servername = $_SESSION['pdo_servername'];
    $pdo_username = $_SESSION['pdo_username'];
    $pdo_password = $_SESSION['pdo_password'];
    $pdo_dbname = $_SESSION['pdo_database'];

try {
        $conn = new PDO("mysql:host=$pdo_servername;dbname=$pdo_dbname", $pdo_username, $pdo_password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepare sql and bind parameters
        $stmt = $conn->prepare("INSERT INTO listed_jobs (username, job_title, job_description, contact_email, contact_phone, further_contact_details, job_location, job_postcode, working_hours, job_cat_1,company_name,year,month,day,unix_time,page_link, listing_live, id, company_logo, stripe_id, user_delete_marked, last_updated, view_count, unix_expiry, free_listing, reporting_users) 
        VALUES (:username,:job_title,:job_description,:contact_email,:contact_phone,:further_contact_details,:job_location,:job_postcode,:working_hours,:job_cat_1,:company_name,:year,:month,:day,:unix_time,:page_link,:listing_live,:id, :company_logo, :stripe_id, :user_delete_marked, :last_updated, :view_count, :unix_expiry, :free_listing, :reporting_users)");
        $stmt->bindParam(':username', $insert_username);
        $stmt->bindParam(':job_title', $insert_job_title);
        $stmt->bindParam(':job_description', $insert_job_description);
        //$stmt->bindParam(':company_logo', $insert_company_logo);
        $stmt->bindParam(':contact_email', $insert_contact_email);
        $stmt->bindParam(':contact_phone', $insert_contact_phone);
        $stmt->bindParam(':further_contact_details', $insert_further_contact_details);
        $stmt->bindParam(':job_location', $insert_job_location);
        $stmt->bindParam(':job_postcode', $insert_job_postcode);
        $stmt->bindParam(':working_hours', $insert_working_hours);
        $stmt->bindParam(':job_cat_1', $insert_job_cat_1);
        $stmt->bindParam(':company_name', $insert_company_name);
        $stmt->bindParam(':year', $insert_year);
        $stmt->bindParam(':month', $insert_month);
        $stmt->bindParam(':day', $insert_day);
        $stmt->bindParam(':unix_time', $insert_unix_time);
        $stmt->bindParam(':page_link',$insert_page_link);
        $stmt->bindParam(':listing_live',$insert_listing_live);
        $stmt->bindParam(':id',$insert_id);
        $stmt->bindParam(':company_logo',$insert_company_logo);
        $stmt->bindParam(':stripe_id',$insert_stripe_id);
        $stmt->bindParam(':user_delete_marked',$insert_user_delete_marked);
        $stmt->bindParam(':last_updated',$insert_last_updated);
        $stmt->bindParam(':view_count',$insert_view_count);
        $stmt->bindParam(':unix_expiry',$insert_unix_expiry);
        $stmt->bindParam(':free_listing',$insert_free_listing);
        $stmt->bindParam(':reporting_users',$insert_reporting_users);
 
        
        // insert a row
        $insert_username = $_SESSION['username'];
        $insert_job_title = $_POST['job_title'];
        $insert_job_description = $_POST['job_description'];
        //$insert_company_logo = $_FILES['company_logo']['name'];
        $insert_contact_email = $_POST['contact_email'];
        $insert_contact_phone = $_POST['contact_phone'];
        $insert_further_contact_details = $_POST['further_contact_details'];
        $insert_job_location = $_POST['job_location'];
        $insert_job_postcode = $_POST['job_postcode'];
        $insert_working_hours = $_POST['working_hours'];
        $insert_job_cat_1 = $_POST['job_cat_1'];
        $insert_company_name = $_POST['company_name'];
        $insert_year = $_SESSION['year'];
        $insert_month = $_SESSION['month'];
        $insert_day = $_SESSION['day'];
        $insert_unix_time = $_SESSION['unix_time'];
        $insert_page_link = $_SESSION['unique_url'];
        $insert_listing_live = $_SESSION['listing_live'];
        $insert_id = $last_row;
        $insert_company_logo = '';
        $insert_stripe_id = ''; 
        $insert_user_delete_marked = 0;
        $insert_last_updated = time();
        $insert_view_count = 0;
        $insert_unix_expiry = '';
        $insert_free_listing = 0;
        $insert_reporting_users = '[]';
 
 
      
 
    

        $stmt->execute();

        //echo "New records created successfully<br>";
        }
    catch(PDOException $e)
        {
        echo "Error: " . $e->getMessage();
        }
    $conn = null;
}

function check_image_type() {
   $type = exif_imagetype($_SERVER['DOCUMENT_ROOT']."/user_uploads/company_logos/".$_FILES['company_logo']['name']);
    if ($type == 1 || $type == 2 || $type == 3) {
        //do nothing, it's a gif, jpg or png file
    } else {
        unlink($_SERVER['DOCUMENT_ROOT']."/user_uploads/company_logos/".$_FILES['company_logo']['name']);
        $_SESSION['error'] = 1;
        $_SESSION['error_type'] = 'invalid_image';
    }
}

function check_image_type_v2($img_path) {
   $type = exif_imagetype($img_path);
    if ($type == 1) {
        return 'GIF';
    } else if ($type == 2) {
        return 'JPEG';
    } else if ($type == 3) {
        return 'PNG';
    } else {
        return 0;
    }
}

function update_db($database,$table,$existing_value,$value_change) {
    $servername = $_SESSION['pdo_servername'];
    $username = $_SESSION['pdo_username'];
    $password = $_SESSION['pdo_password'];
    $dbname = $_SESSION['pdo_database'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE ".$table." SET ".$value_change." WHERE ".$existing_value."";

        // Prepare statement
        $stmt = $conn->prepare($sql);

        // execute the query
        $stmt->execute();

        // echo a message to say the UPDATE succeeded
        //echo $stmt->rowCount() . " records UPDATED successfully";
        }
    catch(PDOException $e)
        {
        echo $sql . "<br>" . $e->getMessage();
        }

    $conn = null;
}

function update_db_v2($sql) {
    $servername = $_SESSION['pdo_servername'];
    $username = $_SESSION['pdo_username'];
    $password = $_SESSION['pdo_password'];
    $dbname = $_SESSION['pdo_database'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare statement
        $stmt = $conn->prepare($sql);

        // execute the query
        $stmt->execute();

        // echo a message to say the UPDATE succeeded
        //echo $stmt->rowCount() . " records UPDATED successfully";
        }
    catch(PDOException $e)
        {
        echo $sql . "<br>" . $e->getMessage();
        }

    $conn = null;
}

function delete_row_from_db($database,$table,$column,$row) {
    $servername = $_SESSION['pdo_servername'];
    $username = $_SESSION['pdo_username'];
    $password = $_SESSION['pdo_password'];
    $dbname = $database;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    // sql to delete a record
    $sql = "DELETE FROM ".$table." WHERE ".$column."='".$row."'";

    if ($conn->query($sql) === TRUE) {
        //echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $conn->close();
}

function check_image_file_size($image_size,$megabyte_limit) {
    $kilobytes = $megabyte_limit * 1000;
    $bytes = $kilobytes * 1000;
    
    if ($image_size < $bytes) {
        //image is smaller than megabyte limit
        return null;
    } else {
        //image is larger than megabyte limit
     unlink($_SERVER['DOCUMENT_ROOT']."/user_uploads/company_logos/".$_FILES['company_logo']['name']);
        $_SESSION['error'] = 1;
        $_SESSION['error_type'] = 'image_file_size_over_limit';
    }
    return null;
}

function resize_image($newWidth, $targetFile, $originalFile) {

    $info = getimagesize($originalFile);
    $mime = $info['mime'];

    switch ($mime) {
            case 'image/jpeg':
                    $image_create_func = 'imagecreatefromjpeg';
                    $image_save_func = 'imagejpeg';
                    //$new_image_ext = 'jpg';
                    break;

            case 'image/png':
                    $image_create_func = 'imagecreatefrompng';
                    $image_save_func = 'imagepng';
                    //$new_image_ext = 'png';
                    break;

            case 'image/gif':
                    $image_create_func = 'imagecreatefromgif';
                    $image_save_func = 'imagegif';
                    //$new_image_ext = 'gif';
                    break;

            default: 
                    throw new Exception('Unknown image type.');
    }

    $img = $image_create_func($originalFile);
    list($width, $height) = getimagesize($originalFile);

    $newHeight = ($height / $width) * $newWidth;
    $tmp = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    if (file_exists($targetFile)) {
            unlink($targetFile);
    }
    //$image_save_func($tmp, "$targetFile.$new_image_ext");
    $image_save_func($tmp, "$targetFile");
}

function pdo_return_pair($pdo_stmt) {
    $servername = $_SESSION['pdo_servername'];
    $dbname = $_SESSION['pdo_database'];
    $username = $_SESSION['pdo_username'];
    $password = $_SESSION['pdo_password'];
    
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sth = $conn->prepare("".$pdo_stmt.""); 
    $sth->execute();

    // Fetch all of the remaining rows in the result set
    $result = $sth->fetchAll(PDO::FETCH_KEY_PAIR);
    
    return $result;
}

function pdo_return_single($pdo_stmt) {
    $servername = $_SESSION['pdo_servername'];
    $dbname = $_SESSION['pdo_database'];
    $username = $_SESSION['pdo_username'];
    $password = $_SESSION['pdo_password'];
    
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sth = $conn->prepare("".$pdo_stmt.""); 
    $sth->execute();

    // Fetch all of the remaining rows in the result set
    $result = $sth->fetchAll(PDO::FETCH_KEY_PAIR);
    
    return $result;
}

function get_working_hours_sticker($hours) {
    if ($hours == 'full_time') {
        $hours = '<div class="hours_icon" id="full_time_icon">Full Time</div>';
    }
    if ($hours == 'part_time') {
        $hours = '<div class="hours_icon" id="part_time_icon">Part Time</div>';
    }
    if ($hours == 'zero_hours') {
        $hours = '<div class="hours_icon" id="zero_hours_icon">Zero Hours</div>';
    }
    return $hours;
}

function print_search_result($row_id) {
    
    $listed_jobs = get_listed_jobs_data('search.php',$row_id)[0];

    echo'
    <a class="format_job_listings" href="job_listing.php?a='.$listed_jobs['page_link'].'">
        <div class="search_result">
            <div class="search_result_column_l">
                <img class="search_logo" src="'.$listed_jobs['company_logo'].'"</img>
            </div>
            <div class="search_result_column_c">
                <p id="job_search_title">'.$listed_jobs['job_title'].'</p><br>
                <p id="search_result_company_name">'.$listed_jobs['company_name'].'</p>
                <br>
                <p id="job_search_description">'.mb_substr($listed_jobs['job_description'],0,221).'...</p>
            </div>
            <div class="search_result_column_r">
                '.get_working_hours_sticker($listed_jobs['working_hours']).'
                <img id="search_logo_mobile" src="'.$listed_jobs['company_logo'].'"</img>
            </div>
        </div>
    </a>'
    ;
}

function get_listed_jobs_data($page,$id_number) {
    $servername = $_SESSION['pdo_servername'];
    $dbname = $_SESSION['pdo_database'];
    $username = $_SESSION['pdo_username'];
    $password = $_SESSION['pdo_password'];
   
    
    try {
    
        $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($page === 'search.php') {

            $sth = $conn->prepare("SELECT job_title,company_logo,job_description,working_hours,company_name,unix_time,page_link FROM listed_jobs WHERE id=:id_number"); 
            $sth->bindParam(':id_number' , $id_number);
            $sth->execute();
            // Fetch all of the remaining rows in the result set
            $output = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $output;

        } else if ($page === 'job_listing') {

            $sth = $conn->prepare("SELECT company_name,job_title,year,month,day,job_description,company_logo,contact_email,contact_phone,further_contact_details,job_location,job_postcode,working_hours,job_cat_1 FROM listed_jobs WHERE id=:id_number"); 
            $sth->bindParam(':id_number' , $id_number);
            $sth->execute();
            // Fetch all of the remaining rows in the result set
            $output = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $output;

        } else if ($page === 'search.php_haystack') {

            $sth = $conn->prepare("SELECT company_name,job_title,job_location,job_postcode,job_cat_1 FROM listed_jobs WHERE id=:id_number"); 
            $sth->bindParam(':id_number' , $id_number);
            $sth->execute();
            // Fetch all of the remaining rows in the result set
            $output = $sth->fetchAll(PDO::FETCH_NUM);
            return $output;
            
        } else if ($page === 'my_account.php') {

            $sth = $conn->prepare("SELECT company_name,job_title,unix_time,id,page_link,listing_live,company_logo FROM listed_jobs WHERE `id`=:id_number "); 
            $sth->bindParam(':id_number' , $id_number);
            $sth->execute();
            // Fetch all of the remaining rows in the result set
            $output = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $output;
            
        } else {
            echo 'page not set or invalid.';
        }
    
    }

    catch(PDOException $e) {
        //echo "Connection failed: " . $e->getMessage();
    }  
}

function secure_search($input) {
    xss_protection($input);
    return $input;
}

function get_search_score($row_id,$search_string = '') {

    $search_strings = explode(" ",$search_string);

	$row_data = get_listed_jobs_data('search.php_haystack',$row_id)[0];
    $row_data = implode(' ',$row_data);
    $row_data = explode(' ',$row_data);

    //both arrays are of individual things seperated by a space now
            
    $match_scores = array();
    
    // Add 1 to score per match per row
    for ($i=0;$i<count($search_strings);$i++) {
        $match_counter = 0;
        for ($j=0;$j<count($row_data);$j++) {
            if (stripos($row_data[$j], $search_strings[$i]) !== false) {
            $match_counter++;
            }
        }
        
        // add 1 to score per match in job_title box
        $job_title = pdo_return("SELECT job_title FROM listed_jobs WHERE id =".$row_id."")[0];
        
        
        if (stripos($job_title, $search_strings[$i]) !== false) {
            $match_counter++;
            }
        
        $data = array($search_strings[$i] => $match_counter);
        array_push($match_scores,$data);
    }
    
    // assign the total single word matches to the output array
    
    $total = array();
    for ($i=0;$i<count($match_scores);$i++) {
        $sum = array_sum($match_scores[$i]);
        array_push($total,$sum);
    }
    
    $total = array_sum($total);


    //string match routines
    
    $match_arrays = return_special_strings_match_data($search_string);
    
    if ($match_arrays !== 0) {
        for ($i=0; $i<count($match_arrays);$i++) {
            $field_data = $match_arrays[$i][0];
            $column = $match_arrays[$i][1];
            $table = $match_arrays[$i][2];
            //$row id exists from top of function

            $existing_field_data = pdo_return("SELECT ".$column." FROM ".$table." WHERE id = ".$row_id." ")[0];

            if ($existing_field_data === $field_data) {
                $total++;
            }
        }
       
        
    }
    
    //echo $total;
    
    //pre($match_arrays);
    
    
    
    //assign row_id to score
    $array = array('row_id' => $row_id, 'score' => $total);
    //pre($array);
    return $array;
    
}

function select_grouped_array_data($array,$group,$a) {
    //a = non zero indexed arrays
    
    $result = array();
    for ($i=0;$i<count($array[$group])-$a;$i++) {
        $data = $array[$group][$i];
        array_push($result,$data);
    }
    return $result;
    
    
}

function select_zero_indexed_from_multi_array($array,$a){
    //$a = non zero indexed key amount
    //selects all zero indexed data from multi dimensional array
    //goes 1 level deep
    
    $result = array();
        
    for ($j=0; $j<count($array);$j++) {
    
        for ($i=0; $i<count($array[$j])-$a;$i++) {

            //add the resulting string to the end of the array
            $item = $array[$j][$i];
            array_push($result,$item);
            }
    }
        
    
    return $result;
}

function get_special_string_groups($option = '') {
    if ($option == '') {
        $array = array(
            array(
                'db_handle' => 'full_time',
                'db_column' => 'working_hours',
                'table_name' => 'listed_jobs',
                'full time',
                'fulltime'
            ),
            array(
                'db_handle' => 'part_time',
                'db_column' => 'working_hours',
                'table_name' => 'listed_jobs',
                'part time',
                'parttime'
            ),
            array (
                'db_handle' => 'zero_hours',
                'db_column' => 'working_hours',
                'table_name' => 'listed_jobs',
                'zero hours',
                'zero hour',
                'zerohours',
                'zerohour',
                '0hours',
                '0hour',
            )
        );
    }
    return $array;
}

function does_string_contain($string,$contain_string) {
        
    $temp_result = stripos($string,$contain_string);
        
    if ($temp_result !== false) {
        return 1;
    }
    
}

function does_string_contain_array_count($string,$array) {
    
    $count = 0;
    
    for ($i=0; $i<count($array);$i++) {
        $result = does_string_contain($string,$array[$i]);
        if ($result !== null) {
        $count++;
        }
    }
    return $count;
}

function does_array_contain_string($array,$string) {
    
    $count = 0;
    
    for ($i=0; $i<count($array);$i++) {
        $result = does_string_contain($string,$array[$i]);
        if ($result !== null) {
        $count = 1;
        }
    }
    return $count;
}

function pre($array) {
    //prints a formatted array
    print "<pre>";
    print_r($array);
    print "<pre>";
}

function get_search_scores_array($search_string) {

    $ids_array = pdo_return("SELECT id FROM listed_jobs WHERE listing_live=1 ORDER BY unix_time DESC");
    
    $search_scores = array();
    
    for($i=0;$i<count($ids_array);$i++) {
        $search_score = get_search_score($ids_array[$i],$search_string);
        array_push($search_scores,$search_score);
    }
    //pre($search_scores);
    return $search_scores;
}

function get_search_scores_array_2($search_string) {

    $ids_array = pdo_return("SELECT id FROM listed_jobs WHERE listing_live=1 ORDER BY unix_time DESC");
    
    $search_scores = array();
    
    for($i=0;$i<count($ids_array);$i++) {
        $search_score = get_search_score($ids_array[$i],$search_string);
        array_push($search_scores,$search_score);
    }
    //pre($search_scores);
    return $search_scores;
}

function reorder_array($array,$row) {

    function method1($a,$b) {
        
        global $row;
        //manually set row below
        $row = 'score';
        //manually set row above
        
        return ($a[$row] >= $b[$row]) ? -1 : 1;
        unset($_SESSION['temp']);
    }
    usort($array, "method1");
    
    
    return $array;
}

function reorder_array_2($array,$row) {

    function method1($a,$b) {
        
        global $row;
        //manually set row below
        $row = 'score';
        //manually set row above
        
        return ($a[$row] >= $b[$row]) ? -1 : 1;
        unset($_SESSION['temp']);
    }
    usort($array, "method1");
    
    
    return $array;
}

function flatten_array_by_key($array,$key) {
    $result = array();
    for ($i=0; $i<count($array);$i++) {
        $data = $array[$i]['row_id'];
        array_push($result,$data);
    }
    return $result;
}

function flatten_array_by_key_2($array,$key) {
    $result = array();
    for ($i=0; $i<count($array);$i++) {
        $data = $array[$i]['row_id'];
        array_push($result,$data);
    }
    return $result;
}

function select_display_rows($array,$first,$last) {
//rewrite this it doesnt work at all
}


function return_matching_ids_array($search_string) {
    
    $array = reorder_array(get_search_scores_array_2($search_string),'score');
    $array = flatten_array_by_key($array,'row_id');
    
    return $array;
}



function print_bottom_bar() {
    echo'
    <div class="search_result_end" style="background-color:rgba(255,255,255,0.7)">
        <p>You\'ve reached the end of the search results.</p><br>
        <br>
        <p>Didn\'t find what you wanted?<br> Get some help by double clicking <a style="color:blue" onclick="toggle_help_box();">here</a>.</p>
        <br>
            
    </div>';
}


function stripos_array_check($a,$b = array(),$c) {
    //$b is an array
    //does a contain b?
    //1 if yes
    //0 if no
    $d = 0;
    $f = array();

    for ($i=0;$i<count($b)-$c;$i++) {
        $check = stripos($a,$b[$i]);
        if ($check !== false) {
            $d = 1;
            $e = $b['db_handle'];
            $g = $b['db_column'];
            $h = $b['table_name'];
        }
            
    }
    if ($d > 0) {
        array_push($f,$e);
        array_push($f,$g);
        array_push($f,$h);
        return $f;
    } else {
        return 0;
    }

    
}

function return_special_strings_match_data($search_string) {
    //returns 0 if no special strings are found
    
    $array = array();
    
    for ($i=0; $i<count(get_special_string_groups());$i++) {
        $arr = get_special_string_groups()[$i];
            $a = stripos_array_check($search_string,$arr,3);
    
        if ($a !== 0) {
            array_push($array,$a);
        }
    
    }
    
    if (isset($array[0])) {
        return $array;
    } else {
        $array = 0;
        return $array;
    }
    
    
    
}

function base62($length) {
    $index = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $res = '';
    for ($x = 1; $x < $length+1; $x++) {
    $res .= $index[rand(0, strlen($index)-1)];
    }
    return $res;
}

function profanity_check($x) {
    //return 1 if profane word found
    //otherwise return 0
    
    foreach (get_included_files() as $item ) {        
    $string = 'profanity_filter.php';
    if (strpos($item, $string) == false) {
        include 'profanity_filter.php';


        $test = new profanityFilter;

        $bool = $test->scanText($x);

        if ($bool > 0) {
            return 1;
        } else {
            return 0;
        }
    }
    unset($string);
    }  
}

function random_url_string($x) {
 $url_string = base62($x);
 //strip it down to the first x chars
 $url_string = substr($url_string,0,$x);
 return $url_string;
}

function unique_in_column($table,$column,$match) {
    
    $result = pdo_return("SELECT ".$column." FROM ".$table."");
    $result_length = count($result);
    
    for ($i=0; $i<$result_length; $i++) {
        if ($result[$i] === $match) {
            $bool = 1;
        }
    }
    
    if (!isset($bool)) {
        $bool = 0;
    }
    
    return $bool;
}

function get_full_url() {
    $x = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    return $x;
}

function get_uploaded_image_size($targetPath) {
    if (isset($targetPath)) {
        $result = array();
        array_push($result,getimagesize($targetPath)[0]);
        array_push($result,getimagesize($targetPath)[1]);
        return $result;
    } else {
        return null;
    }
}

function get_uploaded_file_label($filepath) {
    if (isset($filepath)) {
        return $filepath;
    } else {
        return 'Select a file...';
    }
}

function fail_if_previous_page_is_not($x) {
    if (!isset($_SERVER['HTTP_REFERER'])) {
     push_back_instant('/404.php');
    } else {
        $a = $_SERVER['HTTP_REFERER'];
        if (strpos($a, $x) !== false) {
            //do nothing, allowing the page to load
        } else {
            push_back_instant('/404.php');
        }
    }
}

function get_welcome_message() {
    //don't let the messages be longer than the current ones
    $array = array(
    'You look lovely today!',
    'Welcome back!',
    'Nice to see you!',
    "How's the search going?",
    "Is that a new top?",
    "Did you change your hair?",
    "You look great!",
    "Good to see you!",
    "So glad you're back!",
    "Let's get you going!",
    "Let's find your dream job.",
    "You can do it!",
    "You look stunning.",
    "Look at you go!",
    "What a nice day!",
    "Believe in yourself!"
    );
    
    $array_length = count($array);
    
    $number = rand(0,$array_length-1);
    
    echo '<p id="welcome_message" padding:5px; border-radius:5px; font-size:1em;">'.$array[$number].'</p>';
}

function get_pdo_data($table,$columns) {
    
    //columns must be an array
    //must be logged in, relies on
    //username session variable
    
    $array = array();
    for ($i=0; $i<count($columns); $i++) {
        $item = pdo_return("SELECT `".$columns[$i]."` FROM `".$table."` WHERE username='".$_SESSION['username']."'")[0];
        array_push($array,$item);
    }
    return $array;

}

function string_shortener($string,$max_length,$dots_bool) {
    
    $length = strlen($string);
    if ( $length > $max_length ) {
        return substr($string,0,$max_length).'...';
    } else {
        return $string;
    }
    
}

function get_account_details($username) {
    $array = array(
            'first_name',
            'middle_name',
            'last_name',
            'username',
            'email',
            'gender'
    );
    
    $result = array();
    
    for ($i=0; $i<count($array); $i++) {
        $item = pdo_return("SELECT `".$array[$i]."` FROM `users` WHERE `username` = '".$username."' ")[0];
        array_push($result,$item);
    }
    
    return $result;
    
    
}

function get_job_listing_details($job_id) {
 $array = array(
  'job_title',
  'job_description',
  'company_name',
  'contact_email',
  'contact_phone',
  'further_contact_details',
  'job_location',
  'job_postcode',
  'working_hours',
  'job_cat_1',
 );
    
$result = array();
    
for ($i=0; $i<count($array); $i++) {
 $item = pdo_return("SELECT `".$array[$i]."` FROM `listed_jobs` WHERE `page_link` = '".$job_id."' ")[0];
 array_push($result,$item);
}
    return $result;
}

// only used for my account at this difficult time

class job_listing {
    
    var $job_title;
    var $company_name;
    var $timestamp;  
    var $view_link;
    var $edit_link;
    var $cancel_link;
    
    var $row_count;
  
    function set_vars ($id) {
        $this->job_title = pdo_return("SELECT `job_title` FROM `listed_jobs` WHERE `id`=".$id."")[0];
        $this->company_name = pdo_return("SELECT `company_name` FROM `listed_jobs` WHERE `id`=".$id."")[0];
        $this->timestamp = pdo_return("SELECT `unix_time` FROM `listed_jobs` WHERE `id`=".$id."")[0];
        $link = pdo_return("SELECT `page_link` FROM `listed_jobs` WHERE `id`=".$id."")[0];
        $this->view_link = '/job_listing.php?a='.$link;
        $link = pdo_return("SELECT `page_link` FROM `listed_jobs` WHERE `id`=".$id."")[0];
        $this->edit_link = 'edit/job_listing.php?a='.$link;
        $link = pdo_return("SELECT `page_link` FROM `listed_jobs` WHERE `id`=".$id."")[0];
        $this->cancel_link = 'cancel/job_listing.php?a='.$link;
    }
    
    function convert_timestamp_string($id) {
        if ($this->timestamp < time()) {
            $this->timestamp = 'Listing Live';
        }
    }

    function print_box() {
        echo '
            <div class="data_box_1 green">
                <div class="data_box_header_1">
                    '.$this->company_name.'
                    <br> 
                    <p class="data_box_header_1_a">'.$this->job_title.'</p> 
                    <br><br>
                    <p class="highlight_green">'.$this->timestamp.'</p>
                </div>
                <div class="button_array_1">
                    <a href="'.$this->view_link.'">View</a>
                    <a href="'.$this->edit_link.'">Edit</a>
                    <a href="'.$this->cancel_link.'">Cancel</a>
                </div>
            </div>
        ';
    }
    
    function get_row_count() {
        
        $row_count = pdo_return("SELECT `id` FROM `listed_jobs` WHERE `username` = '".$_SESSION['username']."'");
                            
        $this->row_count = count($row_count);
        return count($row_count);
        
    }

    
    function run($id) {  
        
        //instead of taking the id, take the actual
        //row number. Have a function to convert
        //an id into a row number
        
        $this->set_vars($id);
        $this->convert_timestamp_string($id);
        $this->print_box();
    }
    
}

function return_matching_ids_array_2($search_string) {
    
    $array = reorder_array_2(get_search_scores_array_2($search_string),'score');
    $array = flatten_array_by_key_2($array,'row_id');
    
    return $array;
}

function sql_update($sql) {
    $servername = $_SESSION['pdo_servername'];
   $username = $_SESSION['pdo_username'];
   $password = $_SESSION['pdo_password'];
   $dbname = $_SESSION['pdo_database'];

   try {
       $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
       // set the PDO error mode to exception
       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

       // Prepare statement
       $stmt = $conn->prepare($sql);

       // execute the query
       $stmt->execute();

       // echo a message to say the UPDATE succeeded
       //echo $stmt->rowCount() . " records UPDATED successfully";
       }
   catch(PDOException $e)
       {
       //echo $sql . "<br>" . $e->getMessage();
       }

   $conn = null;
}

function sql_delete($sql) {
    $servername = $_SESSION['pdo_servername'];
   $username = $_SESSION['pdo_username'];
   $password = $_SESSION['pdo_password'];
   $dbname = $_SESSION['pdo_database'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // use exec() because no results are returned
    $conn->exec($sql);
    //echo "Record deleted successfully";
    }
catch(PDOException $e)
    {
    //echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
}

function logged_in_check() {
  if(!isset($_SESSION['logged_in'])) {
  $_SESSION['error'] = 1;
  $_SESSION['error_type'] = 'not_logged_in';
  push_back_instant('/index.php');
 }
}

function pdo_return_secure
($select,$table,$unique_column,$urlstring) {
    $servername = $_SESSION['pdo_servername'];
    $dbname = $_SESSION['pdo_database'];
    $username = $_SESSION['pdo_username'];
    $password = $_SESSION['pdo_password'];
    
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sth = $conn->prepare("SELECT `".$select."` FROM `".$table."` WHERE `".$unique_column."` = :urlstring "); 
    
    $sth->bindParam(':urlstring',$urlstring);
 
    $sth->execute();

    // Fetch all of the remaining rows in the result set
    $result = $sth->fetchAll();
    
    //get the amount of results
    $result_amount = count($result);
    $results = array();
    
    for ( $i=0; $i < $result_amount; $i++) {
        array_push($results,$result[$i][0]);
    }
    
    return $results;
}

function filesize_too_large_print() {
 echo '<div id="popup_error_2"> That image is too large. The maximum file size is 1000kb.</div>';
 $imagePath = "../img/forms/blank.jpg";
 echo '<script>location.reload</script>';
 $image_invalid_popup_shown = 1;
}

function pdo_delete($table='not_set',$column='not_set',$where='not_set', $report=0) {
    $servername = $_SESSION['pdo_servername'];
    $username = $_SESSION['pdo_username'];
    $password = $_SESSION['pdo_password'];
    $dbname = $_SESSION['pdo_database'];

 try {
     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
     // set the PDO error mode to exception
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     // sql to delete a record
     $sql = "DELETE FROM ".$table." WHERE ".$where."  ";

     // use exec() because no results are returned
     $conn->exec($sql);
     if ($report > 0) {
      echo "Record deleted successfully";
     }
     }
 catch(PDOException $e)
     {
      if($report > 0) {
       echo $sql . "<br>" . $e->getMessage();
      }
     }

 $conn = null;
}

function array_swap(&$array,$swap_a,$swap_b){
   list($array[$swap_a],$array[$swap_b]) = array($array[$swap_b],$array[$swap_a]);
}

function count_saved_jobs() {
 $data = pdo_return("SELECT `saved_jobs` FROM `users` WHERE `username` = '".$_SESSION['username']."' ")[0];
 $array = (json_decode($data, true));
 $result = count($array);
 //Adjustment for security string
 return $result-1;
}

function count_listed_jobs() {
 $data = pdo_return("SELECT `id` FROM `listed_jobs` WHERE `username` = '".$_SESSION['username']."' AND NOT `user_delete_marked` = '1' ");

 $data = count($data);
 //Adjustment for security string
 return $data;
}

function input_exists($input,$key_name) {
 if (!isset($input) || $input == '' || $input == null) {
  return $key_name;
 }
}

function remove_empty_values_from_array($array) {
 foreach($array as $key => $value)          
    if(empty($value)) 
        unset($array[$key]); 
  $array = array_values($array);
 return $array;
}

function switch_underscore_for_space_and_capitalise($missing_details) {
 $output = array();
 for ($i=0; $i<count($missing_details); $i++) {
  $missing_details[$i] = ucwords(str_replace("_"," ",$missing_details[$i]));
  
  //Extra thing for job cat 1
  
  if ($missing_details[$i] == 'Job Cat 1') {
   $missing_details[$i] = 'Job Category';
  }
  
  
  array_push($output,$missing_details[$i]);
 }
 
 return($output);
}

function view_counter_update($page_link = '') {
 
 //Check if page link is valid in database
 $view_count = pdo_return("SELECT `view_count` FROM `listed_jobs` WHERE `page_link` = '".$page_link."' ")[0];
 
 //If it is there, add 1 to the page view counter for that listing
 if(isset($view_count)) {
  $view_count = $view_count + 1;
  sql_update("UPDATE `listed_jobs` SET `view_count`='".$view_count."' WHERE `page_link`= '".$page_link."' ");
 }
 
}

function index_view_counter_update() {
 
 //Check if page link is valid in database
 $view_count = pdo_return("SELECT `home_page_views` FROM `site_data` WHERE `sql_id`= '0'")[0];

 //If it is there, add 1 to the page view counter for that listing
 if(isset($view_count)) {
  $view_count = $view_count + 1;
  sql_update("UPDATE `site_data` SET `home_page_views`='".$view_count."' WHERE `sql_id`= '0' ");
 }
 
}

function set_expiry_sql() {
 $one_day = 24*60*60;
 
 //1 month + 3 months for hiring process
 $days = 127;

 $expiry = time() + ($one_day * $days);

 sql_update("UPDATE `listed_jobs` SET `unix_expiry`='".$expiry."' WHERE `page_link`= '".$_SESSION['unique_url']."' ");
}



function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function remove_emoji($array) {
 for ($i=0; $i<count($array); $i++) {
  $array[$i] = str_replace("????"," ",$array[$i]);        
  echo $array[$i];  
 }
}

function get_location_data_v1() {
 
 $session_id = session_id();
 //$table_length = pdo_return("SELECT max(id) FROM user_connections")[0];
 
 //echo $session_id;
   //echo '<br>';
 //echo $table_length;
 
 $row_id = pdo_return("SELECT `id` FROM `user_connections` WHERE `session_id` = '".$session_id."'");
   
 //echo '<br>';
 //echo $entry_id;
   
 if (isset($row_id[0])) {
    //echo 'success! area found.';
    
    $constituency = pdo_return("SELECT `constituency` FROM `user_connections` WHERE `session_id` = '".$session_id."'")[0];
    $postcode = pdo_return("SELECT `postcode` FROM `user_connections` WHERE `session_id` = '".$session_id."'")[0];
    $county = pdo_return("SELECT `county` FROM `user_connections` WHERE `session_id` = '".$session_id."'")[0];
    
    $array = array(
       $constituency,
       $postcode,
       $county
    );
    
    //var_dump($array);
    return $array;

 } else {
    return 0;
 }
}

function location_data_bar() {
 if (get_location_data_v1() !== 0) {
   //echo 'location found';
   $array = (get_location_data_v1());
   //var_dump($array);
    return $array;
 } else {
    return 0;
 }
}

function set_slider() {
 $session_id = session_id();
 //$table_length = pdo_return("SELECT max(id) FROM user_connections")[0];
 
 //echo $session_id;
   //echo '<br>';
 //echo $table_length;
 
 $row_id = pdo_return("SELECT `id` FROM `user_connections` WHERE `session_id` = '".$session_id."'");
   
 //echo '<br>';
 //echo $entry_id;
   
 if (isset($row_id[0])) {
    //echo 'success! area found.';
    
    $setting = pdo_return("SELECT `use_location` FROM `user_connections` WHERE `session_id` = '".$session_id."'")[0];
    
    //var_dump($array);
    if ($setting == 1) {
     $setting = 'checked';
    } else {
     $setting = '';
    }
    echo $setting;

 } else {
    return 0;
 }
   
}

function silent_ignore() {
 //Say yes, and do no for the reporting page.
 echo 'silent ignore activated. function not created yet';  
}

 function sql_update_by_1($column,$table,$unique_column) {
   //Download Column
   $data = pdo_return("SELECT `".$column."` FROM `".$table."` WHERE `".$unique_column."` = '".$_GET['a']."' ")[0];
   //Process Column
   $data++;
   //Upload Column
   pdo_delete_or_update_v1("UPDATE `".$table."` SET `".$column."`='".$data."' WHERE `".$unique_column."` = '".$_GET['a']."' ");
 }



?>