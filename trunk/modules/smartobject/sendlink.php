<?php

/**
 * $Id: sendlink.php 159 2007-12-17 16:44:05Z malanciault $
 * Module: SmartContent
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

include_once("header.php");
require_once SMARTOBJECT_ROOT_PATH.'class/smartloader.php';
require_once SMARTOBJECT_ROOT_PATH.'class/smartobjectlink.php';
require_once XOOPS_ROOT_PATH.'/class/template.php';

$xoopsTpl = new XoopsTpl();
$myts =& MyTextSanitizer::getInstance();
$xoopsConfig['sitename'] = $myts->displayTarea($xoopsConfig['sitename']);

xoops_header(false);
echo smart_get_css_link(SMARTOBJECT_URL . 'module.css');
echo '</head><body>';

$smartobject_link_handler = xoops_getmodulehandler('link', 'smartobject');
$linkObj = $smartobject_link_handler->create();

$op = isset($_POST['op']) ? $_POST['op'] : '';

switch ($op) {
    case 'sendlink' :

        include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjectcontroller.php";
        $controller = new SmartObjectController($smartobject_link_handler);

        $linkObj = $controller->storeSmartObject();
        if ($linkObj->hasError()) {
            /**
             * @todo inform user and propose to close the window if a problem occured when saving the link
             */
        }

        $xoopsMailer =& getMailer();
        $xoopsMailer->useMail();
        $xoopsMailer->setTemplateDir('language/'.$xoopsConfig['language'].'/mail_template');

        $xoopsMailer->setTemplate('sendlink.tpl');
        $xoopsMailer->assign('X_SITENAME', $xoopsConfig['sitename']);
        $xoopsMailer->assign('TO_NAME', $linkObj->getVar('to_name'));
        $xoopsMailer->assign('FROM_NAME', $linkObj->getVar('from_name'));
        $xoopsMailer->assign('SITEURL', XOOPS_URL."/");
        $xoopsMailer->assign('ADMINMAIL', $xoopsConfig['adminmail']);
        $xoopsMailer->assign('MESSAGE', $_POST['body']);
        $xoopsMailer->setToEmails($linkObj->getVar('to_email'));
        $xoopsMailer->setFromEmail($linkObj->getVar('from_email'));
        $xoopsMailer->setFromName($xoopsConfig['sitename']);
        $xoopsMailer->setSubject(sprintf(_CO_SOBJECT_SUBJECT_DEFAULT, $myts->oopsStripSlashesGPC($xoopsConfig['sitename'])));

        if (!$xoopsMailer->send(true)) {
            $xoopsTpl->assign('send_error', sprintf(_CO_SOBJECT_SEND_ERROR, $xoopsConfig['adminmail']) . '<br />' . $xoopsMailer->getErrors(true));
        } else {
            $xoopsTpl->assign('send_success', _CO_SOBJECT_SEND_SUCCESS);
        }

        break;

    default :
        if (isset($_GET['mid'])) {
            $mid = $_GET['mid'];
        } else {
            /**
             * @todo close the window if no mid is passed as GET
             */
        }

        $hModule = xoops_gethandler('module');
        $module = $hModule->get($mid);
        $linkObj->setVar('mid', $module->getVar('mid'));
        $linkObj->setVar('mid_name', $module->getVar('name'));

        if (isset($_GET['link'])) {
            $link = $_GET['link'];
        } else {
            /**
             * @todo close the window if no link is passed as GET
             */
        }
        $linkObj->setVar('link', $link);

        if (is_object($xoopsUser)) {
            $linkObj->setVar('from_uid', $xoopsUser->getVar('uid'));
            $linkObj->setVar('from_name', $xoopsUser->getVar('name') != '' ? $xoopsUser->getVar('name') : $xoopsUser->getVar('uname'));
            $linkObj->setVar('from_email', $xoopsUser->getVar('email'));
        }

        $linkObj->setVar('subject', sprintf(_CO_SOBJECT_SUBJECT_DEFAULT, $xoopsConfig['sitename']));
        $linkObj->setVar('body', sprintf(_CO_SOBJECT_BODY_DEFAULT, $xoopsConfig['sitename'], $link));
        $linkObj->setVar('date', time());
        $linkObj->hideFieldFromForm(array('from_uid', 'to_uid', 'link', 'mid', 'mid_name'));

        $form = $linkObj->getForm(_CO_SOBJECT_SEND_LINK_FORM, 'sendlink', false, _SEND,'javascript:window.close();');

        $form->assign($xoopsTpl);

        $xoopsTpl->assign('showform', true);
        break;
}


$xoopsTpl->display('db:smartobject_sendlink.html');

xoops_footer();

?>