<?php

/**
 * $Id: index.php,v 1.1 2005/05/13 18:21:55 malanciault Exp $
 * Module: SmartMedia
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

include_once("header.php");

global $smartmedia_category_handler;

// At which record shall we start for the Categories
$catstart = isset($_GET['catstart']) ? intval($_GET['catstart']) : 0;

$totalCategories = $smartmedia_category_handler->getCategoriesCount();

$xoopsOption['template_main'] = 'smartmedia_index.html';

include_once(XOOPS_ROOT_PATH . "/header.php");
include_once("footer.php");

// Creating the categories objects

$categoriesObj = $smartmedia_category_handler->getCategories($xoopsModuleConfig['categories_on_index'], $catstart);

$categories = array();
$i = 1;

foreach ($categoriesObj as $categoryObj) {
    $category = $categoryObj->toArray();
    $category['id'] = $i;
    $categories[] = $category;
    $i++;
    unset($category);
}

$xoopsTpl->assign('categories', $categories);

$xoopsTpl->assign('module_home', smartmedia_module_home(false));
$index_msg = $myts->displayTarea($xoopsModuleConfig['index_msg'], 1);
$xoopsTpl->assign('index_msg', $index_msg);

// ITEM Navigation Bar

if ($xoopsModuleConfig['categories_on_index'] > 0) {
    $pagenav = new XoopsPageNav($totalCategories, $xoopsModuleConfig['categories_on_index'], $catstart, 'catstart', '');
    $xoopsTpl->assign('navbar', '<div style="text-align:right;">' . $pagenav->renderNav() . '</div>');

    If ($xoopsModuleConfig['categories_on_index'] >= 8){
        $xoopsTpl->assign('navbarbottom', 1);
    }
}

// MetaTag Generator
smartmedia_createMetaTags($smartmedia_moduleName, '', $index_msg);

include_once(XOOPS_ROOT_PATH . "/footer.php");

?>