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
 * @version         $Id: functions.php 0 2009-11-14 18:47:04Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

function myinviter_adminMenu($currentoption = 0, $breadcrumb = '')
{
    include XOOPS_ROOT_PATH . '/modules/myinviter/admin/menu.php';

    xoops_loadLanguage('admin', 'myinviter');
    xoops_loadLanguage('modinfo', 'myinviter');

    $tpl = new XoopsTpl();
    $tpl->assign(array(
        'modurl'          => XOOPS_URL . '/modules/myinviter',
        'headermenu'      => $myinviter_headermenu,
        'adminmenu'       => $myinviter_adminmenu,
        'current'         => $currentoption,
        'breadcrumb'      => $breadcrumb,
        'headermenucount' => count($myinviter_headermenu)));
    $tpl->display(XOOPS_ROOT_PATH . '/modules/myinviter/templates/static/myinviter_admin_menu.html');
}

function myinviter_getModuleHandler()
{
    static $handler;

    if (!isset($handler)) {
        global $xoopsModule;
        if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == 'myinviter') {
            $handler = $xoopsModule;
        } else {
            $hModule = xoops_gethandler('module');
            $handler = $hModule->getByDirname('myinviter');
        }
    }
    return $handler;
}

function myinviter_getModuleConfig()
{
    static $config;

    if (!$config) {
        global $xoopsModule;
        if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == 'myinviter') {
            $config = $GLOBALS['xoopsModuleConfig'];
        } else {
            $handler = myinviter_getModuleHandler();
            $hModConfig = xoops_gethandler('config');
            $config = $hModConfig->getConfigsByCat(0, $handler->getVar('mid'));
        }
    }
    return $config;
}

function myinviter_sendEmails($id = null, $force = false)
{
    global $xoopsConfig;

    $thisConfigs = myinviter_getModuleConfig();
    $errors = array();

    $emailsperpack = intval($thisConfigs['emailsperpack']);
    if ($emailsperpack == 0 && $id == null) {
        $errors[] = 'No id or no pack number';
        return $errors;
    }

    $timebpacks = intval($thisConfigs['timebpacks']);

    $now = time();
    $last = myinviter_getLastTime();

    if ((($now - $last) <= $timebpacks) && !$force) {
        $errors[] = 'Not enough time';
        return $errors;
    }

    $from = $thisConfigs['from']; //custom, system, user
    $html = $thisConfigs['html'];
    $sandbox = $thisConfigs['sandbox'];
    $sandboxemail = trim($thisConfigs['sandboxemail']);
    $defaultuid = intval($thisConfigs['defaultuid']);

    if (empty($sandboxemail)) {
        $sandboxemail = $xoopsConfig['adminmail'];
    }

    if ($from == 'custom') {
        $fromname = trim($thisConfigs['fromname']);
        $fromemail = trim($thisConfigs['fromemail']);
        if (empty($fromname) || empty($fromemail)) {
            $from = 'system';
        }
    }

    if ($from == 'system') {
        $fromname = $xoopsConfig['sitename'];
        $fromemail = $xoopsConfig['adminmail'];
    }

    $this_handler = xoops_getModuleHandler('waiting', 'myinviter');

    if ($id != null) {
        $id = new Criteria('wt_id', $id);
    }

    $criteria = new CriteriaCompo($id);
    $criteria->setSort('wt_date');
    $criteria->setOrder('ASC');
    $criteria->setLimit($emailsperpack);
    $objs = $this_handler->getObjects($criteria);
    $count = count($objs);
    unset ($criteria);

    if ($count == 0) {
        myinviter_setLastTime($now);
        $errors[] = 'No waiting emails';
        return $errors;
    }

    $member_handler = xoops_gethandler('member');
    $myts = MyTextSanitizer::getInstance();

    $obj_delete = array();
    foreach ($objs as $obj) {
        $thisUser = $member_handler->getUser($obj->getVar('wt_userid'));

        //Was this user removed? Then get the default one!
        if (!is_object($thisUser)) {
            $thisUser = $member_handler->getUser($defaultuid);
        }

        if (!is_object($thisUser)) {
            $errors[] = 'No default user';
            return $errors;
        }

        $xoopsMailer = xoops_getMailer();
        $xoopsMailer->useMail();
        $xoopsMailer->setTemplateDir(XOOPS_ROOT_PATH . '/modules/myinviter/language/' . $xoopsConfig['language'] . '/mail_template/');

        if ($html == 1) {
            $xoopsMailer->multimailer->ContentType = "text/html";
            $xoopsMailer->setTemplate('myinviter_invitation_html.tpl');
            $avatar = $thisUser->getVar('user_avatar');
            if ($avatar == 'blank.gif' || $avatar == '') {
                $avatar = XOOPS_URL . '/modules/myinviter/images/noavatar.gif';
            } else {
                $avatar = XOOPS_URL . '/uploads/' . $avatar;
            }
            $xoopsMailer->assign("USER_AVATAR", $avatar);
        } else {
            $xoopsMailer->setTemplate('myinviter_invitation.tpl');
        }

        if ($sandbox == 1) {
            $xoopsMailer->setToEmails(array($sandboxemail));
        } else {
            $xoopsMailer->setToEmails(array($obj->getVar('wt_email', 'n')));
        }

        if ($from == 'user') {
            $fromname = $thisUser->getVar('uname' , 'n');
            $fromemail = $thisUser->getVar('email' , 'n');
        }

        $xoopsMailer->setFromEmail($fromemail);
        $xoopsMailer->setFromName($fromname);

        xoops_loadLanguage('main' , 'myinviter');
        $xoopsMailer->setSubject(sprintf(_MA_MYINV_EMAIL_SUBJECT,  $thisUser->getVar('uname')));

        $xoopsMailer->assign("ADMINMAIL", $xoopsConfig['adminmail']);
        $xoopsMailer->assign("USER_UNAME", $thisUser->getVar('uname'));
        $xoopsMailer->assign("USER_UID", $thisUser->getVar('uid'));
        $xoopsMailer->assign("INVITED_NAME", $obj->getVar('wt_name'));

        $key = md5($obj->getVar('wt_email') . XOOPS_ROOT_PATH);
        $xoopsMailer->assign("BLACKLIST_URL", XOOPS_URL . '/modules/myinviter/blacklist.php?email=' . $obj->getVar('wt_email') . '&key=' . $key);

        if (!$xoopsMailer->send(true)) {
            $errors[] = $xoopsMailer->getErrors(false); // do not use html in error message
        } else {
            //All Ok? Set log
            /* $log_handler =& xoops_getmodulehandler('log', 'myinviter');
             $log = $log_handler->create();
             $log->setVar('log_userid',$thisUser->getVar('uid'));
             $log->setVar('log_date', time());
             $log_handler->insert($log);  */
        }

        unset($xoopsMailer);
        $obj_delete[] = $obj->getVar('wt_id');
    }

    $criteria = new Criteria('wt_id', '(' . implode(',', $obj_delete). ')', 'IN');
    $this_handler->deleteAll($criteria, true);

    myinviter_setLastTime($now);
    $lastcount = myinviter_getEmailsSent();
    myinviter_setEmailsSent($lastcount + $count);

    return $errors;
}

