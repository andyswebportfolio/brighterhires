<?php
if(!defined('unlock_includes')) {
 http_response_code(404);
 include('404.php'); // provide your own HTML for the error page
 die();
}
?>

<script>
 
 //=************************************************
 
 //Builder Functions
 
 //my_account.php listed jobs listed_jobs
 
 //Builds the structure
 
 function printListedJobBox() {
  
  
  
 }
 
 //=************************************************
    
function toggle_search_bar() {
    
    document.getElementById('search_icon').removeAttribute("onclick");
    
    
    var x1 = document.getElementById("search_bar");
    var x2 = document.getElementById("dropdown_search_bar");
    var x3 = document.getElementById("dropdown_search_button");
                
    var y = "40px";
           
    if (x1.style.height != y) {
        function open_menu(){
            
            x1.style.height = y;

            setTimeout(function(){x2.style.height = y;},25);
            x2.style.display = "block";
            x2.focus();

            setTimeout(function(){x3.style.height = y;},200);
            setTimeout(function(){x3.style.display = "block";},0);
            setTimeout(function(){x3.style.opacity = "1";},200);
            
        }
        open_menu();
    } else {
        
        function close_menu() {
            x1.style.height = "0px";
            x2.style.height = "0px";

            setTimeout(function(){
                x2.style.display = "none";
            },200);

            x3.style.height = "0px";
            x3.style.display = "none";
            x3.style.opacity = "0";
            x3.style.zindex = -1;
        }
        close_menu();
    }
    setTimeout(function(){document.getElementById('search_icon').setAttribute("onclick", "toggle_search_bar();")},200);
}   
    
function toggle_menu_bar() {
    
        document.getElementById('menu_icon').removeAttribute("onclick");
    
    var menu = document.getElementById("menu_dropdown");
    var menuItems = document.getElementById("menu_dropdown").childNodes;
    
    var h2 = menuItems[1];
    var ul = menuItems[5];
                
    var y = "100vh";
           
    if (menu.style.height != y) {
        function open_menu(){
            menu.style.height = y;
            menu.style.display = "block";
            menu.style.paddingTop = "10vh";
            
            setTimeout(function(){
                h2.style.display = "block";
                ul.style.display = "block";
            },100);
            
            h2.style.opacity = "1";
            ul.style.opacity = "1";
        }
        open_menu()
    } else {
        function close_menu() {
            menu.style.height = "0vh";
            menu.style.paddingTop = "0";
            
            setTimeout(function(){
                h2.style.display = "none";
                ul.style.display = "none";
            },100);
            
            h2.style.opacity = "0";
            ul.style.opacity = "0";
        }
        close_menu();
    }
   setTimeout(function(){document.getElementById('menu_icon').setAttribute("onclick", "toggle_menu_bar();")},400);
}
    
function lightUpScrollbar() {
    /*
    var y = window.scrollY;
    var z = 1;
        
    var navBar = document.getElementById("nav_bar");
    if (y > z) {
        navBar.style.backgroundColor = "rgba(255,255,255,1)";
    } else {
        navBar.style.backgroundColor = "rgba(255,255,255,0.2)";
    }
    */
 return 0;
}
 
function toggleNamedDivs(x) {
 
 alert(sessionStorage.getItem("toggle"));

 //check if the div contains anything
 //if it 
 
 //if it exists, child node 2
 
if (x.childNodes[1] == undefined) {
 alert('nothing there except label');
 //so add whatever you want to the element
 
 } else {
  //Skips first child node
  //Turn off to delete label
  var offset = 1;

  for (i=offset; i<x.childNodes.length; i++) {
   x.removeChild(x.childNodes[i]);
  }
  sessionStorage.setItem("toggle", "1");
 }
 
}
        


function assignJsonData(row,page,callback) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var a = this.response;
            callback(a);
       }
    };
    
    var obj = '3254';
    //var obj = JSON.stringify(obj);
    
    xmlhttp.open("POST", page, true);
    xmlhttp.setRequestHeader('Content-type', 'application/json');
    xmlhttp.send(obj);
    //xmlhttp.send();
}

if (window.location.href.indexOf("my_account") > -1) {
 
 var nav = document.getElementById("nav_bar");
  var att = document.createAttribute("style");
  att.value = "background-color:rgba(255,255,255,0.9)";
  nav.setAttributeNode(att);
 
} else {
 window.onscroll = function() {
  lightUpScrollbar();
 };
}
 
 

 //some random functions 
    
