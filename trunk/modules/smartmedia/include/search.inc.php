<?php

/**
 * $Id: search.inc.php,v 1.1 2005/05/13 18:22:03 malanciault Exp $
 * Module: SmartMedia
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

function smartmedia_search($queryarray, $andor, $limit, $offset, $userid)
{
    include_once XOOPS_ROOT_PATH.'/modules/smartmedia/include/common.php';

    $ret = array();

    // Searching the categories
    $smartmedia_category_handler =& xoops_getmodulehandler('category', 'smartmedia');
    $categories_result = $smartmedia_category_handler->getObjectsForSearch($queryarray, $andor, $limit, $offset, $userid);

    foreach ($categories_result as $result) {
        $item['image'] = "images/icon/cat.gif";
        $item['link'] = "category.php?categoryid=" . $result['id'] . "&amp;keywords=" . implode('+', $queryarray);
        $item['title'] = "" . $result['title'];
        $item['time'] = "";
        $item['uid'] = "";
        $ret[] = $item;
        unset($item);

    }

    // Searching the folders
    $smartmedia_folder_handler =& xoops_getmodulehandler('folder', 'smartmedia');
    $folders_result = $smartmedia_folder_handler->getObjectsForSearch($queryarray, $andor, $limit, $offset, $userid);

    foreach ($folders_result as $result) {
        $item['image'] = "images/icon/folder.gif";
        $item['link'] = "folder.php?categoryid=" . $result['categoryid'] . "&amp;folderid=" . $result['id'] . "&amp;keywords=" . implode('+', $queryarray);
        $item['title'] = "" . $result['title'];
        $item['time'] = "";
        $item['uid'] = "";
        $ret[] = $item;
        unset($item);
    }

    // Searching the clipd
    $smartmedia_clip_handler =& xoops_getmodulehandler('clip', 'smartmedia');
    $clips_result = $smartmedia_clip_handler->getObjectsForSearch($queryarray, $andor, $limit, $offset, $userid);

    foreach ($clips_result as $result) {
        $item['image'] = "images/icon/clip.gif";
        $item['link'] = "clip.php?categoryid=" . $result['categoryid'] . "&amp;folderid=" . $result['folderid'] . "&amp;clipid=" . $result['id'] . "&amp;keywords=" . implode('+', $queryarray);
        $item['title'] = "" . $result['title'];
        $item['time'] = "";
        $item['uid'] = "";
        $ret[] = $item;
        unset($item);
    }

    return $ret;
}

?>