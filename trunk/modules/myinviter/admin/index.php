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
 * @package         myinviter
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: index.php 0 2009-11-14 18:47:04Z trabis $
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
$limit = Xmf_Request::getInt('limit', 15);
$start = Xmf_Request::getInt('start', 0);
$redir = Xmf_Request::getInt('redir', null);

$session = $GLOBALS['myinviter']->getHelper('session');
if (!$status = $session->get('status')) {
    $status = MYINVITER_STATUS_WAITING;
}
$session->set('status', Xmf_Request::getInt('status', $status));

if (!$grabstart = $session->get('start')) {
    $grabstart = 1;
}
$session->set('start', Xmf_Request::getInt('grabstart', $grabstart));

if (!$grablimit = $session->get('limit')) {
    $grablimit = 3;
}
$session->set('limit', Xmf_Request::getInt('grablimit', $grablimit));

if (!$grabdomain = $session->get('domain')) {
    $grabdomain = 'www.yourlovelywebsite.com';
}
$session->set('domain', Xmf_Request::getString('grabdomain', $grabdomain));

if (!$grabprovider = $session->get('provider')) {
    $grabprovider = 'hotmail';
}
$session->set('provider', Xmf_Request::getString('grabprovider', $grabprovider));

switch ($op){
    case 'reset':
        index_reset();
        break;
    case 'send':
        index_send($id);
        break;
    case 'sendpack':
        index_send();
        break;
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
    case 'movenotsenttowaiting':
        index_movenotsenttowaiting();
        break;
   case 'moveerrortowaiting':
        index_moveerrortowaiting();
        break;
    case 'grabemails';
        xoops_cp_header();
        index_grabemails();
        $menu = new Xmf_Template_Adminmenu();
        $menu->display();
        echo index_index($start);
        xoops_cp_footer();
        break;
    case 'list':
    default:
        xoops_cp_header();
        $menu = new Xmf_Template_Adminmenu();
        $menu->display();
        echo index_index($start);
        xoops_cp_footer();
        break;
}

function index_grabemails()
{
    global $xoopsTpl;
    $emails_added = 0;
    $emails_notadded = 0;
    $session = $GLOBALS['myinviter']->getHelper('session');

    $i = $session->get('start');
    $limit = $i + $session->get('limit');
    $text = '';
    while ($i < $limit) {
        $b = $i * 10 + 1;
        $url = "http://es.search.yahoo.com/search?p=site:"
                . $session->get('domain')
                . "+%40"
                . $session->get('provider')
                . "&fr2=sb-top&fr=yfp-t-705&rd=r1&&pstart=1&b="
                . $b;
        $text .= strip_tags(file_get_contents_curl($url));

        $url = "http://www.bing.com/search?q=site:"
             . $session->get('domain')
             . "+%40"
             . $session->get('provider')
             . "&go=&filt=all&first="
             . $b;
        $text .= strip_tags(file_get_contents_curl($url));

        if ($i < 20) {
        $url = "http://www.google.com/m/?q=site:"
             . $session->get('domain')
             . "+%40"
             . $session->get('provider')
             . "&sa=N&start="
             . $b;
        $text .= strip_tags(file_get_contents_curl($url));
        }
        $i = $i + 1;
        sleep(1);
    }
    //echo $text;

    $this_handler = $GLOBALS['myinviter']->getHandler('item');
    // parse emails
    if (!empty($text)) {
        $res = preg_match_all(
            "/[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}/i",
            $text,
            $matches
        );

        if ($res) {
            foreach (array_unique($matches[0]) as $email) {
                $email = strtolower(trim($email));
                $email = str_replace($session->get('domain'), '', $email);
                if (myinviter_isValidEmail($email)) {
                    if (!$this_handler->emailExists($email)) {
                        $split = explode('@', $email);
                        $name = $split[0];
                        $obj = $this_handler->create();
                        $obj->setVar('name', $name);
                        $obj->setVar('userid', $GLOBALS['xoopsUser']->getVar('uid'));
                        $obj->setVar('email', $email);
                        $obj->setVar('date', time());
                        $this_handler->insertNotSent($obj);
                        $emails_added++;
                    } else {
                        $emails_notadded++;
                    }
                }
            }
        } else {
            $xoopsTpl->assign('emails_error', _AM_MYINVITER_EMAILS_NOTFOUND);
        }
    } else {
           $xoopsTpl->assign('emails_error', 'NO RESPONSE'/*_AM_MYINVITER_EMAILS_NOTFOUND*/);
    }

    $xoopsTpl->assign('emails_added', $emails_added);
    $xoopsTpl->assign('emails_notadded', $emails_notadded);
    $session->set('start', $limit);
    $session->set('status', MYINVITER_STATUS_NOTSENT);
}

