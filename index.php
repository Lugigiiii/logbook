<?php

/**
 * Project: Logbook
 * Author: Luigi Coletti
 * File: index.php
 * Version: 1.0
 */



// define smarty lib directory
define('SMARTY_DIR', 'resources/php/smarty-4.2.1/libs/');
// include the setup script
require_once('resources/php/config.inc.php');
// include smarty
require(SMARTY_DIR.'Smarty.class.php');


// load smarty
$smarty = new Smarty();
$smarty->template_dir = 'tpl/';
$smarty->compile_dir = 'tpl/cache/'; 
$smarty->cache_dir = 'cache';




// check where to forward to
session_start(); // starts the session
if(empty($_GET['view']) || !isset($_SESSION['loggedin'])){
    $_GET['view'] = 'login';
}


// if user has permission for admin backend, display selector where he can choose the interface
if($_GET['view'] === 'loggedin' && $_SESSION['admin']){
    //$smarty->display('pick-view.tpl');  
    $_GET['view'] = 'mobile';
} elseif ($_GET['view'] === 'loggedin' && !$_SESSION['admin']) {
    $_GET['view'] = 'mobile';
}




if ($_GET['view']==='mobile') {
    // include mobile functions
    include('resources/php/functions/main-functions.php');

    // get first name
    $first = $_SESSION['first'];

    // display tpl
    $smarty->display('header-mobile.tpl'); 
    $smarty->assign('selector',loadCar());
    $smarty->assign('first',$first);
    $smarty->display('mobile.tpl'); 
    $smarty->display('footer-mobile.tpl'); 
}


if ($_GET['view']==='login') {
    // display tpl
    if (isset($CLIENT_LOGO)){ // display logo if set
        $smarty->assign('logo',$CLIENT_LOGO);
    }
    $smarty->display('login.tpl');
}

