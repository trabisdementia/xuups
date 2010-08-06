<?php

/**
 * $Id: client.php,v 1.8 2005/05/30 17:37:15 fx2024 Exp $
 * Module: SmartClient
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

include_once("header.php");
$xoopsOption['template_main'] = 'smartclient_client.html';
include_once(XOOPS_ROOT_PATH . "/header.php");
include_once("footer.php");

global $xoopsUser, $xoopsConfig, $xoopsModuleConfig, $xoopsModule;

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

If ($id == 0) {
    redirect_header("javascript:history.go(-1)", 2, _MD_SCLIENT_NOCLIENTSELECTED);
    exit();
}

// Creating the Client object for the selected FAQ
$clientObj = new SmartclientClient($id);

// If the selected client was not found, exit
If ($clientObj->notLoaded()) {
    redirect_header("javascript:history.go(-1)", 2, _MD_SCLIENT_NOCLIENTSELECTED);
    exit();
}

// Chech the status
If ($clientObj->status() != _SCLIENT_STATUS_ACTIVE) {
    redirect_header("javascript:history.go(-1)", 2, _NOPERM);
    exit();
}

// Updating the counter
$clientObj->updateHits_page();

// Populating the smarty variables with informations related to the selected Client
$client = $clientObj->toArray();
$xoopsTpl->assign('client', $client);

// Lanugage constants
$xoopsTpl->assign('lang_contact', _CO_SCLIENT_CONTACT);
$xoopsTpl->assign('lang_email', _CO_SCLIENT_EMAIL);
$xoopsTpl->assign('lang_adress', _CO_SCLIENT_ADRESS);
$xoopsTpl->assign('lang_phone', _CO_SCLIENT_PHONE);
$xoopsTpl->assign('lang_website', _CO_SCLIENT_WEBSITE);
$xoopsTpl->assign('lang_times', _CO_SCLIENT_TIMES);
$xoopsTpl->assign('lang_stats', _CO_SCLIENT_STATS);
$xoopsTpl->assign('lang_client_informations', _CO_SCLIENT_CLIENT_INFORMATIONS);
$xoopsTpl->assign('lang_page_been_seen', _CO_SCLIENT_PAGE_BEEN_SEEN);
$xoopsTpl->assign('lang_url_been_visited', _CO_SCLIENT_URL_BEEN_VISITED);
$xoopsTpl->assign('backtoindex', $xoopsModuleConfig['backtoindex']);
$xoopsTpl->assign('lang_backtoindex', _MD_SCLIENT_BACKTOINDEX);
$xoopsTpl->assign('modulepath', SMARTCLIENT_URL);

$show_stats_block = false;
if ($xoopsUser) {
    foreach($xoopsModuleConfig['stats_group'] as $group) {
        if (in_array($group, $xoopsUser->getGroups()))	{
            $show_stats_block = true;
        }
    }
} else {
    $show_stats_block = in_array(XOOPS_GROUP_ANONYMOUS, $xoopsModuleConfig['stats_group']);
}

$xoopsTpl->assign('show_stats_block', $show_stats_block);

// MetaTag Generator
smartclient_createMetaTags($clientObj->title(), '', $clientObj->summary());
if (file_exists(XOOPS_ROOT_PATH . '/modules/smarttie/smarttie_links.php')) {
    include_once XOOPS_ROOT_PATH . '/modules/smarttie/smarttie_links.php';
    $xoopsTpl->assign('smarttie',1);
}
include_once XOOPS_ROOT_PATH . '/footer.php';

?>