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
 * @version         $Id: items_new.php 0 2009-06-11 18:47:04Z trabis $
 */

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once dirname(dirname(__FILE__)) . '/include/common.php';

function publisher_items_new_show($options)
{
    $publisher =& PublisherPublisher::getInstance();

    $selectedcatids = explode(',', $options[0]);

    $block = array();
    if (in_array(0, $selectedcatids)) {
        $allcats = true;
    } else {
        $allcats = false;
    }

    $sort = $options[1];
    $order = publisher_getOrderBy($sort);
    $limit = $options[3];
    $start = 0;
    $image = $options[5];

    // creating the ITEM objects that belong to the selected category
    if ($allcats) {
        $criteria = null;
    } else {
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('categoryid', '(' . $options[0] . ')', 'IN'));
    }
    $itemsObj = $publisher->getHandler('item')->getItems($limit, $start, array(_PUBLISHER_STATUS_PUBLISHED), -1, $sort, $order, '', true, $criteria, true);

    $totalitems = count($itemsObj);
    if ($itemsObj) {
        for ($i = 0; $i < $totalitems; $i++) {

            $item = array();
            $item['link'] = $itemsObj[$i]->getItemLink(false, isset($options[4]) ? $options[4] : 65);
            $item['id'] = $itemsObj[$i]->itemid();
            $item['poster'] = $itemsObj[$i]->posterName(); // for make poster name linked, use linkedPosterName() instead of posterName()

            if ($image == 'article') {
                $item['image'] = XOOPS_URL . '/uploads/blank.gif';
                $item['image_name'] = '';
                $images = $itemsObj[$i]->getImages();
                if (is_object($images['main'])) {
		// check to see if GD function exist
		if (!function_exists ('imagecreatetruecolor')) {
                $item['image'] = XOOPS_URL . '/uploads/' . $images['main']->getVar('image_name');
		} else {
                $item['image'] = PUBLISHER_URL . '/thumb.php?src=' . XOOPS_URL . '/uploads/' . $images['main']->getVar('image_name') . '&amp;w=50';
                }  
                $item['image_name'] = $images['main']->getVar('image_nicename');
                }
            } elseif ($image == 'category') {
                $item['image'] = $itemsObj[$i]->getCategoryImagePath();
                $item['image_name'] = $itemsObj[$i]->getCategoryName();
            } elseif ($image == 'avatar') {
                if ($itemsObj[$i]->uid() == '0') {
                    $item['image'] = XOOPS_URL . '/uploads/blank.gif';
                    $images = $itemsObj[$i]->getImages();
                    if (is_object($images['main'])) {
		    // check to see if GD function exist
		    if (!function_exists ('imagecreatetruecolor')) {
                    $item['image'] = XOOPS_URL . '/uploads/' . $images['main']->getVar('image_name');
		    } else {
		    $item['image'] = PUBLISHER_URL . '/thumb.php?src=' . XOOPS_URL . '/uploads/' . $images['main']->getVar('image_name') . '&amp;w=50';
		    }
                    }
                } else {
		    // check to see if GD function exist
		    if (!function_exists ('imagecreatetruecolor')) {
                    $item['image'] = XOOPS_URL . '/uploads/' . $itemsObj[$i]->posterAvatar();
		    } else {
		    $item['image'] = PUBLISHER_URL . '/thumb.php?src=' . XOOPS_URL . '/uploads/' . $itemsObj[$i]->posterAvatar() . '&amp;w=50';
		    }
                }
                $item['image_name'] = $itemsObj[$i]->posterName();
            }

            $item['title'] = $itemsObj[$i]->title();

            if ($sort == "datesub") {
                $item['new'] = $itemsObj[$i]->datesub();
            } elseif ($sort == "counter") {
                $item['new'] = $itemsObj[$i]->counter();
            } elseif ($sort == "weight") {
                $item['new'] = $itemsObj[$i]->weight();
            }

            $block['newitems'][] = $item;
        }
    }

    $block['show_order'] = $options[2];

    return $block;
}

function publisher_items_new_edit($options)
{
    $form = "<table border='0'>";
    $form .= '<tr><td style="vertical-align: top; width: 250px;">' . _MB_PUBLISHER_SELECTCAT . '</td>';
    $form .= '<td>' . publisher_createCategorySelect($options[0]) . '</td></tr>';

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

    $form .= "</select></td>";


    $form .= "<tr><td>" . _MB_PUBLISHER_ORDER_SHOW . "</td><td>";
    $chk = "";
    if ($options[2] == 0) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[2]' value='0'" . $chk . " />" . _NO . "";
    $chk = "";

    if ($options[2] == 1) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[2]' value='1'" . $chk . " />" . _YES . "</td></tr>";


    $form .= "<tr><td>" . _MB_PUBLISHER_DISP . "</td><td><input type='text' name='options[3]' value='" . $options[3] . "' />&nbsp;" . _MB_PUBLISHER_ITEMS . "</td></tr>";
    $form .= "<tr><td>" . _MB_PUBLISHER_CHARS . "</td><td><input type='text' name='options[4]' value='" . $options[4] . "' />&nbsp;chars</td></tr>";

    $form .= "<tr><td>" . _MB_PUBLISHER_IMAGE_TO_DISPLAY . "</td>";
    $form .= "<td><select name='options[5]'>";

    $form .= "<option value='none'";
    if ($options[5] == "none") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _NONE . "</option>";

    $form .= "<option value='article'";
    if ($options[5] == "article") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_PUBLISHER_IMAGE_ARTICLE . "</option>";

    $form .= "<option value='category'";
    if ($options[5] == "category") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_PUBLISHER_IMAGE_CATEGORY . "</option>";

    $form .= "<option value='avatar'";
    if ($options[5] == "avatar") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_PUBLISHER_IMAGE_AVATAR . "</option>";

    $form .= "</select></td></tr>";
    $form .= "</table>";
    return $form;
}

?>
