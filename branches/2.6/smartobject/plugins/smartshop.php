<?php

/**
 * $Id: smartshop.php 159 2007-12-17 16:44:05Z malanciault $
 * Module: SmartClone
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

function smartobject_plugin_smartshop() {
    $pluginInfo = array();

    $pluginInfo['items']['item']['caption'] = 'Item';
    $pluginInfo['items']['item']['url'] = 'item.php?itemid=%u';
    $pluginInfo['items']['item']['request'] = 'itemid';

    $pluginInfo['items']['category']['caption'] = 'Category';
    $pluginInfo['items']['category']['url'] = 'category.php?categoryid=%u';
    $pluginInfo['items']['category']['request'] = 'categoryid';

    return $pluginInfo;
}

?>