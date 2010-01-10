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
//  Date:       12/15/2008                                                   //
//  Module:     Shoutbox                                                     //
//  File:       blocks/shoutbox.php                                          //
//  Version:    4.05                                                         //
//  ------------------------------------------------------------------------ //
//  Change Log                                                               //
//  ***                                                                      //
//  Version 4.01 Initial CVD Release 10/05/2008                              //
//  ***                                                                      //
//  Version 4.02  11/01/2008                                                 //
//  New: Add captcha for guest posts                                         //
//  ***                                                                      //
//  Version 4.03  11/15/2008                                                 //
//  New: Eliminate local module copy of the captcha class                    //
//  New: Add Frameworks captcha support                                      //
//  ***                                                                      //
//  Version 4.05  12/15/2008                                                 //
//  Bug Fix: Move smi-bar string replace function inside comparison to       //
//           elimnate calling when not enabled                               //
//  ***                                                                      //

//
// Function for displaying Shoutbox
//

function b_shoutbox_show($options)
{
    include_once XOOPS_ROOT_PATH . '/modules/shoutbox/include/functions.php';
    global $xoopsUser, $xoopsConfig;

    $module_handler =& xoops_gethandler('module');
    $module =& $module_handler->getByDirname('shoutbox');
    $config_handler =& xoops_gethandler('config');
    $block =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));

    if ($block['captcha_enable']) {
        xoops_load('XoopsFormCaptcha');
        $shoutcaptcha = new XoopsFormCaptcha();
        $block['captcha_caption'] = $shoutcaptcha->getCaption();
        $block['captcha_render'] = $shoutcaptcha->render();
    }

    $block['shoutbox_access'] = false;
    if (is_object($xoopsUser)) {
        $block['shoutbox_access'] = true;
        $block['shoutbox_uname'] = $xoopsUser->getVar('uname');
        $block['shoutbox_userid'] = $xoopsUser->getVar('uid');
    } else if ($block['guests_may_post']) {
        $block['shoutbox_access'] = true;
        $block['shoutbox_uname'] = shoutbox_makeGuestName();
        $block['shoutbox_uid'] = 0;
    }

    $block['shoutbox_anonymous'] = $xoopsConfig['anonymous'];

    if($block['show_smileybar']) {
        ob_start();
        include_once XOOPS_ROOT_PATH . '/include/xoopscodes.php';
        xoopsSmilies('shoutfield');
        $block['shoutbox_smibar'] = ob_get_contents();
        ob_end_clean();
        $block['shoutbox_smibar'] = str_replace("<a href='#moresmiley' onmouseover='style.cursor=\"hand\"' alt=''","<a href='#moresmiley' onmouseover='style.cursor=\"hand\"' title='More'",   $block['shoutbox_smibar']);
    }

    if(!is_object($xoopsUser) && !$block['popup_guests']){
        $block['popup'] = false;
    }

    return $block;
}

?>