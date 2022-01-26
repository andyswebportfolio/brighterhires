<?php
if(!defined('unlock_includes')) {
 http_response_code(404);
 include('404.php'); // provide your own HTML for the error page
 die();
}

//This is a list of functions that, when called,
//add something so wherever you tell them on the screen.

?>



<script>
 
 //Listed Jobs Items
 //listed jobs
 //my_account.php
 
 function spinner(parent) {
  
  var parent = document.getElementById(parent);
  
  //id styled in css files
  var elem = document.createElement('div');
  elem.id = 'loaderContainer';
  
  parent.appendChild(elem);
  
  var elem2 = document.createElement('div');
  elem2.id = 'loader';
  

  elem.appendChild(elem2);
  
 }
 
 function redSavedJobBox(parent,array) {
  
  var linkStringRed = []
  linkStringRed[0] = '/continue_listing_select.php?a=';
  linkStringRed[1] = '/delete_listing.php?a=';
  
  var parent = document.getElementById(parent);
  //Create outer div

   var div_0 = document.createElement("DIV"); 
   var name = "data_box_1 " + 'red';
   div_0.className = name;
   parent.appendChild(div_0);

   //Create inner div 1

   var div_1 = document.createElement("DIV"); 
   var name = "data_box_header_1";
   div_1.className = name;
   div_1.innerHTML = array[1];
   div_0.appendChild(div_1);

   //Create inner div 2
      
   var div_2 = document.createElement("DIV"); 
   var name = "data_box_header_1_a";
   div_2.className = name;
   div_2.innerHTML = array[0];
   div_1.appendChild(div_2);

   //add 2 breaks to data_box_header_1

   for (i=0; i<1; i++) {
    div_1.appendChild(document.createElement("br"));
   }                      

   //Timestamp
   var p_1 = document.createElement("p");
   p_1.className = 'highlight_2';
   p_1.innerHTML = 'Listing in progress';
   div_1.appendChild(p_1);

   // Button array

   //Generate link strings

   var div_3 = document.createElement('div');
   div_3.className = 'button_array_1';
   div_0.appendChild(div_3);
     
   var titles = [
    'Edit',
    'Delete'    
   ];
     
   var buttonCount = 2;
     
   for (i=0; i<buttonCount; i++)  {
                    
   var a = document.createElement('a');
   a.innerHTML = (titles[i]);
        
   linkBuild = linkStringRed[i];
   linkBuild += array[4];
   a.setAttribute('href',linkBuild); 
   div_3.appendChild(a);
                    
   } 
 }
 
 function greenSavedJobBox(parent,array) {
   var parent = document.getElementById(parent);
  
    //Create outer div

   var div_0 = document.createElement("DIV"); 
   var name = "data_box_1 " + 'green';
   div_0.className = name;
   parent.appendChild(div_0);

   //Create inner div 1

   var div_1 = document.createElement("DIV"); 
   var name = "data_box_header_1";
   div_1.className = name;
   div_1.innerHTML = array[1];
   div_0.appendChild(div_1);

   //Create inner div 2
 
   var div_2 = document.createElement("DIV"); 
   var name = "data_box_header_1_a";
   div_2.className = name;
   div_2.innerHTML = array[0];
   div_1.appendChild(div_2);

   //add 2 breaks to data_box_header_1

   for (i=0; i<1; i++) {
    div_1.appendChild(document.createElement("br"));
   }                        

   //Timestamp
   var p_1 = document.createElement("p");
   p_1.className = 'highlight_green';
   p_1.innerHTML = array[2];
   div_1.appendChild(p_1);

   // Button array

   //Generate link strings

   var div_3 = document.createElement('div');
   div_3.className = 'button_array_1';
   div_0.appendChild(div_3);
    
    
   //Create view button
    
   var a = document.createElement('a');
   a.innerHTML = ('View');
   a.setAttribute('href',"/job_listing.php?a="+array[4]);
   div_3.appendChild(a);
    
   //Create edit button
   
   var a = document.createElement('a');
   a.innerHTML = ('Edit');
   //a.setAttribute('href',"/job_listing.php?a="+this.pageLink);
    //
   a.setAttribute('href',"/update_listing_select.php?a="+array[4]);
   div_3.appendChild(a);
    
   //Create delete button
   
   var a = document.createElement('a');
   a.innerHTML = ('Delete');
   a.setAttribute('href',"/delete_listing.php?a="+array[4]);
   div_3.appendChild(a);
 }
 
 function removeElement(elementId) {
    // Removes an element from the document
    var element = document.getElementById(elementId);
    element.parentNode.removeChild(element);
}

 
 
</script>