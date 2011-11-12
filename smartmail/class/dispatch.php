<?php
// $Id: dispatch.php,v 1.12 2006/09/16 12:09:08 mith Exp $           //
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
class SmartmailDispatch extends SmartObject {
    var $newsletter; //Instance of newsletter object
    var $ads = array(); //Array of ads
    var $attachments = array();

    function SmartmailDispatch() {
        $this->initVar("dispatch_id", XOBJ_DTYPE_INT);
        $this->initVar('newsletterid', XOBJ_DTYPE_INT);
        $this->initVar("dispatch_time", XOBJ_DTYPE_INT);
        $this->initVar("dispatch_subject", XOBJ_DTYPE_TXTBOX, "");
        $this->initVar("dispatch_status", XOBJ_DTYPE_INT, 1); //0 = not ready, 1 = ready to send, 2 = dispatched, 3 = to be sent, 4 = in progress
        $this->initVar('dispatch_content', XOBJ_DTYPE_TXTAREA, '');
        $this->initVar('dispatch_receivers', XOBJ_DTYPE_INT, 0);
    }

    /**
     * Get a {@link XoopsForm} object for creating/editing objects
     * @param mixed $action receiving page - defaults to $_SERVER['REQUEST_URI']
     * @param mixed $title title of the form
     *
     * @return object
     */
    function getForm($action = false, $title = false) {
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");

        if ($action == false) {
            $url_parts = parse_url($_SERVER['REQUEST_URI']);
            $action = $url_parts['path'];
        }
        if ($title == false) {
            $title = $this->isNew() ? _ADD : _EDIT;
            $title .= " "._NL_AM_DISPATCH;
        }

        $form = new XoopsThemeForm($title, 'form', $action);
        if (!$this->isNew()) {
            $form->addElement(new XoopsFormHidden('id', $this->getVar('dispatch_id')));
        }
        else {
            $this->assignVar('dispatch_time', $this->getNextDispatch());
        }
        $form->addElement(new XoopsFormHidden('op', 'save'));
        $form->addElement(new XoopsFormHidden('nid', $this->getVar('newsletterid')));
        $time = new XoopsFormDateTime(_NL_AM_TIME, 'dispatch_time', 15, $this->getVar('dispatch_time'));
        $time->_name = "dispatch_time"; //XOOPS 2.0.13.2 < fix for missing name attribute
        $form->addElement($time);
        $form->addElement(new XoopsFormText(_NL_AM_SUBJECT, 'dispatch_subject', 75, 255, $this->getVar('dispatch_subject', 'e')));
        $status_radio = new XoopsFormRadio(_NL_AM_STATUS, 'dispatch_status', $this->getVar('dispatch_status'));
        $status_radio->addOption(0, _NL_AM_NOTREADY);
        $status_radio->addOption(1, _NL_AM_READY);
        $status_radio->addOption(2, _NL_AM_DISPATCHED);
        $form->addElement($status_radio);

        $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        return $form;
    }

    /**
     * Process submissal of form from getForm()
     *
     * @return bool
     */
    function processFormSubmit() {
        $this->setVar('newsletterid', $_REQUEST['nid']);
        $this->setVar('dispatch_time', intval(strtotime($_REQUEST['dispatch_time']['date']) + $_REQUEST['dispatch_time']['time']));
        $this->setVar('dispatch_subject', $_REQUEST['dispatch_subject']);
        $this->setVar('dispatch_status', $_REQUEST['dispatch_status']);

        return true;
    }

    /**
     * Process post-save operations following save of object after submissal of form from getForm()
     *
     * @return bool
     */
    function postSave() {
        return true;
    }

