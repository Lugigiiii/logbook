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

if(empty($_GET['view'])){
    $_GET['view'] = 'login';
}


if ($_GET['view']==='mobile') {
    // include mobile functions
    include('resources/php/functions/main-functions.php');
    

    // display tpl
    $smarty->display('header-mobile.tpl'); 
    $smarty->assign('selector',loadCar($CARS));
    $smarty->display('mobile.tpl'); 
    $smarty->display('footer-mobile.tpl'); 
}


if ($_GET['view']==='login') {
    // display tpl
    $smarty->display('login.tpl'); 
}

?>