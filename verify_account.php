<?php
session_start();
define('unlock_includes', TRUE);
include 'settings.php';
include 'functions.php';
include 'ip_security_lockout.php';

if ( (!isset($_GET['y'])) || (!isset($_GET['z'])) ) {
    push_back_instant('../index.php');
}
    $_GET['z'] = urlencode($_GET['z']);
    
    /*
        echo '<br>Username is '.$_GET['y'].'<br>';
        echo '<br>signup_hash is '.$_GET['z'].'<br>';
    */
    
    if ( (pdo_statement_v2("SELECT username FROM verify_account WHERE username='".$_GET['y']."'") === $_GET['y']) && (hash_equals((pdo_statement_v2("SELECT signup_hash FROM verify_account WHERE username='".$_GET['y']."'")),$_GET['z'])) ) {

        pdo_delete_or_update_v1("DELETE FROM verify_account WHERE username ='".$_GET['y']."'");
        
        $_SESSION['first_login'] = 1;
        $_SESSION['username'] = $_GET['y'];
        $_SESSION['logged_in'] = 1;
        
    } else {
        $_SESSION['email_link_invalid'] = '1';
    }
push_back_instant('../popup_page.php');

?>