function autofocus() {
    this.autofocus;
}
    
function popup_fadeout() {
    var items = document.getElementById('popup');
    items.style.opacity = 0;
}
    
function popup_fadeout_redirect() {
    window.location = 'index.php';
}
   
function popup_fadeout_redirect_upOneLevel() {
    window.location = '../index.php';
}
   
   
function reset_password_redirect() {
   window.location = '/reset_password.php';
}
 
    
function redirect_my_account() {
    window.location = 'my_account.php';
}
    
function redirect_login() {
    window.location = 'login.php';
}
    
function redirect_my_account_login() {
    window.location = 'index.php';
}
    
function redirect_my_account_login_2() {
    window.location = 'my_account.php';
}
 
function redirect_create_account() {
 window.location = 'create_account.php';
}
   
function redirect_reset_password() {
    window.location = 'reset_password.php';
}
 
function goBack() {
    
    var a = history.length;
    
    //if landing page shown, then link visited
    if (a <= 2) {
     //take the user home
     window.location = 'index.php';
    } else {
     //otherwise, send the user back
     window.history.back();
    }
}
 
function goBack2() {
 window.history.go(-2);
}
 
function goBack1() {
 window.history.go(-1);
}
    
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            
            var tag = document.getElementById('image_upload_box');
            tag.setAttribute('src', e.target.result);
            
        }

    reader.readAsDataURL(input.files[0]);
    }
}
   
   function jumpToPasswordReset() {
    window.location = 'reset_password.php';
   }
    
function toggle_help_box() {
    var x = document.getElementById("help");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}
    

function checkWordLen500(obj,wordLen = 3){
    var len = obj.value.split(/[\s]+/);
    if(len.length > wordLen){
        var popup = document.getElementById('popup_2');
        
        popup.style.display = "block";

        
        obj.oldValue = obj.value!=obj.oldValue?obj.value:obj.oldValue;
        obj.value = obj.oldValue?obj.oldValue:"";
        return false;
    }
    return true;
}
 
 // Function List ENDS //
 
 
 //*Search Results Stuff Starts
 
 
 
    
var searchResult = {
 
 pageLink: 'notSet',
 companyLogo: '/user_uploads/company_logos/1535389800.png',
 jobTitle: 'job title not set',
 companyName: 'the company',
 jobDescription: 'jobDescription',
 timeSticker: 'part_time',
    
 run:function() {
  
  var addDiv = document.getElementById('search_results_container');

  //Create structure

  var a_0 = document.createElement("A"); 
  var name = "format_job_listings";
  a_0.className = name;
  a_0.href = "job_listing.php?a=" + this.pageLink;
  addDiv.appendChild(a_0);
     
  var div_0 = document.createElement("DIV"); 
  var name = "search_result";
  div_0.className = name;
  a_0.appendChild(div_0);
     
  var div_1 = document.createElement("DIV"); 
  var name = "search_result_column_l";
  div_1.className = name;
  div_0.appendChild(div_1);
     
  var elem = document.createElement("IMG"); 
  var name = "search_logo";
  elem.className = name;
  elem.src = this.companyLogo;
  div_1.appendChild(elem);
     
  var elem2 = document.createElement("div"); 
  var name = "search_result_column_c";
  elem2.className = name;
  div_0.appendChild(elem2);
     
  var p_0 = document.createElement("P"); 
  var name = "job_search_title";
  p_0.className = name;
  p_0.innerHTML = this.jobTitle;
  elem2.appendChild(p_0);
     
  var br_0 = document.createElement("BR"); 
  elem2.appendChild(br_0);
     
  var p_1 = document.createElement("P"); 
  var name = "search_result_company_name";
  p_1.className = name;
  p_1.innerHTML = this.companyName;
  elem2.appendChild(p_1);
     
  var br_0 = document.createElement("BR"); 
  elem2.appendChild(br_0);
     
  var p_2 = document.createElement("P"); 
  var name = "job_search_description";
  p_2.className = name;
  p_2.innerHTML = this.jobDescription;
  elem2.appendChild(p_2);
     
  var br_1 = document.createElement("BR"); 
  p_2.appendChild(br_1);
     
  var div_2 = document.createElement("DIV"); 
  var name = "search_result_column_r";
  div_2.className = name;
  div_0.appendChild(div_2);
     
     
  if (this.timeSticker == 'full_time') {
   var div_3 = document.createElement("DIV");
   var name = "hours_icon";
   div_3.className = 'hours_icon';
   div_3.className += ' full_time_icon';
   div_3.innerHTML = 'Full Time';
   div_2.appendChild(div_3);
  }

  if (this.timeSticker == 'part_time') {
   var div_3 = document.createElement("DIV");
   var name = "hours_icon";
   div_3.className = 'hours_icon';
   div_3.className += ' part_time_icon';
   div_3.innerHTML = 'Part Time';
   div_2.appendChild(div_3);
  }
     
  if (this.timeSticker == 'zero_hours') {
   var div_3 = document.createElement("DIV");
   var name = "hours_icon";
   div_3.className = 'hours_icon';
   div_3.className += ' zero_hours_icon';
   div_3.innerHTML = 'Zero Hours';
   div_2.appendChild(div_3);
  }


  var img_1 = document.createElement("img");
  img_1.className = 'search_logo_mobile';
  img_1.src = this.companyLogo;
  div_2.appendChild(img_1);

 }
}

