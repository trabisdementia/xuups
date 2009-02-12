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
include_once PUBLISHER_ROOT_PATH . '/class/formdatetime.php';


//xoops_loadLanguage('admin', 'publisher');

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
$sform->addElement(new XoopsFormText(_MD_PUB_TITLE, 'title', 50, 255, $itemObj->getVar('title','e')), true);

// SUMMARY
if ($allow_summary) {
    $summary_text = publisher_getEditor(_MD_PUB_SUMMARY, 'summary', $itemObj->getVar('summary','e'));
    $summary_text->setDescription(_MD_PUB_SUMMARY_DSC);
    $sform->addElement($summary_text);
}

// DISPLAY_SUMMARY
if ($allow_display_summary) {
    $display_summary_radio = new XoopsFormRadioYN(_AM_PUB_DISPLAY_SUMMARY, 'display_summary', $itemObj->display_summary(), ' ' . _AM_PUB_YES . '', ' ' . _AM_PUB_NO . '');
    $sform->addElement($display_summary_radio);
}

// BODY
$body_text = publisher_getEditor(_MD_PUB_BODY_REQ, 'body', $itemObj->getVar('body','e'));
$body_text->setDescription(_MD_PUB_BODY_DSC);
$sform->addElement($body_text, true);

// Available pages to wrap
if ($allow_available_page_wrap) {
    $wrap_pages = XoopsLists::getHtmlListAsArray(publisher_getUploadDir(true, 'content'));
    $available_wrap_pages_text = array();
    foreach ($wrap_pages as $page) {
        $available_wrap_pages_text[] = "<span onclick='publisherPageWrap(\"body\", \"[pagewrap=$page] \");' onmouseover='style.cursor=\"pointer\"'>$page</span>";
    }
    $available_wrap_pages = new XoopsFormLabel(_AM_PUB_AVAILABLE_PAGE_WRAP, implode(', ', $available_wrap_pages_text));
    $available_wrap_pages->setDescription(_AM_PUB_AVAILABLE_PAGE_WRAP_DSC);
    $sform->addElement($available_wrap_pages);
}

// Tags
if ($allow_item_tags && publisher_tag_module_included()) {
    include_once XOOPS_ROOT_PATH . '/modules/tag/include/formtag.php';
    $text_tags = new XoopsFormTag("item_tag", 60, 255, $itemObj->getVar('item_tag', 'e'), 0);
    $sform->addElement($text_tags);
}

// IMAGE
if ($allow_image_item) {
    $image_array = & XoopsLists::getImgListAsArray(publisher_getImageDir('item'));
    $image_select = new XoopsFormSelect('', 'image_item', $itemObj->image());
    //$image_select -> addOption ('-1', '---------------');
    $image_select->addOptionArray($image_array);
    $image_select->setExtra( "onchange='showImgSelected(\"image3\", \"image\", \"" . 'uploads/publisher/images/item/' . "\", \"\", \"" . XOOPS_URL . "\")'");
    $image_tray = new XoopsFormElementTray( _MD_PUB_IMAGE_ITEM, '&nbsp;');
    $image_tray->addElement($image_select);
    $image_tray->addElement(new XoopsFormLabel('', "<br /><br /><img src='" . publisher_getImageDir('item', false) . $itemObj->image() . "' name='image3' id='image3' alt='' />" ));
    $image_tray->setDescription(_MD_PUB_IMAGE_ITEM_DSC);
    $sform->addElement($image_tray);
}

// IMAGE UPLOAD
if ($allow_image_upload) {
    $max_size = 5000000;
    $file_box = new XoopsFormFile(_MD_PUB_IMAGE_UPLOAD, "image_upload", $max_size);
    $file_box->setExtra("size ='45'");
    $file_box->setDescription(_MD_PUB_IMAGE_UPLOAD_ITEM_DSC);
    $sform->addElement($file_box);
    unset($file_box);
}

