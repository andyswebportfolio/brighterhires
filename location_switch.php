<?php
session_start();
define('unlock_includes', TRUE);
include 'functions.php';
$jsData = file_get_contents('php://input');

//If there is an entry for the user php session, update it with a 1 or a 0

$session_id = session_id();

if ($jsData == 1) {
   //the switch is on
   pdo_delete_or_update_v1("UPDATE `user_connections` SET `use_location` = '1' WHERE `session_id` = '".$session_id."'");
}

if ($jsData == 0) {
   //the switch is off
   pdo_delete_or_update_v1("UPDATE `user_connections` SET `use_location` = '0' WHERE `session_id` = '".$session_id."'");
}


//Otherwise, push the user back

 push_back_instant('../404.php');
 exit();

?>