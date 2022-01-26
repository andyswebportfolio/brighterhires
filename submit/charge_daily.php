<?php
  session_start();
  define('unlock_includes', TRUE);
  include '../functions.php';
  fail_if_previous_page_is_not('payment.php');
  require_once('../config.php');



//Cancel any existing stripe subscriptions for this listing
//get stripe subscription
$sub = pdo_return("SELECT `stripe_id` FROM `listed_jobs` WHERE `page_link` = '".$_SESSION['unique_url']."' ")[0];
echo $sub;

//clear stripe subscription
if ($sub !== '') {
 $subscription = \Stripe\Subscription::retrieve($sub);
 $subscription->cancel();
}



if (!isset($_SESSION['unique_url'])) {
    push_back_instant('/index.php');
}

  $token  = $_POST['stripeToken'];
  $email  = $_POST['stripeEmail'];

  $customer = \Stripe\Customer::create([
      'email' => $email,
      'source'  => $token,
  ]);

 $subscription = \Stripe\Subscription::create([
  "customer" => $customer->id,
  "plan" => "pay_daily_123",

]);

//$expiry_time = strtotime('+5 years', time());

$expiry_time = 0;

update_db_v2("UPDATE `listed_jobs` SET `listing_live` = '1', `stripe_id` = '".$subscription['id']."' WHERE `listed_jobs`.`page_link` = '".$_SESSION['unique_url']."';");

//set period
$_SESSION['period'] = 'Daily';

//send email receipt
include '../emails/receipt_job_listing.php';

//set checkout complete
$_SESSION['checkout_complete'] = 1;

//unset unique url
unset($_SESSION['unique_url']);

push_back_instant('../thankyou.php');

?>

