<?php

/**
 * $Id: rating.rate.php 159 2007-12-17 16:44:05Z malanciault $
 * Module: SmartRental
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

if (!defined('SMARTOBJECT_URL')) {
    include_once(XOOPS_ROOT_PATH . '/modules/smartobject/include/common.php');
}
include_once(SMARTOBJECT_ROOT_PATH . "class/rating.php");
include_once(SMARTOBJECT_ROOT_PATH . "include/functions.php");

smart_loadLanguageFile('smartobject', 'rating');

$module_dirname = $xoopsModule->dirname();

// Retreive the SmartObject Rating plugin for the current module if it exists
$smartobject_rating_handler = xoops_getModuleHandler('rating', 'smartobject');
$smartobject_plugin_handler = new SmartPluginHandler();
$pluginObj = $smartobject_plugin_handler->getPlugin($module_dirname);
if ($pluginObj) {
    $rating_item = $pluginObj->getItem();
    if ($rating_item) {
        $rating_itemid = $pluginObj->getItemIdForItem($rating_item);
        $stats = $smartobject_rating_handler->getRatingAverageByItemId($rating_itemid, $module_dirname, $rating_item);
        $xoopsTpl->assign('smartobject_rating_stats_total', $stats['sum']);
        $xoopsTpl->assign('smartobject_rating_stats_average', $stats['average']);
        $xoopsTpl->assign('smartobject_rating_item', $rating_item);
        if(is_object($xoopsUser)){
            $ratingObj = $smartobject_rating_handler->already_rated($rating_item, $rating_itemid, $module_dirname, $xoopsUser->getVar('uid'));
            $xoopsTpl->assign('smartobject_user_can_rate', true);
        }
        if(isset($ratingObj) && is_object($ratingObj)){
            $xoopsTpl->assign('smartobject_user_rate', $ratingObj->getVar('rate'));
            $xoopsTpl->assign('smartobject_rated', true);
        }else{
            $xoopsTpl->assign('smartobject_rating_dirname', $module_dirname);
            $xoopsTpl->assign('smartobject_rating_itemid', $rating_itemid);
            $urls = smart_getCurrentUrls();
            $xoopsTpl->assign('smartobject_rating_current_page', $urls['full']);
            if(isset($xoTheme) && is_object($xoTheme)){
                $xoTheme->addStylesheet(SMARTOBJECT_URL . 'module.css');
            }else{
                //probleme d'inclusion de css apres le flashplayer. Style placé dans css du theme
                //$xoopsTpl->assign('smartobject_css',"<link rel='stylesheet' type='text/css' href='".XOOPS_URL."/modules/smartobject/module.css' />");
            }

        }
    }
}

if (isset($_POST['smartobject_rating_submit'])) {
    // The rating form has just been posted. Let's save the info
    $ratingObj = $smartobject_rating_handler->create();
    $ratingObj->setVar('dirname', $module_dirname);
    $ratingObj->setVar('item', $rating_item);
    $ratingObj->setVar('itemid', $rating_itemid);
    $ratingObj->setVar('uid', $xoopsUser->getVar('uid'));
    $ratingObj->setVar('date', time());
    $ratingObj->setVar('rate', $_POST['smartobject_rating_value']);
    if (!$smartobject_rating_handler->insert($ratingObj)) {
        if ($xoopsDB->errno() == 1062) {
            $message = _SOBJECT_RATING_DUPLICATE_ENTRY;
        } else {
            $message = _SOBJECT_RATING_ERROR;
        }
    } else {
        $message = _SOBJECT_RATING_SUCCESS;
    }
    redirect_header('', 3, $message);
    exit;
}

?>