<?php
//  Author: The ImpressCMS Project & TheRplima & Trabis
//  URL: http://www.impresscms.org/ & http://www.xuups.com
//  E-Mail: therplima@impresscms.org & lusopoemas@gmail.com

require 'admin_header.php';

if (!empty($_POST)) foreach ($_POST as $k => $v) ${$k} = $v;
if (!empty($_GET)) foreach ($_GET as $k => $v) ${$k} = $v;
$op = (isset($_GET['op']))?trim($_GET['op']):((isset($_POST['op']))?trim($_POST['op']):'list');
$permission_id = (isset($_GET['permission_id']))?intval($_GET['permission_id']):(isset($_POST['permission_id'])?intval($_POST['permission_id']):0);
$limit = (isset($_GET['limit']))?intval($_GET['limit']):(isset($_POST['limit'])?intval($_POST['limit']):15);
$start = (isset($_GET['start']))?intval($_GET['start']):(isset($_POST['start'])?intval($_POST['start']):0);
$redir = (isset($_GET['redir']))?$_GET['redir']:(isset($_POST['redir'])?$_POST['redir']:null);

switch ($op){
    case 'list':
        xoops_cp_header();
        defacer_adminmenu(3);
        echo permissions_index($start);
        xoops_cp_footer();
        break;
    case 'addpermission':
        permissions_addpermission();
        break;
    case 'editpermission':
        xoops_cp_header();
        defacer_adminmenu(3);
        echo permissionform($permission_id);
        xoops_cp_footer();
        break;
    case 'editpermissionok':
        permissions_editpermission($permission_id);
        break;
    case 'delpermission':
        permissions_confirmdelpermission($permission_id,$redir);
        break;
    case 'delpermissionok':
        permissions_delpermission($permission_id,$redir);
        break;
}

function permissions_index($start=0){
	global $xoopsTpl,$xoopsUser,$xoopsConfig,$limit;

	include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
	
	$grouplist_handler = xoops_gethandler('group');
    $grouplist = $grouplist_handler->getObjects(null, true);
    foreach (array_keys($grouplist) as $i) {
        $groups[$i] = $grouplist[$i]->getVar('name');
    }
    $xoopsTpl->assign('groups', $groups);

	$permission_handler =& xoops_getmodulehandler('permission','defacer');
	$page_handler =& xoops_getmodulehandler('page','defacer');
	$module_handler =& xoops_gethandler('module');

	$permissioncount = $permission_handler->getCount();
	$xoopsTpl->assign('permissioncount',$permissioncount);
    $criteria = new CriteriaCompo();
    $criteria->setStart($start);
	$criteria->setLimit($limit);
	$permissions = $permission_handler->getObjects($criteria);

	if ($permissioncount > 0){
		if ($permissioncount > $limit) {
			include_once XOOPS_ROOT_PATH.'/class/permissionnav.php';
			$nav = new XoopspermissionNav($permissioncount, $limit, $start, 'start', 'op=list');
			$xoopsTpl->assign('pag','<div style="float:left; padding-top:2px;" align="center">'.$nav->renderNav().'</div>');
		}else{
			$xoopsTpl->assign('pag','');
		}
	}else{
		$xoopsTpl->assign('pag','');
	}

	foreach ($permissions as $permission){
		$pag = array();
		
		$pag['permission_id'] = $permission->getVar('permission_id');
		$pag['permission_groups'] = $permission->getVar('permission_groups');
		$page = $page_handler->get($permission->getVar('permission_id'));
        $mod = $module_handler->get($page->getVar('page_moduleid'));
        if (!is_object($mod)) continue;
		$pag['module'] = $mod->getVar('name');
		$pag['permission_title'] = $page->getVar('page_title');
		$pag['permission_url'] = $page->getVar('page_url');
		if (substr($page->getVar('page_url'),-1) == '*'){
			$pag['permission_vurl'] = 0;
		}else{
			if (substr($page->getVar('page_url'),0,7) == 'http://'){
				$pag['permission_vurl'] = $page->getVar('page_url');
			}else{
				$pag['permission_vurl'] = XOOPS_URL.'/'.$page->getVar('page_url');
			}
		}
		$pag['permission_status'] = $page->getVar('page_status');
		$xoopsTpl->append('permissions',$pag);
	}
	$xoopsTpl->assign('addpermissionform',permissionform());

	return $xoopsTpl->fetch('db:defacer_admin_permission.html');
}

