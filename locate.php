<?php

//Include 404 Security
require 'security/security_404.php';

//Test notes
//1. Get JS Data is using static test data
//$json = '{"long":"0.2711708", "lat":"50.7731463"}';
//Line 107 commented out the old PDO statement

//Include settings to update the server name
define('unlock_includes', TRUE);
include 'settings.php';

//1. Get JS Data
$json = file_get_contents('php://input');
$json = '{"long":"0.2711708", "lat":"50.7731463"}';
$json = json_decode($json, true);


//2. Get PHP Data

//Attempt to set session_id and ip
session_start();
$session_id = session_id();

//Get Ip Address

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}



//Get Town Name from the long and lat, using postcodes.io

//Get JS Long and Lat, if they aren't found, exit the script

//  Initiate curl
$url = 'https://api.postcodes.io/postcodes?lon='.$json['long'].'&lat='.$json['lat'];
     
$ch = curl_init();
// Will return the response, if false it print the response
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$result=curl_exec($ch);
// Closing
curl_close($ch);

// Will dump a beauty json :3
//echo '<pre>';
//var_dump(json_decode($result, true));
$postcodesio_json = json_decode($result, true);



//Storage from postcodes.io 1 of 2: Storage locations to Display

$area = ($postcodesio_json['result'][0]['parliamentary_constituency']);
$county = ($postcodesio_json['result'][0]['admin_county']);
$postcode = ($postcodesio_json['result'][0]['postcode']);
$postcode = current(explode(' ', $postcode));

//Format area according to postcodes.io formats


//Do the usual security stuff on anything incoming from another source



//if there is a space, then and, then a space, remove all of that


//If there is a - , switch it for a blank space

//If there is -under- remove it

//if there are any special characters apart from ', remove it





//
//

//Assign inputs for SQL insert

$data0 = $ip;
$data1 = $session_id;
//$json comes from JS
$data2 = $json['long'];
//$json comes from JS
$data3 = $json['lat'];
$data4 = $area;
$data5 = $county;
$data6 = $postcode;


    //Check if the user's Session is already stored in SQL.
    //If it's not stored, add it, if it is, update it

//Step 1 of 2, Add if it's not there


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


$session_id_exists_check = pdo_return("SELECT `id` from `user_connections` WHERE `session_id` = '".$session_id."' ")[0];


if ($session_id_exists_check != '') {

    //If there's a session id, update it
   
   function pdo_delete_or_update_v1($pdo_delete_v1) {
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
   
 pdo_delete_or_update_v1("UPDATE `user_connections` SET `sql_long`='".$data2."' WHERE `session_id` = '".$session_id."' ");
   
 pdo_delete_or_update_v1("UPDATE `user_connections` SET `sql_lat`='".$data3."' WHERE `session_id` = '".$session_id."' ");
   
   
   
} else {
   
   //Create an entry, because there isn't one
   
   $servername = "localhost";
   $username = $_SESSION['pdo_username'];
   $password = $_SESSION['pdo_password'];
   $dbname = $_SESSION['pdo_database'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO user_connections (ip, session_id, sql_long, sql_lat, constituency, county, postcode, use_location)
    VALUES (:ip, :session_id, :sql_long, :sql_lat, :constituency, :county, :postcode, :use_location)");
   
    $stmt->bindParam(':ip', $ip);
    $stmt->bindParam(':session_id', $session_id);
    $stmt->bindParam(':sql_long', $sql_long);
    $stmt->bindParam(':sql_lat', $sql_lat);
    $stmt->bindParam(':constituency', $constituency);
    $stmt->bindParam(':county', $county);
    $stmt->bindParam(':postcode', $postcode_insert);
    $stmt->bindParam(':use_location', $use_location_insert);

    // insert a row
    $ip = $data0;
    $session_id = $data1;
    $sql_long = $data2;
    $sql_lat = $data3;
    $constituency = $data4;
    $county = $data5;
    $postcode_insert = $postcode;
    $use_location_insert = 1;
   
    $stmt->execute();

    //echo "New records created successfully";
    }
catch(PDOException $e)
    {
    echo "Error: " . $e->getMessage();
    }
$conn = null;
}



?>