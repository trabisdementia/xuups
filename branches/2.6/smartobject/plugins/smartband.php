<?php

/**
 * $Id: smartband.php 159 2007-12-17 16:44:05Z malanciault $
 * Module: SmartClone
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

function smartobject_plugin_smartband() {
    global $xoopsConfig;
    include_once(XOOPS_ROOT_PATH."/modules/smartband/language/".$xoopsConfig['language']."/main.php");

    $pluginInfo = array();
    $pluginInfo['items']['item']['caption'] = _MD_ARTALBUM_ITEM_CAP;
    $pluginInfo['items']['item']['url'] = 'item.php?itemid=%u';
    $pluginInfo['items']['item']['request'] = 'itemid';

    $pluginInfo['items']['category']['caption'] = _MD_ARTALBUM_CATEGORY;
    $pluginInfo['items']['category']['url'] = 'category.php?categoryid=%u';
    $pluginInfo['items']['category']['request'] = 'categoryid';

    return $pluginInfo;
}

?>