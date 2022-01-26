/* First half works. Turn it into a callback */




   function getLocation() {
     if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
        
     } else {
        //Do nothing
     }
   }

   function showPosition(position) {
      //alert(position.coords.latitude);
      //alert(position.coords.longitude);
      
         var jsLong = position.coords.longitude;
         var jsLat = position.coords.latitude;

           var arr = '{"long":"'+jsLong+'", "lat":"'+jsLat+'"}';
           var xhttp = new XMLHttpRequest();
           xhttp.open("POST", "locate.php", true);
           //alert(arr);
           xhttp.send(arr);
   }




   getLocation();

//So this, kids, is how you send data to and from your back end. And yes, this page uses PHP. Have fun hacking I guess :/