function permissions_addpermission() {
	if (!$GLOBALS['xoopsSecurity']->check()) {
		redirect_header('admin_permission.php', 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
	}

	$permission_handler =& xoops_getmodulehandler('permission','defacer');
	$criteria =  new Criteria('permission_id', $_POST['permission_id']);
	$permissioncount = $permission_handler->getCount($criteria);
	if ($permissioncount > 0) {
        $permission = $permission_handler->get($_POST['permission_id']);
    }  else {
        $permission = $permission_handler->create();
    }
    $permission->setVars($_POST);
	if (!$permission_handler->insert($permission)){
		$msg = _AM_DEFACER_ERROR;
	}else{
		$msg = _AM_DEFACER_DBUPDATED;
	}

	redirect_header('admin_permission.php?op=list',2,$msg);
}

function permissions_editpermission($permission_id) {
	if (!$GLOBALS['xoopsSecurity']->check()) {
		redirect_header('admin_permission.php', 3, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
	}
	$permission_handler =& xoops_getmodulehandler('permission','defacer');
	$permission = $permission_handler->get($permission_id);

	$permission->setVars($_POST);
	if (!$permission_handler->insert($permission)){
		$msg = _AM_DEFACER_ERROR;
	}else{
		$msg = _AM_DEFACER_DBUPDATED;
	}

	redirect_header('admin_permission.php?op=list',2,$msg);
}

function permissions_delpermission($permission_id,$redir=null) {
	if (!$GLOBALS['xoopsSecurity']->check()) {
		redirect_header('admin_permission.php',1, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
	}
	if ($permission_id <= 0) {
		redirect_header('admin_permission.php',1);
	}
	$permission_handler =& xoops_getmodulehandler('permission','defacer');
	$permission = $permission_handler->get($permission_id);
	if (!is_object($permission)) {
		redirect_header('admin_permission.php',1);
	}

	if (!$permission_handler->delete($permission)) {
		xoops_cp_header();
		xoops_error(sprintf(_AM_DEFACER_ERROR, $permission->getVar('permission_id')));
		xoops_cp_footer();
		exit();
	}

	redirect_header((!is_null($redir))?base64_decode($redir):'admin_permission.php',2,_AM_DEFACER_DBUPDATED);
}

function permissions_confirmdelpermission($permission_id,$redir=null){
	global $xoopsConfig;

	$permission_handler =& xoops_getmodulehandler('permission','defacer');
	$permission = $permission_handler->get($permission_id);

	/*if ($xoopsConfig['startpermission'] == $permission->getVar('permission_moduleid').'-'.$permission->getVar('permission_id')){ //Selected permission is the start permission of the site
		redirect_header((!is_null($redir))?base64_decode($redir).'&canceled=1':'admin_permission.php?op=list',5,_AM_DEFACER_DELSTARTPERMISSION);
	}else{      */
		xoops_cp_header();
		$arr = array();
		$arr['op'] = 'delpermissionok';
		$arr['permission_id'] = $permission_id;
		$arr['fct'] = 'permissions';
		if (!is_null($redir)){
			$arr['redir'] = $redir;
		}
		xoops_confirm($arr, 'admin_permission.php', _AM_DEFACER_RUDELPERMISSION);
		xoops_cp_footer();
	//}
}

function permissionform($id=null){
	global $xoopsUser, $xoopsConfig, $permission_id;
	include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';

    $permission_handler =& xoops_getmodulehandler('permission','defacer');
	$page_handler =& xoops_getmodulehandler('page','defacer');

    if (isset($id)) $permission = $permission_handler->get($id);
	if (@is_object($permission)){
		$ftitle = _EDIT;
        $permission_id = $permission->getVar('permission_id');
        $permission_groups = $permission->getVar('permission_groups');
	}else{
		$ftitle = _ADD;
		$permission_groups = array(XOOPS_GROUP_ANONYMOUS, XOOPS_GROUP_USERS);
	}

	$form = new XoopsThemeForm($ftitle, 'permission_form', 'admin_permission.php', "post", true);

	$page_select = new XoopsFormSelect(_AM_DEFACER_PAGE, 'permission_id', $permission_id);
	$page_select->customValidationCode[] = 'var value = document.getElementById(\'permission_id\').value; if (value == 0){alert("'._AM_DEFACER_SELECTPAGE_ERR.'"); return false;}';

	$criteria = new CriteriaCompo(new Criteria('page_status', 1));
	$pageslist = $page_handler->getList($criteria);
    $list = array('0'=>'--------------------------');
	$pageslist = $list+$pageslist;
	$page_select->addOptionArray($pageslist);
	$form->addElement($page_select,true);
	
    $form->addElement(new XoopsFormSelectGroup(_AM_DEFACER_PERMISSION_GROUPS, 'permission_groups', true, $permission_groups, 8, true));

	$tray = new XoopsFormElementTray('' ,'');
	$tray->addElement(new XoopsFormButton('', 'permission_button', _SUBMIT, 'submit'));

	$btn = new XoopsFormButton('', 'reset', _CANCEL, 'button');
	if (@is_object($permission)){
		$btn->setExtra('onclick="document.location.href=\'admin_permission.php?op=list\'"');
	}else{
		$btn->setExtra('onclick="document.getElementById(\'addpermissionform\').style.display = \'none\'; return false;"');
	}
	$tray->addElement($btn);
	$form->addElement($tray);

	if (@is_object($permission)){
		$form->addElement(new XoopsFormHidden('op', 'editpermissionok'));
		$form->addElement(new XoopsFormHidden('permission_id', $id));
	}else{
		$form->addElement(new XoopsFormHidden('op', 'addpermission'));
	}

	return $form->render();
}
?>
