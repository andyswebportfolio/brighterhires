<?php 
session_start();
define('unlock_includes', TRUE);
include 'functions.php';
include 'ip_security_lockout.php';
?>

<!doctype html>
<html>
    <?php require 'head_tag.php';?>
    <body>
        
        <?php include 'header_plain.php';?>
        <div class="content plain" id="credits">
            
         <div class="content_bg">     
          <div class="title">
           <h1>Credits</h1>
          <div class="underline2"></div>
          </div>
             
          <div class="content_inner_1">
            
              <div>Upload Icon on image crop page made by Flat Icon <br>
              <a href="https://www.flaticon.com/authors/freepik" title="Upload">Upload</a> from <a href="https://www.flaticon.com/"     title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/"     title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a>
              <br>
              <p>Cover Photo by Ali Yahya on Unsplash (Index Page)</p>

            <br>

              <div>Misc. Icons made by <a href="https://www.flaticon.com/authors/those-icons" title="Those Icons">Those Icons</a> from <a href="https://www.flaticon.com/"             title="Flaticon">www.flaticon.com</a></div>
             </div>
              <br>
              
              <p>Design &amp; development by Andy Wells</p>
              <br>

              <p>Initial concept &amp; funding by Danny Osborne</p>
              <br>
 
             

             <br><br>
             <p>SVG Backgrounds from svgbackgrounds.com</p>
             <br>

             <p>Example Icons for Jobs from Freepik</p>
             <a href='freepik.com/vectors/background'>www.freepik.com</a>
             <br>
             <p>SVG Backgrounds from svgbackgrounds.com</p>
             

           <div class="column_footer_1">
            <div class="button_array_1">
             <div class="button_container">
                <button class="button1b" id="back_to_home" onclick='goBack()'>Go Back</button>
             </div>
            </div>
           </div>
          </div>
            
        </div>
        </div>
        
        
        <?php include 'footer.php'?>
        <?php include 'functions_js.php'?> 
        
    </body>
</html>

    