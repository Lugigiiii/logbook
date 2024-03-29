<?php

/**
 * Project: Logbook
 * Author: Luigi Coletti
 * File: index.php
 * Version: 1.0
 */


// define smarty lib directorysmarty
define('SMARTY_DIR', 'resources/php/smarty-4.2.1/libs/');
// include the setup script
require_once('resources/php/config.inc.php');
// include smarty
require(SMARTY_DIR.'Smarty.class.php');



// load smarty
$tpl = new Smarty();
$tpl->compile_check = true;
$tpl->caching = false;
$tpl->debugging = false;
$tpl->template_dir = 'tpl/';
$tpl->compile_dir = 'tpl/cache/'; 


// views
$views = array("login", "activate-user", "mobile", "admin", "admin-users", "admin-cars");




// check where to forward to
if(session_id() === "") session_start(); // starts the session






// check for activation url
if(!empty($_GET['view']) && $_GET['view'] === 'activate-user' && !empty($_GET['token']) && !empty($_GET['mail'])){ // forward to activation page
    // include main functions
    include_once('resources/php/functions/main-functions.php');

    if(checkToken($_GET['token'], $_GET['mail'])){ // this function checks if the token is valid
        // display tpl
        $tpl->assign('sitename', $SITE_NAME);
        $tpl->assign('token', $_GET['token']);
        $tpl->assign('mail', $_GET['mail']);
        if(isset($COMPANY_LOGO)){ // display logo if set
            $tpl->assign('logo',$COMPANY_LOGO);
        }
        $tpl->display('activate-account.tpl'); 
        die();
    } else {
        header('Location: /index.php?view=login');
    }
}


// check if user loggedin
if(!isset($_SESSION['loggedin']) || !in_array($_GET['view'], $views)){
    $_GET['view'] = 'login';
}






if ($_GET['view']==='mobile') {
    // include main functions
    include_once('resources/php/functions/main-functions.php');

    // get first name
    $first = $_SESSION['first'];

    // display tpl
    $tpl->assign('sitename', $SITE_NAME);
    $tpl->display('header-mobile.tpl'); 
    $tpl->assign('selector',loadCar());
    $tpl->assign('first',$first);
    $tpl->assign('admin',$_SESSION['admin']);
    $tpl->display('mobile.tpl'); 
    $tpl->display('footer-mobile.tpl'); 
}


if ($_GET['view']==='login') {
    if(isset($_SESSION['loggedin'])){
        header("Location: /index.php?view=mobile");
    }
    // display tpl
    $tpl->assign('sitename', $SITE_NAME);
    if (isset($COMPANY_LOGO)){ // display logo if set
        $tpl->assign('logo',$COMPANY_LOGO);
    }
    $tpl->display('login.tpl');
}


if ($_GET['view']==='admin') {
    // include main functions
    include_once('resources/php/functions/main-functions.php');

    $tpl->assign('username', $_SESSION['username']);
    $tpl->assign('sitename', $SITE_NAME);
    $tpl->assign('companyname',$COMPANY_NAME);
    $tpl->assign('data',getRides());
    $tpl->assign('admin',$_SESSION['admin']);
    $tpl->display('admin-header.tpl');
    $tpl->display('admin-main.tpl');
    $tpl->display('admin-footer.tpl');
}

if ($_GET['view']==='admin-cars') {
    if(!$_SESSION['admin']) {
        header("Location: /index.php?view=mobile");
        die();
    }

    // include main functions
    include_once('resources/php/functions/main-functions.php');

    $tpl->assign('username', $_SESSION['username']);
    $tpl->assign('sitename', $SITE_NAME);
    $tpl->assign('companyname',$COMPANY_NAME);
    $tpl->assign('data',getCarsTable());
    $tpl->assign('admin',$_SESSION['admin']);
    $tpl->display('admin-header.tpl');
    $tpl->display('admin-cars.tpl');
    $tpl->display('admin-footer.tpl');
}

if ($_GET['view']==='admin-users') {
    if(!$_SESSION['admin']) {
        header("Location: /index.php?view=mobile");
        die();
    }

    // include main functions
    include_once('resources/php/functions/main-functions.php');

    $tpl->assign('username', $_SESSION['username']);
    $tpl->assign('sitename', $SITE_NAME);
    $tpl->assign('companyname',$COMPANY_NAME);
    $tpl->assign('data',getUsersTable());
    $tpl->assign('admin',$_SESSION['admin']);
    $tpl->display('admin-header.tpl');
    $tpl->display('admin-users.tpl');
    $tpl->display('admin-footer.tpl');
}

