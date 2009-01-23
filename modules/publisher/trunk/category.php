<?php

/**
* $Id: category.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once("header.php");

global $publisher_category_handler, $publisher_item_handler;

$categoryid = isset($_GET['categoryid']) ? intval($_GET['categoryid']) : 0;

// Creating the category object for the selected category
$categoryObj = $publisher_category_handler->get($categoryid);

// if the selected category was not found, exit
if ($categoryObj->notLoaded()) {
    redirect_header("javascript:history.go(-1)", 1, _MD_PUB_NOCATEGORYSELECTED);
    exit();
}

// Check user permissions to access this category
if (!$categoryObj->checkPermission()) {
    redirect_header("javascript:history.go(-1)", 1, _NOPERM);
    exit;
}

$item_page_id = isset($_GET['page']) ? intval($_GET['page']) : -1;

$totalItems = $publisher_category_handler->publishedItemsCount();

// if there is no Item under this categories or the sub-categories, exit
if (!isset($totalItems[$categoryid]) || $totalItems[$categoryid] == 0) {
    //redirect_header("index.php", 1, _MD_PUB_MAINNOFAQS);
    //exit;
}

// Added by skalpa: custom template support
$xoopsOption['template_main'] = $categoryObj->template();
if ( empty( $xoopsOption['template_main'] ) ) {
	$xoopsOption['template_main'] = 'publisher_display' . '_' . $xoopsModuleConfig['displaytype'] . '.html';
}

include_once(XOOPS_ROOT_PATH . "/header.php");
include_once("footer.php");

$gperm_handler = &xoops_gethandler('groupperm');
$hModule = &xoops_gethandler('module');
$module = &$hModule->getByDirname('publisher');
$module_id = $module->getVar('mid');

// At which record shall we start
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;

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

$itemsObj = $publisher_item_handler->getAllPublished($xoopsModuleConfig['indexperpage'], $start, $categoryid, $sort, $order);

if ($itemsObj) {
    $totalItemOnPage = count($itemsObj);
} else {
    $totalItemOnPage = 0;
}

// Arrays that will hold the informations passed on to smarty variables
$category = array();
$items = array();

// Populating the smarty variables with informations related to the selected category
$category = $categoryObj->toArray(null, true);
$category['categoryPath'] = $categoryObj->getCategoryPath($xoopsModuleConfig['linkedPath']);

//$totalItems = $publisher_category_handler->publishedItemsCount($xoopsModuleConfig['displaylastitem']);

if ($xoopsModuleConfig['displaylastitem'] == 1) {
	// Get the last smartitem
	$last_itemObj = $publisher_item_handler->getLastPublishedByCat();
}
$lastitemsize = intval($xoopsModuleConfig['lastitemsize']);

// Creating the sub-categories objects that belong to the selected category
$subcatsObj = $publisher_category_handler->getCategories(0, 0, $categoryid);
$total_subcats = count($subcatsObj);

//$totalItems = array();
$total_items = 0;
/*if ($total_subcats != 0) {
    $subcat_keys = array_keys($subcatsObj);
    foreach ( $subcat_keys as $i) {
        $subcat_id = $subcatsObj[$i]->getVar('categoryid');

        if (isset($totalItems[$subcat_id]) && $totalItems[$subcat_id] > 0 ) {
            if (isset($last_itemObj[$subcat_id])) {
             	$subcatsObj[$i]->setVar('last_itemid', $last_itemObj[$subcat_id]->getVar('itemid'));
                $subcatsObj[$i]->setVar('last_title_link', "<a href='item.php?itemid=" . $last_itemObj[$subcat_id]->getVar('itemid') . "'>" . $last_itemObj[$subcat_id]->title() . "</a>");
            }
        }
           // if(isset($subcatid)){
            	$subcatsObj[$i]->setVar('itemcount', $totalItems[$subcat_id]);
            	$subcats[$subcat_id] = $subcatsObj[$i]->toArray();
           		$total_items += $totalItems[$subcat_id];
            //}
      //}replacé à la ligne 95
    }
        if (isset($subcats)) {
    	$xoopsTpl->assign('subcats', $subcats);
    }
}
/*--------------------*/
	$subcategories = array();

	if ($xoopsModuleConfig['show_subcats'] != 'no' ) {
		// if this category has subcats
		if (isset($subcatsObj)) {
			foreach ($subcatsObj as $key => $subcat) {
				// Get the items count of this very category
				$subcat_total_items = isset($totalItems[$key]) ? $totalItems[$key] : 0;
				// Do we display empty sub-cats ?
				if (($subcat_total_items > 0) || ($xoopsModuleConfig['show_subcats'] == 'all' )) {
					$subcat_id = $subcat->getVar('categoryid');
					// if we retreived the last item object for this category
					if (isset($last_itemObj[$subcat_id])) {
						$subcat->setVar('last_itemid', $last_itemObj[$subcat_id]->itemid());
						$subcat->setVar('last_title_link', $last_itemObj[$key]->getItemLink(false, $lastitemsize));
					}

					$numItems= isset($totalItems[$subcat_id])? $totalItems[$key] :0;
					$subcat->setVar('itemcount', $numItems);
					// Put this subcat in the smarty variable
					$subcategories[$key] = $subcat->toArray();
					//$total += $numItems;
				}
                                if (($subcat_total_items > 0) || ($xoopsModuleConfig['show_subcats'] == 'nomain' )) {
					$subcat_id = $subcat->getVar('categoryid');
					// if we retreived the last item object for this category
					if (isset($last_itemObj[$subcat_id])) {
						$subcat->setVar('last_itemid', $last_itemObj[$subcat_id]->itemid());
						$subcat->setVar('last_title_link', $last_itemObj[$key]->getItemLink(false, $lastitemsize));
					}

					$numItems= isset($totalItems[$subcat_id])? $totalItems[$key] :0;
					$subcat->setVar('itemcount', $numItems);
					// Put this subcat in the smarty variable
					$subcategories[$key] = $subcat->toArray();
					//$total += $numItems;
				}
			}
		}
	}

	$category['subcats'] = $subcategories;
	$category['subcatscount'] = count($subcategories);

