<?php

include('../config.inc.php');

$lat = $_POST['lat'];
$lon = $_POST['lon'];

if(empty($lat) && empty($lon)) {
    exit;
}


$ch = curl_init();
$url = "https://eu1.locationiq.com/v1/reverse?key=".$location_api_token."&lat=".$lat."&lon=".$lon."&format=json";

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
