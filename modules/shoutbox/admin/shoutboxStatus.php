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
//  File:       admin/shoutboxStatus.php                                     //
//  Version:    4.01                                                         //
//  ------------------------------------------------------------------------ //
//  Change Log                                                               //
//  ***                                                                      //
//  Version 4.01 Initial CVD Release 10/05/2008                              //
//  ***                                                                      //

if (!defined("XOOPS_MAINFILE_INCLUDED") || !strstr($_SERVER['PHP_SELF'], 'admin/index.php')) {
    exit();
}

// Count shouts in database and file
// Database:
$query = $xoopsDB->query("SELECT count(*) FROM ".$xoopsDB->prefix("shoutbox"));
$query = $xoopsDB->fetchRow($query);
$count_database = $query[0];
// File:
$path = XOOPS_ROOT_PATH.'/uploads/shoutbox/shout.csv';
$count_file = count(file($path));

// Size
// Database:
// [Source: http://www.webmasterworld.com/forum88/2069.htm]
$rows = $xoopsDB->queryF("SHOW table STATUS");
while ($row = $xoopsDB->fetchBoth($rows)) {
    if($row['Name'] == $xoopsDB->prefix("shoutbox")) {
        $size_database = $row['Data_length'] + $row['Index_length'];
    }
}
// File:
$size_file = filesize($path);

echo "
<table width='100%' class='outer' cellspacing='1'>
<tbody>
<tr>
<th colspan='2'>"._AM_SH_STATUS_TITLE."</th>
</tr>


<tr valign='top' align='left'>
<td class='odd'>
<b>"._AM_SH_STATUS_STORAGETYPE."</b>
</td>
<td class='even'>
$xoopsModuleConfig[storage_type]
</td>
</tr>
<tr valign='top' align='left'>
<td class='odd'>
<ul>
<li>"._AM_SH_STATUS_INDB."</li>
</ul>
</td>
<td class='even'>
$count_database
</td>
</tr>
<tr valign='top' align='left'>
<td class='odd'>
<ul>
<li>"._AM_SH_STATUS_INFILE."</li>
</ul>
</td>
<td class='even'>
$count_file
</td>
</tr>


<tr valign='top' align='left'>
<td class='odd'>
<b>"._AM_SH_STATUS_SIZEDB."</b>
</td>
<td class='even'>
$size_database bytes
</td>
</tr>
<tr valign='top' align='left'>
<td class='odd'>
<b>"._AM_SH_STATUS_SIZEFILE."</b>
</td>
<td class='even'>
$size_file bytes
</td>
</tr>


<tr class='foot'>
<td colspan='2' align='center'>
&nbsp;
</td>
</tr>
</tbody>
</table>
";
?>