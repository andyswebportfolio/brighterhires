<?php

//////////////////////////////////////////////////////////////////////////////////////
//Pseudocode
//////////////////////////////////////////////////////////////////////////////////////

//Administer the system for bad listings at regular intervals

//Set min to a number in a range



//If there are more than min people reporting, and it's over 10% of all ip views, take down the listing, refund the user

//////////////////////////////////////////////////////////////////////////////////////
//Initialise
//////////////////////////////////////////////////////////////////////////////////////

session_start();

define('unlock_includes', TRUE);
include '../functions.php';
include '../mail_settings.php';
include '../mail_functions.php';

//////////////////////////////////////////////////////////////////////////////////////
//Spinner Animation
//////////////////////////////////////////////////////////////////////////////////////

$_SESSION['show_loading'] = 1;
include '../loading.php';
unset($_SESSION['show_loading']);

//////////////////////////////////////////////////////////////////////////////////////
//Loop and Logic
//////////////////////////////////////////////////////////////////////////////////////

//Get the table length
$table_length = pdo_return("SELECT `id` FROM `listed_jobs` WHERE `id` ");
$table_length = count($table_length);

//Set hard limit on min number of views
$hard_lower_limit = 5;

//Create a loop for the cron job
for ($i=0; $i<=$table_length; $i++) {
   
   //Get required data for 1st Check
   $listing_ip_views = pdo_return("SELECT `unique_ip_hits` FROM `listed_jobs` WHERE `id` = ".$i." ")[0];
   
   if ($listing_ip_views > 0) {
    //Get how much of a percentage reported it versus how many viewed it
      $reported_views = pdo_return("SELECT `unique_ip_reports` FROM `listed_jobs` WHERE `id` = ".$i." ")[0];
      //echo $reported_views;
      //echo $listing_ip_views;
      
      $percent_reported = round( $listing_ip_views / $reported_views , 1);
      
      if ( ($percent_reported >= 10) && ( $reported_views >= 10) ) {
         $listing_refund = 1;
         echo 'removal would occur here';
         echo $percent_reported;
         
         // Get the stripe unique id
         $stripe_id = pdo_return("SELECT `stripe_id` FROM `listed_jobs` WHERE `id` = ".$i." ")[0]; 
         
         // Get the username of the listing
         $username = pdo_return("SELECT `username` FROM `listed_jobs` WHERE `id` = ".$i." ")[0];

         //Use that to get the email address
         $deleted_listing_email = pdo_return("SELECT `email` FROM `users` WHERE `username` = '".$username."' ")[0];

         // Add 1 to the counter for report emails sent
         // Get report_emails_sent
         $report_emails_sent = pdo_return("SELECT `report_emails_sent` FROM `listed_jobs` WHERE `id` = '".$i."' ")[0];         
         // Add 1 to it
         $report_emails_sent++;
         //Upload the new number
         pdo_delete_or_update_v1("UPDATE `listed_jobs` SET `report_emails_sent`='".$report_emails_sent."' WHERE `id` = '".$i."' ");
         
         
         // If there was a stripe id, tell stripe to refund the user, cancel any subscriptions
         if ($stripe_id != '') {
          require_once('../stripe/init.php');
          \Stripe\Stripe::setApiKey($_SESSION["stripe_private_key"]);
            
          //Refund everything to the user
          //-----------------------------
          //Get every invoice for the customer, where the subscription id is right
          $data = \Stripe\Invoice::all(['subscription' => $stripe_id]);

          //Get how many entries there are, enter it in for loop
          //Get each charge id, and push it to an array

          $charge_ids_array = array();

          for ($j=0; $j<count($data['data']); $j++) {
             array_push($charge_ids_array,$data['data'][$j]['charge']);   
          }

          //Refund each charge, one by one
          for ($j=0; $j<count($charge_ids_array); $j++) {
             \Stripe\Refund::create([
              'charge' => $charge_ids_array[$j],
            ]);
          }
            
          //Cancel the subscription
          //-----------------------------
          $subscription = \Stripe\Subscription::retrieve($stripe_id);
          $subscription->cancel();
         }


         // Email the user explaining what happened
         
         
         //Email Section STARTS (1 of 2 in document)
         
         
         //////////////////////////////////////////////////////////////////////////////////////
//Sending Email to User
//////////////////////////////////////////////////////////////////////////////////////
//Copied directly from working file

//Get username and hash for email link 

//set session username and session login token from signup page
//recall them here

$y = $_SESSION['username'];

$z = pdo_statement_v2("SELECT signup_hash FROM verify_account WHERE username='".$y."'");




//create url to add to email link
                
                
                //Set recipient
                $to = pdo_return("SELECT `email` FROM `users` WHERE `username` = '".$_SESSION['username']."' ")[0];

                //Set subject
                $subject = "Thank You For Reporting.";

                //Set image in email
                 $img_src_1 = 'https://www.brighterhires.online/emails/images/logo.png';


               //Set text

               $header1 = 'Thank you!';
               $header2 = 'Your report was successful.';
               $text_body = 'This email confirms the site has recieved your report, and will take any and all appropriate action. Thank you for using Brighter Hires.';
               $button_text = 'Back to Site >';
               $bottom_text = 'This is an automated email. Please do not reply to it.';
               if ($_SERVER['HTTP_HOST'] == 'localhost:8888') {
                $button_link = 'http://localhost:8888/index.php';
               } else {
                $button_link = 'https://www.brighterhires.online';
               }

               
               

                
   
            
                /*escape every ' and " inside a html email template with a backslash, then add it to the variable.*/
            


                //$message = (file_get_contents('verify_account_email.php'));
            
                $message = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional //EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\" xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\"><head>
    <!--[if gte mso 9]><xml>
     <o:OfficeDocumentSettings>
      <o:AllowPNG/>
      <o:PixelsPerInch>96</o:PixelsPerInch>
     </o:OfficeDocumentSettings>
    </xml><![endif]-->
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
    <meta name=\"viewport\" content=\"width=device-width\">
    <!--[if !mso]><!--><meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"><!--<![endif]-->
    <title></title>
    <!--[if !mso]><!-- -->
	<link href=\"https://fonts.googleapis.com/css?family=Lato\" rel=\"stylesheet\" type=\"text/css\">
	<!--<![endif]-->
    
    <style type=\"text/css\" id=\"media-query\">
      body {
  margin: 0;
  padding: 0; }

table, tr, td {
  vertical-align: top;
  border-collapse: collapse; }

.ie-browser table, .mso-container table {
  table-layout: fixed; }

* {
  line-height: inherit; }

a[x-apple-data-detectors=true] {
  color: inherit !important;
  text-decoration: none !important; }

[owa] .img-container div, [owa] .img-container button {
  display: block !important; }

[owa] .fullwidth button {
  width: 100% !important; }

[owa] .block-grid .col {
  display: table-cell;
  float: none !important;
  vertical-align: top; }

.ie-browser .num12, .ie-browser .block-grid, [owa] .num12, [owa] .block-grid {
  width: 500px !important; }

.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
  line-height: 100%; }

.ie-browser .mixed-two-up .num4, [owa] .mixed-two-up .num4 {
  width: 164px !important; }

.ie-browser .mixed-two-up .num8, [owa] .mixed-two-up .num8 {
  width: 328px !important; }

.ie-browser .block-grid.two-up .col, [owa] .block-grid.two-up .col {
  width: 250px !important; }

.ie-browser .block-grid.three-up .col, [owa] .block-grid.three-up .col {
  width: 166px !important; }

.ie-browser .block-grid.four-up .col, [owa] .block-grid.four-up .col {
  width: 125px !important; }

.ie-browser .block-grid.five-up .col, [owa] .block-grid.five-up .col {
  width: 100px !important; }

.ie-browser .block-grid.six-up .col, [owa] .block-grid.six-up .col {
  width: 83px !important; }

.ie-browser .block-grid.seven-up .col, [owa] .block-grid.seven-up .col {
  width: 71px !important; }

.ie-browser .block-grid.eight-up .col, [owa] .block-grid.eight-up .col {
  width: 62px !important; }

.ie-browser .block-grid.nine-up .col, [owa] .block-grid.nine-up .col {
  width: 55px !important; }

.ie-browser .block-grid.ten-up .col, [owa] .block-grid.ten-up .col {
  width: 50px !important; }

.ie-browser .block-grid.eleven-up .col, [owa] .block-grid.eleven-up .col {
  width: 45px !important; }

.ie-browser .block-grid.twelve-up .col, [owa] .block-grid.twelve-up .col {
  width: 41px !important; }

@media only screen and (min-width: 520px) {
  .block-grid {
    width: 500px !important; }
  .block-grid .col {
    vertical-align: top; }
    .block-grid .col.num12 {
      width: 500px !important; }
  .block-grid.mixed-two-up .col.num4 {
    width: 164px !important; }
  .block-grid.mixed-two-up .col.num8 {
    width: 328px !important; }
  .block-grid.two-up .col {
    width: 250px !important; }
  .block-grid.three-up .col {
    width: 166px !important; }
  .block-grid.four-up .col {
    width: 125px !important; }
  .block-grid.five-up .col {
    width: 100px !important; }
  .block-grid.six-up .col {
    width: 83px !important; }
  .block-grid.seven-up .col {
    width: 71px !important; }
  .block-grid.eight-up .col {
    width: 62px !important; }
  .block-grid.nine-up .col {
    width: 55px !important; }
  .block-grid.ten-up .col {
    width: 50px !important; }
  .block-grid.eleven-up .col {
    width: 45px !important; }
  .block-grid.twelve-up .col {
    width: 41px !important; } }

@media (max-width: 520px) {
  .block-grid, .col {
    min-width: 320px !important;
    max-width: 100% !important;
    display: block !important; }
  .block-grid {
    width: calc(100% - 40px) !important; }
  .col {
    width: 100% !important; }
    .col > div {
      margin: 0 auto; }
  img.fullwidth, img.fullwidthOnMobile {
    max-width: 100% !important; }
  .no-stack .col {
    min-width: 0 !important;
    display: table-cell !important; }
  .no-stack.two-up .col {
    width: 50% !important; }
  .no-stack.mixed-two-up .col.num4 {
    width: 33% !important; }
  .no-stack.mixed-two-up .col.num8 {
    width: 66% !important; }
  .no-stack.three-up .col.num4 {
    width: 33% !important; }
  .no-stack.four-up .col.num3 {
    width: 25% !important; }
  .mobile_hide {
    min-height: 0px;
    max-height: 0px;
    max-width: 0px;
    display: none;
    overflow: hidden;
    font-size: 0px; } }

    </style>
</head>
<body class=\"clean-body\" style=\"margin: 0;padding: 0;-webkit-text-size-adjust: 100%;background-color: #FFFFFF\">
  <style type=\"text/css\" id=\"media-query-bodytag\">
    @media (max-width: 520px) {
      .block-grid {
        min-width: 320px!important;
        max-width: 100%!important;
        width: 100%!important;
        display: block!important;
      }

      .col {
        min-width: 320px!important;
        max-width: 100%!important;
        width: 100%!important;
        display: block!important;
      }

        .col > div {
          margin: 0 auto;
        }

      img.fullwidth {
        max-width: 100%!important;
      }
			img.fullwidthOnMobile {
        max-width: 100%!important;
      }
      .no-stack .col {
				min-width: 0!important;
				display: table-cell!important;
			}
			.no-stack.two-up .col {
				width: 50%!important;
			}
			.no-stack.mixed-two-up .col.num4 {
				width: 33%!important;
			}
			.no-stack.mixed-two-up .col.num8 {
				width: 66%!important;
			}
			.no-stack.three-up .col.num4 {
				width: 33%!important;
			}
			.no-stack.four-up .col.num3 {
				width: 25%!important;
			}
      .mobile_hide {
        min-height: 0px!important;
        max-height: 0px!important;
        max-width: 0px!important;
        display: none!important;
        overflow: hidden!important;
        font-size: 0px!important;
      }
    }
  </style>
  <!--[if IE]><div class=\"ie-browser\"><![endif]-->
  <!--[if mso]><div class=\"mso-container\"><![endif]-->
  <table class=\"nl-container\" style=\"border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: #FFFFFF;width: 100%\" cellpadding=\"0\" cellspacing=\"0\">
	<tbody>
	<tr style=\"vertical-align: top\">
		<td style=\"word-break: break-word;border-collapse: collapse !important;vertical-align: top\">
    <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td align=\"center\" style=\"background-color: #FFFFFF;\"><![endif]-->

    <div style=\"background-color:transparent;\">
      <div style=\"Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;\" class=\"block-grid\">
        <div style=\"border-collapse: collapse;display: table;width: 100%;background-color:transparent;\">
          <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"background-color:transparent;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width: 500px;\"><tr class=\"layout-full-width\" style=\"background-color:transparent;\"><![endif]-->

              <!--[if (mso)|(IE)]><td align=\"center\" width=\"500\" style=\" width:500px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:15px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><![endif]-->
            <div class=\"col num12\" style=\"min-width: 320px;max-width: 500px;display: table-cell;vertical-align: top;\">
              <div style=\"background-color: transparent; width: 100% !important;\">
              <!--[if (!mso)&(!IE)]><!--><div style=\"border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:15px; padding-right: 0px; padding-left: 0px;\"><!--<![endif]-->

<br>
                  
                    <div align=\"center\" class=\"img-container center fixedwidth \" style=\"padding-right: 20px; padding-left: 20px;\">
<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr style=\"line-height:0px;line-height:0px;\"><td style=\"padding-right: 20px; padding-left: 20px;\" align=\"center\"><![endif]-->
<img class=\"center fixedwidth\" align=\"center\" border=\"0\" src=".$img_src_1." alt=\"Image\" title=\"Image\" style=\"outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: block !important;border: 0;height: auto;float: none;width: 100%;max-width: 275px\" width=\"275\">
<!--[if mso]></td></tr></table><![endif]-->
</div>

<br>

                  
                  
                    <div class=\"\">
	<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;\"><![endif]-->
	<div style=\"color:#00d2b9;font-family:\'Lato\', Tahoma, Verdana, Segoe, sans-serif;line-height:120%; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;\">	
		<div style=\"line-height:14px;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;font-size:12px;color:#42dcff;text-align:left;\"><p style=\"margin: 0;line-height: 14px;text-align: center;font-size: 12px\"><span style=\"font-size: 30px; line-height: 36px;\">".$header1."</span></p></div>
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>

<br>

                  
                  
                    <div class=\"\">
	<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 30px; padding-left: 30px; padding-top: 20px; padding-bottom: 15px;\"><![endif]-->
	<div style=\"color:#555555;font-family:\'Lato\', Tahoma, Verdana, Segoe, sans-serif;line-height:120%; padding-right: 30px; padding-left: 30px; padding-top: 10px; padding-bottom: 10px;\">	
		<div style=\"font-familyTahoma, Verdana, Segoe, sans-serif;line-height:14px;font-size:12px;color:#555555;text-align:left;\"><p style=\"margin: 0;line-height: 14px;text-align: center;font-size: 12px\"><span style=\"font-size: 24px; line-height: 40px;\"><em>".$header2."</em></span><span style=\"font-size: 34px; line-height: 40px;\"><em></em></span></p><p style=\"margin: 0;line-height: 14px;text-align: center;font-size: 12px\"><span style=\"font-size: 34px; line-height: 40px;\"><em><br data-mce-bogus=\"1\"></em></span></p></div>	
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>


                  
                  
                    <div class=\"\">
	<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 5px;\"><![endif]-->
	<div style=\"color:#00d2b9;font-family:\'Lato\', Tahoma, Verdana, Segoe, sans-serif;line-height:120%; padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 5px;\">	
		<div style=\"line-height:14px;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;font-size:12px;color:#002287;text-align:left;\"><p style=\"margin: 0;line-height: 14px;text-align: center;font-size: 12px\"><span style=\"font-size: 22px; line-height: 26px;\">".$text_body."</span></p><p style=\"margin: 0;line-height: 14px;text-align: center;font-size: 12px\"><span style=\"font-size: 22px; line-height: 26px;\"></span></p></div>	
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>



<br>
     
     <div align=\"center\" class=\"button-container center \" style=\"padding-right: 10px; padding-left: 10px; padding-top:10px; padding-bottom:10px;\">
  <!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top:10px; padding-bottom:10px;\" align=\"center\"><v:roundrect xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" href=\"".$button_link." style=\"height:31pt; v-text-anchor:middle; width:82pt;\" arcsize=\"0%\" strokecolor=\"#00d2b9\" fillcolor=\"#00d2b9\"><w:anchorlock/><v:textbox inset=\"0,0,0,0\"><center style=\"color:#ffffff; font-family:Arial, \'Helvetica Neue\', Helvetica, sans-serif; font-size:16px;\"><![endif]-->
    <a href=\"".$button_link."\"target=\"_blank\" style=\"display: block;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #000000; background-color: #61ff66; border-radius: 0px; -webkit-border-radius: 0px; -moz-border-radius: 0px; max-width: 110px; width: 70px;width: auto; border-top: 0px solid #A5CEA3; border-right: 0px solid #A5CEA3; border-bottom: 0px solid #A5CEA3; border-left: 0px solid #A5CEA3; padding-top: 5px; padding-right: 20px; padding-bottom: 5px; padding-left: 20px; font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;mso-border-alt: none;border-radius:5px;\">
      <span style=\"font-size:16px;line-height:32px;\">".$button_text."</span>
    </a>
  <!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->
</div>
                  
                    <div class=\"\">
	<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;\"><![endif]-->
	<div style=\"color:#989898;font-family:Arial, \'Helvetica Neue\', Helvetica, sans-serif;line-height:120%; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;\">	
		<div style=\"font-size:12px;line-height:14px;color:#989898;font-family:Arial, \'Helvetica Neue\', Helvetica, sans-serif;text-align:left;\"><p style=\"margin: 0;font-size: 14px;line-height: 17px;text-align: center\"><!--placeholder asdfasdf text--></p><p style=\"margin: 0;font-size: 14px;line-height: 17px;text-align: center\">".$bottom_text."</p></div>	
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>
                  
                  


                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>    <div style=\"background-color:#00d2b9;\">
      <div style=\"Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;\" class=\"block-grid \">
        <div style=\"border-collapse: collapse;display: table;width: 100%;background-color:transparent;\">
          <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"background-color:#00d2b9;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width: 500px;\"><tr class=\"layout-full-width\" style=\"background-color:transparent;\"><![endif]-->

              <!--[if (mso)|(IE)]><td align=\"center\" width=\"500\" style=\" width:500px; padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><![endif]-->
            <div class=\"col num12\" style=\"min-width: 320px;max-width: 500px;display: table-cell;vertical-align: top;\">
              <div style=\"background-color: transparent; width: 100% !important;\">
              <!--[if (!mso)&(!IE)]><!--><div style=\"border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;\"><!--<![endif]-->

                  
                    
<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" class=\"divider \" style=\"border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%\">
    <tbody>
        <tr style=\"vertical-align: top\">
            <td class=\"divider_inner\" style=\"word-break: break-word;border-collapse: collapse !important;vertical-align: top;padding-right: 0px;padding-left: 0px;padding-top: 0px;padding-bottom: 0px;min-width: 100%;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%\">
                <table class=\"divider_content\" align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\" style=\"border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 0px solid transparent;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%\">
                    <tbody>
                        <tr style=\"vertical-align: top\">
                            <td style=\"word-break: break-word;border-collapse: collapse !important;vertical-align: top;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%\">
                                <span></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>    <div style=\"background-color:#F2F8F9;\">
      <div style=\"Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;\" class=\"block-grid \">
        <div style=\"border-collapse: collapse;display: table;width: 100%;background-color:transparent;\">
          <!--[if (mso)|(IE)]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"background-color:#F2F8F9;\" align=\"center\"><table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" style=\"width: 500px;\"><tr class=\"layout-full-width\" style=\"background-color:transparent;\"><![endif]-->

              <!--[if (mso)|(IE)]><td align=\"center\" width=\"500\" style=\" width:500px; padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px; border-top: 0px solid #5ACEE1; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;\" valign=\"top\"><![endif]-->
            <div class=\"col num12\" style=\"min-width: 320px;max-width: 500px;display: table-cell;vertical-align: top;\">
              <div style=\"background-color: transparent; width: 100% !important;\">
              <!--[if (!mso)&(!IE)]><!--><div style=\"border-top: 0px solid #5ACEE1; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;\"><!--<![endif]-->

                  
                    <div class=\"\">
	<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;\"><![endif]-->
	<div style=\"color:#555555;font-family:Arial, \'Helvetica Neue\', Helvetica, sans-serif;line-height:120%; padding-right: 10px; padding-left: 10px; padding-top: 10px; padding-bottom: 10px;\">	
		<div style=\"font-size:12px;line-height:14px;color:#555555;font-family:Arial, \'Helvetica Neue\', Helvetica, sans-serif;text-align:left;\"><p style=\"margin: 0;font-size: 14px;line-height: 17px;text-align: center\"><!--placeholder text 2 asdfasdf--></p></div>	
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>
                  
              <!--[if (!mso)&(!IE)]><!--></div><!--<![endif]-->
              </div>
            </div>
          <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
        </div>
      </div>
    </div>   <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
		</td>
  </tr>
  </tbody>
  </table>
  <!--[if (mso)|(IE)]></div><![endif]-->


</body></html>";

               $headers  = "From: Brighter Hires";
                //$headers .= "Cc: testsite < mail@testsite.com >\n"; 
                $headers .= "X-Sender:Brighter Hires Auto < no address >\n";
                $headers .= 'X-Mailer: PHP/' . phpversion();
                $headers .= "X-Priority: 1\n"; // Urgent message!
                //$headers .= "Return-Path: mail@testsite.com\n"; // Return path for errors
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=iso-8859-1\n";
                //$headers .= 'Cc: myboss@example.com' . "\r\n";

            
            

               //Send the email

               mail($to,$subject,$message,$headers);
               //Unset everything for next email
               unset($to);
               unset($subject);
               unset($message);
               unset($headers);


//////////////////////////////////////////////////////////////////////////////////////
//Sending Email to internal system
//////////////////////////////////////////////////////////////////////////////////////

//Set recipient
$internal_to = 'msg.brighterhires@gmail.com';

//Set subject
$subject = "Listing Report";

//Get user email

$user_email_address = pdo_return("select `email` from `users` WHERE `username` ='".$_SESSION['username']."'")[0];

//escape every ' and " inside a html email template with a backslash, then add it to the variable.

//Shorten the comment.

$_POST['comment'] = substr($_POST['comment'],0,1024);

//XSS, Just in case
$_POST['comment'] = htmlentities($_POST['comment'], ENT_QUOTES, 'UTF-8');
            
$message = "The user ".$_SESSION['username']." send a report about a listing at ".date('m/d/Y h:i:s a', time())."<br><br>

<h2>User Email: ".$user_email_address."</h2>
                
<h1>Message:</h1>
<br>
".$_POST['comment'];

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
//$headers .= 'Internal Brighter Hires Site System <welcome>' . PHP_EOL .
                
//'X-Mailer: PHP/' . phpversion();
//$headers .= 'Cc: myboss@example.com' . "\r\n";

//Send the email
mail($internal_to,$subject,$message,$headers);
         
         
         //Email Section ENDS (1 of 2 in document)

      }
      /*
      if ($percent_reported >= 7.5 && (!isset($listing_refund)) && ( $reported_views >= 5 )) {
         
         
         
         //Check if an email was already sent
         $email_count = pdo_return("SELECT `report_emails_sent` FROM `listed_jobs` WHERE `id` = ".$i." ")[0];
         
         echo $email_count;
         //If it was not, send it, tell the database to add 1 to the email count
         if ($email_count < 1) {
            echo 'send the first email, add to the count';
         }
         
         //Upload that an email was sent
         //Upload the time the email was sent
         
         
         //Check if it's been a week, alert the user again if it has with a different, recurring email that they are still at risk
         
      }
      */
      
   }
   
   //If the amount of views is over x

   
   //And if the amount of people looking is 
 
}

//For the length of the table, do the processes

//Find out if there are more than 7.5%

?>