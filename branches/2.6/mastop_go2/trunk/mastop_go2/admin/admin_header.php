<?php
### =============================================================
### Mastop InfoDigital - Paix�o por Internet
### =============================================================
### Header com includes padr�es para a Admin do M�dulo
### =============================================================
### Developer: Fernando Santos (topet05), fernando@mastop.com.br
### Copyright: Mastop InfoDigital � 2003-2007
### -------------------------------------------------------------
### www.mastop.com.br
### =============================================================
### $Id$
### =============================================================
include '../../../include/cp_header.php';
if ( file_exists("../language/".$xoopsConfig['language']."/modinfo.php") ) {
	include_once("../language/".$xoopsConfig['language']."/modinfo.php");
} else {
	include_once("../language/portuguesebr/modinfo.php");
}
include_once XOOPS_ROOT_PATH."/modules/".MGO_MOD_DIR."/include/funcoes.inc.php";
$c['lang']['filtros'] = MGO_ADM_FILTROS;
$c['lang']['exibir'] = MGO_ADM_EXIBIR;
$c['lang']['exibindo'] = MGO_ADM_EXIBINDO;
$c['lang']['por_pagina'] = MGO_ADM_PORPAGINA;
$c['lang']['acao'] = MGO_ADM_ACAO;
$c['lang']['semresult'] = MGO_ADM_SEMRESULT;
$c['lang']['showhidemenu'] = MGO_ADM_SHOWHIDEMENU;

$c['lang']['group_action'] = MGO_ADM_GRP_ACTION;
$c['lang']['group_erro_sel'] = MGO_ADM_GRP_ERR_SEL;
$c['lang']['group_del'] = MGO_ADM_GRP_DEL;
$c['lang']['group_del_sure'] = MGO_ADM_GRP_DEL_SURE;

require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/mainfile.php';
require_once XOOPS_ROOT_PATH . '/include/cp_functions.php';
require '../../../include/cp_header.php';

if ( file_exists($GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php'))){
        include_once $GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php');
        //return true;
    }else{
        echo xoops_error("Error: You don't use the Frameworks \"admin module\". Please install this Frameworks");
        //return false;
    }

$moduleInfo =& $module_handler->get($xoopsModule->getVar('mid'));
$pathImageIcon = XOOPS_URL .'/'. $moduleInfo->getInfo('icons16');
$pathImageAdmin = XOOPS_URL .'/'. $moduleInfo->getInfo('icons32');

$myts =& MyTextSanitizer::getInstance();

if ($xoopsUser) {
    $moduleperm_handler =& xoops_gethandler('groupperm');
    if (!$moduleperm_handler->checkRight('module_admin', $xoopsModule->getVar( 'mid' ), $xoopsUser->getGroups())) {
        redirect_header(XOOPS_URL, 1, _NOPERM);
        exit();
    }
} else {
    redirect_header(XOOPS_URL . "/user.php", 1, _NOPERM);
    exit();
}

if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
	include_once(XOOPS_ROOT_PATH."/class/template.php");
	$xoopsTpl = new XoopsTpl();
}

//xoops_cp_header();

//Load languages
xoops_loadLanguage('admin', $xoopsModule->getVar("dirname"));
xoops_loadLanguage('modinfo', $xoopsModule->getVar("dirname"));
xoops_loadLanguage('main', $xoopsModule->getVar("dirname"));










function mgo_adm_menu(){
	global $xoopsModule, $xoopsConfig, $xoopsModuleConfig;
	$adm_url = XOOPS_URL."/modules/".MGO_MOD_DIR."/admin/";
	$links[] = array(0 => XOOPS_URL.'/modules/system/admin.php?fct=preferences&op=showmod&mod='.$xoopsModule->getVar('mid'), 1 => _PREFERENCES);
	xoops_cp_header();
	echo '
<link rel="stylesheet" type="text/css" href="menu/style_menu.css" />
<script type="text/javascript" src="menu/jsdomenu.js"></script>
<script type="text/javascript" src="menu/jsdomenubar.js"></script>
<script type="text/javascript">
function createjsDOMenu() {
	mainMenu1 = new jsDOMenu(170);
	with (mainMenu1) {
	    addMenuItem(new menuItem("'._ADD.'", "", "'.$adm_url.'sec.php?op=novo"));
		addMenuItem(new menuItem("'.MGO_ADM_GER.'", "", "'.$adm_url.'sec.php?op=listar"));
	}

	mainMenu2 = new jsDOMenu(170);
	with (mainMenu2) {
		addMenuItem(new menuItem("'._ADD.'", "", "'.$adm_url.'go2.php?op=novo"));
		addMenuItem(new menuItem("'.MGO_ADM_GER.'", "", "'.$adm_url.'go2.php?op=listar"));
	}

	mainMenu3 = new jsDOMenu(150);
	with (mainMenu3) {
		addMenuItem(new menuItem("'.MGO_ADM_BLOCKS.'", "", "'.$adm_url.'blocksadmin.php"));
		addMenuItem(new menuItem("'._PREFERENCES.'", "", "'.XOOPS_URL.'/modules/system/admin.php?fct=preferences&op=showmod&mod='.$xoopsModule->getVar('mid').'"));
	}

	menuBar = new jsDOMenuBar();
	with (menuBar) {
		addMenuBarItem(new menuBarItem("'.MGO_ADM_SEC.'", mainMenu1, "cliid"));
		addMenuBarItem(new menuBarItem("'.MGO_ADM_GO2.'", mainMenu2, "prdid"));
		addMenuBarItem(new menuBarItem("'._OPTIONS.'", mainMenu3, "optid"));
	}
	menuBar.items.cliid.showIcon("sec", "sec", "sec");
	menuBar.items.prdid.showIcon("go2", "go2", "go2");
	menuBar.items.optid.showIcon("opt", "opt", "opt");
	menuBar.moveTo(680, 81);
}
</script>
';
}
?>