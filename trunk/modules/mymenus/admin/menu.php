<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

$i = -1;
$i++;
$adminmenu[$i]['title'] = _MI_MYMENUS_MENUSMANAGER;
$adminmenu[$i]['link'] = "admin/admin_menus.php";
$i++;
$adminmenu[$i]['title'] = _MI_MYMENUS_MENUMANAGER;
$adminmenu[$i]['link'] = "admin/admin_menu.php";
$i++;
$adminmenu[$i]['title'] = _MI_MYMENUS_ABOUT;
$adminmenu[$i]['link'] = "admin/admin_about.php";


$mymenus_adminmenu = $adminmenu;

global $xoopsModule;
if (isset($xoopsModule) && $xoopsModule->getVar('dirname') == basename(dirname(dirname(__FILE__)))) {
	$i = 0;

	$mymenus_headermenu[$i]['title'] = _AM_MYMENUS_BLOCKS;
	$mymenus_headermenu[$i]['link'] = XOOPS_URL . '/modules/system/admin.php?fct=blocksadmin&amp;selvis=-1&amp;selmod=-2&amp;selgrp=-1&amp;selgen=' . $xoopsModule->getVar('mid');
	$i++;
	
    $mymenus_headermenu[$i]['title'] = _PREFERENCES;
    $mymenus_headermenu[$i]['link'] = XOOPS_URL . '/modules/system/admin.php?fct=preferences&op=showmod&amp;mod=' . $xoopsModule->getVar('mid');
    $i++;

	$mymenus_headermenu[$i]['title'] = _AM_MYMENUS_UPDATE_MODULE;
	$mymenus_headermenu[$i]['link'] = XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $xoopsModule->getVar('dirname');
}
