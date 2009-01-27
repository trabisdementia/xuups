<?php
//  Author: The ImpressCMS Project & TheRplima & Trabis
//  URL: http://www.impresscms.org/ & http://www.xuups.com
//  E-Mail: therplima@impresscms.org & lusopoemas@gmail.com

require 'admin_header.php';

if (!empty($_POST)) foreach ($_POST as $k => $v) ${$k} = $v;
if (!empty($_GET)) foreach ($_GET as $k => $v) ${$k} = $v;
$op = (isset($_GET['op']))?trim($_GET['op']):((isset($_POST['op']))?trim($_POST['op']):'list');
$meta_id = (isset($_GET['meta_id']))?intval($_GET['meta_id']):(isset($_POST['meta_id'])?intval($_POST['meta_id']):0);
$limit = (isset($_GET['limit']))?intval($_GET['limit']):(isset($_POST['limit'])?intval($_POST['limit']):15);
$start = (isset($_GET['start']))?intval($_GET['start']):(isset($_POST['start'])?intval($_POST['start']):0);
$redir = (isset($_GET['redir']))?$_GET['redir']:(isset($_POST['redir'])?$_POST['redir']:null);

switch ($op){
    case 'list':
        xoops_cp_header();
        defacer_adminmenu(2);
        echo metas_index($start);
        xoops_cp_footer();
        break;
    case 'addmeta':
        metas_addmeta();
        break;
    case 'editmeta':
        xoops_cp_header();
        defacer_adminmenu(2);
        echo metaform($meta_id);
        xoops_cp_footer();
        break;
    case 'editmetaok':
        metas_editmeta($meta_id);
        break;
    case 'delmeta':
        metas_confirmdelmeta($meta_id,$redir);
        break;
    case 'delmetaok':
        metas_delmeta($meta_id,$redir);
        break;
}

function metas_index($start=0){
	global $xoopsTpl,$xoopsUser,$xoopsConfig,$limit;

	include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';

	$meta_handler =& xoops_getmodulehandler('meta','defacer');
	$page_handler =& xoops_getmodulehandler('page','defacer');
	$module_handler =& xoops_gethandler('module');

	$metacount = $meta_handler->getCount();
	$xoopsTpl->assign('metacount',$metacount);
	$criteria = new CriteriaCompo();
	$criteria->setStart($start);
	$criteria->setLimit($limit);
	$metas = $meta_handler->getObjects($criteria);

	if ($metacount > 0){
		if ($metacount > $limit) {
			include_once XOOPS_ROOT_PATH.'/class/metanav.php';
			$nav = new XoopsmetaNav($metacount, $limit, $start, 'start', 'op=list');
			$xoopsTpl->assign('pag','<div style="float:left; padding-top:2px;" align="center">'.$nav->renderNav().'</div>');
		}else{
			$xoopsTpl->assign('pag','');
		}
	}else{
		$xoopsTpl->assign('pag','');
	}

	foreach ($metas as $meta){
		$pag = array();

		$pag['meta_id'] = $meta->getVar('meta_id');
		$pag['meta_sitename'] = $meta->getVar('meta_sitename');
		$pag['meta_pagetitle'] = $meta->getVar('meta_pagetitle');
		$pag['meta_slogan'] = $meta->getVar('meta_slogan');
		$pag['meta_keywords'] = $meta->getVar('meta_keywords');
		$pag['meta_description'] = $meta->getVar('meta_description');
		
		$page = $page_handler->get($meta->getVar('meta_id'));
        $mod = $module_handler->get($page->getVar('page_moduleid'));
        if (!is_object($mod)) continue;
		$pag['module'] = $mod->getVar('name');
		$pag['meta_title'] = $page->getVar('page_title');
		$pag['meta_url'] = $page->getVar('page_url');
		if (substr($page->getVar('page_url'),-1) == '*'){
			$pag['meta_vurl'] = 0;
		}else{
			if (substr($page->getVar('page_url'),0,7) == 'http://'){
				$pag['meta_vurl'] = $page->getVar('page_url');
			}else{
				$pag['meta_vurl'] = XOOPS_URL.'/'.$page->getVar('page_url');
			}
		}
		$pag['meta_status'] = $page->getVar('page_status');
		$xoopsTpl->append('metas',$pag);
	}
	$xoopsTpl->assign('addmetaform',metaform());

	return $xoopsTpl->fetch('db:defacer_admin_meta.html');
}

