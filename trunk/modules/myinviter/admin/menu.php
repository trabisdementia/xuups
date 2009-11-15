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
 * @copyright       The XUUPS Project http://www.xuups.com
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Myinviter
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: menu.php 0 2009-11-14 18:47:04Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

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