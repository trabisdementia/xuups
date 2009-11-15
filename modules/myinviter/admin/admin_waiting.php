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
 * @copyright       The XUUPS Project http://www.xuups.com
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Myinviter
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: admin_waiting.php 0 2009-11-14 18:47:04Z trabis $
 */

include_once dirname(__FILE__) . '/admin_header.php';

$op = isset($_GET['op']) ? trim($_GET['op']) : (isset($_POST['op']) ? trim($_POST['op']) : 'list');
$op = isset($_POST['sendpack']) ? 'sendpack' : $op;
$op = isset($_POST['delall']) ? 'delall' : $op;
$op = isset($_POST['reset']) ? 'reset' : $op;

$id = isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['id']) ? intval($_POST['id']) : null);

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : (isset($_POST['limit']) ? intval($_POST['limit']) : 15);
$start = isset($_GET['start']) ? intval($_GET['start']) : (isset($_POST['start']) ? intval($_POST['start']) : 0);
$redir = isset($_GET['redir']) ? $_GET['redir'] : (isset($_POST['redir']) ? $_POST['redir'] : null);

switch ($op){
    case 'reset':
        waiting_reset();
        break;
    case 'send':
        waiting_send($id);
        break;
    case 'sendpack':
        waiting_send();
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
    case 'list':
    default:
        xoops_cp_header();
        myinviter_adminMenu(1, _MI_MYINV_ADMENU_WAITING);
        echo waiting_index($start);
        xoops_cp_footer();
        break;
}

function waiting_index($start = 0)
{
    global $xoopsTpl, $limit;

    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    include_once XOOPS_ROOT_PATH . '/modules/myinviter/include/functions.php';

    $this_handler = xoops_getModuleHandler('waiting', 'myinviter');

    $count = $this_handler->getCount();
    $xoopsTpl->assign('count', $count);
    $xoopsTpl->assign('sent', myinviter_getEmailsSent());

    if ($count > 0) {
        if ($count > $limit) {
            include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
            $nav = new XoopsPageNav($count, $limit, $start, 'start', 'op=list');
            $xoopsTpl->assign('pag', '<div style="float:left; padding-top:2px;" align="center">' . $nav->renderNav() . '</div>');
        } else {
            $xoopsTpl->assign('pag', '');
        }

        $criteria = new CriteriaCompo();
        $criteria->setSort('wt_date');
        $criteria->setOrder('ASC');
        $criteria->setStart($start);
        $criteria->setLimit($limit);
        $objs = $this_handler->getObjects($criteria);
        foreach ($objs as $obj) {
            $objArray = $obj->getValues();
            $objArray['wt_date'] = formatTimestamp($objArray['wt_date']);
            $xoopsTpl->append('objs', $objArray);
            unset($objArray);
        }
        unset($criteria, $objs);
    } else {
        $xoopsTpl->assign('pag', '');
    }

    return $xoopsTpl->fetch(XOOPS_ROOT_PATH . '/modules/myinviter/templates/static/myinviter_admin_waiting.html');
}

function waiting_del($id, $redir = null)
{
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header('admin_waiting.php',1, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
    }

    if ($id <= 0) {
        redirect_header('admin_waiting.php',1);
    }

    $this_handler = xoops_getModuleHandler('waiting' , 'myinviter');
    $obj = $this_handler->get($id);
    if (!is_object($obj)) {
        redirect_header('admin_waiting.php', 1);
    }

    if (!$this_handler->delete($obj)) {
        xoops_cp_header();
        xoops_error(_AM_MYINV_ERROR, $obj->getVar('id'));
        xoops_cp_footer();
        exit();
    }

    redirect_header(!is_null($redir) ? base64_decode($redir) : 'admin_waiting.php' , 2, _AM_MYINV_SUCCESS);
}

function waiting_delall($redir = null)
{
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header('admin_waiting.php',1, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
    }

    $this_handler = xoops_getModuleHandler('waiting' , 'myinviter');

    if (!$this_handler->deleteAll()) {
        redirect_header(!is_null($redir) ? base64_decode($redir) : 'admin_waiting.php' , 2, _AM_MYINV_ERROR);
    }

    redirect_header(!is_null($redir) ? base64_decode($redir) : 'admin_waiting.php' , 2, _AM_MYINV_SUCCESS);
}

function waiting_confirmdel($id = null, $redir = null, $op = 'delok')
{
    $arr = array();
    $arr['op'] = $op;
    $arr['id'] = $id;
    if (!is_null($redir)){
        $arr['redir'] = $redir;
    }

    xoops_cp_header();
    xoops_confirm($arr, 'admin_waiting.php', _AM_MYINV_AYS);
    xoops_cp_footer();
}

function waiting_send($id = null)
{
    include_once XOOPS_ROOT_PATH . '/modules/myinviter/include/functions.php';
    $errors = myinviter_sendEmails($id, true);
    if (count($errors) > 0) {
        $message = '<br />';
        foreach ($errors as $error) {
            $message .= is_array($error) ? implode('<br />', $error) : '<br />' . $error;
        }
        redirect_header('admin_waiting.php', 4, sprintf(_AM_MYINV_ERRORS, $message));
        exit();
    } else {
        redirect_header('admin_waiting.php', 1, _AM_MYINV_DONE);
        exit();
    }
}

function waiting_reset()
{
    include_once XOOPS_ROOT_PATH . '/modules/myinviter/include/functions.php';
    myinviter_setEmailsSent(0);
    redirect_header('admin_waiting.php', 1, _AM_MYINV_DONE);
    exit();
}

?>