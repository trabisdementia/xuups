<?php

/**
 * $Id: index.php,v 1.6 2005/05/26 15:26:15 fx2024 Exp $
 * Module: SmartClient
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

include "header.php";
$xoopsOption['template_main'] = 'smartclient_index.html';
include XOOPS_ROOT_PATH."/header.php";
include "footer.php";

Global $myts;

// Creating the client handler object
$client_handler =& smartclient_gethandler('client', SMARTCLIENT_DIRNAME);

// At which record shall we start
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;

$clients_total = $client_handler->getClientCount();

$clientsObj =& $client_handler->getClients($xoopsModuleConfig['perpage_user'], $start, _SCLIENT_STATUS_ACTIVE, $xoopsModuleConfig['index_sortby'], $xoopsModuleConfig['index_orderby']);
$clients_total_onpage = count($clientsObj);

$clients = array();

If ($clientsObj) {
    for ( $i = 0; $i < $clients_total_onpage; $i++ ) {
        $client = array();
        $client = $clientsObj[$i]->toArray();
        $clients[] = $client;
    }
}
$xoopsTpl->assign('clients', $clients);


// Clients Navigation Bar
$pagenav = new XoopsPageNav($clients_total, $xoopsModuleConfig['perpage_user'], $start, 'start', '');
$xoopsTpl->assign('pagenav', '<div style="text-align:right;">' . $pagenav->renderNav() . '</div>');

$xoopsTpl->assign('sitename', $xoopsConfig['sitename']);
$xoopsTpl->assign("displayjoin" , $xoopsModuleConfig['allowsubmit'] && (is_object($xoopsUser) || $xoopsModuleConfig['anonpost']));
$xoopsTpl->assign("img_max_width" , $xoopsModuleConfig['img_max_width']);

$xoopsTpl->assign('lang_intro_text' , $myts->displayTarea($xoopsModuleConfig['welcomemsg']));
$xoopsTpl->assign('lang_client', _MD_SCLIENT_CLIENT);
$xoopsTpl->assign('lang_desc', _MD_SCLIENT_DESCRIPTION);
$xoopsTpl->assign('lang_edit', _MD_SCLIENT_EDIT);
$xoopsTpl->assign('lang_delete', _MD_SCLIENT_DELETE);
$xoopsTpl->assign('lang_hits', _MD_SCLIENT_HITS);
$xoopsTpl->assign('lang_join' , _MD_SCLIENT_JOIN);
$xoopsTpl->assign('lang_no_clients', _MD_SCLIENT_NOPART);
$xoopsTpl->assign('lang_main_client', _MD_SCLIENT_CLIENTS);
$xoopsTpl->assign('lang_readmore', _MD_SCLIENT_READMORE);
if(!$xoopsModuleConfig['hide_module_name']){
    $xoopsTpl->assign('lang_clientstitle', $myts->displayTarea($xoopsModule->getVar('name')));
}
include_once XOOPS_ROOT_PATH.'/footer.php';
?>