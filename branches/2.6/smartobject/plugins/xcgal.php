<?php

/**
 * $Id: xcgal.php 159 2007-12-17 16:44:05Z malanciault $
 * Module: SmartClone
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

function smartobject_plugin_xcgal() {
    global $xoopsConfig;

    $pluginInfo = array();
    $pluginInfo['items']['album']['caption'] = 'Album';
    $pluginInfo['items']['item']['url'] = 'thumbnails.php?album=%u';
    $pluginInfo['items']['item']['request'] = 'album';

    return $pluginInfo;
}

?>