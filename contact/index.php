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
 * @copyright       The XOOPS Project http://www.xoops.org
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id$
 */

include_once dirname(__FILE__) . '/header.php';

$contact = Xmf_Module_Helper::getInstance(CONTACT_DIRNAME);
$configs = $contact->getConfig();

if (empty($_POST['submit']) || !$GLOBALS['xoopsSecurity']->check()) {
    $xoopsOption['template_main'] = 'contact_contactusform.html';
    include XOOPS_ROOT_PATH . "/header.php";
    $form = $contact->getHandler('item')->getForm();
    $form->assign($xoopsTpl);
    include XOOPS_ROOT_PATH . "/footer.php";
} else {
    $obj = $contact->getHandler('item')->create();
    $fields = array(
        'name', 'email', 'address',
        'url', 'icq', 'company', 'location',
        'sendconfirm','department', 'comments',
        'moreinfo');
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            $obj->setVar($field, $_POST[$field]);
        }
    }

    $securityType = Xmf_Request::getString('securityType');
    $securityHidden = Xmf_Request::getInt('securityHidden');

    $myts =& MyTextSanitizer::getInstance();

    $do_check = false;
    if ($configs['contact_security'] && extension_loaded('gd')) {
        $do_check = true;
        $datekey = date("F j");
        $rcode = hexdec(md5($_SERVER['HTTP_USER_AGENT'] . $securityHidden . $configs['contact_sitekey'] . $datekey));
        $code = substr($rcode, 2, 6);
    }

    $errval = _CT_ERROR_NONE;

    // check seccode
    if ($do_check == true && $code != $securityType) {
        $errval |= _CT_ERROR_BADSECVAL;
    }

    // check for bad email
    if ($obj->isValidEmail() == false) {
        // make sure you add on top of any existing errorlevel by &
        $errval |= _CT_ERROR_BADEMAIL;
    } else {
        if ($configs['contact_validatedomain']) {
            if ($obj->deepCheckEmail() == false) {
                $errval |= _CT_ERROR_BADEMAIL;
            }
        }
    }

    $obj->setVar('error', $errval);
    if ($obj->getVar('error') != 0) {
        // redisplay form
        $xoopsOption['template_main'] = 'contact_contactusform.html';
        include XOOPS_ROOT_PATH . "/header.php";
        $form = $contact->getHandler('item')->getForm($obj);
        $form->assign($xoopsTpl);
        include XOOPS_ROOT_PATH . "/footer.php";
    } else {
        $obj->cleanVars();
        $adminMessage = sprintf(_CT_SUBMITTED, $obj->getVar('name'));
        $adminMessage .= "\n";
        $adminMessage .= "" . _CT_EMAIL . " " . $obj->getVar('email') . "\n";

        if ($configs['contact_address']) {
            $adminMessage .= "" . _CT_ADDRESS . "\n" . $obj->getVar('address') . "\n";
        }

        if ($configs['contact_url']) {
            $adminMessage .= "" . _CT_URL . "\n" . $obj->getVar('url') . "\n";
        }

        if ($configs['contact_icq']) {
            $adminMessage .= "" . _CT_ICQ . "\n" . $obj->getVar('icq') . "\n";
        }

        if ($configs['contact_company']) {
            $adminMessage .= _CT_COMPANY . "\n" . $obj->getVar('company') . "\n";
        }

        if ($configs['contact_loc']) {
            $adminMessage .= _CT_LOCATION . "\n" . $obj->getVar('location') . "\n";
        }

        $adminMessage .= _CT_COMMENTS . "\n";
        $adminMessage .= "\n" . $obj->getVar('comments') . "\n\n";
        $moreinfoMessage = '';
        if ($configs['contact_showmoreinfo']) {
            if (count($obj->getVar('moreinfo')) > 0) {
                $temp = $configs['contact_moreinfotitle'] . " :\n";
                $adminMessage .= $temp;
                $moreinfoMessage = $temp;
                foreach ($obj->getVar('moreinfo') as $item) {
                    $temp = "* $item\n";
                    $adminMessage .= $temp;
                    $moreinfoMessage .= $temp;
                }
            }
        }

        $adminMessage .= "\n" . $_SERVER['HTTP_USER_AGENT'] . "\n";

        $subject = $xoopsConfig['sitename'] . " - " . $configs['contact_head'];
        $toemail = $xoopsConfig['adminmail'];
        if ($configs['contact_showdept']) {
            $selDept = $obj->getVar('department');
            $departments = $obj->getVar('departments');

            foreach ($departments as $val) {
                $valexplode = explode(',', $val);

                $selected = false;
                if (strcmp($selDept, $valexplode[0]) == 0) {
                    // this option is selected
                    $selected = true;
                }

                if ($selected == true) {
                    $subject = $xoopsConfig['sitename'] . " - " . $selDept;
                    $toemail = $valexplode[1];
                }
            }
        }

        $xoopsMailer =& xoops_getMailer();
        $xoopsMailer->useMail();
        $xoopsMailer->setToEmails($toemail);
        $xoopsMailer->setFromEmail($obj->getVar('email'));
        $xoopsMailer->setFromName($obj->getVar('name'));
        $xoopsMailer->setSubject($subject);
        $xoopsMailer->setBody($adminMessage);

        if ($success = $xoopsMailer->send()) {
            $messagesent = sprintf(_CT_MESSAGESENT, $xoopsConfig['sitename']) . "<br />" . $configs['contact_thankyou'] . "";
        } else {
            $messagesent = $xoopsMailer->getErrors();
        }

        if ($success && $obj->getVar('sendconfirm')) {
            $conf_subject = $configs['contact_thankyou'];
            $userMessage = sprintf(_CT_HELLO, $obj->getVar('name'));
            $userMessage .= "\n\n";
            $userMessage .= sprintf(_CT_THANKYOUCOMMENTS, $xoopsConfig['sitename']);
            $userMessage .= "\n";
            $userMessage .= sprintf(_CT_SENTTOWEBMASTER, $obj->getVar('department'));
            $userMessage .= "\n";
            $userMessage .= _CT_YOURMESSAGE . "\n";
            $userMessage .= "\n" . $obj->getVar('comments') . "\n\n";
            $userMessage .= "--------------\n";
            $userMessage .= "" . $subject . "\n";
            $userMessage .= "\n" . $moreinfoMessage . "\n";
            $xoopsMailer =& xoops_getMailer();
            $xoopsMailer->useMail();
            $xoopsMailer->setToEmails($obj->getVar('email'));
            $xoopsMailer->setFromEmail($obj->getVar('email'));
            $xoopsMailer->setFromName($xoopsConfig['sitename']);
            $xoopsMailer->setSubject($conf_subject);
            $xoopsMailer->setBody($userMessage);
            $xoopsMailer->send();
            $messagesent .= "<br />" . sprintf(_CT_SENTASCONFIRM, $obj->getVar('email'));
        }
        redirect_header(XOOPS_URL . "/index.php", $configs['contact_redirecttimeout'], $messagesent);
    }
}