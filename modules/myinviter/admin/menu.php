<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

global $xoopsModule;

$i = 0;
$adminmenu[$i]['title'] = _MI_MYINV_ADMENU_INDEX;
$adminmenu[$i]['link'] = "admin/index.php";

$i++;
$adminmenu[$i]['title'] = _MI_MYINV_ADMENU_WAITING;
$adminmenu[$i]['link'] = "admin/admin_waiting.php";

$i++;
$adminmenu[$i]['title'] = _MI_MYINV_ADMENU_BLACKLIST;
$adminmenu[$i]['link'] = "admin/admin_blacklist.php";

$i++;
$adminmenu[$i]['title'] = _MI_MYINV_ADMENU_ABOUT;
$adminmenu[$i]['link'] = "admin/about.php";

$myinviter_adminmenu = $adminmenu;

if (isset($xoopsModule) && $xoopsModule->getVar('dirname') == basename(dirname(dirname(__FILE__)))) {
    $myinviter_url = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname');

    $i = 0;
	$myinviter_headermenu[$i]['title'] = _AM_MYINV_GOMOD;
	$myinviter_headermenu[$i]['link'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname');

    $i++;
    $myinviter_headermenu[$i]['title'] = _AM_MYINV_BLOCKS;
	$myinviter_headermenu[$i]['link'] = '../../system/admin.php?fct=blocksadmin&amp;selvis=-1&amp;selmod=-2&amp;selgrp=-1&amp;selgen=' . $xoopsModule->getVar('mid');

    $i++;
    $myinviter_headermenu[$i]['title'] = _PREFERENCES;
    $myinviter_headermenu[$i]['link'] = '../../system/admin.php?fct=preferences&op=showmod&amp;mod='. $xoopsModule->getVar('mid');

    $i++;
	$myinviter_headermenu[$i]['title'] = _AM_MYINV_UPDATE_MODULE;
	$myinviter_headermenu[$i]['link'] = XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin&amp;op=update&amp;module=' . $xoopsModule->getVar('dirname');

}

?>
