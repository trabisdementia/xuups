<?php

/**
 * $Id: about.php,v 1.6 2004/12/19 20:23:16 malanciault Exp $
 * Module: SmartPartner
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */


include_once("admin_header.php");

include_once(SMARTPARTNER_ROOT_PATH . "class/about.php");
$aboutObj = new SmartpartnerAbout(_AM_SPARTNER_ABOUT);
$aboutObj->render();

?>