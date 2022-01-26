<?php
session_start();


/*************************************************/
/*************************************************/
/*************************************************/
//Security Switch
//1 is on, everything else is off
$security = 1;
/********** */


define('unlock_includes', TRUE);
include '../functions.php';

/*************************************************/
//Get data from JSON output in Javascript

$data = file_get_contents('php://input');
//$data = '\3254';

/*************************************************/



    //Check for security tag/passcode from Javascript JSON

    //return the search terms, before the \
    $raw_search_term = substr($data, 0, strpos($data, '\\'));
    //echo $raw_search_term;

    //return the security string, after the \ 
    $security_string = substr($data, strpos($data, "\\") + 1);
    //echo $security_string;

    if ($security == 1) {
        
        if ($security_string !== '3254') {
        push_back_instant('../index.php');
        exit();
        }
        
    }





/*************************************************/

//XSS Protect
$search_term = secure_search($raw_search_term);

//Spoofing Search Term #spoof
//$search_term = 'guard';

//Add the optional location strings, if the switch is on

$session_id = session_id();

$switch_state = pdo_return("SELECT `use_location` FROM `user_connections` WHERE `session_id` = '".$session_id."'  ");


if (isset ($switch_state[0])) {
    if ($switch_state == 1) {
        $location_data = get_location_data_v1();
     
        //pre($location_data);
        $search_term = ($search_term.' '.$location_data[0].' '.$location_data[1].' '.$location_data[2]);
     
        //Format the Postcode Data
        $location_data[1] = substr($location_data[1], 0, 2); // returns "d"
        $location_data[1] = preg_replace('/[0-9]+/', '', $location_data[1]);
     }
}


//echo $search_term;



// get the amount of results in the entire database
$results_length = count(pdo_return("SELECT id FROM `listed_jobs`"));

// Get scores for each row of the search database
$array = array();

for ($i=$results_length-1; $i>-1; $i--) {
    
    
 //get the first id from the database
 //if delete is set to 0 and listing live is set to 1
 //get the search score, and push it to the data array
  
 
 $test_1 = pdo_return("SELECT `listing_live` FROM `listed_jobs` WHERE id = ".$i." ")[0];
     
 $test_2 = pdo_return("SELECT `user_delete_marked` FROM `listed_jobs` WHERE id = ".$i." ")[0];
 
    
    
 //echo $test_1.'<br>';
 //echo $test_2.'<br>';
    
    
 // Get search score from user input
    
 if ($test_1 == 1 && $test_2 == 0) {
  $data = get_search_score($i,$search_term);
  array_push($array,$data); 
 } else {
     $results_length --;
 }

}

//pre ( $array );

// Reorder array 

$array = reorder_array($array,'score');

//


// Output array, convert to JSON

$array2 = array();

for ($i=0; $i<$results_length; $i++) {
 $data = get_listed_jobs_data('search.php',$array[$i]['row_id'])[0];
 $data['job_description'] = mb_substr($data['job_description'],0,221).'...';
 array_push($array2,$data);
}

//pre ( $array2 );
echo json_encode($array2,JSON_UNESCAPED_SLASHES);


?>