function assignJsonDataSearch(row,page,callback) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var a = this.response;
            callback(a);
       }
    };
    
    var obj = 'hello';
    //var obj = JSON.stringify(obj);
    
    xmlhttp.open("POST", page, true);
    xmlhttp.setRequestHeader('Content-type', 'application/json');
    xmlhttp.send(obj);
    //xmlhttp.send();
}
    
function loadDoc(page,sendString,callback) {
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     callback(this.responseText);
    }
  };
    
  var secureString = "\\3254";
    
  sendString = sendString + secureString;
    
  xmlhttp.open("POST", page, true);
  //xmlhttp.send();
    
  xmlhttp.setRequestHeader('Content-type', 'application/json');
  xmlhttp.send(sendString);
}
    


//search.php code
if (window.location.href.indexOf("search") > -1) {
 
 //Functions for page
 function removeLoaderContainer2() {
  var loaderContainer = document.getElementById('loaderContainer2');
  loaderContainer.style.display = "none";
 }
 
 window.onload = function printSearchJobs() {

 /*Set search term if nothing is entered in url*/     
    
  if (window.location.href.indexOf('?search=') > 0) {
   removeLoaderContainer2();
  } else {
   loadDoc("json/search_results.php",search,function(data){
      
    function printSearchResult() {
     searchResult.companyLogo = results[i].company_logo;
     searchResult.jobTitle = results[i].job_title;
     searchResult.companyName = results[i].company_name;
     searchResult.jobDescription = results[i].job_description;
     searchResult.timeSticker = results[i].working_hours;
     searchResult.pageLink = results[i].page_link;
     searchResult.run();
    }
      
    var results = JSON.parse(data);
    var pageLength = 10;
    var offset = 0;
    
    //Get the length of the resuls. If there are less than pageLength then hide the spinner after a second
     results.length = 9;
   
    if (results.length <= pageLength) {
     var loaderContainer = document.getElementById('loaderContainer2');
     loaderContainer.style.display = "none";
    }
    
   //If there are results, print them
    for (i=0; i<pageLength; i++) {
     printSearchResult();
    }
    

      
    var rowsRemaining = results.length - pageLength
    window.onscroll = function() {
       
     lightUpScrollbar();
      
     /*This line has the wrong syntax, but works, so leave it. idk */   
     if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 300)
        
      if( rowsRemaining > 0 ) {
       //code for scrolled load
        for(i=pageLength+offset; i<(pageLength+1)+offset; i++) {
       printSearchResult();
       } 
      rowsRemaining--;
      offset++;
      } else {
       var loaderContainer = document.getElementById('loaderContainer2');
       loaderContainer.style.display = "none";
      }
    } 
   });
   
   
  }
     
  /**********/
     
  function getUrlVars() {
   var vars = {};
   var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
    vars[key] = value;
   });
   return vars;
  }

  /*remove + sign from url*/
  var search = getUrlVars()["search"];
  search = search.split('+').join(' ');

  /*set to nothing if search is in url but not defined */     
  if (search == undefined) {
   var search = '';
  }
     
  loadDoc("json/search_results.php",search,function(data){
      
   function printSearchResult() {
    searchResult.companyLogo = results[i].company_logo;
    searchResult.jobTitle = results[i].job_title;
    searchResult.companyName = results[i].company_name;
    searchResult.jobDescription = results[i].job_description;
    searchResult.timeSticker = results[i].working_hours;
    searchResult.pageLink = results[i].page_link;
    searchResult.run();
   }
   console.log(data);
   var results = JSON.parse(data);
   var resultsLength = results.length;
   var pageLength = 10;
   var offset = 0;
   var notFullPageSize = 4;
   
   if (results.length <= notFullPageSize) {
    
     var loaderContainer = document.getElementById('loaderContainer2');
     loaderContainer.style.display = "none";
    
    //Show thing that says you reached the end of the results
    
   }
    
   
   for (i=0; i<pageLength; i++) {
    
    printSearchResult();
       
   } 
      
   var rowsRemaining = results.length - pageLength
   window.onscroll = function() {
    lightUpScrollbar();
      
    /*This line has the wrong syntax, but works, so leave it. idk */   
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 300)
        
     if( rowsRemaining > 0 ) {
      //code for scrolled load
      for(i=pageLength+offset; i<(pageLength+1)+offset; i++) {
       printSearchResult();
      } 
     rowsRemaining--;
     offset++;
     }
          
    if ( rowsRemaining > 0) {
     var loaderContainer = document.getElementById('loaderContainer2');
     loaderContainer.style.display = "none";
    }
   } 
  });
 }
 
 // For the bar on the bottom, if the user clicks the toggle button, or the text, it changes the state of the location appearance
 
 var locationdata = document.getElementById('location_data_display');
 var current = locationdata.innerHTML;
 var getElem = document.getElementById('slider_1');
 var switchActive = getElem.checked;
   
 //Activated on switch click
 function location_data_switch() {
    //alert('switch activated');
    
    if (switchActive == true) {
     //locationdata.innerHTML = 'Location Unknown';
     //alert(current);
     switchActive = false;
     //Post the switchactive state to SQL
       var xhttp = new XMLHttpRequest();
       xhttp.open("POST", "location_switch.php", true);
       xhttp.send(0); 
    } else if (switchActive == false) {
     locationdata.innerHTML = current;
     switchActive = true;
     //Post the switchactive state to SQL
       var xhttp = new XMLHttpRequest();
       xhttp.open("POST", "location_switch.php", true);
       xhttp.send(1); 
    }
       setTimeout(function(){ location.reload(); }, 200);
    }
}
    
