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
 * @subpackage      Include
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: search.inc.php 0 2009-06-11 18:47:04Z trabis $
 */

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once dirname(dirname(__FILE__)) . '/include/common.php';

function publisher_search($queryarray, $andor, $limit, $offset, $userid, $categories = array(), $sortby = 0, $searchin = "", $extra = "")
{
    global $myts;
    $publisher =& PublisherPublisher::getInstance();

    $ret = array();

    if ($queryarray == '' || count($queryarray) == 0) {
        $keywords = '';
        $hightlight_key = '';
    } else {
        $keywords = implode('+', $queryarray);
        $hightlight_key = "&amp;keywords=" . $keywords;
    }

    $itemsObjs = $publisher->getHandler('item')->getItemsFromSearch($queryarray, $andor, $limit, $offset, $userid, $categories, $sortby, $searchin, $extra);

    $withCategoryPath = $publisher->getConfig('search_cat_path');
    //xoops_load("xoopslocal");
    $usersIds = array();
    foreach ($itemsObjs as $obj) {
        $item['image'] = "images/item_icon.gif";
        $item['link'] = $obj->getItemUrl();
        $item['link'] .= (!empty($hightlight_key) && (strpos($item['link'], '.php?') === false)) ? "?" . ltrim($hightlight_key, '&amp;') : $hightlight_key;
        if ($withCategoryPath) {
            $item['title'] = $obj->getCategoryPath(false) . " > " . $obj->title();
        } else {
            $item['title'] = $obj->title();
        }
        $item['time'] = $obj->getVar('datesub'); //must go has unix timestamp
        $item['uid'] = $obj->uid();

        /*
         * "Fulltext search"/highlight needs better formulize
         *
         */
        $text = $obj->body();
        $sanitized_text = "";
        $text_i = strtolower($text);
        $queryarray = is_array($queryarray) ? $queryarray : array($queryarray);
        foreach ($queryarray as $query) {
            if ($query != '') {
                $pos = strpos($text_i, strtolower($query)); //xoops_local("strpos", $text_i, strtolower($query));
                $start = max(($pos - 100), 0);
                $length = strlen($query) + 200; //xoops_local("strlen", $query) + 200;
                $context = preg_replace_callback("/(" . preg_quote($query) . ")/si", array($obj, 'highlighter'), xoops_substr($text, $start, $length, " [...]"));
                $sanitized_text .= "<p>[...] " . $context . "</p>";
            }
        }
        $item['text'] = $sanitized_text;
        $item['author'] = $obj->author_alias();
        $item['datesub'] = $obj->datesub($publisher->getConfig('format_date'));
        $usersIds[$obj->uid()] = $obj->uid();

        $ret[] = $item;
        unset($item, $sanitized_text);
    }

    xoops_load('XoopsUserUtility');
    $usersNames = XoopsUserUtility::getUnameFromIds($usersIds, $publisher->getConfig('format_realname'), true);
    foreach ($ret as $key => $item) {
        if ($item["author"] == '') {
            $ret[$key]["author"] = @$usersNames[$item["uid"]];
        }
    }
    unset($usersNames, $usersIds);

    return $ret;
}

?>