/*--------------------*/

$thiscategory_itemcount = isset($totalItems[$categoryid]) ? $totalItems[$categoryid] : 0;
$category['total'] = $thiscategory_itemcount;
if (count($itemsObj)>0) {
    $userids = array();
    if($itemsObj){
	    foreach ($itemsObj as $key => $thisitem) {
	        $itemids[] = $thisitem->getVar('itemid');
	        $userids[$thisitem->uid()] = 1;
	    }
    }
    $member_handler = &xoops_gethandler('member');
    $users = $member_handler->getUsers(new Criteria('uid', "(".implode(',', array_keys($userids)).")", "IN"), true);
    // Adding the items of the selected category

    for ( $i = 0; $i < $totalItemOnPage; $i++ ) {
		$item = $itemsObj[$i]->toArray(-1, $xoopsModuleConfig['titlesize']);
		$item['categoryname'] = $categoryObj->name();
		$item['categorylink'] = "<a href='" . publisher_seo_genUrl('category', $itemsObj[$i]->categoryid(), $categoryObj->short_url()) . "'>" . $categoryObj->name() . "</a>";
		$item['who_when'] = $itemsObj[$i]->getWhoAndWhen($users);

        $xoopsTpl->append('items', $item);
    }
    //var_dump( $last_itemObj[$categoryObj->getVar('categoryid')]);
    if (isset($last_itemObj[$categoryObj->getVar('categoryid')]) && $last_itemObj[$categoryObj->getVar('categoryid')]) {
    	$category['last_itemid'] = $last_itemObj[$categoryObj->getVar('categoryid')]->getVar('itemid');
        $category['last_title_link'] = $last_itemObj[$categoryObj->getVar('categoryid')]->getItemLink(false, $lastitemsize);
    }
}

