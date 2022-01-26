<?php

//Initialise

session_start();
//Not used Due to CRON Restriction.
//define('unlock_includes', TRUE);
//include '../settings.php';
//include '../functions.php';
//$_SESSION['push_to_home'] = 1;
//exit();

//Cron Script

function cron_run_log_prepared_statement($cron_job_name_insert,$cron_job_time_insert,$cron_job_date_insert) {
//If it's offline, do this
if ($_SERVER['HTTP_HOST'] == 'localhost:8888') {
 $servername = 'localhost';
 $username = 'root';
 $password = 'root';
 $dbname = 'u221194601_brighter_hires';
} else {
 //If it's online, connect to online database
   //! Needs to be copied manually for CRON Jobs
 $servername = 'localhost';
 $username = 'u221194601_root';
 $password = 'Cube=c00l';
 $dbname = 'u221194601_brighter_hires';
}


   try {
     $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
     // set the PDO error mode to exception
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     // prepare sql and bind parameters
     $stmt = $conn->prepare("INSERT INTO cron_run_log (cron_job, time, date)
     VALUES (:cron_job, :time, :date)");
     $stmt->bindParam(':cron_job', $cron_job);
     $stmt->bindParam(':time', $time);
     $stmt->bindParam(':date', $date);

     // insert each row
     $cron_job = $cron_job_name_insert;
     $time = $cron_job_time_insert;
     $date = $cron_job_date_insert;
     $stmt->execute();

     //echo "New records created successfully";
   } catch(PDOException $e) {
     //echo "Error: " . $e->getMessage();
   }
   $conn = null;
}

//Log cron_run_log in SQL Database 1x run
date_default_timezone_set('Europe/London');
cron_run_log_prepared_statement('cron_test',date("G:i:s"),date("dS F Y "));



?>