<?php

/**
 * $Id: category.php,v 1.1 2005/05/13 18:21:55 malanciault Exp $
 * Module: SmartMedia
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

include_once("header.php");

global $smartmedia_category_handler, $smartmedia_folder_handler;

$categoryid = isset($_GET['categoryid']) ? intval($_GET['categoryid']) : 0;

// Creating the category object for the selected category
$categoryObj = $smartmedia_category_handler->get($categoryid);

// If the selected Category was not found, exit
If (!$categoryObj) {
    redirect_header("javascript:history.go(-1)", 1, _MD_SMEDIA_CATEGORY_NOT_SELECTED);
    exit();
}

$totalItem = $smartmedia_category_handler->onlineFoldersCount($categoryid);

// If there is no Item under this categories or the sub-categories, exit
If (!isset($totalItem[$categoryid]) || $totalItem[$categoryid] == 0) {
    redirect_header("index.php", 3, _MD_SMEDIA_NO_FOLDER);
    exit;
}

$xoopsOption['template_main'] = 'smartmedia_category.html';

include_once(XOOPS_ROOT_PATH . "/header.php");
include_once("footer.php");

// Category Smarty variabble
$xoopsTpl->assign('category', $categoryObj->toArray());
$xoopsTpl->assign('categoryPath', $categoryObj->title());

// At which record shall we start
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;


$foldersObj =& $smartmedia_folder_handler->getfolders($xoopsModuleConfig['folders_per_category'], $start, $categoryid, _SMEDIA_FOLDER_STATUS_ONLINE, 'parent.categoryid ASC, weight ASC, parent.folderid', 'ASC', false);

$folders = array();
$i = 1;

foreach ($foldersObj as $folderObj) {
    $folder = $folderObj->toArray();
    $folder['id'] = $i;
    $folders[] = $folder;
    $i++;
    unset($folder);
}

$xoopsTpl->assign('folders', $folders);


$xoopsTpl->assign('module_home', smartmedia_module_home());

// The Navigation Bar
if ($xoopsModuleConfig['folders_per_category'] > 0) {

    include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
    $pagenav = new XoopsPageNav($totalItem[$categoryObj->getVar('categoryid')], $xoopsModuleConfig['folders_per_category'], $start, 'start', 'categoryid=' . $categoryObj->getVar('categoryid'));
    $xoopsTpl->assign('navbar','<div style="text-align:right;">' . $pagenav->renderNav() . '</div>');

    If ($xoopsModuleConfig['folders_per_category'] >= 8){
        $xoopsTpl->assign('navbarbottom', 1);
    }
}

// MetaTag Generator
smartmedia_createMetaTags($categoryObj->title(), '', $categoryObj->description());

include_once(XOOPS_ROOT_PATH . "/footer.php");

?>