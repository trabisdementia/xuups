<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         myinviter
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id$
 */

include_once dirname(__FILE__) . '/admin_header.php';

$op = isset($_GET['op']) ? trim($_GET['op']) : (isset($_POST['op']) ? trim($_POST['op']) : 'list');
$op = isset($_POST['sendpack']) ? 'sendpack' : $op;
$op = isset($_POST['delall']) ? 'delall' : $op;
$op = isset($_POST['reset']) ? 'reset' : $op;
$op = isset($_POST['moveerrortowaiting']) ? 'moveerrortowaiting' : $op;
$op = isset($_POST['movenotsenttowaiting']) ? 'movenotsenttowaiting' : $op;
$op = isset($_POST['grabemails']) ? 'grabemails' : $op;

$id = Xmf_Request::getInt('id', null);
$limit = Xmf_Request::getInt('limit', 5);
$start = Xmf_Request::getInt('start', 0);
$redir = Xmf_Request::getInt('redir', null);

switch ($op) {
    case 'del':
        index_confirmdel($id, $redir);
        break;
    case 'delok':
        index_del($id, $redir);
        break;
    case 'delall':
        index_confirmdel(null, $redir, 'delallok');
        break;
    case 'delallok':
        index_delall($redir);
        break;
    case 'list':
    default:
        xoops_cp_header();
        $menu = new Xmf_Template_Adminmenu();
        $menu->display();
        $nav = new Xmf_Template_Adminnav();
        $nav->display();
        echo index_index($start);
        xoops_cp_footer();
        break;
}

function index_index($start = 0)
{
    global $xoopsTpl, $limit;

    $this_handler = $GLOBALS['log']->getHandler('item');
    $count = $this_handler->getCount();

    $xoopsTpl->assign('count', $count);

    if ($count > 0) {
        if ($count > $limit) {
            include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
            $nav = new XoopsPageNav($count, $limit, $start, 'start', 'op=list');
            $xoopsTpl->assign('pag', '<div style="float:left; padding-top:2px;" align="center">' . $nav->renderNav() . '</div>');
        } else {
            $xoopsTpl->assign('pag', '');
        }
        $criteria = new CriteriaCompo();
        $criteria->setLimit($limit);
        $criteria->setStart($start);
        $criteria->setSort('time');
        $criteria->setOrder('DESC');
        $objs = $this_handler->getObjects($criteria);
        $xoopsTpl->assign('objs', $this_handler->render($objs));
        unset($objs);
    } else {
        $xoopsTpl->assign('pag', '');
    }

    return $xoopsTpl->fetch(XOOPS_ROOT_PATH . '/modules/log/templates/log_admin_index.html');
}

function index_del($id, $redir = null)
{
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header('index.php',1, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
    }

    if ($id <= 0) {
        redirect_header('index.php',1);
    }

    $this_handler = $GLOBALS['log']->getHandler('item');
    $obj = $this_handler->get($id);
    if (!is_object($obj)) {
        redirect_header('index.php', 1);
    }

    if (!$this_handler->delete($obj)) {
        xoops_cp_header();
        xoops_error(_AM_LOG_ERROR, $obj->getVar('id'));
        xoops_cp_footer();
        exit();
    }

    redirect_header(!is_null($redir) ? base64_decode($redir) : 'index.php' , 2, _AM_LOG_SUCCESS);
}

function index_delall($redir = null)
{
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header('index.php',1, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
    }

    if (!$GLOBALS['log']->getHandler('item')->deleteAll()) {
        redirect_header(!is_null($redir) ? base64_decode($redir) : 'index.php' , 2, _AM_LOG_ERROR);
    }

    redirect_header(!is_null($redir) ? base64_decode($redir) : 'index.php' , 2, _AM_LOG_SUCCESS);
}

function index_confirmdel($id = null, $redir = null, $op = 'delok')
{
    $arr = array();
    $arr['op'] = $op;
    $arr['id'] = $id;
    if (!is_null($redir)){
        $arr['redir'] = $redir;
    }

    xoops_cp_header();
    xoops_confirm($arr, 'index.php', _AM_LOG_AYS);
    xoops_cp_footer();
}