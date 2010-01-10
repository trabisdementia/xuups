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
//  File:       popup.php                                                    //
//  Version:    4.01                                                         //
//  ------------------------------------------------------------------------ //
//  Change Log                                                               //
//  ***                                                                      //
//  Version 4.01 Initial CVD Release 10/05/2008                              //
//  ***                                                                      //

include_once dirname(__FILE__) .'/header.php';
include_once XOOPS_ROOT_PATH . '/modules/shoutbox/include/functions.php';
include_once XOOPS_ROOT_PATH . '/class/module.textsanitizer.php';

if(!is_object($xoopsUser) && (!$xoopsModuleConfig['popup_guests'] || !$xoopsModuleConfig['guests_may_post'])) {
    xoops_header(false);
    xoops_error("<br />You aren't allowed to enter this section!<br /><br />");
    xoops_footer();
    die();
}

$uname = isset($_POST['uname']) ? trim($_POST['uname']) : '';

if (!is_object($xoopsUser)) {
    if ($xoopsModuleConfig['guests_may_chname']==1 && !empty($uname)){
        $myts = MyTextSanitizer::getInstance();
        $xoopsTpl->assign('uname',$myts->htmlSpecialChars($uname, ENT_QUOTES));
    }else if(!$xoopsModuleConfig['guests_may_chname']) {
        $xoopsTpl->assign('uname', shoutbox_makeGuestName());
    } else {
        $xoopsTpl->assign('uname', '');
    }
} else {
    $xoopsTpl->assign('uname', $xoopsUser->uname());
}

ob_start();
include_once XOOPS_ROOT_PATH . '/include/xoopscodes.php';
xoopsSmilies('shoutfield');
$smiliesbar = str_replace("<a href='#moresmiley' onmouseover='style.cursor=\"hand\"' alt=''","<a href='#moresmiley' onmouseover='style.cursor=\"hand\"' title='More'", ob_get_contents());
ob_end_clean();

$xoopsTpl->assign('smiliesbar', $smiliesbar);
$xoopsTpl->assign('config', $xoopsModuleConfig);

$xoopsTpl->xoops_setCaching(0);
$xoopsTpl->display('db:shoutbox_popup.html');
?>