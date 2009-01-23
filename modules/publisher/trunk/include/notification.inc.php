<?php

/**
* $Id: notification.inc.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

function publisher_notify_iteminfo($category, $item_id)
{
    global $xoopsModule, $xoopsModuleConfig, $xoopsConfig;

    include_once(XOOPS_ROOT_PATH . "/modules/publisher/include/seo_functions.php");
    
    if (empty($xoopsModule) || $xoopsModule->getVar('dirname') != 'publisher') {
        $module_handler = &xoops_gethandler('module');
        $module = &$module_handler->getByDirname('publisher');
        $config_handler = &xoops_gethandler('config');
        $config = &$config_handler->getConfigsByCat(0, $module->getVar('mid'));
    } else {
        $module = &$xoopsModule;
        $config = &$xoopsModuleConfig;
    } 

    if ($category == 'global') {
        $item['name'] = '';
        $item['url'] = '';
        return $item;
    } 

    global $xoopsDB;

    if ($category == 'category') {
        // Assume we have a valid category id
        $sql = 'SELECT name, short_url FROM ' . $xoopsDB->prefix('publisher_categories') . ' WHERE categoryid  = ' . $item_id;
        $result = $xoopsDB->query($sql); // TODO: error check
        $result_array = $xoopsDB->fetchArray($result);
        $item['name'] = $result_array['name'];
        $item['url'] = publisher_seo_genUrl('category', $item_id, $result_array['short_url']); 
        return $item;
    } 

    if ($category == 'item') {
        // Assume we have a valid story id
        $sql = 'SELECT title, short_url FROM ' . $xoopsDB->prefix('publisher_item') . ' WHERE itemid = ' . $item_id;
        $result = $xoopsDB->query($sql); // TODO: error check
        $result_array = $xoopsDB->fetchArray($result);
        $item['name'] = $result_array['title'];
        $item['url'] = publisher_seo_genUrl('item', $item_id, $result_array['short_url']); 
        return $item;
    } 
} 

?>