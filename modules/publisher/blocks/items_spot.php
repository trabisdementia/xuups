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
 * @version         $Id: items_spot.php 0 2009-06-11 18:47:04Z trabis $
 */

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once dirname(dirname(__FILE__)) . '/include/common.php';

function publisher_items_spot_show($options)
{
    $publisher =& PublisherPublisher::getInstance();

    $opt_display_last = $options[0];
    $opt_items_count = $options[1];
    $opt_categoryid = $options[2];
    $sel_items = isset($options[3]) ? explode(',', $options[3]) : '';
    $opt_display_poster = $options[4];
    $opt_display_comment = $options[5];
    $opt_display_type = $options[6];
    $opt_truncate = intval($options[7]);
    $opt_catimage = $options[8];

    if ($opt_categoryid == 0) {
        $opt_categoryid = -1;
    }

    $block = array();
    if ($opt_display_last == 1) {
        $itemsObj = $publisher->getHandler('item')->getAllPublished($opt_items_count, 0, $opt_categoryid, $sort='datesub', $order='DESC', 'summary');
        $i = 1;
        $itemsCount = count($itemsObj);

        if ($itemsObj) {
            if($opt_categoryid != -1 && $opt_catimage){
                $cat = $publisher->getHandler('category')->get($opt_categoryid);
                $category['name']             = $cat->name();
                $category['categoryurl']      = $cat->getCategoryUrl();
                if ($cat->image() != 'blank.png') {
                    $category['image_path'] = publisher_getImageDir('category', false) . $cat->image();
                } else {
                    $category['image_path'] = '';
                }
                $block['category'] = $category;
            }
            foreach ($itemsObj as $key => $thisitem) {
                $item = array();

                $item = $thisitem->toArray('default', 0, $opt_truncate);

                if ($i < $itemsCount) {
                    $item['showline'] = true;
                } else {
                    $item['showline'] = false;
                }
                if ($opt_truncate > 0) {
                    $block['truncate'] = true;
                }
                $block['items'][] = $item;
                $i++;
            }
        }
    } else {
        $i = 1;
        $itemsCount = count($sel_items);
        foreach ($sel_items as $item_id) {
            $itemObj = $publisher->getHandler('item')->get($item_id);
            if (!$itemObj->notLoaded() && $itemObj->checkPermission()) {
                $categoryObj = $itemObj->category();
                $item = array();
                $item = $itemObj->toArray();
                $item['who_when'] = sprintf(_MB_PUBLISHER_WHO_WHEN, $itemObj->posterName(), $itemObj->datesub());
                if ($i < $itemsCount) {
                    $item['showline'] = true;
                } else {
                    $item['showline'] = false;
                }
                if ($opt_truncate > 0) {
                    $block['truncate'] = true;
                    $item['summary'] = publisher_truncateTagSafe($item['summary'], $opt_truncate);
                }
                $block['items'][] = $item;
                $i++;
            }
        }
    }

    if (!isset($block['items']) || count($block['items']) == 0) {
        return false;
    }

    $block['lang_reads'] = _MB_PUBLISHER_READS;
    $block['lang_comments'] = _MB_PUBLISHER_COMMENTS;
    $block['lang_readmore'] = _MB_PUBLISHER_READMORE;
    $block['display_whowhen_link'] = $opt_display_poster;
    $block['display_comment_link'] = $opt_display_comment;
    $block['display_type'] = $opt_display_type;

    return $block;
}

