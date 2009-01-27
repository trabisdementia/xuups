<?php
//  Author: The ImpressCMS Project & TheRplima & Trabis
//  URL: http://www.impresscms.org/ & http://www.xuups.com
//  E-Mail: therplima@impresscms.org & lusopoemas@gmail.com

require 'admin_header.php';

if (!empty($_POST)) foreach ($_POST as $k => $v) ${$k} = $v;
if (!empty($_GET)) foreach ($_GET as $k => $v) ${$k} = $v;
$op = (isset($_GET['op']))?trim($_GET['op']):((isset($_POST['op']))?trim($_POST['op']):'list');
$theme_id = (isset($_GET['theme_id']))?intval($_GET['theme_id']):(isset($_POST['theme_id'])?intval($_POST['theme_id']):0);
$limit = (isset($_GET['limit']))?intval($_GET['limit']):(isset($_POST['limit'])?intval($_POST['limit']):15);
$start = (isset($_GET['start']))?intval($_GET['start']):(isset($_POST['start'])?intval($_POST['start']):0);
$redir = (isset($_GET['redir']))?$_GET['redir']:(isset($_POST['redir'])?$_POST['redir']:null);

switch ($op){
    case 'list':
        xoops_cp_header();
        defacer_adminmenu(1);
        echo themes_index($start);
        xoops_cp_footer();
        break;
    case 'addtheme':
        themes_addtheme();
        break;
    case 'edittheme':
        xoops_cp_header();
        defacer_adminmenu(1);
        echo themeform($theme_id);
        xoops_cp_footer();
        break;
    case 'editthemeok':
        themes_edittheme($theme_id);
        break;
    case 'deltheme':
        themes_confirmdeltheme($theme_id,$redir);
        break;
    case 'delthemeok':
        themes_deltheme($theme_id,$redir);
        break;
}

function themes_index($start=0){
	global $xoopsTpl,$xoopsUser,$xoopsConfig,$limit;

	include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';

	$theme_handler =& xoops_getmodulehandler('theme','defacer');
	$page_handler =& xoops_getmodulehandler('page','defacer');
	$module_handler =& xoops_gethandler('module');

	$themecount = $theme_handler->getCount();
	$xoopsTpl->assign('themecount',$themecount);
    $criteria = new CriteriaCompo();
    $criteria->setStart($start);
	$criteria->setLimit($limit);
	$themes = $theme_handler->getObjects($criteria);

	if ($themecount > 0){
		if ($themecount > $limit) {
			include_once XOOPS_ROOT_PATH.'/class/themenav.php';
			$nav = new XoopsthemeNav($themecount, $limit, $start, 'start', 'op=list');
			$xoopsTpl->assign('pag','<div style="float:left; padding-top:2px;" align="center">'.$nav->renderNav().'</div>');
		}else{
			$xoopsTpl->assign('pag','');
		}
	}else{
		$xoopsTpl->assign('pag','');
	}

	foreach ($themes as $theme){
		$pag = array();
		
		$pag['theme_id'] = $theme->getVar('theme_id');
		$pag['theme_name'] = $theme->getVar('theme_name');
		$page = $page_handler->get($theme->getVar('theme_id'));
        $mod = $module_handler->get($page->getVar('page_moduleid'));
        if (!is_object($mod)) continue;
		$pag['module'] = $mod->getVar('name');
		$pag['theme_title'] = $page->getVar('page_title');
		$pag['theme_url'] = $page->getVar('page_url');
		if (substr($page->getVar('page_url'),-1) == '*'){
			$pag['theme_vurl'] = 0;
		}else{
			if (substr($page->getVar('page_url'),0,7) == 'http://'){
				$pag['theme_vurl'] = $page->getVar('page_url');
			}else{
				$pag['theme_vurl'] = XOOPS_URL.'/'.$page->getVar('page_url');
			}
		}
		$pag['theme_status'] = $page->getVar('page_status');
		$xoopsTpl->append('themes',$pag);
	}
	$xoopsTpl->assign('addthemeform',themeform());

	return $xoopsTpl->fetch('db:defacer_admin_theme.html');
}

