<?php

/**
* $Id: admin_header.php 1561 2008-04-13 14:14:19Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once "../../../mainfile.php";

if (!defined("PUBLISHER_NOCPFUNC")) {
	include_once '../../../include/cp_header.php';
}

include_once XOOPS_ROOT_PATH . "/kernel/module.php";
include_once XOOPS_ROOT_PATH . "/class/tree.php";
include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

include XOOPS_ROOT_PATH.'/modules/publisher/include/common.php';

if( !defined("PUBLISHER_ADMIN_URL") ){
	define('PUBLISHER_ADMIN_URL', PUBLISHER_URL . "admin");
}

$imagearray = array(
	'editimg' => "<img src='". PUBLISHER_IMAGES_URL ."/button_edit.png' alt='" . _AM_PUB_ICO_EDIT . "' align='middle' />",
    'deleteimg' => "<img src='". PUBLISHER_IMAGES_URL ."/button_delete.png' alt='" . _AM_PUB_ICO_DELETE . "' align='middle' />",
    'online' => "<img src='". PUBLISHER_IMAGES_URL ."/on.png' alt='" . _AM_PUB_ICO_ONLINE . "' align='middle' />",
    'offline' => "<img src='". PUBLISHER_IMAGES_URL ."/off.png' alt='" . _AM_PUB_ICO_OFFLINE . "' align='middle' />",
	);

$myts = &MyTextSanitizer::getInstance();
?>
