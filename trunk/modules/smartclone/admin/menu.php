<?php

/**
 * $Id: menu.php,v 1.1 2006/11/02 17:25:04 marcan Exp $
 * Module: SmartHelp
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */


$adminmenu[0]['title'] = _MI_SCLONE_CLONE_A_MODULE;
$adminmenu[0]['link'] = "admin/index.php";

if (isset($xoopsModule) && $xoopsModule->getVar('dirname') == 'smartclone') {
    $headermenu[0]['title'] = _PREFERENCES;
    $headermenu[0]['link'] = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid');

    $headermenu[1]['title'] = _CO_SOBJECT_UPDATE_MODULE;
    $headermenu[1]['link'] = XOOPS_URL . "/modules/system/admin.php?fct=modulesadmin&op=update&module=" . $xoopsModule->getVar('dirname');

    $headermenu[2]['title'] = _AM_SOBJECT_ABOUT;
    $headermenu[2]['link'] = SMARTCLONE_URL . "admin/about.php";
}
?>