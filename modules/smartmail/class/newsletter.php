<?php
// $Id: newsletter.php,v 1.15 2006/09/25 19:44:52 marcan Exp $                   //
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

if (!class_exists('SmartObject')) {
    include_once(XOOPS_ROOT_PATH . "/modules/smartobject/class/smartobject.php");
}

class SmartmailNewsletter extends SmartObject {
    function SmartmailNewsletter() {
        $this->initVar("newsletter_id", XOBJ_DTYPE_INT);
        $this->initVar("newsletter_name", XOBJ_DTYPE_TXTBOX, "", true);
        $this->initVar("newsletter_description", XOBJ_DTYPE_TXTAREA);
        $this->initVar('newsletter_template', XOBJ_DTYPE_TXTBOX);
        $this->initVar('newsletter_from_name', XOBJ_DTYPE_TXTBOX);
        $this->initVar('newsletter_from_email', XOBJ_DTYPE_TXTBOX);
        $this->initVar('newsletter_email', XOBJ_DTYPE_TXTBOX);
        $this->initVar('newsletter_confirm_text', XOBJ_DTYPE_TXTAREA);
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
            $action = $_SERVER['REQUEST_URI'];
        }
        if ($title == false) {
            $title = $this->isNew() ? _ADD : _EDIT;
            $title .= " "._NL_AM_NEWSLETTER;
        }

        $form = new XoopsThemeForm($title, 'form', $action);
        if (!$this->isNew()) {
            $form->addElement(new XoopsFormHidden('id', $this->getVar('newsletter_id')));
        }

        $form->addElement(new XoopsFormText(_NL_AM_NAME, 'newsletter_name', 35, 255, $this->getVar('newsletter_name', 'e')), true);
        $form->addElement(new XoopsFormTextArea(_NL_AM_DESCRIPTION, 'newsletter_description', $this->getVar('newsletter_description', 'e')));
        $form->addElement(new XoopsFormText(_NL_AM_FROMNAME, 'newsletter_from_name', 35, 255, $this->getVar('newsletter_from_name', 'e')), true);
        $form->addElement(new XoopsFormText(_NL_AM_FROMEMAIL, 'newsletter_from_email', 35, 255, $this->getVar('newsletter_from_email', 'e')), true);
        $form->addElement(new XoopsFormText(_NL_AM_EMAIL, 'newsletter_email', 35, 255, $this->getVar('newsletter_email', 'e')), true);

        $form->addElement(new XoopsFormTextArea(_NL_AM_CONFIRM_TEXT, "newsletter_confirm_text", $this->getVar('newsletter_confirm_text', 'e'), 10, 50, "newsletter_confirm_text"));

        $member_handler = &xoops_gethandler('member');
        $group_list = &$member_handler->getGroupList();
        $groups_checkbox = new XoopsFormCheckBox(_NL_AM_PERMISSIONS_SELECT, 'newsletter_permissions[]', $this->getPermissions());
        $groups_checkbox->setDescription(_NL_AM_PERMISSIONS_SELECT_DSC);
        foreach ($group_list as $group_id => $group_name) {
            $groups_checkbox->addOption($group_id, $group_name);
        }
        $form->addElement($groups_checkbox);

        $template_select = new XoopsFormSelect(_NL_AM_TEMPLATE, 'newsletter_template', $this->getVar('newsletter_template', 'e'));
        $template_select->addOption('smartmail_newsletter_pcworld.html');
        $form->addElement($template_select);

