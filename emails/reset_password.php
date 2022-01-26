<?php

//! IMPORTANT! This, like all email, may not work offline, but will work when uploaded.

//`````````````````````````````````````````````````````````````````````````
// -- This page can use local variables from the place it is included.                          :
// It is included in the page /submit/reset_password.php                                        :
//The user will be told the page does not exist if they try to access it without a PHP unlock.  :
//`````````````````````````````````````````````````````````````````````````

//.........................................................................
//Security
//.........................................................................

//Pushes back if the unlock isn't set

if (!isset($_SESSION['unlock_email'])) {
 push_back_instant('../404.php');
}
unset($_SESSION['unlock_email']);



//.........................................................................
//Email
//.........................................................................
//Part 1 of 3 - Settings

//Header
$title_font_colour = 'RGB(235, 113, 0)'; //Add this as if you're saying in css #id { color = $title_font_colour }

//Secondary Header
$secondary_header_colour = 'RGB(77, 74, 0)';

//Header Image
$img_src_1 = 'https://www.brighterhires.online/emails/images/logo_large_square_1-5.png';

//Text
$to = $user_email;
$subject = 'Reset Your Password';

if ($_SERVER['HTTP_HOST'] == 'localhost:8888') {
 $button_link = 'http://localhost:8888/change_password.php?y='.$username.'&z='.$reset_hash;
} else {
 $button_link = 'https://www.brighterhires.online/change_password.php?y='.$username.'&z='.$reset_hash;
}




$headline = 'Password Reset';
$headline_2 = 'You can set a new, secure password using this email.';
$main_text = 'To set a new password for your account, simply click the button below.';
$low_text = 'If you do not want to reset your password, simply ignore this email.';
$button_text = 'Reset';


//..........................................................................................
//Part 2 of 3 - HTML and CSS Code
            
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
		<div style=\"line-height:14px;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;font-size:12px;color:".$title_font_colour.";text-align:left;\"><p style=\"margin: 0;line-height: 14px;text-align: center;font-size: 12px\"><span style=\"font-size: 30px; line-height: 36px;\">".$headline."</span></p></div>
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>

<br>

                  
                  
                    <div class=\"\">
	<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 30px; padding-left: 30px; padding-top: 20px; padding-bottom: 15px;\"><![endif]-->
	<div style=\"color:#555555;font-family:\'Lato\', Tahoma, Verdana, Segoe, sans-serif;line-height:120%; padding-right: 30px; padding-left: 30px; padding-top: 10px; padding-bottom: 10px;\">	
		<div style=\"font-familyTahoma, Verdana, Segoe, sans-serif;line-height:14px;font-size:12px;color:#555555;text-align:left;\"><p style=\"margin: 0;line-height: 14px;text-align: center;font-size: 12px\"><span style=\"font-size: 24px; line-height: 40px;\"><em>".$headline_2."</em></span><span style=\"font-size: 34px; line-height: 40px;\"><em></em></span></p><p style=\"margin: 0;line-height: 14px;text-align: center;font-size: 12px\"><span style=\"font-size: 34px; line-height: 40px;\"><em><br data-mce-bogus=\"1\"></em></span></p></div>	
	</div>
	<!--[if mso]></td></tr></table><![endif]-->
</div>


                  
                  
                    <div class=\"\">
	<!--[if mso]><table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td style=\"padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 5px;\"><![endif]-->
	<div style=\"color:#00d2b9;font-family:\'Lato\', Tahoma, Verdana, Segoe, sans-serif;line-height:120%; padding-right: 0px; padding-left: 0px; padding-top: 0px; padding-bottom: 5px;\">	
		<div style=\"line-height:14px;font-family:Lato, Tahoma, Verdana, Segoe, sans-serif;font-size:12px;color:".$secondary_header_colour.";text-align:left;\"><p style=\"margin: 0;line-height: 14px;text-align: center;font-size: 12px\"><span style=\"font-size: 22px; line-height: 26px;\">".$main_text." </span></p><p style=\"margin: 0;line-height: 14px;text-align: center;font-size: 12px\"><span style=\"font-size: 22px; line-height: 26px;\"></span></p></div>	
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
		<div style=\"font-size:12px;line-height:14px;color:#989898;font-family:Arial, \'Helvetica Neue\', Helvetica, sans-serif;text-align:left;\"><p style=\"margin: 0;font-size: 14px;line-height: 17px;text-align: center\"><!--placeholder asdfasdf text--></p><p style=\"margin: 0;font-size: 14px;line-height: 17px;text-align: center\">".$low_text."</p></div>	
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

//..........................................................................................
//Part 3 of 3 - Technical Sending Details

                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                // More headers
                $headers .= 'From: Brighter Hires <welcome>' . PHP_EOL .
                
                'X-Mailer: PHP/' . phpversion();
                //$headers .= 'Cc: myboss@example.com' . "\r\n";
            
               //Send the message
               mail($to,$subject,$message,$headers);
                
               //Show the message [debugging only]
               //echo $message;
               
               //Notify Session, and redirect
            
             $_SESSION['email_sent_2'] = 1;
             echo "<script>
              window.location = '../popup_page.php';
             </script>";
?>