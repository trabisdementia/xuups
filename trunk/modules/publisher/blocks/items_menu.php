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
 * @version         $Id: items_menu.php 0 2009-06-11 18:47:04Z trabis $
 */

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once dirname(dirname(__FILE__)) . '/include/common.php';

function publisher_items_menu_show($options)
{
    global $xoopsModule;
    $block = array();

    $publisher =& PublisherPublisher::getInstance();

    // Getting all top cats
    $block_categoriesObj = $publisher->getHandler('category')->getCategories(0, 0, 0);

    if (count($block_categoriesObj) == 0) return $block;

    // Are we in Publisher ?
    $block['inModule'] = (isset($xoopsModule) && $xoopsModule->getVar('dirname') == $publisher->getModule()->getVar('dirname'));

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

    $array_categoryids = array_keys($block_categoriesObj);
    $categoryids = implode(', ', $array_categoryids);

    foreach ($block_categoriesObj as $catid => $block_categoryObj) {
        if ($catid != $categoryid) {
            $block['categories'][$catid]['categoryLink'] = $block_categoryObj->getCategoryLink($catlink_class);
        }
    }

    return $block;
}

function publisher_items_menu_edit($options)
{
    $form = publisher_createCategorySelect($options[0]);

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

    $form .= "&nbsp;" . _MB_PUBLISHER_DISP . "&nbsp;<input type='text' name='options[]' value='" . $options[2] . "' />&nbsp;" . _MB_PUBLISHER_ITEMS . "";

    return $form;
}

?>