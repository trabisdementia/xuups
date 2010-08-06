<?php

/**
 * $Id: join.php,v 1.8 2005/05/26 15:26:15 fx2024 Exp $
 * Module: SmartClient
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

include "header.php";
$xoopsOption['template_main'] = 'smartclient_join.html';
include XOOPS_ROOT_PATH."/header.php";
include "footer.php";

$myts =& MyTextSanitizer::getInstance();

$op = isset($_POST['op']) ? $_POST['op'] : 'form';

switch ($op) {

    case "submitClient" :

        include XOOPS_ROOT_PATH."/class/xoopsmailer.php";

        $clientObj = $client_handler->create();
        // Uploading the logo, if any
        // Retreive the filename to be uploaded

        if ( $_FILES['logo_file']['name'] != "" ) {
            $filename = $_POST["xoops_upload_file"][0] ;
            if( !empty( $filename ) || $filename != "" ) {
                global $xoopsModuleConfig;
                 
                $max_size = 10000000;
                $max_imgwidth = $xoopsModuleConfig['img_max_width'];
                $max_imgheight = $xoopsModuleConfig['img_max_height'];
                $allowed_mimetypes = smartclient_getAllowedMimeTypes();
                 
                include_once(XOOPS_ROOT_PATH."/class/uploader.php");
                 
                if( $_FILES[$filename]['tmp_name'] == "" || ! is_readable( $_FILES[$filename]['tmp_name'] ) ) {
                    redirect_header( 'javascript:history.go(-1)' , 2, _CO_SCLIENT_FILE_UPLOAD_ERROR ) ;
                    exit ;
                }
                 
                $uploader = new XoopsMediaUploader(smartclient_getImageDir(), $allowed_mimetypes, $max_size, $max_imgwidth, $max_imgheight);
                 
                if( $uploader->fetchMedia( $filename ) && $uploader->upload() ) {

                    $clientObj->setVar('image', $uploader->getSavedFileName());

                } else {
                    redirect_header( 'javascript:history.go(-1)' , 2, _CO_SCLIENT_FILE_UPLOAD_ERROR . $uploader->getErrors() ) ;
                    exit ;
                }
            }
        }

        // Putting the values in the client object
        $clientObj->setVar('id', (isset($_POST['id'])) ? intval($_POST['id']) : 0);
        $clientObj->setVar('title', $_POST['title']);
        $clientObj->setVar('summary', $_POST['summary']);
        $clientObj->setVar('description', $_POST['description']);
        $clientObj->setVar('contact_name', $_POST['contact_name']);
        $clientObj->setVar('contact_email', $_POST['contact_email']);
        $clientObj->setVar('contact_phone', $_POST['contact_phone']);
        $clientObj->setVar('adress', $_POST['adress']);
        $clientObj->setVar('url', $_POST['url']);
        $clientObj->setVar('weight', (isset($_POST['weight'])) ? intval($_POST['weight']) : 0);
        $clientObj->setVar('status', _SCLIENT_STATUS_SUBMITTED);

        if ($xoopsModuleConfig['autoapprove_submitted']) {
            $clientObj->setVar('status', _SCLIENT_STATUS_ACTIVE);
        } else {
            $clientObj->setVar('status', _SCLIENT_STATUS_SUBMITTED);
        }

        // Storing the client
        If ( !$clientObj->store() ) {
            redirect_header("javascript:history.go(-1)", 3, _MD_SCLIENT_SUBMIT_ERROR . smartclient_formatErrors($clientObj->getErrors()));
            exit;
        }

        if (isset($_POST['notifypub']) && $_POST['notifypub'] == 1) {
            include_once XOOPS_ROOT_PATH . '/include/notification_constants.php';
            $notification_handler = &xoops_gethandler('notification');
            $notification_handler->subscribe('client', $clientObj->id(), 'approved', XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE);
        }

        $clientObj->sendNotifications(array(_SCLIENT_NOT_CLIENT_SUBMITTED));
        redirect_header("index.php", 3, _MD_SCLIENT_SUBMIT_SUCCESS);
        exit;
        break;

    case "form" :

        If (($xoopsModuleConfig['allowsubmit'] != 1) || (!$xoopsUser) && $xoopsModuleConfig['anonpost'] != 1) {
            redirect_header("index.php",2,_NOPERM);
        }

        include XOOPS_ROOT_PATH."/class/xoopsformloader.php";
        $form = new XoopsThemeForm(_MD_SCLIENT_JOIN, "joinform", "join.php");
        $form->setExtra('enctype="multipart/form-data"');
        $title_text = new XoopsFormText(_MD_SCLIENT_TITLE, "title", 30, 50);
        $title_text->setDescription(_MD_SCLIENT_TITLE_DSC);

        // TITLE
        $title_text = new XoopsFormText(_CO_SCLIENT_TITLE_REQ, 'title', 50, 255, '');
        $title_text->setDescription(_CO_SCLIENT_TITLE_DSC);
        $form->addElement($title_text, true);

        // LOGO UPLOAD
        $max_size = 5000000;
        $file_box = new XoopsFormFile(_CO_SCLIENT_LOGO_UPLOAD, "logo_file", $max_size);
        $file_box->setExtra( "size ='45'") ;
        $file_box->setDescription(sprintf(_CO_SCLIENT_LOGO_UPLOAD_DSC,$xoopsModuleConfig['img_max_width'],$xoopsModuleConfig['img_max_height']));
        $form->addElement($file_box);

        // IMAGE_URL
        $image_url_text = new XoopsFormText(_CO_SCLIENT_IMAGE_URL, 'image_url', 50, 255, '');
        $image_url_text->setDescription(_CO_SCLIENT_IMAGE_URL_DSC);
        $form->addElement($image_url_text, false);

        // URL
        $url_text = new XoopsFormText(_CO_SCLIENT_URL, 'url', 50, 255, '');
        $url_text->setDescription(_CO_SCLIENT_URL_DSC);
        $form->addElement($url_text, false);

        // SUMMARY
        $summary_text = new XoopsFormTextArea(_CO_SCLIENT_SUMMARY_REQ, 'summary', '', 7, 60);
        $summary_text->setDescription(_CO_SCLIENT_SUMMARY_DSC);
        $form->addElement($summary_text, true);

        // DESCRIPTION
        $description_text = new XoopsFormDhtmlTextArea(_CO_SCLIENT_DESCRIPTION, 'description', '', 15, 60);
        $description_text->setDescription(_CO_SCLIENT_DESCRIPTION_DSC);
        $form->addElement($description_text, false);

        // CONTACT_NAME
        $contact_name_text = new XoopsFormText(_CO_SCLIENT_CONTACT_NAME, 'contact_name', 50, 255, '');
        $contact_name_text->setDescription(_CO_SCLIENT_CONTACT_NAME_DSC);
        $form->addElement($contact_name_text, false);

        // CONTACT_EMAIL
        $contact_email_text = new XoopsFormText(_CO_SCLIENT_CONTACT_EMAIL, 'contact_email', 50, 255, '');
        $contact_email_text->setDescription(_CO_SCLIENT_CONTACT_EMAIL_DSC);
        $form->addElement($contact_email_text, false);

        // CONTACT_PHONE
        $contact_phone_text = new XoopsFormText(_CO_SCLIENT_CONTACT_PHONE, 'contact_phone', 50, 255, '');
        $contact_phone_text->setDescription(_CO_SCLIENT_CONTACT_PHONE_DSC);
        $form->addElement($contact_phone_text, false);

        // ADRESS
        $adress_text = new XoopsFormTextArea(_CO_SCLIENT_ADRESS, 'adress', '', 4, 60);
        $adress_text->setDescription(_CO_SCLIENT_ADRESS_DSC);
        $form->addElement($adress_text, false);


        // NOTIFY ON PUBLISH
        if (is_object($xoopsUser)&& ($xoopsModuleConfig['autoapprove_submitted'] != 1)) {
            $notify_checkbox = new XoopsFormCheckBox('', 'notifypub', 1);
            $notify_checkbox->addOption(1, _MD_SCLIENT_NOTIFY);
            $form->addElement($notify_checkbox);
        }

        // BUTTONS
        $button_tray = new XoopsFormElementTray('', '');
        $hidden = new XoopsFormHidden('op', 'submitClient');
        $button_tray->addElement($hidden);

        $butt_create = new XoopsFormButton('', '', _CO_SCLIENT_SUBMIT, 'submit');
        $butt_create->setExtra('onclick="this.form.elements.op.value=\'submitClient\'"');
        $button_tray->addElement($butt_create);

        $butt_clear = new XoopsFormButton('', '', _CO_SCLIENT_CLEAR, 'reset');
        $button_tray->addElement($butt_clear);

        $butt_cancel = new XoopsFormButton('', '', _CO_SCLIENT_CANCEL, 'button');
        $butt_cancel->setExtra('onclick="history.go(-1)"');
        $button_tray->addElement($butt_cancel);

        $form->addElement($button_tray, true);

        $form->assign($xoopsTpl);
        $xoopsTpl->assign(array("lang_main_client" => _MD_SCLIENT_CLIENTS, "lang_join" => _MD_SCLIENT_JOIN));
        $xoopsTpl->assign('lang_intro_title', _MD_SCLIENT_JOIN);
        $xoopsTpl->assign('lang_intro_text', sprintf(_MD_SCLIENT_INTRO_JOIN, $xoopsConfig['sitename']));
        $xoopsTpl->assign('xoops_pagetitle', $myts->makeTboxData4Show($xoopsModule->name()) . ' - ' . _MD_SCLIENT_JOIN);
        break;
}


include_once XOOPS_ROOT_PATH.'/footer.php';
?>