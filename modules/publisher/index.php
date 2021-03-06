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
 * @version         $Id$
 */

include_once dirname(__FILE__) . '/header.php';

// At which record shall we start for the Categories
$catstart = PublisherRequest::getInt('catstart');

// At which record shall we start for the ITEM
$start = PublisherRequest::getInt('start');

// Number of categories at the top level
$totalCategories = $publisher->getHandler('category')->getCategoriesCount(0);

// if there ain't no category to display, let's get out of here
if ($totalCategories == 0) {
    redirect_header(XOOPS_URL, 2, _MD_PUBLISHER_NO_TOP_PERMISSIONS);
    exit;
}


$xoopsOption['template_main'] = 'publisher_display' . '_' . $publisher->getConfig('idxcat_items_display_type') . '.html';
include_once XOOPS_ROOT_PATH . '/header.php';
include_once PUBLISHER_ROOT_PATH . '/footer.php';

$gperm_handler = xoops_gethandler('groupperm');

// Creating the top categories objects
$categoriesObj = $publisher->getHandler('category')->getCategories($publisher->getConfig('idxcat_cat_perpage'), $catstart);

// if no categories are found, exit
$totalCategoriesOnPage = count($categoriesObj);
if ($totalCategoriesOnPage == 0) {
    redirect_header("javascript:history.go(-1)", 2, _MD_PUBLISHER_NO_CAT_EXISTS);
    exit;
}
        //exit('here');
// Get subcats of the top categories
$subcats = $publisher->getHandler('category')->getSubCats($categoriesObj);

// Count of items within each top categories
$totalItems = $publisher->getHandler('category')->publishedItemsCount();

// real total count of items
$real_total_items = $publisher->getHandler('item')->getItemsCount(-1, array(_PUBLISHER_STATUS_PUBLISHED));

if ($publisher->getConfig('idxcat_display_last_item') == 1) {
    // Get the last item in each category
    $last_itemObj = $publisher->getHandler('item')->getLastPublishedByCat();
}

// Max size of the title in the last item column
$lastitemsize = intval($publisher->getConfig('idxcat_last_item_size'));

// Hide sub categories in main page only - hacked by Mowaffak
if ($publisher->getConfig('idxcat_show_subcats') == 'nomain') {
    $publisher->setConfig('idxcat_show_subcats', 'no');
}

