<?php
session_start();

define('unlock_includes', TRUE);

if(!defined('unlock_includes')) {
 http_response_code(404);
 include('404.php'); // provide your own HTML for the error page
 die();
}



if (isset($_POST['submit'])) {
 include 'functions.php';
//Delete any existing file before uploading
 if(isset($_SESSION['uploaded_file_path'])) {
  //echo 'file was uploaded already';
 }


 $file = $_FILES['file'];
 //print_r($file);
 
 
 //Assign file information from $_FILES array
 
 $fileName = $_FILES['file']['name'];
 $fileTmpName = $_FILES['file']['tmp_name'];
 $fileSize = $_FILES['file']['size'];
 $fileError = $_FILES['file']['error'];
 $fileType = $_FILES['file']['type'];
 
 
 //Check MIME Type

 $allowed = array(
 'image/jpeg',
 'image/png'
 );
 
 if (in_array($fileType, $allowed)) {
  //valid
 } else {
  //invalid
 }
   
//Strip rotation data
   
   /// This read the data but does not allow you
   /// to edit it. Imagick is added at the bottom
   /// of this page with intention to get and set
   /// the orientation of images correctly
   /*
   pre( $_FILES );
   

   
   $complete_path = 'uploads/'. $_SESSION['uploaded_file_path'];
      echo $complete_path;

$exif = exif_read_data($complete_path, 1, true);
//pre($exif);
   
   $exif['IFD0']['Orientation'] = '2';
   
   pre( $exif['IFD0']['Orientation'] );
   
   //Change the file path to what is in EXIF
   
   $_SESSION['']
  */
   
   
 //Set allowed file types
 
 $fileExt = explode('.', $fileName);
 $fileActualExt = strtolower(end($fileExt));
  //pdf removed from tutorial
 $allowed = array('jpg','jpeg','png','jpe');
 
 if (in_array($fileActualExt, $allowed)) {
  
  if ($fileError === 0) {
   //max file size 2500mb
   if ($fileSize < 7000000) {
    //set the new file name to a unique string
    $fileNameNew = $_SESSION['unique_url'].".".$fileActualExt;
    $fileDestination = 'uploads/'.$fileNameNew;
    move_uploaded_file($fileTmpName, $fileDestination);
    
    
     //Check Magic Numbers [file signatures]
 
     ///Convert to binary

     $imageContents = file_get_contents('uploads/'.$fileNameNew);
     $hex = bin2hex($imageContents);
     $hex = strtoupper($hex);
     //Spoof hex
     $hex = 'FFD8FFEE';

    ///If it is in the array, set found to 1 [for later's more complex check]
    
    //look for each file signature individually
    
     //Test for 3rd in array [1,2,{3},4,5]
     if ( mb_substr($hex, 0, 24) === 'FFD8FFE000104A4649460001') {
      $pass = 1;
     }
    
     //Test for 5th in array [1,2,_,4,{5}]
     ///If the first 8 chars are x and the last 12 chars are y, pass
     if( mb_substr($hex, 0, 8) === 'FFD8FFE1') {
      if ( mb_substr($hex, 12, 12) === '457869660000') {                             
       $pass = 1;
      } 
     }
    
     //Test for 1st in array [{1},2,_,4,_]
     if ( mb_substr($hex, 0, 16) === '89504E470D0A1A0A') {
      $pass = 1;
     }
        
     //Test for 2nd in array [_,{2},_,4,_]
     if ( mb_substr($hex, 0, 8) === 'FFD8FFDB') {
      $pass = 1;
     }
    
     //Test for 2nd in array [_,_,_,{4},_]
     if ( mb_substr($hex, 0, 8) === 'FFD8FFEE') {
      $pass = 1;
     }

     if (isset($pass)) {
      //come back to the page
      header("Location: image_processing.php?uploadsuccess");
     } else {
      $_SESSION["error"] = 1;
      $_SESSION["error_type"] = 'file_sig_invalid';
      push_back_instant('image_processing.php');
      exit();
     }
   } else {
    $_SESSION["error"] = 1;
    $_SESSION["error_type"] = 'file_too_large';
    push_back_instant('image_processing.php');
    exit();
   }
  } else {
   $_SESSION["error"] = 1;
   $_SESSION["error_type"] = 'upload_error';
   push_back_instant('image_processing.php');
   exit();
  }
 } else {
  $_SESSION["error"] = 1;
  $_SESSION["error_type"] = 'bad_file_type';
  push_back_instant('image_processing.php');
  exit();
 }
 
 //grab file names for image_processing.php
 if(isset($fileNameNew)) {
  $_SESSION['uploaded_file_path'] = $fileNameNew;
  $_SESSION['ext_file_upload_check'] = 1;
  $_SESSION['file_ext'] = $fileActualExt;
 } 

  
}

pre($_FILES);

/*

// Note: $image is an Imagick object, not a filename! See example use below.
function autoRotateImage($image) {
    $orientation = $image->getImageOrientation();

    switch($orientation) {
        case imagick::ORIENTATION_BOTTOMRIGHT:
            $image->rotateimage("#000", 180); // rotate 180 degrees
        break;

        case imagick::ORIENTATION_RIGHTTOP:
            $image->rotateimage("#000", 90); // rotate 90 degrees CW
        break;

        case imagick::ORIENTATION_LEFTBOTTOM:
            $image->rotateimage("#000", -90); // rotate 90 degrees CCW
        break;
    }

    // Now that it's auto-rotated, make sure the EXIF data is correct in case the EXIF gets saved with the image!
    $image->setImageOrientation(imagick::ORIENTATION_TOPLEFT);
}

$image = new Imagick('my-image-file.jpg');
autoRotateImage($image);
// - Do other stuff to the image here -
$image->writeImage('result-image.jpg');

*/



?>