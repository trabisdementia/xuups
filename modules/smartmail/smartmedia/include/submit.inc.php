<?php

/**
 * $Id: submit.inc.php,v 1.1 2005/05/13 18:22:03 malanciault Exp $
 * Module: SmartMedia
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

global $_POST, $xoopsDB;

include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";
include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

include_once 'functions.php';

$categoryid = isset($_GET['categoryid']) ? intval($_GET['categoryid']) : 0;
$mytree = new XoopsTree($xoopsDB->prefix("smartmedia_categories"), "categoryid", "parentid");
$sform = new XoopsThemeForm(_MD_SMEDIA_SUB_SMNAME, "storyform", xoops_getenv('PHP_SELF'));

// Category
ob_start();
$sform->addElement(new XoopsFormHidden('categoryid', ''));
$mytree->makeMySelBox("name", "weight", $categoryid);
$category_label = new XoopsFormLabel(_MD_SMEDIA_CATEGORY, ob_get_contents());
$category_label->setDescription(_MD_SMEDIA_CATEGORY_DSC);
$sform->addElement($category_label);
ob_end_clean();

// ITEM TITLE
$sform->addElement(new XoopsFormText(_MD_SMEDIA_TITLE, 'title', 50, 255, ''), true);

// SUMMARY
$summary_text = new XoopsFormTextArea(_MD_SMEDIA_SUMMARY, 'summary', '', 7, 60);
$summary_text->setDescription(_MD_SMEDIA_SUMMARY_DSC);
$sform->addElement($summary_text, false);

// BODY
$body_text = new XoopsFormDhtmlTextArea(_MD_SMEDIA_BODY, 'body', '', 15, 60);
$body_text->setDescription(_MD_SMEDIA_BODY_DSC);
$sform->addElement($body_text, true);


// NOTIFY ON PUBLISH
if (is_object($xoopsUser)) {
    $notify_checkbox = new XoopsFormCheckBox('', 'notifypub', 1);
    $notify_checkbox->addOption(1, _MD_SMEDIA_NOTIFY);
    $sform->addElement($notify_checkbox);
}

$button_tray = new XoopsFormElementTray('', '');

$hidden = new XoopsFormHidden('op', 'post');
$button_tray->addElement($hidden);
$button_tray->addElement(new XoopsFormButton('', 'post', _MD_SMEDIA_CREATE, 'submit'));

//$hidden2 = new XoopsFormHidden('op', 'preview');
//$button_tray->addElement($hidden2);
//$button_tray->addElement(new XoopsFormButton('', 'preview', _MD_SMEDIA_PREVIEW, 'submit'));

$sform->addElement($button_tray);
$sform->display();

unset($hidden);
unset($hidden2);

?>