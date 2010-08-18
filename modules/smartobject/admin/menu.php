<?php
/**
 * $Id: menu.php 2341 2008-05-21 16:34:21Z malanciault $
 * Module: SmartObject
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

$i = -1;

$i++;
$adminmenu[$i]['title'] = _MI_SOBJECT_INDEX;
$adminmenu[$i]['link'] = "admin/index.php";

$i++;
$adminmenu[$i]['title'] = _MI_SOBJECT_SENT_LINKS;
$adminmenu[$i]['link'] = "admin/link.php";

$i++;
$adminmenu[$i]['title'] = _MI_SOBJECT_TAGS;
$adminmenu[$i]['link'] = "admin/customtag.php";

$i++;
$adminmenu[$i]['title'] = _MI_SOBJECT_ADSENSES;
$adminmenu[$i]['link'] = "admin/adsense.php";

$i++;
$adminmenu[$i]['title'] = _MI_SOBJECT_RATINGS;
$adminmenu[$i]['link'] = "admin/rating.php";

if (!defined('SMARTOBJECT_ROOT_PATH')) {
    include_once XOOPS_ROOT_PATH . '/modules/smartobject/include/functions.php';
}

$smartobject_config = smart_getModuleConfig('smartobject');

if (isset($smartobject_config['enable_currencyman']) && $smartobject_config['enable_currencyman'] == true) {
    $i++;
    $adminmenu[$i]['title'] = _MI_SOBJECT_CURRENCIES;
    $adminmenu[$i]['link'] = "admin/currency.php";
}

global $xoopsModule;
if (isset($xoopsModule) && $xoopsModule->getVar('dirname') == 'smartobject') {
    $i = -1;

    $i++;
    $headermenu[$i]['title'] = _PREFERENCES;
    $headermenu[$i]['link'] = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid');

    $i++;
    $headermenu[$i]['title'] = _CO_SOBJECT_UPDATE_MODULE;
    $headermenu[$i]['link'] = XOOPS_URL . "/modules/system/admin.php?fct=modulesadmin&op=update&module=" . $xoopsModule->getVar('dirname');

    $i++;
    $headermenu[$i]['title'] = _AM_SOBJECT_ABOUT;
    $headermenu[$i]['link'] = SMARTOBJECT_URL . "admin/about.php";
}
?>