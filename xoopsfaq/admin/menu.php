<?php
/**
 * Name: menu.php
 * Description: Menu for the Xoops FAQ Module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright::  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license::    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package::    Xoops
 * @module::     Xoops FAQ
 * @subpackage:: Xoops FAQ Adminisration
 * @since::      2.3.0
 * @author::     John Neill
 * @version::    $Id$
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

$module_handler =& xoops_gethandler('module');
$xoopsModule =& XoopsModule::getByDirname('xoopsfaq');
$moduleInfo =& $module_handler->get($xoopsModule->getVar('mid'));
$pathImageAdmin = $moduleInfo->getInfo('icons32');
/**
 * Admin Menus
 */
 
$adminmenu = array();

$i = 1;
$adminmenu[$i]["title"] = _MI_XOOPSFAQ_MENU_ADMININDEX; //_MI_XOOPSFAQ_MENU_01;
$adminmenu[$i]["link"]  = "admin/index.php";
$adminmenu[$i]["desc"] = _MI_XOOPSFAQ_ADMIN_INDEX_DESC;
$adminmenu[$i]["icon"] = '../../'.$pathImageAdmin.'/home.png';
$i++;
$adminmenu[$i]["title"] = _MI_XOOPSFAQ_MENU_ADMINCATEGORY;
$adminmenu[$i]["link"]  = "admin/category.php";
$adminmenu[$i]["desc"] = _MI_XOOPSFAQ_ADMIN_CATEGORY_DESC;
$adminmenu[$i]["icon"] = '../../'.$pathImageAdmin.'/category.png';
$i++;
$adminmenu[$i]["title"] = _MI_XOOPSFAQ_MENU_ADMINFAQ;
$adminmenu[$i]["link"]  = "admin/main.php";
$adminmenu[$i]["desc"] = _MI_XOOPSFAQ_ADMIN_FAQ_DESC;
$adminmenu[$i]["icon"] = '../../'.$pathImageAdmin.'/faq.png';
$i++;
$adminmenu[$i]["title"] = _MI_XOOPSFAQ_MENU_ADMINABOUT;
$adminmenu[$i]["link"]  = "admin/about.php";
$adminmenu[$i]["desc"] = _MI_XOOPSFAQ_ADMIN_ABOUT_DESC;
$adminmenu[$i]["icon"] = '../../'.$pathImageAdmin.'/about.png';