// File upload UPLOAD
if ($allow_item_upload_file) {
	$file_box = new XoopsFormFile(publisher_new_feature_tag() . _AM_PUB_ITEM_UPLOAD_FILE, "item_upload_file", 0);
	$file_box->setDescription(_AM_PUB_ITEM_UPLOAD_FILE_DSC . publisher_new_feature_tag());
	$file_box->setExtra("size ='50'");
	$sform->addElement($file_box);
	unset($file_box);
}

// Uid
/*  We need to retreive the users manually because for some reason, on the frxoops.org server,
    the method users::getobjects encounters a memory error
*/
if ($allow_uid) {
    $uid_select = new XoopsFormSelect(_AM_PUB_UID, 'uid', $itemObj->uid(), 1, false);
    $uid_select->setDescription(_AM_PUB_UID_DSC);

    $sql = "SELECT uid, uname FROM " . $xoopsDB->prefix('users') . " ORDER BY uname ASC";
    $result = $xoopsDB->query($sql);
    $users_array = array();
    $users_array[0] = $xoopsConfig['anonymous'];
    while ($myrow = $xoopsDB->fetchArray($result)) {
        $users_array[$myrow['uid']] = $myrow['uname'];
    }

    $uid_select->addOptionArray($users_array);
    $sform->addElement($uid_select);
}

// Datesub
if ($allow_datesub) {
	$datesub = ($itemObj->getVar('datesub') == 0) ? time() : $itemObj->getVar('datesub');
	$datesub_datetime = new PublisherFormDateTime(_AM_PUB_DATESUB, 'datesub', $size = 15, $datesub);
	$datesub_datetime->setDescription(_AM_PUB_DATESUB_DSC);
	$sform->addElement($datesub_datetime);
}

// STATUS
if ($allow_status) {
	$options = array(_PUB_STATUS_PUBLISHED=>_AM_PUB_PUBLISHED, _PUB_STATUS_OFFLINE=>_AM_PUB_OFFLINE, _PUB_STATUS_SUBMITTED=>_AM_PUB_SUBMITTED, _PUB_STATUS_REJECTED=>_AM_PUB_REJECTED);
	$status_select = new XoopsFormSelect(_AM_PUB_STATUS, 'status', $itemObj->getVar('status'));
	$status_select->addOptionArray($options);
	$status_select->setDescription(_AM_PUB_STATUS_DSC);
	$sform->addElement($status_select);
}

// Short url
if ($allow_item_short_url) {
    $text_short_url = new XoopsFormText(_AM_PUB_ITEM_SHORT_URL, 'item_short_url', 50, 255, $itemObj->short_url('e'));
    $text_short_url->setDescription(_AM_PUB_ITEM_SHORT_URL_DSC);
    $sform->addElement($text_short_url);
}

// Meta Keywords
if ($allow_item_meta_keywords) {
    $text_meta_keywords = new XoopsFormTextArea(_AM_PUB_ITEM_META_KEYWORDS, 'item_meta_keywords', $itemObj->meta_keywords('e'), 7, 60);
    $text_meta_keywords->setDescription(_AM_PUB_ITEM_META_KEYWORDS_DSC);
    $sform->addElement($text_meta_keywords);
}

// Meta Description
if ($allow_item_meta_description) {
    $text_meta_description = new XoopsFormTextArea(_AM_PUB_ITEM_META_DESCRIPTION, 'item_meta_description', $itemObj->meta_description('e'), 7, 60);
    $text_meta_description->setDescription(_AM_PUB_ITEM_META_DESCRIPTION_DSC);
    $sform->addElement($text_meta_description);
}

// WEIGHT
if ($allow_weight) {
	$sform->addElement(new XoopsFormText(_AM_PUB_WEIGHT, 'weight', 5, 5, $itemObj->weight()), true);
}

// COMMENTS
if ($allow_allowcomments) {
    $addcomments_radio = new XoopsFormRadioYN(_AM_PUB_ALLOWCOMMENTS, 'allowcomments', $itemObj->cancomment(), ' ' . _AM_PUB_YES . '', ' ' . _AM_PUB_NO . '');
    $sform->addElement($addcomments_radio);
}

