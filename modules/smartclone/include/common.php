<?php

/**
 * $Id: common.php,v 1.1 2006/11/02 17:25:05 marcan Exp $
 * Module: SmartClone
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

if( !defined("SMARTCLONE_DIRNAME") ){
    define("SMARTCLONE_DIRNAME", 'smartclone');
}

if( !defined("SMARTCLONE_URL") ){
    define("SMARTCLONE_URL", XOOPS_URL.'/modules/'.SMARTCLONE_DIRNAME.'/');
}
if( !defined("SMARTCLONE_ROOT_PATH") ){
    define("SMARTCLONE_ROOT_PATH", XOOPS_ROOT_PATH.'/modules/'.SMARTCLONE_DIRNAME.'/');
}

if( !defined("SMARTCLONE_IMAGES_URL") ){
    define("SMARTCLONE_IMAGES_URL", SMARTCLONE_URL.'/images/');
}

/** Include SmartObject Framework **/
include_once XOOPS_ROOT_PATH.'/modules/smartobject/include/common.php';

include_once(SMARTCLONE_ROOT_PATH . "include/functions.php");

// Creating the SmartModule object
$smartclone_module =& smart_getModuleInfo(SMARTCLONE_DIRNAME);

// Find if the user is admin of the module
$smartclone_isAdmin = smart_userIsAdmin(SMARTCLONE_DIRNAME);

$myts = MyTextSanitizer::getInstance();
$smartclone_moduleName = $smartclone_module->getVar('name');

// Creating the SmartModule config Object
$smartclone_config =& smart_getModuleConfig(SMARTCLONE_DIRNAME);

?>