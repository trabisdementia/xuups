<?php

/**
* $Id: item.php 1440 2008-04-05 13:27:01Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once("header.php");

global $publisher_item_handler, $publisher_category_handler, $xoopsUser, $xoopsConfig, $xoopsModuleConfig, $xoopsModule;

$itemid = isset($_GET['itemid']) ? intval($_GET['itemid']) : 0;
$item_page_id = isset($_GET['page']) ? intval($_GET['page']) : -1;

if ($itemid == 0) {
	redirect_header("javascript:history.go(-1)", 1, _MD_PUB_NOITEMSELECTED);
	exit();
}

// Creating the item object for the selected item
$itemObj = $publisher_item_handler->get($itemid);

// if the selected item was not found, exit
if (!$itemObj) {
	redirect_header("javascript:history.go(-1)", 1, _MD_PUB_NOITEMSELECTED);
	exit();
}

$xoopsOption['template_main'] = 'publisher_item.html';
include_once(XOOPS_ROOT_PATH . "/header.php");
include_once("footer.php");

// Creating the category object that holds the selected item
$categoryObj =& $publisher_category_handler->get($itemObj->categoryid());

// Check user permissions to access that category of the selected item
if (!(publisher_itemAccessGranted($itemObj))) {
	redirect_header("javascript:history.go(-1)", 1, _NOPERM);
	exit;
}

// Update the read counter of the selected item
if (!$xoopsUser || ($xoopsUser->isAdmin($xoopsModule->mid()) && $xoopsModuleConfig['adminhits'] == 1) || ($xoopsUser && !$xoopsUser->isAdmin($xoopsModule->mid()))) {
	$itemObj->updateCounter();
}

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

$itemsObj = $publisher_item_handler->getAllPublished(0, 0, $categoryObj->categoryid(), $sort, $order, '', true, true);

// Retreiving the next and previous object
$array_keys = array();
foreach ($itemsObj as $key=> $item){
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
$item['who_when'] = $itemObj->getWhoAndWhen();

if ($itemObj->pagescount() > 0) {
	include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
	if ($item_page_id == -1) ($item_page_id = 0);
    $pagenav = new XoopsPageNav($itemObj->pagescount(), 1, $item_page_id, 'page', 'itemid=' . $itemObj->itemid());
    $xoopsTpl->assign('pagenav', $pagenav->renderNav());
}


$items = array();

foreach($itemsObj as $theitemObj)
{
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

$files = array();
$embeded_files = array();

foreach($filesObj as $fileObj)
{
	if ($fileObj->mimetype() == 'application/x-shockwave-flash') {
		$file['content'] = $fileObj->displayFlash();

		if (strpos($item['maintext'], '[flash-' . $fileObj->getVar('fileid') . ']')) {
			$item['maintext'] = str_replace('[flash-' . $fileObj->getVar('fileid') . ']', $file['content'], $item['maintext']);
		} else {
			$embeded_files[] = $file;
		}
		unset($file);
	} else {
		$file['fileid'] = $fileObj->fileid();
		$file['name'] = $fileObj->name();
		$file['description'] = $fileObj->description();
		$file['name'] = $fileObj->name();
		$file['type'] = $fileObj->mimetype();
		$file['datesub'] = $fileObj->datesub();
		$file['hits'] = $fileObj->counter();
		$files[] = $file;
		unset($file);
	}

}
$item['files'] = $files;
$item['embeded_files'] = $embeded_files;

// Language constants
$xoopsTpl->assign('item', $item);
$xoopsTpl->assign('mail_link', 'mailto:?subject=' . sprintf(_MD_PUB_INTITEM, $xoopsConfig['sitename']) . '&amp;body=' . sprintf(_MD_PUB_INTITEMFOUND, $xoopsConfig['sitename']) . ': ' . $itemObj->getItemUrl());
$xoopsTpl->assign('lang_printerpage', _MD_PUB_PRINTERFRIENDLY);
$xoopsTpl->assign('lang_sendstory', _MD_PUB_SENDSTORY);
$xoopsTpl->assign('itemid', $itemObj->itemid());
$xoopsTpl->assign('sectionname', $publisher_moduleName);
$xoopsTpl->assign('modulename', $xoopsModule->dirname());
$xoopsTpl->assign('lang_home', _MD_PUB_HOME);
$xoopsTpl->assign('lang_item', _MD_PUB_OTHER_ITEMS);
$xoopsTpl->assign('lang_postedby', _MD_PUB_POSTEDBY);
$xoopsTpl->assign('lang_on', _MD_PUB_ON);
$xoopsTpl->assign('lang_datesub', _MD_PUB_DATESUB);
$xoopsTpl->assign('lang_hitsdetail', _MD_PUB_HITSDETAIL);
$xoopsTpl->assign('lang_reads', _MD_PUB_READS);
$xoopsTpl->assign('lang_comments', _MD_PUB_COMMENTS);
$xoopsTpl->assign('lang_files_linked', _MD_PUB_FILES_LINKED);
$xoopsTpl->assign('lang_file_name', _MD_PUB_FILENAME);
$xoopsTpl->assign('lang_file_type', _MD_PUB_FILE_TYPE);
$xoopsTpl->assign('lang_hits', _MD_PUB_HITS);
$xoopsTpl->assign('lang_download_file', _MD_PUB_DOWNLOAD_FILE);
$xoopsTpl->assign('lang_page', _MD_PUB_PAGE);
$xoopsTpl->assign('lang_previous_item', _MD_PUB_PREVIOUS_ITEM);
$xoopsTpl->assign('lang_next_item', _MD_PUB_NEXT_ITEM);

$xoopsTpl->assign('module_home', publisher_module_home($xoopsModuleConfig['linkedPath']));
$xoopsTpl->assign('categoryPath', $item['categoryPath'] . " > " . $item['title']);
$xoopsTpl->assign('commentatarticlelevel', $xoopsModuleConfig['commentatarticlelevel']);
$xoopsTpl->assign('com_rule', publisher_getConfig('com_rule'));
$xoopsTpl->assign('lang_items_links', _MD_PUB_ITEMS_LINKS);
$xoopsTpl->assign('previous_item_link', $previous_item_link);
$xoopsTpl->assign('next_item_link', $next_item_link);
$xoopsTpl->assign('previous_item_url', $previous_item_url);
$xoopsTpl->assign('next_item_url', $next_item_url);
$xoopsTpl->assign('other_items', $xoopsModuleConfig['other_items_type']);

$itemFooter = publisher_getConfig('itemfooter');
$itemFooter = $myts->displayTarea($itemFooter);
$xoopsTpl->assign('itemfooter', $itemFooter);

// tags support
if (publisher_tag_module_included()) {
	include_once XOOPS_ROOT_PATH."/modules/tag/include/tagbar.php";
	$xoopsTpl->assign('tagbar', tagBar($itemid, $catid = 0));
}
/**
 * Generating meta information for this page
 */
