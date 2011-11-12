<?php

/**
 * $Id: admin_header.php,v 1.3 2005/04/19 18:20:55 fx2024 Exp $
 * Module: SmartClient
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

include_once "../../../mainfile.php";
include_once '../../../include/cp_header.php';
include_once XOOPS_ROOT_PATH . "/class/xoopsmodule.php";
include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";
include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

$myts = &MyTextSanitizer::getInstance();

?>