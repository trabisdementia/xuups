<?php
/************************************************************************/
/* Donations - Paypal financial management module for Xoops 2           */
/* Copyright (c) 2004 by Xoops2 Donations Module Dev Team			    */
/* http://dev.xoops.org/modules/xfmod/project/?group_id=1060			*/
/* $Id$      */
/************************************************************************/
/*                                                                      */
/* Based on NukeTreasury for PHP-Nuke - by Dave Lawrence AKA Thrash     */
/* NukeTreasury - Financial management for PHP-Nuke                     */
/* Copyright (c) 2004 by Dave Lawrence AKA Thrash                       */
/*                       thrash@fragnastika.com                         */
/*                       thrashn8r@hotmail.com                          */
/*                                                                      */
/************************************************************************/
/*                                                                      */
/* This program is free software; you can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/*                                                                      */
/* This program is distributed in the hope that it will be useful, but  */
/* WITHOUT ANY WARRANTY; without even the implied warranty of           */
/* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU     */
/* General Public License for more details.                             */
/*                                                                      */
/* You should have received a copy of the GNU General Public License    */
/* along with this program; if not, write to the Free Software          */
/* Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307  */
/* USA                                                                  */
/************************************************************************/


$module_handler =& xoops_gethandler('module');
$xoopsModule =& XoopsModule::getByDirname('xdonations');
$moduleInfo =& $module_handler->get($xoopsModule->getVar('mid'));
$pathIcon32 = $moduleInfo->getInfo('icons32');

$adminmenu = array();

$i = 1;
$adminmenu[$i]['title'] = _MI_DON_MENU_00 ;
$adminmenu[$i]['link']  = 'admin/index.php' ;
$adminmenu[$i]['icon']  = '../../'.$pathIcon32.'/home.png' ;
$i++;

$adminmenu[$i] = array ('title'      => _MI_DON_TREASURY_F_REGISTER,
                        'link'       => "admin/donations.php?op=Treasury",
                        'icon'       => '../../'.$pathIcon32.'/calculator.png', // or business.png
                        );

                        $i++;
                        $adminmenu[$i] = array ('title'      => _MI_DON_SHOW_LOG,
                        'link'       => "admin/donations.php?op=ShowLog",
                        'icon'       => '../../'.$pathIcon32.'/view_text.png',
                        );

                        $i++;
                        $adminmenu[$i] = array ('title'      => _MI_DON_SHOW_TXN,
                        'link'       => "admin/transaction.php",
                        'icon'       => '../../'.$pathIcon32.'/view_detailed.png',
                        );

                        $i++;
                        $adminmenu[$i] = array ('title'      => _MI_DON_CONFIGURATION,
                        'link'       => "admin/donations.php?op=Config",
                        'icon'       => '../../'.$pathIcon32.'/administration.png',
                        );
						
						$i++;
$adminmenu[$i]["title"] = _MI_DON_ADMIN_ABOUT;
$adminmenu[$i]["link"] = 'admin/about.php';
$adminmenu[$i]["icon"] = '../../'.$pathIcon32.'/about.png';
						
?>
