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
//  File:       admin/shoutboxSave.php                                       //
//  Version:    4.01                                                         //
//  ------------------------------------------------------------------------ //
//  Change Log                                                               //
//  ***                                                                      //
//  Version 4.01 Initial CVD Release 10/05/2008                              //
//  ***                                                                      //

if (!defined("XOOPS_MAINFILE_INCLUDED") || !strstr($_SERVER['PHP_SELF'], 'admin/index.php')) {
    exit();
}

$handler = xoops_getModuleHandler('database', 'shoutbox');

$id = intval($_POST['id']);
if (!$obj = $handler->get($id)) {
    /**
     * Or we got none, or something really strange happend here...
     */
    redirect_header("index.php", 3, _AM_SH_INVALID_ID);
}

if (!preg_match("/^[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}$/", $_POST['shoutboxIp'])) {
    // This check is far from perfect but...
    exit('Whoops! [ERROR 24]');
}

$obj->setVar('uname', $_POST['shoutboxUname']);
$obj->setVar('ip', $_POST['shoutboxIp']);
$obj->setVar('message', $_POST['shoutboxMessage']);


// Execute query
if($handler->insert($obj)) {
    redirect_header("index.php", 2, "Shout updated!");
} else {
    redirect_header("index.php", 4, "Error - Could not execute query...");
}

?>