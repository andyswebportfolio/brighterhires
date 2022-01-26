<?php 
session_start();

//if a isn't shown do a 404
 if(!isset($_GET['a'])) {
  http_response_code(404);
  include('404.php'); // provide your own HTML for the error page
  die();
 }

define('unlock_includes', TRUE);
include 'functions.php';
include 'settings.php';
include 'ip_security_lockout.php';

// Don't show page if it has been deleted by the user

if(isset($_GET['a'])) {
 $deleted = pdo_return("SELECT `user_delete_marked` FROM `listed_jobs` WHERE `page_link` = '".$_GET['a']."' ")[0];
} else {
 $deleted = 0;
}




if ($deleted == 1) {
 $_SESSION['error'] = 1;
 $_SESSION['error_type'] = 'link_invalid';
 push_back_instant('index.php');
 exit();
}

//If there is a link, but it's not in the database, push to 404

$id = pdo_return("SELECT id FROM listed_jobs WHERE page_link='".$_GET['a']."'")[0];

if ($id == '') {
   http_response_code(404);
   push_back_instant('/404.php');
}


//Get the user's ip, address, check if it is in the database for this listing

//Record the User's IP Address
 $user_ip = get_real_ip_return();
 //echo $user_ip;
 //Check if this IP has seen the page before
 $ip_array = pdo_return("SELECT `ips_visited` FROM `listed_jobs` WHERE `page_link` = '".$_GET['a']."'")[0];
 $ip_array = json_decode($ip_array, true);
 //pre( $ip_array );

 //Find out if it has seen this ip before
 
 for($i=0; $i<count($ip_array); $i++) {
    if ($ip_array[$i] == $user_ip) {
       $ignore_ip = 1;
    }
 }
 if (!isset($ignore_ip)) {
  $ignore_ip = 0;
 }

 //Only push the ip to the array and update the counter if it's not been counted already
  //If it has, do not update the counter
 if ($ignore_ip == 0) {

$user_ip = get_real_ip_return();
$column = 'ips_visited';
$table = 'listed_jobs';
$unique_column = 'page_link';

 //Download Column
$data = pdo_return("SELECT `".$column."` FROM `".$table."` WHERE `".$unique_column."` = '".$_GET['a']."' ")[0];

//Process Column
$data = json_decode($data, true);
array_push($data,$user_ip);
$data = json_encode($data);
//Upload Column
pdo_delete_or_update_v1("UPDATE `".$table."` SET `".$column."`='".$data."' WHERE `".$unique_column."` = '".$_GET['a']."' ");
    
//Add to hit counter by 1 for unique ips
sql_update_by_1('unique_ip_hits','listed_jobs','page_link');
    
 }

//If it is not, add it to the array and add one to the unique view count

?>

<!doctype html>
<html>
    <head>
     <?php require 'head_tag.php';?>   
    </head>
    <body>
        
        <?php include 'header.php';?>
        
        <?php view_counter_update($_GET['a']); ?>
        
        <?php if (isset($_SESSION['first_login'])) {
                include 'popup.php';
                unset($_SESSION['first_login']);
            }
        
        if (!isset($_GET['a'])) {
            //push_back_instant('index.php');
        }
        
        if(isset($_GET['a'])) {
         $page = $_GET['a'];
         $id = pdo_return("SELECT id FROM listed_jobs WHERE page_link='".$page."'")[0];
         $data = get_listed_jobs_data('job_listing',$id);
        } else {
         $page = null;
         $id = null;
         $data = null;
        }


        ?>
        
        <div class="content" id="job_listing">
        
                <div id="job_listing_header">
                    <h1><?php echo $data[0]['job_title'];?></h1>
                    
                    <div class="underline1"></div>
                    <p id="job_listing_company_name"><?php echo $data[0]['company_name'];?></p>
                    <br>
                    <p id="job_listing_header_location"><?php echo $data[0]['job_location'];?></p>
                </div>
                
                <div id="job_listing_bar">
                    <img src="<?php echo $data[0]['company_logo'];?>"/>
                </div>
                
                <div class="divide1">
                </div>

                <div class="highlight_box highlight_box--padding" id="job_desc">
                    <h1 id="highlight_box_job_desc">Job Description</h1>
                    <div class="underline2"></div>
                    <div class="highlight_box__p">
                     <p><?php echo nl2br($data[0]['job_description']);?></p>
                    </div>
                    
                </div>
                
                <?php
                
                if (isset($data[0]['further_contact_details']) && ($data[0]['further_contact_details'] != '') ) {
                    echo'
                    <div class="highlight_box highlight_box--padding" id="further_contact_details">
                     <h1 id="highlight_box_job_desc">More Details</h1>
                     <div class="underline2"></div>
                     <div class="highlight_box__p">
                      <p>'.nl2br($data[0]['further_contact_details']).'</p>
                     </div>
                    </div>
                    ';
                }
                
                ?>
                
                <div id="contact_bar" class="highlight_box highlight_box--padding">
                 <h1>Contact Details</h1>
                 <div class="underline2"></div>
                 <div class="highlight_box__p">
                         
                  <p>Email: <?php echo $data[0]['contact_email'];?></p>
                  <br>
                  <p>Tel: <?php echo $data[0]['contact_phone'];?></p>
                  <br><br>
                  <p>Location: <?php echo $data[0]['job_location'];?></p>
                  <br>
                  <p>Postcode: <?php echo $data[0]['job_postcode'];?></p>
                  <br>
                  <p>Job Posted: <?php echo $data[0]['day'];?> / <?php echo $data[0]['month'];?> / <?php echo $data[0]['year'];?></p>
                  <br><br>
                  <p>Employer: <?php echo $data[0]['company_name'];?></p>
                  <br>
                 </div>
                </div>
            
                
   
        </div>
        
        <?php






        if (isset($_SESSION['logged_in'])) {

        //Set up link outside of php to avoid use of single quotes in html
        $link = $_GET['a'];

            echo '
                <div id="save_button_bar">
                <div id="save_button_container">
                <a href="submit/save_listing.php?a=<?php echo $link?>"><li class="button4">Save this job</li></a>
                </div>
            </div>
            ';
        }

        ?>



        
        
                <div class="listing_menu">

                 <div>
                  <?php
 
                  //Get the username for the listing
                  $username = pdo_return("SELECT `username` FROM `listed_jobs` WHERE `page_link` = '".$_GET['a']."' ")[0];
                  
                  if (isset ($_SESSION['logged_in']) && $_SESSION['username'] == $username) {
                   echo '
                     <a href="update_listing_select.php?a='.$_GET["a"].'">Edit Listing</a>
                     <p> | </p>
                     <a href="delete_listing.php?a='.$_GET["a"].'">Cancel Listing</a>
                    ';
                  } else {
                    echo '
                    <a href="report_listing.php?a='.$_GET['a'].'">Report This Listing</a>
                    ';
                  }
                  ?>

                     
                 </div>
                </div>
        
        <?php include 'footer.php'?>
        <?php include 'functions_js.php'?>
        
    </body>
</html>