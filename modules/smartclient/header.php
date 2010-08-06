<?php

/**
 * $Id: header.php,v 1.3 2005/04/19 18:20:56 fx2024 Exp $
 * Module: SmartClient
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

include "../../mainfile.php";
/* We don't need this line, as a cool thing a find out :
 * include/common.php is included automatically as soon as we include the mainfile.php !
 */

include_once XOOPS_ROOT_PATH.'/modules/' . SMARTCLIENT_DIRNAME . '/include/common.php';
include SMARTCLIENT_ROOT_PATH.'include/metagen.php';
include XOOPS_ROOT_PATH."/class/pagenav.php";

$myts =& MyTextSanitizer::getInstance();

?>