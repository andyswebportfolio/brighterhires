<html>
  <head>
    <title>Croppie demo</title>
    <meta name="viewport" content="width=device-width, initial-scale=0.5">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style>
     body {
       padding: 10px;
     }

     .croppie-container {
       padding: 5px;
     }
     .croppie-container .cr-slider-wrap {
       margin-top: 10px;
       margin-bottom: 20px;
     }

     .yingsLightBox.dialog--open .dialog__content {
       max-height: 100vh;
     }

     .croppedImage {
       margin: 0 auto 20px;
     }

     .contentImage__img {
       margin-bottom: 20px;
     }

     .contentImage__container > span {
       display: -webkit-flex;
       display: flex;
       justify-content: center;
       align-items: center;
       width: 120px;
       height: 120px;
       border-radius: 50%;
       background: rgba(255, 255, 255, 0.9);
       border: 1px solid #ddd;
       line-height: 1.2;
       position: absolute;
       top: 30%;
       left: 30%;
     }
     .contentImage__container > span > span {
       padding: 15px;
       font-weight: bold;
       text-align: center;
       text-transform: uppercase;
     }

     .actionSelectFile, .actionDone, .actionUpload, .actionCrop {
       display: block;
       width: 250px;
       text-align: center;
       background: #AB308A;
       border-radius: 3px;
       font-family: "Source Sans Pro", "Segoe UI", "Segoe UI Light", HelveticaNeue-Light, "Roboto Thin", sans-serif;
       font-weight: 700;
       font-size: 13px;
       color: #fff;
       border: 1px solid #AB308A;
       padding: 8px 20px;
       text-decoration: none;
       text-transform: uppercase;
       line-height: 1.5;
       margin: 0 auto 10px;
     }
     .actionSelectFile:hover, .actionDone:hover, .actionUpload:hover, .actionCrop:hover {
       text-decoration: none;
     }

     .actionCancel {
       display: block;
       width: 250px;
       text-align: center;
       background: #f5f5f5;
       border-radius: 3px;
       font-family: "Source Sans Pro", "Segoe UI", "Segoe UI Light", HelveticaNeue-Light, "Roboto Thin", sans-serif;
       font-weight: 700;
       font-size: 13px;
       color: #AB308A;
       border: 1px solid #ddd;
       padding: 8px 20px;
       text-decoration: none;
       text-transform: uppercase;
       line-height: 1.5;
       margin: 0 auto 10px;
     }
     .actionCancel:hover {
       text-decoration: none;
     }

     input[type="file"] {
       display: none;
     }

    </style>
  </head>
  <body>
    <a class="userActivity__didButton"></a>
    <div id="initialModal" class="yingsLightBox">
      <div class="dialog__overlay"></div>
      <div class="dialog__content">
        <div class="contentImage__container">
          <img src="" alt="" class="contentImage__img" />
          <span><span>I Did It!</span></span>
        </div>
        <label class="actionSelectFile" for="upload">
          <span>Add My Photo</span>
          <input type="file" id="upload" value="Choose Image" accept="image/*">
        </label>
        <a class="actionDone">Done</a>
        <a class="close">close</a>
      </div>
    </div>
    <div id="croppingModal" class="yingsLightBox">
      <div class="dialog__overlay"></div>
      <div class="dialog__content">
        <div id="main-cropper"></div>
        <a class="actionCrop">Choose</a>
        <a class="actionCancel">Cancel</a>
        <a class="close">close</a>
      </div>
    </div>
    <div id="finalizeModal" class="yingsLightBox">
      <div class="dialog__overlay"></div>
      <div class="dialog__content">
        <img src="" alt="" class="croppedImage" />
        <a class="actionUpload">Done</a>
        <a class="actionCancel">Cancel</a>
        <a class="close">close</a>
      </div>
    </div>
   <script>
   /* Open initial modal */
   $('.userActivity__didButton').on('click', function(event){
     event.preventDefault();
     this.pictureUrl = 'http://images.meredith.com/content/dam/bhg/Images/2013/6/13/RU204832.jpg.rendition.largest.ss.jpg';
     this.picture = $("#initialModal img");
     this.picture.attr('src', this.pictureUrl);
     $("#initialModal").yingsLightBox({preloadImage:true});
     $('#main-cropper').croppie('bind');
   })

 /* Close Modal Buttons */  
   $('.actionDone').on('click', function(e) {
     $('#initialModal').yingsLightBox().closeModal();
   });
   $('.actionCancel').on('click', function(e) {
     $('#croppingModal').yingsLightBox().closeModal();
     $('#finalizeModal').yingsLightBox().closeModal();
   });  
   $('.actionr').on('click', function(e) {
     $('#finalizeModal').yingsLightBox().closeModal();
     alert("Yay! Your image has been uploaded!");
   });

  /* File selected triggers second modal */
  $('input[type="file"]').change(function(){
    $('#initialModal').yingsLightBox().closeModal();
    $("#croppingModal").yingsLightBox({preloadImage:true});
    readFile(this);
  });  

  /* Croppie Code */
  var $uploadCroppedPhoto
  $uploadCroppedPhoto = $('#main-cropper').croppie({
      viewport: { width: 220, height: 220 },
      boundary: { width: 300, height: 400 },
      showZoomer: true,
      exif: true
  });

  /* Send selected file to Croppie */
  function readFile(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $('#main-cropper').croppie('bind', {
          url: e.target.result
        });
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

  /* Send crop to preview modal */
  $('.actionCrop').on('click', function (ev) {
              $uploadCroppedPhoto.croppie('result', {
                  type: 'canvas',
                  size: 'viewport'
              }).then(function (resp) {
          $('#croppingModal').yingsLightBox().closeModal();
          this.picture = $("#finalizeModal img");
          this.picture.attr('src', resp);
          $("#finalizeModal").yingsLightBox({preloadImage:true});
              });
          });
   </script>
  </body>
</html>