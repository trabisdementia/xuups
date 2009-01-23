<?php

/**
* $Id: items_tree.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/
if (!defined("XOOPS_ROOT_PATH")) {
die("XOOPS root path not defined");
}

function publisher_items_tree_show($options)
{
	/*
	options(
		[0] => category (-1: current; 0: all)
		[1] => sort
		[2] => order
		[3] => maxlevel (-1: all)
		[4] => show items
	);
	 */
		
	include_once(XOOPS_ROOT_PATH."/modules/publisher/include/common.php");	
	$block = array();
	
	switch ($options[0])
	{
		case -1:
			global $xoopsModule;
			$smartModule =& publisher_getModuleInfo();
			
			echo $xoopsModule->dirname() . "<br>";
			echo $smartModule->dirname();
			
			if($xoopsModule->dirname() == $smartModule->dirname())
			{
				if(isset($_GET['categoryid']))
				{
					$cat2show = $_GET['categoryid']; 
				}else{
					if(isset($_GET['itemid']))
					{
						$itemObj = new PublisherItem($_GET['itemid']);
						$cat2show = $itemObj->categoryid();
					}else{
						$cat2show = 0;
					}//itemid
				}//categoryid
			}//dirname	
			break;
		case 0:
			$cat2show = 0;
			break;
		default:
			$cat2show = $options[0];		
			break;
	}
	
	$sort = $options[1];
	//$order = publisher_getOrderBy($sort);
	$order = $options[2];
	$maxlevel = $options[3];
	$showItems = $options[4];

	$arrayTree = publisher_tree($cat2show, 0, $sort, $order, $maxlevel, $showItems);

	$block["arrayTree"] = $arrayTree;
	return $block;	
} 

function publisher_tree(
	$categoryid, 
	$level = 0, 
	$sort = "weight", 
	$order = "ASC", 
	$maxlevel = -1, 
	$showItems = true, 
	$itemsLoad = false, 
	$items = array(),
	$catsLoad = false, 
	$cats = array()
	)
{
/*
echo "publisher_tree(
	categoryid = $categoryid, 
	level =$level, 
	sort = $sort, 
	order= $order, 
	maxlevel = $maxlevel, 
	showItems = $showItems, 
	itemsLoad = $itemsLoad, 
	items = $items,
	catsLoad = $catsLoad, 
	cats = $cats
	)<hr>";
*/
	$tree = array();

	if($categoryid < 0)
		$categoryid = 0;
	
	if($showItems and !$itemsLoad)
	{
		$publisher_item_handler =& publisher_gethandler('item');
		//$items = $publisher_item_handler-> getAllPublished(0, 0, -1, $sort, $order, '', true, 'categoryid');
		$items = $publisher_item_handler-> getAllPublished(0, 0, $categoryid, $sort, $order, '', true, 'categoryid');
		$itemsLoad = true;
	}//if($showItems and !$itemsLoad)

	if(!$catsLoad)
	{
		$publisher_category_handler =& publisher_gethandler('category');
		$categoriesObj = $publisher_category_handler->getCategories(0, 0, $categoryid, $sort, $order);
		//$categoriesObj = $publisher_category_handler->getCategories(0, 0, -1, $sort, $order);
		
		$cats = array();
		foreach($categoriesObj as $cat)
		{
			$catArray = $cat->toArray();
			$catArray["categoryUrl"] = $cat->getCategoryUrl();
			$catArray["categoryLink"] = $cat->getCategoryLink();
			$catArray["parentid"] = $cat->parentid();
			
			$cats[$cat->parentid()][$cat->categoryid()] = $catArray;
			
		}//foreach $categoryObj
		unset($cat);
		$catsLoad = true;
	}//catsload

	if( (!empty($cats)) and (array_key_exists($categoryid, $cats)))
	{
		//for all childs of $categoryid
		foreach($cats[$categoryid] as $catid=>$cat)
		{
			$tree[$catid] = $cat;
			if( ($level < $maxlevel) or ($maxlevel == -1) )
			{
				$tree[$catid]["subcats"] = publisher_tree($catid, $level + 1, $sort, $order, $maxlevel, $showItems, $itemsLoad, $items, $catsLoad, $cats);

				if($showItems == 1)
				{
					if(array_key_exists($catid, $items))
					{
						foreach($items[$catid] as $item)
						{
							$tree[$catid]["items"][$item->itemid()]["itemLink"] = $item->getItemLink();
						}//foreach catItems
					}//key exists
				}//showItems
			}//level
		}//foreach $cats			
	}//key exists

	if( (!empty($items[$categoryid])) and (array_key_exists($categoryid, $items)) )
	{
		foreach($items[$categoryid] as $item)
		{
			$tree["items"][$item->itemid()]["itemLink"] = $item->getItemLink();
		}//foreach catItems
	}//array_key_exists($categoryid, $items)
	return $tree;
}//publisher_tree

function publisher_items_tree_edit($options)
{
    global $xoopsDB, $xoopsModule, $xoopsUser;
	include_once(XOOPS_ROOT_PATH."/modules/publisher/include/functions.php");
	include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';

	$form = "" . _MB_PUB_SELECTCAT . "&nbsp;\n<select name='options[]'>\n";
	$sel = "";
	if ($options[0] == -1) {
        $sel = " selected='selected'";
    } 
	$form .= "<option value='-1'$sel>" . _MB_PUB_CURRENTCATEGORY . "</option>\n";
	if ($options[0] == 0) {
        $sel = " selected='selected'";
    } 
	$form .= "<option value='0'$sel>" . _MB_PUB_ALLCAT . "</option>\n";	
	
	// Creating the category handler object
	$category_handler =& publisher_gethandler('category');
	
	// Creating category objects
	$categoriesObj = $category_handler->getCategories(0, 0, 0);
	
	if (count($categoriesObj) > 0) {
		foreach ( $categoriesObj as $catID => $categoryObj) {
			$form .= publisher_addCategoryOption($categoryObj, $options[0]);
		}
	} 
	$form .= "</select>\n";

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

	$form .= 
		"&nbsp;" . 
		"<select name='options[]'>" .
			"<option value='ASC'";
				if ($options[2] == "ASC") {
        			$form .= " selected='selected'";
    			}
	$form .= ">". _MB_PUB_ASC ."</option>" .
			"<option value='DESC'";
				if ($options[2] == "DESC") {
			        $form .= " selected='selected'";
			    }
	$form .= ">". _MB_PUB_DESC ."</option>" .
		"</select>";

	$form .= "<br />" . _MB_PUB_LEVELS . 
		"<input name='options[]' value='". $options[3] ."' size='3' maxlenght='3'/>";

	$showItemsRadio = new XoopsFormRadioYN(_MB_PUB_SHOWITEMS, 'options[]', $options[4]);
	$form .= "<br />" . _MB_PUB_SHOWITEMS . "&nbsp;" . $showItemsRadio->render();
	
    return $form;
}//edit
?>
