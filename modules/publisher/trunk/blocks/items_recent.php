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
 * @subpackage      Blocks
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: items_recent.php 0 2009-06-11 18:47:04Z trabis $
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once dirname(dirname(__FILE__)) . '/include/common.php';

function publisher_items_recent_show($options)
{
    $publisher =& PublisherPublisher::getInstance();
	$myts =& MyTextSanitizer::getInstance();

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
	$start = 0;
	
	// creating the ITEM objects that belong to the selected category
	if ($allcats) {
		$criteria = null;
	} else {
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('categoryid', '(' . $options[0] . ')', 'IN'));
	}	
	$itemsObj = $publisher->getHandler('item')->getItems($limit, $start, array(_PUBLISHER_STATUS_PUBLISHED), -1, $sort, $order, '', true, $criteria, true);
	
	$totalItems = count($itemsObj);

	if ($itemsObj) {
		for ( $i = 0; $i < $totalItems; $i++ ) {

			$newItems['itemid']       = $itemsObj[$i]->itemid();
			$newItems['title']        = $itemsObj[$i]->title();
			$newItems['categoryname'] = $itemsObj[$i]->getCategoryName();
			$newItems['categoryid']   = $itemsObj[$i]->categoryid();
			$newItems['date']         = $itemsObj[$i]->datesub();
			$newItems['poster']       = $itemsObj[$i]->linkedPosterName();
			$newItems['itemlink']     = $itemsObj[$i]->getItemLink(false, isset($options[3]) ? $options[3] : 65);
			$newItems['categorylink'] = $itemsObj[$i]->getCategoryLink();

			$block['items'][] = $newItems;
		}

		$block['lang_title']     = _MB_PUBLISHER_ITEMS;
		$block['lang_category']  = _MB_PUBLISHER_CATEGORY;
		$block['lang_poster']    = _MB_PUBLISHER_POSTEDBY;
		$block['lang_date']      = _MB_PUBLISHER_DATE;
		$modulename              = $myts->displayTarea($publisher->getModule()->getVar('name'));
		$block['lang_visitItem'] = _MB_PUBLISHER_VISITITEM . " " . $modulename;
	}

	return $block;
}

function publisher_items_recent_edit($options) {

    $form  = "<table border='0'>";
	$form .= '<tr><td style="vertical-align: top; width: 250px;">' . _MB_PUBLISHER_SELECTCAT . '</td>';
	$form .= '<td>'. publisher_createCategorySelect($options[0]) . '</td></tr>';
		
    $form .= "<tr><td>" . _MB_PUBLISHER_ORDER . "</td>";
    $form .= "<td><select name='options[1]'>";

    $form .= "<option value='datesub'";
    if ($options[1] == "datesub") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_PUBLISHER_DATE . "</option>";

    $form .= "<option value='counter'";
    if ($options[1] == "counter") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_PUBLISHER_HITS . "</option>";

    $form .= "<option value='weight'";
    if ($options[1] == "weight") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_PUBLISHER_WEIGHT . "</option>";

    $form .= "</select></td></tr>";

    $form .= "<tr><td>" . _MB_PUBLISHER_DISP . "</td><td><input type='text' name='options[2]' value='" . $options[2] . "' />&nbsp;" . _MB_PUBLISHER_ITEMS . "</td></tr>";
    $form .= "<tr><td>" . _MB_PUBLISHER_CHARS . "</td><td><input type='text' name='options[3]' value='" . $options[3] . "' />&nbsp;chars</td></tr>";

    $form .= "</table>";
    return $form;
}

?>
