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

function myinviter_isValidEmail($email)
{
        return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
}

function myinviter_sendEmails($id = null, $force = false)
{
    global $xoopsConfig;

    $errors = array();
    $sent = 0;

    $emailsperpack = intval($GLOBALS['myinviter']->getConfig('emailsperpack'));
    if ($emailsperpack == 0 && $id == null) {
        $errors[] = 'No id or no pack number';
        return $errors;
    }

    $timebpacks = intval($GLOBALS['myinviter']->getConfig('timebpacks'));

    $now = time();
    $last = myinviter_getLastTime();
    if ((($now - $last) <= $timebpacks) && !$force) {
        $errors[] = 'Not enough time';
        return $errors;
    }

    $from = $GLOBALS['myinviter']->getConfig('from'); //custom, system, user
    $html = $GLOBALS['myinviter']->getConfig('html');
    $sandbox = $GLOBALS['myinviter']->getConfig('sandbox');
    $sandboxemail = trim($GLOBALS['myinviter']->getConfig('sandboxemail'));
    $defaultuid = intval($GLOBALS['myinviter']->getConfig('defaultuid'));

    if (empty($sandboxemail)) {
        $sandboxemail = $xoopsConfig['adminmail'];
    }

    if ($from == 'custom') {
        $fromname = trim($GLOBALS['myinviter']->getConfig('fromname'));
        $fromemail = trim($GLOBALS['myinviter']->getConfig('fromemail'));
        if (empty($fromname) || empty($fromemail)) {
            $from = 'system';
        }
    }

    if ($from == 'system') {
        $fromname = $xoopsConfig['sitename'];
        $fromemail = $xoopsConfig['adminmail'];
    }

    $this_handler = $GLOBALS['myinviter']->getHandler('item');
    $objs = $this_handler->getWaitingObjects($id, 0,$emailsperpack);

    if (count($objs) == 0) {
        myinviter_setLastTime($now);
        $errors[] = 'No waiting emails';
        return $errors;
    }

    $member_handler = xoops_gethandler('member');
    foreach ($objs as $obj) {
        $thisUser = $member_handler->getUser($obj->getVar('userid'));

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
        $xoopsMailer->setTemplateDir(XOOPS_ROOT_PATH . '/modules/myinviter/language/');

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
            $xoopsMailer->setToEmails(array($obj->getVar('email', 'n')));
        }

        if ($from == 'user') {
            $fromname = $thisUser->getVar('uname', 'n');
            $fromemail = $thisUser->getVar('email', 'n');
        }

        $xoopsMailer->setFromEmail($fromemail);
        $xoopsMailer->setFromName($fromname);

        xoops_loadLanguage('main', 'myinviter');
        $xoopsMailer->setSubject(sprintf(_MA_MYINVITER_EMAIL_SUBJECT, $thisUser->getVar('uname')));

        $xoopsMailer->assign("ADMINMAIL", $xoopsConfig['adminmail']);
        $xoopsMailer->assign("USER_UNAME", $thisUser->getVar('uname'));
        $xoopsMailer->assign("USER_UID", $thisUser->getVar('uid'));
        $xoopsMailer->assign("INVITED_NAME", $obj->getVar('name'));


        $key = md5($obj->getVar('email') . XOOPS_ROOT_PATH);
        $xoopsMailer->assign("BLACKLIST_URL", MYINVITER_URL . '/blacklist.php?email=' . $obj->getVar('email') . '&key=' . $key);

        if (!$xoopsMailer->send(true)) {
            $errors[] = $xoopsMailer->getErrors(false); // do not use html in error message
            $this_handler->insertError($obj);
        } else {
            $this_handler->insertSent($obj);
            $sent++;
            //All Ok? Set log
            /* $log_handler =& xoops_getmodulehandler('log', 'myinviter');
             $log = $log_handler->create();
             $log->setVar('log_userid',$thisUser->getVar('uid'));
             $log->setVar('log_date', time());
             $log_handler->insert($log);  */
        }

        unset($xoopsMailer);
    }

    myinviter_setLastTime($now);
    $lastcount = myinviter_getEmailsSent();
    myinviter_setEmailsSent($lastcount + $sent);

    return $errors;
}

function myinviter_getLastTime()
{
    $ret = $GLOBALS['myinviter']->getHelper('cache')->read('lasttime');
    if ($ret == false) {
        $ret = time();
        myinviter_setLastTime($ret);
    }
    return $ret;
}

function myinviter_setLastTime($value = 0)
{
    $ret = $GLOBALS['myinviter']->getHelper('cache')->write('lasttime', $value);
    return $ret;
}

function myinviter_getEmailsSent()
{
    $ret = $GLOBALS['myinviter']->getHelper('cache')->read('emailssent');
    if ($ret == false) {
        $ret = 0;
        myinviter_setEmailsSent($ret);
    }
    return $ret;
}

function myinviter_setEmailsSent($value)
{
    $ret = $GLOBALS['myinviter']->getHelper('cache')->write('emailssent', $value);
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
            $contacts[$key]['disabled'] = sprintf(_MA_MYINVITER_ISREGISTERED, $reg_emails[$contact['email']]['uname']);
        }
    }
    unset($reg_emails, $users);
    return $contacts;
}

function myinviter_filterWaiting($contacts)
{
    $waiting_emails = $GLOBALS['myinviter']->getHandler('item')->getList();
    foreach ($contacts as $key => $contact) {
        if (in_array($contact['email'], $waiting_emails)) {
            $contacts[$key]['disabled'] = _MA_MYINVITER_ISWAITING;
        }
    }
    unset($waiting_emails);
    return $contacts;
}

function myinviter_filterBlacklisted($contacts)
{
    $blacklisted_emails = $GLOBALS['myinviter']->getHandler('item')->getBlacklistList();
    foreach ($contacts as $key => $contact) {
        if (in_array($contact['email'], $blacklisted_emails)) {
            $contacts[$key]['disabled'] = _MA_MYINVITER_ISBLACKLISTED;
        }
    }
    unset($blacklisted_emails);
    return $contacts;
}