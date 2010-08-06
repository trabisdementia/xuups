<?php
// $Id: dispatch.php,v 1.8 2006/09/25 19:44:52 marcan Exp $
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

$handler = xoops_getmodulehandler('dispatch');
$typetitle = _NL_AM_DISPATCH;
$xoopsTpl->assign('typetitle', $typetitle);

$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : "new";
switch ($op) {
    default:
    case "new":

        smart_xoops_cp_header();
        smart_adminMenu(1);

        $newsletterid = isset($_REQUEST['nid']) ?  intval($_REQUEST['nid']) : redirect_header('index.php', 2, _NL_AM_NOSELECTION);
        $obj =& $handler->create();
        $obj->setVar('newsletterid', $newsletterid);
        $form =& $obj->getForm(false, _ADD." ".$typetitle);
        $form->display();
        break;

    case "next":

        smart_xoops_cp_header();
        smart_adminMenu(1);

        $newsletterid = isset($_REQUEST['nid']) ?  intval($_REQUEST['nid']) : redirect_header('index.php', 2, _NL_AM_NOSELECTION);
        $obj =& $handler->create();
        $obj->setVar('newsletterid', $newsletterid);
        //$obj->setVar('dispatch_time', $obj->getNextDispatch($handler->getLastDispatchTime($newsletterid)));
        $form =& $obj->getForm(false, _ADD." ".$typetitle);
        $form->display();
        break;

    case "edit":
        if (!isset($_REQUEST['id'])) {
            redirect_header('index.php', 2, _NL_AM_NOSELECTION);
        }

        smart_xoops_cp_header();
        smart_adminMenu(1);

        $obj =& $handler->get($_REQUEST['id']);
        $form =& $obj->getForm(false, _EDIT." ".$typetitle);
        $form->assign($xoopsTpl);

        /**
         * @todo  Add blocks to this page, too - at least the dispatch-specific ones
         */
        $xoopsTpl->assign('output', $obj->build(true));

        //Add block form
        $block_handler = xoops_getmodulehandler('block');
        $form = $block_handler->getAddBlockForm($obj->getVar('newsletterid'), $_REQUEST['id']);
        $form->assign($xoopsTpl);

        $smartOption['template_main'] = "smartmail_admin_dispatch_edit.html";
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
            redirect_header('dispatchlist.php?id='.$obj->getVar('newsletterid'), 3, sprintf(_NL_AM_SAVEDSUCCESS, $obj->getVar('dispatch_subject')));
        }
        else {

            smart_xoops_cp_header();
            smart_adminMenu(1);

            echo "<div class='errorMsg'>".implode('<br />', $obj->getErrors())."</div>";
            $form =& $obj->getForm();
            $form->display();
        }
        break;

    case "delete":
        $obj =& $handler->get($_REQUEST['id']);
        if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
            if ($handler->delete($obj)) {
                redirect_header('dispatchlist.php?id='.intval($obj->getVar('newsletterid')), 3, sprintf(_NL_AM_DELETEDSUCCESS, _NL_AM_DISPATCH));
            }
            else {
                echo implode('<br />', $obj->getErrors());
            }
        }
        else {
            smart_xoops_cp_header();
            smart_adminMenu(1);

            xoops_confirm(array('ok' => 1, 'id' => $_REQUEST['id'], 'op' => 'delete'), 'dispatch.php', sprintf(_NL_AM_RUSUREDEL, _NL_AM_DISPATCH));
        }
        break;

}

if (isset($smartOption['template_main'])) {
    $xoopsTpl->display("db:".$smartOption['template_main']);
}
smart_modFooter ();
xoops_cp_footer();
?>