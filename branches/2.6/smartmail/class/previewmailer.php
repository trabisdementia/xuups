<?php
// $Id: previewmailer.php,v 1.4 2006/09/19 13:47:32 mith Exp $           //
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
// Authors: Jan Keller Pedersen (AKA Mithrandir) & Jannik Nielsen (Bitkid)   //
// URL: http://www.idg.dk/ http://www.xoops.org/ http://www.web-udvikling.dk //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

include_once(SMARTMAIL_ROOT_PATH . "class/newslettermailer.php");

class NewsletterPreviewMailer extends NewsletterMailer {

    /**
     * Send newsletter via the Mlmmj mailing list
     *
     * @param string $email
     * @return bool
     */
    function send($email) {
        //send content to mailing list
        $mailer = getMailer();
        /* @var $mailer XoopsMailer */
        $mailer->useMail();

        $mailer->setBody($this->body);
        $mailer->setFromEmail($this->fromEmail);
        $mailer->setFromName($this->fromName);
        if (count($this->headers) > 0) {
            foreach ($this->headers as $header) {
                $mailer->addHeaders($header);
            }
        }
        $mailer->setSubject($this->subject );
        $mailer->multimailer->isHTML(true);

        //$this->addAttachments($mailer);

        //Send to specified email
        $mailer->setToEmails($email);
        if (! $mailer->send(true)) {
            echo $mailer->getErrors();
            return false;
        }
        return true;
    }
}