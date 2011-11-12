<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

require dirname(__FILE__) . '/admin_header.php';

$op = isset($_GET['op']) ? trim($_GET['op']) : (isset($_POST['op']) ? trim($_POST['op']) : 'list');
$op = isset($_POST['delall']) ? 'delall' : $op;

$id = isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['id']) ? intval($_POST['id']) : null);

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : (isset($_POST['limit']) ? intval($_POST['limit']) : 15);
$start = isset($_GET['start']) ? intval($_GET['start']) : (isset($_POST['start']) ? intval($_POST['start']) : 0);
$redir = isset($_GET['redir']) ? $_GET['redir'] : (isset($_POST['redir']) ? $_POST['redir'] : null);

switch ($op) {
    case 'list':
        xoops_cp_header();
        subscribers_adminMenu(2, _MI_SUBSCRIBERS_ADMENU_WAITING);
        echo waiting_index($start);
        xoops_cp_footer();
        break;
    case 'del':
        waiting_confirmdel($id, $redir);
        break;
    case 'delok':
        waiting_del($id, $redir);
        break;
    case 'delall':
        waiting_confirmdel(null, $redir, 'delallok');
        break;
    case 'delallok':
        waiting_delall($redir);
        break;
}

function waiting_index($start = 0)
{
    global $xoopsTpl, $xoopsUser, $xoopsConfig, $limit;

    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    include_once XOOPS_ROOT_PATH . '/modules/subscribers/include/functions.php';

    subscribers_sendEmails();

    $this_handler =& xoops_getModuleHandler('waiting', 'subscribers');

    $count = $this_handler->getCount();
    $xoopsTpl->assign('count', $count);

    $criteria = new CriteriaCompo();
    $criteria->setSort('wt_priority DESC, wt_created');
    $criteria->setOrder('ASC');
    $criteria->setStart($start);
    $criteria->setLimit($limit);
    $objs = $this_handler->getObjects($criteria);

    if ($count > 0){
        if ($count > $limit) {
            include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
            $nav = new XoopsPageNav($count, $limit, $start, 'start', 'op=list');
            $xoopsTpl->assign('pag', '<div style="float:left; padding-top:2px;" align="center">' . $nav->renderNav() . '</div>');
        }else{
            $xoopsTpl->assign('pag', '');
        }
    }else{
        $xoopsTpl->assign('pag', '');
    }

    include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
    $countries = XoopsLists::getCountryList();

    foreach ($objs as $obj){
        $objArray = $obj->toArray();
        $objArray['wt_created'] = formatTimestamp($objArray['wt_created']);
        $xoopsTpl->append('objs', $objArray);
        unset($objArray);
    }

    return $xoopsTpl->fetch(XOOPS_ROOT_PATH . '/modules/subscribers/templates/static/subscribers_admin_waiting.html');
}

function waiting_del($id, $redir = null)
{
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header('admin_waiting.php',1, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
    }

    if ($id <= 0) {
        redirect_header('admin_waiting.php',1);
    }

    $this_handler =& xoops_getModuleHandler('waiting' , 'subscribers');
    $obj = $this_handler->get($id);
    if (!is_object($obj)) {
        redirect_header('admin_waiting.php', 1);
    }

    if (!$this_handler->delete($obj)) {
        xoops_cp_header();
        xoops_error(_AM_SUBSCRIBERS_ERROR, $obj->getVar('id'));
        xoops_cp_footer();
        exit();
    }

    redirect_header(!is_null($redir) ? base64_decode($redir) : 'admin_waiting.php' , 2, _AM_SUBSCRIBERS_SUCCESS);
}

function waiting_delall($redir = null)
{
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header('admin_waiting.php',1, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
    }

    $this_handler =& xoops_getModuleHandler('waiting' , 'subscribers');

    if (!$this_handler->deleteAll()) {
        redirect_header(!is_null($redir) ? base64_decode($redir) : 'admin_waiting.php' , 2, _AM_SUBSCRIBERS_ERROR);
    }

    redirect_header(!is_null($redir) ? base64_decode($redir) : 'admin_waiting.php' , 2, _AM_SUBSCRIBERS_SUCCESS);
}

function waiting_confirmdel($id, $redir = null, $op = 'delok')
{
    global $xoopsConfig;

    $this_handler =& xoops_getModuleHandler('waiting' , 'subscribers');
    $obj = $this_handler->get($id);

    xoops_cp_header();

    $arr = array();
    $arr['op'] = $op;
    $arr['id'] = $id;
    if (!is_null($redir)){
        $arr['redir'] = $redir;
    }

    xoops_confirm($arr, 'admin_waiting.php', _AM_SUBSCRIBERS_AYS);

    xoops_cp_footer();
}
?>
