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
 * @version         $Id: category_items_sel.php 0 2009-06-11 18:47:04Z trabis $
 */

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once dirname(dirname(__FILE__)) . '/include/common.php';

function publisher_category_items_sel_show($options)
{
    $publisher =& PublisherPublisher::getInstance();
    $myts =& MyTextSanitizer::getInstance();

    $block = array();

    $categories = $publisher->getHandler('category')->getCategories(0, 0, -1);

    if (count($categories) == 0) return $block;

    $selectedcatids = explode(',', $options[0]);
    $sort = $options[1];
    $order = publisher_getOrderBy($sort);
    $limit = $options[2];
    $start = 0;

    // creating the ITEM objects that belong to the selected category
    $block['categories'] = array();
    foreach ($categories as $catID => $catObj) {
        if (!in_array(0, $selectedcatids) && !in_array($catID, $selectedcatids)) continue;

        $criteria = new Criteria('categoryid', $catID);
        $items = $publisher->getHandler('item')->getItems($limit, $start, array(_PUBLISHER_STATUS_PUBLISHED), -1, $sort, $order, '', true, $criteria, true);
        unset($criteria);

        if (count($items) == 0) continue;

        $item['title']                          = $catObj->name();
        $item['itemurl']                        = 'none';
        $block['categories'][$catID]['items'][] = $item;

        foreach ($items as $itemObj) {
            $item['title']                          = $itemObj->title(isset($options[3]) ? $options[3] : 0);
            $item['itemurl']                        = $itemObj->getItemUrl();
            $block['categories'][$catID]['items'][] = $item;
        }
        $block['categories'][$catID]['name'] = $catObj->name();
    }

    unset($items, $categories);

    if (count($block['categories']) == 0) return $block;
    return $block;
}

function publisher_category_items_sel_edit($options) {

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
