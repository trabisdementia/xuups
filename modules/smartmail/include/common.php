<?php

/**
 * $Id: common.php,v 1.4 2006/09/11 20:53:50 marcan Exp $
 * Module: SmartShop
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}
if( !defined("SMARTMAIL_DIRNAME") ){
    define("SMARTMAIL_DIRNAME", 'smartmail');
}

if( !defined("SMARTMAIL_URL") ){
    define("SMARTMAIL_URL", XOOPS_URL.'/modules/'.SMARTMAIL_DIRNAME.'/');
}
if( !defined("SMARTMAIL_ROOT_PATH") ){
    define("SMARTMAIL_ROOT_PATH", XOOPS_ROOT_PATH.'/modules/'.SMARTMAIL_DIRNAME.'/');
}

if( !defined("SMARTMAIL_IMAGES_URL") ){
    define("SMARTMAIL_IMAGES_URL", SMARTMAIL_URL.'/images/');
}

/** Include SmartObject framework **/
include_once XOOPS_ROOT_PATH.'/modules/smartobject/class/smartloader.php';
include(SMARTOBJECT_ROOT_PATH . "class/smartobjectcategory.php");

/*
 * Including the common language file of the module
 */
$fileName = SMARTMAIL_ROOT_PATH . 'language/' . $GLOBALS['xoopsConfig']['language'] . '/common.php';
if (!file_exists($fileName)) {
    $fileName = SMARTMAIL_ROOT_PATH . 'language/english/common.php';
}

include_once($fileName);

include_once(SMARTMAIL_ROOT_PATH . "class/newsletter.php");
include_once(SMARTMAIL_ROOT_PATH . "class/subscriber.php");
include_once(SMARTMAIL_ROOT_PATH . "include/functions.php");

// Creating the SmartModule object
$smartContentModule =& smart_getModuleInfo('smartmail');

// Find if the user is admin of the module
$smartmail_isAdmin = smart_userIsAdmin('smartmail');

$myts = MyTextSanitizer::getInstance();
$smartmail_moduleName = $smartContentModule->getVar('name');

// Creating the SmartModule config Object
$smartContentConfig =& smart_getModuleConfig('smartmail');

// Creating the Newsletter handler
$smartmail_newsletter_handler = xoops_getmodulehandler('newsletter','smartmail');

// Creating the Subscriber handler
$smartmail_subscriber_handler = xoops_getmodulehandler('subscriber','smartmail');

?>