<?php

/**
* $Id: items_recent.php 1449 2008-04-06 05:10:14Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("XOOPS_ROOT_PATH")) {
die("XOOPS root path not defined");
}

function publisher_items_recent_show($options)
{
	include_once(XOOPS_ROOT_PATH."/modules/publisher/include/common.php");

	$myts = &MyTextSanitizer::getInstance();

   	$smartModule =& publisher_getModuleInfo();

	$block = array();

	$selectedcatids = explode(',', $options[0]);

	if (in_array(0, $selectedcatids)) {
		$allcats = true;
	} else {
		$allcats = false;
	}
	
	$sort = $options[1];
	$order = publisher_getOrderBy($sort);
	$limit = $options[2];
	$publisher_item_handler =& publisher_gethandler('item');
	// creating the ITEM objects that belong to the selected category
	if ($allcats) {
		$criteria=null;
	} else {
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('categoryid', '(' . $options[0] . ')', 'IN'));
	}	
	$itemsObj = $publisher_item_handler->getItems($limit, $start, array(_PUB_STATUS_PUBLISHED), -1, $sort, $order, '', true, $criteria, true);
	
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
	}

	return $block;
}

function publisher_items_recent_edit($options)
{
	include_once(XOOPS_ROOT_PATH."/modules/publisher/include/functions.php");

	$form .= '
	<table>
		<tr>
			<td style="vertical-align: top; width: 150px;">' . _MB_PUB_SELECTCAT . '</td>';
	$form .= '<td>';
	$form .= publisher_createCategorySelect($options[0]) . '</td>';
		
    $form .= "<tr><td>" . _MB_PUB_ORDER . "</td>";
    $form .= "<td><select name='options[]'>";

    $form .= "<option value='datesub'";
    if ($options[1] == "datesub") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_PUB_DATE . "</option>";

    $form .= "<option value='counter'";
    if ($options[1] == "counter") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_PUB_HITS . "</option>";

    $form .= "<option value='weight'";
    if ($options[1] == "weight") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_PUB_WEIGHT . "</option>";

    $form .= "</select></td>";

    $form .= "</tr><tr><td>" . _MB_PUB_DISP . "</td><td><input type='text' name='options[]' value='" . $options[2] . "' />&nbsp;" . _MB_PUB_ITEMS . "</td></tr>";
    $form .= "<tr><td>" . _MB_PUB_CHARS . "</td><td><input type='text' name='options[]' value='" . $options[3] . "' />&nbsp;chars</td></tr>";
	$form .= "</table>";
    return $form;
	}

?>