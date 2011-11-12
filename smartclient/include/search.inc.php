<?php

/**
 * $Id: search.inc.php,v 1.3 2005/04/19 18:21:14 fx2024 Exp $
 * Module: SmartMedia
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

function smartclient_search($queryarray, $andor, $limit, $offset, $userid)
{
    // This must contain the name of the folder in which reside SmartClient
    if( !defined("SMARTCLIENT_DIRNAME") ){
        define("SMARTCLIENT_DIRNAME", 'smartclient');
    }
    include_once XOOPS_ROOT_PATH.'/modules/' . SMARTCLIENT_DIRNAME . '/include/common.php';

    $ret = array();

    if (!isset($client_handler)) {
        $client_handler =& smartclient_gethandler('client');
    }

    // Searching the clients
    $clients_result = $client_handler->getObjectsForSearch($queryarray, $andor, $limit, $offset, $userid);

    if ($queryarray == ''){
        $keywords= '';
        $hightlight_key = '';
    } else {
        $keywords=implode('+', $queryarray);
        $hightlight_key = "&amp;keywords=" . $keywords;
    }

    foreach ($clients_result as $result) {
        $item['image'] = "images/links/client.gif";
        $item['link'] = "client.php?id=" . $result['id'] . $hightlight_key;
        $item['title'] = "" . $result['title'];
        $item['time'] = "";
        $item['uid'] = "";
        $ret[] = $item;
        unset($item);
    }

    return $ret;
}

?>