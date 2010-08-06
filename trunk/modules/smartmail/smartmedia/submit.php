<?php

/**
 * $Id: submit.php,v 1.1 2005/05/13 18:21:55 malanciault Exp $
 * Module: SmartMedia
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

include_once("header.php");
include_once(XOOPS_ROOT_PATH . "/header.php");

Global $smartmedia_category_handler, $smartmedia_item_handler, $xoopsUser, $xoopsConfig, $xoopsModuleConfig, $xoopsModule;

// Get the total number of categories
$totalCategories = count($smartmedia_category_handler->getCategories());

if ($totalCategories == 0) {
    redirect_header("index.php", 1, _AM_SMEDIA_NOCOLEXISTS);
    exit();
}

// Find if the user is admin of the module
$isAdmin = smartmedia_userIsAdmin();
// If the user is not admin AND we don't allow user submission, exit
if (!($isAdmin || (isset($xoopsModuleConfig['allowsubmit']) && $xoopsModuleConfig['allowsubmit'] == 1 && (is_object($xoopsUser) || (isset($xoopsModuleConfig['anonpost']) && $xoopsModuleConfig['anonpost'] == 1))))) {
    redirect_header("index.php", 1, _NOPERM);
    exit();
}

$op = '';

if (isset($_GET['op'])) $op = $_GET['op'];
if (isset($_POST['op'])) $op = $_POST['op'];

switch ($op) {
    case 'preview':

        Global $xoopsUser, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $xoopsDB;

        $newItemObj = $smartmedia_item_handler->create();

        if (!$xoopsUser) {
            if ($xoopsModuleConfig['anonpost'] == 1) {
                $uid = 0;
            } else {
                redirect_header("index.php", 3, _NOPERM);
                exit();
            }
        } else {
            $uid = $xoopsUser->uid();
        }

        // Putting the values about the ITEM in the ITEM object
        $newItemObj->setVar('categoryid', $_POST['categoryid']);
        $newItemObj->setVar('uid', $uid);
        $newItemObj->setVar('title', $_POST['title']);
        $newItemObj->setVar('summary', $_POST['summary']);
        $newItemObj->setVar('body', $_POST['body']);
        $newItemObj->setVar('notifypub', $_POST['notifypub']);

        // Storing the item object in the database
        If ( !$newItemObj->store() ) {
            redirect_header("javascript:history.go(-1)", 3, _MD_SMEDIA_SUBMIT_ERROR . smartmedia_formatErrors($newItemObj->getErrors()));
            exit();
        }

        // Get the cateopry object related to that item
        $categoryObj =& $newItemObj->category();

        // If autoapprove_submitted
        If ( $xoopsModuleConfig['autoapprove_submitted'] ==  1) {
            // We do not not subscribe user to notification on publish since we publish it right away

            // Send notifications
            $newItemObj->sendNotifications(array(_SMEDIA_NOT_ITEM_PUBLISHED));

            $redirect_msg = _MD_SMEDIA_ITEM_RECEIVED_AND_PUBLISHED;
        } else {
            // Subscribe the user to On Published notification, if requested
            if ($_POST['notifypub'] == 1) {
                include_once XOOPS_ROOT_PATH . '/include/notification_constants.php';
                $notification_handler = &xoops_gethandler('notification');
                $notification_handler->subscribe('item', $categoryObj->categoryid(), 'approve', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE);
            }
            // Send notifications
            $newItemObj->sendNotifications(array(_SMEDIA_NOT_ITEM_SUBMITTED));

            $redirect_msg = _MD_SMEDIA_ITEM_RECEIVED_NEED_APPROVAL;
        }

        redirect_header("javascript:history.go(-2)", 2, $redirect_msg);


        exit();
        break;

    case 'post':

        Global $xoopsUser, $xoopsConfig, $xoopsModule, $xoopsModuleConfig, $xoopsDB;

        $newItemObj = $smartmedia_item_handler->create();

        if (!$xoopsUser) {
            if ($xoopsModuleConfig['anonpost'] == 1) {
                $uid = 0;
            } else {
                redirect_header("index.php", 3, _NOPERM);
                exit();
            }
        } else {
            $uid = $xoopsUser->uid();
        }

        // Putting the values about the ITEM in the ITEM object
        $newItemObj->setVar('categoryid', $_POST['categoryid']);
        $newItemObj->setVar('uid', $uid);
        $newItemObj->setVar('title', $_POST['title']);
        $newItemObj->setVar('summary', isset($_POST['summary']) ? $_POST['summary'] : '');
        $newItemObj->setVar('body', $_POST['body']);
        $notifypub = isset($_POST['notifypub']) ? $_POST['notifypub'] : '';
        $newItemObj->setVar('notifypub', $notifypub);

        // Setting the status of the item
        If ( $xoopsModuleConfig['autoapprove_submitted'] ==  1) {
            $newItemObj->setVar('status', _SMEDIA_STATUS_PUBLISHED);
        } else {
            $newItemObj->setVar('status', _SMEDIA_STATUS_SUBMITTED);
        }

        // Storing the ITEM object in the database
        If ( !$newItemObj->store() ) {
            redirect_header("javascript:history.go(-1)", 2, _MD_SMEDIA_SUBMIT_ERROR);
            exit();
        }

        // Get the cateopry object related to that item
        $categoryObj =& $newItemObj->category();

        // If autoapprove_submitted
        If ( $xoopsModuleConfig['autoapprove_submitted'] ==  1) {
            // We do not not subscribe user to notification on publish since we publish it right away

            // Send notifications
            $newItemObj->sendNotifications(array(_SMEDIA_NOT_ITEM_PUBLISHED));

            $redirect_msg = _MD_SMEDIA_ITEM_RECEIVED_AND_PUBLISHED;
        } else {
            // Subscribe the user to On Published notification, if requested
            if ($notifypub) {
                include_once XOOPS_ROOT_PATH . '/include/notification_constants.php';
                $notification_handler = &xoops_gethandler('notification');
                $notification_handler->subscribe('item', $newItemObj->itemid(), 'approved', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE);
            }
            // Send notifications
            $newItemObj->sendNotifications(array(_SMEDIA_NOT_ITEM_SUBMITTED));

            $redirect_msg = _MD_SMEDIA_ITEM_RECEIVED_NEED_APPROVAL;
        }

        redirect_header("javascript:history.go(-2)", 2, $redirect_msg);


        exit();
        break;

    case 'form':
    default:

        global $xoopsUser, $myts;

        $name = ($xoopsUser) ? (ucwords($xoopsUser->getVar("uname"))) : 'Anonymous';

        $sectionname = $myts->makeTboxData4Show($xoopsModule->getVar('name'));

        echo "<table width='100%' style='padding: 0; margin: 0; border-bottom: 1px solid #2F5376;'><tr>";
        echo "<td width='50%'><span style='font-size: 10px; line-height: 18px;'><a href='" . XOOPS_URL . "'>" . _MD_SMEDIA_HOME . "</a> > <a href='" . XOOPS_URL . "/modules/" . $xoopsModule->dirname() . "/index.php'>" . $sectionname . "</a> > " . _MD_SMEDIA_SUBMIT . "</span></td>";
        echo "<td width='50%' align='right'><span style='font-size: 18px; text-align: right; font-weight: bold; color: #2F5376; letter-spacing: -1.5px; margin: 0; line-height: 18px;'>" . $sectionname . "</span></td></tr></table>";

        echo "<span style='margin-top: 8px; color: #33538e; margin-bottom: 8px; font-size: 18px; line-height: 18px; font-weight: bold; display: block;'>" ._MD_SMEDIA_SUB_SNEWNAME . "</span>";
        echo "<span style='color: #456; margin-bottom: 8px; line-height: 130%; display: block;}#33538e'>" . _MD_SMEDIA_GOODDAY . "<b>$name</b>, " . _MD_SMEDIA_SUB_INTRO . "</span>";

        include_once ('include/submit.inc.php');

        include_once (XOOPS_ROOT_PATH . '/footer.php');
        break;
}

?>