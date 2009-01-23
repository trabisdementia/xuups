<?php

/**
* $Id: items_menu.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("XOOPS_ROOT_PATH")) {
die("XOOPS root path not defined");
}

function publisher_items_menu_show($options)
{
	include_once(XOOPS_ROOT_PATH."/modules/publisher/include/common.php");

	$block = array();
	/*if ($options[0] == 0) {
		$categoryid = -1;
	} else {
		$categoryid = $options[0];
	}

	$sort = $options[1];
	$order = publisher_getOrderBy($sort);
	$limit = $options[2];
	*/
	$publisher_item_handler =& publisher_gethandler('item');
	$publisher_category_handler =& publisher_gethandler('category');

	// Are we in Publisher ?
	global $xoopsModule;

	$block['inModule'] = (isset($xoopsModule) && ($xoopsModule->getVar('dirname') == 'publisher'));

	$catlink_class = 'menuMain';

	$categoryid = 0;

	if ($block['inModule']) {
		// Are we in a category and if yes, in which one ?
		$categoryid = isset($_GET['categoryid']) ? $_GET['categoryid'] : 0;

		if ($categoryid != 0) {
			// if we are in a category, then the $categoryObj is already defined in publisher/category.php
			global $categoryObj;
			$block['currentcat'] = $categoryObj->getCategoryLink('menuTop');
			$catlink_class = 'menuSub';
		}
	}

	// Getting all top cats
	$block_categoriesObj = $publisher_category_handler->getCategories(0, 0, 0);

	$array_categoryids = array_keys($block_categoriesObj);
	$categoryids = implode(', ', $array_categoryids);

	foreach ($block_categoriesObj as $catid => $block_categoryObj) {
		if($catid !=$categoryid){
			$block['categories'][$catid]['categoryLink'] = $block_categoryObj->getCategoryLink($catlink_class);
		}
	}

	return $block;
}

function publisher_items_menu_edit($options)
{
    global $xoopsDB, $xoopsModule, $xoopsUser;
	include_once(XOOPS_ROOT_PATH."/modules/publisher/include/functions.php");

	$form = publisher_createCategorySelect($options[0]);

    $form .= "&nbsp;<br>" . _MB_PUB_ORDER . "&nbsp;<select name='options[]'>";

    $form .= "<option value='datesub'";
    if ($options[1] == "datesub") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_PUB_DATE . "</option>\n";

    $form .= "<option value='counter'";
    if ($options[1] == "counter") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_PUB_HITS . "</option>\n";

    $form .= "<option value='weight'";
    if ($options[1] == "weight") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_PUB_WEIGHT . "</option>\n";

    $form .= "</select>\n";

    $form .= "&nbsp;" . _MB_PUB_DISP . "&nbsp;<input type='text' name='options[]' value='" . $options[2] . "' />&nbsp;" . _MB_PUB_ITEMS . "";

    return $form;
}

?>