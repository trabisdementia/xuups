<?php

/**
 * $Id: folder.php,v 1.2 2005/06/02 19:50:59 fx2024 Exp $
 * Module: SmartMedia
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

include_once("header.php");

global $smartmedia_folder_handler, $smartmedia_clip_handler;

$folderid = isset($_GET['folderid']) ? intval($_GET['folderid']) : 0;

// Creating the folder object for the selected folder
$folderObj = $smartmedia_folder_handler->get($folderid);

// If the selected folder was not found, exit
If (!$folderObj) {
    redirect_header("javascript:history.go(-1)", 1, _MD_SMEDIA_FOLDER_NOT_SELECTED);
    exit();
}

$totalItem = $smartmedia_folder_handler->onlineClipsCount($folderid);

// If there is no Item under this categories or the sub-categories, exit
If (!isset($totalItem[$folderid]) || $totalItem[$folderid] == 0) {
    redirect_header("javascript:history.go(-1)", 3, _MD_SMEDIA_NO_CLIP);
    exit;
}

$xoopsOption['template_main'] = 'smartmedia_folder.html';

include_once(XOOPS_ROOT_PATH . "/header.php");
include_once("footer.php");

// Updating folder counter
$folderObj->updateCounter();

// Retreiving the parent category name to this folder
$categoryid = isset($_GET['categoryid']) ? $_GET['categoryid'] : 0;
$parentObj = $smartmedia_category_handler->get($categoryid);

// Folder Smarty variabble
$xoopsTpl->assign('folder', $folderObj->toArray());

// Breadcrumb
$xoopsTpl->assign('categoryPath', $parentObj->getItemLink() . " &gt; " . $folderObj->title());

// At which record shall we start
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;


$clipsObj =& $smartmedia_clip_handler->getclips($xoopsModuleConfig['clips_per_folder'], $start, $folderid, 'weight', 'ASC', false);

$clips = array();
$i = 1;
foreach ($clipsObj as $clipObj) {
    $clip = $clipObj->toArray($categoryid);
    $clip['id'] = $i;
    $clips[] = $clip;
    $i++;
    unset($clip);
}

$xoopsTpl->assign('clips', $clips);

$xoopsTpl->assign('module_home', smartmedia_module_home());

// The Navigation Bar
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';

if($xoopsModuleConfig['clips_per_folder'] != 0){
    $pagenav = new XoopsPageNav($totalItem[$folderObj->getVar('folderid')], $xoopsModuleConfig['clips_per_folder'], $start, 'start', 'categoryid='.$categoryid.'&folderid=' . $folderObj->getVar('folderid'));
    $xoopsTpl->assign('navbar','<div style="text-align:right;">' . $pagenav->renderNav() . '</div>');
    If ($xoopsModuleConfig['clips_per_folder'] >= 8){
        $xoopsTpl->assign('navbarbottom', 1);
    }
}
// MetaTag Generator
smartmedia_createMetaTags($folderObj->title(), $parentObj->title(), $folderObj->description());

include_once(XOOPS_ROOT_PATH . "/footer.php");

?>