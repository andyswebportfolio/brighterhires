<?php

if(!defined('unlock_includes')) {
 http_response_code(404);
 include('../404.php'); // provide your own HTML for the error page
 die();
}

function pre_embed($array) {
    //prints a formatted array
    print "<pre>";
    print_r($array);
    print "<pre>";
    
}

function pdo_return_embed($pdo_stmt) {
    
    $servername = $_SESSION['pdo_servername'];
    $dbname = $_SESSION['pdo_database'];
    $username = $_SESSION['pdo_username'];
    $password = $_SESSION['pdo_password'];
    
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sth = $conn->prepare("".$pdo_stmt.""); 
    $sth->execute();

    /* Fetch all of the remaining rows in the result set */
    $result = $sth->fetchAll();
    
    //get the amount of results
    $result_amount = count($result);
    $results = array();
    
    for ( $i=0; $i < $result_amount; $i++) {
        array_push($results,$result[$i][0]);
    }
    
    return $results;
        
}

?>
