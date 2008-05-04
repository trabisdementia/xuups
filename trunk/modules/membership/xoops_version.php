<?php
// $Id: xoops_version.php,v 1.13 2003/04/01 22:51:21 mvandam Exp $
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

$modversion['name']         = _MI_MEMBERSHIP_NAME;
$modversion['dirname']      = "membership";
$modversion['description']  = _MI_MEMBERSHIP_DESC;
$modversion['version']      = "2.0b";
$modversion['author']       = "SMD <webmaster@xoopsmalaysia.org><br />http://www.xoopsmalaysia.org";
$modversion['credits']      = "SMD <webmaster@xoopsmalaysia.org><br />http://www.xoopsmalaysia.org";
$modversion['license']      = "GNU/GPL";
$modversion['official']     = "No";
$modversion['image']        = "images/membership_logo.gif";

// Tables
$modversion['sqlfile']['mysql'] = "sql/tables.sql";
$i=0;
$modversion['tables'][$i] = "mship_ips";

// Blocks
$modversion['blocks'][1]['file'] 		= "membership_block.php";
$modversion['blocks'][1]['show_func'] 	= "show_membership_block";
$modversion['blocks'][1]['name'] 		= _MI_MEMBERSHIP_TITLE;
$modversion['blocks'][1]['description'] = _MI_MEMBERSHIP_DESC;
$modversion['blocks'][1]['edit_func'] = "membership_edit";
$modversion['blocks'][1]['options'] = "1";
$modversion['blocks'][1]['template'] = 'membership_block.html';


// Menu
$modversion['hasMain'] = 1;
$modversion['sub'][1]['name'] = _MI_MEMBERSHIP_SMNAME1;
$modversion['sub'][1]['url'] = "rank.php";

?>
