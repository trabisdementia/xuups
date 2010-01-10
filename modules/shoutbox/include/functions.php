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
//  File:       include/functions.php                                        //
//  Version:    4.01                                                         //
//  ------------------------------------------------------------------------ //
//  Change Log                                                               //
//  ***                                                                      //
//  Version 4.01 Initial CVD Release 10/05/2008                              //
//  ***                                                                      //
function shoutbox_getOption($option, $dirname = 'shoutbox')
{
    static $modOptions = array();
    if (is_array($modOptions) && array_key_exists($option, $modOptions)) {
        return $modOptions[$option];
    }

    $ret = null;
    $module_handler =& xoops_gethandler('module');
    $module =& $module_handler->getByDirname($dirname);
    $config_handler =& xoops_gethandler('config');
    if ($module) {
        $moduleConfig =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
        if (isset($moduleConfig[$option])) {
            $ret = $moduleConfig[$option];
        }
    }
    $modOptions[$option] = $ret;
    return $ret;
}

function shoutbox_makeGuestName()
{
    global $xoopsConfig;
    $ipadd = getenv('REMOTE_ADDR');
    $iparr = explode('.', $ipadd);
    $ipadd = $iparr[0] + $iparr[1] + $iparr[2] + $iparr[3];
    $guestname = $xoopsConfig['anonymous'] . $ipadd;
    return $guestname;
}

/**
 * Most of these functions were written (originally)
 * by Florian Solcher <e-xoops.alphalogic.org>
 */
function shoutbox_setCookie($timestamp)
{
    if(empty($_COOKIE['shoutcookie'])) {
        setcookie("shoutcookie", $timestamp);
        return false;
    }

    if($_COOKIE['shoutcookie'] < $timestamp) {
        setcookie("shoutcookie", $timestamp);
        return TRUE;
    } else {
        return FALSE;
    }
}

//irc like commands
function shoutbox_ircLike($command) {
    global $xoopsModuleConfig, $xoopsUser, $special_stuff_head;
    if ($command == "/quit") {
        $special_stuff_head .= '<script language="javascript">';
        $special_stuff_head .= '    top.window.close();';
        $special_stuff_head .= '</script>';
        return true;
    }
    $commandlines=explode(' ',$command);
    if (is_array($commandlines)) {
        //general commands
        //unregistered commands
        if (!$xoopsUser) {
            if (count($commandlines)==2) {
                if (($commandlines[0]=='/nick') && ($commandlines[1]!='')) {
                    if($xoopsModuleConfig['guests_may_chname'] == 1)
                    {
                        $special_stuff_head .= '<script language="javascript">';
                        $special_stuff_head .= '    top.document.location.href="popup.php?username='.htmlentities($commandlines[1], ENT_QUOTES).'";';
                        $special_stuff_head .= '</script>';
                        return true;
                    }else{
                        return true;
                    }
                }
            }
        }
    }
    return false;
}
?>