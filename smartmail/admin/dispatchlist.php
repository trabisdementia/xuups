<?php
// $Id: dispatchlist.php,v 1.6 2006/09/27 20:21:18 marcan Exp $
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
smart_adminMenu(1);

$dispatch_handler = xoops_getmodulehandler('dispatch');
if (isset($_REQUEST['add'])) {

    $newsletterid = intval($_REQUEST['newsletterid']);
    $number = intval($_REQUEST['number']);

    $start_time = $dispatch_handler->getLastDispatchTime($newsletterid);

    $dispatch_handler->createNextDispatch($newsletterid, $start_time, $number);
}
$newsletter_handler = xoops_getmodulehandler('newsletter', 'smartmail');
$newsletterlist = $newsletter_handler->getList();

$criteria = new CriteriaCompo(new Criteria('dispatch_time', time(), ">="));
$criteria->add(new Criteria('dispatch_status', 0), 'OR');
if (isset($_REQUEST['id'])) {
    $criteria->add(new Criteria('newsletterid', intval($_REQUEST['id'])));
}

$criteria->setLimit(15);
$criteria->setSort("dispatch_time");
$criteria->setOrder("ASC");

$dispatches = $dispatch_handler->getObjects($criteria, true, false);
unset($criteria);
$xoopsTpl->assign('newsletterlist', $newsletterlist);
$xoopsTpl->assign('objects', $dispatches);

$smartOption['template_main'] = "smartmail_admin_dispatch_list.html";

// Dispatched ones, too:
$criteria = new CriteriaCompo(new Criteria("dispatch_status", 1, ">"));
if (isset($_REQUEST['id'])) {
    $criteria->add(new Criteria('newsletterid', intval($_REQUEST['id'])));
}
$start = isset($_REQUEST['start']) ? intval($_REQUEST['start']) : 0;
$criteria->setStart($start);
$criteria->setLimit(30);
$criteria->setSort("dispatch_time");
$criteria->setOrder("DESC");

$dispatched = $dispatch_handler->getObjects($criteria, true, false);
$dispatched_count = $dispatch_handler->getCount($criteria);
unset($criteria);

$xoopsTpl->assign("dispatched", $dispatched);

include_once XOOPS_ROOT_PATH."/class/pagenav.php";
$pagenav = new XoopsPageNav($dispatched_count, 30, $start, "start");
$xoopsTpl->assign('pagenav', $pagenav->renderNav(5));


if (isset($smartOption['template_main'])) {
    $xoopsTpl->display("db:".$smartOption['template_main']);
}
smart_modFooter ();
xoops_cp_footer();
?>