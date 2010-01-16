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

$itemid = PublisherRequest::getInt('itemid');
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

$allowed_editors = publisher_getEditors($gperm_handler->getItemIds('editors', $groups, $module_id));
$form_view = $gperm_handler->getItemIds('form_view', $groups, $module_id);

// This code makes sure permissions are not manipulated
$elements = array (
    'summary', 'available_page_wrap', 'item_tags', 'image_item',
    'item_upload_file', 'uid', 'datesub', 'status','item_short_url',
    'item_meta_keywords', 'item_meta_description','weight',
    'allow_comments', 'permissions_item', 'partial_view',
    'dohtml', 'dosmiley', 'doxcode' , 'doimage', 'dolinebreak',
    'notify', 'subtitle', 'author_alias');
foreach ($elements as $element) {
    if (isset($_REQUEST[$element]) && !in_array(constant('_PUBLISHER_' . strtoupper($element)), $form_view)) {
        redirect_header("index.php", 1, _MD_PUBLISHER_SUBMIT_ERROR);
        exit();
    }
}
//Now if the values are not in $_POST we can use the default config values

//Required fields
$categoryid = PublisherRequest::getInt('categoryid');
$title = PublisherRequest::getString('title');
$body = PublisherRequest::getText('body');

//Not required fields
$summary = PublisherRequest::getText('summary');

/*
 $allow_display_summary = in_array(_PUBLISHER_DISPLAY_SUMMARY, $form_view);
 $display_summary = (isset($_POST['display_summmary'])&& $allow_display_summary) ? intval($_POST['display_summary']) : 1;
 */

$subtitle = PublisherRequest::getString('subtitle');

//$allow_available_page_wrap = in_array(_PUBLISHER_AVAILABLE_PAGE_WRAP, $form_view);

$item_tag = PublisherRequest::getString('item_tag');
$image_item = PublisherRequest::getArray('image_item');
$image_featured = PublisherRequest::getString('image_featured');
$item_upload_file = isset($_FILES['item_upload_file']) ? $_FILES['item_upload_file'] : '';
$uid = PublisherRequest::getInt('uid', $uid);
$author_alias = PublisherRequest::getString('author_alias');
if ($author_alias != '') $uid = 0;

$datesub = isset($_POST['datesub']) ? strtotime($_POST['datesub']['date']) + $_POST['datesub']['time'] : $datesub;
$status = PublisherRequest::getInt('status', $publisher->getConfig('submit_status'));
$item_short_url = PublisherRequest::getString('item_short_url');
$item_meta_keywords = PublisherRequest::getString('item_meta_keywords');
$item_meta_description = PublisherRequest::getString('item_meta_description');
$weight = PublisherRequest::getInt('weight');
$allowcomments = PublisherRequest::getInt('allowcomments', $publisher->getConfig('submit_allowcomments'));
$permissions_item = PublisherRequest::getArray('permissions_item', array('0'));
$partial_view = PublisherRequest::getInt('partial_view', false);
$dohtml = PublisherRequest::getInt('dohtml', $publisher->getConfig('submit_dohtml'));
$dosmiley = PublisherRequest::getInt('dosmiley', $publisher->getConfig('submit_dosmiley'));
$doxcode = PublisherRequest::getInt('doxcode', $publisher->getConfig('submit_doxcode'));
$doimage = PublisherRequest::getInt('doimage', $publisher->getConfig('submit_doimage'));
$dolinebreak = PublisherRequest::getInt('dolinebreak', $publisher->getConfig('submit_dobr'));
$notify = PublisherRequest::getInt('notify');

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
        $itemObj->setVar('item_tag', $item_tag);
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
        if (!$itemObj->store()) {
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