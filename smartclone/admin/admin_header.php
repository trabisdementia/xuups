<?php

/**
 * $Id: admin_header.php,v 1.1 2006/11/02 17:25:04 marcan Exp $
 * Module: SmartClone
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

if (!defined("SMARTCLONE_NOCPFUNC")) {
    include_once '../../../include/cp_header.php';
}

include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

include_once XOOPS_ROOT_PATH.'/modules/smartclone/include/common.php';

if( !defined("SMARTCLONE_ADMIN_URL") ){
    define('SMARTCLONE_ADMIN_URL', SMARTCLONE_URL . "admin/");
}

if( !defined("SMARTCLONE_ADMIN_ROOT_PATH") ){
    define('SMARTCLONE_ADMIN_ROOT_PATH', SMARTCLONE_ROOT_PATH . "admin/");
}

?>