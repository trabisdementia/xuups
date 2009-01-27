<?php
//  Author: The ImpressCMS Project & TheRplima & Trabis
//  URL: http://www.impresscms.org/ & http://www.xuups.com
//  E-Mail: therplima@impresscms.org & lusopoemas@gmail.com

require 'admin_header.php';

if (!empty($_POST)) foreach ($_POST as $k => $v) ${$k} = $v;
if (!empty($_GET)) foreach ($_GET as $k => $v) ${$k} = $v;
$op = (isset($_GET['op']))?trim($_GET['op']):((isset($_POST['op']))?trim($_POST['op']):'list');
$page_id = (isset($_GET['page_id']))?intval($_GET['page_id']):(isset($_POST['page_id'])?intval($_POST['page_id']):0);
$limit = (isset($_GET['limit']))?intval($_GET['limit']):(isset($_POST['limit'])?intval($_POST['limit']):15);
$start = (isset($_GET['start']))?intval($_GET['start']):(isset($_POST['start'])?intval($_POST['start']):0);
$redir = (isset($_GET['redir']))?$_GET['redir']:(isset($_POST['redir'])?$_POST['redir']:null);

switch ($op){
    case 'list':
        xoops_cp_header();
        defacer_adminmenu(0);
        echo pages_index($start);
        xoops_cp_footer();
        break;
    case 'addpage':
        pages_addpage();
        break;
    case 'editpage':
        xoops_cp_header();
        defacer_adminmenu(0);
        echo pageform($page_id);
        xoops_cp_footer();
        break;
    case 'editpageok':
        pages_editpage($page_id);
        break;
    case 'delpage':
        pages_confirmdelpage($page_id,$redir);
        break;
    case 'delpageok':
        pages_delpage($page_id,$redir);
        break;
    case 'changestatus':
        pages_changestatus($page_id,$redir);
        break;
}

function pages_index($start=0){
	global $xoopsTpl,$xoopsUser,$xoopsConfig, $limit;
    $myts =& MyTextSanitizer::getInstance();

	include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';

    $query = isset($_POST['query']) ? $_POST['query'] : null;
	$xoopsTpl->assign('query',$query);

	$page_handler =& xoops_getmodulehandler('page','defacer');
	$module_handler =& xoops_gethandler('module');

	$criteria = new CriteriaCompo();
	if (!is_null($query)){
		$crit = new CriteriaCompo(new Criteria('page_title', $myts->addSlashes($query).'%','LIKE'));
		$criteria->add($crit);
	}
	$pagecount = $page_handler->getCount($criteria);
	$xoopsTpl->assign('pagecount',$pagecount);
	$criteria->setStart($start);
	$criteria->setLimit($limit);

	$criteria->setSort('name');
	$criteria->setOrder('ASC');
	$pages = $page_handler->getObjects($criteria);

	if ($pagecount > 0){
		if ($pagecount > $limit) {
			include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
			$nav = new XoopsPageNav($pagecount, $limit, $start, 'start', 'op=list');
			$xoopsTpl->assign('pag','<div style="float:left; padding-top:2px;" align="center">'.$nav->renderNav().'</div>');
		}else{
			$xoopsTpl->assign('pag','');
		}
	}else{
		$xoopsTpl->assign('pag','');
	}

	foreach ($pages as $page){
		$pag = array();
		$pag['page_id'] = $page->getVar('page_id');
		$pag['page_moduleid'] = $page->getVar('page_moduleid');
		/*$mod = $module_handler->get($page->getVar('page_moduleid'));
		if (!is_object($mod)) continue;    */
		$pag['module'] = $page->getVar('name');
		$pag['page_title'] = $page->getVar('page_title');
		$pag['page_url'] = $page->getVar('page_url');
		if (substr($page->getVar('page_url'),-1) == '*'){
			$pag['page_vurl'] = 0;
		}else{
			if (substr($page->getVar('page_url'),0,7) == 'http://'){
				$pag['page_vurl'] = $page->getVar('page_url');
			}elseif ($page->getVar('page_moduleid') == 1){
				$pag['page_vurl'] = XOOPS_URL.'/'.$page->getVar('page_url');
			} else {
                $pag['page_vurl'] = XOOPS_URL.'/modules/'.$page->getVar('dirname').'/'.$page->getVar('page_url');
			}
		}
		$pag['page_status'] = $page->getVar('page_status');
		$xoopsTpl->append('pages',$pag);
	}
	$xoopsTpl->assign('addpageform',pageform());

	return $xoopsTpl->fetch('db:defacer_admin_page.html');
}

