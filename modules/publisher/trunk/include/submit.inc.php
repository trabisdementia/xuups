<?php

/**
* $Id: submit.inc.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("XOOPS_ROOT_PATH")) { 
 	die("XOOPS root path not defined");
}

global $_POST, $xoopsDB;

include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";
include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

if (!$itemObj->categoryid() && isset($_GET['categoryid']))  {
	$categoryid = $_GET['categoryid'];
} else {
	$categoryid = $itemObj->categoryid();
}

if(isset($_GET['op']) && $_GET['op'] == 'clone'){
	$title = _MD_PUB_SUB_CLONE;
}
else{
	$title = _MD_PUB_SUB_SMNAME;
}
$sform = new XoopsThemeForm($title , "form", xoops_getenv('PHP_SELF'));
$sform->setExtra('enctype="multipart/form-data"');

// Category
$category_select = new XoopsFormSelect(_MD_PUB_CATEGORY, 'categoryid', $categoryid);
$category_select->setDescription(_MD_PUB_CATEGORY_DSC);
$category_select->addOptionArray($categoriesArray);
$sform->addElement($category_select);

// ITEM TITLE
$sform->addElement(new XoopsFormText(_MD_PUB_TITLE, 'title', 50, 255, $itemObj->title('e')), true);

// SUMMARY
$summary_text = publisher_getEditor(_MD_PUB_SUMMARY, 'summary', $itemObj->getVar('summary'));
$summary_text->setDescription(_MD_PUB_SUMMARY_DSC);
$sform->addElement($summary_text, false);

// BODY
//$body_text = new XoopsFormDhtmlTextArea(_MD_PUB_BODY, 'body', '', 15, 60);
$body_text = publisher_getEditor(_MD_PUB_BODY_REQ, 'body', $itemObj->getVar('body'));
$body_text->setDescription(_MD_PUB_BODY_DSC);
$sform->addElement($body_text);


// Uid
/*  We need to retreive the users manually because for some reason, on the frxoops.org server,
    the method users::getobjects encounters a memory error
*/
$uid = $itemObj->uid();
if ($isAdmin) {
    //xoops_loadLanguage('admin', 'publisher');
    $uid_select = new XoopsFormSelect(_AM_PUB_UID, 'uid', $uid, 1, false);
    $uid_select->setDescription(_AM_PUB_UID_DSC);

    $sql = "SELECT uid, uname FROM " . $xoopsDB->prefix('users') . " ORDER BY uname ASC";
    $result = $xoopsDB->query($sql);
    $users_array = array();
    $users_array[0] = $xoopsConfig['anonymous'];
    while ($myrow = $xoopsDB->fetchArray($result)) {
        $users_array[$myrow['uid']] = $myrow['uname'];
    }

    $uid_select->addOptionArray($users_array);
    $sform->addElement( $uid_select );
}  else {
    $hidden_uid = new XoopsFormHidden('uid', $uid);
    $sform->addElement($hidden_uid);
}

// IMAGE
$image_array = & XoopsLists :: getImgListAsArray( publisher_getImageDir('item') );
$image_select = new XoopsFormSelect( '', 'image', $itemObj->image() );
//$image_select -> addOption ('-1', '---------------');
$image_select -> addOptionArray( $image_array );
$image_select -> setExtra( "onchange='showImgSelected(\"image3\", \"image\", \"" . 'uploads/publisher/images/item/' . "\", \"\", \"" . XOOPS_URL . "\")'" );
$image_tray = new XoopsFormElementTray( _MD_PUB_IMAGE_ITEM, '&nbsp;' );
$image_tray -> addElement( $image_select );
$image_tray -> addElement( new XoopsFormLabel( '', "<br /><br /><img src='" . publisher_getImageDir('item', false) .$itemObj->image() . "' name='image3' id='image3' alt='' />" ) );
$image_tray->setDescription(_MD_PUB_IMAGE_ITEM_DSC);
$sform -> addElement( $image_tray );

// IMAGE UPLOAD
$max_size = 5000000;
$file_box = new XoopsFormFile(_MD_PUB_IMAGE_UPLOAD, "image_file", $max_size);
$file_box->setExtra( "size ='45'") ;
$file_box->setDescription(_MD_PUB_IMAGE_UPLOAD_ITEM_DSC);
$sform->addElement($file_box);

if (PUBLISHER_LEVEL > 0 ) {
	// VARIOUS OPTIONS
	$options_tray = new XoopsFormElementTray(_AM_PUB_OPTIONS, '<br />');
	
	$html_checkbox = new XoopsFormCheckBox('', 'dohtml', $itemObj->dohtml());
	$html_checkbox->addOption(1, _AM_PUB_DOHTML);
	$options_tray->addElement($html_checkbox);
	
	$smiley_checkbox = new XoopsFormCheckBox('', 'dosmiley', $itemObj->dosmiley());
	$smiley_checkbox->addOption(1, _AM_PUB_DOSMILEY);
	$options_tray->addElement($smiley_checkbox);
	
	$xcodes_checkbox = new XoopsFormCheckBox('', 'doxcode', $itemObj->doxcode());
	$xcodes_checkbox->addOption(1, _AM_PUB_DOXCODE);
	$options_tray->addElement($xcodes_checkbox);
	
	$images_checkbox = new XoopsFormCheckBox('', 'doimage', $itemObj->doimage());
	$images_checkbox->addOption(1, _AM_PUB_DOIMAGE);
	$options_tray->addElement($images_checkbox);
	
	$linebreak_checkbox = new XoopsFormCheckBox('', 'dobr', $itemObj->dobr());
	$linebreak_checkbox->addOption(1, _AM_PUB_DOLINEBREAK);
	$options_tray->addElement($linebreak_checkbox);
	
	$sform->addElement($options_tray);
}


// NOTIFY ON PUBLISH
if (is_object($xoopsUser)) {
	$notify_checkbox = new XoopsFormCheckBox('', 'notifypub', $notifypub);
	$notify_checkbox->addOption(1, _MD_PUB_NOTIFY);
	$sform->addElement($notify_checkbox);
}

$button_tray = new XoopsFormElementTray('', '');

$hidden = new XoopsFormHidden('op', 'post');

if(isset($_GET['op']) && $_GET['op']= 'clone'){
	$itemid = 0;
	$itemObj->setNew();
}
$button_tray->addElement($hidden);
if ($itemid) { 
	$button_tray->addElement(new XoopsFormButton('', 'post', _MD_PUB_EDIT, 'submit'));
} else {
	$button_tray->addElement(new XoopsFormButton('', 'post', _MD_PUB_CREATE, 'submit'));
}

$button_tray->addElement(new XoopsFormButton('', 'preview', _MD_PUB_PREVIEW, 'submit'));

$sform->addElement($button_tray);

$hidden_itemid = new XoopsFormHidden('itemid', $itemid);
$sform->addElement($hidden_itemid);

$sform->assign($xoopsTpl);

unset($hidden);
unset($hidden2);

?>
