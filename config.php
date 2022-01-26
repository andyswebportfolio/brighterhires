<?php

if (!defined('unlock_includes')) {
 include('404.php');
}

include 'ip_security_lockout.php';

foreach (get_included_files() as $item ) {        
    $string = 'functions.php';
    if (strpos($item, $string) == false) {
     include_once 'functions.php';
    }
    unset($string);
}

require_once('vendor/autoload.php');



$stripe = [
  "secret_key"      => "sk_live_HtXeVOMan5WLsWVEWGacE1Yc",
  "publishable_key" => "pk_live_i6DkhFTYlCg0vaxEWMctlwws",
];

/*
$stripe = [
  "secret_key"      => "sk_test_sK1cUbPWSUD23tPO2vytjiGr",
  "publishable_key" => "pk_test_Aev0FVzlOtzW7e963ogr9ic8",
];
*/
    

\Stripe\Stripe::setApiKey($stripe['secret_key']);


?>