<?php

/**
* $Id: footer.php 2033 2008-05-05 20:40:10Z kurak_bu $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

global $xoopsModule, $xoopsModuleConfig;
$uid = ($xoopsUser) ? ($xoopsUser->getVar("uid")) : 0;

$xoopsTpl->assign("publisher_adminpage", "<a href='" . XOOPS_URL . "/modules/publisher/admin/index.php'>" ._MD_PUB_ADMIN_PAGE . "</a>");
$xoopsTpl->assign("isAdmin", $publisher_isAdmin);
$xoopsTpl->assign('publisher_url', PUBLISHER_URL);
$xoopsTpl->assign('publisher_images_url', PUBLISHER_IMAGES_URL);

$xoopsTpl->assign("xoops_module_header", '<link rel="stylesheet" type="text/css" href="' . PUBLISHER_URL . 'module.css" />' .
		'<link rel="alternate" type="application/rss+xml" title="'.$xoopsModule->getVar("name").'" href="' . PUBLISHER_URL . '/backend.php" />');

$xoopsTpl->assign('lang_total', _MD_PUB_TOTAL_SMARTITEMS);
$xoopsTpl->assign('lang_home', _MD_PUB_HOME);
$xoopsTpl->assign('lang_description', _MD_PUB_DESCRIPTION);
$xoopsTpl->assign('displayType', $xoopsModuleConfig['displaytype']);
// display_category_summary enabled by Freeform Solutions March 21 2006
$xoopsTpl->assign('display_category_summary', $xoopsModuleConfig['display_category_summary']);
$xoopsTpl->assign('displayList', $xoopsModuleConfig['displaytype']=='list');
$xoopsTpl->assign('displayFull', $xoopsModuleConfig['displaytype']=='full');
$xoopsTpl->assign('modulename', $xoopsModule->dirname());
$xoopsTpl->assign('displaylastitem', $xoopsModuleConfig['displaylastitem']);
$xoopsTpl->assign('displaysubcatdsc', $xoopsModuleConfig['displaysubcatdsc']);
$xoopsTpl->assign('publisher_display_breadcrumb', $xoopsModuleConfig['display_breadcrumb']);

$xoopsTpl->assign('collapsable_heading', $xoopsModuleConfig['collapsable_heading']);
$xoopsTpl->assign('display_comment_link', $xoopsModuleConfig['display_comment_link']);
$xoopsTpl->assign('display_whowhen_link', $xoopsModuleConfig['display_whowhen_link']);
$xoopsTpl->assign('displayarticlescount', $xoopsModuleConfig['displayarticlescount']);

$xoopsTpl->assign('display_date_col', $xoopsModuleConfig['display_date_col']);
$xoopsTpl->assign('display_hits_col', $xoopsModuleConfig['display_hits_col']);

$xoopsTpl->assign('category_list_image_width', $xoopsModuleConfig['category_list_image_width']);
$xoopsTpl->assign('category_main_image_width', $xoopsModuleConfig['category_main_image_width']);


$xoopsTpl->assign('lang_reads', _MD_PUB_READS);
$xoopsTpl->assign('lang_items', _MD_PUB_ITEMS);
$xoopsTpl->assign('lang_last_publisher', _MD_PUB_LAST_SMARTITEM);
$xoopsTpl->assign('lang_category_column', _MD_PUB_CATEGORY );
$xoopsTpl->assign('lang_editcategory', _MD_PUB_CATEGORY_EDIT);
$xoopsTpl->assign('lang_comments', _MD_PUB_COMMENTS);
$xoopsTpl->assign('lang_view_more',_MD_PUB_VIEW_MORE);
$xoopsTpl->assign("ref_smartfactory", "Publisher is developed by The SmartFactory (http://www.smartfactory.ca), a division of INBOX International (http://inboxinternational.com)");
?>