function myinviter_getLastTime()
{
    xoops_load('cache');
    $ret = XoopsCache::read('myinviter_lasttime');
    if ($ret == false) {
        $ret = time();
        myinviter_setLastTime($ret);
    }
    return $ret;
}

function myinviter_setLastTime($value = 0)
{
    xoops_load('cache');
    $ret = XoopsCache::write('myinviter_lasttime', $value);
    return $ret;
}

function myinviter_getEmailsSent()
{
    xoops_load('cache');
    $ret = XoopsCache::read('myinviter_emailssent');
    if ($ret == false) {
        $ret = 0;
        myinviter_setEmailsSent($ret);
    }
    return $ret;
}

function myinviter_setEmailsSent($value)
{
    xoops_load('cache');
    $ret = XoopsCache::write('myinviter_emailssent', $value);
    return $ret;
}

function myinviter_filterRegistered($contacts)
{
    $reg_emails = array();
    $user_handler = xoops_gethandler('user');
    $users = $user_handler->getAll(null, array('email', 'uname'), false, false);
    foreach ($users as $user) {
        $reg_emails[$user['email']] = $user;
    }
    foreach ($contacts as $key => $contact) {
        if (in_array($contact['email'], array_keys($reg_emails))) {
            $contacts[$key]['disabled'] =  sprintf(_MA_MYINV_ISREGISTERED, $reg_emails[$contact['email']]['uname']);
        }
    }
    unset($reg_emails, $users);
    return $contacts;
}

function myinviter_filterWaiting($contacts)
{
    $waiting_handler = xoops_getmodulehandler('waiting');
    $waiting_emails = $waiting_handler->getList();
    foreach ($contacts as $key => $contact) {
        if (in_array($contact['email'], $waiting_emails)) {
            $contacts[$key]['disabled'] = _MA_MYINV_ISWAITING;
        }
    }
    unset($waiting_emails);
    return $contacts;
}

function myinviter_filterBlacklisted($contacts)
{
    $blacklist_handler = xoops_getmodulehandler('blacklist');
    $blacklisted_emails = $blacklist_handler->getList();
    foreach ($contacts as $key => $contact) {
        if (in_array($contact['email'], $blacklisted_emails)) {
            $contacts[$key]['disabled'] = _MA_MYINV_ISBLACKLISTED;
        }
    }
    unset($blacklisted_emails);
    return $contacts;
}

?>