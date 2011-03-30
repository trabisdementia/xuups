<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

global $xoopsModule;

// Index
$i = 0;
$adminmenu[$i]['title'] = _MI_SUBSCRIBERS_ADMENU_USER;
$adminmenu[$i]['link'] = "admin/admin_user.php";

// Send
$i++;
$adminmenu[$i]['title'] = _MI_SUBSCRIBERS_ADMENU_SEND;
$adminmenu[$i]['link'] = "admin/admin_send.php";

// Waiting
$i++;
$adminmenu[$i]['title'] = _MI_SUBSCRIBERS_ADMENU_WAITING;
$adminmenu[$i]['link'] = "admin/admin_waiting.php";

$subscribers_adminmenu = $adminmenu;

if (isset($xoopsModule) && $xoopsModule->getVar('dirname') == basename(dirname(dirname(__FILE__)))) {
    $subscribers_url = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname');

    $i = 0;
    $subscribers_headermenu[$i]['title'] = _AM_SUBSCRIBERS_GOMOD;
    $subscribers_headermenu[$i]['link'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname');

    $i++;
    $subscribers_headermenu[$i]['title'] = _AM_SUBSCRIBERS_BLOCKS;
    $subscribers_headermenu[$i]['link'] = '../../system/admin.php?fct=blocksadmin&amp;selvis=-1&amp;selmod=-2&amp;selgrp=-1&amp;selgen=' . $xoopsModule->getVar('mid');

    $i++;
    $subscribers_headermenu[$i]['title'] = _PREFERENCES;
    $subscribers_headermenu[$i]['link'] = '../../system/admin.php?fct=preferences&op=showmod&amp;mod='. $xoopsModule->getVar('mid');

    $i++;
    $subscribers_headermenu[$i]['title'] = _AM_SUBSCRIBERS_UPDATE_MODULE;
    $subscribers_headermenu[$i]['link'] = XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin&amp;op=update&amp;module=' . $xoopsModule->getVar('dirname');

    $i++;
    $subscribers_headermenu[$i]['title'] = _AM_SUBSCRIBERS_EXPORT;
    $subscribers_headermenu[$i]['link'] = XOOPS_URL . '/modules/' . $xoopsModule->getVar('dirname') . '/admin/admin_export.php';

}
?>
