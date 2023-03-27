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

// function for array upload to db
function multiUpload($prep_st, $ride_id, $array){
    // include the setup script
    include('resources/php/config.inc.php');

    // Create connection
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // loop array
    foreach ($array as $key => $value) {
        // first insert main ride, then get id and upload all arrays via foreach loop
        // prepare and bind ride
        $stmt = $conn->prepare($statement);
        $stmt->bind_param("is", $ride_id, $value)
        try {
            $stmt->execute();
        } catch(Exception $e){
            echo 'Error: '.$e;
        }
        $stmt->close();

    }
    $conn->close();
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
    // prepare and bind ride
    $stmt = $conn->prepare("INSERT INTO ride (user, car, kmStart, kmEnd) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isii", $_SESSION['user_id'], $car, $kmStart, $kmStop);
    try {
        $stmt->execute();
    } catch(Exception $e){
        echo 'Error: '.$e;
    }
    $ride_id = $conn->insert_id; // get id of pk

    // upload multiple
    multiUpload("INSERT INTO locstart (ride_id, location) VALUES (?, ?)", $ride_id, $arr_locStart);
    multiUpload("INSERT INTO tsstart (fk_ride_id, timestamp) VALUES (?, ?)", $ride_id, $arr_tsStart);
    multiUpload("INSERT INTO tsstop (fk_ride_id, timestamp) VALUES (?, ?)", $ride_id, $arr_tsStop);

    $conn->close();
}
