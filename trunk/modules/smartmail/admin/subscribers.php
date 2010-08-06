<?php
// $Id: subscribers.php,v 1.1 2006/09/16 11:59:50 mith Exp $
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
smart_xoops_cp_header();
smart_adminMenu(0);
$handler = xoops_getmodulehandler('subscriber');
$typetitle = _NL_AM_SUBSCRIBERS;
$xoopsTpl->assign('typetitle', $typetitle);
$typetemplate = "smartmail_admin_subscriberlist.html";

$id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : "list";

switch ($op) {
    default:
    case "list":
        $criteria = new CriteriaCompo(new Criteria('newsletterid', $id));
        $count = $handler->getCount($criteria);
        $start = isset($_REQUEST['start']) ? intval($_REQUEST['start']) : 0;
        $limit = 50;
        $subscribers =& $handler->getRecipientList($id, $limit, $start);
        unset($criteria);
        if (count($subscribers) > 0) {
            $xoopsTpl->assign('subscribers', $subscribers);
        }
        $smartOption['template_main'] = $typetemplate;

        if ($count > $limit) {
            include_once XOOPS_ROOT_PATH."/class/pagenav.php";
            $nav = new XoopsPageNav($count, $limit, $start, "start");
            $xoopsTpl->assign("pagenav", $nav->renderNav(50));
        }

        $newsletter_handler = xoops_getmodulehandler('newsletter');
        $xoopsTpl->assign('newsletter', $newsletter_handler->get($id, false));

        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $form = new XoopsForm('', 'form', 'subscribers.php');
        $form->addElement(new XoopsFormHidden('id', $id));
        $form->addElement(new XoopsFormHidden('op', 'add'));
        $form->addElement(new XoopsFormSelectUser('', 'uid'));
        $form->addElement(new XoopsFormButton('', 'submit', _NL_AM_ADDUSER, 'submit'));
        $form->assign($xoopsTpl);
        break;

    case "add":
        if ($id == 0 || !isset($_REQUEST['uid'])) {
            redirect_header('index.php', 2, _NL_AM_NOSELECTION);
        }
        $uid = intval($_REQUEST['uid']);
        $user_handler = xoops_gethandler('user');
        $user = $user_handler->get($uid);
        if ($handler->subscribe($user, $id)) {
            redirect_header('subscribers.php?id='.$id, 3, _NL_AM_USERADDED);
        }
        else {
            redirect_header('subscribers.php?id='.$id, 3, _NL_AM_USERNOTADDED);
        }
        break;

    case "remove":
        if ($id == 0 || !isset($_REQUEST['uid'])) {
            redirect_header('index.php', 2, _NL_AM_NOSELECTION);
        }
        $uid = intval($_REQUEST['uid']);
        $subscriber = $handler->getByUser($uid, $id);
        if ($handler->unsubscribe($subscriber)) {
            redirect_header('subscribers.php?id='.$id, 3, _NL_AM_USERREMOVED);
        }
        else {
            redirect_header('subscribers.php?id='.$id, 3, _NL_AM_USERNOTREMOVED);
        }
        break;

    case "import":
        //Empty for now
        break;
}
if (isset($smartOption['template_main'])) {
    $xoopsTpl->display("db:".$smartOption['template_main']);
}
smart_modFooter ();
xoops_cp_footer();
?>