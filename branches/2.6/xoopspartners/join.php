<?php
// $Id$
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
// ------------------------------------------------------------------------- //
// Author: Raul Recio (AKA UNFOR)                                            //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

include 'header.php';
$xoopsOption['template_main'] = 'xoopspartners_join.html';
include XOOPS_ROOT_PATH . '/header.php';
$myts =& MyTextSanitizer::getInstance();
if ($xoopsUser) {
    if ($_POST['op'] == "sendMail") {
        if (!$GLOBALS['xoopsSecurity']->check()) {
            redirect_header(
                'index.php', 3,
                _MD_XPARTNERS_ERROR1 . "<br />" . implode('<br />', $GLOBALS['xoopsSecurity']->getErrors())
            );
        }
        //TODO: Test Change - don't extract $_POST vars directly into var table space
        //extract($_POST);
        extract($_POST, EXTR_PREFIX_ALL, "unsafe");
        include XOOPS_ROOT_PATH . "/class/xoopsmailer.php";
        if (empty($unsafe_title) || empty($unsafe_description) || empty($unsafe_url) || $unsafe_url == "http://") {
            $xoopsTpl->assign(
                array(
                     "content4join" => _MD_XPARTNERS_ERROR1, "lang_main_partner" => _MD_XPARTNERS_PARTNERS, "sitename" => $xoopsConfig['sitename']
                )
            );
            $xoopsContentsTpl = 'partnerjoin.html';
            include_once XOOPS_ROOT_PATH . '/footer.php';
            exit();
        }
        $url = formatURL($myts->htmlSpecialChars($unsafe_url));
        $title = $myts->htmlSpecialChars($unsafe_title);
        $description = $myts->htmlSpecialChars($unsafe_description);
        $image = formatURL($myts->htmlSpecialChars($unsafe_image));
        $imageInfo = @getimagesize($image);
        $imageWidth = $imageInfo[0];
        $imageHeight = $imageInfo[1];
        $type = $imageInfo[2];
        if (0 == $type) {
            $xoopsTpl->assign(
                array(
                     "content4join" => _MD_XPARTNERS_ERROR3, "lang_main_partner" => _MD_XPARTNERS_PARTNERS, "sitename" => $xoopsConfig['sitename']
                )
            );
            $xoopsContentsTpl = 'partnerjoin.html';
            include_once XOOPS_ROOT_PATH . '/footer.php';
            exit();
        }
        if ($imageWidth >= 110 or $imageHeight >= 150) {
            $xoopsTpl->assign(
                array(
                     "content4join" => _MD_XPARTNERS_ERROR2, "lang_main_partner" => _MD_XPARTNERS_PARTNERS, "sitename" => $xoopsConfig['sitename']
                )
            );
            $xoopsContentsTpl = 'partnerjoin.html';
            include_once XOOPS_ROOT_PATH . '/footer.php';
            exit();
        }
        $image = ("http://" == $image) ? '' : $image;
        $xoopsMailer =& xoops_getMailer();
        $xoopsMailer->useMail();
        $xoopsMailer->setTemplateDir(
            XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar('dirname') . "/language/{$xoopsConfig['language']}/"
        );
        $xoopsMailer->setTemplate("join.tpl");
        $xoopsMailer->assign("SITENAME", $xoopsConfig['sitename']);
        $xoopsMailer->assign("SITEURL", XOOPS_URL . "/");
        $xoopsMailer->assign("IP", $_SERVER['REMOTE_ADDR']);
        $xoopsMailer->assign("URL", $url);
        $xoopsMailer->assign("IMAGE", $image);
        $xoopsMailer->assign("TITLE", $title);
        $xoopsMailer->assign("DESCRIPTION", $description);
        $xoopsMailer->assign("USER", $xoopsUser->getVar("uname"));
        $xoopsMailer->assign("MODULENAME", $xoopsModule->getVar("dirname"));
        $xoopsMailer->setToEmails($xoopsConfig['adminmail']);
        $xoopsMailer->setFromEmail($xoopsUser->getVar("email"));
        $xoopsMailer->setFromName($xoopsUser->getVar("uname"));
        $xoopsMailer->setSubject(sprintf(_MD_XPARTNERS_NEWPARTNER, $xoopsConfig['sitename']));
        if (!$xoopsMailer->send()) {
            $xoopsTpl->assign(
                array(
                     "content4join"
                     => "<br />" . $xoopsMailer->getErrors()
                         . _MD_XPARTNERS_GOBACK, "lang_main_partner" => _MD_XPARTNERS_PARTNERS, "lang_join" => _MD_XPARTNERS_JOIN, "sitename" => $xoopsConfig['sitename']
                )
            );
        } else {
            $xoopsTpl->assign(
                array(
                     "content4join"
                     => "<br />"
                         . _MD_XPARTNERS_SENDMAIL, "lang_main_partner" => _MD_XPARTNERS_PARTNERS, "lang_join" => _MD_XPARTNERS_JOIN, "sitename" => $xoopsConfig['sitename']
                )
            );
        }
        $xoopsContentsTpl = 'partnerjoin.html';
    } else {
        include XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
        $form = new XoopsThemeForm("", "joinform", "join.php", "post", true);
        $titlePartner = new XoopsFormText(_MD_XPARTNERS_TITLE, "title", 30, 150);
        $imagePartner = new XoopsFormText(_MD_XPARTNERS_IMAGE, "image", 30, 150, "http://");
        $urlPartner = new XoopsFormText(_MD_XPARTNERS_URL, "url", 30, 150, "http://");
        $descriptionPartner = new XoopsFormTextArea(_MD_XPARTNERS_DESCRIPTION, "description", '', 7, 50);
        $opHidden = new XoopsFormHidden("op", "sendMail");
        $submitButton = new XoopsFormButton("", "dbsubmit", _MD_XPARTNERS_SEND, "submit");
        $form->addElement($titlePartner);
        $form->addElement($imagePartner);
        $form->addElement($urlPartner);
        $form->addElement($descriptionPartner);
        $form->addElement($opHidden);
        $form->addElement($submitButton);
        $form->setRequired($titlePartner);
        $form->setRequired($urlPartner);
        $form->setRequired($descriptionPartner);
        $content = $form->render();
        $xoopsTpl->assign(
            array(
                 "content4join" => $content, "lang_main_partner" => _MD_XPARTNERS_PARTNERS, "lang_join" => _MD_XPARTNERS_JOIN, "sitename" => $xoopsConfig['sitename']
            )
        );
    }
} else {
    redirect_header('index.php', 2, _NOPERM);
}
include_once XOOPS_ROOT_PATH . '/footer.php';