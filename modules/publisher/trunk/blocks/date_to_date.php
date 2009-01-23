<?php

/**
* $Id: date_to_date.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("XOOPS_ROOT_PATH")) {
die("XOOPS root path not defined");
}

function publisher_date_to_date_show($options)
{
	include_once(XOOPS_ROOT_PATH."/modules/publisher/include/common.php");

	$myts = &MyTextSanitizer::getInstance();

   	$smartModule =& publisher_getModuleInfo();

	$block = array();
	$fromArray = explode('/', $options[0]);
	//month, day, year
	$fromStamp = mktime(0,0,0,$fromArray[0], $fromArray[1], $fromArray[2]);
	$untilArray = explode('/', $options[1]);
	$untilStamp = mktime(0,0,0,$untilArray[0], $untilArray[1], $untilArray[2]);

	$criteria = new CriteriaCompo();
	$criteria->add(new Criteria('datesub', $fromStamp, '>'));
	$criteria->add(new Criteria('datesub', $untilStamp, '<'));
	$criteria->setSort('datesub');
	$criteria->setOrder('DESC');



	$publisher_item_handler =& publisher_gethandler('item');
	// creating the ITEM objects that belong to the selected category
	$itemsObj = $publisher_item_handler->getObjects($criteria);
	$totalItems = count($itemsObj);

	if ($itemsObj) {
		for ( $i = 0; $i < $totalItems; $i++ ) {

			$newItems['itemid'] = $itemsObj[$i]->itemid();
			$newItems['title'] = $itemsObj[$i]->title();
			$newItems['categoryname'] = $itemsObj[$i]->getCategoryName();
			$newItems['categoryid'] = $itemsObj[$i]->categoryid();
			$newItems['date'] = $itemsObj[$i]->datesub();
			$newItems['poster'] = xoops_getLinkedUnameFromId($itemsObj[$i]->uid());
			$newItems['itemlink'] = $itemsObj[$i]->getItemLink(false, isset($options[3]) ? $options[3] : 65);
			$newItems['categorylink'] = $itemsObj[$i]->getCategoryLink();

			$block['items'][] = $newItems;
		}

		$block['lang_title'] = _MB_PUB_ITEMS;
		$block['lang_category'] = _MB_PUB_CATEGORY;
		$block['lang_poster'] = _MB_PUB_POSTEDBY;
		$block['lang_date'] = _MB_PUB_DATE;
		$modulename = $myts->makeTboxData4Show($smartModule->getVar('name'));
		$block['lang_visitItem'] = _MB_PUB_VISITITEM . " " . $modulename;
		$block['lang_articles_from_to'] = sprintf(_MB_PUB_ARTICLES_FROM_TO, $options[0], $options[1]);
	}

	return $block;
}

function publisher_date_to_date_edit($options)
{
	include_once(XOOPS_ROOT_PATH."/modules/publisher/include/functions.php");
	$form =  _MB_PUB_FROM . "<input type='text' name='options[]' value='" . $options[0] . "' />&nbsp;<br />";
    $form .= _MB_PUB_UNTIL . "&nbsp;<input type='text' name='options[]' value='" . $options[1] . "' /><br/>"._MB_PUB_DATE_FORMAT;

return $form;
}

?>