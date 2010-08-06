<?php

/**
 * $Id: about.php,v 1.1 2006/11/02 17:25:04 marcan Exp $
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