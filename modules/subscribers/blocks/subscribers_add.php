<?php

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

function subscribers_add_show($options)
{
    include_once XOOPS_ROOT_PATH . '/modules/subscribers/include/functions.php';
    subscribers_sendEmails();
    
    $config =& subscribers_getModuleConfig();
    $block = array();
    include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
    $block['countries'] = XoopsLists::getCountryList();
    $block['selected'] = $config['country'];
    array_shift($block['countries']);
    return $block;
}
?>
