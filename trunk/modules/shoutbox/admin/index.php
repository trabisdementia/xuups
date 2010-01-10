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
//  File:       admin/index.php                                              //
//  Version:    4.01                                                         //
//  ------------------------------------------------------------------------ //
//  Change Log                                                               //
//  ***                                                                      //
//  Version 4.01 Initial CVD Release 10/05/2008                              //
//  ***                                                                      //

// Hello admin?
include '../../../include/cp_header.php';
// Admin!

function shoutboxDefault()
{
    global $xoopsModuleConfig;

    if($xoopsModuleConfig['storage_type'] == 'database') {
        $database = '['._AM_SH_EDIT_INUSE.']';
        $file = '';
    } else if($xoopsModuleConfig['storage_type'] == 'file') {
        $database = '';
        $file = '['._AM_SH_EDIT_INUSE.']';
    }

    echo "
    <h1>"._AM_SH_CONFIG."</h1>
    <br />
    "._AM_SH_CHOOSE."
    <ul>
    <li><a href='index.php?op=shoutboxList'>" . _AM_SH_EDIT_DB . "</a> $database</li>
    <li><a href='index.php?op=shoutboxFile'>" . _AM_SH_EDIT_FILE . "</a> $file</li>
    <li><a href='index.php?op=shoutboxStatus'>" . _AM_SH_STATUSOF . "</a></li>
    </ul>
    <br />
    ";
}

function shoutboxList()
{
    global $xoopsDB;
    include 'shoutboxList.php';
}

function shoutboxEdit()
{
    global $xoopsDB;
    include 'shoutboxEdit.php';
}

function shoutboxSave()
{
    global $xoopsDB;
    include 'shoutboxSave.php';
}

function shoutboxRemove()
{
    global $xoopsDB;
    include 'shoutboxRemove.php';
}

function shoutboxFile()
{
    global $xoopsDB;
    include 'shoutboxFile.php';
}

function shoutboxStatus()
{
    global $xoopsDB, $xoopsModuleConfig;
    include 'shoutboxStatus.php';
}

$op = empty($_GET["op"]) ? '' : $_GET["op"];

switch ($op){
    case "shoutboxList":
        xoops_cp_header();
        shoutboxList();
        break;

    case "shoutboxEdit":
        xoops_cp_header();
        shoutboxEdit();
        break;

    case "shoutboxSave":
        shoutboxSave();
        break;

    case "shoutboxRemove":
        shoutboxRemove();
        break;

    case "shoutboxFile":
        xoops_cp_header();
        shoutboxFile();
        break;

    case "shoutboxStatus":
        xoops_cp_header();
        shoutboxStatus();
        break;

    default:
        xoops_cp_header();
        shoutboxDefault();
        break;

}

xoops_cp_footer();
?>