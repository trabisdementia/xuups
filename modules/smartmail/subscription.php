<?php
// $Id: subscription.php,v 1.13 2006/09/25 19:44:52 marcan Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

function smartmail_subscriptionForm() {
    global $xoopsUser, $xoopsTpl, $smartmail_newsletter_handler, $smartmail_subscriber_handler;

    $groups = $xoopsUser ? $xoopsUser->getGroups() : array (
    XOOPS_GROUP_ANONYMOUS
    );

    $allowedNewsletters = $smartmail_newsletter_handler->getAllowedNewsletters($groups);

    if (is_object($xoopsUser)) {
        $subcribedNewsletters = $smartmail_subscriber_handler->getNewslettersByUser($xoopsUser->getVar('uid'));
        $xoopsTpl->assign('subscribedNewsletters', $smartmail_subscriber_handler->getObjectsAsArray($subcribedNewsletters));

        // remove the subcribed newsletters to the allowedNewletters array
        $newAllowedNewsletters = array();
        foreach($allowedNewsletters as $key=>$value) {
            if (!isset($subcribedNewsletters[$key])) {
                $newAllowedNewsletters[$key] = $value;
            }
        }
        $xoopsTpl->assign('newsletters', $smartmail_newsletter_handler->getObjectsAsArray($newAllowedNewsletters));
    } else {
        $xoopsTpl->assign('newsletters', $allowedNewsletters);
    }

    $xoopsTpl->assign('subscription_action', 'default');
}

include "header.php";

if ($xoopsUser) {
    // Turn off caching of user-specific page
    $xoopsConfig['module_cache'][$xoopsModule->getVar('mid')] = 0;
}
$xoopsOption['template_main'] = 'smartmail_subscription.html';
include_once (XOOPS_ROOT_PATH . "/header.php");
$submit = isset ($_POST['subscription_block_submit']) ? true : false;
$aInfoMessages = array ();
$aErrorMessages = array ();
$xoopsTpl->assign('module_home', smart_getModuleName(true, true));
$xoopsTpl->assign('categoryPath', _NL_MA_SUBSCRIPTION);
$xoopsTpl->assign('subscription_action', 'login');
$xoopsTpl->assign('subscription_lang_lostpass', _MB_SYSTEM_LPASS);
$xoopsTpl->assign('subscription_lang_registernow', _MB_SYSTEM_RNOW);
$xoopsTpl->assign('lang_password', _PASSWORD);
$xoopsTpl->assign('lang_rememberme', _REMEMBERME); // autologin hack GIJ
if ($xoopsConfig['use_ssl'] == 1 && $xoopsConfig['sslloginlink'] != '') {
    $xoopsTpl->assign('subscription_sslloginlink', "<a href=\"javascript:openWithSelfMain('" . $xoopsConfig['sslloginlink'] . "', 'ssllogin', 300, 200);\">" . _MB_SYSTEM_SECURE . "</a>");
}
$op = isset ($_POST['op']) ? $_POST['op'] : false;
$op = isset ($_GET['op']) ? $_GET['op'] : $op;

