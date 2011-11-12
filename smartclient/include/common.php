<?php

/**
 * $Id: common.php,v 1.4 2005/04/19 18:20:56 fx2024 Exp $
 * Module: SmartClient
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

// This must contain the name of the folder in which reside SmartClient
if( !defined("SMARTCLIENT_DIRNAME") ){
    define("SMARTCLIENT_DIRNAME", 'smartclient');
}

if( !defined("SMARTCLIENT_URL") ){
    define("SMARTCLIENT_URL", XOOPS_URL.'/modules/'.SMARTCLIENT_DIRNAME.'/');
}
if( !defined("SMARTCLIENT_ROOT_PATH") ){
    define("SMARTCLIENT_ROOT_PATH", XOOPS_ROOT_PATH.'/modules/'.SMARTCLIENT_DIRNAME.'/');
}

include_once(SMARTCLIENT_ROOT_PATH . "include/functions.php");
include_once(SMARTCLIENT_ROOT_PATH . "class/keyhighlighter.class.php");

// Creating the client handler object
$client_handler =& smartclient_gethandler('client');


?>