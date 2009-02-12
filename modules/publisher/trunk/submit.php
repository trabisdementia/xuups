<?php

/**
* $Id: submit.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once dirname(__FILE__).'/header.php';
include_once PUBLISHER_ROOT_PATH . '/include/form_constants.php';

xoops_loadLanguage('admin', 'publisher');

global $publisher_category_handler, $publisher_item_handler, $xoopsUser, $xoopsConfig, $xoopsModuleConfig, $xoopsModule;

// Get the total number of categories
$categoriesArray = $publisher_category_handler->getCategoriesForSubmit();

if (!$categoriesArray) {
	redirect_header("index.php", 1, _MD_PUB_NEED_CATEGORY_ITEM);
	exit();
}

// Find if the user is admin of the module
$isAdmin = publisher_userIsAdmin();

$uid = is_object($xoopsUser) ? $xoopsUser->uid() : 0;

$groups = $xoopsUser ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
$gperm_handler =& xoops_getmodulehandler('groupperm');
$hModConfig =& xoops_gethandler('config');
$module_id = $publisher_handler->getVar('mid');

$itemid = (isset($_GET['itemid'])) ? $_GET['itemid'] : 0;
$itemid = (isset($_POST['itemid'])) ? $_POST['itemid'] : $itemid;
if ($itemid != 0) {
	// We are editing an article
	$itemObj = $publisher_item_handler->get($itemid);
	if (!($isAdmin || (is_object($xoopsUser) && $itemObj && ($xoopsUser->uid() == $itemObj->uid())))) {
	   redirect_header("index.php", 1, _NOPERM);
	   exit();
	}
	$categoryObj = $itemObj->category();
} else {
	// we are submitting a new article
	// if the user is not admin AND we don't allow user submission, exit
	if (!($isAdmin || (isset($xoopsModuleConfig['allowsubmit']) && $xoopsModuleConfig['allowsubmit'] == 1 && (is_object($xoopsUser) || (isset($xoopsModuleConfig['anonpost']) && $xoopsModuleConfig['anonpost'] == 1))))) {
		redirect_header("index.php", 1, _NOPERM);
		exit();
	}
	$itemObj = $publisher_item_handler->create();
	$categoryObj = $publisher_category_handler->create();
}

$op = '';

if (isset($_POST['post'])) {
	$op = 'post';
} elseif (isset($_POST['preview'])) {
	$op = 'preview';
} else {
	$op = 'add';
}

//Required fields
$categoryid = isset($_POST['categoryid']) ? $_POST['categoryid'] : 0;
$title = isset($_POST['title']) ? $_POST['title'] : '';
$body = isset($_POST['body']) ? $_POST['body'] : '';

//Not required fields, we are going to double check permissions and set default values
$allow_summary = $gperm_handler->checkRight('form_view', _PUB_SUMMARY, $groups, $module_id);
$summary = (isset($_POST['summary']) && $allow_summary) ? $_POST['summary'] : '';

$allow_display_summary = $gperm_handler->checkRight('form_view', _PUB_DISPLAY_SUMMARY, $groups, $module_id);
$display_summmary = (isset($_POST['display_summmary'])&& $allow_display_summmary) ? intval($_POST['display_summmary']) : 0;

$allow_available_page_wrap = $gperm_handler->checkRight('form_view', _PUB_AVAILABLE_PAGE_WRAP, $groups, $module_id);

$allow_item_tags = $gperm_handler->checkRight('form_view', _PUB_ITEM_TAGS, $groups, $module_id);
$item_tags = (isset($_POST['item_tags']) && $allow_item_tags) ? $_POST['item_tags'] : false;

$allow_image_item = $gperm_handler->checkRight('form_view', _PUB_IMAGE_ITEM, $groups, $module_id);
$image_item = (isset($_POST['image_item']) && $allow_image_item) ? $_POST['image_item'] : '';

$allow_image_upload = $gperm_handler->checkRight('form_view', _PUB_IMAGE_UPLOAD, $groups, $module_id);
$image_upload = (isset($_FILES['image_upload']) && $allow_image_upload) ? $_FILES['image_upload'] : false;

$allow_item_upload_file  = $gperm_handler->checkRight('form_view', _PUB_ITEM_UPLOAD_FILE, $groups, $module_id);
$item_upload_file = (isset($_FILES['item_upload_file']) && $allow_item_upload_file) ? $_FILES['item_upload_file'] : '';

$allow_uid = $gperm_handler->checkRight('form_view', _PUB_UID, $groups, $module_id);
$uid = (isset($_POST['uid']) && $allow_uid) ? intval($_POST['uid']) : $uid;

$allow_datesub = $gperm_handler->checkRight('form_view', _PUB_DATESUB, $groups, $module_id);
$datesub = (isset($_POST['datesub']) && $allow_datesub) ? strtotime($_POST['datesub']['date']) + $_POST['datesub']['time'] : time();

$allow_status = $gperm_handler->checkRight('form_view', _PUB_STATUS, $groups, $module_id);
$status = (isset($_POST['status']) && $allow_status) ? intval($_POST['status']) : _PUB_STATUS_SUBMITTED;

$allow_item_short_url = $gperm_handler->checkRight('form_view', _PUB_ITEM_SHORT_URL, $groups, $module_id);
$item_short_url = (isset($_POST['item_short_url']) && $allow_item_short_url) ? $_POST['item_short_url'] : '';

$allow_item_meta_keywords = $gperm_handler->checkRight('form_view', _PUB_ITEM_META_KEYWORDS, $groups, $module_id);
$item_meta_keywords = (isset($_POST['item_meta_keywords']) && $allow_item_meta_keywords) ? $_POST['item_meta_keywords'] : '';

$allow_item_meta_description = $gperm_handler->checkRight('form_view', _PUB_ITEM_META_DESCRIPTION, $groups, $module_id);
$item_meta_description = (isset($_POST['item_meta_description']) && $allow_item_meta_description) ? $_POST['item_meta_description'] : '';

$allow_weight = $gperm_handler->checkRight('form_view', _PUB_WEIGHT, $groups, $module_id);
$weight = (isset($_POST['weight'])&& $allow_weight) ? intval($_POST['weight']) : 0;

$allow_allowcomments = $gperm_handler->checkRight('form_view', _PUB_ALLOWCOMMENTS, $groups, $module_id);
$allowcomments = (isset($_POST['allowcomments'])&& $allow_allowcomments) ? intval($_POST['allowcomments']) : 1;

$allow_permissions_item = $gperm_handler->checkRight('form_view', _PUB_PERMISSIONS_ITEM, $groups, $module_id);
$permissions_item = (isset($_POST['permissions_item']) && $allow_permissions_item) ? $_POST['permissions_item'] : array('0');

$allow_partial_view = $gperm_handler->checkRight('form_view', _PUB_PARTIAL_VIEW, $groups, $module_id);
$partial_view = (isset($_POST['partial_view']) && $allow_partial_view) ? $_POST['partial_view'] : false;

$allow_dohtml = $gperm_handler->checkRight('form_view', _PUB_DOHTML, $groups, $module_id);
$dohtml = (isset($_POST['dohtml'])&& $allow_dohtml) ? intval($_POST['dohtml']) : 0;

$allow_dosmiley = $gperm_handler->checkRight('form_view', _PUB_DOSMILEY, $groups, $module_id);
$dosmiley = (isset($_POST['dosmiley'])&& $allow_dosmiley) ? intval($_POST['dosmiley']) : 0;

$allow_doxcode = $gperm_handler->checkRight('form_view', _PUB_DOXCODE, $groups, $module_id);
$doxcode = (isset($_POST['doxcode'])&& $allow_doxcode) ? intval($_POST['doxcode']) : 0;

$allow_doimage = $gperm_handler->checkRight('form_view', _PUB_DOIMAGE, $groups, $module_id);
$doimage = (isset($_POST['doimage'])&& $allow_doimage) ? intval($_POST['doimage']) : 0;

$allow_dolinebreak = $gperm_handler->checkRight('form_view', _PUB_DOLINEBREAK, $groups, $module_id);
$dolinebreak = (isset($_POST['dolinebreak'])&& $allow_dolinebreak) ? intval($_POST['dolinebreak']) : 0;

$allow_notify = $gperm_handler->checkRight('form_view', _PUB_NOTIFY, $groups, $module_id);
$notify = (isset($_POST['notify']) && $allow_notify) ? $_POST['notify'] : 0;

//stripcslashes
switch ($op) {
	case 'preview':

	global $xoopsUser, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $xoopsDB;
	// Putting the values about the ITEM in the ITEM object
    //stripcslashes?
    $itemObj->setVar('uid', $uid);
    $itemObj->setVar('categoryid', $categoryid);
	$itemObj->setVar('title', $title);
	$itemObj->setVar('summary', $summary);
	$itemObj->setVar('body', $body);
	$itemObj->setVar('notifypub', $notify);

	$itemObj->setVar('dohtml', $dohtml);
	$itemObj->setVar('dosmiley', $dosmiley);
	$itemObj->setVar('doxcode', $doxcode);
	$itemObj->setVar('doimage', $doimage);
	$itemObj->setVar('dobr', $dolinebreak);


	// Uploading the image, if any
	// Retreive the filename to be uploaded
	if ( isset($_FILES['image_file']) && $_FILES['image_file']['name'] != "" ) {
		$filename = $_POST["xoops_upload_file"][0] ;
		if( !empty( $filename ) || $filename != "" ) {
			global $xoopsModuleConfig;

			// TODO : Implement publisher mimetype management
			$max_size = $xoopsModuleConfig['maximum_filesize'];
			$max_imgwidth = $xoopsModuleConfig['maximum_image_width'];
			$max_imgheight = $xoopsModuleConfig['maximum_image_height'];
			$allowed_mimetypes = publisher_getAllowedImagesTypes();

			include_once(XOOPS_ROOT_PATH."/class/uploader.php");

			if( $_FILES[$filename]['tmp_name'] == "" || ! is_readable( $_FILES[$filename]['tmp_name'] ) ) {
				redirect_header( 'javascript:history.go(-1)' , 2, _AM_PUB_FILEUPLOAD_ERROR ) ;
				exit ;
			}

			$uploader = new XoopsMediaUploader(publisher_getImageDir('item'), $allowed_mimetypes, $max_size, $max_imgwidth, $max_imgheight);

			if( $uploader->fetchMedia( $filename ) && $uploader->upload() ) {

				$itemObj->setVar('image', $uploader->getSavedFileName());

			} else {
				redirect_header( 'javascript:history.go(-1)' , 2, _AM_PUB_FILEUPLOAD_ERROR . $uploader->getErrors() ) ;
				exit ;
			}
		}
	} else {
		$itemObj->setVar('image', $_POST['image']);
	}

	global $xoopsUser, $myts;

	$xoopsOption['template_main'] = 'publisher_submit.html';
	include_once XOOPS_ROOT_PATH . "/header.php";
	include_once "footer.php";

	$name = $xoopsUser ? ucwords($xoopsUser->getVar("uname")) : 'Anonymous';

	$categoryObj = $publisher_category_handler->get($_POST['categoryid']);

	$item = $itemObj->toArray();

    $item['summary'] = $item['maintext'];
	$item['categoryPath'] = $categoryObj->getCategoryPath(true);
	$item['who_when'] = $itemObj->getWhoAndWhen();
	$item['comments'] = -1;

    $xoopsTpl->assign('item', $item);
	
	$xoopsTpl->assign('op', 'preview');
	$xoopsTpl->assign('module_home', publisher_module_home());

	if ($itemid) {
		$xoopsTpl->assign('categoryPath', _MD_PUB_EDIT_ARTICLE);
		$xoopsTpl->assign('lang_intro_title', _MD_PUB_EDIT_ARTICLE);
		//For RISQ
		$xoopsTpl->assign('lang_intro_text', '');
		//$xoopsTpl->assign('lang_intro_text', $myts->displayTarea(publisher_getConfig('submitintromsg')));
	} else {
		$xoopsTpl->assign('categoryPath', _MD_PUB_SUB_SNEWNAME);
		$xoopsTpl->assign('lang_intro_title', sprintf(_MD_PUB_SUB_SNEWNAME, ucwords($xoopsModule->name())));
		//For RISQ
		$xoopsTpl->assign('lang_intro_text', publisher_getConfig('submitintromsg'));
		//$xoopsTpl->assign('lang_intro_text', $myts->displayTarea(publisher_getConfig('submitintromsg')));

	}

	include_once PUBLISHER_ROOT_PATH . '/include/submit.inc.php';

	include_once XOOPS_ROOT_PATH . '/footer.php';

	exit();
	break;

	case 'post':

	global $xoopsUser, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $xoopsDB;

	// Putting the values about the ITEM in the ITEM object
    $itemObj->setVar('categoryid', $categoryid);
	$itemObj->setVar('title', $title);
	$itemObj->setVar('body', $body);

    $itemObj->setVar('summary', $summary);
    $itemObj->setVar('display_summary', $display_summary);

$allow_available_page_wrap = $gperm_handler->checkRight('form_view', _PUB_AVAILABLE_PAGE_WRAP, $groups, $module_id);

    $itemObj->setVar('item_tag', $item_tags);
    
    // Uploading the image, if any
	// Retreive the filename to be uploaded
	if ( $image_upload && $image_upload['name'] != "" ) {
		$filename = $_POST["xoops_upload_file"][0] ;
		if( !empty( $filename ) || $filename != "" ) {
			global $xoopsModuleConfig;

			// TODO : Implement publisher mimetype management
			$max_size = $xoopsModuleConfig['maximum_filesize'];
			$max_imgwidth = $xoopsModuleConfig['maximum_image_width'];
			$max_imgheight = $xoopsModuleConfig['maximum_image_height'];
			$allowed_mimetypes = publisher_getAllowedImagesTypes();

			include_once(XOOPS_ROOT_PATH."/class/uploader.php");

			if( $_FILES[$filename]['tmp_name'] == "" || ! is_readable( $_FILES[$filename]['tmp_name'] ) ) {
				redirect_header( 'javascript:history.go(-1)' , 2, _AM_PUB_FILEUPLOAD_ERROR ) ;
				exit ;
			}

			$uploader = new XoopsMediaUploader(publisher_getImageDir('item'), $allowed_mimetypes, $max_size, $max_imgwidth, $max_imgheight);

			if ($uploader->fetchMedia( $filename ) && $uploader->upload()) {
				$itemObj->setVar('image', $uploader->getSavedFileName());
			} else {
				redirect_header( 'javascript:history.go(-1)' , 2, _AM_PUB_FILEUPLOAD_ERROR . $uploader->getErrors());
				exit;
			}
		}
	} else {
		$itemObj->setVar('image', $image_item);
	}

    // attach file if any
	if ($item_upload_file && $item_upload_file['name'] != "" ) {
		$file_upload_result = publisher_upload_file(false, false, $itemObj);
		if ($file_upload_result !== true) {
			redirect_header("javascript:history.go(-1)", 3, $file_upload_result);
			exit;
		}
	}
	
    $itemObj->setVar('uid', $uid);
    $itemObj->setVar('datesub', $datesub);
    $itemObj->setVar('status', $status);
    $itemObj->setVar('short_url', $item_short_url);
    $itemObj->setVar('meta_keywords', $item_meta_keywords);
    $itemObj->setVar('meta_description', $item_meta_description);
    $itemObj->setVar('weight', $weight);
   	$itemObj->setVar('cancomment', $allowcomments);
    $itemObj->setGroups_read($permissions_item);
    $itemObj->setPartial_view($partial_view);
    $itemObj->setVar('dohtml', $dohtml);
	$itemObj->setVar('dosmiley', $dosmiley);
	$itemObj->setVar('doxcode', $doxcode);
	$itemObj->setVar('doimage', $doimage);
	$itemObj->setVar('dobr', $dolinebreak);
	$itemObj->setVar('notifypub', $notify);

	// if we are editing an article, we don't change the uid and datesub values
	if (!$itemid) {
		$itemObj->setVar('datesub', time());
    }
    
	// Setting the status of the item
	/*if ( $itemid || ($xoopsModuleConfig['autoapprove_submitted'] ==  1)) {
		$itemObj->setVar('status', _PUB_STATUS_PUBLISHED);
	} else {
		$itemObj->setVar('status', _PUB_STATUS_SUBMITTED);
	}   */

	// Storing the item object in the database
	if ( !$itemObj->store() ) {
		redirect_header("javascript:history.go(-1)", 2, _MD_PUB_SUBMIT_ERROR);
		exit();
	}

	// Get the cateopry object related to that item
	$categoryObj =& $itemObj->category();

	// if autoapprove_submitted. This does not apply if we are editing an article
	if (!$itemid) {
		if ($itemObj->getVar('status') == _PUB_STATUS_PUBLISHED/*$xoopsModuleConfig['autoapprove_submitted'] ==  1*/) {
			// We do not not subscribe user to notification on publish since we publish it right away

			// Send notifications
			$itemObj->sendNotifications(array(_PUB_NOT_ITEM_PUBLISHED));

			$redirect_msg = _MD_PUB_ITEM_RECEIVED_AND_PUBLISHED;
		} else {
			// Subscribe the user to On Published notification, if requested
			if ($notify) {
				include_once XOOPS_ROOT_PATH . '/include/notification_constants.php';
				$notification_handler = &xoops_gethandler('notification');
				$notification_handler->subscribe('item', $itemObj->itemid(), 'approved', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE);
			}
			// Send notifications
			$itemObj->sendNotifications(array(_PUB_NOT_ITEM_SUBMITTED));

			$redirect_msg = _MD_PUB_ITEM_RECEIVED_NEED_APPROVAL;
		}
	} else {
		$redirect_msg = _MD_PUB_ITEMMODIFIED;
	}
	redirect_header("index.php", 2, $redirect_msg);


	exit();
	break;

	case 'add':
	default:

	global $xoopsUser, $myts;

	$xoopsOption['template_main'] = 'publisher_submit.html';
	include_once XOOPS_ROOT_PATH . '/header.php';
	include_once PUBLISHER_ROOT_PATH . '/footer.php';

	$name = $xoopsUser ? ucwords($xoopsUser->getVar("uname")) : 'Anonymous';

    //default values
    $itemObj->setVar('uid', $uid);
    
	$itemObj->setVar('dohtml', $dohtml);
	$itemObj->setVar('dosmiley', $dosmiley);
	$itemObj->setVar('doxcode', $doxcode);
	$itemObj->setVar('doimage', $doimage);
	$itemObj->setVar('dobr', $dolinebreak);
	
	$itemObj->setVar('notifypub', $notify);
	
	$xoopsTpl->assign('module_home', publisher_module_home());

	if(isset($_GET['op']) && $_GET['op'] == 'clone'){
		$xoopsTpl->assign('categoryPath', _MD_PUB_CLONE);
		$xoopsTpl->assign('lang_intro_title', _MD_PUB_CLONE);
	}
	elseif ($itemid) {
		$xoopsTpl->assign('categoryPath', _MD_PUB_EDIT_ARTICLE);
		$xoopsTpl->assign('lang_intro_title', _MD_PUB_EDIT_ARTICLE);
		//For RISQ
		$xoopsTpl->assign('lang_intro_text', '');
		//$xoopsTpl->assign('lang_intro_text', $myts->displayTarea(publisher_getConfig('submitintromsg')));
	} else {
		$xoopsTpl->assign('categoryPath', _MD_PUB_SUB_SNEWNAME);
		$xoopsTpl->assign('lang_intro_title', sprintf(_MD_PUB_SUB_SNEWNAME, ucwords($xoopsModule->name())));
		//For RISQ
		$xoopsTpl->assign('lang_intro_text', publisher_getConfig('submitintromsg'));
		//$xoopsTpl->assign('lang_intro_text', $myts->displayTarea(publisher_getConfig('submitintromsg')));

	}

	include_once PUBLISHER_ROOT_PATH . '/include/submit.inc.php';

	include_once XOOPS_ROOT_PATH . '/footer.php';
	break;
}

?>
