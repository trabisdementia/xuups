<?php

/**
 * $Id: common.php,v 1.2 2005/05/19 01:49:46 malanciault Exp $
 * Module: SmartMedia
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

if( !defined("SMARTMEDIA_DIRNAME") ){
    define("SMARTMEDIA_DIRNAME", 'smartmedia');
}

if( !defined("SMARTMEDIA_URL") ){
    define("SMARTMEDIA_URL", XOOPS_URL.'/modules/'.SMARTMEDIA_DIRNAME.'/');
}
if( !defined("SMARTMEDIA_ROOT_PATH") ){
    define("SMARTMEDIA_ROOT_PATH", XOOPS_ROOT_PATH.'/modules/'.SMARTMEDIA_DIRNAME.'/');
}

if( !defined("SMARTMEDIA_IMAGES_URL") ){
    define("SMARTMEDIA_IMAGES_URL", SMARTMEDIA_URL . "images/");
}

include_once(SMARTMEDIA_ROOT_PATH . "include/functions.php");

// Creating the SmartModule object
$smartModule =& smartmedia_getModuleInfo();
$myts = MyTextSanitizer::getInstance();
$smartmedia_moduleName = $myts->displayTarea($smartModule->getVar('name'));

$is_smartmedia_admin = (smartmedia_userIsAdmin());

// Creating the SmartModule config Object
$smartConfig =& smartmedia_getModuleConfig();

include_once(SMARTMEDIA_ROOT_PATH . "class/permission.php");
include_once(SMARTMEDIA_ROOT_PATH . "class/category.php");
include_once(SMARTMEDIA_ROOT_PATH . "class/category_text.php");
include_once(SMARTMEDIA_ROOT_PATH . "class/folder.php");
include_once(SMARTMEDIA_ROOT_PATH . "class/folder_text.php");
include_once(SMARTMEDIA_ROOT_PATH . "class/clip.php");
include_once(SMARTMEDIA_ROOT_PATH . "class/clip_text.php");
include_once(SMARTMEDIA_ROOT_PATH . "class/tabs.php");
include_once(SMARTMEDIA_ROOT_PATH . "class/format.php");

include_once(SMARTMEDIA_ROOT_PATH . "class/keyhighlighter.class.php");

// Creating the permission handler object
$smartmedia_permission_handler =& xoops_getmodulehandler('permission', SMARTMEDIA_DIRNAME);

// Creating the category handler object
$smartmedia_category_handler =& smartmedia_gethandler('category');

// Creating the category_text handler object
$smartmedia_category_text_handler =& smartmedia_gethandler('category_text');

// Creating the folder handler object
$smartmedia_folder_handler =& smartmedia_gethandler('folder');

// Creating the doler_text handler object
$smartmedia_folder_text_handler =& smartmedia_gethandler('folder_text');

// Creating the clip handler object
$smartmedia_clip_handler =& smartmedia_gethandler('clip');

// Creating the clip_text handler object
$smartmedia_clip_text_handler =& smartmedia_gethandler('clip_text');

// Creating the clip_text handler object
$smartmedia_format_handler =& smartmedia_gethandler('format');

?>