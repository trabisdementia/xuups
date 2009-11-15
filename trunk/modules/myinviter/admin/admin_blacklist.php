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
 * @version         $Id: admin_blacklist.php 0 2009-11-14 18:47:04Z trabis $
 */

require dirname(__FILE__) . '/admin_header.php';

$op = isset($_GET['op']) ? trim($_GET['op']) : (isset($_POST['op']) ? trim($_POST['op']) : 'list');
$id = isset($_GET['id']) ? intval($_GET['id']) : (isset($_POST['id']) ? intval($_POST['id']) : null);

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : (isset($_POST['limit']) ? intval($_POST['limit']) : 15);
$start = isset($_GET['start']) ? intval($_GET['start']) : (isset($_POST['start']) ? intval($_POST['start']) : 0);
$redir = isset($_GET['redir']) ? $_GET['redir'] : (isset($_POST['redir']) ? $_POST['redir'] : null);

switch ($op) {
    case 'list':
        xoops_cp_header();
        myinviter_adminMenu(2, _MI_MYINV_ADMENU_BLACKLIST);
        echo blacklist_index($start);
        xoops_cp_footer();
        break;
    case 'del':
        blacklist_confirmdel($id, $redir);
        break;
    case 'delok':
        blacklist_del($id, $redir);
        break;
}

function blacklist_index($start = 0)
{
    global $xoopsTpl, $limit;

    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    include_once XOOPS_ROOT_PATH . '/modules/myinviter/include/functions.php';

    $this_handler = xoops_getModuleHandler('blacklist', 'myinviter');

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
        $criteria->setSort('bl_date');
        $criteria->setOrder('DESC');
        $criteria->setStart($start);
        $criteria->setLimit($limit);
        $objs = $this_handler->getObjects($criteria);
        foreach ($objs as $obj) {
            $objArray = $obj->getValues();
            $objArray['bl_date'] = formatTimestamp($objArray['bl_date']);
            $xoopsTpl->append('objs', $objArray);
            unset($objArray);
        }
        unset($criteria, $objs);
    } else {
        $xoopsTpl->assign('pag', '');
    }

    return $xoopsTpl->fetch(XOOPS_ROOT_PATH . '/modules/myinviter/templates/static/myinviter_admin_blacklist.html');
}

function blacklist_del($id, $redir = null)
{
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header('admin_blacklist.php',1, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
    }

    if ($id <= 0) {
        redirect_header('admin_blacklist.php',1);
    }

    $this_handler = xoops_getModuleHandler('blacklist' , 'myinviter');
    $obj = $this_handler->get($id);
    if (!is_object($obj)) {
        redirect_header('admin_blacklist.php', 1);
    }

    if (!$this_handler->delete($obj)) {
        xoops_cp_header();
        xoops_error(_AM_MYINV_ERROR, $obj->getVar('id'));
        xoops_cp_footer();
        exit();
    }

    redirect_header(!is_null($redir) ? base64_decode($redir) : 'admin_blacklist.php' , 2, _AM_MYINV_SUCCESS);
}

function blacklist_confirmdel($id, $redir = null)
{
    $this_handler = xoops_getModuleHandler('blacklist' , 'myinviter');
    $obj = $this_handler->get($id);

    $arr = array();
    $arr['op'] = 'delok';
    $arr['id'] = $id;
    if (!is_null($redir)){
        $arr['redir'] = $redir;
    }

    xoops_cp_header();
    xoops_confirm($arr, 'admin_blacklist.php', _AM_MYINV_AYS);
    xoops_cp_footer();
}
?>