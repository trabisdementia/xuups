<?php

/**
* $Id: answer.inc.php,v 1.10 2005/08/16 15:39:46 fx2024 Exp $
* Module: SmartFAQ
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("XOOPS_ROOT_PATH")) { 
 	die("XOOPS root path not defined");
}

global $_POST;

include_once XOOPS_ROOT_PATH . "/class/xoopstree.php";
include_once XOOPS_ROOT_PATH . "/class/xoopslists.php";
include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
//include_once 'functions.php';

$mytree = new XoopsTree($xoopsDB->prefix("smartfaq_categories"), "categoryid", "parentid");
$form = new XoopsThemeForm(_MD_SF_SUBMITANSWER, "form", xoops_getenv('PHP_SELF'));
// faq QUESTION
$form->addElement(new XoopsFormLabel(_MD_SF_QUESTION, $faqObj->question()), false);
// ANSWER
$form->addElement(new XoopsFormDhtmlTextArea(_MD_SF_ANSWER_FAQ, 'answer', '', 15, 60), true);
// NOTIFY ON PUBLISH
if (is_object($xoopsUser)) {
	$notify_checkbox = new XoopsFormCheckBox('', 'notifypub', 1);
	$notify_checkbox->addOption(1, _MD_SF_NOTIFY);
	$form->addElement($notify_checkbox);
}

if (($faqObj->status() == _SF_STATUS_PUBLISHED) || ($faqObj->status() == _SF_STATUS_NEW_ANSWER) ){
	$answerObj =& $faqObj->answer();
	$form->addElement(new XoopsFormLabel(_MD_SF_ORIGINAL_ANSWER, $answerObj->answer()), false);
}

$form->addElement(new XoopsFormHidden('faqid', $faqObj->faqid()));

$button_tray = new XoopsFormElementTray('', '');
$hidden = new XoopsFormHidden('op', 'post');
$button_tray->addElement($hidden);

$button_tray = new XoopsFormElementTray('', '');
$hidden = new XoopsFormHidden('op', 'post');
$button_tray->addElement($hidden);
$button_tray->addElement(new XoopsFormButton('', 'post', _MD_SF_SUBMITANSWER, 'submit'));
$form->addElement($button_tray);

$form->assign($xoopsTpl);

unset($hidden);

?>