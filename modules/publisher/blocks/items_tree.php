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
 * @version         $Id: items_tree.php 0 2009-06-11 18:47:04Z trabis $
 */

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once dirname(dirname(__FILE__)) . '/include/common.php';

function publisher_items_tree_show($options)
{
    $publisher =& PublisherPublisher::getInstance();
    /*
     options(
     [0] => category (-1: current; 0: all)
     [1] => sort
     [2] => order
     [3] => maxlevel (-1: all)
     [4] => show items
     );
     */

    $block = array();

    switch ($options[0])
    {
        case -1:
            global $xoopsModule;
            	
            	
            if($xoopsModule->dirname() == $publisher->getModule()->getVar('dirname'))
            {
                if(isset($_GET['categoryid']))
                {
                    $cat2show = $_GET['categoryid'];
                }else{
                    if(isset($_GET['itemid']))
                    {
                        $itemObj = $publisher->getHandler('item')->get($_GET['itemid']);
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

function publisher_tree($categoryid, $level = 0, $sort = "weight", $order = "ASC", $maxlevel = -1,
$showItems = true, $itemsLoad = false, $items = array(), $catsLoad = false, $cats = array())
{

    $publisher =& PublisherPublisher::getInstance();
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
        //$items = $publisher_item_handler-> getAllPublished(0, 0, -1, $sort, $order, '', true, 'categoryid');
        $items = $publisher->getHandler('item')->getAllPublished(0, 0, $categoryid, $sort, $order, '', true, 'categoryid');
        $itemsLoad = true;
    }//if($showItems and !$itemsLoad)

    if(!$catsLoad)
    {
        $categoriesObj = $publisher->getHandler('category')->getCategories(0, 0, $categoryid, $sort, $order);
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
    $publisher =& PublisherPublisher::getInstance();
    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

    $form = "" . _MB_PUBLISHER_SELECTCAT . "&nbsp;\n<select name='options[]'>\n";
    $sel = "";
    if ($options[0] == -1) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='-1'$sel>" . _MB_PUBLISHER_CURRENTCATEGORY . "</option>\n";
    if ($options[0] == 0) {
        $sel = " selected='selected'";
    }
    $form .= "<option value='0'$sel>" . _MB_PUBLISHER_ALLCAT . "</option>\n";

    // Creating category objects
    $categoriesObj = $publisher->getHandler('category')->getCategories(0, 0, 0);

    if (count($categoriesObj) > 0) {
        foreach ( $categoriesObj as $catID => $categoryObj) {
            $form .= publisher_addCategoryOption($categoryObj, $options[0]);
        }
    }
    $form .= "</select>\n";

    $form .= "&nbsp;<br>" . _MB_PUBLISHER_ORDER . "&nbsp;<select name='options[]'>";

    $form .= "<option value='datesub'";
    if ($options[1] == "datesub") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_PUBLISHER_DATE . "</option>\n";

    $form .= "<option value='counter'";
    if ($options[1] == "counter") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_PUBLISHER_HITS . "</option>\n";

    $form .= "<option value='weight'";
    if ($options[1] == "weight") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_PUBLISHER_WEIGHT . "</option>\n";

    $form .= "</select>\n";

    $form .=
		"&nbsp;" . 
		"<select name='options[]'>" .
			"<option value='ASC'";
    if ($options[2] == "ASC") {
        $form .= " selected='selected'";
    }
    $form .= ">". _MB_PUBLISHER_ASC ."</option>" .
			"<option value='DESC'";
    if ($options[2] == "DESC") {
        $form .= " selected='selected'";
    }
    $form .= ">". _MB_PUBLISHER_DESC ."</option>" .
		"</select>";

    $form .= "<br />" . _MB_PUBLISHER_LEVELS .
		"<input name='options[]' value='". $options[3] ."' size='3' maxlenght='3'/>";

    $showItemsRadio = new XoopsFormRadioYN(_MB_PUBLISHER_SHOWITEMS, 'options[]', $options[4]);
    $form .= "<br />" . _MB_PUBLISHER_SHOWITEMS . "&nbsp;" . $showItemsRadio->render();

    return $form;
}//edit
?>
