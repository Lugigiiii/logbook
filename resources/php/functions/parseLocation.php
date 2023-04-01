<?php
// include config
include('../config.inc.php');


// check if user is authenticated for the following part
if(session_id() === "") session_start();
if($_SESSION['loggedin'] !== True){
    header('Location: /index.php?view=login');
    die();
}



$lat = addslashes($_POST['lat']);
$lon = addslashes($_POST['lon']);

if(empty($lat) && empty($lon)) {
    exit;
}


$ch = curl_init();
$url = "https://eu1.locationiq.com/v1/reverse?key=".$LOCATION_API_TOKEN."&lat=".$lat."&lon=".$lon."&format=json";

$curl = curl_init($url);

curl_setopt_array($curl, array(
  CURLOPT_RETURNTRANSFER    =>  true,
  CURLOPT_FOLLOWLOCATION    =>  true,
  CURLOPT_MAXREDIRS         =>  10,
  CURLOPT_TIMEOUT           =>  30,
  CURLOPT_CUSTOMREQUEST     =>  'GET',
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
