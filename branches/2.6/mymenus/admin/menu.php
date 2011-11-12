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
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Mymenus
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: menu.php 0 2010-07-21 18:47:04Z trabis $
 */

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
    $mymenus_headermenu[$i]['link'] = $GLOBALS['xoops']->url('modules/system/admin.php?fct=blocksadmin&amp;selvis=-1&amp;selmod=-2&amp;selgrp=-1&amp;selgen=' . $xoopsModule->getVar('mid'));
    $i++;

    $mymenus_headermenu[$i]['title'] = _PREFERENCES;
    $mymenus_headermenu[$i]['link'] = $GLOBALS['xoops']->url('modules/system/admin.php?fct=preferences&op=showmod&amp;mod=' . $xoopsModule->getVar('mid'));
    $i++;

    $mymenus_headermenu[$i]['title'] = _AM_MYMENUS_UPDATE_MODULE;
    $mymenus_headermenu[$i]['link'] = $GLOBALS['xoops']->url('modules/system/admin.php?fct=modulesadmin&op=update&module=' . $xoopsModule->getVar('dirname'));
}
