<?php
// $Id: menu.php,v 1.4 2006/08/30 21:10:04 mith Exp $
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
$adminmenu[] = array("title" => _NL_MI_NEWSLETTERS,
					"link" => "admin/newsletter.php");
$adminmenu[] = array("title" => _NL_MI_DISPATCHES,
					"link" => "admin/dispatchlist.php");
$adminmenu[] = array("title" => _NL_MI_PERMISSIONS,
					"link" => "admin/permissions.php");

if (isset($xoopsModule)) {

    $i = -1;

    $i++;
    $headermenu[$i]['title'] = _PREFERENCES;
    $headermenu[$i]['link'] = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid');

    $i++;
    $headermenu[$i]['title'] = _CO_SOBJECT_GOTOMODULE;
    $headermenu[$i]['link'] = XOOPS_URL."/modules/smartmail";

    $i++;
    $headermenu[$i]['title'] = _CO_SOBJECT_UPDATE_MODULE;
    $headermenu[$i]['link'] = XOOPS_URL . "/modules/system/admin.php?fct=modulesadmin&op=update&module=" . $xoopsModule->getVar('dirname');

    $i++;
    $headermenu[$i]['title'] = _AM_SOBJECT_ABOUT;
    $headermenu[$i]['link'] = XOOPS_URL . "/modules/smartmail/admin/about.php";
}
?>