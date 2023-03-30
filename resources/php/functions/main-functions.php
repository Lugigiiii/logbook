<?php
// function to authenticate user
function authUser(){
    include_once('../config.inc.php'); // include the setup script
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // DB Create connection

    $inpUsername = addslashes($_POST['inpUsername']); // get data
    $inpPassword = $_POST['inpPassword']; // get data

    if ($conn->connect_error) { // Check connection
        die("Connection failed: " . $conn->connect_error);
    }

    if($LDAP_AUTH) { // check if site is set to ldap auth
        return false;
    }

    if(!$LDAP_AUTH) { // just use db authentication  
        $stmt = $conn->prepare("SELECT * FROM user WHERE username=?");
        $stmt->bind_param("s", $inpUsername);
        if($stmt->execute()){
            $result = $stmt->get_result(); // get the mysqli result
            $user = $result->fetch_assoc(); // fetch row as array
            $dbUsername = $user['username'];
            $dbPassword = $user['password'];
            $dbUID = $user['pk_id'];
            $dbFirst = $user['first_name'];

            var_dump(password_verify($inpPassword,$dbPassword));

            // now compare
            if(password_verify($inpPassword,$dbPassword)){
                echo 'auth ok';
                session_start();
                $_SESSION['user_id'] = $dbUID;
                $_SESSION['username'] = $dbUsername;
                $_SESSION['first'] = $dbFirst;
                return true; // user authenticated
            } else {
                echo 'auth not ok';
                return false; // user invalid
            }
        } else {
            echo 'unable to connect to database';
        }
    }
}





// load car from array and show html dropdown for mobile selection
function loadCar() {
    include('resources/php/config.inc.php'); // include the setup script

    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // DB Create connection

    if ($conn->connect_error) { // Check connection
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM car WHERE active=1");
    if($stmt->execute()){
        $carsArray = []; // set empty array
        $result = $stmt->get_result(); // get the mysqli result
        while($row = $result->fetch_assoc()){ // fetch row as array
            array_push($carsArray,$row['name']);
        }

        $html = '<select class="inp-fw" name="car" id="car-selector" type="text">';
        $html .= '<option value="" default>Fahrzeug...</option>';
        foreach ($carsArray as $value) {
            $html .= "<option value='{$value}'>{$value}</option>";
        }
        $html .= '</select>';
        return $html;
    } else {
        echo 'unable to connect to database';
        die();
    }

    $conn->close();
}




// function to get last driven km
function getKM($car){
    include('../config.inc.php'); // include the setup script

    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // DB Create connection

    if ($conn->connect_error) { // Check connection
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT MAX(ride.kmEnd) AS lastKM, car.name FROM ride INNER JOIN car ON ride.car=car.pk_id WHERE car.name=?");
    $stmt->bind_param("s", $car);
    if($stmt->execute()){
        $result = $stmt->get_result(); // get the mysqli result
        $row = $result->fetch_assoc();

        if(!empty($row['lastKM'])){ // check if data present
            return intval($row['lastKM']);
        } else {
            return;
        }

    } else {
        echo 'unable to get km from database';
        die();
    }
    $conn->close();
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
        $stmt->bind_param("is", $ride_id, $value);
        if(!$stmt->execute()){
            echo 'error inserting into db';
            die();
        }
        $stmt->close();

    }
    $conn->close();
}



// upload ride data
function uploadData($car,$arr_locStart,$arr_tsStart,$arr_tsStop,$kmStart,$kmStop){
    // include the setup script
    include('resources/php/config.inc.php');

    // start session
    session_start();

    // Create connection
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // first insert main ride, then get id and upload all arrays via foreach loop
    // prepare and bind ride
    $stmt = $conn->prepare('INSERT INTO ride (user, car, kmStart, kmEnd) VALUES (?, ?, ?, ?)');
    $stmt->bind_param("isii", $_SESSION['user_id'], $car, $kmStart, $kmStop);
    if(!$stmt->execute()){
        echo 'Error inserting into db';
        die();
    }
    $ride_id = $conn->insert_id; // get id of pk

    // upload multiple
    multiUpload("INSERT INTO locstart (ride_id, location) VALUES (?, ?)", $ride_id, $arr_locStart);
    multiUpload("INSERT INTO tsstart (fk_ride_id, timestamp) VALUES (?, ?)", $ride_id, $arr_tsStart);
    multiUpload("INSERT INTO tsstop (fk_ride_id, timestamp) VALUES (?, ?)", $ride_id, $arr_tsStop);

    $conn->close();
}






// authenticate user after form submit
if(!empty($_POST['inpUsername']) && !empty($_POST['inpPassword'])){
    if(authUser()) {
        header('Location: /index.php?view=mobile');
    }
}


// getKM after ajax call
if(!empty($_POST['carSelected'])){
    echo(getKM($_POST['carSelected']));
}