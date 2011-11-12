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
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id$
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

// defines are used to set the errorLevel
define("_CT_ERROR_NONE", 0);       // 00000000
define("_CT_ERROR_BADSECVAL", 1);  // 00000001
define("_CT_ERROR_BADEMAIL", 2);   // 00000010

class ContactItem extends XoopsObject
{
    var $helper;

    /**
     * constructor
     */
    function __construct()
    {
        $this->helper = Xmf_Module_Helper::getInstance('contact');
        $xoopsUser = $GLOBALS['xoopsUser'];
        $xoopsConfig = $GLOBALS['xoopsConfig'];

        $this->initVar('name', XOBJ_DTYPE_TXTBOX, !empty($xoopsUser) ? $xoopsUser->getVar("uname", "E") : "");
        $this->initVar('email', XOBJ_DTYPE_TXTBOX, !empty($xoopsUser) ? $xoopsUser->getVar("email", "E") : "");
        $this->initVar('url', XOBJ_DTYPE_TXTBOX, !empty($xoopsUser) ? $xoopsUser->getVar("url", "E") : "");
        $this->initVar('icq', XOBJ_DTYPE_TXTBOX, !empty($xoopsUser) ? $xoopsUser->getVar("user_icq", "E") : "");
        $this->initVar('location', XOBJ_DTYPE_TXTBOX, !empty($xoopsUser) ? $xoopsUser->getVar("user_from", "E") : "");

        $this->initVar('address', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('company', XOBJ_DTYPE_TXTBOX, '');

        $this->initVar("sendconfirm", XOBJ_DTYPE_INT, 0);
        $this->initVar('comments', XOBJ_DTYPE_TXTAREA, '');

        $this->initVar('departments', XOBJ_DTYPE_ARRAY, $this->helper->getConfig('contact_dept'));
        $this->initVar('department', XOBJ_DTYPE_TXTBOX, $xoopsConfig['sitename']);

        $this->initVar('error', XOBJ_DTYPE_INT, _CT_ERROR_NONE);

        $this->initVar('moreinfo', XOBJ_DTYPE_ARRAY, array());
        $this->initVar('moreinfolist', XOBJ_DTYPE_ARRAY, $this->helper->getConfig('contact_moreinfo'));

        // there is no data, or contact_showdept
        if ((!is_array($this->getVar('departments')) || count($this->getVar('departments')) == 0)) {
            $this->helper->setConfig('contact_showdept', 0); // is turned off...set departments to default
            $this->setVar('departments', array(0 => $xoopsConfig['sitename'] . "," . $xoopsConfig['adminmail']));
        }
    }

    function isValidEmail()
    {
        $retval = false;
        // this validates the structure of the email
        if (preg_match("/^[a-zA-Z0-9_\.]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$/i", $this->getVar('email', 'e'))) {
            $retval = true;
        }
        return $retval;
    }

    function deepCheckEmail()
    {
        $retval = true;
        if (checkdnsrr($this->getEmailtld())) {
            return $retval;
        }

        $fp = fsockopen($this->getEmailtld(), 80, $errno, $errstr, 30);
        if (!$fp) {
            $retval = false;
        } else {
            fclose($fp);
        }
        return $retval;
    }

    function getEmailtld()
    {
        $retval = "";
        if (preg_match("/^[a-zA-Z0-9_\.]+@([a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+)$/i", $this->getVar('email', 'e'), $regs)) {
            $retval = $regs[1];
        }
        return $retval;
    }

}

class ContactItemHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db)
    {
        parent::__construct($db, '', 'ContactItem');
    }

    function getForm($obj = false)
    {
        xoops_load('xoopsformloader');

        if (!is_object($obj)) {
            $obj = $this->create();
        }

        $configs = $obj->helper->getConfig();

        $contact_form = new XoopsThemeForm($configs['contact_head'], "contactform", "index.php", "post", true);

        // check for pre-existing error condition
        if ($obj->getVar('error') != 0) {
            $err = $obj->getVar('error');
            $message = _CT_ERROR_CONDITION;
            if ($err & _CT_ERROR_BADSECVAL) {
                $message .= _CT_ERROR_BADSECVALUE_MSG;
            }
            if ($err & _CT_ERROR_BADEMAIL) {
                $message .= _CT_ERROR_BADEMAIL_MSG;
            }
            $error_text = new XoopsFormLabel(_CT_ERROR_CONDITIONHEAD, $message);
            $contact_form->addElement($error_text);
        }

        // check to see if there is some intro text to display
        if ($configs['contact_intro']) {
            $intro_text = new XoopsFormLabel($configs['contact_intro_head'], $configs['contact_intro']);
            $contact_form->addElement($intro_text);
        }

        $name_text = new XoopsFormText(_CT_NAME, "name", 50, 100, $obj->getVar('name', 'e'));
        $contact_form->addElement($name_text, true);

        $email_text = new XoopsFormText(_CT_EMAIL, "email", 50, 100, $obj->getVar('email', 'e'));
        $contact_form->addElement($email_text, true);

        if ($configs['contact_address']) {
            $address_text = new XoopsFormTextArea(_CT_ADDRESS, "address", $obj->getVar('address', 'e'));
            $contact_form->addElement($address_text);
        }

        if ($configs['contact_url']) {
            $url_text = new XoopsFormText(_CT_URL, "url", 50, 100, $obj->getVar('url', 'e'));
            $contact_form->addElement($url_text);
        }

        if ($configs['contact_icq']) {
            $icq_text = new XoopsFormText(_CT_ICQ, "icq", 50, 100, $obj->getVar('icq', 'e'));
            $contact_form->addElement($icq_text);
        }

        if ($configs['contact_company']) {
            $company_text = new XoopsFormText(_CT_COMPANY, "company", 50, 100, $obj->getVar('company', 'e'));
            $contact_form->addElement($company_text);
        }

        if ($configs['contact_loc']) {
            $location_text = new XoopsFormText(_CT_LOCATION, "location", 50, 100, $obj->getVar('location', 'e'));
            $contact_form->addElement($location_text);
        }

        if ($configs['contact_allowsendconfirm']) {
            // draw the checkbox for user to get a confirmation mail
            $email_v = $obj->getVar('email', 'e');
            $caption = ($email_v == "" ? _CT_SENDCONFIRM : sprintf(_CT_SENDCONFIRMEMAIL, $email_v));
            $sendconfirm = new XoopsFormCheckBox(_CT_CONFIRM, "sendconfirm", $obj->getVar('sendconfirm'));
            $sendconfirm->addOption(1, $caption);
            $contact_form->addElement($sendconfirm);
        }

        if ($configs['contact_showdept']) {
            // show a drop down with the correct departments listed
            $departmentlist = new XoopsFormSelect($configs['contact_depttitle'], "department");
            $departments = $obj->getVar('departments','e'); // get array of departments
            $selDept = $obj->getVar('department', 'e');
            $cnt = 0;
            foreach ($departments as $val) {
                $valexplode = explode(',', $val);
                $selected = false;
                if ($selDept != "" && (strcmp($selDept, $valexplode[0]) == 0)) {
                    // this option is selected
                    $selected = true;
                } else {
                    // if there is none selected and this is the first one
                    if ($selDept == "" && $cnt == 0) {
                        // make it selected
                        $selected = true;
                    }
                }
                $departmentlist->addOption($valexplode[0]);
                if ($selected == true) {
                    $departmentlist->setValue($valexplode[0]);
                }
                $cnt++;
            }
            $contact_form->addElement($departmentlist);
        }

        // add comment area
        $comment_textarea = new XoopsFormTextArea(_CT_COMMENTS, "comments", $obj->getVar('comments', 'e'));
        $contact_form->addElement($comment_textarea, true);

        // add more info area if required
        if ($configs['contact_showmoreinfo']) {
            // draw container with multi-select check boxes
            $moreinfo = new XoopsFormCheckBox($configs['contact_moreinfotitle'], "moreinfo");
            $moreinfolist = $configs['contact_moreinfo'];
            $selmoreinfo = $obj->getVar('moreinfo', 'e');
            foreach ($moreinfolist as $val) {
                $moreinfo->addOption($val);
            } // end foreach $moreinfolist
            $moreinfo->setValue($selmoreinfo);
            $contact_form->addElement($moreinfo);
        }

        // add security check if required
        if ($configs['contact_security'] && extension_loaded('gd')) {
            mt_srand((double)microtime() * 10000);
            $random_num = mt_rand(0, 100000);
            $security = "<img src='getgfx.php?random_num=$random_num' border='1' alt='" . _CT_SECURITY_CODE . "' title='" . _CT_SECURITY_CODE . "'>&nbsp;&nbsp;"
                        . "<img src='images/no-spam.jpg' alt='" . _CT_NO_SPAM . "' title='" . _CT_NO_SPAM . "'>";
            // show the security block and input field
            $security_graphic = new XoopsFormLabel(_CT_SECURITY_CODE, $security);
            $contact_form->addElement($security_graphic);
            $type_security = new XoopsFormText(_CT_SECURITY_TYPE, "securityType", 10, 6);
            $contact_form->addElement($type_security, true);
            $security_hidden = new XoopsFormHidden("securityHidden", $random_num);
            $contact_form->addElement($security_hidden);
        }
        $submit_button = new XoopsFormButton("", "submit", _CT_SUBMIT, "submit");
        $contact_form->addElement($submit_button);
        return $contact_form;
    }
}