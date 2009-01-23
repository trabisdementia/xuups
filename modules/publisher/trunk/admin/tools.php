<?php

/**
* $Id: tools.php 3436 2008-07-05 10:49:26Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once("admin_header.php");

$op = '';
if (isset($_POST['replacepermissions'])) {
	$op = 'replacepermissions';
}

switch ($op) {
	case 'replacepermissions' :
		$categoriesObj = $publisher_category_handler->getObjects();
		$groups_read = isset($_POST['groups_read']) ? $_POST['groups_read'] : array();
		foreach($categoriesObj as $categoryObj) {
			publisher_saveCategory_Permissions($groups_read, $categoryObj->categoryid(), 'category_read');
			publisher_overrideItemsPermissions($groups_read, $categoryObj->categoryid());
		}
		redirect_header("index.php", 3, _AM_PUB_PERMISSIONS_UPDATED);
		exit;


	break;

	case "default":
	default:
	publisher_xoops_cp_header();

	publisher_adminMenu(-1, _AM_PUB_TOOLS);

	publisher_collapsableBar('tools1', 'tools1icon', _AM_PUB_CONFIGURE_READ_PERMISSIONS, _AM_PUB_CONFIGURE_READ_PERMISSIONS_EXP);

	include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

	$sform = new XoopsThemeForm(_AM_PUB_FULLACCESS , "form", xoops_getenv('PHP_SELF'));
	$sform->setExtra('enctype="multipart/form-data"');

	// READ PERMISSIONS
	$groups_read_checkbox = new XoopsFormCheckBox(_AM_PUB_PERMISSIONS_CAT_READ, 'groups_read[]');
	$member_handler =& xoops_gethandler('member');

	foreach ( $member_handler->getGroupList() as $group_id=>$group_name ) {
		if ($group_id != XOOPS_GROUP_ADMIN) {
			$groups_read_checkbox->addOption($group_id, $group_name);
		}
	}
	$sform->addElement($groups_read_checkbox);

	$button_tray = new XoopsFormElementTray('', '');

	$button_tray->addElement(new XoopsFormButton('', 'replacepermissions', _AM_PUB_REPLACE_PERMISSIONS, 'submit'));
	$sform->addElement($button_tray);
	$sform->display();

	publisher_close_collapsable('tools1', 'tools1icon');

	break;
}
xoops_cp_footer();
?>