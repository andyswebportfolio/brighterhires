<?php
if(!defined('unlock_includes')) {
 http_response_code(404);
 include('404.php'); // provide your own HTML for the error page
 die();
}
?>

<head>
    
    <title>Brighter Hires.com</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/tablet.css">
    <link rel="stylesheet" type="text/css" href="/css/mobile.css">
    
    <link rel="stylesheet" type="text/css" href="/css/mobile_lock.css">
 
    <link rel="stylesheet" href="croppie/croppie.css" />
     
        <meta name="description" content="Brighter Hires - Need a job? Ask the whale!" />
        <meta name="keywords" content="Jobs Site UK, Jobs, jobssite, jobs, employment, employer, employee"/>
        <meta name="author" content="AWK Web Design"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="description" content="We offer a professional and friendly job search service to employees and employers. With a safe and secure database of jobs to search through, and a simple user interface, you are sure to find the connection you are looking for, whether you are looking to employ others or find employment yourself." />
        
        <meta name="keywords" content="HTML, CSS, JavaScript, PHP">
        <meta name="author" content="AWK Web Design">
   
        <meta charset="utf-8">
      <link rel="icon" href="/favicon2.ico" type="image/x-icon">
 
     <?php
 
   //Add custom javascript libraries based on page url
    
    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
 
    if (preg_match('/\bimage_processing.php\b/', $url) !== 0) {
     
     echo '<script src="/croppie/jquery3-3-1.js"></script>';
     
     echo '<script src="/croppie/croppie.min.js"></script>'; //the custom header additions
    }
    
 
 

 
    ?>
   
   <script src="locate.js"></script>
   
</head>