<?php

//Search Function

//Returns data based on newest first (unix time)
//Then takes each search string
//And ranks results based on search.php haystack in functions.php

session_start();
define('unlock_includes', TRUE);
include '../functions.php';

/*************************************************/
//Get Data

$data = file_get_contents('php://input');
//Spoofing data for testing
//$data = 'bexhill doctor superhero\\3254';

/*************************************************/
//Check for security tag/passcode from Javascript JSON

//return the search terms, before the \
$raw_search_term = substr($data, 0, strpos($data, '\\'));
//echo $raw_search_term;

//return the security string, after the \ 
$security_string = substr($data, strpos($data, "\\") + 1);    
//echo $security_string;


if ($security_string !== '3254') {
 push_back_instant('../index.php');
 exit();
}

//If user is not logged in, reject
if(!isset($_SESSION['logged_in'])) {
 push_back_instant('../index.php');
 exit();
}

/*************************************************/
//Secure + get the Search String

//
//
$search_string = secure_search($raw_search_term);
//echo $search_string;
/*************************************************/
// Get the amount of total possible results

//Get raw results
$results_length = 
 $data = pdo_return("SELECT `saved_jobs` FROM `users` WHERE `username` = '".$_SESSION['username']."' ")[0];
//Make array from JSON Data
$data = json_decode($data, true);

//pre($data);
// Remove any that were deleted or are not listed but exist from array
for ($i=0; $i<count($data); $i++) {

 //If the listing is not live, get it's array key and remove it from the array
  $listing_live = pdo_return("SELECT `listing_live` FROM `listed_jobs` WHERE `page_link` = '".$data[$i]."' ")[0];
 if ($listing_live == '0') {
  $key = array_search($data[$i], $data);
  unset($data[$key]);
 }
 
 //If the listing is deleted, get it's array key and remove it from the array
 if(isset($data[$i])) {
  $user_delete_marked = pdo_return("SELECT `user_delete_marked` FROM `listed_jobs` WHERE `page_link` = '".$data[$i]."' ")[0];
  if ($user_delete_marked == '1') {
   $key = array_search($data[$i], $data);
   unset($data[$key]);
  }
 }
 
}

//Reorder the data array to be zero indexed again after things were removed
$data = array_values($data);
//
//
$total_results = count($data);
//pre($total_results);
/*************************************************/
//Get the searchable data from each valid result
//$data = ?

$result = array();

for ($i=0; $i<$total_results; $i++) {
 $listing_data = pdo_return_arr("SELECT `company_name`,`job_title`,`job_location`,`working_hours`,`job_cat_1`,`page_link`
 FROM `listed_jobs` WHERE `page_link` = '".$data[$i]."' ")[0];
 
 array_push($result,$listing_data);
}
//
//
$data = $result;
//pre($data);
/*************************************************/
//Remove any search results that do not match the search criteria
//pre($data);

//Split the search term in to an array
//echo $search_string;
//
//
$search_strings = preg_split("/[\s]+/", $search_string);
//pre($search_strings);
/*************************************************/
//Search result body

//get_search_score relies on row_id
//return row ids of every page link that was returned
//assign it to an array
$array = array();
for ($i=0; $i<$total_results; $i++) {
 //get the row id for each page link
 $page_link = $data[$i]['page_link'];
 $row_id = pdo_return("SELECT `id` FROM `listed_jobs` WHERE `page_link` = '".$page_link."' ")[0];

 array_push($array,$row_id);
}
//
//
$row_ids = $array;
//pre($array);
/*************************************************/
//Order the remaining search results by newest first
//And any other biases you want

//Get the unix time for each row id of each remaining row
$array = array();
for ($i=0; $i<count($row_ids); $i++) {
 $data = pdo_return_arr("SELECT `unix_time`,`id` FROM `listed_jobs` WHERE `id` = '".$row_ids[$i]."' ");
 array_push($array,$data[0]);
}
//Sort by nested array key
function sortByOrder($a, $b) {
    return $a['unix_time'] - $b['unix_time'];
}

usort($array, 'sortByOrder');

$row_ids_ranked = $array;

//Change $row_ids to the ranked array
unset ($row_ids);
$row_ids = array();
for ($i=0; $i<count($row_ids_ranked); $i++) {
 array_push($row_ids,$row_ids_ranked[$i]['id']);
}
//
//
//$row_ids is now ranked by unix time
//pre($row_ids);
/*************************************************/

/* Get scores for each row of the search database */
$array = array();

for ($i=0; $i<count($row_ids); $i++) {
 $array2 = array();
 for ($j=0; $j<count($search_strings); $j++) {
  $data = get_search_score($row_ids[$i],$search_strings[$j]);
  array_push($array2,$data);
 }
 array_push($array,$array2);
}
//pre($array);

//Generate a nested array for later (added after line 210 echo $score)
$array3 = array();
$array4 = array();

//For every entry in the array,
for ($i=0; $i<count($array); $i++) {
 //save the row_id,
 $row_id = $row_ids[$i];
 //and add up the score
 
 //For every search string
 $array2 = array();
 for ($j=0;$j<count($search_strings); $j++) {
  //get the score
  $score = $array[$i][$j]['score'];
  //push both to an array
  array_push($array2,$score);
 }
  //get the row id
 $row_id = $array[$i][0]['row_id'];
  //get the sum of the search scores from loop
 $score = array_sum($array2);
 //assign to inner array declared outside all loops
 $array3['row_id'] = $row_id;
 $array3['score'] = $score;
 //assign inner array to outer array for all results
 array_push($array4,$array3);
}
//
//
$search_scores = $array4;
//pre($search_scores);
/*************************************************/
//Order the search scores by score

//Sort the array by the keys
function sortByOrder2($a, $b) {
    return $a['score'] - $b['score'];
}

for ($i=0; $i<count($search_scores); $i++) {
 $number = usort($search_scores, 'sortByOrder2');
 if ($number > $search_scores[$i]['score']) {
  if ($i-1 == null) {
   $i_setup = 1;
  } else {
   $i_setup = 0;
  }
  array_swap($search_scores,$i,$i_setup);
 }
}
$search_scores = array_reverse($search_scores);
//
//
$sorted_ids = $search_scores;
//pre($sorted_ids);
/*************************************************/
//Extract the sorted ids from the multidimensional array
$input = $sorted_ids;

$array = array();
for($i=0; $i<count($input); $i++) {
 array_push($array,$input[$i]['row_id']);
}


//
//
//pre($array);
$sorted_ids= $array;
/*************************************************/
//Encode the data as JSON + export
//Input is $sorted_ids
//
//

//For each row id, get the page link
$array = array();
for ($i=0; $i<count($sorted_ids); $i++) {
 $data = pdo_return("SELECT `page_link` FROM `listed_jobs` WHERE `id` = '".$sorted_ids[$i]."' ")[0];
 array_push($array,$data);
}

//for each page link, get the data you want to output

$array2 = array();
for ($i=0; $i<count($array); $i++) {
 $listing_data = pdo_return_arr("SELECT `company_name`,`job_title`,`job_description`,`company_logo`,`working_hours`,`unix_time`,`page_link` FROM `listed_jobs` WHERE `page_link` = '".$array[$i]."' ")[0];
 
 //Shorten strings
 $listing_data['job_description'] = mb_substr($listing_data['job_description'],0,221).'...';
  
 array_push($array2,$listing_data);
}
//
//
//pre($array2);
//
//
//
//
echo json_encode($array2);

?>