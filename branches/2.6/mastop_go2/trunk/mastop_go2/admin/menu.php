<?php
### =============================================================
### Mastop InfoDigital - Paixão por Internet
### =============================================================
### Menu da Administração
### =============================================================
### Developer: Fernando Santos (topet05), fernando@mastop.com.br
### Copyright: Mastop InfoDigital © 2003-2007
### -------------------------------------------------------------
### www.mastop.com.br
### =============================================================
### $Id$
### =============================================================

$module_handler =& xoops_gethandler('module');
$xoopsModule =& XoopsModule::getByDirname('mastop_go2');
$moduleInfo =& $module_handler->get($xoopsModule->getVar('mid'));
$pathImageAdmin = $moduleInfo->getInfo('icons32');


$adminmenu = array();
$i = 1;
$adminmenu[$i]["title"] = MGO_ADM_HOME;
$adminmenu[$i]["link"]  = "admin/index.php";
$adminmenu[$i]["icon"] = '../../'.$pathImageAdmin.'/home.png';
$i++;
$adminmenu[$i]["title"] = MGO_MOD_MENU_SEC;
$adminmenu[$i]["link"]  = "admin/sec.php";
$adminmenu[$i]["icon"] = '../../'.$pathImageAdmin.'/category.png';
$i++;
$adminmenu[$i]['title'] = MGO_MOD_MENU_GO2;
$adminmenu[$i]['link'] = "admin/go2.php";
$adminmenu[$i]["icon"] = '../../'.$pathImageAdmin.'/alert.png';
$i++;
// $adminmenu[$i]['title'] = MGO_MOD_BLOCOS;
// $adminmenu[$i]['link'] = "admin/blocksadmin.php";
// $adminmenu[$i]["icon"] = '../../'.$pathImageAdmin.'/block.png';
// $i++;
$adminmenu[$i]["title"] = MGO_ADM_ABOUT;
$adminmenu[$i]["link"]  = "admin/about.php";
$adminmenu[$i]["icon"] = '../../'.$pathImageAdmin.'/about.png';