<?php

/**
* $Id: preferences.php 331 2007-12-23 16:01:11Z malanciault $
* Module: SmartPartner
* Author: Xavier JIMENEZ
* Licence: GNU
*/

define("PUBLISHER_NOCPFUNC",1);  // cp_functions will be loaded by /system/admin.php, so prevent initial load
include_once("admin_header.php");

include_once XOOPS_ROOT_PATH."/kernel/module.php";
$xoopsModule = XoopsModule::getByDirname("publisher");

if (file_exists(PUBLISHER_ROOT_PATH . 'language/' . $xoopsConfig['language'] . '/modinfo.php')) {
	include_once PUBLISHER_ROOT_PATH . 'language/' . $xoopsConfig['language'] . '/modinfo.php';
} else {
	include_once PUBLISHER_ROOT_PATH . 'language/english/modinfo.php';
}

if (file_exists(PUBLISHER_ROOT_PATH . 'language/' . $xoopsConfig['language'] . '/admin.php')) {
	include_once PUBLISHER_ROOT_PATH . 'language/' . $xoopsConfig['language'] . '/admin.php';
} else {
	include_once PUBLISHER_ROOT_PATH . 'language/english/admin.php';
}


ob_start();
publisher_adminmenu(0, _AM_PUB_OPTS);
$btnsbar = ob_get_contents();
ob_end_clean();

//publisher_adminmenu(0, 'preferences');

function addAdminMenu($buf) {
	global $btnsbar;
	
	$pattern = array(
	"#admin.php?#",
	"#(<div class='content'>)#",
	);
	$replace = array(
	"preferences.php?",
	" $1 <br />".$btnsbar . "<div style='clear: both' class='content'>",
	);
	$html = preg_replace($pattern,$replace,$buf);
	return $html;
	
	//		ereg("(.*)(<div class='content'>.*)",$buf,$regs);
	//		return $regs[1].$btnsbar.$regs[2];
}


/*
* Display and capture preferences screen
*/

if (!isset($_POST['fct'])) $_GET['fct'] = $_GET['fct'] = "preferences";
if (!isset($_POST['op'])) $_GET['op' ] = $_GET['op' ] = "showmod";
if (!isset($_POST['mod'])) $_GET['mod'] = $_GET['mod'] = $xoopsModule->getVar('mid');
chdir(XOOPS_ROOT_PATH."/modules/system/");
ob_start("addAdminMenu");
include XOOPS_ROOT_PATH."/modules/system/admin.php";
ob_end_flush();
?>