$categories = array();
foreach ($categoriesObj as $cat_id => $category) {

    $total = 0;
    // Do we display sub categories ?
    if ($publisher->getConfig('idxcat_show_subcats') != 'no') {
        // if this category has subcats
        if (isset($subcats[$cat_id])) {
            foreach ($subcats[$cat_id] as $key => $subcat) {
                // Get the items count of this very category
                $subcat_total_items = isset($totalItems[$key]) ? $totalItems[$key] : 0;
                // Do we display empty sub-cats ?
                if (($subcat_total_items > 0) || ($publisher->getConfig('idxcat_show_subcats') == 'all')) {
                    $subcat_id = $subcat->getVar('categoryid');
                    // if we retrieved the last item object for this category
                    if (isset($last_itemObj[$subcat_id])) {
                        $subcat->setVar('last_itemid', $last_itemObj[$subcat_id]->itemid());
                        $subcat->setVar('last_title_link', $last_itemObj[$subcat_id]->getItemLink(false, $lastitemsize));
                    }

                    $numItems = isset($totalItems[$subcat_id]) ? $totalItems[$key] : 0;
                    $subcat->setVar('itemcount', $numItems);
                    // Put this subcat in the smarty variable
                    $categories[$cat_id]['subcats'][$key] = $subcat->toArrayTable();
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
    // if ($total > 0) {
    if (isset($last_itemObj[$cat_id])) {
        $category->setVar('last_itemid', $last_itemObj[$cat_id]->getVar('itemid'));
        $category->setVar('last_title_link', $last_itemObj[$cat_id]->getItemLink(false, $lastitemsize));
    }
    $category->setVar('itemcount', $total);

    if (!isset($categories[$cat_id])) {
        $categories[$cat_id] = array();
    }

    $categories[$cat_id] = $category->toArrayTable($categories[$cat_id]);
}
unset($categoriesObj);

if (isset($categories[$cat_id])) {
    $categories[$cat_id] = $category->ToArraySimple($categories[$cat_id]);
    $categories[$cat_id]['categoryPath'] = $category->getCategoryPath($publisher->getConfig('format_linked_path'));
}

$xoopsTpl->assign('categories', $categories);

if ($publisher->getConfig('index_display_last_items')) {
    // creating the Item objects that belong to the selected category
    switch ($publisher->getConfig('format_order_by')) {
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
    $itemsObj = $publisher->getHandler('item')->getAllPublished($publisher->getConfig('idxcat_index_perpage'), $start, -1, $sort, $order);
    $itemsCount = count($itemsObj);

    //todo: make config for summary size
    if ($itemsCount > 0) {
        foreach ($itemsObj as $itemObj) {
            $xoopsTpl->append('items', $itemObj->ToArraySimple($publisher->getConfig('idxcat_items_display_type'), $publisher->getConfig('item_title_size'), 300, true)); //if no summary truncate body to 300
        }
        $xoopsTpl->assign('show_subtitle', $publisher->getConfig('index_disp_subtitle'));
        unset($allcategories);
    }
    unset($itemsObj);

}

// Language constants
$xoopsTpl->assign('title_and_welcome', $publisher->getConfig('index_title_and_welcome')); //SHINE ADDED DEBUG mainintro txt
$xoopsTpl->assign('lang_mainintro', $myts->displayTarea($publisher->getConfig('index_welcome_msg'), 1));
$xoopsTpl->assign('sectionname', $publisher->getModule()->getVar('name'));
$xoopsTpl->assign('whereInSection', $publisher->getModule()->getVar('name'));
$xoopsTpl->assign('module_home', publisher_moduleHome(false));
$xoopsTpl->assign('indexfooter', $myts->displayTarea($publisher->getConfig('index_footer'), 1));

$xoopsTpl->assign('lang_category_summary', _MD_PUBLISHER_INDEX_CATEGORIES_SUMMARY);
$xoopsTpl->assign('lang_category_summary_info', _MD_PUBLISHER_INDEX_CATEGORIES_SUMMARY_INFO);
$xoopsTpl->assign('lang_items_title', _MD_PUBLISHER_INDEX_ITEMS);
$xoopsTpl->assign('indexpage', true);


include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
// Category Navigation Bar
$pagenav = new XoopsPageNav($totalCategories, $publisher->getConfig('idxcat_cat_perpage'), $catstart, 'catstart', '');
if ($publisher->getConfig('format_image_nav') == 1) {
    $xoopsTpl->assign('catnavbar', '<div style="text-align:right;">' . $pagenav->renderImageNav() . '</div>');
} else {
    $xoopsTpl->assign('catnavbar', '<div style="text-align:right;">' . $pagenav->renderNav() . '</div>');
}
// ITEM Navigation Bar
$pagenav = new XoopsPageNav($real_total_items, $publisher->getConfig('idxcat_index_perpage'), $start, 'start', '');
if ($publisher->getConfig('format_image_nav') == 1) {
    $xoopsTpl->assign('navbar', '<div style="text-align:right;">' . $pagenav->renderImageNav() . '</div>');
} else {
    $xoopsTpl->assign('navbar', '<div style="text-align:right;">' . $pagenav->renderNav() . '</div>');
}
//show subcategories
$xoopsTpl->assign('show_subcats', $publisher->getConfig('idxcat_show_subcats'));
$xoopsTpl->assign('displaylastitems', $publisher->getConfig('index_display_last_items'));

/**
 * Generating meta information for this page
 */
$publisher_metagen = new PublisherMetagen($publisher->getModule()->getVar('name'));
$publisher_metagen->createMetaTags();

// RSS Link
if ($publisher->getConfig('idxcat_show_rss_link') == 1) {
    $link = sprintf("<a href='%s' title='%s'><img src='%s' border=0 alt='%s'></a>", PUBLISHER_URL . "/backend.php", _MD_PUBLISHER_RSSFEED, PUBLISHER_URL . "/images/rss.gif", _MD_PUBLISHER_RSSFEED);
    $xoopsTpl->assign('rssfeed_link', $link);
}

include_once XOOPS_ROOT_PATH . '/footer.php';