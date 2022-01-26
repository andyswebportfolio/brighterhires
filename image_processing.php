<?php 

session_start();
define('unlock_includes', TRUE);

include 'functions.php';
include 'ip_security_lockout.php';
?>

<!doctype html>
<html>
 
 <?php
if(!defined('unlock_includes')) {
 http_response_code(404);
 include('404.php'); // provide your own HTML for the error page
 die();
}
 
if (!isset($_SESSION['unique_url'])) {
 $_SESSION['error'] = 1;
 $_SESSION['error_type'] = 'link_invalid_2';
}



//If a user is not logged in,
//push back

if (!isset($_SESSION['logged_in'])) {
 $_SESSION['login_required_message'] = 1;
 push_back_instant('../index.php');
}
 
?>

 <?php require 'head_tag.php';?>
 
 <body>
  <?php include 'header_plain.php';?>    
  <?php include_error_reporting();?>
  
  <?php
   
   //Setting image path of croppie box


   if(isset($_SESSION['uploaded_file_path'])) {
    
    
    //if uploaded file path contains the unique url for this listing
    
    $findme    = $_SESSION['unique_url'];
    $mystring1 = $_SESSION['uploaded_file_path'];
    $mystring1 = substr($mystring1, 0, strpos($mystring1, "."));

    $pos1 = stripos($mystring1, $findme);

     // Nope, 'a' is certainly not in 'xyz'
     if ($pos1 === false) {
         //echo "The string '$findme' was not found in the string '$mystring1'";
         $croppy_image_path = '/img/forms/blank.png';
         $no_upload = 1;
         
     } else {
         //echo "The string '$findme' was found in the string '$mystring1'";
         $croppy_image_path = '/uploads/'.$_SESSION['uploaded_file_path'];
     }
    

    } else {
     $croppy_image_path = '/img/forms/blank.png';
    }

   //get the file extension if a file was uploaded
  
   if ( isset ($_SESSION['ext_file_upload_check'])) {
    //echo $_SESSION['uploaded_file_path'];
     
    $file_ext = $_SESSION['uploaded_file_path'];
    $file_ext = substr( $file_ext, ( $pos = strpos( $file_ext, '.' ) ) === false ? 0 : $pos + 1 );
    
    unset ($_SESSION['ext_file_upload_check']);
   }
  
  //Format file extensions for javascript param
  
   if(isset($file_ext)) {
    if ($file_ext == 'jpe' || $file_ext == 'jpg' || $file_ext == 'jpeg') {
     $file_ext = '"jpeg"';
    } else {
     $file_ext = '"png"';
    }
   } else {
    $file_ext = '"png"';
   }
      
  ?>
        
  <div class="content" id="image_processing">
   
   <div id="upload_form_container">
    <h1 id="upload_logo_header">Upload your logo</h1>
    <div id="container_img_processing">
   
    <label for="file" id="userImage_label">

        <div id="select_file_button" class="row">
         <div class="upload_button_column" id="upload_btn_text"><p>Select A File...</p></div>
         <div class="upload_button_column">
           <img id="upload_icon" src="../img/icons/upload-symbol.png"/>
         </div>
  
        </div>

     </label>
     
     <form action="upload.php" method="POST" enctype="multipart/form-data" id="upload_form">
      <input type="file" name="file" id="file" style="opacity:0; width:0px; height:0px; position:absolute;">
      <button type="submit" name="submit" class="btnSubmit" id="btnSubmit" style="opacity:0; height:0">Upload</button>
     </form>
     <script>
      document.getElementById("file").onchange = function() {
       document.getElementById("btnSubmit").click();
      };
     </script>
     <br>
   
     <div id="main-cropper">
      <div id="cropper-spinner">
       <div class="center_children">
       <div class="loader_2"></div>    
       </div>
      </div>  
     </div>
       
     <br><br>    
       
       <button class="vanilla-rotate rotate_buttons" data-deg="-90" id="rotate_button_l"></button>


     
     <script>
      
      function removeElement(elementId) {
       // Removes an element from the document
       var element = document.getElementById(elementId);
       element.parentNode.removeChild(element);
      }
      
      window.onload = function() {
       setTimeout(function(){ 
        removeElement('cropper-spinner');
       }, 500);
      }
     </script>
     
    
   
     <script>
      
      //Check when window is resized. If it crosses the boundary for mobile,
      //remove the zoomer from the croppie plugin.
      //If it crosses it the other way, add the zoomer back in.

        var croppieBox = $('#main-cropper').croppie({
            viewport: { width: 300, height: 300 },
            boundary: { width: 320, height: 320 },
            enableOrientation: true,

            update: function (data) {
               

               
             var coords = $('#main-cropper').croppie('get');
             
             //alert ( JSON.stringify(coords, null, 4) );
             
             //for data use
             var pointA = coords.points[0];
             var pointB = coords.points[1];
             var pointC = coords.points[2];
             var pointD = coords.points[3];
             var zoom = coords.zoom;
             
             var croppieGet = $('#main-cropper').croppie('result', {
                type: "canvas", 
                
                format: '<?php echo $file_ext;?>'
                

                
             }).then(function (img) {
             document.getElementById("javascript_image_base64").value = img;
             });
             
            }         
        //Close the first part of Croppie
        });

         croppieBox.croppie('bind', {
          url: <?php echo "'".$croppy_image_path."'"; ?>,
         });
        
            //.vanilla-rotate is the HTML button
        $('.vanilla-rotate').on('click', function(ev) {
            //vanilla is the new croppie instance, croppieBox
           var croppieBox = $('#main-cropper');
            croppieBox.croppie('rotate', parseInt($(this).data('deg')));
		});

      
       // get cropped image data
       // get zoom data
       // get crop points data
      
       //send it to php
      
       
      
       </script>
     
     <br>

     
     <form action="submit/image_crop.php" method="post">
      <input type="hidden" name="javascript_image_base64" value ='javascript string' id="javascript_image_base64"><br>
     <input type="submit" onclick="testNewPhp()" class="btnSubmit" id="btnSubmit2">
     </form>
     
     <?php
     
     //Hide the submit button if nothing has been submitted, using javascript
     
     if (isset($no_upload)) {
      echo '<script> document.getElementById("btnSubmit2").style.display = "none" </script>';
     }
     ?>

    </div>
   </div>
         
  </div>

  <?php include 'footer_plain.php'?>
  <?php include 'functions_js.php'?>
        
 </body>
</html>