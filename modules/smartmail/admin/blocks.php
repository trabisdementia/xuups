<?php
// $Id: blocks.php,v 1.4 2006/06/18 16:04:03 marcan Exp $
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
smart_xoops_cp_header();
smart_adminMenu(0);

$handler = xoops_getmodulehandler('newsletter');
$typetitle = _NL_AM_NEWSLETTER;
$xoopsTpl->assign('typetitle', $typetitle);

$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : "details";
$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : redirect_header("javascript: history.back(-1)");

switch ($op) {
    default:
    case "blocks":
        $newsletter = $handler->get($id);
        $newsletterblock_handler = xoops_getmodulehandler('block');
        $newsletterblocks = $newsletterblock_handler->getByNewsletter($newsletter->getVar('newsletter_id'));

        //Add block form
        $form = $newsletterblock_handler->getAddBlockForm($id);

        $form->assign($xoopsTpl);
        if (isset($newsletterblocks[$newsletter->getVar('newsletter_id')])) {
            ksort($newsletterblocks[$newsletter->getVar('newsletter_id')]);
            $xoopsTpl->assign('blocks', $newsletterblocks[$newsletter->getVar('newsletter_id')]);
        }
        $xoopsTpl->assign("newsletterid", $newsletter->getVar('newsletter_id'));
        $smartOption['template_main'] = "smartmail_admin_block_list.html";

        break;

    case "block":
        $block_handler =& xoops_gethandler('block');
        $newsletterblock_handler = xoops_getmodulehandler('block');

        if (isset($_REQUEST['nb'])) {
            $newsletterblock = $newsletterblock_handler->get($_REQUEST['nb']);
            $block = $block_handler->get($newsletterblock->getVar('b_id'));
        }
        else {
            $bid = intval($_REQUEST['block_id']);
            $block = $block_handler->get($bid);
            $newsletterblock = $newsletterblock_handler->create();
            if (isset($_REQUEST['dispatchid'])) {
                $newsletterblock->setVar('dispatchid', intval($_REQUEST['dispatchid']));
            }
        }
        $newsletterblock->assignVar('newsletterid', $id);

        $newsletterblock->setBlock($block);
        $form = $newsletterblock->getForm();
        $form->display();


        break;

    case "block_save":
        $newsletterblock_handler = xoops_getmodulehandler('block');
        if (isset($_REQUEST['nb_id'])) {
            $newsletterblock = $newsletterblock_handler->get($_REQUEST['nb_id']);
        }
        else {
            $newsletterblock = $newsletterblock_handler->create();
        }
        $newsletterblock->assignVar('newsletterid', $id);
        $newsletterblock->assignVar('dispatchid', $_REQUEST['dispatchid']);
        $newsletterblock->setVar('b_id',$_REQUEST['block_id']);
        $newsletterblock->setVar('nb_title',$_REQUEST['block_title']);
        $newsletterblock->setVar('nb_position',$_REQUEST['block_pos']);
        $newsletterblock->setVar('nb_weight',$_REQUEST['block_weight']);
        $newsletterblock->setVar('nb_options',$_REQUEST['options']);
        if ($newsletterblock_handler->insert($newsletterblock)) {
            if ($_REQUEST['dispatchid'] > 0) {
                redirect_header("dispatch.php?op=edit&amp;id=".intval($_REQUEST['dispatchid']), 2, sprintf(_NL_AM_SAVEDSUCCESS, "Block"));
            }
            redirect_header("newsletter.php?id=".$id, 2, sprintf(_NL_AM_SAVEDSUCCESS, "Block"));
        }
        if (!file_exists(XOOPS_ROOT_PATH."/kernel/blockinstance.php")) {
            //Using 2.0.13.2 or lower
            include_once(XOOPS_ROOT_PATH."/class/xoopsblock.php");
            $block = new XoopsBlock($newsletterblock->getVar('b_id'));
        }
        else {
            $block_handler = xoops_gethandler('block');
            $block = $block_handler->get($newsletterblock->getVar('b_id'));
        }
        $newsletterblock->setBlock($block);

        echo implode('<br />', $newsletterblock->getErrors());
        $form = $newsletterblock->getForm();
        $form->display();

        break;

    case "block_delete":
        $newsletterblock_handler = xoops_getmodulehandler('block');
        $obj = $newsletterblock_handler->get($_REQUEST['block_id']);
        if (isset($_REQUEST['ok']) && $_REQUEST['ok'] == 1) {
            if ($newsletterblock_handler->delete($obj)) {
                redirect_header('newsletter.php?id='.intval($obj->getVar('newsletterid')), 3, sprintf(_NL_AM_DELETEDSUCCESS, _NL_AM_BLOCK));
            }
            else {
                echo implode('<br />', $obj->getErrors());
            }
        }
        else {
            xoops_confirm(array('ok' => 1, 'block_id' => intval($_REQUEST['block_id']), 'id' => $id, 'op' => 'block_delete'), 'blocks.php', sprintf(_NL_AM_RUSUREDEL, _NL_AM_BLOCK));
        }
        break;
}


if (isset($smartOption['template_main'])) {
    $xoopsTpl->display("db:".$smartOption['template_main']);
}
smart_modFooter ();
xoops_cp_footer();
?>