function index_index($start = 0)
{
    global $xoopsTpl, $limit;

    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    include_once XOOPS_ROOT_PATH . '/modules/myinviter/include/functions.php';

    $this_handler = $GLOBALS['myinviter']->getHandler('item');
    $session = $GLOBALS['myinviter']->getHelper('session');
    $count = $this_handler->getCountByStatus($session->get('status'));

    $xoopsTpl->assign('count', $count);
    $xoopsTpl->assign('sent', myinviter_getEmailsSent());
    $xoopsTpl->assign('status', $session->get('status'));

    if ($count > 0) {
        if ($count > $limit) {
            include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
            $nav = new XoopsPageNav($count, $limit, $start, 'start', 'op=list');
            $xoopsTpl->assign('pag', '<div style="float:left; padding-top:2px;" align="center">' . $nav->renderNav() . '</div>');
        } else {
            $xoopsTpl->assign('pag', '');
        }
        $objs = $this_handler->getItems(null, $start, $limit, $session->get('status'));
        $xoopsTpl->assign('objs', $this_handler->toArray($objs));
        unset($objs);
    } else {
        $xoopsTpl->assign('pag', '');
    }

    $select = new XoopsFormSelect('', 'status', $session->get('status'));
    $select->addOption(MYINVITER_STATUS_WAITING, _AM_MYINVITER_STATUS_WAITING);
    $select->addOption(MYINVITER_STATUS_ERROR, _AM_MYINVITER_STATUS_ERROR);
    $select->addOption(MYINVITER_STATUS_BLACKLIST, _AM_MYINVITER_STATUS_BLACKLIST);
    $select->addOption(MYINVITER_STATUS_SENT, _AM_MYINVITER_STATUS_SENT);
    $select->addOption(MYINVITER_STATUS_NOTSENT, _AM_MYINVITER_STATUS_NOTSENT);
    $select->setExtra('onChange="document.form.submit()"');
    $xoopsTpl->assign('selectform', $select->render());

    $grabdomain = new XoopsFormText('', 'grabdomain', 50, 50, $session->get('domain'));
    $xoopsTpl->assign('domainform', $grabdomain->render());
    $grabprovider = new XoopsFormText('', 'grabprovider', 30, 30, $session->get('provider'));
    $xoopsTpl->assign('providerform', $grabprovider->render());
    $grabstart = new XoopsFormText('', 'grabstart', 3, 30, $session->get('start'));
    $xoopsTpl->assign('startform', $grabstart->render());
    $grablimit = new XoopsFormText('', 'grablimit', 3, 30, $session->get('limit'));
    $xoopsTpl->assign('limitform', $grablimit->render());

    return $xoopsTpl->fetch(XOOPS_ROOT_PATH . '/modules/myinviter/templates/myinviter_admin_index.html');
}

function index_del($id, $redir = null)
{
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header('index.php',1, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
    }

    if ($id <= 0) {
        redirect_header('index.php',1);
    }

    $this_handler = $GLOBALS['myinviter']->getHandler('item');
    $obj = $this_handler->get($id);
    if (!is_object($obj)) {
        redirect_header('index.php', 1);
    }

    if (!$this_handler->delete($obj)) {
        xoops_cp_header();
        xoops_error(_AM_MYINVITER_ERROR, $obj->getVar('id'));
        xoops_cp_footer();
        exit();
    }

    redirect_header(!is_null($redir) ? base64_decode($redir) : 'index.php' , 2, _AM_MYINVITER_SUCCESS);
}

function index_delall($redir = null)
{
    if (!$GLOBALS['xoopsSecurity']->check()) {
        redirect_header('index.php',1, implode('<br />', $GLOBALS['xoopsSecurity']->getErrors()));
    }

    if (!$GLOBALS['myinviter']->getHandler('item')->deleteAllByStatus($GLOBALS['myinviter']->getHelper('session')->get('status'))) {
        redirect_header(!is_null($redir) ? base64_decode($redir) : 'index.php' , 2, _AM_MYINVITER_ERROR);
    }

    redirect_header(!is_null($redir) ? base64_decode($redir) : 'index.php' , 2, _AM_MYINVITER_SUCCESS);
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
    xoops_confirm($arr, 'index.php', _AM_MYINVITER_AYS);
    xoops_cp_footer();
}

function index_send($id = null)
{
    $errors = myinviter_sendEmails($id, true);
    if (count($errors) > 0) {
        $message = '<br />';
        foreach ($errors as $error) {
            $message .= is_array($error) ? implode('<br />', $error) : '<br />' . $error;
        }
        redirect_header('index.php', 4, sprintf(_AM_MYINVITER_ERRORS, $message));
        exit();
    } else {
        redirect_header('index.php', 1, _AM_MYINVITER_DONE);
        exit();
    }
}

function index_reset()
{
    myinviter_setEmailsSent(0);
    redirect_header('index.php', 1, _AM_MYINVITER_DONE);
    exit();
}

function index_moveerrortowaiting()
{
    if ($GLOBALS['myinviter']->getHandler('item')->moveErrorToWaiting()) {
        $GLOBALS['myinviter']->getHelper('session')->set('status', MYINVITER_STATUS_WAITING);
        redirect_header('index.php', 1, _AM_MYINVITER_DONE);
        exit();
    } else {
        redirect_header('index.php', 1, _AM_MYINVITER_ERROR);
        exit();
    }
}

function index_movenotsenttowaiting()
{
    if ($GLOBALS['myinviter']->getHandler('item')->moveNotsentToWaiting()) {
        $GLOBALS['myinviter']->getHelper('session')->set('status',MYINVITER_STATUS_WAITING);
        redirect_header('index.php', 1, _AM_MYINVITER_DONE);
        exit();
    } else {
        redirect_header('index.php', 1, _AM_MYINVITER_ERROR);
        exit();
    }
}

function file_get_contents_curl($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
    curl_setopt($ch, CURLOPT_URL, $url);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}