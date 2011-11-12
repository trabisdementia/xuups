<?php
// $Id$
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

include_once dirname(__FILE__) . '/admin_header.php';
xoops_cp_header();

$menu = new Xmf_Template_Adminmenu();
$menu->display();

$nav = new Xmf_Template_Adminnav();
$nav->display();

$index = new Xmf_Template_Adminindex();


$result = $xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix("xoopspoll_desc") . "") ;
list($totalPolls) = $xoopsDB->fetchRow($result) ;

$result = $xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix("xoopspoll_desc") . " WHERE end_time < UNIX_TIMESTAMP()") ;
list($totalNonActivePolls) = $xoopsDB->fetchRow($result) ;

$totalActivePolls =  $totalPolls - $totalNonActivePolls;

$infoBox = new Xmf_Template_Infobox();
$infoBox->setTitle(_MD_XOOPSPOLL_DASHBOARD) ;
$infoBox->addLine(_MD_XOOPSPOLL_TOTALACTIVE . "<span style='color : green; font-weight : bold;'>". $totalActivePolls. "</span>\n <br />") ;//, 'Green'
$infoBox->addLine( _MD_XOOPSPOLL_TOTALNONACTIVE. "<span style='color : red; font-weight : bold;'>" .$totalNonActivePolls.  "</span>\n <br />") ;//, 'Red'
$infoBox->addLine( _MD_XOOPSPOLL_TOTALPOLLS. "<span style='color : black; font-weight : bold;'>" .$totalPolls.  "</span>\n <br />") ;

$index->addInfoBox($infoBox);

$index->display();

include_once 'admin_footer.php';