<?php
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
//  Original Author: Alphalogic <alphafake@hotmail.com>					     //
//  Original Author Website: http://www.alphalogic-network.de		         //
//  ------------------------------------------------------------------------ //
//  XOOPS Version made by: (XOOPS 1.3.x and 2.0.x version)			         //
//  Jan304 <http://www.jan304.org>									         //
//  ------------------------------------------------------------------------ //
//  Author:     tank                                                         //
//  Website:    http://www.customvirtualdesigns.com                          //
//  E-Mail:     tanksplace@comcast.net                                       //
//  Date:       10/05/2008                                                   //
//  Module:     Shoutbox                                                     //
//  File:       online.php                                                   //
//  Version:    4.01                                                         //
//  ------------------------------------------------------------------------ //
//  Change Log                                                               //
//  ***                                                                      //
//  Version 4.01 Initial CVD Release 10/05/2008                              //
//  ***                                                                      //
include_once dirname(__FILE__) . '/header.php';

$online_handler =& xoops_gethandler('online');
// set gc probabillity to 10% for now..
if (mt_rand(1, 100) < 11) {
    $online_handler->gc(300);
}
if (is_object($xoopsUser)) {
    $uid = $xoopsUser->getVar('uid');
    $uname = $xoopsUser->getVar('uname');
} else {
    $uid = 0;
    $uname = '';
}

$online_handler->write($uid, $uname, time(), $xoopsModule->getVar('mid'), $_SERVER['REMOTE_ADDR']);

$start = isset($_GET['start']) ? intval($_GET['start']) : 0;
$online_handler =& xoops_gethandler('online');
$online_total =& $online_handler->getCount();
$limit = ($online_total > 2) ? 20 : $online_total;
$criteria = new CriteriaCompo();
$criteria->setLimit($limit);
$criteria->setStart($start);
$onlines =& $online_handler->getAll($criteria);
$count = count($onlines);
$anonymous_count = 0;
for ($i = 0; $i < $count; $i++) {
    if ($onlines[$i]['online_uid'] == 0) {
        $onlineUsers[$i]['uname'] = $xoopsConfig['anonymous'];
        $onlineUsers[$i]['uid'] = 0;
        $anonymous_count++;
    } else {
        $thisUser =& new XoopsUser($onlines[$i]['online_uid']);
        $onlineUsers[$i]['uname'] = $thisUser->getVar('uname');
        $onlineUsers[$i]['uid'] = $thisUser->getVar('uid');
    }
}

if ($online_total > 20) {
    include_once XOOPS_ROOT_PATH . '/class/pagenav.php';
    $nav = new XoopsPageNav($online_total, 20, $start, 'start', '');
    $xoopsTpl->assign('online_navigation', $nav->renderNav());
}

$xoopsTpl->assign('users', $onlineUsers);
$xoopsTpl->assign('anonymous_count', $anonymous_count);
$xoopsTpl->assign('online_total', $online_total);

$xoopsTpl->xoops_setCaching(0);
$xoopsTpl->display('db:shoutbox_online.html');
?>