$categories = array();
$categories[] = $category;
$xoopsTpl->assign('category', $category);
$xoopsTpl->assign('categories', $categories);


// Language constants

$xoopsTpl->assign(array('lang_on' => _MD_PUB_ON, 'lang_postedby' => _MD_PUB_POSTEDBY, 'lang_total' => $totalItemOnPage, 'lang_title' => _MD_PUB_TITLE, 'lang_datesub' => _MD_PUB_DATESUB, 'lang_hits' => _MD_PUB_HITS));
$xoopsTpl->assign('sectionname', $publisher_moduleName);
$xoopsTpl->assign('whereInSection', $publisher_moduleName);
$xoopsTpl->assign('modulename', $xoopsModule->dirname());
$xoopsTpl->assign('lang_category_summary', sprintf(_MD_PUB_CATEGORY_SUMMARY,$categoryObj->name()));
$xoopsTpl->assign('lang_category_summary_info', sprintf(_MD_PUB_CATEGORY_SUMMARY_INFO,$categoryObj->name()));
$xoopsTpl->assign('lang_items_title', sprintf(_MD_PUB_ITEMS_TITLE,$categoryObj->name()));
$xoopsTpl->assign('lang_items_info', _MD_PUB_ITEMS_INFO);
$xoopsTpl->assign('module_home', publisher_module_home($xoopsModuleConfig['linkedPath']));
$xoopsTpl->assign('categoryPath', $category['categoryPath']);
$xoopsTpl->assign('lang_name_column',_MD_PUB_NAME);
$xoopsTpl->assign('lang_empty',_MD_PUB_EMPTY);
$xoopsTpl->assign('lang_view_more',_MD_PUB_VIEW_MORE);
$xoopsTpl->assign('selected_category',$categoryid);

//$xoopsTpl->assign('lang_items_list', _MD_PUB_ITEMS_LIST);
//$xoopsTpl->assign('lang_link_xplain', _MD_PUB_LINK_XPLAIN);

// The Navigation Bar
include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
$pagenav = new XoopsPageNav($thiscategory_itemcount, $xoopsModuleConfig['indexperpage'], $start, 'start', 'categoryid=' . $categoryObj->getVar('categoryid'));
if ($xoopsModuleConfig['useimagenavpage'] == 1) {
    $navbar = '<div style="text-align:right;">' . $pagenav->renderImageNav() . '</div>';
} else {
    $navbar = '<div style="text-align:right;">' . $pagenav->renderNav() . '</div>';
}

$xoopsTpl->assign('navbar', $navbar);

/**
 * Generating meta information for this page
 */
$publisher_metagen = new PublisherMetagen($categoryObj->getVar('name'), $categoryObj->getVar('meta_keywords','n'), $categoryObj->getVar('meta_description', 'n'), $categoryObj->getCategoryPathForMetaTitle());
$publisher_metagen->createMetaTags();

//code to include smartie
/*if (file_exists(XOOPS_ROOT_PATH . '/modules/smarttie/smarttie_links.php')) {
	include_once XOOPS_ROOT_PATH . '/modules/smarttie/smarttie_links.php';
		$xoopsTpl->assign('smarttie',1);
}*/
//end code for smarttie

// RSS Link
if($xoopsModuleConfig['show_rss_link'] == 1){
	$link=sprintf("<a href='%s' title='%s'><img src='%s' border=0 alt='%s'></a>",XOOPS_URL."/modules/publisher/backend.php?categoryid=".$categoryid, _MD_PUB_RSSFEED, XOOPS_URL."/modules/publisher/images/rss.gif",_MD_PUB_RSSFEED);
	$xoopsTpl->assign('rssfeed_link',$link);
}

include_once(XOOPS_ROOT_PATH . "/footer.php");

?>