<?php

/**
 * $Id: common.php 3432 2008-07-05 10:16:49Z malanciault $
 * Module: SmartRental
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

global $xoopsConfig;

/**
 * SmartObject library path
 */
if (!defined('SMARTOBJECT_URL')) {
    define('SMARTOBJECT_URL', XOOPS_URL . "/modules/smartobject/");
}
if (!defined('SMARTOBJECT_ROOT_PATH')) {
    define('SMARTOBJECT_ROOT_PATH', XOOPS_ROOT_PATH . "/modules/smartobject/");
}
if (!defined('SMARTOBJECT_IMAGES_URL')) {
    define('SMARTOBJECT_IMAGES_URL', SMARTOBJECT_URL . "images/");
}
if (!defined('SMARTOBJECT_IMAGES_ROOT_PATH')) {
    define('SMARTOBJECT_IMAGES_ROOT_PATH', SMARTOBJECT_ROOT_PATH . "images/");
}
if (!defined('SMARTOBJECT_IMAGES_ACTIONS_URL')) {
    define('SMARTOBJECT_IMAGES_ACTIONS_URL', SMARTOBJECT_URL . "images/actions/");
}
if (!defined('SMARTOBJECT_IMAGES_ACTIONS_ROOT_PATH')) {
    define('SMARTOBJECT_IMAGES_ACTIONS_ROOT_PATH', SMARTOBJECT_ROOT_PATH . "images/actions/");
}

/**
 * Version of the SmartObject Framework
 */
include_once(SMARTOBJECT_ROOT_PATH . "include/version.php");
include_once(SMARTOBJECT_ROOT_PATH . "include/functions.php");
include_once(SMARTOBJECT_ROOT_PATH . "include/xoops_core_common_functions.php");

/**
 * Some constants used by the SmartObjects
 */
define('_SMART_GETVAR', 1);
define('_SMART_OBJECT_METHOD', 2);

/**
 * Include the common language constants for the SmartObject Framework
 */
/*
 if (!defined('SMARTOBJECT_COMMON_CONSTANTS')) {

 $common_file = SMARTOBJECT_ROOT_PATH . "language/" . $xoopsConfig['language'] . "/common.php";
 if (!file_exists($common_file)) {

 $common_file = SMARTOBJECT_ROOT_PATH . "language/english/common.php";
 }
 include($common_file);
 define('SMARTOBJECT_COMMON_CONSTANTS', true);
 }
 */
// get current page
$smart_current_page = smart_getCurrentPage();

// get previous page
$smart_previous_page = smart_getenv('HTTP_REFERER');

include_once(SMARTOBJECT_ROOT_PATH . "class/smartloader.php");

?>