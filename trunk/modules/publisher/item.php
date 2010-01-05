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
 * @version         $Id: item.php 0 2009-06-11 18:47:04Z trabis $
 */

include_once dirname(__FILE__) . '/header.php';

$itemid = PublisherRequest::getInt('itemid');
$item_page_id = PublisherRequest::getInt('itemid', -1);

if ($itemid == 0) {
    redirect_header("javascript:history.go(-1)", 1, _MD_PUBLISHER_NOITEMSELECTED);
    exit();
}

// Creating the item object for the selected item
$itemObj = $publisher->getHandler('item')->get($itemid);

// if the selected item was not found, exit
if (!$itemObj) {
    redirect_header("javascript:history.go(-1)", 1, _MD_PUBLISHER_NOITEMSELECTED);
    exit();
}

$xoopsOption['template_main'] = 'publisher_item.html';
include_once XOOPS_ROOT_PATH . '/header.php';
include_once PUBLISHER_ROOT_PATH . '/footer.php';

// Creating the category object that holds the selected item
$categoryObj =& $publisher->getHandler('category')->get($itemObj->categoryid());

// Check user permissions to access that category of the selected item
if (!$itemObj->accessGranted()) {
    redirect_header("javascript:history.go(-1)", 1, _NOPERM);
    exit;
}

// Update the read counter of the selected item
if (!$xoopsUser || ($xoopsUser->isAdmin($publisher->getModule()->mid()) && $publisher->getConfig('item_admin_hits') == 1) || ($xoopsUser && !$xoopsUser->isAdmin($publisher->getModule()->mid()))) {
    $itemObj->updateCounter();
}

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

$itemsObj = $publisher->getHandler('item')->getAllPublished(0, 0, $categoryObj->categoryid(), $sort, $order, '', true, true);

// Retreiving the next and previous object
$array_keys = array();
foreach ($itemsObj as $key => $item) {
    $array_keys[$key]= $item->itemid();
}

$current_item = array_search($itemid, $array_keys);
$items_count = count($array_keys);
$previous_item = $current_item - 1;
$next_item = $current_item + 1;


if ($previous_item >= 0) {
    $previous_item_link = $itemsObj[$previous_item]->getItemLink();
    $previous_item_url = $itemsObj[$previous_item]->getItemUrl();
} else {
    $previous_item_link = '';
    $previous_item_url = '';
}

if ($next_item < $items_count) {
    $next_item_link = $itemsObj[$next_item]->getItemLink();
    $next_item_url = $itemsObj[$next_item]->getItemUrl();
} else {
    $next_item_link = '';
    $next_item_url = '';
}

// Populating the smarty variables with informations related to the selected item
$item = $itemObj->toArray($item_page_id);

if ($itemObj->pagescount() > 0) {
    if ($item_page_id == -1) {
        $item_page_id = 0;
    }
    include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
    $pagenav = new XoopsPageNav($itemObj->pagescount(), 1, $item_page_id, 'page', 'itemid=' . $itemObj->itemid());
    $xoopsTpl->assign('pagenav', $pagenav->renderNav());
}

$items = array();
foreach ($itemsObj as $theitemObj) {
    $theitem['titlelink'] = $theitemObj->getItemLink();
    $theitem['datesub'] = $theitemObj->datesub();
    $theitem['counter'] = $theitemObj->counter();
    if ($theitemObj->itemid() == $itemObj->itemid()) {
        $theitem['titlelink'] = $theitemObj->title();
    }
    $items[] = $theitem;
    unset($theitem);
}
$xoopsTpl->assign('items', $items);

// Creating the files object associated with this item
$filesObj = $itemObj->getFiles();

$file = array();
$files = array();
$embeded_files = array();

foreach ($filesObj as $fileObj) {
    if ($fileObj->mimetype() == 'application/x-shockwave-flash') {
        $file['content'] = $fileObj->displayFlash();

        if (strpos($item['maintext'], '[flash-' . $fileObj->getVar('fileid') . ']')) {
            $item['maintext'] = str_replace('[flash-' . $fileObj->getVar('fileid') . ']', $file['content'], $item['maintext']);
        } else {
            $embeded_files[] = $file;
        }
    } else {
        $file['fileid'] = $fileObj->fileid();
        $file['name'] = $fileObj->name();
        $file['description'] = $fileObj->description();
        $file['name'] = $fileObj->name();
        $file['type'] = $fileObj->mimetype();
        $file['datesub'] = $fileObj->datesub();
        $file['hits'] = $fileObj->counter();
        $files[] = $file;
    }
}

$item['files'] = $files;
$item['embeded_files'] = $embeded_files;
unset($file, $embeded_files, $filesObj, $fileObj);

