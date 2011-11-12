<?php
// $Id: newsletter.php,v 1.11 2006/09/25 19:44:52 marcan Exp $
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
include "header.php";

function getIdentifier($obj, $handler) {
    if ($handler->identifierName != "") {
        return $obj->getVar($handler->identifierName);
    }
    global $typetitle;
    return $typetitle;
}

$handler = xoops_getmodulehandler('newsletter');
$typetitle = _NL_AM_NEWSLETTER;
$xoopsTpl->assign('typetitle', $typetitle);
$typetemplate = "smartmail_admin_list.html";
$sortby = "newsletter_name";
$order = "ASC";

$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : ($id > 0 ? "details" : "list");

switch ($op) {
    default:
    case "list":

        smart_xoops_cp_header();
        smart_adminMenu(0);

        $xoopsTpl->assign('typetitle', $typetitle);
        $criteria = new CriteriaCompo();

        $count = $handler->getCount($criteria);
        $start = isset($_REQUEST['start']) ? intval($_REQUEST['start']) : 0;
        $limit = 20;
        $criteria->setStart($start);
        $criteria->setLimit($limit);
        if (isset($sortby) && $sortby != "") {
            $criteria->setSort($sortby);
            $criteria->setOrder($order);
        }
        $objects =& $handler->getObjects($criteria, true, false);
        unset($criteria);
        if (count($objects) > 0) {
            $xoopsTpl->assign('objects', $objects);
            $criteria = new Criteria('newsletterid', "(".implode(',', array_keys($objects)).")", "IN");
            $criteria->setGroupby("newsletterid");
            $subscriber_handler = xoops_getmodulehandler('subscriber');
            $xoopsTpl->assign('receiver_counts', $subscriber_handler->getCount($criteria));
        }
        $smartOption['template_main'] = $typetemplate;

        if ($count > $limit) {
            include_once XOOPS_ROOT_PATH."/class/pagenav.php";
            $nav = new XoopsPageNav($count, $limit, $start, "start");
            $xoopsTpl->assign("pagenav", $nav->renderNav(20));
        }

        /**
         * Implementing the SmartObject Table
         * Tobe continued...
         */
        /*
         include_once SMARTOBJECT_ROOT_PATH."class/smartobjecttable.php";
         $objectTable = new SmartObjectTable($handler);
         $objectTable->addColumn(new SmartObjectColumn('name'));
         $objectTable->addColumn(new SmartObjectColumn('description'));
         //		$objectTable->addColumn(new SmartObjectColumn(_AM_SOBJECT_SENT_TAGS_FROM, $align='left', $width=false, 'getFromInfo'));


         $objectTable->setDefaultSort('newsletter_id');

         $objectTable->addIntroButton('addtag', 'newsletter.php?op=new', _NL_AM_CREATE_NEWSLETTER);

         $objectTable->render();
         */


        break;

    case "new":

        smart_xoops_cp_header();
        smart_adminMenu(0);

        $obj =& $handler->create();
        $form =& $obj->getForm(false, _ADD." ".$typetitle);
        $form->display();
        break;

    case "edit":
        if (!isset($_REQUEST['id'])) {
            redirect_header('index.php', 2, _NL_AM_NOSELECTION);
        }

        smart_xoops_cp_header();
        smart_adminMenu(0);

        $obj =& $handler->get($_REQUEST['id']);
        $form =& $obj->getForm(false, _EDIT." ".$typetitle);
        $form->display();
        break;

    case "save":
        if (isset($_REQUEST['id'])) {
            $obj =& $handler->get($_REQUEST['id']);
        }
        else {
            $obj =& $handler->create();
        }

        $obj->processFormSubmit();

        if ($handler->insert($obj) && $obj->postSave()) {
            redirect_header('newsletter.php?op=list', 3, sprintf(_NL_AM_SAVEDSUCCESS, getIdentifier($obj, $handler)));
        }
        else {
            echo "<div class='errorMsg'>".implode('<br />', $obj->getErrors())."</div>";
            $form =& $obj->getForm();
            $form->display();
        }
        break;

    case "delete":
        $obj =& $handler->get($_REQUEST['id']);
        if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
            if ($handler->delete($obj)) {
                redirect_header('newsletter.php?op=list', 3, sprintf(_NL_AM_DELETEDSUCCESS, $typetitle));
            }
            else {
                echo implode('<br />', $obj->getErrors());
            }
        }
        else {

            smart_xoops_cp_header();
            smart_adminMenu(0);
            xoops_confirm(array('ok' => 1, 'id' => $_REQUEST['id'], 'op' => 'delete'), 'newsletter.php', sprintf(_NL_AM_RUSUREDEL, getIdentifier($obj, $handler)));
        }
        break;

    case "details":

        smart_xoops_cp_header();
        smart_adminMenu(0);

        $newsletter = $handler->get($id);
        $newsletter_arr = $newsletter->toArray();

        $xoopsTpl->assign('newsletter', $newsletter_arr);

        $rule_handler = xoops_getmodulehandler('rule');
        $newsletter_criteria = new Criteria('newsletterid', $id);
        $criteria = new CriteriaCompo($newsletter_criteria);

        $rules = $rule_handler->getObjects($newsletter_criteria, true, false);
        if (count($rules) > 0) {
            foreach (array_keys($rules) as $i) {
                if (file_exists(XOOPS_ROOT_PATH."/language/".$GLOBALS['xoopsConfig']['language']."/calendar.php")) {
                    include_once XOOPS_ROOT_PATH."/language/".$GLOBALS['xoopsConfig']['language']."/calendar.php";
                }
                else {
                    include_once XOOPS_ROOT_PATH."/language/english/calendar.php";
                }
                switch ($rules[$i]['rule_weekday']) {
                    case 0:
                        $day = _NL_AM_EVERYDAY;
                        break;

                    case 1:
                        $day = _CAL_MONDAY;
                        break;

                    case 2:
                        $day = _CAL_TUESDAY;
                        break;

                    case 3:
                        $day =_CAL_WEDNESDAY;
                        break;

                    case 4:
                        $day = _CAL_THURSDAY;
                        break;

                    case 5:
                        $day = _CAL_FRIDAY;
                        break;

                    case 6:
                        $day = _CAL_SATURDAY;
                        break;

                    case 7:
                        $day =_CAL_SUNDAY;

                }
                $rules[$i]['ruleday'] = $day;
            }

            $xoopsTpl->assign('rules', $rules);
        }

        $rule_example = $rule_handler->create();
        $form = $rule_example->getForm("newsletterrule.php");
        $form->assign($xoopsTpl);

        $hDispatch =  xoops_getmodulehandler('dispatch');
        $dispatch_example = $hDispatch->create();
        $dispatch_example->setVar('newsletterid', $id);
        $xoopsTpl->assign('output', $dispatch_example->build(true));

        $smartOption['template_main'] = "smartmail_admin_newsletter_details.html";
        break;
}
if (isset($smartOption['template_main'])) {
    $xoopsTpl->display("db:".$smartOption['template_main']);
}
smart_modFooter ();
xoops_cp_footer();
?>