        $form->addElement(new XoopsFormHidden('op', 'save'));
        $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        return $form;
    }

    /**
     * Process submissal of form from getForm()
     *
     * @return bool
     */
    function processFormSubmit() {
        $this->setVar('newsletter_name', $_REQUEST['newsletter_name']);
        $this->setVar('newsletter_description', $_REQUEST['newsletter_description']);
        $this->setVar('newsletter_template', $_REQUEST['newsletter_template']);
        $this->setVar('newsletter_from_name', $_REQUEST['newsletter_from_name']);
        $this->setVar('newsletter_from_email', $_REQUEST['newsletter_from_email']);
        $this->setVar('newsletter_email', $_REQUEST['newsletter_email']);
        return true;
    }

    /**
     * Process post-save operations following save of object after submissal of form from getForm()
     *
     * @return bool
     */
    function postSave() {

        $ret = $this->storePermissions($_REQUEST['newsletter_permissions']);

        return $ret;
    }

    /**
     * Returns rules for this newsletter
     *
     * @return array
     */
    function getRules() {
        $rulehandler = xoops_getmodulehandler('rule', 'smartmail');
        return $rulehandler->getObjects(new Criteria('newsletterid', $this->getVar('newsletter_id')));
    }

    /**
     * Get next dispatch for this newsletter from start time
     *
     * @param int $starttime time to start with
     *
     * @return int
     */
    function getNextDispatch($starttime = null) {
        if (is_null($starttime)) {
            $starttime = time();
        }
        else {
            $starttime++;
        }

        $rules = $this->getRules();

        foreach ($rules as $rule) {
            $dispatchtime = $rule->getNextDispatchTime($starttime);

            if ((!isset($nexttime) || $dispatchtime < $nexttime) && $dispatchtime > $starttime) {
                $nexttime = $dispatchtime;
            }
        }

        if (!isset($nexttime)) {
            return time();
        }
        if ($nexttime > time()) {
            return $nexttime;
        }
        return $this->getNextDispatch($nexttime);
    }

    /**
     * Store newsletter permissions
     *
     * @param array $groups groups that are granted a specific permission
     * @param string $perm_name name of the permission
     *
     * @return bool TRUE if success FALSE if fail
     */
    function storePermissions($groups, $perm_name='smartmail_newsletter_subscribe') {
        $smartModule = smart_getModuleInfo('smartmail');
        $module_id = $smartModule->getVar('mid');
        $gperm_handler = &xoops_gethandler('groupperm');
        // First, if the permissions are already there, delete them
        if (!$gperm_handler->deleteByModule($module_id, $perm_name, $this->getVar('newsletter_id'))) {
            return false;
        }
        $result = true;
        // Save the new permissions
        if (count($groups) > 0) {
            foreach ($groups as $group_id) {
                if (!$gperm_handler->addRight($perm_name, $this->getVar('newsletter_id'), $group_id, $module_id)) {
                    $result = false;
                }
            }
        }
        return $result;
    }

    /**
     * Retreive the groups that are granted a specific permission
     *
     * @param string $perm_name name of the permission
     *
     * @return array groups that are granted the permission
     */
    function getPermissions($perm_name='smartmail_newsletter_subscribe') {
        $smartModule = smart_getModuleInfo('smartmail');
        $gperm_handler =& xoops_gethandler('groupperm');

        //Get groups allowed for an item id
        return $gperm_handler->getGroupIds($perm_name, $this->getVar('newsletter_id'), $smartModule->getVar('mid'));
    }

    /**
     * Returns an array representation of the object
     *
     * @return array
     */
    function toArray() {
        $ret = array();
        $vars = $this->getVars();
        foreach (array_keys($vars) as $i) {
            $ret[$i] = $this->getVar($i);
        }
        return $ret;
    }
}

class SmartmailNewsletterHandler extends SmartPersistableObjectHandler {
    function SmartmailNewsletterHandler($db) {
        parent::SmartPersistableObjectHandler($db, "newsletter", "newsletter_id", "newsletter_name", "", "smartmail");
    }

    /**
     * Get list of newsletters allowed by the groups
     *
     * @param array $groups
     * @param Criteria $criteria
     * @return array
     */
    function getAllowedList($groups, $criteria = null) {
        return $this->getAllowedObjects(false, $groups, $criteria);
    }

    function getAllowedNewsletters($groups, $criteria = null) {
        return $this->getAllowedObjects(true, $groups, $criteria);
    }

    function getAllowedObjects ($asObject = true, $groups, $criteria = null) {
        $smartModule = smart_getModuleInfo('smartmail');
        $perm_handler = xoops_gethandler('groupperm');
        $allowed_newsletterids = $perm_handler->getItemIds('smartmail_newsletter_subscribe', $groups, $smartModule->getVar('mid'));
        $nl_criteria = new CriteriaCompo();
        if (!is_null($criteria)) {
            $nl_criteria->add($criteria);
        }

        $nl_criteria->add(new Criteria('newsletter_id', "(".implode(',', $allowed_newsletterids).")", "IN"));
        if ($asObject) {
            return $this->getObjects($nl_criteria, true);
        } else {
            return $this->getList($nl_criteria);
        }
    }
}
?>