<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Publisher
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: menu.php 0 2009-06-11 18:47:04Z trabis $
 */

global $xoopsModule;

$i = 0;

// Index
$adminmenu[$i]['title'] = _MI_PUBLISHER_ADMENU1;
$adminmenu[$i]['link'] = "admin/index.php";
$i++;
// Category
$adminmenu[$i]['title'] = _MI_PUBLISHER_ADMENU2;
$adminmenu[$i]['link'] = "admin/category.php";
$i++;
// Items
$adminmenu[$i]['title'] = _MI_PUBLISHER_ADMENU3;
$adminmenu[$i]['link'] = "admin/item.php";
$i++;
// Permissions
$adminmenu[$i]['title'] = _MI_PUBLISHER_ADMENU4;
$adminmenu[$i]['link'] = "admin/permissions.php";
$i++;
// Mimetypes
$adminmenu[$i]['title'] = _MI_PUBLISHER_ADMENU6;
$adminmenu[$i]['link'] = "admin/mimetypes.php";
$i++;

// Preferences
$adminmenu[$i]['title'] = _PREFERENCES;
$adminmenu[$i]['link'] = "admin/preferences.php";

$publisher_adminmenu = $adminmenu;

if (isset($xoopsModule) && $xoopsModule->getVar('dirname') == basename(dirname(dirname(__FILE__)))) {
    $i = 0;

    $publisher_headermenu[$i]['title'] = _AM_PUBLISHER_BLOCKS;
    $publisher_headermenu[$i]['link'] = '../../system/admin.php?fct=blocksadmin&amp;selvis=-1&amp;selmod=-2&amp;selgrp=-1&amp;selgen=' . $xoopsModule->getVar('mid');
    $i++;

    $publisher_headermenu[$i]['title'] = _AM_PUBLISHER_COMMENTS;
    $publisher_headermenu[$i]['link'] = '../../system/admin.php?fct=comments&amp;module=' . $xoopsModule->getVar('mid');
    $i++;

    $publisher_headermenu[$i]['title'] = _AM_PUBLISHER_GOMOD;
    $publisher_headermenu[$i]['link'] = PUBLISHER_URL;
    $i++;

    $publisher_headermenu[$i]['title'] = _AM_PUBLISHER_UPDATE_MODULE;
    $publisher_headermenu[$i]['link'] = XOOPS_URL . "/modules/system/admin.php?fct=modulesadmin&op=update&module=" . $xoopsModule->getVar('dirname');
    $i++;

    $publisher_headermenu[$i]['title'] = _AM_PUBLISHER_IMPORT;
    $publisher_headermenu[$i]['link'] = PUBLISHER_URL . "/admin/import.php";
    $i++;

    $publisher_headermenu[$i]['title'] = _AM_PUBLISHER_CLONE;
    $publisher_headermenu[$i]['link'] = PUBLISHER_URL . "/admin/clone.php";
    $i++;

    $publisher_headermenu[$i]['title'] = _AM_PUBLISHER_ABOUT;
    $publisher_headermenu[$i]['link'] = PUBLISHER_URL . "/admin/about.php";
}
?>