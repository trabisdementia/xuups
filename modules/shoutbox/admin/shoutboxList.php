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
//  File:       admin/shoutboxList.php                                       //
//  Version:    4.01                                                         //
//  ------------------------------------------------------------------------ //
//  Change Log                                                               //
//  ***                                                                      //
//  Version 4.01 Initial CVD Release 10/05/2008                              //
//  ***                                                                      //

if ( !defined("XOOPS_MAINFILE_INCLUDED") || !strstr($_SERVER['PHP_SELF'], 'admin/index.php') )  {
	exit();
}

include_once(XOOPS_ROOT_PATH.'/class/module.textsanitizer.php');
$sanitizer = new MyTextSanitizer;

	echo "<h4 style='text-align: left;'>"._AM_SH_CONFIG."</h4>\n";
	echo "	<table class='outer' width='100%' cellpadding='4' cellspacing='1'>
	<tr>
		<th width='15%' align='left'>"._AM_SH_POSTER."</th>
		<th width='15%' align='left'>"._AM_SH_LIST_TIME."</th>
		<th width='55%' align='center'>"._AM_SH_MESSAGE."</th>
		<th width='15%' align='right'>"._AM_SH_LIST_ACTION."</th>
	</tr>\n";

	$evodd = "even";
	$result = $xoopsDB->query("SELECT `id`, `uid`, `uname`, `time`, `ip`, `message` FROM ".$xoopsDB->prefix('shoutbox')." ORDER BY `time` DESC LIMIT 0, 50");

	if(!$xoopsDB->getRowsNum($result))
	{
		echo "<tr class='even' align='center'><td colspan='4'>"._AM_SH_LIST_NOSHOUTS."</td></tr>";
	}

    while (list($msg_id, $user_id, $uname, $time, $ip, $message) = $xoopsDB->fetchRow($result))
    {

	    if($evodd == "even")
	    {
			echo "<tr class='even' align='center' valign='top'>\n";
		}else{
			echo "<tr class='even' align='center' valign='top'>\n";
		}

	    echo   "<td align='left'>
	    			<div title='UID: $user_id | IP: $ip'>$uname"; if($user_id == 0) { echo '*'; } echo "</div>
	    		</td>
	    		<td align='left'>
	    			".formatTimestamp($time, _DATESTRING)."
	    		</td>
	    		<td align='center'>
	    			$message
	    		</td>
	    		<td align='right'>
	    			<a href='index.php?op=shoutboxEdit&amp;id=$msg_id'>"._EDIT."</a> / <a href='index.php?op=shoutboxRemove&amp;id=$msg_id'>"._DELETE."</a>
	    		</td>";

	    echo "</tr>";
    }

    echo "<tr class='foot'><td colspan='4'>&nbsp;</td></tr></table>";
?>