switch ($op) {
    case 'subscription_form_post' :
        $user_email = $_POST['subscription_block_email'];
        $aNewsletters = $_POST['subscription_block_submit_newsletters'];
        $xoopsTpl->assign('subscription_newsletters', $aNewsletters);

        $sNewslettersForDisplay = implode(', ', array_map('intval', $aNewsletters));
        $sNewslettersForRedirect = implode('-', array_map('intval', $aNewsletters));
        $members_handler = xoops_gethandler('member');
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('email', $user_email));
        $aUsers = $members_handler->getUsers($criteria);
        $xoopsTpl->assign('redirect_page', "$xoopsRequestUri?op=logedin&nl=$sNewslettersForRedirect");
        if (count($aUsers) == 0) {
            $aInfoMessages[] = sprintf(_NL_MA_EMAIL_NOT_FOUND, $user_email);
            $xoopsTpl->assign('subscription_action', 'typo');
            $xoopsTpl->assign('subscription_user_email', $user_email);
        }
        elseif (count($aUsers) > 1) {
            $aErrorMessages[] = sprintf(_NL_MA_EMAIL_MORE_THAN_1, $user_email);
        } else {
            //include user language files
            $language_file = XOOPS_ROOT_PATH . "/language/" . $xoopsConfig['language'] . "/user.php";
            if (!file_exists($language_file)) {
                $language_file = XOOPS_ROOT_PATH . "/language/english/user.php";
            }
            include_once ($language_file);
            $oUser = $aUsers[0];
            $aInfoMessages[] = sprintf(_NL_MA_EMAIL_FOUND_USER, $user_email);
            $xoopsTpl->assign('redirect_page', "$xoopsRequestUri?op=logedin&nl=$sNewslettersForRedirect");
            $xoopsTpl->assign('subscription_action', 'login');
        }
        break;
    case 'logedin' :
        if (!is_object($xoopsUser)) {
            redirect_header($smart_previous_page, 3, _NL_MA_MUST_BE_LOGEDIN);
        }

        $subscriber_handler = xoops_getmodulehandler('subscriber');

        // If user has unchecked some newsletters, unsubscribe him
        // First, let's retreive user's current subscription
        $subscribedNewsletters = $subscriber_handler->getNewsletterListByUser($xoopsUser->getVar('uid'));
        $posted_subscribedNewsletters = array_map('intval', $_POST['subscription_block_subscribed_newsletters']);

        $unsubscribedNewsletters = false;
        foreach($subscribedNewsletters as $key=>$value) {
            if (array_search($key, $posted_subscribedNewsletters) === false) {
                $subscriber_handler->unsubscribe($subscriber_handler->getByUser($xoopsUser->getVar('uid'), $key));
                $unsubscribedNewsletters[] = $value;
            }
        }
        if ($unsubscribedNewsletters) {
            $aInfoMessages[] = sprintf(_NL_MA_UNSUBSCRIBED_NEWSLETTER, implode(', ', $unsubscribedNewsletters));
        }
        if (isset ($_GET['nl'])) {
            $sNewsletters = isset ($_GET['nl']) ? $_GET['nl'] : false;
            $aNewsletters = array_map('intval', explode('-', $sNewsletters));
        }
        elseif (isset ($_POST['subscription_block_submit_newsletters'])) {
            $aNewsletters = array_map('intval', $_POST['subscription_block_submit_newsletters']);
        }

        $sNewsletters = implode(', ', $aNewsletters);
        /**
         * subscribe $xoopsUser to the selected newsletters
         **/

        $newsletters = $smartmail_newsletter_handler->getAllowedList($xoopsUser->getGroups());
        $newSubscribedNewsLetters = array();
        foreach ($aNewsletters as $newsletterid) {
            if (isset ($newsletters[$newsletterid])) {
                if (!$subscriber_handler->subscribe($xoopsUser, $newsletterid)) {
                    //subscription to this newsletter failed
                    $aErrorMessages[] = sprintf(_NL_MA_SUBSCRIPTION_FAILURE, $newsletters[$newsletterid]);
                } else {
                    $newSubscribedNewsLetters[] = $newsletters[$newsletterid];
                }
            }
        }
        if ($newSubscribedNewsLetters) {
            $aInfoMessages[] = sprintf(_NL_MA_NEW_SUBSCRIBED_NEWSLETTERS, implode(', ', $newSubscribedNewsLetters));
        }
        $xoopsTpl->assign('subscription_newsletters', $subscriber_handler->getNewsletterListByUser($xoopsUser->getVar('uid')));
        $xoopsTpl->assign('subscription_action', 'default');
        /**
         * @todo send a message to user with a list of his subscriptions and a link to "Subscription Management" screen
         */

        smartmail_subscriptionForm();
        break;

    case 'newuser' :
        $user_email = $_POST['subscription_user_email'];
        $xoopsTpl->assign('subscription_action', 'newuser');
        $config_handler = & xoops_gethandler('config');
        $xoopsConfigUser = & $config_handler->getConfigsByCat(XOOPS_CONF_USER);
        switch ($xoopsConfigUser['activation_type']) {
            case 0 :
                $level = 0;
                $mailtemplate = 'smartmail_activate_user.tpl';
                $aInfoMessages[] = sprintf(_NL_MA_NEW_USER_NEED_ACT, $user_email);
                break;
            case 1 :
                $level = 1;
                $mailtemplate = 'smartmail_auto_activate_user.tpl';
                $aInfoMessages[] = sprintf(_NL_MA_NEW_USER_AUTO_ACT, $user_email);
                break;
            case 2 :
            default :
                $level = 0;
                $mailtemplate = 'smartmail_admin_activate_user.tpl';
                $aInfoMessages[] = sprintf(_NL_MA_NEW_USER_ADMIN_ACT, $user_email);
        }
        $password = xoops_makepass();

        $name = substr($user_email, 0, strpos($user_email, "@") + 1); //Take the email adress without domain as username
        $actkey = xoops_makepass();
        $newUser = smartmail_XoopsAccountFromEmail($user_email, $name, $password, $level, $actkey);
        $aNewsletters = $_POST['subscription_newsletters'];
        $sNewslettersForDisplay = implode(', ', $aNewsletters);
        $xoopsTpl->assign('subscription_newsletters', $aNewsletters);
        // Get list of allowed newsletters
        $newsletters = $smartmail_newsletter_handler->getAllowedList($newUser->getGroups());
        /**
         * Subscribe this new user to the selected newsletters
         */

        $subscriber_handler = xoops_getmodulehandler('subscriber');
        $subscribedNewsletters = array();
        foreach ($aNewsletters as $newsletterid) {
            if (isset ($newsletters[$newsletterid])) {
                if (!$subscriber_handler->subscribe($newUser, $newsletterid)) {
                    //subscription to this newsletter failed
                    $aErrorMessages[] = sprintf(_NL_MA_SUBSCRIPTION_FAILURE, $newsletters[$newsletterid]);
                } else {
                    $subscribedNewsletters[] = $newsletters[$newsletterid];
                }
            }
        }

        $aInfoMessages[] = sprintf(_NL_MA_NEW_USER_NEWSLETTERS, implode(', ', $subscribedNewsletters));

        $xoopsMailer = & getMailer();
        $xoopsMailer->useMail();
        $xoopsMailer->setTemplateDir('language/' . $xoopsConfig['language'] . '/mail_template');
        $xoopsMailer->setTemplate($mailtemplate);
        $xoopsMailer->assign('XOOPS_USER_PASSWORD', $password);
        $xoopsMailer->assign('SITENAME', $xoopsConfig['sitename']);
        $xoopsMailer->assign('ADMINMAIL', $xoopsConfig['adminmail']);
        $xoopsMailer->assign('SITEURL', XOOPS_URL . "/");
        $xoopsMailer->assign('UNAME', $newUser->getVar('uname'));
        $xoopsMailer->assign('USERACTLINK', XOOPS_URL . '/user.php?op=actv&id=' . $newUser->getVar('uid') . '&actkey=' . $actkey);
        $xoopsMailer->setToUsers($newUser);
        $xoopsMailer->setFromEmail($xoopsConfig['adminmail']);
        $xoopsMailer->setFromName($xoopsConfig['sitename']);
        $xoopsMailer->setSubject(_NL_MA_YOUR_REGISTRATION);
        if (!$xoopsMailer->send(true)) {
            /**
             * @todo trap error if email was not sent
             */
            $xoopsMailer->getErrors(true);
        }
        /**
         * @todo add and respect the module preference about automatic creation of username and password
         * @todo send a message to user with a list of his subscriptions and a link to "Subscription Management" screen
         */
        break;
    default :
        smartmail_subscriptionForm();
        break;
}
$xoopsTpl->assign('infoMessages', $aInfoMessages);
$xoopsTpl->assign('errorMessages', $aErrorMessages);
include_once ("footer.php");
include_once (XOOPS_ROOT_PATH . "/footer.php");
?>