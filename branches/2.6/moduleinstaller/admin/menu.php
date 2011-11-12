<?php

$module_handler =& xoops_gethandler('module');
$xoopsModule =& XoopsModule::getByDirname('moduleinstaller');
$moduleInfo =& $module_handler->get($xoopsModule->getVar('mid'));
//$pathImageAdmin = XOOPS_URL .'/'. $moduleInfo->getInfo('icons32');
$pathImageAdmin = $moduleInfo->getInfo('icons32');

$adminmenu = array();

$i = 1;
$adminmenu[$i]["title"] = _MI_INSTALLER_MENU_00;
$adminmenu[$i]["link"] = 'admin/index.php';
$adminmenu[$i]["icon"] = '../../'.$pathImageAdmin.'/home.png';
$i++;
$adminmenu[$i]["title"] = _MI_INSTALLER_MENU_01;
// $adminmenu[$i]["link"] = 'admin/page_moduleinstaller.php';
$adminmenu[$i]["link"] = 'admin/install.php';
$adminmenu[$i]["icon"] = '../../'.$pathImageAdmin.'/add.png';
$i++;
$adminmenu[$i]["title"] = _MI_INSTALLER_MENU_02;
$adminmenu[$i]["link"] = 'admin/uninstall.php';
$adminmenu[$i]["icon"] = '../../'.$pathImageAdmin.'/delete.png';
$i++;
$adminmenu[$i]["title"] = _MI_INSTALLER_ADMIN_ABOUT;
$adminmenu[$i]["link"] = 'admin/about.php';
$adminmenu[$i]["icon"] = '../../'.$pathImageAdmin.'/about.png';