// Language constants
$xoopsTpl->assign('mail_link', 'mailto:?subject=' . sprintf(_CO_PUBLISHER_INTITEM, $xoopsConfig['sitename']) . '&amp;body=' . sprintf(_CO_PUBLISHER_INTITEMFOUND, $xoopsConfig['sitename']) . ': ' . $itemObj->getItemUrl());
$xoopsTpl->assign('lang_printerpage', _MD_PUBLISHER_PRINTERFRIENDLY);
$xoopsTpl->assign('lang_sendstory', _MD_PUBLISHER_SENDSTORY);
$xoopsTpl->assign('itemid', $itemObj->itemid());
$xoopsTpl->assign('sectionname', $publisher->getModule()->getVar('name'));
$xoopsTpl->assign('modulename', $publisher->getModule()->getVar('dirname'));
$xoopsTpl->assign('lang_home', _MD_PUBLISHER_HOME);
$xoopsTpl->assign('lang_item', _MD_PUBLISHER_OTHER_ITEMS);
$xoopsTpl->assign('lang_postedby', _CO_PUBLISHER_POSTEDBY);
$xoopsTpl->assign('lang_on', _MD_PUBLISHER_ON);
$xoopsTpl->assign('lang_datesub', _MD_PUBLISHER_DATESUB);
$xoopsTpl->assign('lang_hitsdetail', _MD_PUBLISHER_HITSDETAIL);
$xoopsTpl->assign('lang_reads', _MD_PUBLISHER_READS);
$xoopsTpl->assign('lang_comments', _MD_PUBLISHER_COMMENTS);
$xoopsTpl->assign('lang_files_linked', _MD_PUBLISHER_FILES_LINKED);
$xoopsTpl->assign('lang_file_name', _MD_PUBLISHER_FILENAME);
$xoopsTpl->assign('lang_file_type', _MD_PUBLISHER_FILE_TYPE);
$xoopsTpl->assign('lang_hits', _MD_PUBLISHER_HITS);
$xoopsTpl->assign('lang_download_file', _MD_PUBLISHER_DOWNLOAD_FILE);
$xoopsTpl->assign('lang_page', _MD_PUBLISHER_PAGE);
$xoopsTpl->assign('lang_previous_item', _MD_PUBLISHER_PREVIOUS_ITEM);
$xoopsTpl->assign('lang_next_item', _MD_PUBLISHER_NEXT_ITEM);

$xoopsTpl->assign('module_home', publisher_moduleHome($publisher->getConfig('format_linked_path')));
$xoopsTpl->assign('categoryPath', $item['categoryPath'] . " > " . $item['title']);
$xoopsTpl->assign('commentatarticlelevel', $publisher->getConfig('perm_com_art_level'));
$xoopsTpl->assign('com_rule', $publisher->getConfig('com_rule'));
$xoopsTpl->assign('lang_items_links', _MD_PUBLISHER_ITEMS_LINKS);
$xoopsTpl->assign('previous_item_link', $previous_item_link);
$xoopsTpl->assign('next_item_link', $next_item_link);
$xoopsTpl->assign('previous_item_url', $previous_item_url);
$xoopsTpl->assign('next_item_url', $next_item_url);
$xoopsTpl->assign('other_items', $publisher->getConfig('item_other_items_type'));

$xoopsTpl->assign('itemfooter', $myts->displayTarea($publisher->getConfig('item_footer'), 1));

$xoopsTpl->assign('perm_author_items', $publisher->getConfig('perm_author_items'));

// tags support
if (xoops_isActiveModule('tag')) {
    include_once XOOPS_ROOT_PATH . '/modules/tag/include/tagbar.php';
    $xoopsTpl->assign('tagbar', tagBar($itemid, $catid = 0));
}

/**
 * Generating meta information for this page
 */
$publisher_metagen = new PublisherMetagen($itemObj->getVar('title'), $itemObj->getVar('meta_keywords','n'), $itemObj->getVar('meta_description', 'n'), $itemObj->getCategoryPath());
$publisher_metagen->createMetaTags();

// Include the comments if the selected ITEM supports comments
if ((($itemObj->cancomment() == 1) || !$publisher->getConfig('perm_com_art_level')) && ($publisher->getConfig('com_rule') <> 0)) {
    include_once XOOPS_ROOT_PATH . "/include/comment_view.php";
    // Problem with url_rewrite and posting comments :
    $xoopsTpl->assign(array('editcomment_link' => PUBLISHER_URL . '/comment_edit.php?com_itemid=' . $com_itemid . '&amp;com_order=' . $com_order . '&amp;com_mode=' . $com_mode . $link_extra,
        'deletecomment_link' => PUBLISHER_URL . '/comment_delete.php?com_itemid=' . $com_itemid . '&amp;com_order=' . $com_order . '&amp;com_mode=' . $com_mode . $link_extra,
        'replycomment_link' => PUBLISHER_URL . '/comment_reply.php?com_itemid='  .$com_itemid . '&amp;com_order=' . $com_order . '&amp;com_mode=' . $com_mode . $link_extra));
    $xoopsTpl->_tpl_vars['commentsnav'] = str_replace("self.location.href='", "self.location.href='" . PUBLISHER_URL . '/', $xoopsTpl->_tpl_vars['commentsnav']);
}

// Include support for AJAX rating
if ($publisher->getConfig('perm_rating')) {
    $xoopsTpl->assign('rating_enabled', true);
    $item['ratingbar'] = publisher_ratingBar($itemid);
    $xoTheme->addScript(PUBLISHER_URL . '/js/behavior.js');
    $xoTheme->addScript(PUBLISHER_URL . '/js/rating.js');
}

$xoopsTpl->assign('item', $item);
include_once XOOPS_ROOT_PATH . '/footer.php';
?>