if (window.location.href.indexOf("edit_account_details") > -1) {
 var elem = document.getElementById('existing_value_gender').value;
    
 var male = document.getElementById('male_gender_value');
 var female = document.getElementById('female_gender_value');
 var other = document.getElementById('other_gender_value');
    
 if (elem == "Male") {
  male.remove();
 }
    
 if (elem == "Female") {
  female.remove();
 }
    
 if (elem == "Other") {
  other.remove();
 }

}
 
//my_account.php / My Account saved_jobs code
 
if (window.location.href.indexOf("my_account") > -1) {
 
 var loading = 'loading';
 document.getElementById("saved_jobs_display_div").innerHTML = '<br>';
 
 var xmlhttp = new XMLHttpRequest();
 xmlhttp.onreadystatechange = function() {

  if (this.readyState == 4 && this.status == 200) {
   //Empty the div
     document.getElementById("saved_jobs_display_div").innerHTML = '';
   //remove the loading wheel
   document.getElementById('loaderContainerSavedJobs').style.display = 'none';
   json = JSON.parse(this.responseText);
   
   //Check security string
   var securityStringLocation = json.length-1;
   //Keep this line
   //alert(json[securityStringLocation]);
   
   
   //Code to create correct divs here based on search term
   //document.getElementById("saved_jobs_display_div").innerHTML = json[0].company_name;

   
   
   // Code to print a result box inside the saved jobs section
   // Should also work for the listed jobs section on the same page
   
   //! Run it like this searchResult.run(params);
   var searchResult = {
 
    run:function(
     companyName,
     jobTitle,
     jobDescription,
     companyLogo,
     workingHours,
     pageLink
    )
    {

     var addDiv = document.getElementById('saved_jobs_display_div');

     //Create structure
     
     var a_0 = document.createElement('a');
     a_0.href='job_listing.php?a=' + pageLink;
     a_0.style.width = '100%';
     a_0.className = 'a_wrapper_for_saved_listings';
     addDiv.appendChild(a_0);
     
     var div_0 = document.createElement("DIV"); 
     div_0.className = 'search_result_my_acc';
     div_0.href = 'index.php';
     a_0.appendChild(div_0);

     var div_1 = document.createElement('DIV');
     div_1.className = "search_result_column_l_my_acc";
     div_0.appendChild(div_1);

     var img_1 = document.createElement('img');
     img_1.className = "search_logo_my_acc";
     img_1.src = companyLogo;
     div_1.appendChild(img_1);

     var div_2 = document.createElement('div');
     div_2.className = 'search_result_column_c_my_acc';
     div_0.appendChild(div_2);

     var p_1 = document.createElement('p');
     p_1.className = 'job_search_title_my_acc';
     p_1.innerHTML = jobTitle;
     div_2.appendChild(p_1);

     var br_1 = document.createElement("br");
     div_2.appendChild(br_1);

     var p_2 = document.createElement("p");
     p_2.className = 'search_result_company_name_my_acc';
     p_2.innerHTML = companyName;
     div_2.appendChild(p_2);

     var br_1 = document.createElement("br");
     div_2.appendChild(br_1);

     var p_3 = document.createElement("p");
     p_3.className = 'job_search_description_my_acc';
     p_3.innerHTML = jobDescription;
     div_2.appendChild(p_3);

     //Was a break tag in the <p> above, not included

     var div_3 = document.createElement('div');
     div_3.className = 'search_result_column_r_my_acc';
     div_0.appendChild(div_3);
     
     if (this.workingHours == 'full_time') {
     var div_3a = document.createElement("DIV");
     var name = "hours_icon";
     div_3a.className = 'hours_icon';
     div_3a.className += ' full_time_icon';
     div_3a.innerHTML = 'Full Time';
     div_2.appendChild(div_3);
    }

    if (this.workingHours == 'part_time') {
     var div_3a = document.createElement("DIV");
     var name = "hours_icon";
     div_3a.className = 'hours_icon';
     div_3a.className += ' part_time_icon';
     div_3a.innerHTML = 'Part Time';
     div_2.appendChild(div_3);
    }

    if (this.workingHours == 'zero_hours') {
     var div_3a = document.createElement("DIV");
     var name = "hours_icon";
     div_3a.className = 'hours_icon';
     div_3a.className += ' zero_hours_icon';
     div_3a.innerHTML = 'Zero Hours';
     div_2.appendChild(div_3);
    }

     var div_4 = document.createElement('div');
     div_4.className = 'hours_icon_my_acc';
     
     if (workingHours == 'part_time') {
      div_4.className += ' part_time_icon_my_acc';
      div_4.innerHTML = 'Part Time';
     }
     
     if (workingHours == 'full_time') {
      div_4.className += ' full_time_icon_my_acc';
      div_4.innerHTML = 'Full Time';
     }
     
     if (workingHours == 'zero_hours') {
      div_4.className += ' zero_hours_icon_my_acc';
      div_4.innerHTML = 'Zero Hours';
     }

     div_3.appendChild(div_4);
     
     
     //Create picture div for small layouts
     var img_2 = document.createElement('img');
     img_2.className = "search_logo_my_acc";
     img_2.className += " search_logo_my_acc_mobile"
     img_2.src = companyLogo;
     div_3.appendChild(img_2);
     
     
     //Create the button bar at the bottom
     var elem = document.createElement('div');
     elem.className = 'button_array_1--2';
     elem.style.position = 'relative';
     elem.style.width = '95%';
     elem.style.left = '2.5%';
     
     elem.style.height = '75px';
     elem.style.marginBottom = '30px';
     elem.style.borderBottom = '2px solid #ededed';
     var parent = addDiv;
     parent.appendChild(elem);
     
     //Add buttons to the bar, inside a form
     
     var elem = document.createElement('form');
     elem.action = 'submit/delete_saved_job.php?a=' + json[i].page_link;
     elem.method = 'POST';
     elem.enctype = 'multipart/form-data';
     elem.className = 'delete_saved_job_form'
     var parent = document.getElementsByClassName('button_array_1--2');
     parent[i].appendChild(elem);
     
     var a_1 = document.createElement('button');
     a_1.href = 'submit/delete_saved_job.php?a=' + json[i].page_link;
     a_1.innerHTML = 'Remove';
     var parent = document.getElementsByClassName('delete_saved_job_form');
     parent[i].appendChild(a_1);
     
     
    } //Close out the run function
    
   } //Close out the search result variable (object)
   
   
   //For every result in the list, print them in order
   //-1 because security string is sent at the end as json[x]
   for (i=0; i<json.length-1; i++) {
    searchResult.run(
     json[i].company_name,
     json[i].job_title,
     json[i].job_description,
     json[i].company_logo,
     json[i].working_hours,
     json[i].page_link
    );
   }
   
   

   
   //If there are more than 5 saved jobs, change
   //the layout so that it scrolls
   
   if (json.length > 5) {
    var elem = document.querySelector('#saved_jobs_display_div');

    // Allow the box to scroll
    elem.style.overflow = 'auto';
    elem.style.height = '550px';
    
    //Show the scroll info bar
    var elem = document.createElement('div');
    elem.id='scroll_info_bar';
    elem.style.minHeight = '40px';
    elem.style.width = '95%';
    elem.style.left = '2.5%';
    elem.style.border = '2px dotted silver';
    elem.style.borderRadius = '5px';
    elem.style.marginTop = '10px';
    elem.style.marginBottom = '30px';
    elem.style.position = 'relative';
    elem.style.backgroundColor = '#f2f2f2';
    var parent = document.getElementById('saved_jobs_display_div');
    parent.insertAdjacentElement('afterbegin', elem);
    
    var elem = document.createElement('p');
    elem.innerHTML = 'Scroll up and down to view your saved jobs.';
    elem.style.position = 'relative';
    elem.style.top = '5px';
    elem.style.color = 'grey';
    var parent = document.getElementById('scroll_info_bar');
    parent.appendChild(elem);
   }
   
   if (json.length < 2 || json.length == undefined) {
    
    //Create a container
    var elem = document.createElement('div');
    elem.id = 'no_saved_jobs_container';
    elem.style.height = '125px';
    elem.innerHTML = 'You have no saved jobs.<div style="text-align:center; height:150px; position:relative; top:20px;"><div class="underline2_1" style="margin-top:5px;"></div><a class="button1" style = "color:black; display:inline-block; width:150px; padding:5px; position:relative; border-radius:2px; top:25px; " href="search.php" class="button1">Latest Jobs</a></div>';
    elem.style.paddingTop = '20px';
    var parent = document.getElementById('saved_jobs_display_div');
    parent.appendChild(elem);
    
    //
    
   }
   
   
   
   //alert(JSON.stringify(json));
   //alert(json[i].page_link);
   
   /*
   var tempInsert = document.getElementById('saved_jobs_display_div');
   var tempData = json.stringify(json);
   tempInsert.appendChild(tempData);
   */

   /*
   //Spoof
   json[0].working_hours = 'part_time';

   //Convert strings before entry
   if (json[0].working_hours === 'full_time') {
    alert('yes');
    json[0].working_hours = 'Full Time';
   }
   if (json[0].working_hours === 'part_time') {
    alert('yes');
    json[0].working_hours = 'Part Time';
   }
   if (json[0].working_hours === 'zero_hours') {
    alert('yes');
    json[0].working_hours = 'Zero Hours';
   }
   */
   


  }
 };
 
 var securityString = '3254';

 xmlhttp.open("POST", "/json/saved_jobs.php", true);
 xmlhttp.setRequestHeader('Content-type', 'application/json');
 xmlhttp.send(securityString);

}
 
