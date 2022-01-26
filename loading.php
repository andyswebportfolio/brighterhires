<?php

foreach (get_included_files() as $item ) {        
    $string = 'functions.php';
    if (strpos($item, $string) == false) {
        include_once 'functions.php';
    }
    unset($string);
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['show_loading'])) {
    push_back_instant('/index.php');
}

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/tablet.css">
    <link rel="stylesheet" type="text/css" href="css/mobile.css">
    
    <link rel="stylesheet" type="text/css" href="css/mobile_lock.css">
    
    <title>Brighter Hires - Loading...</title>
    
<style>
.loader {
  border: 8px solid silver;
  border-radius: 50%;
  border-top: 8px solid white;
  width: 50px;
  height: 50px;
  -webkit-animation: spin 0.5s linear infinite; /* Safari */
  animation: spin 0.5s linear infinite;
    position:relative;
    left:calc(50% - 25px);
    top:50px;
}
    
.center_children {
    text-align:center;
    width:100%;
    height:100px;
}
    
body {
    background-color:white;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
</head>
<body>

<div class="center_children">
    <div class="loader"></div>    
</div>

</body>
</html>
