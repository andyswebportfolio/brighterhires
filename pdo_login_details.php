<?php

if(!defined('unlock_includes')) {
 http_response_code(404);
 include('404.php'); // provide your own HTML for the error page
 die();
}

if ($_SERVER['HTTP_HOST'] == 'localhost:8888') {
 $servername = "localhost";
 $username = "root";
 $password = "root";
 $dbname = "u221194601_brighter_hires";
 $database = "u221194601_brighter_hires";
} else {
 //If it's online, connect to online database
 $servername = "107.6.169.66";
 $username = 'brighter';
 $password = 'Cube=c00l';
 $dbname = 'u221194601_brighter_hires';
 $database = 'u221194601_brighter_hires';
}


?>