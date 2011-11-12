<?php
// $Id: rule.php,v 1.7 2006/09/16 12:09:08 mith Exp $               //
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

class SmartmailRule extends SmartObject {
    function SmartmailRule() {
        $this->initVar("rule_id", XOBJ_DTYPE_INT);
        $this->initVar("newsletterid", XOBJ_DTYPE_INT);
        $this->initVar("rule_weekday", XOBJ_DTYPE_INT); //0 means every day, 1 through 7 means monday through sunday
        $this->initVar("rule_timeofday", XOBJ_DTYPE_TXTBOX, "10:00"); //on the form HH:MM
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
            $title .= " "._NL_AM_NEWSLETTERRULE;
        }

        $form = new XoopsThemeForm($title, 'form', $action);
        if (!$this->isNew()) {
            $form->addElement(new XoopsFormHidden('id', $this->getVar('rule_id')));
        }

        $newsletter_select = new XoopsFormSelect(_NL_AM_NEWSLETTER, 'newsletterid', $this->getVar('newsletterid'));
        $smartmail_newsletter_handler = xoops_getmodulehandler('newsletter');
        $newsletter_select->addOptionArray($smartmail_newsletter_handler->getList());
        $form->addElement($newsletter_select);

        if (file_exists(XOOPS_ROOT_PATH."/language/".$GLOBALS['xoopsConfig']['language']."/calendar.php")) {
            include_once XOOPS_ROOT_PATH."/language/".$GLOBALS['xoopsConfig']['language']."/calendar.php";
        }
        else {
            include_once XOOPS_ROOT_PATH."/language/english/calendar.php";
        }
        $weekday_select = new XoopsFormSelect(_NL_AM_WEEKDAY, 'rule_weekday', $this->getVar('rule_weekday', 'e'));
        $weekday_select->addOption(0, _NL_AM_EVERYDAY);
        $weekday_select->addOption(1, _CAL_MONDAY);
        $weekday_select->addOption(2, _CAL_TUESDAY);
        $weekday_select->addOption(3, _CAL_WEDNESDAY);
        $weekday_select->addOption(4, _CAL_THURSDAY);
        $weekday_select->addOption(5, _CAL_FRIDAY);
        $weekday_select->addOption(6, _CAL_SATURDAY);
        $weekday_select->addOption(7, _CAL_SUNDAY);
        $form->addElement($weekday_select);

        $form->addElement(new XoopsFormText(_NL_AM_TIMEOFDAY, 'rule_timeofday', 6, 6, $this->getVar('rule_timeofday', 'e')));

        $form->addElement(new XoopsFormHidden('op', 'save'));
        $form->addElement(new XoopsFormButton('', 'submit', _ADD." "._NL_AM_NEWSLETTERRULE, 'submit'));
        return $form;
    }

    /**
     * Process submissal of form from getForm()
     *
     * @return bool
     */
    function processFormSubmit() {
        $this->setVar('newsletterid', $_REQUEST['newsletterid']);
        $this->setVar('rule_weekday', $_REQUEST['rule_weekday']);
        $this->setVar('rule_timeofday', $_REQUEST['rule_timeofday']);
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
     * Get next dispatch for this newsletter from start time
     *
     * @param int $starttime time to start with
     *
     * @return int
     */
    function getNextDispatchTime($starttime) {
        $day_array = array(1 => "Monday",
        2 => "Tuesday",
        3 => "Wednesday",
        4 => "Thursday",
        5 => "Friday",
        6 => "Saturday",
        7 => "Sunday");
        $today_time = intval(date('Hi', $starttime));
        $today_weekday = date("w", $starttime) == 0 ? 7 : date("w", $starttime);
        //Replace : with nothing in HH:mm string and get intval of the result
        $time_of_day = intval(str_replace(":", "", $this->getVar('rule_timeofday', 'n')));
        switch ($this->getVar('rule_weekday')) {
            case 0:
                $add_days = 0;
                if ($time_of_day <= $today_time || $today_weekday == 0) {
                    $add_days=1;
                }

                if ($time_of_day <= $today_time && $today_weekday == 5) {
                    $add_days = 3;
                }
                elseif ($today_weekday == 6) {
                    $add_days = 2;
                }
                $day_clause = $add_days > 0 ? "+".$add_days." days" : "";
                break;

            default:
                if ($today_weekday == $this->getVar('rule_weekday') && $today_time < $time_of_day) {
                    $day_clause = "";
                }
                else {
                    $day_clause = "Next ".$day_array[$this->getVar('rule_weekday')];
                }
                break;
        }
        $time_string = "$day_clause ".$this->getVar('rule_timeofday', 'n');
        //        echo "$time_string <br />";

        $dispatchtime = strtotime($time_string, $starttime);
        return $dispatchtime > time() ? $dispatchtime : $this->getNextDispatchTime($dispatchtime);
    }
}

class SmartmailRuleHandler extends SmartPersistableObjectHandler {
    function SmartmailRuleHandler($db) {
        parent::SmartPersistableObjectHandler($db, "rule", "rule_id", "", "", "smartmail");
    }
}
?>