<?php

/**
* $Id: header.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once "../../mainfile.php";

if( !defined("PUBLISHER_DIRNAME") ){
	define("PUBLISHER_DIRNAME", 'publisher');
}

include_once XOOPS_ROOT_PATH.'/modules/' . PUBLISHER_DIRNAME . '/include/common.php';

include_once XOOPS_ROOT_PATH."/class/pagenav.php";
$myts = MyTextSanitizer::getInstance();

?>