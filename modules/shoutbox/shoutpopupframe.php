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
//  File:       shoutpopupframe.php                                          //
//  Version:    4.04                                                         //
//  ------------------------------------------------------------------------ //
//  Change Log                                                               //
//  ***                                                                      //
//  Version 4.01 Initial CVD Release 10/05/2008                              //
//  ***                                                                      //
//  Version 4.02  11/01/2008                                                 //
//  New: Add guest avatar                                                    //
//  ***                                                                      //
//  Version 4.04  12/01/2008                                                 //
//  Add selectable guest avatars                                             //
//  Add blank.gif assignment for guest avatar set to None                    //
//  ***                                                                      //

include_once dirname(__FILE__) . '/header.php';
include_once XOOPS_ROOT_PATH . '/modules/shoutbox/class/shoutbox.php';
include_once XOOPS_ROOT_PATH . '/modules/shoutbox/include/functions.php';

$shoutbox = new Shoutbox($xoopsModuleConfig['storage_type']);


$online_handler =& xoops_gethandler('online');
mt_srand((double)microtime()*1000000);
// set gc probability to 10% for now..
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

$addit=1;
$special_stuff_head='';
$lastmine=0;
$double=0;
$newmessage=0;


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
       /* if ($xoopsModuleConfig['captcha_enable']) {
            xoops_load('XoopsCaptcha');
            $xoopsCaptcha = XoopsCaptcha::getInstance();
            if (!$xoopsCaptcha->verify()) {
                $xoopsTpl->assign('captcha_error', $xoopsCaptcha->getMessage());
                $xoopsTpl->assign('message', $message);
                $xoopsTpl->assign('uname', $uname);
                $addit = false;
            }
        }*/
    } else {
        $uname = $xoopsUser->getVar('uname');
        $uid = $xoopsUser->getVar('uid');
    }
    //check if it is a double post
    if ($addit && $shoutbox->shoutExists($message)) {
        $addit = false;
        $xoopsTpl->assign('refresh', true);
    }

    // Enable IRC Commands
    if($xoopsModuleConfig['popup_irc']==1 && isset($message) && strstr($message, '/')) {
        if(shoutbox_ircLike($message)) {
            unset($message);
            $addit = false;
            $xoopsTpl->assign('refresh', true);
        }
    }

    if ($addit) {
        $shoutbox->saveShout($uid, $uname, $message);
        $shoutbox->pruneShouts($xoopsModuleConfig['maxshouts_trim']);
        $xoopsTpl->assign('refresh', true);
    }
}

/*
if($shouts = file($shoutbox->csvfile))
{
    $totalshouts = count($shouts);
}

// Check or there is a new message
if(!empty($shouts))
{
    $oneline = explode("|", $shouts[$totalshouts-1]);

    /*
     echo '$_COOKIE["shoutcookie"] ='.$_COOKIE["shoutcookie"]."<br \>\n";
     echo '$online[2] ='.$oneline[2]."<br \>\n";
     echo '$time() ='.time()."<br \>\n";
     */
/*
    if($xoopsUser && $xoopsUser->uname() == $oneline[0])
    {
        $lastmine=1;
    }elseif(!empty($username) && $username == $oneline[0])
    {
        $lastmine=1;
    }

    if(shoutbox_setCookie($oneline[2]) && $lastmine==0)
    {
        $newmessage = 1;
    }
}
*/
$shouts = $shoutbox->getShouts(1, $xoopsModuleConfig['allow_bbcode'], $xoopsModuleConfig['maxshouts_view']);

if (!empty($shouts)) {
    $xoopsTpl->assign('shouts', $shouts);
} else {
    xoops_result(_MD_SHOUTBOX_POPUP_NOSHOUTS, 0);
}

$xoopsTpl->assign('lang_anonymous', $xoopsConfig['anonymous']);
$xoopsTpl->assign('special_stuff_head', $special_stuff_head);
$xoopsTpl->assign('newmessage', $newmessage);
$xoopsTpl->assign('config', $xoopsModuleConfig);

$xoopsTpl->xoops_setCaching(0);
$xoopsTpl->display('db:shoutbox_popupframe.html');
?>