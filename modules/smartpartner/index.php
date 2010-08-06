<?php

/**
 * $Id: index.php,v 1.9 2005/05/17 20:28:08 fx2024 Exp $
 * Module: SmartPartner
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

include "header.php";
$xoopsOption['template_main'] = 'smartpartner_index.html';
include XOOPS_ROOT_PATH."/header.php";
include "footer.php";

Global $myts;

// Creating the partner handler object
$partner_handler =& smartpartner_gethandler('partner', SMARTPARTNER_DIRNAME);

// At which record shall we start
$start = isset($_GET['start']) ? intval($_GET['start']) : 0;

$partners_total = $partner_handler->getPartnerCount();

$partnersObj =& $partner_handler->getPartners($xoopsModuleConfig['perpage_user'], $start, _SPARTNER_STATUS_ACTIVE, $xoopsModuleConfig['index_sortby'], $xoopsModuleConfig['index_orderby']);
$partners_total_onpage = count($partnersObj);

$partners = array();

If ($partnersObj) {
    for ( $i = 0; $i < $partners_total_onpage; $i++ ) {
        $partner = $partnersObj[$i]->toArray();
        $partners[] = $partner;
    }
}
$xoopsTpl->assign('partners', $partners);


// Partners Navigation Bar
$pagenav = new XoopsPageNav($partners_total, $xoopsModuleConfig['perpage_user'], $start, 'start', '');
$xoopsTpl->assign('pagenav', '<div style="text-align:right;">' . $pagenav->renderNav() . '</div>');

$xoopsTpl->assign('sitename', $xoopsConfig['sitename']);
$xoopsTpl->assign("displayjoin" , $xoopsModuleConfig['allowsubmit'] && (is_object($xoopsUser) || $xoopsModuleConfig['anonpost']));
$xoopsTpl->assign("img_max_width" , $xoopsModuleConfig['img_max_width']);

$xoopsTpl->assign('lang_intro_text' , $myts->displayTarea($xoopsModuleConfig['welcomemsg']));
$xoopsTpl->assign('lang_partner', _MD_SPARTNER_PARTNER);
$xoopsTpl->assign('lang_desc', _MD_SPARTNER_DESCRIPTION);
$xoopsTpl->assign('lang_edit', _MD_SPARTNER_EDIT);
$xoopsTpl->assign('lang_delete', _MD_SPARTNER_DELETE);
$xoopsTpl->assign('lang_hits', _MD_SPARTNER_HITS);
$xoopsTpl->assign('lang_join' , _MD_SPARTNER_JOIN);
$xoopsTpl->assign('lang_no_partners', _MD_SPARTNER_NOPART);
$xoopsTpl->assign('lang_main_partner', _MD_SPARTNER_PARTNERS);
$xoopsTpl->assign('lang_readmore', _MD_SPARTNER_READMORE);
if(!$xoopsModuleConfig['hide_module_name']){
    $xoopsTpl->assign('lang_partnerstitle', $myts->displayTarea($xoopsModule->getVar('name')));
}
include_once XOOPS_ROOT_PATH.'/footer.php';
?>