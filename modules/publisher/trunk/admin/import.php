<?php

/**
* $Id: import.php 3436 2008-07-05 10:49:26Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once dirname(__FILE__) . "/admin_header.php";

$op='none';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

switch ($op) {

	case "importExecute":

	$importfile = (isset($_POST['importfile'])) ? $_POST['importfile'] : 'nonselected';
	$importfile_path = XOOPS_ROOT_PATH."/modules/" . $xoopsModule->getVar('dirname') . "/admin/import/".$importfile.".php";
	if (!file_exists($importfile_path)) {
		$errs[] = sprintf(_AM_PUB_IMPORT_FILE_NOT_FOUND, $importfile_path);
		$error = true;
	} else {
		include_once($importfile_path);
	}
	foreach ($msgs as $m) {
		echo $m.'<br />';
	}
	echo "<br />";
	if ($error == true) {
		$endMsg = _AM_PUB_IMPORT_ERROR;
	} else {
		$endMsg = _AM_PUB_IMPORT_SUCCESS;
	}

	echo $endMsg;
	echo "<br /><br />";
	echo "<a href='" . XOOPS_URL . "/modules/" . $xoopsModule->getVar('dirname') . "/admin/import.php'>" . _AM_PUB_IMPORT_BACK . "</a>";
	echo "<br /><br />";
	break;

	case "default":
	default:

	$importfile = 'none';

	publisher_xoops_cp_header();

	publisher_adminMenu(-1, _AM_PUB_IMPORT);

	publisher_collapsableBar('import', 'importicon', _AM_PUB_IMPORT_TITLE, _AM_PUB_IMPORT_INFO);

	include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

	$module_handler =& xoops_gethandler ('module');

	// WF-Section
	$wfs_version = 0;
	$moduleObj = $module_handler->getByDirname('wfsection');
	if ($moduleObj) {
		$from_module_version = round($moduleObj->getVar('version') / 100, 2);
		if (($from_module_version == 1.5) || $from_module_version == 1.04 || $from_module_version == 1.01 || $from_module_version == 2.07 || $from_module_version == 2.06) {
			$importfile_select_array["wfsection"] = "WF-Section " . $from_module_version;
			$wfs_version = $from_module_version;
		}
	}

	// News
	$news_version = 0;
	$moduleObj = $module_handler->getByDirname('news');
	if ($moduleObj) {
		$from_module_version = round($moduleObj->getVar('version') / 100, 2);
		if (($from_module_version >= 1.1)) {
			$importfile_select_array["news"] = "News " . $from_module_version;
			$news_version = $from_module_version;
		}
	}
	
	//  XF-Section
	$xfs_version = 0;
	$moduleObj = $module_handler->getByDirname('xfsection');
	If ($moduleObj) {
		$from_module_version = round($moduleObj->getVar('version') / 100, 2);
		if ($from_module_version > 1.00) {
			$importfile_select_array["xfsection"] = "XF-Section " . $from_module_version;
			$xfs_version = $from_module_version;
		}
	}


	if (isset($importfile_select_array) && count($importfile_select_array) > 0 ) {

		$sform = new XoopsThemeForm(_AM_PUB_IMPORT_SELECTION, "op", xoops_getenv('PHP_SELF'));
		$sform->setExtra('enctype="multipart/form-data"');

		// Partners to import
		$importfile_select = new XoopsFormSelect('', 'importfile', $importfile);
		$importfile_select->addOptionArray($importfile_select_array);
		$importfile_tray = new XoopsFormElementTray(_AM_PUB_IMPORT_SELECT_FILE , '&nbsp;');
		$importfile_tray->addElement($importfile_select);
		$importfile_tray->setDescription(_AM_PUB_IMPORT_SELECT_FILE_DSC);
		$sform->addElement($importfile_tray);

		// Buttons
		$button_tray = new XoopsFormElementTray('', '');
		$hidden = new XoopsFormHidden('op', 'importExecute');
		$button_tray->addElement($hidden);

		$butt_import = new XoopsFormButton('', '', _AM_PUB_IMPORT, 'submit');
		$butt_import->setExtra('onclick="this.form.elements.op.value=\'importExecute\'"');
		$button_tray->addElement($butt_import);

		$butt_cancel = new XoopsFormButton('', '', _AM_PUB_CANCEL, 'button');
		$butt_cancel->setExtra('onclick="history.go(-1)"');
		$button_tray->addElement($butt_cancel);

		$sform->addElement($button_tray);
		$sform->addElement(new XoopsFormHidden('xfs_version', $xfs_version));
		$sform->addElement(new XoopsFormHidden('wfs_version', $wfs_version));
		$sform->addElement(new XoopsFormHidden('news_version', $news_version));
		$sform->display();
		unset($hidden);
	} else {
		echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-weight: bold; font-size: small; display: block; \">" . _AM_PUB_IMPORT_NO_MODULE . "</span>";
	}


	// End of collapsable bar

	publisher_close_collapsable('import', 'importicon');

	break;
}

xoops_cp_footer();
?>
