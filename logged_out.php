<?php 

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
include 'functions.php';
//include 'ip_security_lockout.php';

?>

<!doctype html>
<html>
    <?php require 'head_tag.php';?>
    <body>
        <?php 

         redirect_delay('index.php',1);
     
        ?>
        <?php include 'functions_js.php'?> 
        
    </body>
</html>

<?php 
 if (isset($_SESSION['logged_out'])) {
  session_destroy();
  pre($_SESSION);
 }

 
?>
