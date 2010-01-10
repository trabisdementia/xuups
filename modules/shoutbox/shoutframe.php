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
//  Date:       12/01/2008                                                   //
//  Module:     Shoutbox                                                     //
//  File:       shoutframe.php                                               //
//  Version:    4.04                                                         //
//  ------------------------------------------------------------------------ //
//  Change Log                                                               //
//  ***                                                                      //
//  Version 4.01 Initial CVD Release 10/05/2008                              //
//  ***                                                                      //
//  Version 4.02  11/01/2008                                                 //
//  New: Add guest avatar                                                    //
//  New: Add captcha for guest posts                                         //
//  ***                                                                      //
//  Version 4.03  11/15/2008                                                 //
//  New: Eliminate local module copy of the captcha class                    //
//  New: Add Frameworks captcha support                                      //
//  ***                                                                      //
//  Version 4.04  12/01/2008                                                 //
//  Bug Fix: Add passing UID to template to correct page refresh problem     //
//  Add selectable guest avatars                                             //
//  Add blank.gif assignment for guest avatar set to None                    //
//  ***                                                                      //

include_once dirname(__FILE__) . '/header.php';
include_once XOOPS_ROOT_PATH . '/modules/shoutbox/class/shoutbox.php';
include_once XOOPS_ROOT_PATH . '/modules/shoutbox/include/functions.php';

$shoutbox = new Shoutbox($xoopsModuleConfig['storage_type']);

// Admins may delete posts
if (!empty($_POST['clear']) && (!empty($xoopsUser)) && ($xoopsUser->isAdmin())) {
    $shoutbox->deleteShouts();
}

$addit = true;
$double = false;
$message = !empty($_POST['message']) ? trim($_POST['message']) : '';

$isUser = is_object($xoopsUser);
$isAnonymous = !$isUser && $xoopsModuleConfig['guests_may_post'];
$isMessage = !empty($message);
if ($isMessage && ($isUser || $isAnonymous)) {
    //Populate uid and name and verify captcha
    if ($isAnonymous) {
        $uid = 0;
        $post_uname = isset($_POST['uname']) ? trim($_POST['uname']) : '';
        if ($xoopsModuleConfig['guests_may_chname'] && !empty($post_uname)) {
            $uname = $post_uname;
        } else {
            $uname = shoutbox_makeGuestName();
        }
        if ($xoopsModuleConfig['captcha_enable']) {
            xoops_load('XoopsCaptcha');
            $xoopsCaptcha = XoopsCaptcha::getInstance();
            if (!$xoopsCaptcha->verify()) {
                $xoopsTpl->assign('captcha_error', $xoopsCaptcha->getMessage());
                $xoopsTpl->assign('message', $message);
                $xoopsTpl->assign('uname', $uname);
                $addit = false;
            }
        }
    } else {
        $uname = $xoopsUser->getVar('uname');
        $uid = $xoopsUser->getVar('uid');
    }

    //check if it is a double post
    if ($addit && $shoutbox->shoutExists($message)) {
        $addit = false;
        $xoopsTpl->assign('refresh', true);
    }

    if ($addit) {
        $shoutbox->saveShout($uid, $uname, $message);
        $shoutbox->pruneShouts($xoopsModuleConfig['maxshouts_trim']);
        $xoopsTpl->assign('refresh', true);
    }
}


$shouts = $shoutbox->getShouts(0, $xoopsModuleConfig['allow_bbcode'], $xoopsModuleConfig['maxshouts_view']);

if (!empty($shouts)) {
    $xoopsTpl->assign('shouts', $shouts);
}

$xoopsTpl->assign('config', $xoopsModuleConfig);

$xoopsTpl->xoops_setCaching(0);
$xoopsTpl->display('db:shoutbox_shoutframe.html');
?>