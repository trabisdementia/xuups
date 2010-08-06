<?php

/**
 * $Id: notification.inc.php,v 1.3 2005/04/19 18:21:12 fx2024 Exp $
 * Module: SmartClient
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

function smartclient_notify_iteminfo($category, $item_id)
{
    // This must contain the name of the folder in which reside SmartClient
    if( !defined("SMARTCLIENT_DIRNAME") ){
        define("SMARTCLIENT_DIRNAME", 'smartclient');
    }

    global $xoopsModule, $xoopsModuleConfig, $xoopsConfig;

    if (empty($xoopsModule) || $xoopsModule->getVar('dirname') != SMARTCLIENT_DIRNAME) {
        $module_handler = &xoops_gethandler('module');
        $module = &$module_handler->getByDirname(SMARTCLIENT_DIRNAME);
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

    if ($category == 'item') {
        // Assume we have a valid client id
        $sql = 'SELECT question FROM ' . $xoopsDB->prefix('smartclient_client') . ' WHERE id = ' . $item_id;
        $result = $xoopsDB->query($sql); // TODO: error check
        $result_array = $xoopsDB->fetchArray($result);
        $item['name'] = $result_array['title'];
        $item['url'] = XOOPS_URL . '/modules/' . $module->getVar('dirname') . '/client.php?id=' . $item_id;
        return $item;
    }
}

?>