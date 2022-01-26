<?php

//*USAGE

//Use this as a template.
//It is secure.
//There is no need to re-write it.


//******

session_start();

define('unlock_includes', TRUE);

//ADD push back if something is not set

include '../settings.php';
include '../functions.php';
include '../ip_security_lockout.php';
//**************************************************

/*Assign post array for
numbered usage purposes*/

$post_array = array (
 $_POST['first_name'],
 $_POST['middle_name'],
 $_POST['last_name'],
 $_POST['username'],
 $_POST['email'],
 $_POST['password'],
 $_POST['gender']
);

//**************************************************

// Show loading wheel
$_SESSION['show_loading'] = 1;
include '../loading.php';
unset($_SESSION['show_loading']);

//**************************************************

//Cross Site Scripting Protection
// Must be written individually.
// Stops scripts running, but still causes layout problems.

//This can be fixed with removing certain characters later

htmlentities($_POST['first_name'], ENT_QUOTES, 'UTF-8');
htmlentities($_POST['middle_name'], ENT_QUOTES, 'UTF-8');
htmlentities($_POST['last_name'], ENT_QUOTES, 'UTF-8');
htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8');
htmlentities($_POST['password'], ENT_QUOTES, 'UTF-8');
htmlentities($_POST['gender'], ENT_QUOTES, 'UTF-8');

//**************************************************

//Match check local
 //throw error if
  //any of the boxes contain the password apart from the password  

$main_item = $_POST['password'];
$test_items = array (

$_POST['first_name'],
$_POST['middle_name'],
$_POST['last_name'],
$_POST['username'],
$_POST['email'],
$_POST['gender']
);

for ($i=0; $i<count($test_items); $i++) {
   if(strcmp($main_item,$test_items[$i]) == 0) {
    //push back due to error
    set_error_type('name_match_2');
  }
}

//**************************************************
 
//Match check db
 //throw error if
  //the username or email matches an existing entry in the database

  //return an array of every x column in the database

function unique_in_db($table,$column) {
    
//select username by session username
$existing_detail = pdo_return("SELECT `".$column."` FROM `users` WHERE username ='".$_SESSION['username']."' ")[0];
    
//if the column matches the entry for that username
//do not set this function off

 $length = count(pdo_return("SELECT `".$column."` FROM `".$table."` "));

 for ($i=0; $i<$length; $i++) {
  $item = pdo_return("SELECT `".$column."` FROM `".$table."` ")[$i];
     
 if ($item == $_POST[$column] && $item !== $existing_detail) {
  //username is in use
  set_error_type($column.'_not_unique');
  }
 }
}

unique_in_db('users','username');
unique_in_db('users','email');

//**************************************************
 
//Max Length check
 //throw error if
 //any box is longer than x

//Allows lengths up to 35

$custom_post_array = array (
$_POST['first_name'],
$_POST['middle_name'],
$_POST['last_name'],
$_POST['username']
);

for ($i=0; $i<count($custom_post_array); $i++) {
 if (strlen($custom_post_array[$i]) > 35) {
  set_error_type('length_check_name');
 }
}

//Allows lengths up to 75

if (strlen($_POST['password']) > 75) {
 set_error_type('length_check_password');
}

//Allows lengths up to 350

if (strlen($_POST['email']) > 350) {
 set_error_type('length_check_email');
}

//**************************************************

//Data type check
 //throw error if
 //any box is not the correct data type
 //entire post array is reassigned at
 //top of page for usage throughout

 $strings = $post_array;
    
 foreach ($strings as $testcase) {
  $type = gettype($testcase);
  if ($type === "string") {
   //do nothing
  } else {
    set_error_type('data_type');
  }
     
//**************************************************

//Allowed Characters
  //throw error if
   //any box contains dissallowed characters
     
//Allowed Characters

 if (preg_match('/^[\p{Latin}[A-Za-z]*$/', $_POST['gender'])) {
     //passed
 } else {
  set_error_type('allowed_characters_gender');
 }
}
   
$strings = array(
 $_POST['first_name'],
 $_POST['middle_name'],
 $_POST['last_name']
);

foreach ($strings as $testcase) {
 if (preg_match('/^[\p{Latin}[A-Za-z-\s]*$/', $testcase)) {
 } else {
  set_error_type('allowed_characters_name');
 }
}

if (preg_match('/^[\p{Latin}[A-Za-z0-9_-]*$/', $_POST['username'])) {
 //nothing
} else {
 set_error_type('allowed_characters_username');
}


if (preg_match('/^[\p{Latin}[A-Za-z0-9\._\-@]*$/', $_POST['email'])) {
 //nothing
} else {
 set_error_type('allowed_characters_email');
}

//**************************************************

//Min length checks

//Password
if (strlen($_POST['password']) < 8) {
 set_error_type('password_too_short');
}

//**************************************************

//Presence Check
  //throw error if
   //any box is empty

$required_boxes = array(
 $post_array[0],
 $post_array[2],
 $post_array[3],
 $post_array[4],
 $post_array[5],
 $post_array[6]
);

   
for($i=0; $i<count($required_boxes); $i++) {
 if ($required_boxes[$i] == '') {
  set_error_type('box_blank');
 }
}

if (strlen($_POST['password']) == 0) {
 set_error_type('password_not_present');
}

//**************************************************
    
// If there has been an error, push back and set error code
        
if (isset($error) || isset($_SESSION['error'])) {
        
    $_SESSION['error'] = 1;
    //push back due to error
    echo "<script>
    setTimeout(function(){window.location = '../edit_account_details.php';}, 1000);
    </script>"; 

} else {
 
    //Update all existing entries in database to new username
 
    pdo_delete_or_update_v1("UPDATE `listed_jobs` SET `username` = '".$_POST['username']."' WHERE `listed_jobs`.`username` = '".$_SESSION['username']."'");
    
    //get the username and update the details
    $servername = $_SESSION['pdo_servername'];
    $username = $_SESSION['pdo_username'];
    $password = $_SESSION['pdo_password'];
    $dbname = $_SESSION['pdo_database'];
    
    //Set vars to bind in sql statement
    
    try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    // Declare params
    //Cannot be done later due to security restrictions in PHP
    
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $gender = $_POST['gender'];

    $sql = 
    "UPDATE users 
    SET 
     first_name = :first_name,
     middle_name = :middle_name,
     last_name = :last_name,
     username = :username,
     email = :email,
     password = :password,
     gender = :gender
    WHERE username='".$_SESSION['username']."'";
    
    // Prepare statement
    $stmt = $conn->prepare($sql);
        
    // Bind parameters
    $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
    $stmt->bindParam(':middle_name', $middle_name, PDO::PARAM_STR);
    $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
    $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);

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
    
    //Reset username
    $_SESSION['username'] = $_POST['username'];
 
 
    //Notify the user that details were updated
    user_message_custom('Your details have been updated.');
    
     redirect_delay('../edit_account_details.php',971);
    }

?>