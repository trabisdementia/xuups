<?php

/**
 * $Id: about.php 159 2007-12-17 16:44:05Z malanciault $
 * Module: SmartObject
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */
//
include_once("admin_header.php");

include_once(SMARTOBJECT_ROOT_PATH . "class/smartobjectabout.php");
$aboutObj = new SmartobjectAbout();
$aboutObj->render();

?>