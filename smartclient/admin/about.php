<?php

/**
 * $Id: about.php,v 1.3 2005/04/19 18:20:55 fx2024 Exp $
 * Module: SmartClient
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */


include_once("admin_header.php");

include_once(SMARTCLIENT_ROOT_PATH . "class/about.php");
$aboutObj = new SmartclientAbout(_AM_SCLIENT_ABOUT);
$aboutObj->render();

?>