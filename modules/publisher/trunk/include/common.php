<?php

/**
* $Id: common.php 3433 2008-07-05 10:24:09Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

if (!defined("PUBLISHER_DIRNAME")) {
	define("PUBLISHER_DIRNAME", 'publisher');
}

if (!defined("PUBLISHER_URL")) {
	define("PUBLISHER_URL", XOOPS_URL . '/modules/' . PUBLISHER_DIRNAME);
}

if (!defined("PUBLISHER_ROOT_PATH")) {
	define("PUBLISHER_ROOT_PATH", XOOPS_ROOT_PATH . '/modules/' . PUBLISHER_DIRNAME);
}

if (!defined("PUBLISHER_IMAGES_URL")) {
	define("PUBLISHER_IMAGES_URL", PUBLISHER_URL . '/images');
}

/** Configuring the module level of available features
 *
 * 0  = light mode
 * 10 = full mode
 */
if(!defined("PUBLISHER_LEVEL")){
	define("PUBLISHER_LEVEL", 10);
}

xoops_loadLanguage('common', 'publisher');

include_once PUBLISHER_ROOT_PATH ."/include/functions.php";
include_once PUBLISHER_ROOT_PATH ."/include/seo_functions.php";
include_once PUBLISHER_ROOT_PATH ."/class/keyhighlighter.class.php";
include_once PUBLISHER_ROOT_PATH ."/class/smartmetagen.php";
include_once PUBLISHER_ROOT_PATH ."/class/permission.php";
include_once PUBLISHER_ROOT_PATH ."/class/category.php";
include_once PUBLISHER_ROOT_PATH ."/class/item.php";
include_once PUBLISHER_ROOT_PATH ."/class/file.php";
include_once PUBLISHER_ROOT_PATH ."/class/session.php";

// Check XOOPS version to see if we are on XOOPS 2.2.x plateform
$xoops22 = publisher_isXoops22();

// Creating the SmartModule object
$publisher_handler =& publisher_getModuleInfo();

$publisher_moduleName = $publisher_handler->getVar('name');

// Find if the user is admin of the module
$publisher_isAdmin = publisher_userIsAdmin();

// Creating the SmartModule config Object
$publisher_config =& publisher_getModuleConfig();

// Loading handlers
$publisher_item_handler =& xoops_getmodulehandler('item', PUBLISHER_DIRNAME);
$publisher_category_handler =& xoops_getmodulehandler('category', PUBLISHER_DIRNAME);
$publisher_permission_handler =& xoops_getmodulehandler('permission', PUBLISHER_DIRNAME);
$publisher_file_handler =& xoops_getmodulehandler('file', PUBLISHER_DIRNAME);

// get current page
$publisher_current_page = publisher_getCurrentPage();

?>
