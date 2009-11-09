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
 * @package         Admin
 * @subpackage      Action
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: tools.php 0 2009-06-11 18:47:04Z trabis $
 */

include_once dirname(__FILE__) . '/admin_header.php';

$op = '';
if (isset($_POST['replacepermissions'])) {
	$op = 'replacepermissions';
}

switch ($op) {
	case 'replacepermissions' :
		$categoriesObj = $publisher->getHandler('category')->getObjects();
		$groups_read = isset($_POST['groups_read']) ? $_POST['groups_read'] : array();
		foreach($categoriesObj as $categoryObj) {
			publisher_saveCategory_Permissions($groups_read, $categoryObj->categoryid(), 'category_read');
			publisher_overrideItemsPermissions($groups_read, $categoryObj->categoryid());
		}
		redirect_header("index.php", 3, _AM_PUBLISHER_PERMISSIONS_UPDATED);
		exit;


	break;

	case "default":
	default:
	publisher_cpHeader();
	publisher_adminMenu(-1, _AM_PUBLISHER_TOOLS);

	publisher_openCollapsableBar('tools1', 'tools1icon', _AM_PUBLISHER_CONFIGURE_READ_PERMISSIONS, _AM_PUBLISHER_CONFIGURE_READ_PERMISSIONS_EXP);

	include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

	$sform = new XoopsThemeForm(_AM_PUBLISHER_FULLACCESS , "form", xoops_getenv('PHP_SELF'));
	$sform->setExtra('enctype="multipart/form-data"');

	// READ PERMISSIONS
	$groups_read_checkbox = new XoopsFormCheckBox(_AM_PUBLISHER_PERMISSIONS_CAT_READ, 'groups_read[]');
	$member_handler =& xoops_gethandler('member');

	foreach ( $member_handler->getGroupList() as $group_id=>$group_name ) {
		if ($group_id != XOOPS_GROUP_ADMIN) {
			$groups_read_checkbox->addOption($group_id, $group_name);
		}
	}
	$sform->addElement($groups_read_checkbox);

	$button_tray = new XoopsFormElementTray('', '');

	$button_tray->addElement(new XoopsFormButton('', 'replacepermissions', _AM_PUBLISHER_REPLACE_PERMISSIONS, 'submit'));
	$sform->addElement($button_tray);
	$sform->display();

	publisher_closeCollapsableBar('tools1', 'tools1icon');

	break;
}
xoops_cp_footer();
?>
