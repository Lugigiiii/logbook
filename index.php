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




// check where to forward to
if(session_id() === "") session_start(); // starts the session
if(empty($_GET['view']) || !isset($_SESSION['loggedin'])){
    $_GET['view'] = 'login';
}




// if user has permission for admin backend, display selector where he can choose the interface
if($_GET['view'] === 'loggedin' && $_SESSION['admin']){
    $tpl->display('header-mobile.tpl');
    $tpl->display('pick-view.tpl'); 
    $tpl->display('footer-mobile.tpl'); 
    $_GET['view'] = 'mobile';
} elseif ($_GET['view'] === 'loggedin' && !$_SESSION['admin']) {
    header("Location: /index.php?view=mobile");
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
    $tpl->display('mobile.tpl'); 
    $tpl->display('footer-mobile.tpl'); 
}


if ($_GET['view']==='login') {
    // display tpl
    $tpl->assign('sitename', $SITE_NAME);
    if (isset($CLIENT_LOGO)){ // display logo if set
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
    $tpl->display('admin-header.tpl');
    $tpl->display('admin-main.tpl');
    $tpl->display('admin-footer.tpl');
}

if ($_GET['view']==='admin-cars') {
    // include main functions
    include_once('resources/php/functions/main-functions.php');

    $tpl->assign('username', $_SESSION['username']);
    $tpl->assign('sitename', $SITE_NAME);
    $tpl->assign('companyname',$COMPANY_NAME);
    $tpl->display('admin-header.tpl');
    $tpl->display('admin-cars.tpl');
    $tpl->display('admin-footer.tpl');
}

if ($_GET['view']==='admin-users') {
    // include main functions
    include_once('resources/php/functions/main-functions.php');

    $tpl->assign('username', $_SESSION['username']);
    $tpl->assign('sitename', $SITE_NAME);
    $tpl->assign('companyname',$COMPANY_NAME);
    $tpl->display('admin-header.tpl');
    $tpl->display('admin-users.tpl');
    $tpl->display('admin-footer.tpl');
}