//=************************************************
//=************************************************
//my_account.php functions
 
function hide_element(elem) {
 document.getElementById(elem).style.display = 'none';
 //alert ('element hidden'); 
}

 
//Tags: saved_jobs.php
 
//Page = my_account.php
//File = saved_jobs.php
//Action = typing in saved jobs search box
 
//Define functions
  var canGo = true,
  delay = 1000; // one second
   function getSavedJobs() {
    if (canGo) {
        canGo = false;
        // do whatever you want
        runGetSavedJobs();
        
        setTimeout(function () {
            canGo = true;
        }, delay)
    } else {
     //alert("Can't go!");
    }
   
   function runGetSavedJobs() {
    
   var searchText2 = document.getElementById('saved_jobs_text_input').value;
    
   //Show Loader + style it
   document.getElementById('loaderContainerSavedJobs').style.display = 'initial';
   document.getElementById('loaderContainerSavedJobs').style.position = 'relative';
   document.getElementById('loaderContainerSavedJobs').style.top = '15px';
    
     if (searchText2) {

      var delayedSearchText = searchText2;

      //alert(searchText2);
      //setTimeout(function(){ alert("Hello"); }, 3000);
      //Wipe the box, put something else there
      var elem = document.getElementById('saved_jobs_display_div');
      elem.innerHTML = '';
      elem.style.height = '0px';
      //elem.innerHTML = searchText2;




      //Send the data and return results
      var xhttp = new XMLHttpRequest();
       xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
         
         //alert(this.responseText);
         var json = JSON.parse(this.responseText);


         var searchResult = {

       run:function(
        companyName,
        jobTitle,
        jobDescription,
        companyLogo,
        workingHours,
        pageLink
       )
       {

       var addDiv = document.getElementById('saved_jobs_display_div');

           //Create structure
           var div_0 = document.createElement("DIV"); 
           div_0.className = 'search_result_my_acc';
           addDiv.appendChild(div_0);

           var div_1 = document.createElement('DIV');
           div_1.className = "search_result_column_l_my_acc";
           div_0.appendChild(div_1);

           var img_1 = document.createElement('img');
           img_1.className = "search_logo_my_acc";
           img_1.src = companyLogo;
           div_1.appendChild(img_1);

           var div_2 = document.createElement('div');
           div_2.className = 'search_result_column_c_my_acc';
           div_0.appendChild(div_2);

           var p_1 = document.createElement('p');
           p_1.className = 'job_search_title_my_acc';
           p_1.innerHTML = jobTitle;
           div_2.appendChild(p_1);

           var br_1 = document.createElement("br");
           div_2.appendChild(br_1);

           var p_2 = document.createElement("p");
           p_2.className = 'search_result_company_name_my_acc';
           p_2.innerHTML = companyName;
           div_2.appendChild(p_2);

           var br_1 = document.createElement("br");
           div_2.appendChild(br_1);

           var p_3 = document.createElement("p");
           p_3.className = 'job_search_description_my_acc';
           p_3.innerHTML = jobDescription;
           div_2.appendChild(p_3);

           //Was a break tag in the <p> above, not included

           var div_3 = document.createElement('div');
           div_3.className = 'search_result_column_r_my_acc';
           div_0.appendChild(div_3);

           if (this.workingHours == 'full_time') {
           var div_3a = document.createElement("DIV");
           var name = "hours_icon";
           div_3a.className = 'hours_icon';
           div_3a.className += ' full_time_icon';
           div_3a.innerHTML = 'Full Time';
           div_2.appendChild(div_3);
          }

          if (this.workingHours == 'part_time') {
           var div_3a = document.createElement("DIV");
           var name = "hours_icon";
           div_3a.className = 'hours_icon';
           div_3a.className += ' part_time_icon';
           div_3a.innerHTML = 'Part Time';
           div_2.appendChild(div_3);
          }

          if (this.workingHours == 'zero_hours') {
           var div_3a = document.createElement("DIV");
           var name = "hours_icon";
           div_3a.className = 'hours_icon';
           div_3a.className += ' zero_hours_icon';
           div_3a.innerHTML = 'Zero Hours';
           div_2.appendChild(div_3);
          }
        
           //Create picture div for small layouts
           var img_2 = document.createElement('img');
           img_2.className = "search_logo_my_acc";
           img_2.className += " search_logo_my_acc_mobile"
           img_2.src = companyLogo;
           div_3.appendChild(img_2);

           var div_4 = document.createElement('div');
           div_4.className = 'hours_icon_my_acc';

           if (workingHours == 'part_time') {
            div_4.className += ' part_time_icon_my_acc';
            div_4.innerHTML = 'Part Time';
           }

           if (workingHours == 'full_time') {
            div_4.className += ' full_time_icon_my_acc';
            div_4.innerHTML = 'Full Time';
           }

           if (workingHours == 'zero_hours') {
            div_4.className += ' zero_hours_icon_my_acc';
            div_4.innerHTML = 'Zero Hours';
           }




           div_3.appendChild(div_4);

           var img_2 = document.createElement('img');
           img_2.className = 'search_logo_mobile_my_acc';
           img_2.src = '/user_uploads/company_logos/086lnFVWe8.jpg';
           div_3.appendChild(img_2);

           //Create the button bar at the bottom
           var elem = document.createElement('div');
           elem.className = 'button_array_1--2';
           elem.style.position = 'relative';
           elem.style.width = '95%';
           elem.style.left = '2.5%';

           elem.style.height = '75px';
           elem.style.marginBottom = '30px';
           elem.style.borderBottom = '2px solid #ededed';
           var parent = addDiv;
           parent.appendChild(elem);

           //Add buttons to the bar, inside a form

           var elem = document.createElement('form');
           elem.action = 'submit/delete_saved_job.php?a=' + json[i].page_link;
           elem.method = 'POST';
           elem.enctype = 'multipart/form-data';
           elem.className = 'delete_saved_job_form'
           var parent = document.getElementsByClassName('button_array_1--2');
           parent[i].appendChild(elem);

           var a_1 = document.createElement('button');
           a_1.href = 'submit/delete_saved_job.php?a=' + json[i].page_link;
           a_1.innerHTML = 'Remove';
           var parent = document.getElementsByClassName('delete_saved_job_form');
           parent[i].appendChild(a_1);


          } //Close out the run function

      } //Close out the search result variable (object)

         for (i=0; i<json.length; i++) {
          searchResult.run(
           json[i].company_name,
           json[i].job_title,
           json[i].job_description,
           json[i].company_logo,
           json[i].working_hours,
           json[i].page_link
          );
         }
          
         //Remove the spinner
         document.getElementById('loaderContainerSavedJobs').style.display = 'none';
         
         //put the height back to what it is supposed to be
         var elem = document.getElementById('saved_jobs_display_div');
         elem.style.height = 'unset';
         
        }
       };
      xhttp.open("POST", "json/saved_jobs_search.php", true);
      xhttp.send(delayedSearchText + '\\3254');


     }
    //Return a 1 because it is complete
    return 1;

   }
}
 