function publisher_items_spot_edit($options)
{
    $publisher =& PublisherPublisher::getInstance();

    $form  = "<table border='0'>";

    // Auto select last items
    $form .= "<tr><td>" . _MB_PUBLISHER_AUTO_LAST_ITEMS . "</td><td>";
    $chk   = "";
    if ($options[0] == 0) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[0]' value='0'" . $chk . " />" . _NO . "";
    $chk   = "";

    if ($options[0] == 1) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[0]' value='1'" . $chk . " />"._YES."</td></tr>";

    // Number of last items...
    $form .= "<tr><td>" . _MB_PUBLISHER_LAST_ITEMS_COUNT . "</td><td>";
    $form .= "<input type='text' name='options[1]' size='2' value='" . $options[1] . "' /></td></tr>";

    // Select 1 category
    $form .= "<tr><td>" . _MB_PUBLISHER_SELECTCAT . "</td><td>";
    $form .= "<select name='options[2]'> " . publisher_createCategoryOptions($options[2]) . " /></td></tr>";

    // Items Select box
    // Creating the item handler object
    $criteria = new CriteriaCompo();
    $criteria->setSort('datesub');
    $criteria->setOrder('DESC');
    $itemsObj = $publisher->getHandler('item')->getList($criteria);
    unset($criteria);

    if (empty($options[3]) || ($options[3] == 0)) {
        $sel_items = '0';
    } else {
        $sel_items = explode(',', $options[3]);
    }

    $form .= "<tr><td style='vertical-align: top;'>" . _MB_PUBLISHER_SELECT_ITEMS . "</td><td>";
    $form .= "<select size='10' name='options[3][]' multiple='multiple'>";

    if ($itemsObj) {
        foreach($itemsObj as $id => $title) {
            $sel = "";
            if ($sel_items == '0') {
                $sel = " selected='selected' ";
                $sel_items = '';
            } else {
                if ( !empty($sel_items) && ( in_array($id, $sel_items) )) {
                    $sel = " selected='selected' ";
                }
            }
            $form .= "<option value='" . $id . "' ".$sel.">". $title ."</option>";
        }
    }

    $form .= "</select></td></tr>";

    // Display Who and When
    $form .= "<tr><td>" . _MB_PUBLISHER_DISPLAY_WHO_AND_WHEN . "</td><td>";
    $chk   = "";
    if ($options[4] == 0) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[4]' value='0'" . $chk . " />" . _NO . "";
    $chk   = "";
    if ($options[4] == 1) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[4]' value='1'" . $chk . " />" . _YES . "</td></tr>";

    // Display Comment(s)
    $form .= "<tr><td>" . _MB_PUBLISHER_DISPLAY_COMMENTS . "</td><td>";
    $chk   = "";
    if ($options[5] == 0) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[5]' value='0'" . $chk . " />" . _NO . "";
    $chk   = "";
    if ($options[5] == 1) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[5]' value='1'" . $chk . " />" . _YES . "</td></tr>";


    // Display type : block or bullets
    $form .= "<tr><td style='vertical-align: top;'>" . _MB_PUBLISHER_DISPLAY_TYPE . "</td><td>";
    $form .= "<select size='1' name='options[6]'>";

    $sel = "";
    if ($options[6] == 'block') {
        $sel = " selected='selected' ";
    }
    $form .= "<option value='block' " . $sel . ">" . _MB_PUBLISHER_DISPLAY_TYPE_BLOCK . "</option>";

    $sel = "";
    if ($options[6] == 'bullet') {
        $sel = " selected='selected' ";
    }
    $form .= "<option value='bullet' " . $sel . ">" . _MB_PUBLISHER_DISPLAY_TYPE_BULLET . "</option>";

    $form .= "</select></td></tr>";

    // Truncate
    $form .= "<tr><td style='vertical-align: top;'>" . _MB_PUBLISHER_TRUNCATE . "</td><td>";
    $form .= "<input type='text' name='options[7]' value='" . $options[7] . "' size='4'></td></tr>";

    // Display Category image
    $form .= "<tr><td>" . _MB_PUBLISHER_DISPLAY_CATIMAGE . "</td><td>";
    $chk   = "";
    if ($options[8] == 0) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[8]' value='0'" . $chk . " />" . _NO . "";
    $chk   = "";
    if ($options[8] == 1) {
        $chk = " checked='checked'";
    }
    $form .= "<input type='radio' name='options[8]' value='1'" . $chk . " />" . _YES . "</td></tr>";

    $form .= "</table>";
    return $form;
}
?>