// PER ITEM PERMISSIONS
if ($allow_permissions_item) {
	$member_handler = &xoops_gethandler('member');
	$group_list = $member_handler->getGroupList();
	$groups_checkbox = new XoopsFormCheckBox(_AM_PUB_PERMISSIONS_ITEM, 'permissions_item[]', $itemObj->getGroups_read());
	$groups_checkbox->setDescription(_AM_PUB_PERMISSIONS_ITEM_DSC);
	foreach ($group_list as $group_id => $group_name) {
		if ($group_id != XOOPS_GROUP_ADMIN) {
			$groups_checkbox->addOption($group_id, $group_name);
		}
	}
	$sform->addElement($groups_checkbox);
}

// partial_view
if ($allow_partial_view) {
	$p_view_checkbox = new XoopsFormCheckBox(_AM_PUB_PARTIAL_VIEW, 'partial_view[]', $itemObj->partial_view());
	$p_view_checkbox->setDescription(_AM_PUB_PARTIAL_VIEWDSC);
	foreach ($group_list as $group_id => $group_name) {
		if ($group_id != XOOPS_GROUP_ADMIN) {
			$p_view_checkbox->addOption($group_id, $group_name);
		}
	}
	$sform->addElement($p_view_checkbox);
}

// VARIOUS OPTIONS
if ($allow_dohtml || $allow_dosmiley || $allow_doxcode || $allow_doimage || $allow_dolinebreak) {

	$options_tray = new XoopsFormElementTray(_AM_PUB_OPTIONS, '<br />');

    if ($allow_dohtml) {
        $html_checkbox = new XoopsFormCheckBox('', 'dohtml', $itemObj->dohtml());
        $html_checkbox->addOption(1, _AM_PUB_DOHTML);
        $options_tray->addElement($html_checkbox);
    }

	if ($allow_dosmiley) {
        $smiley_checkbox = new XoopsFormCheckBox('', 'dosmiley', $itemObj->dosmiley());
	    $smiley_checkbox->addOption(1, _AM_PUB_DOSMILEY);
	    $options_tray->addElement($smiley_checkbox);
    }
	
	if ($allow_doxcode) {
        $xcodes_checkbox = new XoopsFormCheckBox('', 'doxcode', $itemObj->doxcode());
        $xcodes_checkbox->addOption(1, _AM_PUB_DOXCODE);
	    $options_tray->addElement($xcodes_checkbox);
	}
	
	if ($allow_doimage) {
	    $images_checkbox = new XoopsFormCheckBox('', 'doimage', $itemObj->doimage());
	    $images_checkbox->addOption(1, _AM_PUB_DOIMAGE);
	    $options_tray->addElement($images_checkbox);
	}
	
	if ($allow_dolinebreak) {
        $linebreak_checkbox = new XoopsFormCheckBox('', 'dolinebreak', $itemObj->dobr());
	    $linebreak_checkbox->addOption(1, _AM_PUB_DOLINEBREAK);
	    $options_tray->addElement($linebreak_checkbox);
	}
	
	$sform->addElement($options_tray);
	
}


// NOTIFY ON PUBLISH
if ($allow_notify) {
	$notify_checkbox = new XoopsFormCheckBox('', 'notify', $itemObj->notifypub());
	$notify_checkbox->addOption(1, _MD_PUB_NOTIFY);
	$sform->addElement($notify_checkbox);
}

$button_tray = new XoopsFormElementTray('', '');

$hidden = new XoopsFormHidden('op', 'post');
$button_tray->addElement($hidden);
unset($hidden);

if(isset($_GET['op']) && $_GET['op']= 'clone'){
	$itemid = 0;
	$itemObj->setNew();
}

if ($itemid) { 
	$button_tray->addElement(new XoopsFormButton('', 'post', _MD_PUB_EDIT, 'submit'));
} else {
	$button_tray->addElement(new XoopsFormButton('', 'post', _MD_PUB_CREATE, 'submit'));
}

$button_tray->addElement(new XoopsFormButton('', 'preview', _MD_PUB_PREVIEW, 'submit'));

$sform->addElement($button_tray);

$hidden = new XoopsFormHidden('itemid', $itemid);
$sform->addElement($hidden);
unset($hidden);

$sform->assign($xoopsTpl);

?>
