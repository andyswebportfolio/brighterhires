<?php

//remove the login cookie
// unset cookies

if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}



session_start();
define('unlock_includes', TRUE);
include '../functions.php';
include '../ip_security_lockout.php';

//Show Spinner
$_SESSION['show_loading'] = 1;
include '../loading.php';
unset($_SESSION['show_loading']);

//Fail if nobody is logged in

if(!isset($_SESSION['logged_in'])) {
 //No error because it pushes to my account which sees you aren't logged in
 //and pushes you to the index page.
 push_back_instant('../my_account.php');
 exit();
}

//
//Update user delete marked for the user

pdo_delete_or_update_v1("UPDATE `users` SET `deleted` = '1' WHERE `username` = '".$_SESSION['username']."'");

//Mark all jobs as deleted for this user

pdo_delete_or_update_v1("UPDATE `listed_jobs` SET `user_delete_marked` = '1' WHERE `username` = '".$_SESSION['username']."'");


/*

// Delete Stripe Subscriptions by username

require_once('../stripe/init.php');
\Stripe\Stripe::setApiKey($_SESSION['stripe_private_key']);

$sub_ids = pdo_return("SELECT `stripe_id` FROM `listed_jobs` WHERE `username` = '".$_SESSION['username']."'");


if (count($sub_ids > 0)) {
 for ($i=0; $i<count($sub_ids); $i++) {
    
  if ($sub_ids[$i] !== '') {
   $subscription = \Stripe\Subscription::retrieve($sub_ids[$i]);
   $subscription->cancel();
  }
    
 }
}



//Delete all job entries by $_SESSION['username']

pdo_delete_or_update_v1("UPDATE `listed_jobs` SET `user_delete_marked` = '1' WHERE `username` = '".$_SESSION['username']."'");


//Delete the user entry with Brighter Hires

$servername = $_SESSION['pdo_servername'];
$username = $_SESSION['pdo_username'];
$password = $_SESSION['pdo_password'];
$dbname = $_SESSION['pdo_database'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // sql to delete a record
    $sql = "DELETE FROM users WHERE username='".$_SESSION['username']."'";
    unset ( $_SESSION['username'] );
    

    // use exec() because no results are returned
    $conn->exec($sql);
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

$conn = null;
*/
//session is destroyed on next page
$_SESSION['logged_out'] = 1;

if(isset($_SESSION['logged_in'])) {
 unset($_SESSION['logged_in']);
}

echo "<script>setTimeout(function(){window.location = '../logged_out.php';}, 2000)</script>";



?>