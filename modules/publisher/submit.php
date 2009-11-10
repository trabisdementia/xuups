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
 * @subpackage      Action
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: submit.php 0 2009-06-11 18:47:04Z trabis $
 */

include_once dirname(__FILE__) . '/header.php';
xoops_loadLanguage('admin', PUBLISHER_DIRNAME);

// Get the total number of categories
$categoriesArray = $publisher->getHandler('category')->getCategoriesForSubmit();

if (!$categoriesArray) {
	redirect_header("index.php", 1, _MD_PUBLISHER_NEED_CATEGORY_ITEM);
	exit();
}

// Find if the user is admin of the module
$isAdmin = publisher_userIsAdmin();

$uid = is_object($xoopsUser) ? $xoopsUser->uid() : 0;

$groups = $xoopsUser ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
$gperm_handler =& xoops_getmodulehandler('groupperm');
$module_id = $publisher->getModule()->getVar('mid');

$itemid = isset($_GET['itemid']) ? $_GET['itemid'] : 0;
$itemid = isset($_POST['itemid']) ? $_POST['itemid'] : $itemid;
if ($itemid != 0) {
	// We are editing an article
	$itemObj = $publisher->getHandler('item')->get($itemid);
	if (!($isAdmin || (is_object($xoopsUser) && $itemObj && ($xoopsUser->uid() == $itemObj->uid())))) {
	   redirect_header("index.php", 1, _NOPERM);
	   exit();
	}
	$categoryObj = $itemObj->category();
	$datesub = $itemObj->getVar('datesub');
} else {
	// we are submitting a new article
	// if the user is not admin AND we don't allow user submission, exit
	if (!($isAdmin || ($publisher->getConfig('perm_submit') == 1 && (is_object($xoopsUser) || ($publisher->getConfig('perm_anon_submit') == 1))))) {
		redirect_header("index.php", 1, _NOPERM);
		exit();
	}
	$itemObj = $publisher->getHandler('item')->create();
	$categoryObj = $publisher->getHandler('category')->create();
	$datesub = time();
}

if (isset($_GET['op']) && $_GET['op'] == 'clone') {
	$formtitle = _MD_PUBLISHER_SUB_CLONE;
    $itemObj->setNew();
} else {
	$formtitle = _MD_PUBLISHER_SUB_SMNAME;
}