$publisher_metagen = new PublisherMetagen($itemObj->getVar('title'), $itemObj->getVar('meta_keywords','n'), $itemObj->getVar('meta_description', 'n'), $itemObj->getCategoryPath());
$publisher_metagen->createMetaTags();

//SmartObject Rating feature
if (file_exists(XOOPS_ROOT_PATH . '/modules/smartobject/include/rating.rate.php')) {
	include_once(XOOPS_ROOT_PATH . '/modules/smartobject/include/rating.rate.php');
}

// Include the comments if the selected ITEM supports comments
if ((($itemObj->cancomment() == 1) || !$xoopsModuleConfig['commentatarticlelevel']) && (publisher_getConfig('com_rule') <> 0)) {
    include_once XOOPS_ROOT_PATH . "/include/comment_view.php";
    // Problem with url_rewrite and posting comments :
    $xoopsTpl->assign(array('editcomment_link' => PUBLISHER_URL . '/comment_edit.php?com_itemid='.$com_itemid.'&amp;com_order='.$com_order.'&amp;com_mode='.$com_mode.''.$link_extra, 'deletecomment_link' => PUBLISHER_URL . '/comment_delete.php?com_itemid='.$com_itemid.'&amp;com_order='.$com_order.'&amp;com_mode='.$com_mode.''.$link_extra, 'replycomment_link' => PUBLISHER_URL . '/comment_reply.php?com_itemid='.$com_itemid.'&amp;com_order='.$com_order.'&amp;com_mode='.$com_mode.''.$link_extra));
    $xoopsTpl->_tpl_vars['commentsnav'] = str_replace("self.location.href='", "self.location.href='" . PUBLISHER_URL, $xoopsTpl->_tpl_vars['commentsnav']);
}

$xoopsTpl->assign('rating_enabled', $xoopsModuleConfig['rating_enabled']);

$newGroupsArray = array();
$newGroupsArray[0] = 'None';
if ( is_array($groups) ) {
    foreach($groups as $key=>$value) {
        $newGroupsArray[$key] = $value;
    }
}

//code to include smartie
/*if (file_exists(XOOPS_ROOT_PATH . '/modules/smarttie/smarttie_links.php')) {
	include_once XOOPS_ROOT_PATH . '/modules/smarttie/smarttie_links.php';
		$xoopsTpl->assign('smarttie',1);
}*/
//end code for smarttie
include_once XOOPS_ROOT_PATH . '/footer.php';

?>
