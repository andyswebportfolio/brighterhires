<?php
session_start();




//Get the name from the site header
//$data = "/extra%20sites/jobsaroundlaurelandyanny.co.uk/";    
/*
$data = $_SERVER['REQUEST_URI'];






echo $data;


//Store the variable on the main jobs around session variable
$_SESSION['site_area_name'] = $data;

echo $_SESSION['site_area_name'];
*/

/*
//Redirect the user 


?>


<?php

//Get the ip
/*
$ip = $_SERVER['REMOTE_ADDR'];
echo $ip;
*/




$data = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

$data = substr($data, strpos($data, "jobsaround") + 10);
$data = substr($data, 0, strpos($data, "."));
$data = ucwords($data);

//echo $data;

$_SESSION['site_area_name'] = $data;
//echo $_SESSION['site_area_name'];

//Test

echo session_id();

/*
//This changes based on offline or online

if ( $_SERVER['HTTP_HOST'] == 'localhost:8888' ) {
 header("Location: http://localhost:8888");
} else {
 header("Location: https://www.brighterhires.online");
}

//print_r($_SERVER);
*/



exit();




?>