//=************************************************
 
 //Functions for loading listed jobs

  function initialListedJobsLoad() {
   //Show the spinner
 spinner('ajax_results');

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     
     //Parse the JSON Data
     var data = JSON.parse(this.responseText);
     
     //Print the boxes
     for (j=0; j<data.length; j++) {
      var array = [
      data[j].company_name,
      data[j].job_title,
      data[j].unix_time,
      data[j].id,
      data[j].page_link,
      data[j].listing_live,
      data[j].company_logo
     ];
     
      //Create logic for which boxes to show when

      if (array[5] == 1) {
       //alert('green box');
       greenSavedJobBox('ajax_results',array);
      } else {
       //alert('red box');
       redSavedJobBox('ajax_results',array);
      }
     }

     //Remove the spinner now loading is done
     document.getElementById('loaderContainer').style.display = 'none';
     
    }
  };
  xhttp.open("POST", 'json/listed_jobs.php', true);
  xhttp.send('3254');
 }

 
function getListedJobsSearch(searchTerm) {

  //Show the spinner
 spinner('ajax_results');

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     
     //Parse the JSON Data
     var data = JSON.parse(this.responseText);
     
     //Print the boxes
     for (j=0; j<data.length; j++) {
      var array = [
      data[j].company_name,
      data[j].job_title,
      data[j].unix_time,
      data[j].id,
      data[j].page_link,
      data[j].listing_live,
      data[j].company_logo
     ];
     
      //Create logic for which boxes to show when

      if (array[5] == 1) {
       //alert('green box');
       greenSavedJobBox('ajax_results',array);
      } else {
       //alert('red box');
       redSavedJobBox('ajax_results',array);
      }
     }

     //Remove the spinner now loading is done
     document.getElementById('loaderContainer').style.display = 'none';
     
    }
  };
  xhttp.open("POST", 'json/listed_jobs_search.php', true);
  xhttp.send(searchTerm + '\\3254');
}
 
//***************************************************
//my_account.php actions

//Logic for my_account.php
 
if (window.location.href.indexOf("my_account") > -1) {
 
 initialListedJobsLoad();
 //Saved Jobs load is done elsewhere
 
 document.getElementById("getSavedJobsButton").onclick = function() {
  getSavedJobs();
 }

 document.getElementById("getListedJobsButton").onclick = function() {
  var searchText2 = document.getElementById('listed_jobs_text_input').value;
   document.getElementById("ajax_results").innerHTML = '';
   getListedJobsSearch(searchText2);
 }
 
} //if page is my account

 
    
/* Geolocation */
    

/*
if ("geolocation" in navigator) {
 // geolocation is available
 alert('working');
 navigator.geolocation.getCurrentPosition(function(position) {
 alert(position.coords.latitude, position.coords.longitude);
});
} else {
 // geolocation IS NOT available
 alert('yeah, no');
}
*/
 
 // Saved Jobs Version 2
 
  //Send the data and return results

    
</script>