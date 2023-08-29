<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// function to authenticate user
function authUser(){
    // include the setup script
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= '/resources/php/config.inc.php';
    include($path);
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // DB Create connection

    $inpUsername = htmlspecialchars(addslashes($_POST['inpUsername'])); // get data
    $inpPassword = htmlspecialchars(addslashes($_POST['inpPassword'])); // get data

    if ($conn->connect_error) { // Check connection
        die("Connection failed: " . $conn->connect_error);
    }

    if($LDAP_AUTH) { // check if site is set to ldap auth
        // connect to ldap server
        if($LDAP_SSL){
            $ldapconn = ldap_connect("ldaps://".$LDAP_SERVER.":".$LDAP_PORT);
        } else {
            $ldapconn = ldap_connect("ldap://".$LDAP_SERVER.":".$LDAP_PORT);
        }

        // necessary settings
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
        ldap_set_option($ds, LDAP_OPT_NETWORK_TIMEOUT, 10);

        // check if connection successful
        if($ldapconn){
            $ldaprdn = "uid=".$inpUsername.",".$LDAP_BASE_DN; // ldap url to lookup user
            if($ldapbind = ldap_bind($ldapconn, $ldaprdn, $inpPassword)) {
                // auth successful, now check group
                // then set session
                // return true for login
                return true;

            } else {
                return false;
            }
        } else {
            // unable to connect to ldap server
            return false;
        }
    }

    if(!$LDAP_AUTH) { // just use db authentication  
        $stmt = $conn->prepare("SELECT * FROM user WHERE username=? AND active = 1");
        $stmt->bind_param("s", $inpUsername);
        if($stmt->execute()){
            $result = $stmt->get_result(); // get the mysqli result
            if($user = $result->fetch_assoc()){ // fetch row as array
                $dbUsername = $user['username'];
                $dbPassword = $user['password'];
                $dbUID = $user['pk_id'];
                $dbFirst = $user['first_name'];
                $mail = $user['email'];
                $dbAdmin = $user['admin'];

                // close connection
                $stmt->close();
                $conn->close();


                // now compare
                if(password_verify($inpPassword,$dbPassword)){
                    session_start();
                    $_SESSION['loggedin'] = True;
                    $_SESSION['user_id'] = $dbUID;
                    $_SESSION['username'] = $dbUsername;
                    $_SESSION['first'] = $dbFirst;
                    $_SESSION['mail'] = $mail;
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
    // include the setup script
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= '/resources/php/config.inc.php';
    include($path);

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

        $stmt->close();
        $conn->close();

        return $html;
    } else {
        echo 'unable to connect to database';
        die();
    }
    $conn->close();
}




// function to get last driven km
function getKM($car){
    // include the setup script
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= '/resources/php/config.inc.php';
    include($path);

    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // DB Create connection

    if ($conn->connect_error) { // Check connection
        die("Connection failed: " . $conn->connect_error);
    }

    $car = htmlspecialchars(addslashes($car));

    $stmt = $conn->prepare("SELECT MAX(ride.kmEnd) AS lastKM, car.name FROM ride INNER JOIN car ON ride.car=car.pk_id WHERE car.name=? AND ride.deleted NOT LIKE 1");
    $stmt->bind_param("s", $car);
    if($stmt->execute()){
        $result = $stmt->get_result(); // get the mysqli result
        $row = $result->fetch_assoc();

        $stmt->close();
        $conn->close();

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
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= '/resources/php/config.inc.php';
    include($path);

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
        $value = addslashes(htmlspecialchars($value));
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
function uploadData($car,$arr_locStart,$arr_tsStart,$arr_tsStop,$kmStart,$kmStop,$tsUP,$manual){
    // include the setup script
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= '/resources/php/config.inc.php';
    include($path);

    // Create connection
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // shell escape for XSS prevention
    $car = htmlspecialchars(addslashes($car));
    $kmStart = htmlspecialchars($kmStart);
    $kmStop = htmlspecialchars($kmStop);
    $manual = htmlspecialchars($manual);

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
    $stmt = $conn->prepare('INSERT INTO ride (user, car, kmStart, kmEnd, deleted, ts, manual) VALUES (?, ?, ?, ?, 0, ?, ?)');
    $stmt->bind_param("iiiisi", $_SESSION['user_id'], $carID, $kmStart, $kmStop, $tsUP,$manual);
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


// functions for admin backend


// gets startts or stopts
function getTS($ride_id,$table, $order){
    // include the setup script
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= '/resources/php/config.inc.php';
    include($path);

    // Create connection
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // XSS prevention
    $ride_id = htmlspecialchars(addslashes($ride_id));
    $table = htmlspecialchars(addslashes($table));
    $order = htmlspecialchars(addslashes($order));

    // get starting timestamp
    $stmt = $conn->query("SELECT timestamp FROM ".$table." WHERE fk_ride_id = {$ride_id} ORDER BY timestamp ".$order." LIMIT 1");
    if($result = $stmt->fetch_assoc()){
        $ts = $result['timestamp'];
    } else {
        $ts = 0;
    }
    $stmt->free_result();
    $conn->close();


    return $ts;
}

// gets location string from db
function getLocation($ride_id){
    // include the setup script
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= '/resources/php/config.inc.php';
    include($path);

    // Create connection
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // XSS prevention
    $ride_id = htmlspecialchars(addslashes($ride_id));

    // get locations
    $stmt = $conn->query("SELECT location FROM locstart WHERE ride_id = {$ride_id}");
    $result = $stmt->fetch_all();
    $stmt->free_result();
    $locations = ''; // locations string
    $i = 0;
    foreach($result as $row){
        $locations .= $row[0];
        if(count($result)-1 != $i){
            $locations .= ' - ';
        }
        $i++;
    }
    $conn->close();

    return $locations;
}

// gets data of all rides in db
function getRides(){
    // include the setup script
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= '/resources/php/config.inc.php';
    include($path);

    // Create connection
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $data = array();

    $result = $conn->query("SELECT ride.pk_id, user.first_name, user.last_name, car.name, ride.kmStart, ride.kmEnd, ride.deleted, ride.manual FROM ride INNER JOIN user ON ride.user = user.pk_id INNER JOIN car ON ride.car = car.pk_id ORDER BY ride.ts DESC");
    $rows = $result->fetch_all();
    $result->free_result();
    $conn->close();
    foreach($rows as $row){
        // store current data
        $ride_id = $row[0];
        $name = $row[1]." ".$row[2];
        $kmStart = $row[4];
        $car = $row[3];
        $deleted = $row[6];
        $manual = $row[7];
        $kmEnd = $row[5];

        // query for further data
        $tsstart = intval(getTS($ride_id,'tsstart','ASC') / 1000);
        $tsstop = intval(getTS($ride_id,'tsstop','DESC') / 1000);
        $locations = getLocation($ride_id);


        $res = array(
            $tsstart,
            $tsstop,
            $car,
            $kmStart,
            $locations, 
            $name,
            $ride_id,
            $deleted,
            $manual,
            $kmEnd
        );

        array_push($data, $res);
    }

    return $data;
}


/* function to load cars for page admin-cars */
function getCarsTable(){
    // include the setup script
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= '/resources/php/config.inc.php';
    include($path);

    // Create connection
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $data = array();

    $result = $conn->query("SELECT * FROM car");
    $rows = $result->fetch_all();
    $result->free_result();
    $conn->close();
    foreach($rows as $row){ // loop through all rows
        $res = array(); // array of current row
        foreach($row as $element){ // loop through current row
            if(!empty($element)){ // if empty, add "LEER" text, else push into array for current row
                array_push($res,$element);
            } else {
                array_push($res,'LEER');
            }
            
        }

        array_push($data, $res); // push row into full dataset
    }

    return $data;
}

/* function to change active element of car -> enable / disable */
function changeActiveCar($car, $updateVal){
    $car = intval(htmlspecialchars($car));
    $updateVal = intval(htmlspecialchars($updateVal));

    // include the setup script
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= '/resources/php/config.inc.php';
    include($path);

    // Create connection
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // perform statement
    $stmt = $conn->prepare("UPDATE car SET active = ? WHERE pk_id = ?");
    $stmt->bind_param('ii', $updateVal, $car);
    if(!$stmt->execute()){
        echo 'SQL error at changeActiveCar()';
        die();
    }
    $conn->close();
}

/* function to insert new car into db received from form on admin-cars */
function insertNewCar($carName, $carNumberplate, $carYear, $carActive){
    // include the setup script
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= '/resources/php/config.inc.php';
    include($path);

    // XSS prevention
    $carName = htmlspecialchars(addslashes($carName));
    $carNumberplate = htmlspecialchars(addslashes($carNumberplate));
    $carYear = htmlspecialchars(addslashes($carYear));
    $carActive = htmlspecialchars(addslashes($carActive));

    // Create connection
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // perform statement
    $stmt = $conn->prepare("INSERT INTO car (name, numberplate, year, active) VALUES (?,?,?,?)");
    $stmt->bind_param('ssii', $carName, $carNumberplate, $carYear, $carActive);
    if(!$stmt->execute()){
        echo 'SQL error at insertNewCar()';
        die();
    }
    $conn->close();
}



/* function to load users for page admin-users */
function getUsersTable(){
    // include the setup script
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= '/resources/php/config.inc.php';
    include($path);

    // Create connection
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $data = array();

    $result = $conn->query("SELECT pk_id, first_name, last_name, username, email, created, admin, active FROM user");
    $rows = $result->fetch_all();
    $result->free_result();
    $conn->close();
    foreach($rows as $row){ // loop through all rows
        $res = array(); // array of current row
        foreach($row as $element){ // loop through current row
            if(!empty($element)){ // if empty, add "LEER" text, else push into array for current row
                array_push($res,$element);
            } else {
                array_push($res,'LEER');
            }
            
        }

        array_push($data, $res); // push row into full dataset
    }

    return $data;
}


/* add or remove user from admin group via page admin-users */
function changeAdminUser($user, $updateVal){
    $user = intval(addslashes(htmlspecialchars($user)));
    $updateVal = intval(addslashes(htmlspecialchars($updateVal)));

    // include the setup script
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= '/resources/php/config.inc.php';
    include($path);

    // Create connection
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // perform statement
    $stmt = $conn->prepare("UPDATE user SET admin = ? WHERE pk_id = ?");
    $stmt->bind_param('ii', $updateVal, $user);
    if(!$stmt->execute()){
        echo 'SQL error at changeAdminUser()';
        die();
    }
    $conn->close();
}

/* function to insert new user into db received from form on admin-users */
function insertNewUser($newUserFirst, $newUserLast, $newUserName, $newUserMail, $newUserAdmin){
    // include the setup script
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= '/resources/php/config.inc.php';
    include($path);

    // include php mailer
    require '../phpmailer/Exception.php';
    require '../phpmailer/PHPMailer.php';
    require '../phpmailer/SMTP.php';


    // XSS prevention
    $newUserFirst = addslashes(htmlspecialchars($newUserFirst));
    $newUserLast = addslashes(htmlspecialchars($newUserLast));
    $newUserName = addslashes(htmlspecialchars($newUserName));
    $newUserMail = addslashes(htmlspecialchars($newUserMail));
    $newUserAdmin = addslashes(htmlspecialchars($newUserAdmin));
    


    // Create connection
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    // check if user already exists
    $stmt = $conn->query("SELECT * FROM user WHERE username = '{$newUserName}' OR email = '{$newUserMail}'");
    if($stmt->num_rows > 0){
        return 'Benutzer existiert bereits';
    }
    $stmt->close();


    // create token
    $activation_token = sha1(mt_rand(10000,99999).time().$newUserMail);
    $url = 'https://'.$SITE_DOMAIN.'/index.php?view=activate-user&token='.$activation_token.'&mail='.$newUserMail;

    // perform statement
    $stmt = $conn->prepare("INSERT INTO user (first_name, last_name, username, email, admin, activation_token) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param('ssssis', $newUserFirst, $newUserLast, $newUserName, $newUserMail, $newUserAdmin, $activation_token);
    if(!$stmt->execute()){
        echo 'SQL error at insertNewUser()';
        die();
    } else {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings                              // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $SMTP_HOST;                   // Specify main and backup SMTP servers
            $mail->SMTPAuth = $SMTP_AUTH;                               // Enable SMTP authentication
            $mail->Username = $SMTP_USERNAME;              // SMTP username
            $mail->Password = $SMTP_PASSWORD;                           // SMTP password
            $mail->SMTPSecure = $SMTP_ENCRYPTION;                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $SMTP_PORT;                                    // TCP port to connect to
            
        
            //Recipients
            $mail->setFrom($SMTP_USERNAME, $SITE_NAME);          //This is the email your form sends From
            $mail->addAddress($newUserMail, $newUserFirst." ".$newUserLast); // Add a recipient address
            $mail->addCC($_SESSION['mail'], $_SESSION['first']);
        
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Benutzerkonto aktivieren | '.$SITE_NAME;
            $mail->CharSet = 'UTF-8';
        
            $mail->Body    =
                '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                    <title>Benutzerkonto aktivieren | '.$SITE_NAME.'</title>
                </head>
                <body style="margin: 0; padding: 0;">
                <h1 style="text-align: center;">'.$SITE_NAME.'</h1>
                <img src="'.$COMPANY_LOGO.'" alt="Client Logo" style="margin: 20px; max-width: 200px; max-height: auto;">
                <hr />
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td>
                        <h2 style="margin-top: 20px;">Guten Tag, '.$newUserFirst.' '.$newUserLast.'</h2><br />
                            <p>Ein Benutzerkonto wurde für Sie auf '.$SITE_DOMAIN.' angelegt.</p><br />
                            <p>Öffnen Sie den Link, um ein Kennwort zu setzen und Ihr Benutzerkonto zu aktivieren: <a href="'.$url.'">'.$url.'</a><p><br />
                            <p>Die Applikation ermöglicht die Aufzeichnung von Fahrten und die digitale Führung eines Fahrtenbuchs für die Firma '.$COMPANY_NAME.'.</p>
                            <h5>'.$SITE_NAME.'</h5>
                            <small>The content of this email is confidential and intended for the recipient specified in message only. It is strictly forbidden to share any part of this message with any third party, without a written consent of the sender. If you received this message by mistake, please reply to this message and follow with its deletion, so that we can ensure such a mistake does not occur in the future.</small>
                        </td>
                    </tr>
                </table>
                </body>
                ';
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
        } catch (Exception $e) {
            die($e);
        }
    }
    $conn->close();
}

/* function to change active element of user -> enable / disable */
function changeActiveUser($user, $updateVal){
    $user = intval(addslashes(htmlspecialchars($user)));
    $updateVal = intval(addslashes(htmlspecialchars($updateVal)));

    // include the setup script
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= '/resources/php/config.inc.php';
    include($path);

    // Create connection
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // perform statement
    $stmt = $conn->prepare("UPDATE user SET active = ? WHERE password <> '' AND pk_id = ?");
    $stmt->bind_param('ii', $updateVal, $user);
    if(!$stmt->execute()){
        echo 'SQL error at changeActiveCar()';
        die();
    }
    $conn->close();
}




/* check if token of newly created user is valid */
function checkToken($token, $mail){
    $token = htmlspecialchars(addslashes($token));
    $mail = htmlspecialchars(addslashes($mail));

    // include the setup script
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= '/resources/php/config.inc.php';
    include($path);

    // Create connection
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // perform statement
    $stmt = $conn->prepare("SELECT username FROM user WHERE email = ? AND activation_token = ?");
    $stmt->bind_param('ss', $mail, $token);
    $stmt->execute();
    $data = $stmt->get_result();
    if($data->num_rows > 0){
        return true; // url ok
    } else {
        return false; // wrong
    }
    $stmt->close();
    $conn->close();
}


/* function to change password  of user */
function changePasswordUser($token, $mail, $inpPwd1, $inpPwd2){
    $token = htmlspecialchars(addslashes($token));
    $mail = htmlspecialchars(addslashes($mail));
    $inpPwd1 = htmlspecialchars(addslashes($inpPwd1));
    $inpPwd2 = htmlspecialchars(addslashes($inpPwd2));


    // include the setup script
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= '/resources/php/config.inc.php';
    include($path);

    // Create connection
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // check request
    if(!checkToken($token, $mail)){
        header('Location: /index.php?view=login');
        return;
    }

    // check if passwords match
    if($inpPwd1 !== $inpPwd2){
        return '<div class="alert alert-danger" role="alert">Kennwörter stimmen nicht überein!</div>';
    }

    $hashPwd = password_hash($inpPwd2, PASSWORD_DEFAULT);

    // perform statement
    $stmt = $conn->prepare("UPDATE user SET password = ?, activation_token = NULL, active = 1 WHERE activation_token = ? AND email = ? AND active = 0");
    $stmt->bind_param('sss', $hashPwd, $token, $mail);
    if(!$stmt->execute()){
        echo 'SQL error at changeActiveCar()';
        die();
    }
    return '<div class="alert alert-success" role="alert">Erfolgreich Gespeichert. <br />Navigiere zur <a href="/index.php?view=login">Login-Seite</a> und melde dich mit Benutzername und Passwort an.</div>'; 
    $conn->close();
}

function resetUser($uid){
    $uid = intval(htmlspecialchars($uid));

    // include the setup script
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= '/resources/php/config.inc.php';
    include($path);

    // include php mailer
    require '../phpmailer/Exception.php';
    require '../phpmailer/PHPMailer.php';
    require '../phpmailer/SMTP.php';

    // Create connection
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // perform statement
    $stmt = $conn->prepare("SELECT first_name, last_name, username, email FROM user WHERE pk_id = ?");
    $stmt->bind_param('i', $uid);
    if(!$stmt->execute()){
        echo 'SQL error at resetUser()';
        die();
    }
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    // bind to variables
    $name = $row['first_name'].' '.$row['last_name'];
    $username = $row['username'];
    $email = $row['email'];
    $activation_token = sha1(mt_rand(10000,99999).time().$email);
    $url = 'https://'.$SITE_DOMAIN.'/index.php?view=activate-user&token='.$activation_token.'&mail='.$email;

    $stmt->close();

    // remove password and set token
    $stmt = $conn->prepare("UPDATE user SET active = 0, password = '', activation_token = ? WHERE pk_id = ?");
    $stmt->bind_param('si', $activation_token, $uid);
    if(!$stmt->execute()){
        echo 'SQL error at resetUser()';
        die();
    }

    // inform user via Mail
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings                              // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $SMTP_HOST;                   // Specify main and backup SMTP servers
        $mail->SMTPAuth = $SMTP_AUTH;                               // Enable SMTP authentication
        $mail->Username = $SMTP_USERNAME;              // SMTP username
        $mail->Password = $SMTP_PASSWORD;                           // SMTP password
        $mail->SMTPSecure = $SMTP_ENCRYPTION;                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $SMTP_PORT;                                    // TCP port to connect to
        
    
        //Recipients
        $mail->setFrom($SMTP_USERNAME, $SITE_NAME);          //This is the email your form sends From
        $mail->addAddress($email, $name); // Add a recipient address
        $mail->addCC($_SESSION['mail'], $_SESSION['first']);
    
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Benutzerkonto aktivieren | '.$SITE_NAME;
        $mail->CharSet = 'UTF-8';
    
        $mail->Body    =
            '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <title>Benutzerkonto aktivieren | '.$SITE_NAME.'</title>
            </head>
            <body style="margin: 0; padding: 0;">
            <h1 style="text-align: center;">'.$SITE_NAME.'</h1>
            <img src="'.$COMPANY_LOGO.'" alt="Client Logo" style="margin: 20px; max-width: 200px; max-height: auto;">
            <hr />
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td>
                    <h2 style="margin-top: 20px;">Guten Tag, '.$name.'</h2><br />
                        <p>Ein Benutzerkonto wurde für Sie auf '.$SITE_DOMAIN.' angelegt.</p><br />
                        <p>Öffnen Sie den Link, um ein Kennwort zu setzen und Ihr Benutzerkonto zu aktivieren: <a href="'.$url.'">'.$url.'</a><p><br />
                        <p>Die Applikation ermöglicht die Aufzeichnung von Fahrten und die digitale Führung eines Fahrtenbuchs für die Firma '.$COMPANY_NAME.'.</p>
                        <h5>'.$SITE_NAME.'</h5>
                        <small>The content of this email is confidential and intended for the recipient specified in message only. It is strictly forbidden to share any part of this message with any third party, without a written consent of the sender. If you received this message by mistake, please reply to this message and follow with its deletion, so that we can ensure such a mistake does not occur in the future.</small>
                    </td>
                </tr>
            </table>
            </body>
            ';
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
    } catch (Exception $e) {
        die($e);
    }
}

/* function to delete ride */

function delRide($ride_id){
    $ride_id = intval(htmlspecialchars($ride_id));

    // include the setup script
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= '/resources/php/config.inc.php';
    include($path);

    // Create connection
    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // perform statement
    $stmt = $conn->prepare("UPDATE ride SET deleted = 1 WHERE pk_id = ?");
    $stmt->bind_param('i', $ride_id);
    if(!$stmt->execute()){
        echo 'SQL error at delRide()';
        die();
    }
    $conn->close();
}

// check if submitted km is larger than stored value
function checkKmStart($car, $km){
    // include the setup script
    $path = $_SERVER['DOCUMENT_ROOT'];
    $path .= '/resources/php/config.inc.php';
    include($path);

    $car = addslashes(htmlspecialchars($car));

    $conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME); // DB Create connection

    if ($conn->connect_error) { // Check connection
        die("Connection failed: " . $conn->connect_error);
    }

    $car = htmlspecialchars(addslashes($car));
    $km = intval($km);

    $stmt = $conn->prepare("SELECT MAX(ride.kmEnd) AS lastKM, car.name FROM ride INNER JOIN car ON ride.car=car.pk_id WHERE car.name=? AND ride.deleted NOT LIKE 1");
    $stmt->bind_param("s", $car);
    if($stmt->execute()){
        $result = $stmt->get_result(); // get the mysqli result
        $row = $result->fetch_assoc();

        $stmt->close();
        $conn->close();

        if(!empty($row['lastKM'])){ // check if data present
            // check if submitted data is larger than stored data
            if($km >= $row['lastKM']){
                return true;
            } else {
                return false;
            }
        } else {
            return true;
        }

    } else {
        echo 'unable to get km from database';
        die();
    }
    $conn->close();
}





































/* 
    The following code is required to call the functions above

*/




// authenticate user after form submit
/*
if(!empty($_POST['inpUsername']) && !empty($_POST['inpPassword'])){
    if(authUser()) {
        header('Location: /index.php?view=mobile');
    } else {
        header("Location: /index.php?view=login");
    }
}
*/

if(!empty($_POST['inpUsername']) && !empty($_POST['inpPassword'])){
    if(authUser()) {
        header('Content-Type: application/json');
        die(json_encode(['status' => 'success', 'message' => 'User authenticated']));
    } else {
        header('Content-Type: application/json');
        die(json_encode(['status' => 'error', 'message' => 'Invalid credentials']));
    }
}




// check if user is authenticated for the following part
if(session_id() === "") session_start();
if(!isset($_SESSION) && $_SESSION['loggedin'] !== true && $_GET['view'] !== 'activate-user'){
    header('Location: /index.php?view=login');
    die();
}


// getKM after ajax call
if(!empty($_POST['carSelected']) && !empty($_POST['kmEntered'])){
    // user submitted km value and wanted to start ride
    if(checkKmStart($_POST['carSelected'], $_POST['kmEntered'])){
        header('Content-Type: application/json');
        die(json_encode(['status' => 'success', 'message' => 'KM ok']));
    } else {
        header('Content-Type: application/json');
        die(json_encode(['status' => 'failure', 'message' => 'KM to small']));
    }
} elseif(!empty($_POST['carSelected'])){
    // user selected car and requests last km value
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
    $tsUP = $_POST['tsUP'];
    if(empty($_POST['manual'])){
        $manual = 0;
    } else {
        $manual = $_POST['manual'];
    }

    // call function and respond to user
    if(uploadData($car,$arr_locStart,$arr_tsStart,$arr_tsStop,$kmStart,$kmStop,$tsUP, $manual)){
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

    header("Location: /index.php?view=login");
    // Finally, destroy the session.
    session_destroy();
}


// edit data from table
if(!empty($_GET['edit']) &&  $_GET['edit'] == true){

    // change active bool of car
    if(!empty($_GET['car']) && isset($_GET['active'])){
        changeActiveCar($_GET['car'], $_GET['active']);
        header("Location: /index.php?view=admin-cars");
    }

    // add or remove user from group admin
    if(!empty($_GET['user']) && isset($_GET['admin'])){
        changeAdminUser($_GET['user'], $_GET['admin']);
        header("Location: /index.php?view=admin-users");
    }

    // set user active or inactive
    if(!empty($_GET['user']) && isset($_GET['active'])){
        changeActiveUser($_GET['user'], $_GET['active']);
        header("Location: /index.php?view=admin-users");
    }

    // reset password
    if(!empty($_GET['user']) && isset($_GET['reset']) && $_GET['reset'] == true){
        resetUser($_GET['user']);
        header("Location: /index.php?view=admin-users");
    }

    // del ride
    
    if(!empty($_GET['ride']) && isset($_GET['del']) && $_GET['del'] == true){
        delRide($_GET['ride']);
        header("Location: /index.php?view=admin");
    }
    
}



// add new car to database from form on admin-cars
if(isset($_POST['carName']) && isset($_POST['carNumberplate']) && isset($_POST['carYear'])){
    $carName = addslashes($_POST['carName']);
    $carNumberplate = addslashes($_POST['carNumberplate']);
    $carYear = intval($_POST['carYear']);
    if(isset($_POST['carActive'])){
        $carActive = 1;
    } else {
        $carActive = 0;
    }

    insertNewCar($carName, $carNumberplate, $carYear, $carActive);
    header("Location: /index.php?view=admin-cars");
}

// add new user to database from form on admin-users
if(isset($_POST['newUserFirst']) && isset($_POST['newUserLast']) && isset($_POST['newUserName']) && isset($_POST['newUserMail'])){
    $newUserFirst = addslashes($_POST['newUserFirst']);
    $newUserLast = addslashes($_POST['newUserLast']);
    $newUserName = addslashes($_POST['newUserName']);
    $newUserMail = addslashes($_POST['newUserMail']);
    if(isset($_POST['newUserAdmin'])){
        $newUserAdmin = 1;
    } else {
        $newUserAdmin = 0;
    }

    insertNewUser($newUserFirst, $newUserLast, $newUserName, $newUserMail, $newUserAdmin);
    header("Location: /index.php?view=admin-users");
}


// hook for changePassword()
if(isset($_POST['changePwd']) && isset($_POST['activation_token']) && isset($_POST['mail']) && isset($_POST['inpPwd1']) && isset($_POST['inpPwd2'])){
    echo(changePasswordUser($_POST['activation_token'], $_POST['mail'], $_POST['inpPwd1'], $_POST['inpPwd2']));
}