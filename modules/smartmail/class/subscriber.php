<?php
// $Id: subscriber.php,v 1.12 2006/09/25 19:44:52 marcan Exp $
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
if (!class_exists('SmartPersistableObjectHandler')) {
    include_once(XOOPS_ROOT_PATH . "/modules/smartobject/class/smartobjecthandler.php");
}

class SmartmailSubscriber extends SmartObject {
    function SmartmailSubscriber() {
        $this->initVar('subscriber_id', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('uid', XOBJ_DTYPE_INT);
        $this->initVar('newsletterid', XOBJ_DTYPE_INT);
    }
}

class SmartmailSubscriberHandler extends SmartPersistableObjectHandler {
    function SmartmailSubscriberHandler($db) {
        parent::SmartPersistableObjectHandler($db, "subscriber", "subscriber_id", "subscriber_email", "", "smartmail");
    }

    /**
     * Get subscriber from user ID and newsletter ID
     *
     * @param int $uid
     * @param int $newsletterid
     * @return SmartmailSubscriber|false
     */
    function getByUser($uid, $newsletterid) {
        $criteria = new CriteriaCompo(new Criteria('uid', intval($uid)));
        $criteria->add(new Criteria('newsletterid', intval($newsletterid)));
        $criteria->setLimit(1);
        $ret = $this->getObjects($criteria);
        return isset($ret[0]) ? $ret[0] : false;
    }

    /**
     * Subscribe a user to a newsletter
     *
     * @param XoopsUser $subscriber
     * @param int $newsletterid
     * @return bool
     */
    function subscribe($user, $newsletterid) {
        $newsletter_handler = xoops_getmodulehandler('newsletter', 'smartmail');
        $newsletter = $newsletter_handler->get($newsletterid);
        if ($newsletter->isNew() ) {
            return false; // newsletter doesn't exist
        }
        $subscriber = $this->getByUser($user->getVar('uid'), $newsletter->getVar('newsletter_id'));
        if (is_object($subscriber) ) {
            // User already subscribed
            return true;
        }
        $subscriber = $this->create();
        $subscriber->setVar('uid', $user->getVar('uid'));
        $subscriber->setVar('newsletterid', $newsletterid);
        // Save in database
        return $this->insert($subscriber, true);
    }

    /**
     * Unsubscribe a subscriber
     *
     * @param NewsletterSubscriber $subscriber
     * @return bool
     */
    function unsubscribe( $subscriber) {
        // @todo: Add subscriber to former recipients table/log
        return $this->delete($subscriber);
    }

    /**
     * Get a list of newsletters that a user subscribes to
     *
     * @param int $uid
     *
     * @return array
     */
    function getNewsletterListByUser($uid) {
        return $this->getNewsletterObjectsByUser(false, $uid);
    }

    function getNewslettersByUser($uid) {
        return $this->getNewsletterObjectsByUser(true, $uid);
    }

    function getNewsletterObjectsByUser($asObjects = true, $uid) {
        $subscriptions = $this->getObjects(new Criteria('uid', intval($uid)));
        if (count($subscriptions) == 0) {
            return array();
        }
        foreach (array_keys($subscriptions) as $i) {
            $newsletterids[] = $subscriptions[$i]->getVar('newsletterid');
        }
        $smartmail_newsletter_handler = xoops_getmodulehandler('newsletter', 'smartmail');
        if ($asObjects) {
            return $smartmail_newsletter_handler->getObjects(new Criteria('newsletter_id', "(".implode(',', $newsletterids).")", "IN"), true);
        } else {
            return $smartmail_newsletter_handler->getList(new Criteria('newsletter_id', "(".implode(',', $newsletterids).")", "IN"));
        }
    }

    /**
     * Get list of (active) recipients for a newsletter
     *
     * This function uses a VERY BAD join with the users table, but getting
     * a list of 30000 userids from the subscribers table and then calling
     * the user handler to fetch the users' information and then joining it
     * together is a pretty bad idea, too.
     *
     * If the users table changes in forthcoming XOOPS versions, this will be
     * dealt with by me (Mith).
     *
     * @param int $newsletterid
     * @param int $limit number of recipients to fetch
     * @param int $offset start at which recipient
     * @return array
     */
    function getRecipientList($newsletterid, $limit = 0, $offset = 0) {
        $sql = "SELECT * FROM ".$this->table." s, ".$this->db->prefix("users")." u
    			WHERE s.newsletterid = ".intval($newsletterid)." AND s.uid = u.uid AND u.level > 0 ORDER BY u.email";
        $result = $this->db->query($sql, $limit, $offset);
        if (!$result) {
            return array();
        }
        $ret = array();
        while ($row = $this->db->fetchArray($result)) {
            $ret[] = $row;
        }
        return $ret;
    }
}
?>