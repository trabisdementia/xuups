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
//  File:       admin/shoutboxRemove.php                                     //
//  Version:    4.01                                                         //
//  ------------------------------------------------------------------------ //
//  Change Log                                                               //
//  ***                                                                      //
//  Version 4.01 Initial CVD Release 10/05/2008                              //
//  ***                                                                      //

if (!defined("XOOPS_MAINFILE_INCLUDED") || !strstr($_SERVER['PHP_SELF'], 'admin/index.php')) {
    exit();
}
$id = intval($_REQUEST['id']);
$handler = xoops_getModuleHandler('database', 'shoutbox');
// Request or confirmation?
if (!empty($_POST['confirm']) && $_POST['confirm'] == 'yes') {
    // Sanitize inputs
    $obj = $handler->get($id);
    if (is_object($obj) && $handler->delete($obj)) {
        redirect_header("index.php", 2, _AM_SH_REMOVE_SUCCES);
    }else{
        redirect_header("index.php", 4, _AM_SH_REMOVE_FAILURE);
    }
} else {
    xoops_cp_header();
    // Check or we got a shout
    if (!$obj = $handler->get($id)) {
        /**
         * Or we got none, or something really strange happend here...
         */
        redirect_header("index.php", 3, _AM_SH_INVALID_ID);
    }

    // Make code ready for preview
    $shout = $obj->getValues();
    $shout['date'] = $obj->time(_DATESTRING);

    echo "
    <form action='index.php?op=shoutboxRemove' method='post'>
    <table width='100%' class='outer' cellspacing='1'>
    <tbody>
    <tr>
    <th colspan='2'>".sprintf(_AM_SH_REMOVE_TITLE, $shout['date'])."</th>
    </tr>
    <tr valign='top' align='left'>
    <td class='odd'>
    <b>"._AM_SH_POSTER."</b>
    </td>
    <td class='even'>
    $shout[uname]
    </td>
    </tr>
    <tr valign='top' align='left'>
    <td class='odd'>
    <b>"._AM_SH_REMOVE_FROM."</b>
    </td>
    <td class='even'>
    $shout[ip]
    </td>
    </tr>
    <tr valign='top' align='left'>
    <td class='odd'>
    <b>"._AM_SH_MESSAGE."</b>
    </td>
    <td class='even'>
    $shout[message]
    </td>
    </tr>
    <tr class='foot'>
    <td colspan='2' align='center'>
    <input type='hidden' name='id' value='$shout[id]' />
    <input type='hidden' name='confirm' value='yes' />
    <input type='submit' name='submit' value='"._DELETE."' />
    <input type='button' value='"._CANCEL."' onClick='location=\"index.php?op=shoutboxList\"' />
    </td>
    </tr>
    </tbody>
    </table>
    </form>
    ";
}
?>