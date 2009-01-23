<?php

/**
* $Id: items_random_item.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("XOOPS_ROOT_PATH")) {
die("XOOPS root path not defined");
}

function publisher_items_random_item_show($options)
{
	include_once(XOOPS_ROOT_PATH."/modules/publisher/include/common.php");

    $block = array();
	$publisher_item_handler =& publisher_gethandler('item');
    // creating the ITEM object
    $itemsObj = $publisher_item_handler->getRandomItem('summary', array(_PUB_STATUS_PUBLISHED));

    if ($itemsObj) {
       	$block['content'] = $itemsObj->summary();
       	$block['id'] = $itemsObj->itemid();
       	$block['url'] = $itemsObj->getItemUrl();
       	$block['lang_fullitem'] = _MB_PUB_FULLITEM;
    }

    return $block;
}

?>