$op = '';
if (isset($_POST['additem'])) {
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

$allowed_editors = publisher_getEditors($gperm_handler->getItemIds('editors', $groups, $module_id));
$form_view = $gperm_handler->getItemIds('form_view', $groups, $module_id);

//Not required fields, we are going to double check permissions and set default values
$allow_summary = in_array(_PUBLISHER_SUMMARY, $form_view);
$summary = (isset($_POST['summary']) && $allow_summary) ? $_POST['summary'] : '';
/*
$allow_display_summary = in_array(_PUBLISHER_DISPLAY_SUMMARY, $form_view);
$display_summary = (isset($_POST['display_summmary'])&& $allow_display_summary) ? intval($_POST['display_summary']) : 1;
*/
$allow_subtitle = in_array(_PUBLISHER_SUBTITLE, $form_view);
$subtitle = (isset($_POST['subtitle']) && $allow_subtitle) ? $_POST['subtitle'] : '';

$allow_available_page_wrap = in_array(_PUBLISHER_AVAILABLE_PAGE_WRAP, $form_view);

$allow_item_tags = in_array(_PUBLISHER_ITEM_TAGS, $form_view);
$item_tags = (isset($_POST['item_tag']) && $allow_item_tags) ? $_POST['item_tag'] : '';

$allow_image_item = in_array(_PUBLISHER_IMAGE_ITEM, $form_view);
$image_item = (isset($_POST['image_item']) && $allow_image_item) ? $_POST['image_item'] : array();
$image_featured = (isset($_POST['image_featured']) && $allow_image_item) ? $_POST['image_featured'] : '';

//$allow_image_upload = in_array(_PUBLISHER_IMAGE_UPLOAD, $form_view);
//$image_upload = (isset($_FILES['image_upload']) && $allow_image_upload) ? $_FILES['image_upload'] : false;
$image_upload = false;

$allow_item_upload_file  = in_array(_PUBLISHER_ITEM_UPLOAD_FILE, $form_view);
$item_upload_file = (isset($_FILES['item_upload_file']) && $allow_item_upload_file) ? $_FILES['item_upload_file'] : '';

$allow_uid = in_array(_PUBLISHER_UID, $form_view);
$uid = (isset($_POST['uid']) && $allow_uid) ? intval($_POST['uid']) : $uid;

$allow_author_alias = in_array(_PUBLISHER_ITEM_META_DESCRIPTION, $form_view);
$author_alias = (isset($_POST['author_alias']) && $allow_author_alias) ? $_POST['author_alias'] : '';
if ($author_alias != '') $uid = 0;

$allow_datesub = in_array(_PUBLISHER_DATESUB, $form_view);
$datesub = (isset($_POST['datesub']) && $allow_datesub) ? strtotime($_POST['datesub']['date']) + $_POST['datesub']['time'] : $datesub;

$allow_status = in_array(_PUBLISHER_STATUS, $form_view);
$status = (isset($_POST['status']) && $allow_status) ? intval($_POST['status']) : $publisher->getConfig('submit_status');

$allow_item_short_url = in_array(_PUBLISHER_ITEM_SHORT_URL, $form_view);
$item_short_url = (isset($_POST['item_short_url']) && $allow_item_short_url) ? $_POST['item_short_url'] : '';

$allow_item_meta_keywords = in_array(_PUBLISHER_ITEM_META_KEYWORDS, $form_view);
$item_meta_keywords = (isset($_POST['item_meta_keywords']) && $allow_item_meta_keywords) ? $_POST['item_meta_keywords'] : '';

$allow_item_meta_description = in_array(_PUBLISHER_ITEM_META_DESCRIPTION, $form_view);
$item_meta_description = (isset($_POST['item_meta_description']) && $allow_item_meta_description) ? $_POST['item_meta_description'] : '';

$allow_weight = in_array(_PUBLISHER_WEIGHT, $form_view);
$weight = (isset($_POST['weight'])&& $allow_weight) ? intval($_POST['weight']) : 0;

$allow_allowcomments = in_array(_PUBLISHER_ALLOWCOMMENTS, $form_view);
$allowcomments = (isset($_POST['allowcomments'])&& $allow_allowcomments) ? intval($_POST['allowcomments']) : $publisher->getConfig('submit_allowcomments');

$allow_permissions_item = in_array(_PUBLISHER_PERMISSIONS_ITEM, $form_view);
$permissions_item = (isset($_POST['permissions_item']) && $allow_permissions_item) ? $_POST['permissions_item'] : array('0');

$allow_partial_view = in_array(_PUBLISHER_PARTIAL_VIEW, $form_view);
$partial_view = (isset($_POST['partial_view']) && $allow_partial_view) ? $_POST['partial_view'] : false;

//check boxes do not set the variable if not marked
$allow_dohtml = in_array(_PUBLISHER_DOHTML, $form_view);
$dohtml = isset($_POST['dohtml']) ? 1 : 0;
$dohtml = $allow_dohtml ? $dohtml : $publisher->getConfig('submit_dohtml');

$allow_dosmiley = in_array(_PUBLISHER_DOSMILEY, $form_view);
$dosmiley = isset($_POST['dosmiley']) ? 1 : 0;
$dosmiley = $allow_dosmiley ? $dosmiley : $publisher->getConfig('submit_dosmiley');

$allow_doxcode = in_array(_PUBLISHER_DOXCODE, $form_view);
$doxcode = isset($_POST['doxcode']) ? 1 : 0;
$doxcode = $allow_doxcode ? $doxcode : $publisher->getConfig('submit_doxcode');

$allow_doimage = in_array(_PUBLISHER_DOIMAGE, $form_view);
$doimage = isset($_POST['doimage']) ? 1 : 0;
$doimage = $allow_doimage ? $doimage : $publisher->getConfig('submit_doimage');

$allow_dolinebreak = in_array(_PUBLISHER_DOLINEBREAK, $form_view);
$dolinebreak = isset($_POST['dolinebreak']) ? 1 : 0;
$dolinebreak = $allow_dolinebreak ? $dolinebreak : $publisher->getConfig('submit_dobr');

$allow_notify = in_array(_PUBLISHER_NOTIFY, $form_view);
$notify = (isset($_POST['notify']) && $allow_notify) ? 1 : 0;

//stripcslashes
switch ($op) {
	case 'preview': 
    	// Putting the values about the ITEM in the ITEM object
        $itemObj->setVar('categoryid', $categoryid);
    	$itemObj->setVar('title', $title);
    	$itemObj->setVar('body', $body);
        $itemObj->setVar('summary', $summary);
        //$itemObj->setVar('display_summary', $display_summary);
        //$allow_available_page_wrap = $gperm_handler->checkRight('form_view', _PUBLISHER_AVAILABLE_PAGE_WRAP, $groups, $module_id);
        $itemObj->setVar('item_tag', $item_tags);
        $itemObj->setVar('subtitle', $subtitle);
        $itemObj->setVar('author_alias', $author_alias);
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
    
        $image_handler =& xoops_gethandler('image');
        $imageObjs = $image_handler->getObjects(null, true);
        $image_item_ids = array();
        foreach ($imageObjs as $id => $imageObj) {
            $image_name = $imageObj->getVar('image_name');
            if ($image_name == $image_featured) {
                $itemObj->setVar('image', $id);
            }
            if (in_array($image_name, $image_item)) {
                $image_item_ids[] = $id;
            }
        }
        $itemObj->setVar('images', implode('|', $image_item_ids));
        unset($imageObjs);
    
    	$xoopsOption['template_main'] = 'publisher_submit.html';
    	include_once XOOPS_ROOT_PATH . '/header.php';
        include_once PUBLISHER_ROOT_PATH . '/footer.php';
    	$GLOBALS['xoTheme']->addScript(PUBLISHER_URL . '/js/ajaxupload.3.5.js');
    	
    	$name = $xoopsUser ? ucwords($xoopsUser->getVar("uname")) : $GLOBALS['xoopsConfig']['anonymous'];
    
    	$categoryObj = $publisher->getHandler('category')->get($_POST['categoryid']);
    	
        $item = $itemObj->toArray();
        $item['summary'] = $itemObj->body();
    	$item['categoryPath'] = $categoryObj->getCategoryPath(true);
    	$item['who_when'] = $itemObj->getWhoAndWhen();
    	$item['comments'] = -1;
        $xoopsTpl->assign('item', $item);
    	
    	$xoopsTpl->assign('op', 'preview');
    	$xoopsTpl->assign('module_home', publisher_moduleHome());
    
    	if ($itemid) {
    		$xoopsTpl->assign('categoryPath', _MD_PUBLISHER_EDIT_ARTICLE);
    		$xoopsTpl->assign('lang_intro_title', _MD_PUBLISHER_EDIT_ARTICLE);
    		$xoopsTpl->assign('lang_intro_text', '');
    	} else {
    		$xoopsTpl->assign('categoryPath', _MD_PUBLISHER_SUB_SNEWNAME);
    		$xoopsTpl->assign('lang_intro_title', sprintf(_MD_PUBLISHER_SUB_SNEWNAME, ucwords($publisher->getModule()->name())));
    		$xoopsTpl->assign('lang_intro_text', $publisher->getConfig('submit_intro_msg'));
    	}
    
        $sform = $itemObj->getForm($formtitle, true);
        $sform->assign($xoopsTpl);
    	include_once XOOPS_ROOT_PATH . '/footer.php';
    	exit();
        
    	break;

	case 'post':
        // Putting the values about the ITEM in the ITEM object
        $itemObj->setVar('categoryid', $categoryid);
        $itemObj->setVar('title', $title);
        $itemObj->setVar('body', $body);  
        $itemObj->setVar('summary', $summary);
        //$itemObj->setVar('display_summary', $display_summary);
        //$allow_available_page_wrap = $gperm_handler->checkRight('form_view', _PUBLISHER_AVAILABLE_PAGE_WRAP, $groups, $module_id); 
        $itemObj->setVar('item_tag', $item_tags);

        $image_handler =& xoops_gethandler('image');
        $imageObjs = $image_handler->getObjects(null, true);
        $image_item_ids = array();
        foreach ($imageObjs as $id => $imageObj) {
            $image_name = $imageObj->getVar('image_name');
            if ($image_name == $image_featured) {
                $itemObj->setVar('image', $id);
            }
            if (in_array($image_name, $image_item)) {
                $image_item_ids[] = $id;
            }
        }
        $itemObj->setVar('images', implode('|', $image_item_ids));
        unset($imageObjs);
        
        $itemObj->setVar('subtitle', $subtitle);
        $itemObj->setVar('author_alias', $author_alias);
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
        
        // Storing the item object in the database
        if ( !$itemObj->store() ) {
        	redirect_header("javascript:history.go(-1)", 2, _MD_PUBLISHER_SUBMIT_ERROR);
        	exit();
        }
        
        // attach file if any
        if ($item_upload_file && $item_upload_file['name'] != "" ) {
        	$file_upload_result = publisher_uploadFile(false, false, $itemObj);
        	if ($file_upload_result !== true) {
        		redirect_header("javascript:history.go(-1)", 3, $file_upload_result);
        		exit;
        	}
        }
        
        // if autoapprove_submitted. This does not apply if we are editing an article
        if (!$itemid) {
        	if ($itemObj->getVar('status') == _PUBLISHER_STATUS_PUBLISHED/*$publisher->getConfig('perm_autoapprove'] ==  1*/) {
        		// We do not not subscribe user to notification on publish since we publish it right away
        
        		// Send notifications
        		$itemObj->sendNotifications(array(_PUBLISHER_NOT_ITEM_PUBLISHED));
        
        		$redirect_msg = _MD_PUBLISHER_ITEM_RECEIVED_AND_PUBLISHED;
        	} else {
        		// Subscribe the user to On Published notification, if requested
        		if ($notify) {
        			include_once XOOPS_ROOT_PATH . '/include/notification_constants.php';
        			$notification_handler =& xoops_gethandler('notification');
        			$notification_handler->subscribe('item', $itemObj->itemid(), 'approved', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE);
        		}
        		// Send notifications
        		$itemObj->sendNotifications(array(_PUBLISHER_NOT_ITEM_SUBMITTED));
        
        		$redirect_msg = _MD_PUBLISHER_ITEM_RECEIVED_NEED_APPROVAL;
        	}
        } else {
        	$redirect_msg = _MD_PUBLISHER_ITEMMODIFIED;
        }
        redirect_header("index.php", 2, $redirect_msg);    
        exit();
        
        break;

	case 'add':
	default:
    	$xoopsOption['template_main'] = 'publisher_submit.html';
    	include_once XOOPS_ROOT_PATH . '/header.php';
        include_once PUBLISHER_ROOT_PATH . '/footer.php';
    	$GLOBALS['xoTheme']->addScript(PUBLISHER_URL . '/js/ajaxupload.3.5.js');
    
        //new item, is not allways a new item???
        if ($itemid == 0) {
            $itemObj->setVar('uid', $uid);
    
            //default values set in preferences
            $itemObj->setVar('status', $publisher->getConfig('submit_status'));
            $itemObj->setVar('cancomment', $publisher->getConfig('submit_allowcomments'));
    	    $itemObj->setVar('dohtml', $publisher->getConfig('submit_dohtml'));
    	    $itemObj->setVar('dosmiley', $publisher->getConfig('submit_dosmiley'));
    	    $itemObj->setVar('doxcode', $publisher->getConfig('submit_doxcode'));
    	    $itemObj->setVar('doimage', $publisher->getConfig('submit_doimage'));
    	    $itemObj->setVar('dobr', $publisher->getConfig('submit_dobr'));
    	
    	    $itemObj->setVar('notifypub', $notify);
        }
    	
    	$xoopsTpl->assign('module_home', publisher_moduleHome());
    
    	if (isset($_GET['op']) && $_GET['op'] == 'clone') {
    		$xoopsTpl->assign('categoryPath', _CO_PUBLISHER_CLONE);
    		$xoopsTpl->assign('lang_intro_title', _CO_PUBLISHER_CLONE);
    	} else if ($itemid) {
    		$xoopsTpl->assign('categoryPath', _MD_PUBLISHER_EDIT_ARTICLE);
    		$xoopsTpl->assign('lang_intro_title', _MD_PUBLISHER_EDIT_ARTICLE);
    		$xoopsTpl->assign('lang_intro_text', '');
    	} else {
    		$xoopsTpl->assign('categoryPath', _MD_PUBLISHER_SUB_SNEWNAME);
    		$xoopsTpl->assign('lang_intro_title', sprintf(_MD_PUBLISHER_SUB_SNEWNAME, ucwords($publisher->getModule()->name())));
    		$xoopsTpl->assign('lang_intro_text', $publisher->getConfig('submit_intro_msg'));
    	}
        $sform = $itemObj->getForm($formtitle, true);
        $sform->assign($xoopsTpl);
    
    	include_once XOOPS_ROOT_PATH . '/footer.php';
    	
        break;
}

?>
