<?php

/**
 * $Id: common.php,v 1.6 2005/03/21 22:57:53 malanciault Exp $
 * Module: SmartPartner
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

// This must contain the name of the folder in which reside SmartPartner
if( !defined("SMARTPARTNER_DIRNAME") ){
    define("SMARTPARTNER_DIRNAME", 'smartpartner');
}

if( !defined("SMARTPARTNER_URL") ){
    define("SMARTPARTNER_URL", XOOPS_URL.'/modules/'.SMARTPARTNER_DIRNAME.'/');
}
if( !defined("SMARTPARTNER_ROOT_PATH") ){
    define("SMARTPARTNER_ROOT_PATH", XOOPS_ROOT_PATH.'/modules/'.SMARTPARTNER_DIRNAME.'/');
}

include_once(SMARTPARTNER_ROOT_PATH . "include/functions.php");
include_once(SMARTPARTNER_ROOT_PATH . "class/keyhighlighter.class.php");

// Creating the partner handler object
$partner_handler =& smartpartner_gethandler('partner');


?>