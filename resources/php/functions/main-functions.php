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
            if($user = $result->fetch_assoc()){ // fetch row as array
                $dbUsername = $user['username'];
                $dbPassword = $user['password'];
                $dbUID = $user['pk_id'];
                $dbFirst = $user['first_name'];
                $dbAdmin = $user['admin'];


                // now compare
                if(password_verify($inpPassword,$dbPassword)){
                    echo 'auth ok';
                    session_start();
                    $_SESSION['loggedin'] = True;
                    $_SESSION['user_id'] = $dbUID;
                    $_SESSION['username'] = $dbUsername;
                    $_SESSION['first'] = $dbFirst;
                    if($dbAdmin == 1){
                        $_SESSION['admin'] = true;
                    } else {
                        $_SESSION['admin'] = false;
                    }
                    return true; // user authenticated
                } else {
                    return false; // user invalid
                }
            } else {
                return false;
            }
        } else {
            return false;
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
    include('../config.inc.php');

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
        $stmt = $conn->prepare($prep_st);
        $stmt->bind_param("is", $ride_id, $value);
        if(!$stmt->execute()){
            echo 'error inserting into db';
            return false;
        }
        $stmt->close();
    }
    $conn->close();
    return true;
}



// upload ride data
function uploadData($car,$arr_locStart,$arr_tsStart,$arr_tsStop,$kmStart,$kmStop){
    // include the setup script
    include('../config.inc.php');

    // Create connection
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // get id of car selected
    $stmt = $conn->prepare("SELECT pk_id FROM car WHERE name=?");
    $stmt->bind_param("s", $car);
    if($stmt->execute()){
        $result = $stmt->get_result(); // get the mysqli result
        $row = $result->fetch_assoc();
        $carID = $row['pk_id'];
    } else {
        echo "Error at function uploadData() unable to get car id";
        return false;
    }

    // first insert main ride, then get id and upload all arrays via foreach loop
    // prepare and bind ride
    $stmt = $conn->prepare('INSERT INTO ride (user, car, kmStart, kmEnd) VALUES (?, ?, ?, ?)');
    $stmt->bind_param("iiii", $_SESSION['user_id'], $carID, $kmStart, $kmStop);
    if(!$stmt->execute()){
        echo 'Error at function uploadData() cannot insert into db';
        return false;
    }
    $ride_id = $conn->insert_id; // get id of pk

    // upload multiple
    multiUpload("INSERT INTO locstart (ride_id, location) VALUES (?, ?)", $ride_id, $arr_locStart);
    multiUpload("INSERT INTO tsstart (fk_ride_id, timestamp) VALUES (?, ?)", $ride_id, $arr_tsStart);
    multiUpload("INSERT INTO tsstop (fk_ride_id, timestamp) VALUES (?, ?)", $ride_id, $arr_tsStop);

    $conn->close();
    return true;
}





/* 
    The following code is required to call the functions above

*/




// authenticate user after form submit
if(!empty($_POST['inpUsername']) && !empty($_POST['inpPassword'])){
    if(authUser()) {
        header('Location: /index.php?view=loggedin');
    } else {
        echo("Anmeldeinformationen nicht korrekt");
    }
}



// check if user is authenticated for the following part
if(session_id() === "") session_start();
if($_SESSION['loggedin'] !== true){
    header('Location: /index.php?view=login');
    die();
}


// getKM after ajax call
if(!empty($_POST['carSelected'])){
    echo(getKM($_POST['carSelected']));
}


// upload data after ride
if(!empty($_POST['carUP']) && !empty($_POST['ar_locStartUP']) && !empty($_POST['ar_tsStartUP']) && !empty($_POST['ar_tsStopUP']) && !empty($_POST['kmStartUP']) && !empty($_POST['kmStopUP'])){
    // convert to php format
    $car = addslashes($_POST['carUP']);
    $arr_locStart = json_decode($_POST['ar_locStartUP']);
    $arr_tsStart = json_decode($_POST['ar_tsStartUP']);
    $arr_tsStop = json_decode($_POST['ar_tsStopUP']);
    $kmStart = $_POST['kmStartUP'];
    $kmStop = $_POST['kmStopUP'];

    // call function and respond to user
    if(uploadData($car,$arr_locStart,$arr_tsStart,$arr_tsStop,$kmStart,$kmStop)){
        echo "Daten wurden erfolgreich gespeichert";
    } else {
        echo "Fehler: Daten konnten nicht gespeichert werden. Bitte Screenshot machen und manuell nachtragen.";
    }
}


if(isset($_POST['logout'])){
    // Unset all of the session variables.
    $_SESSION = array();

    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finally, destroy the session.
    session_destroy();
}