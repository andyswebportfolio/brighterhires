<?php 
session_start();
define('unlock_includes', TRUE);
include 'functions.php';
include 'ip_security_lockout.php';
login_redirect();

if (isset($_SESSION['unique_url'])) {
 unset($_SESSION['unique_url']);
}

?>



<!doctype html>
<html>
    <head>
        <?php require 'head_tag.php';?>   
    </head>
 
    <body>
        <?php include 'header.php';?>
        <?php 
            if (isset($_SESSION['password_changed'])) {
                include 'popup.php';
            }
            if (isset($_SESSION['listing_unfinished'])) {
                include 'popup.php';
            }
            if (isset($_SESSION['no_edit_selected'])) {
                include 'popup.php';
            }
            if (isset($_SESSION['listing_updated'])) {
                include 'popup.php';
            }
        ?>
        <div class="content" id="my_account">
         <?php include_error_reporting();?>
            <div class="outer">
                <div id="outer__title">
                 <h1><?php header_name();?>'s Account</h1>
                </div>
                <div class="underline2 underline2--higher"></div>
                
                <br>
 
                <div class="row_container">
                

                        <div class="account_column">
                            <div class="column_title_1">
                                My Details
                            </div>
                            <div class="underline2"></div>
                            <?php 
                            
                                $sql_col_names = array(
                                    'first_name',
                                    'middle_name',
                                    'last_name',
                                    'username',
                                    'email',
                                    'uk_date',
                                );
                            
                                $display_names = array(
                                    'First Name',
                                    'Middle Name(s)',
                                    'Surname',
                                    'Username',
                                    'Email',
                                    'Account Created'
                                );

                                $table = 'users';
                            
                                $arr_1 = get_pdo_data($table,$sql_col_names);
                            
                                if ($arr_1[1] == '') {
                                 $arr_1[1] = '<p>None</p>';
                                }
                                
                                
                            
                                //pre($arr_1);
                            
                            
                                for ($i=0; $i<count($arr_1); $i++) {
                                    echo '
                                        <div class="data_box_header_1">
                                        '.$display_names[$i].': 
                                        '.string_shortener($arr_1[$i],23,1).
                                        
                                        '
                                        </div>
                                    ';
                                }
                            ?>
                            
                            <div class="underline2_1"></div>
                            
                            <div class="column_footer_1">
                                <div class="button_array_1">
                                    <a href="edit_account_details.php">Edit</a>
                                    <a href="close_account.php">Close Account</a>
                                </div>
                            </div><br>
                        </div>
                 
                        <br>
                 
                        <div class="account_column" id="saved_jobs">
                         <div class="column_title_1">
                          Saved Jobs
                         </div>
                         <div class="underline2">
                         </div>
                         <div class="underline3"></div>
                         <div id="full_width_search_div">
                          <form class="example" action="javascript:void(0);" id="saved_jobs_search_form">
                           <input type="text" placeholder="Search Saved Jobs..." name="search" id="saved_jobs_text_input">
                           <button type="submit" class="no_hand" id="getSavedJobsButton"><img id="search_icon_2" src="img/header/search_icon.png" alt="search button" /></button>
                          </form>
                         </div>
                         <div id="saved_jobs_display_div">
                          <!--Javascript data is displayed here-->
                         </div>
                         
                           <!--gets hidden if everything is loaded-->
                            <div id="loaderContainerSavedJobs">  
                              <div id="loader" style="position:relative; top:-5px"> 
                              </div>
                                <?php /*$a = new job_listing;
                                $a->run(1);
                                */?>
                            </div>
                         
                         <div id="test_display_div">
                          <!--Javascript data is displayed here-->
                         </div>
                         
                        </div>
     
                 
                    
                        <br>

                        <div class="account_column">
                            <div class="column_title_1">
                                Listed Jobs
                            </div>

                            <div class="underline2"></div>
                            <div class="underline3"></div>
                         
                            <div id="full_width_search_div">
                             <form class="example" action="javascript:void(0);" id="listed_jobs_search_form">
                              <input type="text" placeholder="Search Listed Jobs..." name="search" id="listed_jobs_text_input">
                              <button type="submit" id="getListedJobsButton"><img id="search_icon_2" src="img/header/search_icon.png" onclick="" alt="search button"/></button>
                             </form>
                            </div>
                         
                            <?php
      
                            if (count_listed_jobs() < 1) {
                             echo '
                             
                             <script>
                             document.getElementById("listed_jobs_search_form").style.display = "none";
                             </script>
                             
                              <div id="no_listed_jobs_container" style="height:135px";>
                              
                              <p style="position:relative; top:25px;">You have no listed jobs.</p>
                              
                              <div class="underline2_1" style="margin-top:5px; position:relative; top:60px;"></div>
                              
                              <a style= "color:black; display:inline-block; width:150px; padding:5px; position:relative; border-radius:2px; top:75px;" href="list_a_job.php" class="button4">List Job</a>
                              
                              </div>
                             ';
                            }

                            ?>
                            

                            
                            <div id="ajax_results">
                             
                             </div>
                            <!--gets hidden if everything is loaded-->


                            
                        </div>
                    
                </div>
            
            </div>    <br>
        </div>
        

        <?php include 'footer.php'?>
        <?php include 'objects_js.php'?>
        <?php include 'functions_js.php'?>
     
        <?php
        
        //Hide search box that was created in Javascript in functions.js
         //echo count_saved_jobs();
         if (count_saved_jobs() < 3 ) {
          //hide the search box for saved jobs
          echo 
          '<script>
           hide_element("full_width_search_div");
          </script>';
         } 
        ?>
        
        <script>
        </script>
        
        <script>
            
            
        </script>
        

        
    </body>
</html>