function pages_addpage() {
	if (!$GLOBALS['xoopsSecurity']->check()) {
		redirect_header('admin_page.php', 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
	}

	$page_handler =& xoops_getmodulehandler('page','defacer');
	$page = $page_handler->create();
	if (!isset($_POST['page_moduleid']) || $_POST['page_moduleid'] == 0){
		$_POST['page_moduleid'] = 1;
	}
	$page->setVars($_POST);

	if (!$page_handler->insert($page)){
		$msg = _AM_DEFACER_ERROR;
	}else{
		$msg = _AM_DEFACER_DBUPDATED;
	}

	redirect_header('admin_page.php?op=list',2,$msg);
}

function pages_editpage($page_id) {
	if (!$GLOBALS['xoopsSecurity']->check()) {
		redirect_header('admin_page.php', 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
	}
	$page_handler =& xoops_getmodulehandler('page','defacer');
	$page = $page_handler->get($page_id);
	if (!isset($_POST['page_moduleid']) || $_POST['page_moduleid'] == 0){
		$_POST['page_moduleid'] = 1;
	}
	$page->setVars($_POST);

	if (!$page_handler->insert($page)){
		$msg = _AM_DEFACER_ERROR;
	}else{
		$msg = _AM_DEFACER_DBUPDATED;
	}

	redirect_header('admin_page.php?op=list',2,$msg);
}

function pages_delpage($page_id,$redir=null) {
	if (!$GLOBALS['xoopsSecurity']->check()) {
		redirect_header('admin_page.php',1, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
	}
	if ($page_id <= 0) {
		redirect_header('admin_page.php',1);
	}
	$page_handler =& xoops_getmodulehandler('page','defacer');
	$theme_handler =& xoops_getmodulehandler('theme','defacer');
	$meta_handler =& xoops_getmodulehandler('meta','defacer');
	$permission_handler =& xoops_getmodulehandler('permission','defacer');

    $page = $page_handler->get($page_id);
	if (!is_object($page)) {
		redirect_header('admin_page.php',1);
	}

	if (!$page_handler->delete($page)) {
		xoops_cp_header();
		xoops_error(sprintf(_AM_DEFACER_ERROR, $page->getVar('page_id')));
		xoops_cp_footer();
		exit();
	}
	
	$theme = $theme_handler->get($page_id);
	if (is_object($theme) && !$theme_handler->delete($theme)) {
		xoops_cp_header();
		xoops_error(sprintf(_AM_DEFACER_ERROR, $theme->getVar('theme_id')));
		xoops_cp_footer();
		exit();
	}
	
	$meta = $meta_handler->get($page_id);
	if (is_object($meta) && !$meta_handler->delete($meta)) {
		xoops_cp_header();
		xoops_error(sprintf(_AM_DEFACER_ERROR, $meta->getVar('meta_id')));
		xoops_cp_footer();
		exit();
	}
	
	$permission = $permission_handler->get($page_id);
	if (is_object($permission) && !$permission_handler->delete($permission)) {
		xoops_cp_header();
		xoops_error(sprintf(_AM_DEFACER_ERROR, $permission->getVar('permission_id')));
		xoops_cp_footer();
		exit();
	}
	
	redirect_header((!is_null($redir))?base64_decode($redir):'admin_page.php',2,_AM_DEFACER_DBUPDATED);
}

function pages_confirmdelpage($page_id,$redir=null){
	global $xoopsConfig;

	$page_handler =& xoops_getmodulehandler('page','defacer');
	$page = $page_handler->get($page_id);

	/*if ($xoopsConfig['startpage'] == $page->getVar('page_moduleid').'-'.$page->getVar('page_id')){ //Selected page is the start page of the site
		redirect_header((!is_null($redir))?base64_decode($redir).'&canceled=1':'admin_page.php?op=list',5,_AM_DEFACER_DELSTARTPAGE);
	}else{   */
		xoops_cp_header();
		$arr = array();
		$arr['op'] = 'delpageok';
		$arr['page_id'] = $page_id;
		$arr['fct'] = 'pages';
		if (!is_null($redir)){
			$arr['redir'] = $redir;
		}
		xoops_confirm($arr, 'admin_page.php', _AM_DEFACER_RUDEL);
		xoops_cp_footer();
	//}
}

function pages_changestatus($page_id,$redir=null) {
	global $xoopsConfig;

	$page_handler =& xoops_getmodulehandler('page','defacer');
	$page = $page_handler->get($page_id);
	if (empty($redir)){
		$sts = !$page->getVar('page_status');
	}else{
		$sts = 0;
	}
	$page->setVar('page_status',$sts);

	$module_handler =& xoops_gethandler('module');
	$mod = $module_handler->get($page->getVar('page_moduleid'));

	if (!$mod->getVar('isactive')){
		redirect_header((!is_null($redir))?base64_decode($redir).'&canceled=1':'admin_page.php?op=list',3,_AM_DEFACER_MODDEACTIVE);
	}
    /*
	if ($xoopsConfig['startpage'] == $page->getVar('page_moduleid').'-'.$page->getVar('page_id')){ //Selected page is the start page of the site
		redirect_header((!is_null($redir))?base64_decode($redir).'&canceled=1':'admin_page.php?op=list',5,_AM_DEFACER_DELSTARTPAGE);
	} */

	if (!$page_handler->insert($page)){
		$msg = _AM_DEFACER_ERROR;
	}else{
		$msg = _AM_DEFACER_DBUPDATED;
	}

	redirect_header((!is_null($redir))?base64_decode($redir):'admin_page.php?op=list',2,$msg);
}

function pageform($id=null){
	global $xoopsUser,$xoopsConfig;
	include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
	
	$page_handler =& xoops_getmodulehandler('page','defacer');

	if (isset($id)){
		$ftitle = _EDIT;
        $page = $page_handler->get($id);
        $moduleid = $page->getVar('page_moduleid');
        $title = $page->getVar('page_title');
        $url = $page->getVar('page_url');
		$status = $page->getVar('page_status');
	}else{
		$ftitle = _ADD;
		$title = '';
		$url = '';
		$moduleid = '';
		$status = 1;
	}

	$form = new XoopsThemeForm($ftitle, 'page_form', 'admin_page.php', "post", true);

	$mid = new XoopsFormSelect(_AM_DEFACER_PAGE_MODULE, 'page_moduleid', $moduleid);
	$mid->customValidationCode[] = 'var value = document.getElementById(\'page_moduleid\').value; if (value == 0){alert("'._AM_DEFACER_SELECTMODULE_ERR.'"); return false;}';
	$module_handler =& xoops_gethandler('module');
	$criteria = new CriteriaCompo(new Criteria('hasmain', 1));
	$criteria->add(new Criteria('isactive', 1));
	//$criteria->setSort('name');
	//$criteria->setOrder('ASC'); xoopsModule does not accpet this :(
	$moduleslist = $module_handler->getList($criteria);
	$module = $module_handler->get(1);
	$list = array('0'=>'--------------------------',$module->getVar('mid')=>$module->getVar('name'));
	$moduleslist = $list+$moduleslist;
	$mid->addOptionArray($moduleslist);
	$form->addElement($mid,true);

	$form->addElement(new XoopsFormText(_AM_DEFACER_PAGE_TITLE, 'page_title', 50, 255,$title), true);
	$furl = new XoopsFormText(_AM_DEFACER_PAGE_URL, 'page_url', 50, 255,$url);
	$furl->setDescription(_AM_DEFACER_PAGE_URL_DESC);
	$form->addElement($furl, true);
	$form->addElement(new XoopsFormRadioYN(_AM_DEFACER_PAGE_DISPLAY, 'page_status', intval($status), _YES, _NO));

	$tray = new XoopsFormElementTray('' ,'');
	$tray->addElement(new XoopsFormButton('', 'page_button', _SUBMIT, 'submit'));

	$btn = new XoopsFormButton('', 'reset', _CANCEL, 'button');
	if (isset($id)){
		$btn->setExtra('onclick="document.location.href=\'admin_page.php?op=list\'"');
	}else{
		$btn->setExtra('onclick="document.getElementById(\'addpageform\').style.display = \'none\'; return false;"');
	}
	$tray->addElement($btn);
	$form->addElement($tray);

	if (isset($id)){
		$form->addElement(new XoopsFormHidden('op', 'editpageok'));
		$form->addElement(new XoopsFormHidden('page_id', $id));
	}else{
		$form->addElement(new XoopsFormHidden('op', 'addpage'));
	}

	return $form->render();
}
?>
