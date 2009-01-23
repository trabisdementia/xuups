<?php

/**
* $Id: index.php 1428 2008-04-05 01:59:04Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
include_once("header.php");

global $publisher_category_handler, $publisher_item_handler, $xoopsUser, $xoopsModuleConfig;

// At which record shall we start for the Categories
$catstart = isset($_GET['catstart']) ? intval($_GET['catstart']) : 0;

// At which record shall we start for the ITEM
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;

// Number of categories at the top level
$totalCategories = $publisher_category_handler->getCategoriesCount(0);

// if there ain't no category to display, let's get out of here
if ($totalCategories  == 0 ) {
	redirect_header("../../index.php", 2, _MD_PUB_NO_TOP_PERMISSIONS);
	exit;
}
$xoopsOption['template_main'] = 'publisher_display' . '_' . $xoopsModuleConfig['displaytype'] . '.html';

include_once(XOOPS_ROOT_PATH . "/header.php");

include_once("footer.php");

$gperm_handler = &xoops_gethandler('groupperm');

$hModule = &xoops_gethandler('module');
// Creating the top categories objects
$categoriesObj = $publisher_category_handler->getCategories($xoopsModuleConfig['catperpage'], $catstart);

// if no categories are found, exit
$totalCategoriesOnPage = count($categoriesObj);
if ($totalCategoriesOnPage  == 0 ) {
	redirect_header("javascript:history.go(-1)", 2, _MD_PUB_NO_CAT_EXISTS);
	exit;
}


// Get subcats of the top categories
$subcats = $publisher_category_handler->getSubCats($categoriesObj);

// Count of items within each top categories
$totalItems = $publisher_category_handler->publishedItemsCount();

// real total count of items
$real_total_items = $publisher_item_handler->getCount();

if ($xoopsModuleConfig['displaylastitem'] == 1) {
	// Get the last item in each category
	$last_itemObj = $publisher_item_handler->getLastPublishedByCat();
}

// Max size of the title in the last item column
$lastitemsize = intval($xoopsModuleConfig['lastitemsize'])	;

$categories = array();

// Hide subcategories in main page olny - hacked by Mowaffak
if ($xoopsModuleConfig['show_subcats'] == 'nomain' ) {
   $xoopsModuleConfig['show_subcats'] = 'no';
}


foreach ($categoriesObj as $cat_id => $category) {

	$total = 0;
	// Do we display subcategories ?
	if ($xoopsModuleConfig['show_subcats'] != 'no' ) {
		// if this category has subcats
		if (isset($subcats[$cat_id])) {
			foreach ($subcats[$cat_id] as $key => $subcat) {
				// Get the items count of this very category
				$subcat_total_items = isset($totalItems[$key]) ? $totalItems[$key] : 0;
				// Do we display empty sub-cats ?
				if (($subcat_total_items > 0) || ($xoopsModuleConfig['show_subcats'] == 'all' )) {
					$subcat_id = $subcat->getVar('categoryid');
					// if we retreived the last item object for this category
					if (isset($last_itemObj[$subcat_id])) {
						$subcat->setVar('last_itemid', $last_itemObj[$subcat_id]->itemid());
						$subcat->setVar('last_title_link', $last_itemObj[$subcat_id]->getItemLink(false, $lastitemsize));
					}

					$numItems= isset($totalItems[$subcat_id])? $totalItems[$key] :0;
					$subcat->setVar('itemcount', $numItems);
					// Put this subcat in the smarty variable
					$categories[$cat_id]['subcats'][$key] = $subcat->toArray();
					//$total += $numItems;
				}


			}
		}
	}

	$categories[$cat_id]['subcatscount'] = isset($subcats[$cat_id]) ? count($subcats[$cat_id]) : 0;

	// Get the items count of this very category
	if (isset($totalItems[$cat_id]) && $totalItems[$cat_id] > 0) {
		$total += $totalItems[$cat_id];
	}
	// I'm commenting out this to also display empty categories...
	//if ($total > 0) {
	if (isset($last_itemObj[$cat_id])) {
		$category->setVar('last_itemid', $last_itemObj[$cat_id]->getVar('itemid'));
		$category->setVar('last_title_link', $last_itemObj[$cat_id]->getItemLink(false, $lastitemsize));
	}
	$category->setVar('itemcount', $total);
	if (!isset($categories[$cat_id])) {
		$categories[$cat_id] = array();
	}
	$categories[$cat_id] = $category->toArray($categories[$cat_id]);
}

if(isset($categories[$cat_id])){
	$categories[$cat_id] = $category->toArray($categories[$cat_id]);
	$categories[$cat_id]['categoryPath'] = $category->getCategoryPath($xoopsModuleConfig['linkedPath']);
	//}

}
$xoopsTpl->assign('categories', $categories);

if ($xoopsModuleConfig['displaylastitems']) {

	// Arrays that will hold the informations passed on to smarty variables
	$items = array();

	// creating the Item objects that belong to the selected category
	switch ($xoopsModuleConfig['orderby']) {
		case 'title' :
			$sort = 'title';
			$order = 'ASC';
			break;

		case 'date' :
			$sort = 'datesub';
			$order = 'DESC';
			break;

		default :
			$sort = 'weight';
			$order = 'ASC';
			break;
	}

	// Creating the last ITEMs
	$smartfactory_query_count_activated = true;
	global $xoopsDB;

	$itemsObj = $publisher_item_handler->getAllPublished($xoopsModuleConfig['indexperpage'], $start, -1, $sort, $order);

	$totalItemsOnPage = count($itemsObj);
	$allcategories = $publisher_category_handler->getObjects(null, true);
	if ($itemsObj) {
		$userids = array();
		foreach ($itemsObj as $key => $thisitem) {
			$itemids[] = $thisitem->getVar('itemid');
			$userids[$thisitem->uid()] = 1;
		}

		$member_handler = &xoops_gethandler('member');
		$users = $member_handler->getUsers(new Criteria('uid', "(".implode(',', array_keys($userids)).")", "IN"), true);
		for ( $i = 0; $i < $totalItemsOnPage; $i++ ) {
			$item = $itemsObj[$i]->toArray(-1, $xoopsModuleConfig['titlesize']);
			$item['categoryname'] = $allcategories[$itemsObj[$i]->categoryid()]->name();
			$item['categorylink'] = "<a href='" . XOOPS_URL . "/modules/publisher/category.php?categoryid=" . $itemsObj[$i]->categoryid() . "'>" . $allcategories[$itemsObj[$i]->categoryid()]->name() . "</a>";
			$item['who_when'] = $itemsObj[$i]->getWhoAndWhen($users);

			$xoopsTpl->append('items', $item);

		}
	}
}
/// sizeof($items);exit;
// Language constants
$xoopsTpl->assign(array('lang_on' => _MD_PUB_ON, 'lang_postedby' => _MD_PUB_POSTEDBY, 'lang_total' => isset($totalItemsOnPage) ? $totalItemsOnPage : '', 'lang_title' => _MD_PUB_TITLE, 'lang_datesub' => _MD_PUB_DATESUB, 'lang_hits' => _MD_PUB_HITS));
$xoopsTpl->assign('title_and_welcome', $xoopsModuleConfig['title_and_welcome']); //SHINE ADDED DEBUG mainintro txt
$xoopsTpl->assign('lang_mainintro', $myts->displayTarea($xoopsModuleConfig['indexwelcomemsg'], 1));
$xoopsTpl->assign('sectionname', $publisher_moduleName);
$xoopsTpl->assign('whereInSection', $publisher_moduleName);
$xoopsTpl->assign('module_home', publisher_module_home(false));
$indexfooter = publisher_getConfig('indexfooter');
$indexfooter = $myts->displayTarea($indexfooter, 1);
$xoopsTpl->assign('indexfooter', $indexfooter);

$xoopsTpl->assign('lang_category_summary', _MD_PUB_INDEX_CATEGORIES_SUMMARY);
$xoopsTpl->assign('lang_category_summary_info', _MD_PUB_INDEX_CATEGORIES_SUMMARY_INFO);
$xoopsTpl->assign('lang_items_title', _MD_PUB_INDEX_ITEMS);
$xoopsTpl->assign('lang_items_info', _MD_PUB_INDEX_ITEMS_INFO);
$xoopsTpl->assign('index_page', true);


// Category Navigation Bar
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
$pagenav = new XoopsPageNav($totalCategories, $xoopsModuleConfig['catperpage'], $catstart, 'catstart', '');
if ($xoopsModuleConfig['useimagenavpage'] == 1) {
	$xoopsTpl->assign('catnavbar', '<div style="text-align:right;">' . $pagenav->renderImageNav() . '</div>');
} else {
	$xoopsTpl->assign('catnavbar', '<div style="text-align:right;">' . $pagenav->renderNav() . '</div>');
}

// ITEM Navigation Bar
$pagenav = new XoopsPageNav($real_total_items, $xoopsModuleConfig['indexperpage'], $start, 'start', '');
if ($xoopsModuleConfig['useimagenavpage'] == 1) {
	$xoopsTpl->assign('navbar', '<div style="text-align:right;">' . $pagenav->renderImageNav() . '</div>');
} else {
	$xoopsTpl->assign('navbar', '<div style="text-align:right;">' . $pagenav->renderNav() . '</div>');
}
//show subcategories
$xoopsTpl->assign('show_subcats', $xoopsModuleConfig['show_subcats']);
$xoopsTpl->assign('displaylastitems', $xoopsModuleConfig['displaylastitems']);

/**
 * Generating meta information for this page
 */
$publisher_metagen = new PublisherMetagen($publisher_moduleName);
$publisher_metagen->createMetaTags();

// We are on the index page
$xoopsTpl->assign('indexpage', true);

// RSS Link
if($xoopsModuleConfig['show_rss_link'] == 1){
	$link=sprintf("<a href='%s' title='%s'><img src='%s' border=0 alt='%s'></a>",XOOPS_URL."/modules/publisher/backend.php", _MD_PUB_RSSFEED, XOOPS_URL."/modules/publisher/images/rss.gif",_MD_PUB_RSSFEED);
	$xoopsTpl->assign('rssfeed_link',$link);
}
include_once(XOOPS_ROOT_PATH . "/footer.php");

?>