function metas_addmeta() {
	if (!$GLOBALS['xoopsSecurity']->check()) {
		redirect_header('admin_meta.php', 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
	}

	$meta_handler =& xoops_getmodulehandler('meta','defacer');
	$criteria =  new Criteria('meta_id', $_POST['meta_id']);
	$metacount = $meta_handler->getCount($criteria);
	if ($metacount > 0) {
        $meta = $meta_handler->get($_POST['meta_id']);
    }  else {
        $meta = $meta_handler->create();
    }
    $meta->setVars($_POST);
	if (!$meta_handler->insert($meta)){
		$msg = _AM_DEFACER_ERROR;
	}else{
		$msg = _AM_DEFACER_DBUPDATED;
	}

	redirect_header('admin_meta.php?op=list',2,$msg);
}

function metas_editmeta($meta_id) {
	if (!$GLOBALS['xoopsSecurity']->check()) {
		redirect_header('admin_meta.php', 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
	}
	$meta_handler =& xoops_getmodulehandler('meta','defacer');
	$meta = $meta_handler->get($meta_id);

	$meta->setVars($_POST);
	if (!$meta_handler->insert($meta)){
		$msg = _AM_DEFACER_ERROR;
	}else{
		$msg = _AM_DEFACER_DBUPDATED;
	}

	redirect_header('admin_meta.php?op=list',2,$msg);
}

function metas_delmeta($meta_id,$redir=null) {
	if (!$GLOBALS['xoopsSecurity']->check()) {
		redirect_header('admin_meta.php',1, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
	}
	if ($meta_id <= 0) {
		redirect_header('admin_meta.php',1);
	}
	$meta_handler =& xoops_getmodulehandler('meta','defacer');
	$meta = $meta_handler->get($meta_id);
	if (!is_object($meta)) {
		redirect_header('admin_meta.php',1);
	}

	if (!$meta_handler->delete($meta)) {
		xoops_cp_header();
		xoops_error(sprintf(_AM_DEFACER_ERROR, $meta->getVar('meta_id')));
		xoops_cp_footer();
		exit();
	}

	redirect_header((!is_null($redir))?base64_decode($redir):'admin_meta.php',2,_AM_DEFACER_DBUPDATED);
}

function metas_confirmdelmeta($meta_id,$redir=null){
	global $xoopsConfig;

	$meta_handler =& xoops_getmodulehandler('meta','defacer');
	$meta = $meta_handler->get($meta_id);

/*	if ($xoopsConfig['startmeta'] == $meta->getVar('meta_moduleid').'-'.$meta->getVar('meta_id')){ //Selected meta is the start meta of the site
		redirect_header((!is_null($redir))?base64_decode($redir).'&canceled=1':'admin_meta.php?op=list',5,_AM_DEFACER_DELSTARTMETA);
	}else{  */
		xoops_cp_header();
		$arr = array();
		$arr['op'] = 'delmetaok';
		$arr['meta_id'] = $meta_id;
		$arr['fct'] = 'metas';
		if (!is_null($redir)){
			$arr['redir'] = $redir;
		}
		xoops_confirm($arr, 'admin_meta.php', _AM_DEFACER_RUDEL);
		xoops_cp_footer();
//	}
}

function metaform($id=null){
	global $xoopsUser, $xoopsConfig, $meta_id;
	include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';

    $meta_handler =& xoops_getmodulehandler('meta','defacer');
	$page_handler =& xoops_getmodulehandler('page','defacer');
	
 if (isset($id)) $meta = $meta_handler->get($id);
	if (@is_object($meta)){
		$ftitle = _EDIT;
        $meta_id = $meta->getVar('meta_id');
        $meta_sitename = $meta->getVar('meta_sitename');
        $meta_pagetitle = $meta->getVar('meta_pagetitle');
        $meta_slogan = $meta->getVar('meta_slogan');
        $meta_keywords = $meta->getVar('meta_keywords');
        $meta_description = $meta->getVar('meta_description');
	}else{
		$ftitle = _ADD;
        $meta_sitename = '';
        $meta_pagetitle = '';
        $meta_slogan = '';
        $meta_keywords = '';
        $meta_description = '';
	}

	$form = new XoopsThemeForm($ftitle, 'meta_form', 'admin_meta.php', "post", true);

	$page_select = new XoopsFormSelect(_AM_DEFACER_PAGE, 'meta_id', $meta_id);
	$page_select->customValidationCode[] = 'var value = document.getElementById(\'meta_id\').value; if (value == 0){alert("'._AM_DEFACER_SELECTPAGE_ERR.'"); return false;}';

	$criteria = new CriteriaCompo(new Criteria('page_status', 1));
	$pageslist = $page_handler->getList($criteria);
	$list = array('0'=>'--------------------------');
	$pageslist = $list+$pageslist;
	$page_select->addOptionArray($pageslist);
	$form->addElement($page_select,true);

    $form->addElement(new XoopsFormText(_AM_DEFACER_META_SITENAME,'meta_sitename', 50, 50, $meta_sitename));
	$form->addElement(new XoopsFormText(_AM_DEFACER_META_SLOGAN,'meta_slogan', 50, 50, $meta_slogan));
	$form->addElement(new XoopsFormText(_AM_DEFACER_META_PAGETITLE,'meta_pagetitle', 50, 50, $meta_pagetitle));
	$form->addElement(new XoopsFormTextArea(_AM_DEFACER_META_KEYWORDS,'meta_keywords' , $meta_keywords));
	$form->addElement(new XoopsFormTextArea(_AM_DEFACER_META_DESCRIPTION,'meta_description' , $meta_description));

	$tray = new XoopsFormElementTray('' ,'');
	$tray->addElement(new XoopsFormButton('', 'meta_button', _SUBMIT, 'submit'));

	$btn = new XoopsFormButton('', 'reset', _CANCEL, 'button');
	if (@is_object($meta)){
		$btn->setExtra('onclick="document.location.href=\'admin_meta.php?op=list\'"');
	}else{
		$btn->setExtra('onclick="document.getElementById(\'addmetaform\').style.display = \'none\'; return false;"');
	}
	$tray->addElement($btn);
	$form->addElement($tray);

	if (@is_object($meta)){
		$form->addElement(new XoopsFormHidden('op', 'editmetaok'));
		$form->addElement(new XoopsFormHidden('meta_id', $id));
	}else{
		$form->addElement(new XoopsFormHidden('op', 'addmeta'));
	}

	return $form->render();
}

?>
