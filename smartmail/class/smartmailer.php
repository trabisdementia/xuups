<?php
// $Id: smartmailer.php,v 1.1 2006/09/06 20:39:29 mith Exp $           //
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
require_once XOOPS_ROOT_PATH."/modules/smartmail/class/newslettermailer.php";
class NewsletterSmartMailer extends NewsletterMailer {
    var $email;

    function NewsletterSmartMailer(&$dispatch) {
        $this->NewsletterMailer(&$dispatch);
        $this->email = $this->dispatch->newsletter->getVar('newsletter_email', 'n');
    }

    /**
     * Send newsletter via the SmartMail Mail Sender Service Interface
     *
     * @param array $recipients
     * @return bool
     */
    function send($recipients) {
        $output = $this->getXML($recipients);
         
        // Debug data - will be removed
        $filename = XOOPS_UPLOAD_PATH."/mailtest.xml";
        $fp = fopen($filename, "w");
        fwrite($fp, $output);
         
        //send content to mailing list
        $mailer = getMailer();
        /* @var $mailer XoopsMailer */
        $mailer->useMail();

        $mailer->setBody($output);
        $mailer->setFromEmail($this->fromEmail);
        $mailer->setFromName($this->fromName);
        if (count($this->headers) > 0) {
            foreach ($this->headers as $header) {
                $mailer->addHeaders($header);
            }
        }
        $mailer->setSubject($this->subject );
        $mailer->multimailer->isHTML(true);

        //Send to specified email
        $mailer->setToEmails($this->email);
        if (! $mailer->send(true)) {
            echo $mailer->getErrors();
            return false;
        }
        return true;
    }

    /**
     * Generate XML document from recipients list
     *
     * @param array $recipients
     * @return string
     */
    function getXML($recipients) {

        $dom = new DOMDocument();

        $xml_ele = $dom->createElement("mailJob");
        $xml_ele->setAttribute("id", $this->dispatch->getVar('dispatch_id'));

        $mailTpl_ele = $dom->createElement("mailTemplate");

        $subject_ele = $dom->createElement("subject");
        $subject_cdata = $dom->createCDATASection(utf8_encode($this->subject));
        $subject_ele->appendChild($subject_cdata);

        $body_ele = $dom->createElement("body");
        $body_cdata = $dom->createCDATASection(utf8_encode($this->body));
        $body_ele->appendChild($mail_cdata);

        $mailTpl_ele->appendChild($subject_ele);
        $mailTpl_ele->appendChild($body_ele);

        $xml_ele->appendChild($mailTpl_ele);

        $subscriberlist_ele = $dom->createElement("subscriberList");
        foreach ($recipients as $id => $recipient) {
            $subscriber_ele = $dom->createElement("subscriber");
            $subscriber_ele->setAttribute("id", "xoops-".$recipient['subscriber_id']);

            foreach ($recipient as $name => $value) {
                if ($var == "id") {
                    continue;
                }
                $var_ele = $dom->createElement("var", $value);
                $var_ele->setAttribute("name", $name);
                $subscriber_ele->appendChild($var_ele);
            }
            $subscriberlist_ele->appendChild($subscriber_ele);

        }
        $xml_ele->appendChild($subscriberlist_ele);

        $dom->appendChild($xml_ele);
        $dom->formatOutput = true;

        return $dom->saveXML();
    }
}