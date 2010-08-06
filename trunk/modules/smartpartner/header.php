<?php

/**
 * $Id: header.php,v 1.5 2005/04/21 15:09:31 malanciault Exp $
 * Module: SmartPartner
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

include "../../mainfile.php";

/* We don't need this line, as a cool thing a find out :
 * include/common.php is included automatically as soon as we include the mainfile.php !
 */

include_once XOOPS_ROOT_PATH.'/modules/' . SMARTPARTNER_DIRNAME . '/include/common.php';
include SMARTPARTNER_ROOT_PATH.'include/metagen.php';
include XOOPS_ROOT_PATH."/class/pagenav.php";

$myts =& MyTextSanitizer::getInstance();

?>