function themes_addtheme() {
	if (!$GLOBALS['xoopsSecurity']->check()) {
		redirect_header('admin_theme.php', 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
	}

	$theme_handler =& xoops_getmodulehandler('theme','defacer');
	$criteria =  new Criteria('theme_id', $_POST['theme_id']);
	$themecount = $theme_handler->getCount($criteria);
	if ($themecount > 0) {
        $theme = $theme_handler->get($_POST['theme_id']);
    }  else {
        $theme = $theme_handler->create();
    }
    $theme->setVars($_POST);
	if (!$theme_handler->insert($theme)){
		$msg = _AM_DEFACER_ERROR;
	}else{
		$msg = _AM_DEFACER_DBUPDATED;
	}

	redirect_header('admin_theme.php?op=list',2,$msg);
}

function themes_edittheme($theme_id) {
	if (!$GLOBALS['xoopsSecurity']->check()) {
		redirect_header('admin_theme.php', 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
	}
	$theme_handler =& xoops_getmodulehandler('theme','defacer');
	$theme = $theme_handler->get($theme_id);

	$theme->setVars($_POST);
	if (!$theme_handler->insert($theme)){
		$msg = _AM_DEFACER_ERROR;
	}else{
		$msg = _AM_DEFACER_DBUPDATED;
	}

	redirect_header('admin_theme.php?op=list',2,$msg);
}

function themes_deltheme($theme_id,$redir=null) {
	if (!$GLOBALS['xoopsSecurity']->check()) {
		redirect_header('admin_theme.php',1, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
	}
	if ($theme_id <= 0) {
		redirect_header('admin_theme.php',1);
	}
	$theme_handler =& xoops_getmodulehandler('theme','defacer');
	$theme = $theme_handler->get($theme_id);
	if (!is_object($theme)) {
		redirect_header('admin_theme.php',1);
	}

	if (!$theme_handler->delete($theme)) {
		xoops_cp_header();
		xoops_error(sprintf(_AM_DEFACER_ERROR, $theme->getVar('theme_id')));
		xoops_cp_footer();
		exit();
	}

	redirect_header((!is_null($redir))?base64_decode($redir):'admin_theme.php',2,_AM_DEFACER_DBUPDATED);
}

function themes_confirmdeltheme($theme_id,$redir=null){
	global $xoopsConfig;

	$theme_handler =& xoops_getmodulehandler('theme','defacer');
	$theme = $theme_handler->get($theme_id);

/*	if ($xoopsConfig['starttheme'] == $theme->getVar('theme_moduleid').'-'.$theme->getVar('theme_id')){ //Selected theme is the start theme of the site
		redirect_header((!is_null($redir))?base64_decode($redir).'&canceled=1':'admin_theme.php?op=list',5,_AM_DEFACER_DELSTARTTHEME);
	}else{   */
		xoops_cp_header();
		$arr = array();
		$arr['op'] = 'delthemeok';
		$arr['theme_id'] = $theme_id;
		$arr['fct'] = 'themes';
		if (!is_null($redir)){
			$arr['redir'] = $redir;
		}
		xoops_confirm($arr, 'admin_theme.php', _AM_DEFACER_RUDELtheme);
		xoops_cp_footer();
	//}
}

function themeform($id=null){
	global $xoopsUser, $xoopsConfig, $theme_id;
	include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';

	$theme_handler =& xoops_getmodulehandler('theme','defacer');
	$page_handler =& xoops_getmodulehandler('page','defacer');

	if (isset($id)) $theme = $theme_handler->get($id);
	if (@is_object($theme)){
		$ftitle = _EDIT;
        $theme_id = $theme->getVar('theme_id');
        $theme_name = $theme->getVar('theme_name');
	}else{
		$ftitle = _ADD;
		$theme_name = '';
	}

	$form = new XoopsThemeForm($ftitle, 'theme_form', 'admin_theme.php', "post", true);

	$page_select = new XoopsFormSelect(_AM_DEFACER_PAGE, 'theme_id', $theme_id);
	$page_select->customValidationCode[] = 'var value = document.getElementById(\'theme_id\').value; if (value == 0){alert("'._AM_DEFACER_SELECTPAGE_ERR.'"); return false;}';

	$criteria = new CriteriaCompo(new Criteria('page_status', 1));
	$criteria->setSort('name');
	$criteria->setOrder('ASC');
	$pageslist = $page_handler->getList($criteria);
    $list = array('0'=>'--------------------------');
	$pageslist = $list+$pageslist;
	$page_select->addOptionArray($pageslist);
	$form->addElement($page_select,true);
	

    $dirname = XOOPS_THEME_PATH.'/';
	$dirlist = array();
		if (is_dir($dirname) && $handle = opendir($dirname)) {
			while (false !== ($file = readdir($handle))) {
				if ( !preg_match("/^[\.]{1,2}$/",$file) ) {
					if (strtolower($file) != 'cvs' && is_dir($dirname.$file) && $file!='z_changeable_theme' ) {
						$dirlist[$file]=$file;
					}
				}
			}
			closedir($handle);
			asort($dirlist);
			reset($dirlist);
		}
	$theme_select = new XoopsFormSelect(_AM_DEFACER_THEME,'theme_name' , $theme_name);
	$theme_select->addOptionArray($dirlist);
	$form->addElement($theme_select);

	$tray = new XoopsFormElementTray('' ,'');
	$tray->addElement(new XoopsFormButton('', 'theme_button', _SUBMIT, 'submit'));

	$btn = new XoopsFormButton('', 'reset', _CANCEL, 'button');
	if (@is_object($theme)){
		$btn->setExtra('onclick="document.location.href=\'admin_theme.php?op=list\'"');
	}else{
		$btn->setExtra('onclick="document.getElementById(\'addthemeform\').style.display = \'none\'; return false;"');
	}
	$tray->addElement($btn);
	$form->addElement($tray);

	if (@is_object($theme)){
		$form->addElement(new XoopsFormHidden('op', 'editthemeok'));
		$form->addElement(new XoopsFormHidden('theme_id', $id));
	}else{
		$form->addElement(new XoopsFormHidden('op', 'addtheme'));
	}

	return $form->render();
}
?>
