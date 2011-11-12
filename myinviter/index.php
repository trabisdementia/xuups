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

include_once dirname(__FILE__) . '/header.php';

include_once XOOPS_ROOT_PATH . '/header.php';

if (isset($_SESSION['contacts_post'])) {
    $_POST = $_SESSION['contacts_post'];
    $_POST['step'] = 'get_contacts';
    $_SESSION['contacts_post'] = null;
}

$template = 'list';

$p_disabled = array();
$p_provider = array();
$p_selected = '';

$ers = array();
$import_ok = false;

$step = isset($_POST['step']) ? $_POST['step'] : 'form';
$email_box = isset($_POST['email_box']) ? $_POST['email_box'] : '';
$password_box = isset($_POST['password_box']) ? $_POST['password_box'] : '';
$provider_box = isset($_POST['provider_box']) ? $_POST['provider_box'] : '';
$oi_session_id = isset($_POST['oi_session_id']) ? $_POST['oi_session_id'] : '';

$inviter = $GLOBALS['myinviter']->getHandler('inviter');
$oi_services = $inviter->getPlugins();

switch ($step) {
    case 'get_contacts':
        if (empty($email_box)) {
            $ers['email'] = _MA_MYINVITER_ERROR_EMAILMISSING;
        }
        if (empty($password_box)) {
            $ers['password'] = _MA_MYINVITER_ERROR_PASSWORDMISSING;
        }
        if (empty($provider_box)) {
            $ers['provider'] = _MA_MYINVITER_ERROR_PROVIDERMISSING;
        }
        if (count($ers) == 0) {
            $inviter->startPlugin($provider_box);
            $internal = $inviter->getInternalError();
            if ($internal) {
                $ers['inviter'] = $internal;
            } else if (!$inviter->login($email_box, $password_box)) {
                $internal = $inviter->getInternalError();
                $ers['login'] = $internal ? $internal : _MA_MYINVITER_ERROR_LOGINFAILED;
            } else if (false === $contacts = $inviter->getMyContacts()) {
                $ers['contacts'] = _MA_MYINVITER_ERROR_UNABLE;
            } else {
                $import_ok = true;
            }
        }
        break;

    case 'send_invites':
        $selected_contacts = array();
        $this_handler = $GLOBALS['myinviter']->getHandler('item');
        $uid = is_object($xoopsUser) ? $xoopsUser->getVar('uid') : intval($GLOBALS['myinviter']->getConfig('defaultuid'));
        $list = isset($_POST['list']) ? $_POST['list'] : array();

        $inviter->startPlugin($provider_box);
        $internal = $inviter->getInternalError();
        if ($internal) {
            $ers['internal'] = $internal;
        }
        if (empty($provider_box)) {
            $ers['provider'] = _MA_MYINVITER_ERROR_PROVIDERMISSING;
        }
        if (empty($oi_session_id)) {
            $ers['session_id'] = _MA_MYINVITER_ERROR_SESSIONMISSING;
        }

        if (count($ers) == 0) {
            foreach ($list as $name_email) {
                if (ereg(':', $name_email)){
                    list($fname, $fmail) = explode(':', $name_email);
                } else {
                    continue;
                }

                if (ereg('@', $fname)){
                    $split = explode('@', $fname);
                    $fname = $split[0];
                }

                if (ereg(', ', $fname)){
                    $split = explode(', ', $fname);
                    $fname = $split[1] . ' ' . $split[0];
                }

                //for services that don't provide email (twitter/facebook)
                if (is_numeric($fmail)) {
                    $selected_contacts[$fmail] = $fname;
                } else {
                    $waiting = $this_handler->create();
                    $waiting->setVar('userid', $uid);
                    $waiting->setVar('email', $fmail);
                    $waiting->setVar('name', $fname);
                    $waiting->setVar('date', time());
                    $this_handler->insertWaiting($waiting);
                    unset($waiting);
                }
            }

            if (count($selected_contacts) > 0) {
                $message = array(
                    'subject' => $GLOBALS['myinviter']->getConfig('socialsubject'),
                    'body' => $GLOBALS['myinviter']->getConfig('socialmessage'),
                    'attachment' => ""
                );


                $messageSent = $inviter->sendMessage($oi_session_id, $message, $selected_contacts);
                $inviter->logout();
                if ($messageSent === -1 || $messageSent === false) {
                    redirect_header('index.php', 2, $inviter->getInternalError());
                }
                redirect_header('index.php', 2, _MA_MYINVITER_INVITATIONSSENT);
                exit();
            }
            redirect_header('index.php', 2, _MA_MYINVITER_EMAILSADDED);
            exit();
        }
        break;

    case 'form':
    default:
        break;
}

$plugType = '';
if (!empty($provider_box)) {
    if (isset($oi_services['email'][$provider_box])) {
        $plugType = 'email';
    } else if (isset($oi_services['social'][$provider_box])) {
        $plugType = 'social';
    }
}

foreach ($oi_services as $type => $providers) {
    $s_list[$type] = $inviter->pluginTypes[$type];
    foreach ($providers as $provider => $details) {
        $p_list[$type][$provider] = $details['name'];
        if ($provider_box == $provider) {
            $p_selected = $provider;
        }
    }
}
$xoopsTpl->assign('services', $s_list);
$xoopsTpl->assign('providers', $p_list);
$xoopsTpl->assign('selected', $p_selected);
$xoopsTpl->assign('errors', $ers);
$xoopsTpl->assign('email_box' , $email_box);
$xoopsTpl->assign('password_box', $password_box);
$xoopsTpl->assign('provider_box', $provider_box);
$xoopsTpl->assign('oi_session_id', $oi_session_id);

if ($import_ok) {
    $template = 'contacts';
    $i = 0;
    foreach ($contacts as $email => $name) {
        $con[$i]['email'] = $email;
        $con[$i]['name'] = utf8_encode($name);
        $i++;
    }
    $con = myinviter_filterRegistered($con);
    $con = myinviter_filterWaiting($con);
    $con = myinviter_filterBlacklisted($con);

    $xoopsTpl->assign('contacts_array', $con);
    unset($contacts, $con);
    $xoopsTpl->assign('xoops_module_header', '
        <script>

        //Check all radio/check buttons script- by javascriptkit.com
        //Visit JavaScript Kit (http://javascriptkit.com) for script
        //Credit must stay intact for use


        function checkall(thestate){
        var el_collection = document.forms[\'form_results\'].elements[\'list[]\'];
        for (var c=0;c<el_collection.length;c++)
        el_collection[c].checked=thestate
        }

        </script>
        <style type="text/css">

        td.off {
        background: #A4A4A4;
        }

        </style>
    ');
}
switch ($template) {
    case 'list':
        $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
        $xoTheme->addScript('modules/myinviter/js/jquery.mousewheel-3.0.4.pack.js');
        $xoTheme->addScript('modules/myinviter/js/jquery.fancybox-1.3.4.pack.js');
        $xoTheme->addStylesheet('modules/myinviter/css/jquery.fancybox-1.3.4.css');
        $xoTheme->addStylesheet('modules/myinviter/css/style.css');

        break;
}



$xoopsTpl->display(XOOPS_ROOT_PATH . "/modules/myinviter/templates/myinviter_{$template}.html");

include_once XOOPS_ROOT_PATH . '/footer.php';