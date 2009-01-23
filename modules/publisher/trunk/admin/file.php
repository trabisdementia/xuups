<?php

/**
* $Id: file.php 3436 2008-07-05 10:49:26Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once("admin_header.php");

global $publisher_file_handler;

$op = '';
if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

function editfile($showmenu = false, $fileid = 0, $itemid = 0)
{
	global $publisher_file_handler, $xoopsModule;

	include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
	// if there is a parameter, and the id exists, retrieve data: we're editing a file
	if ($fileid != 0) {

		// Creating the File object
		$fileObj = new publisherfile($fileid);

		if ($fileObj->notLoaded()) {
			redirect_header("javascript:history.go(-1)", 1, _AM_PUB_NOFILESELECTED);
			exit();
		}

		if ($showmenu) {
			publisher_adminMenu(2, _AM_PUB_FILE . " > " . _AM_PUB_EDITING);
		}

		echo "<br />\n";
		echo "<span style='color: #2F5376; font-weight: bold; font-size: 16px; margin: 6px 06 0 0; '>" . _AM_PUB_FILE_EDITING . "</span>";
		echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . _AM_PUB_FILE_EDITING_DSC . "</span>";
		publisher_collapsableBar('editfile', 'editfileicon', _AM_PUB_FILE_INFORMATIONS);
	} else {
		// there's no parameter, so we're adding an item
		$fileObj =& $publisher_file_handler->create();
		$fileObj->setVar('itemid', $itemid);
		if ($showmenu) {
			publisher_adminMenu(2, _AM_PUB_FILE . " > " . _AM_PUB_FILE_ADD);
		}
		echo "<span style='color: #2F5376; font-weight: bold; font-size: 16px; margin: 6px 06 0 0; '>" . _AM_PUB_FILE_ADDING . "</span>";
		echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . _AM_PUB_FILE_ADDING_DSC . "</span>";
		publisher_collapsableBar('addfile', 'addfileicon', _AM_PUB_FILE_INFORMATIONS);
	}

	// FILES UPLOAD FORM
	$files_form = new XoopsThemeForm(_AM_PUB_UPLOAD_FILE, "files_form", xoops_getenv('PHP_SELF'));
	$files_form->setExtra( "enctype='multipart/form-data'" ) ;

	// NAME
	$name_text = new XoopsFormText(_AM_PUB_FILE_NAME, 'name', 50, 255, $fileObj->name());
	$name_text->setDescription(_AM_PUB_FILE_NAME_DSC);
	$files_form->addElement($name_text, true);

	// DESCRIPTION
	$description_text = new XoopsFormTextArea(_AM_PUB_FILE_DESCRIPTION, 'description', $fileObj->description());
	$description_text->setDescription(_AM_PUB_FILE_DESCRIPTION_DSC);
	$files_form->addElement($description_text, 7, 60);

	// FILE TO UPLOAD
	if ($fileid == 0) {
		$file_box = new XoopsFormFile(_AM_PUB_FILE_TO_UPLOAD, "userfile", 0);
		$file_box->setExtra( "size ='50'") ;
		$files_form->addElement($file_box);
	}

	$status_select = new XoopsFormRadioYN(_AM_PUB_FILE_STATUS, 'file_status', $fileObj->status());
	$status_select->setDescription(_AM_PUB_FILE_STATUS_DSC);
	$files_form->addElement($status_select);

	$files_button_tray = new XoopsFormElementTray('', '');
	$files_hidden = new XoopsFormHidden('op', 'uploadfile');
	$files_button_tray->addElement($files_hidden);

	if ($fileid == 0) {
		$files_butt_create = new XoopsFormButton('', '', _AM_PUB_UPLOAD, 'submit');
		$files_butt_create->setExtra('onclick="this.form.elements.op.value=\'uploadfile\'"');
		$files_button_tray->addElement($files_butt_create);

		$files_butt_another = new XoopsFormButton('', '', _AM_PUB_FILE_UPLOAD_ANOTHER, 'submit');
		$files_butt_another->setExtra('onclick="this.form.elements.op.value=\'uploadanother\'"');
		$files_button_tray->addElement($files_butt_another);
	} else {
		$files_butt_create = new XoopsFormButton('', '', _AM_PUB_MODIFY, 'submit');
		$files_butt_create->setExtra('onclick="this.form.elements.op.value=\'modify\'"');
		$files_button_tray->addElement($files_butt_create);
	}

	$files_butt_clear = new XoopsFormButton('', '', _AM_PUB_CLEAR, 'reset');
	$files_button_tray->addElement($files_butt_clear);

	$butt_cancel = new XoopsFormButton('', '', _AM_PUB_CANCEL, 'button');
	$butt_cancel->setExtra('onclick="history.go(-1)"');
	$files_button_tray->addElement($butt_cancel);

	$files_form->addElement($files_button_tray);

	// fileid
	$files_form->addElement(new XoopsFormHidden('fileid', $fileid));

	// itemid
	$files_form->addElement(new XoopsFormHidden('itemid', $itemid));

	$files_form->display();

	if ($fileid != 0) {
		publisher_close_collapsable('editfile', 'editfileicon');
	} else {
		publisher_close_collapsable('addfile', 'addfileicon');
	}


}
$false = false;
/* -- Available operations -- */
switch ($op) {
	case "uploadfile";
	publisher_upload_file(false, true, $false);
	exit;
	break;

	case "uploadanother";
	publisher_upload_file(true, true, $false);
	exit;
	break;

	case "mod":

	Global $publisher_file_handler;
	$fileid = (isset($_GET['fileid'])) ? $_GET['fileid'] : 0;
	$itemid = (isset($_GET['itemid'])) ? $_GET['itemid'] : 0;
	if (($fileid == 0) && ($itemid == 0)) {
		redirect_header("javascript:history.go(-1)", 3, _AM_PUB_NOITEMSELECTED);
		exit();
	}

	publisher_xoops_cp_header();
	include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

	editfile(true, $fileid, $itemid);
	break;

	case "modify":
	global $xoopsUser;

	$fileid = (isset($_POST['fileid'])) ? intval($_POST['fileid']) : 0;

	// Creating the file object
	if ($fileid != 0) {
		$fileObj =& new PublisherFile($fileid);
	} else {
		$fileObj = $publisher_file_handler->create();
	}

	// Putting the values in the file object
	$fileObj->setVar('name', $_POST['name']);
	$fileObj->setVar('description', $_POST['description']);
	$fileObj->setVar('status', intval($_POST['file_status']));

	// Storing the file
	if ( !$fileObj->store() ) {
		redirect_header("item.php?op=mod&itemid=" . $fileObj->itemid(), 3, _AM_PUB_FILE_EDITING_ERROR . publisher_formatErrors($fileObj->getErrors()));
		exit;
	}

	redirect_header("item.php?op=mod&itemid=" . $fileObj->itemid(), 2, _AM_PUB_FILE_EDITING_SUCCESS);

	exit();
	break;

	case "del":
	global $xoopsUser, $xoopsUser, $xoopsConfig, $xoopsDB, $_GET;

	$module_id = $xoopsModule->getVar('mid');
	$gperm_handler = &xoops_gethandler('groupperm');

	$fileid = (isset($_POST['fileid'])) ? intval($_POST['fileid']) : 0;
	$fileid = (isset($_GET['fileid'])) ? intval($_GET['fileid']) : $fileid;

	$fileObj = new PublisherFile($fileid);

	$confirm = (isset($_POST['confirm'])) ? $_POST['confirm'] : 0;
	$title = (isset($_POST['title'])) ? $_POST['title'] : '';

	if ($confirm) {
		if ( !$publisher_file_handler->delete($fileObj)) {
			redirect_header("item.php", 2, _AM_PUB_FILE_DELETE_ERROR);
			exit;
		}

		redirect_header("item.php", 2, sprintf(_AM_PUB_FILEISDELETED, $fileObj->name()));
		exit();
	} else {
		// no confirm: show deletion condition
		$fileid = (isset($_GET['fileid'])) ? intval($_GET['fileid']) : 0;

		publisher_xoops_cp_header();
		xoops_confirm(array('op' => 'del', 'fileid' => $fileObj->fileid(), 'confirm' => 1, 'name' => $fileObj->name()), 'file.php', _AM_PUB_DELETETHISFILE . " <br />" . $fileObj->name() . " <br /> <br />", _AM_PUB_DELETE);
		xoops_cp_footer();
	}

	exit();
	break;

	case "default":
	default:
	publisher_xoops_cp_header();

	publisher_adminMenu(2, _AM_PUB_ITEMS);
	exit;
	include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
	include_once XOOPS_ROOT_PATH . '/class/pagenav.php';

	global $xoopsUser, $xoopsUser, $xoopsConfig, $xoopsDB, $xoopsModuleConfig, $xoopsModule;

	echo "<br />\n";

	publisher_collapsableBar('toptable', 'toptableicon', _AM_PUB_PUBLISHEDITEMS, _AM_PUB_PUBLISHED_DSC);

	// Get the total number of published ITEM
	$totalitems = $publisher_item_handler->getItemsCount(-1, array(_PUB_STATUS_PUBLISHED));

	// creating the item objects that are published
	$itemsObj = $publisher_item_handler->getAllPublished($xoopsModuleConfig['perpage'], $startitem);
	$totalItemsOnPage = count($itemsObj);

	echo "<table width='100%' cellspacing=1 cellpadding=3 border=0 class = outer>";
	echo "<tr>";
	echo "<td width='40' class='bg3' align='center'><b>" . _AM_PUB_ITEMID . "</b></td>";
	echo "<td width='20%' class='bg3' align='left'><b>" . _AM_PUB_ITEMCATEGORYNAME . "</b></td>";
	echo "<td class='bg3' align='left'><b>" . _AM_PUB_TITLE . "</b></td>";
	echo "<td width='90' class='bg3' align='center'><b>" . _AM_PUB_CREATED . "</b></td>";
	echo "<td width='60' class='bg3' align='center'><b>" . _AM_PUB_ACTION . "</b></td>";
	echo "</tr>";
	if ($totalitems > 0) {
		for ( $i = 0; $i < $totalItemsOnPage; $i++ ) {
			$categoryObj =& $itemsObj[$i]->category();

			$modify = "<a href='item.php?op=mod&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/edit.gif' title='" . _AM_PUB_EDITITEM . "' alt='" . _AM_PUB_EDITITEM . "' /></a>";
			$delete = "<a href='item.php?op=del&itemid=" . $itemsObj[$i]->itemid() . "'><img src='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/images/icon/delete.gif' title='" . _AM_PUB_EDITITEM . "' alt='" . _AM_PUB_DELETEITEM . "'/></a>";

			echo "<tr>";
			echo "<td class='head' align='center'>" . $itemsObj[$i]->itemid() . "</td>";
			echo "<td class='even' align='left'>" . $categoryObj->name() . "</td>";
			echo "<td class='even' align='left'><a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/item.php?itemid=" . $itemsObj[$i]->itemid() . "'>" . $itemsObj[$i]->title() . "</a></td>";
			echo "<td class='even' align='center'>" . $itemsObj[$i]->datesub() . "</td>";
			echo "<td class='even' align='center'> $modify $delete </td>";
			echo "</tr>";
		}
	} else {
		$itemid = -1;
		echo "<tr>";
		echo "<td class='head' align='center' colspan= '7'>" . _AM_PUB_NOITEMS . "</td>";
		echo "</tr>";
	}
	echo "</table>\n";
	echo "<br />\n";

	$pagenav = new XoopsPageNav($totalitems, $xoopsModuleConfig['perpage'], $startitem, 'startitem');
	echo '<div style="text-align:right;">' . $pagenav->renderNav() . '</div>';
	echo "</div>";

	$totalcategories = $publisher_category_handler->getCategoriesCount(-1);
	if ($totalcategories > 0) {
		edititem();
	}

	break;
}
xoops_cp_footer();
?>