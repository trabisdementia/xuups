<?php

/**
* $Id: admin_header.php 1561 2008-04-13 14:14:19Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once dirname(dirname(dirname(dirname(__FILE__)))) . "/mainfile.php";
include XOOPS_ROOT_PATH.'/modules/publisher/include/common.php';

if( !defined("PUBLISHER_ADMIN_URL") ){
	define('PUBLISHER_ADMIN_URL', PUBLISHER_URL . "/admin");
}

if (!defined("PUBLISHER_NOCPFUNC")) {
    include_once XOOPS_ROOT_PATH . "/include/cp_functions.php";

    $moduleperm_handler = & xoops_gethandler( 'groupperm' );
    if ( $xoopsUser ) {
        $module_handler =& xoops_gethandler('module');
        $xoopsModule =& $module_handler->getByDirname('publisher');
        if ( !$moduleperm_handler->checkRight( 'module_admin', $xoopsModule->getVar( 'mid' ), $xoopsUser->getGroups() ) ) {
            redirect_header( XOOPS_URL, 1, _NOPERM );
            exit();
        }
    } else {
        redirect_header( XOOPS_URL . "/user.php", 1, _NOPERM );
        exit();
    }

    // set config values for this module
    if ( $xoopsModule->getVar( 'hasconfig' ) == 1 || $xoopsModule->getVar( 'hascomments' ) == 1 ) {
        $config_handler = & xoops_gethandler( 'config' );
        $xoopsModuleConfig =  $config_handler->getConfigsByCat( 0, $xoopsModule->getVar( 'mid' ) );
    }

    xoops_loadLanguage('admin', 'publisher');
}

include_once XOOPS_ROOT_PATH . "/kernel/module.php";
include_once XOOPS_ROOT_PATH . "/class/tree.php";
include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";



$imagearray = array(
	'editimg' => "<img src='". PUBLISHER_IMAGES_URL ."/button_edit.png' alt='" . _AM_PUB_ICO_EDIT . "' align='middle' />",
    'deleteimg' => "<img src='". PUBLISHER_IMAGES_URL ."/button_delete.png' alt='" . _AM_PUB_ICO_DELETE . "' align='middle' />",
    'online' => "<img src='". PUBLISHER_IMAGES_URL ."/on.png' alt='" . _AM_PUB_ICO_ONLINE . "' align='middle' />",
    'offline' => "<img src='". PUBLISHER_IMAGES_URL ."/off.png' alt='" . _AM_PUB_ICO_OFFLINE . "' align='middle' />",
	);

$myts = &MyTextSanitizer::getInstance();
?>
