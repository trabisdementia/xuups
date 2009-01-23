<?php

/**
* $Id: search.inc.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

function publisher_search($queryarray, $andor, $limit, $offset, $userid)
{
	include_once XOOPS_ROOT_PATH.'/modules/publisher/include/functions.php';

	$ret = array();

	if (!isset($publisher_item_handler)) {
		$publisher_item_handler = xoops_getmodulehandler('item', 'publisher');
	}

	if ($queryarray == '' || count($queryarray) == 0){
		$keywords= '';
		$hightlight_key = '';
	} else {
		$keywords=implode('+', $queryarray);
		$hightlight_key = "&amp;keywords=" . $keywords;
	}

	$itemsObj =& $publisher_item_handler->getItemsFromSearch($queryarray, $andor, $limit, $offset, $userid);

	$withCategoryPath = publisher_getConfig('catpath_search');

	foreach ($itemsObj as $result) {
		$item['image'] = "images/item_icon.gif";
		$item['link'] = "item.php?itemid=" . $result['id'] . $hightlight_key;
		if ($withCategoryPath) {
			$item['title'] = $result['categoryPath'] . $result['title'];
		} else {
			$item['title'] = "" . $result['title'];
		}
		$item['time'] = $result['datesub'];
		$item['uid'] = $result['uid'];
		$ret[] = $item;
		unset($item);
	}

	return $ret;
}

?>