    /**
     * Builds a newsletter ready to be mailed
     *
     * @param bool $edit if true, the output will have edit links for editing blocks
     *
     * @return string
     *
     **/
    function build($edit = false) {
        $this->loadNewsletter();
        //Assign information
        global $xoopsTpl;
        $xoopsTpl->assign('dispatchid', $this->getVar('dispatch_id'));
        $xoopsTpl->assign('receivercount', $this->getReceiverCount());
        $xoopsTpl->assign('newsletter', $this->newsletter->toArray());

        $timestamp = $this->getVar("dispatch_time");
        $date = array('weekday' => strftime("%A", $timestamp), 'day' => date("d", $timestamp), 'month' => strftime("%B", $timestamp));
        $xoopsTpl->assign('date', $date);

        $newsletterblock_handler = xoops_getmodulehandler('block');
        $newsletterblocks = $newsletterblock_handler->getByNewsletter($this->getVar('newsletterid'), $this->getVar('dispatch_id'), $edit);
        if (isset($newsletterblocks[$this->getVar('newsletterid')])) {
            $xoopsTpl->assign("blocks", $newsletterblocks[$this->getVar('newsletterid')]);
        }

        //Apply template
        $content['html'] = $xoopsTpl->fetch('db:'.$this->newsletter->getVar('newsletter_template'));

        //Generate subject if not present
        /**
         * @todo find a new way of generating subject automatically
         */
        if ($this->getVar('dispatch_subject') == "") {
            $subject = "[No Subject]";
            $this->setVar('dispatch_subject', $subject);
        }

        //Return content
        return $content;
    }

    /**
     * Send a newsletter dispatch
     *
     * @param bool $preview whether it is a preview send
     * @param string $email email to send to
     *
     * @return bool
     **/
    function send($preview = true, $email = "") {
        //Get articles as array
        $content = $this->build();
        $this->loadNewsletter();

        if ($preview) {
            include_once(XOOPS_ROOT_PATH."/modules/smartmail/class/previewmailer.php");
            $mailer = new NewsletterPreviewMailer();
            $recipients = $email;
        }
        else {
            $mailer = "smart"; // change to a newsletter preference?
            // Include class file
            include_once(XOOPS_ROOT_PATH."/modules/smartmail/class/".strtolower($mailer)."mailer.php");
            // Calculate class name
            $classname = "Newsletter".ucfirst($mailer)."Mailer";
            // Instantiate mailer class
            $mailer = new $classname($this);
            // Get recipient list
            $recipients = $this->getReceiverList();
            break;
        }

        $mailer->body = $content['html'];
        $mailer->fromEmail = $this->newsletter->getVar('newsletter_from_email');
        $mailer->fromName = $this->newsletter->getVar('newsletter_from_name');
        $mailer->addHeaders("Kod-ord: ".$GLOBALS['xoopsModuleConfig']['newsletter_passphrase']);

        $subject = $this->getVar('dispatch_subject', 'n');
        $mailer->subject = $subject ;
        $mailer->attachments = $this->attachments;
        $mailer->dispatchid = $this->getVar('dispatch_id');

        if ($mailer->send($recipients) ) {
            // Temporary commenting - put back when testing has finished
            //            if (!$preview) {
            //                $this->setVar('dispatch_content', $content["html"]);
            //                $this->setVar('dispatch_subject', $subject);
            //                $this->setVar('dispatch_receivers', $this->getReceiverCount());
            //
            //                //set dispatch status to "Dispatched"
            //                $this->setStatus(2);
            //
            //                //call update on blocks
            //                /**
            //                 * @todo find a method to call updates on blocks - newsletter blocks and dispatch blocks
            //                 */
            //                //$this->updateBlocks();
            //
            //                //create next dispatch for the newsletter
            //                $this->createNextDispatch();
            //            }
            return true;
        }
        else {
            //If preview, but no email is set, don't send
            return false;
        }
    }

    /**
     * Load newsletter object into property
     *
     * @return void
     **/
    function loadNewsletter() {
        if (!is_object($this->newsletter)) {
            $newsletter_handler = xoops_getmodulehandler('newsletter', 'smartmail');
            $this->newsletter = $newsletter_handler->get($this->getVar('newsletterid'));
        }
    }

    /**
     * Creates next dispatch based on the newsletter rules
     *
     * @return int
     **/
    function getNextDispatch($starttime = null) {
        $this->loadNewsletter();
        $nexttime = $this->newsletter->getNextDispatch($starttime);
        return isset($nexttime) ? $nexttime : 0;
    }

