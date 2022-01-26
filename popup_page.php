<?php 
 session_start();
 define('unlock_includes', TRUE);
 include 'functions.php';
 include 'settings.php';
 include 'ip_security_lockout.php';
?>



<!doctype html>
<html>
    <?php require 'head_tag.php';?>
    <body>
        
        <?php include 'header.php';?>
        <div id="popup_test">
            <?php include 'popup.php';?>
        </div>
        
        <div class="content" id="index">
        
        </div>
        
        
        <?php include 'footer.php'?>
        <?php include 'functions_js.php'?>
        
        
    </body>
</html>

<script>
    var element = document.getElementById('popup_box');
    //alert(element.childNodes[1]);
    
    var type = typeof element.childNodes[1];
    
    if (type == 'undefined') {
        window.location.replace('/index.php');
    }
</script>
