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
 * @version         $Id: date_to_date.php 0 2009-06-11 18:47:04Z trabis $
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once dirname(dirname(__FILE__)) . '/include/common.php';

function publisher_date_to_date_show($options)
{
	$myts =& MyTextSanitizer::getInstance();
	$publisher =& PublisherPublisher::getInstance();

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

	// creating the ITEM objects that belong to the selected category
	$itemsObj = $publisher->getHandler('item')->getObjects($criteria);
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

		$block['lang_title'] = _MB_PUBLISHER_ITEMS;
		$block['lang_category'] = _MB_PUBLISHER_CATEGORY;
		$block['lang_poster'] = _MB_PUBLISHER_POSTEDBY;
		$block['lang_date'] = _MB_PUBLISHER_DATE;
		$modulename = $myts->displayTarea($publisher_handler->getVar('name'));
		$block['lang_visitItem'] = _MB_PUBLISHER_VISITITEM . " " . $modulename;
		$block['lang_articles_from_to'] = sprintf(_MB_PUBLISHER_ARTICLES_FROM_TO, $options[0], $options[1]);
	}

	return $block;
}

function publisher_date_to_date_edit($options)
{

	$form =  _MB_PUBLISHER_FROM . "<input type='text' name='options[]' value='" . $options[0] . "' />&nbsp;<br />";
    $form .= _MB_PUBLISHER_UNTIL . "&nbsp;<input type='text' name='options[]' value='" . $options[1] . "' /><br/>"._MB_PUBLISHER_DATE_FORMAT;

    return $form;
}

?>
