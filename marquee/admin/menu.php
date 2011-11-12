<?php

$module_handler =& xoops_gethandler('module');
$xoopsModule =& XoopsModule::getByDirname('marquee');
$moduleInfo =& $module_handler->get($xoopsModule->getVar('mid'));
$pathImageAdmin = $moduleInfo->getInfo('icons32');

$adminmenu = array();

$i = 1;
$adminmenu[$i]["title"] = _MI_MARQUEE_MENU_00;
$adminmenu[$i]["link"] = 'admin/index.php';
$adminmenu[$i]["icon"] = '../../'.$pathImageAdmin.'/home.png';

$i++;
$adminmenu[$i]["title"] = _MI_MARQUEE_MENU_01;
$adminmenu[$i]["link"] = 'admin/marquee.php';
$adminmenu[$i]["icon"] = '../../'.$pathImageAdmin.'/marquee.png';

$i++;
$adminmenu[$i]["title"] = _MI_MARQUEE_ADMIN_ABOUT;
$adminmenu[$i]["link"] = 'admin/about.php';
$adminmenu[$i]["icon"] = '../../'.$pathImageAdmin.'/about.png';
