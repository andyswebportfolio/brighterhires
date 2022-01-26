<?php
session_start();

//Security is at the top and the bottom, typically.

define('unlock_includes', TRUE);

if(!defined('unlock_includes')) {
 http_response_code(404);
 include('../404.php'); // provide your own HTML for the error page
 die();
}


include '../settings.php';
include '../functions.php';



if (isset($_POST["first_name"])) {

    $error = NULL;
    
    if(isset($_SESSION['block_sql'])) {
     $block_sql = $_SESSION['block_sql'];
    } else {
     $block_sql = null;
    }


$_SESSION['show_loading'] = 1;
include '../loading.php';
unset($_SESSION['show_loading']);

//echo '<h1>Secure Sending Page</h1>';

/*Fill Form With Information*/
    
    $gender = $_POST['gender'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    //Extra additions for monitoring and updates to names etc.
    $live_jobs = '0';
    $update_count = '0';
    $last_updated = time();
    $saved_jobs = '[]';
    $deleted = '0';
    $admin = '0';
    $strikes = '0';

    


/*From PHP*/
date_default_timezone_set("Europe/London");
$uk_date = date("j / M / Y");
$uk_time = date("H:i:s");
$ip = $_SERVER['REMOTE_ADDR'];
    
/**********************************************************
/*Match Check*/
    
    
/**********legacy code needed for old function****/
$match_check_required_inputs = array (
        $first_name,
        $middle_name,
        $last_name,
        $username,
        $email,
        $password
);
/**********legacy code needed for old function****/

$check_1 = array (
    $first_name,
    $middle_name,
    $last_name,
);
    
$check_2 = array (
    $username,
    $password
);

foreach ($check_1 as $item) {
    for ($i = 0; $i <= 1; $i++) {
        if ($item == $check_2[$i]) {

                //echo '<br>'.$item.' match with '.$check_2[$i];
            
            set_error();
            set_error_type('name_match');

        } else {

                // echo '<br>'.$item.' no match with '.$check_2[$i];

        }
    }
    echo '<br>';
}
    
if ($check_2[0] == $check_2[1]) {

       // echo 'username and password match! throw error.';
    
    set_error();
    set_error_type('username_and_password_match');
}

unset($check_1);
unset($check_2);
/**********************************************************
/*Length Check*/
/*Check size does not go over a set limit of characters*/
    

    //echo '<br>';
    //echo "<h1>Limit Check</h1>";

    
$strings = array($gender);
$limit = 7;

foreach($strings as $testcase) {
    $length = strlen($testcase);
    if ($length < $limit) {
       //echo 'limit check pass';
    } else {
        //echo 'limit check fail';
        $error = 1;
        $_SESSION['error_type'] = 'length_check';
    }
    
        //echo '<br>Limit was '.$limit;
        //echo '<br>Length was '.$length;
        //echo '<br>String was '.$testcase.'<br>';
        //echo '<br>';
    
}

$strings = array($first_name,$middle_name,$last_name,$username);
$limit = 35;

foreach($strings as $testcase) {
    $length = strlen($testcase);
    if ($length < $limit) {
        //echo 'limit check pass';
    } else {
        //echo 'limit check fail';
        $error = 1;
        $_SESSION['error_type'] = 'length_check';
    }
    
        //echo '<br>Limit was '.$limit;
        //echo '<br>Length was '.$length;
        //echo '<br>String was '.$testcase.'<br>';
        //echo '<br>';
    
}

$strings = array($email);
$limit = 350;
foreach($strings as $testcase) {
    $length = strlen($testcase);
    if ($length < $limit) {
       //echo 'limit check pass';
    } else {
        //echo 'limit check fail';
        $error = 1;
        $_SESSION['error_type'] = 'length_check';
    }
    
        //echo '<br>Limit was '.$limit;
        //echo '<br>Length was '.$length;
        //echo '<br>String was '.$testcase.'<br>';
        //echo '<br>';
    
}

$strings = array($password);
$limit = 75;
foreach($strings as $testcase) {
    $length = strlen($testcase);
    if ($length < $limit) {
        //echo 'limit check pass';
    } else {
        //echo 'limit check fail';
        $error = 1;
        $_SESSION['error_type'] = 'length_check';
    }
    
        //echo '<br>Limit was '.$limit;
        //echo '<br>Length was '.$length;
        //echo '<br>String was '.$testcase.'<br>';
        //echo '<br>';
    
}

    

/**********************************************************
Password min length check. Not included in report mode.*/
    
$pass_length = strlen($password);

if ($pass_length < 8) {
    $_SESSION['error'] = 1;
    $_SESSION['error_type'] = 'password_too_short';
    
    

        //echo '<h1>Password Length Check</h1>';
        //echo '<p>Length is lower than 8. Error Thrown.';
    
}

/**********************************************************


/************************/
/* 8 Step Check Process */
/************************/
    
/*Prevent XSS, Javascript Injection*/
    
/*process each one, and output it to it's variable name. */
    

    //echo '<br>';
    //echo "<h1>XSS Protection</h1>";
    //echo '<br>';


$strings = array($gender,$first_name,$middle_name,$last_name,$username,$email,$password);
    
    
    $gender = htmlentities($gender, ENT_QUOTES, 'UTF-8');
    $first_name = htmlentities($first_name, ENT_QUOTES, 'UTF-8');
    $middle_name = htmlentities($middle_name, ENT_QUOTES, 'UTF-8');
    $last_name = htmlentities($last_name, ENT_QUOTES, 'UTF-8');
    $username = htmlentities($username, ENT_QUOTES, 'UTF-8');
    $email = htmlentities($email, ENT_QUOTES, 'UTF-8');
    $password = htmlentities($password, ENT_QUOTES, 'UTF-8');
        
/*Make sure the above scripts are a copy of this bottom one to make the test reliable*/
function test_xss_protection() {
    $script_injection = "<script>alert('Im a virus');</script>";
    
    /*Copy this line with the correct variables to prevent script injection*/
    $script_injection = htmlentities($script_injection, ENT_QUOTES, 'UTF-8');
    
    
    echo "XSS Test Run. <br>";
    
    echo "If javascript popup shows, you are vulnerable. Else, you are safe. ";
    echo "If you see no javascript in the next line on this page, you are vulnerable.<br>";
    echo $script_injection;
    echo "<br><br>See back end code on this page for implementation.";
    echo '<br>';
}
    

    //test_xss_protection();


    
/*Data Type*/
/* checks whether the data is a string, integer, float, array and so on. */
    

    //echo '<br>';
    //echo "<h1>Data Type Check</h1>";
    //echo "<br>";

   
    $strings = array($gender,$first_name,$middle_name,$last_name,$username,$email,$password);
    
    foreach ($strings as $testcase) {
        $type = gettype($testcase);
        if ($type === "string") {
             
                //echo "Data Type check passed<br>";
            
        } else {
            $error = 1;
            $_SESSION['error_type'] = 'data_type';
            
                //echo "Data Type check failed.<br>";
            
        }
    }




/*Allowed Characters*/
/*Could use php ctype, this allows all languages though, but no numbers or symbols/**/
    

    //echo '<br>';
    //echo "<h1>Allowed Characters Check</h1>";
    //echo "<br>";

    
$strings = array($gender);
foreach ($strings as $testcase) {
    if (preg_match('/^[\p{Latin}[A-Za-z]*$/', $testcase)) {
        //echo "Allowed characters check passed";
    } else {
        //echo "The string $testcase does not consist of all letters. Reject.\n";
        $error = 1;
        $_SESSION['error_type'] = 'allowed_characters_gender';
    }
    
        //echo '<br>';
    
}

          
$strings = array($first_name,$middle_name,$last_name);
foreach ($strings as $testcase) {
    if (preg_match('/^[\p{Latin}[A-Za-z-\s]*$/', $testcase)) {
        //echo "Allowed characters check passed";
    } else {
        //echo "The string $testcase does not consist of all letters. Reject.\n";
        $error = 1;
        $_SESSION['error_type'] = 'allowed_characters_name';
    }

      //echo '<br>';

}
    
$strings = array($username);
foreach ($strings as $testcase) {
    if (preg_match('/^[\p{Latin}[A-Za-z0-9_-]*$/', $testcase)) {
        //echo "Allowed characters check passed";
    } else {
        //echo "The string $testcase does not consist of all letters. Reject.\n";
        $error = 1;
        $_SESSION['error_type'] = 'allowed_characters_username';
    }
   //echo '<br>';
}
    
$strings = array($email);
foreach ($strings as $testcase) {
    if (preg_match('/^[\p{Latin}[A-Za-z0-9\._\-@]*$/', $testcase)) {
        //echo "Allowed characters check passed";
    } else {
        //echo "The string $testcase does not consist of all letters. Reject.\n";
        $error = 1;
        $_SESSION['error_type'] = 'allowed_characters_email';
    }
   


    //echo '<br>';
    
}
    
/*password regex allows any character*/
    




/*Presence Check*/
/*This is done in html.*/

/*Verification Check*/
/* Do it twice, to make sure.*/
/*Not using this, it's silly.*/
/*This is done in html.*/
    
/*Hash sensitive information*/
    
    /*Password work*/
    

        //echo '<br>';
        //echo "<h1>Hash Secure Information</h1>";

        //echo 'Password var is: ' . $password . '<br>';
        //echo 'Password Hash = ';
    
    

    //echo $password;

    $hash_string = password_hash($password, PASSWORD_DEFAULT);
    //echo $hash_string;
    
    $password = $hash_string;
    //echo '<br>Password var is: ' . $password . '<br>';
    
    
/*****************************************************************************************

/* Unique Entry Check */


       // echo '<h1>Unique Entry Check</h1>';
       // echo 'entered username was '.$username.'<br>';
    
  
    //Report mode testing

      //echo '<br>';
      //echo 'function result for username is ';
      //echo check_users_detail_unique('username',$username);
      //echo '<br>';
      //echo 'function result for email is ';
      //echo check_users_detail_unique('email',$email);
      //echo '<br>';
     

      
      
     if (check_users_detail_unique('username',$username) ==!NULL) {

             //echo 'username found! Throw error.';
         
         $_SESSION['error'] = 1;
         $_SESSION['error_type'] = 'username_not_unique';
     } else {
         
             //echo 'username not found! Pass this check.';
         
     }
    
    echo '<br><br>';
    
    
        //echo 'entered email was '.$email.'<br>';
    
    
     if (check_users_detail_unique('email',$email) ==!NULL) {

             //echo 'email found! Throw error.';             
         
         $_SESSION['error'] = 1;  
         $_SESSION['error_type'] = 'email_not_unique';
     } else {
         
             //echo 'email not found! Pass this check.';
         
     }
    
    





/******************************************************************************************

/* Data Flood Check */
//reset_counters();

//flood_check();

/******************************************************************************************

Combine session error and error*/
    

    

        
        //echo '<h1>Combine Local and Session Error Values</h1>';
        
        //echo $error.' is current file var for error<br>';
        if (isset($_SESSION['error'])) {
            //echo $_SESSION['error'].' is current session var for error';
        } else {
            //echo 'Error Session is not set.';
        }
    
    
    if (isset($_SESSION['error'])) {
        $error = $error + $_SESSION['error'];
    }
    //echo '<br> error variable is '.$error;
    
    if ($error === 0) {
        $error = NULL;
    }
    
       // echo '<br>Error variable now contains ['.$error.']';
    

//
 
 //Set the id number as one more than the last entry in the table
 
 $id = pdo_return("SELECT `id` FROM users ORDER BY id DESC LIMIT 1")[0];
   
if ($id === NULL) {
   $id = 0;
} else {
   $id = $id + 1;
}


/******************************************************************************************
    
    
    
    
/*Output full data set to be sent*/

    //echo '<br>';
    //echo "<h1>Data Set</h1>";
    
$post = array($gender,$first_name,$middle_name,$last_name,$username,$email,$password,$uk_date,$uk_time,$ip);
   
        //foreach($post as $item){
            //echo $item;
            //echo '<br>';
        //}
    
    
/*Check for block sql*/
    
if ($block_sql ==!NULL & $error === NULL) {

      //echo '<p>No errors, however, sql is switched off.</p>';

}

/*Assign persistent, unique login token, in case.*/
/*Note token contains no encrypted user information.*/

$login_token = generate_unique_token();

    
/*Prevent SQL Injection, Insert into SQL*/
/*Use prepared statements.*/

    
if ($error == NULL & $block_sql == NULL) {

    $pdo_servername = $_SESSION['pdo_servername'];
    $pdo_username = $_SESSION['pdo_username'];
    $pdo_password = $_SESSION['pdo_password'];
    $pdo_dbname = $_SESSION['pdo_database'];

    try {
        $conn = new PDO("mysql:host=$pdo_servername;dbname=$pdo_dbname", $pdo_username, $pdo_password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // prepare sql and bind parameters
        $stmt = $conn->prepare("INSERT INTO users (gender, first_name, middle_name, last_name, username, email, password, uk_date, uk_time, ip, login_token,id,live_jobs,update_count,last_updated,saved_jobs,deleted,admin,strikes) 
        VALUES (:gender, :first_name, :middle_name, :last_name, :username, :email, :password, :uk_date, :uk_time, :ip, :login_token, :id, :live_jobs, :update_count, :last_updated, :saved_jobs, :deleted, :admin, :strikes)");
       
        
        
        $stmt->bindParam(':gender', $insert_gender);
        $stmt->bindParam(':first_name', $insert_first_name);
        $stmt->bindParam(':middle_name', $insert_middle_name);
        $stmt->bindParam(':last_name', $insert_last_name);
        $stmt->bindParam(':username', $insert_username);
        $stmt->bindParam(':email', $insert_email);
        $stmt->bindParam(':password', $insert_password);

        $stmt->bindParam(':uk_date', $insert_uk_date);
        $stmt->bindParam(':uk_time', $insert_uk_time);
        $stmt->bindParam(':ip', $insert_ip);
        $stmt->bindParam(':login_token', $insert_login_token);
        $stmt->bindParam(':id', $insert_id);
       
        //Updates added for monitoring
        $stmt->bindParam(':live_jobs', $insert_live_jobs); 
        $stmt->bindParam(':update_count', $insert_update_count);
        $stmt->bindParam(':last_updated', $insert_last_updated);
        $stmt->bindParam(':saved_jobs', $insert_saved_jobs);
        $stmt->bindParam(':deleted', $insert_deleted);
     
        //Admin account setting
        $stmt->bindParam(':admin', $insert_admin);
       
        //Account Strikes setting
        $stmt->bindParam(':strikes', $insert_strikes);
        

        // insert a row 
        
        $insert_gender = $gender;
        $insert_first_name = $first_name;
        $insert_middle_name = $middle_name;
        $insert_last_name = $last_name;
        $insert_username = $username;
        $insert_email = $email;
        $insert_password = $password;

        $insert_uk_date = $uk_date;
        $insert_uk_time = $uk_time;
        $insert_ip = $ip;
        
        $insert_login_token = $login_token; 
        $insert_id = $id;
     
        
        //Updates for monitoring, set at the top of the page
        $insert_live_jobs = $live_jobs;
        $insert_update_count = $update_count;
        $insert_last_updated = $last_updated;
        $insert_saved_jobs = $saved_jobs;
        $insert_deleted = $deleted;
        $insert_admin = '0';
        $insert_strikes = $strikes;

        $stmt->execute();

        //echo "Details Posted to users database!";
        }
    catch(PDOException $e)
        {
        //echo "Error: " . $e->getMessage();
        }
    $conn = NULL;
    
    
    //Add to user verification table
    
    $_SESSION['username'] = $username;
    
    post_user_verify_to_sql();

    
}

    
    
    
        
    if ($error == !NULL) {
        $_SESSION['error'] = 1;

           // echo '<br>';
           // echo "<h1>Error Reporting</h1>";
           // echo 'There is a problem with the input. Nothing was posted to the database.';
           // echo '<br>Last Problem was '.$_SESSION['error_type'];
         //exit();
        } else {
        
        //push back due to error
        

            echo "<script>
            setTimeout(function(){window.location = '../create_account.php';}, 1000);
            </script>";
         

     
        //set email address to post to for next page
        $_SESSION['verify_email'] = $email;
        

            //echo '<br>Security passed.<br> Proceed to email verification at ../emails/verify_account.php';


            //go to user email page
            
                define('unlock_verify', TRUE);
                $_SESSION['push_to_email'] = 1;
                
                echo "<script>
                setTimeout(function(){window.location = '../emails/verify_account.php';}, 1000);
                </script>";
                
            
            
        
    }



} else {
   //Or if it all goes wrong...

        echo "<script> window.location = '../index.php';</script>";
  
}

//unset($_SESSION['counter']);



?>