<?php

$module_handler =& xoops_gethandler('module');
$xoopsModule =& XoopsModule::getByDirname('extcal');
$moduleInfo =& $module_handler->get($xoopsModule->getVar('mid'));
$pathImageAdmin = $moduleInfo->getInfo('icons32');
$adminmenu = array();

$i = 1;
$adminmenu[$i]['title'] = _MI_EXTCAL_INDEX;
$adminmenu[$i]['link'] = "admin/index.php";
$adminmenu[$i]["icon"] = '../../'.$pathImageAdmin.'/home.png';
$i++;
$adminmenu[$i]['title'] = _MI_EXTCAL_CATEGORY;
$adminmenu[$i]['link'] = "admin/cat.php";
$adminmenu[$i]["icon"] = '../../'.$pathImageAdmin.'/category.png';
$i++;
$adminmenu[$i]['title'] = _MI_EXTCAL_EVENT;
$adminmenu[$i]['link'] = "admin/event.php";
$adminmenu[$i]["icon"] = '../../'.$pathImageAdmin.'/event.png';

$i++;
$adminmenu[$i]['title'] = _MI_EXTCAL_PERMISSIONS;
$adminmenu[$i]['link'] = "admin/perm.php";
$adminmenu[$i]["icon"] = '../../'.$pathImageAdmin.'/permissions.png';
//$i++;
//$adminmenu[$i]['title'] = _MI_EXTCAL_PRUNING;
//$adminmenu[$i]['link'] = "admin/prune.php";
//$adminmenu[$i]["icon"] = "images/admin/about.png";
$i++;
$adminmenu[$i]["title"] = _MI_EXTCAL_ABOUT;
$adminmenu[$i]["link"] = "admin/about.php";
$adminmenu[$i]["icon"] = '../../'.$pathImageAdmin.'/about.png';
?>