    /**
     * Get dispatch's {@link Newsletter}
     *
     * @return object
     */
    function getNewsletter() {
        $this->loadNewsletter();
        return $this->newsletter;
    }

    /**
     * Get the number of recipients to this newsletter
     *
     * @return int
     **/
    function getReceiverCount() {
        $subscriber_handler = xoops_getmodulehandler('subscriber', 'smartmail');
        $criteria = new CriteriaCompo(new Criteria('newsletterid', $this->newsletter->getVar('newsletter_id')));
        $subscribercount = $subscriber_handler->getCount($criteria);
        return $subscribercount;
    }

    /**
     * Get a list of recipients to this newsletter
     *
     * @return array
     **/
    function getReceiverList() {
        $smartmail_subscriber_handler = xoops_getmodulehandler('subscriber', 'smartmail');
        return $smartmail_subscriber_handler->getRecipientList($this->getVar('newsletterid'));
    }

    /**
     * Create x dispatches from a timestamp
     *
     * @param int $start_time timestamp to start from
     * @param int $number number of dispatches to create
     *
     * @return void
     */
    function createNextDispatch($start_time = 0, $number = 1) {
        $dispatch_handler = xoops_getmodulehandler('dispatch', 'smartmail');
        if ($start_time == 0) {
            $start_time = $dispatch_handler->getLastDispatchTime($this->getVar('newsletterid'));
        }
        $dispatch_handler->createNextDispatch($this->getVar('newsletterid'), $start_time, $number);
    }

    /**
     * Set status of this to something
     * @param int $status
     *
     * @return bool
     **/
    function setStatus($status) {
        $dispatch_handler = xoops_getmodulehandler('dispatch', 'smartmail');
        $this->setVar('dispatch_status', $status);
        return $dispatch_handler->insert($this, true);
    }
}

class SmartmailDispatchHandler extends SmartPersistableObjectHandler {
    function SmartmailDispatchHandler($db) {
        parent::SmartPersistableObjectHandler($db, "dispatch", "dispatch_id", "dispatch_subject", "", "smartmail");
    }

    /**
     * Returns dispatch objects that are ready for dispatch and are set to dispatch in the past
     *
     * @return array
     */
    function getReadyDispatches() {
        $criteria = new CriteriaCompo(new Criteria('dispatch_status', 1));
        $criteria->add(new Criteria('dispatch_time', time(), "<="));
        return $this->getObjects($criteria, true);
    }

    /**
     * Returns the timestamp of last dispatch
     *
     * @param int $newsletterid Which newsletter to fetch for
     *
     * @retun int
     **/
    function getLastDispatchTime($newsletterid) {
        $sql = "SELECT MAX(dispatch_time) FROM ".$this->table." WHERE newsletterid=".intval($newsletterid);
        $result = $this->db->query($sql);
        list($ret) = $this->db->fetchRow($result);
        return $ret;
    }

    /**
     * Create x dispatches from a timestamp
     *
     * @param int $newsletterid Newsletter to add dispatches for
     * @param int $start_time timestamp to start calculating
     * @param int $number number of dispatches to create
     *
     * @return void
     */
    function createNextDispatch($newsletterid, $start_time, $number) {
        $newsletter_handler = xoops_getmodulehandler('newsletter', 'smartmail');
        $newsletter = $newsletter_handler->get($newsletterid);
        if ($start_time < time()) {
            $start_time = time();
        }
        for ($i = 0; $i < $number; $i++) {
            $next_timestamp = $newsletter->getNextDispatch($start_time);
            //echo "<br />".date('d-m-Y H:i:s', $next_timestamp);
            $next_dispatch = $this->create();
            $next_dispatch->setVar('newsletterid', $newsletterid);
            $next_dispatch->setVar("dispatch_time", $next_timestamp);
            $this->insert($next_dispatch, true);
            $start_time = $next_timestamp;
        }
    }
}
?>