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
 * @author          Bandit-x
 * @version         $Id: items_columns.php 77 2009-07-17 17:38:28Z trabis $
 */

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once dirname(dirname(__FILE__)) . '/include/common.php';

/***
 * Function To Show Publisher Items From Categories In Their Own Columns
 * @param    array $options Block Options
 */
function publisher_items_columns_show($options)
{
    global $xoTheme;

    $publisher =& PublisherPublisher::getInstance();
    $myts =& MyTextSanitizer::getInstance();

    //Column Settings
    $opt_num_columns = isset($options[0]) ? intval($options[0]) : '2';
    $sel_categories = isset($options[1]) ? explode(',', $options[1]) : array();
    $opt_cat_items = intval($options[2]);
    $opt_cat_truncate = isset($options[3]) ? intval($options[3]) : '0';

    $block = array();
    $block['lang_reads'] = _MB_PUBLISHER_READS;
    $block['lang_comments'] = _MB_PUBLISHER_COMMENTS;
    $block['lang_readmore'] = _MB_PUBLISHER_READMORE;

    $sel_categories_obj = array();

    //get permited categories only once
    $categories_obj = $publisher->getHandler('category')->getCategories(0, 0, -1);

    //if not selected 'all', let's get the selected ones
    if (!in_array(0, $sel_categories)) {
        foreach ($categories_obj as $key => $value) {
            if (in_array($key, $sel_categories)) {
                $sel_categories_obj[$key] = $value;
            }
        }
    } else {
        $sel_categories_obj = $categories_obj;
    }

    $ccount = count($sel_categories_obj);

    if ($ccount == 0) {
        return false;
    }

    if ($ccount < $opt_num_columns) {
        $opt_num_columns = $ccount;
    }

    $k = 0;
    $columns = array();

    foreach ($sel_categories_obj as $categoryId => $mainitemCatObj) {
        $categoryItemsObj = $publisher->getHandler('item')->getAllPublished($opt_cat_items, 0, $categoryId);
        $scount = count($categoryItemsObj);
        if ($scount > 0 && is_array($categoryItemsObj)) {
            reset($categoryItemsObj);
            //First Item
            list($itemid, $thisitem) = each($categoryItemsObj);

            $mainitem['item_title'] = $thisitem->title();
            $mainitem['item_cleantitle'] = strip_tags($thisitem->title());
            $mainitem['item_link'] = $thisitem->itemid();
            $mainitem['itemurl'] = $thisitem->getItemUrl();
            $mainImage = $thisitem->getMainImage();
	    // check to see if GD function exist
	    if (!function_exists ('imagecreatetruecolor')) {
	    $mainitem['item_image'] = $mainImage['image_path']; 
	    } else {
	    $mainitem['item_image'] = PUBLISHER_URL . '/thumb.php?src=' . $mainImage['image_path'] . '&amp;w=100';
	    }
            $mainitem['item_summary'] = $thisitem->getBlockSummary($opt_cat_truncate);

            $mainitem['item_cat_name'] = $mainitemCatObj->name();
            $mainitem['item_cat_description'] = $mainitemCatObj->description() != '' ? $mainitemCatObj->description() : $mainitemCatObj->name();
            $mainitem['item_cat_link'] = $mainitemCatObj->getCategoryLink();
            $mainitem['categoryurl'] = $mainitemCatObj->getCategoryUrl();

            //The Rest
            if ($scount > 1) {
                while (list($itemid, $thisitem) = each($categoryItemsObj)) {
                    $subitem['title'] = $thisitem->title();
                    $subitem['cleantitle'] = strip_tags($thisitem->title());
                    $subitem['link'] = $thisitem->getItemLink();
                    $subitem['itemurl'] = $thisitem->getItemUrl();
                    $subitem['summary'] = $thisitem->getBlockSummary($opt_cat_truncate);
                    $mainitem['subitem'][] = $subitem;
                    unset($subitem);
                }
            }
            $columns[$k][] = $mainitem;
            unset($thisitem);
            unset($mainitem);
            $k++;

            if ($k == $opt_num_columns) {
                $k = 0;
            }
        }
    }
    $block['template'] = $options[4];
    $block['columns'] = $columns;
    $block['columnwidth'] = intval(100 / $opt_num_columns);

    $xoTheme->addStylesheet(XOOPS_URL . '/modules/' . PUBLISHER_DIRNAME . '/css/publisher.css');

    return $block;
}

/***
 * Edit Function For Multi-Column Category Items Display Block
 * @param    array $options Block Options
 *
 */
function publisher_items_columns_edit($options)
{
    global $xoopsDB;

    $form = "<table border='0'>";
    $form .= "<tr><td style='vertical-align: top; width: 250px;'>" . _MB_PUBLISHER_NUMBER_COLUMN_VIEW . "</td>";
    $form .= "<td><select size='1' name='options[0]'>";

    for ($i = 1; $i < 5; $i++) {
        $form .= "<option value='{$i}'";
        if ($options[0] == $i || ($options[0] == '' && $i == 0)) {
            $form .= " selected='selected'";
        }
        //$label = ($i == 0) ? _NONE : $i;
        $form .= ">{$i}</option>";
    }

    $form .= "</select></td></tr>";

    //Select Which Categories To Show
    $form .= "<tr><td style='vertical-align: top;'>" . _MB_PUBLISHER_SELECTCAT . "</td><td>";
    $form .= publisher_createCategorySelect($options[1], 0, true, 'options[1]');
    $form .= "</td></tr>";

    //number of items in category
    $form .= "<tr><td style='vertical-align: top;'>" . _MB_PUBLISHER_NUMBER_ITEMS_CAT . "</td><td>";
    $form .= "<input type='text' name='options[2]' value='" . $options[2] . "' size='4'></td></tr>";

    //teaser length
    $form .= "<tr><td style='vertical-align: top;'>" . _MB_PUBLISHER_TRUNCATE . "</td><td>";
    $form .= "<input type='text' name='options[3]' value='" . $options[3] . "' size='4'></td></tr>";


    //template
    $form .= "<tr><td style='vertical-align: top;'>" . _MB_PUBLISHER_TEMPLATE . "</td>";
    $form .= "<td><select size='1' name='options[4]'>";

    $templates = array('normal' => _MB_PUBLISHER_TEMPLATE_NORMAL, 'extended' => _MB_PUBLISHER_TEMPLATE_EXTENDED);
    foreach ($templates as $key => $value) {
        $form .= "<option value='{$key}'";
        if ($options[4] == $key) {
            $form .= " selected='selected'";
        }
        $form .= ">{$value}</option>";
    }

    $form .= "</select></td></tr>";

    $form .= "</table>";
    return $form;
}

?>
