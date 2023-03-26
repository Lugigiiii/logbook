<?php

// load car from array and show html dropdown for mobile selection
function loadCar($array) {
    $html = '<select class="inp-fw" name="car" id="car-selector" type="text">';
    $html .= '<option value="" default>Fahrzeug...</option>';
    foreach ($array as $value) {
        $html .= "<option value='{$value}'>{$value}</option>";
    }
    $html .= '</select>';
    return $html;
}



// upload ride data
function uploadData($car,$arr_locStart,$arr_tsStart,$arr_tsStop,$kmStart,$kmStop){
    // include the setup script
    include('resources/php/config.inc.php');

    // Create connection
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    // first insert main ride, then get id and upload all arrays via foreach loop
}
