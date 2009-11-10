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
 * @package         Publisher
 * @subpackage      Forms
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: fileform.inc.php 0 2009-06-11 18:47:04Z trabis $
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}


//todo: Move this to other dir
include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

$publisher =& PublisherPublisher::getInstance();

$fileid = isset($_GET['fileid']) ? intval($_GET['fileid']) : 0;

if ($fileid != 0) {
	$fileObj = new PublisherFile($fileid);
} else {
	$fileObj =& $publisher->getHandler('file')->create();
}

// FILES UPLOAD FORM
$files_form = new XoopsThemeForm(_MD_PUBLISHER_UPLOAD_FILE, "form", xoops_getenv('PHP_SELF'));
$files_form->setExtra( "enctype='multipart/form-data'" ) ;

// NAME

$name_text = new XoopsFormText(_MD_PUBLISHER_FILENAME, 'name', 50, 255, $fileObj->name());
$name_text->setDescription(_MD_PUBLISHER_FILE_NAME_DSC);
$files_form->addElement($name_text, true);

// DESCRIPTION
$description_text = new XoopsFormTextArea(_MD_PUBLISHER_FILE_DESCRIPTION, 'description', $fileObj->description());
$description_text->setDescription(_MD_PUBLISHER_FILE_DESCRIPTION_DSC);
$files_form->addElement($description_text, 7, 60);

// FILE TO UPLOAD
if ($fileid == 0) {
	$file_box = new XoopsFormFile(_MD_PUBLISHER_FILE_TO_UPLOAD, "item_upload_file", 0);
	$file_box->setExtra( "size ='50'") ;
	$files_form->addElement($file_box);
}

$status_select = new XoopsFormRadioYN(_MD_PUBLISHER_FILE_STATUS, 'file_status', _PUBLISHER_STATUS_FILE_ACTIVE);
$status_select->setDescription(_MD_PUBLISHER_FILE_STATUS_DSC);
$files_form->addElement($status_select);

$files_button_tray = new XoopsFormElementTray('', '');
$files_hidden = new XoopsFormHidden('op', 'uploadfile');
$files_button_tray->addElement($files_hidden);

if ($fileid == 0) {
	$files_butt_create = new XoopsFormButton('', '', _MD_PUBLISHER_UPLOAD, 'submit');
	$files_butt_create->setExtra('onclick="this.form.elements.op.value=\'uploadfile\'"');
	$files_button_tray->addElement($files_butt_create);

	$files_butt_another = new XoopsFormButton('', '', _MD_PUBLISHER_FILE_UPLOAD_ANOTHER, 'submit');
	$files_butt_another->setExtra('onclick="this.form.elements.op.value=\'uploadanother\'"');
	$files_button_tray->addElement($files_butt_another);
} else {
	$files_butt_create = new XoopsFormButton('', '', _MD_PUBLISHER_MODIFY, 'submit');
	$files_butt_create->setExtra('onclick="this.form.elements.op.value=\'modify\'"');
	$files_button_tray->addElement($files_butt_create);
}

$files_butt_clear = new XoopsFormButton('', '', _MD_PUBLISHER_CLEAR, 'reset');
$files_button_tray->addElement($files_butt_clear);

$butt_cancel = new XoopsFormButton('', '', _MD_PUBLISHER_CANCEL, 'button');
$butt_cancel->setExtra('onclick="history.go(-1)"');
$files_button_tray->addElement($butt_cancel);

$files_form->addElement($files_button_tray);

// fileid
$files_form->addElement(new XoopsFormHidden('fileid', $fileid));

// itemid
$files_form->addElement(new XoopsFormHidden('itemid', $itemid));

$files_form->assign($xoopsTpl);

?>
