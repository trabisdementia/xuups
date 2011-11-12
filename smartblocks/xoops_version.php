<?php
// $Id: xoops_version.php,v 1.2 2006/12/13 14:33:36 mithyt2 Exp $
###############################################################################
##                    XOOPS - PHP Content Management System                  ##
##                       Copyright (c) 2000 XOOPS.org                        ##
##                          <http://www.xoops.org/>                          ##
###############################################################################
##  This program is free software; you can redistribute it and/or modify     ##
##  it under the terms of the GNU General Public License as published by     ##
##  the Free Software Foundation; either version 2 of the License, or        ##
##  (at your option) any later version.                                      ##
##                                                                           ##
##  You may not change or alter any portion of this comment or credits       ##
##  of supporting developers from this source code or any supporting         ##
##  source code which is considered copyrighted (c) material of the          ##
##  original comment or credit authors.                                      ##
##                                                                           ##
##  This program is distributed in the hope that it will be useful,          ##
##  but WITHOUT ANY WARRANTY; without even the implied warranty of           ##
##  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            ##
##  GNU General Public License for more details.                             ##
##                                                                           ##
##  You should have received a copy of the GNU General Public License        ##
##  along with this program; if not, write to the Free Software              ##
##  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA ##
###############################################################################

$modversion['name'] = "SmartBlocks";
$modversion['version'] = 1.00;
$modversion['description'] = "Module for managing blocks more fine-grained than XOOPS default";
$modversion['author'] = "Jan Keller Pedersen <jkp@cusix.dk>";
$modversion['credits'] = "Michael Wulff Nielsen <naish@klanen.net>";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/module_logo.gif";
$modversion['dirname'] = "smartblocks";

//Database
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][0] = "smartblocks_fallback_location";
$modversion['tables'][1] = "smartblocks_pageblock";

$modversion['hasMain'] = 0;

//Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

$modversion['templates'][] = array('file' => "smartblocks_admin_blocks.html",
                                   'description' => "");
$modversion['templates'][] = array('file' => "smartblocks_admin_page.html",
                                   'description' => "");

//Blocks
$modversion['blocks'][1]['file'] = "smartblock.php";
$modversion['blocks'][1]['name'] = "Left SmartBlock";
$modversion['blocks'][1]['description'] = "Shows dynamic content based on location";
$modversion['blocks'][1]['show_func'] = "b_smartblock_show";
$modversion['blocks'][1]['edit_func'] = "b_smartblock_edit";
$modversion['blocks'][1]['template'] = 'smartblocks_block.html';
$modversion['blocks'][1]['options'] = '1';

$modversion['blocks'][2]['file'] = "smartblock.php";
$modversion['blocks'][2]['name'] = "Right SmartBlock";
$modversion['blocks'][2]['description'] = "Shows dynamic content based on location";
$modversion['blocks'][2]['show_func'] = "b_smartblock_show";
$modversion['blocks'][2]['edit_func'] = "b_smartblock_edit";
$modversion['blocks'][2]['template'] = 'smartblocks_block.html';
$modversion['blocks'][2]['options'] = '2';

$modversion['blocks'][3]['file'] = "smartblock.php";
$modversion['blocks'][3]['name'] = "Center SmartBlock";;
$modversion['blocks'][3]['description'] = "Shows dynamic content based on location";
$modversion['blocks'][3]['show_func'] = "b_smartblock_show";
$modversion['blocks'][3]['edit_func'] = "b_smartblock_edit";
$modversion['blocks'][3]['template'] = 'smartblocks_block.html';
$modversion['blocks'][3]['options'] = '3';

$modversion['blocks'][4]['file'] = "smartblock.php";
$modversion['blocks'][4]['name'] = "Center-Left SmartBlock";;
$modversion['blocks'][4]['description'] = "Shows dynamic content based on location";
$modversion['blocks'][4]['show_func'] = "b_smartblock_show";
$modversion['blocks'][4]['edit_func'] = "b_smartblock_edit";
$modversion['blocks'][4]['template'] = 'smartblocks_block.html';
$modversion['blocks'][4]['options'] = '4';

$modversion['blocks'][5]['file'] = "smartblock.php";
$modversion['blocks'][5]['name'] = "Center-Right SmartBlock";;
$modversion['blocks'][5]['description'] = "Shows dynamic content based on location";
$modversion['blocks'][5]['show_func'] = "b_smartblock_show";
$modversion['blocks'][5]['edit_func'] = "b_smartblock_edit";
$modversion['blocks'][5]['template'] = 'smartblocks_block.html';
$modversion['blocks'][5]['options'] = '5';

$modversion['blocks'][6] = array('file' => "smartblock.php",
                                 'name' => "Bottom Center SmartBlock",
                                 'description' => "Shows dynamic content based on location",
                                 'show_func' => "b_smartblock_show",
                                 'edit_func' => "b_smartblock_edit",
                                 'template' => 'smartblocks_block.html',
                                 'options' => "6");

$modversion['blocks'][7] = array('file' => "smartblock.php",
                                 'name' => "Bottom Center-Left SmartBlock",
                                 'description' => "Shows dynamic content based on location",
                                 'show_func' => "b_smartblock_show",
                                 'edit_func' => "b_smartblock_edit",
                                 'template' => 'smartblocks_block.html',
                                 'options' => "7");

$modversion['blocks'][8] = array('file' => "smartblock.php",
                                 'name' => "Bottom Center-Right SmartBlock",
                                 'description' => "Shows dynamic content based on location",
                                 'show_func' => "b_smartblock_show",
                                 'edit_func' => "b_smartblock_edit",
                                 'template' => 'smartblocks_block.html',
                                 'options' => "8");

// About stuff
$modversion['status_version'] = "Release Candidate";
$modversion['developer_website_url'] = "http://smartfactory.ca";
$modversion['developer_website_name'] = "The SmartFactory";
$modversion['developer_email'] = "info@smartfactory.ca";
$modversion['status'] = "RC";
$modversion['date'] = "Unreleased";

$modversion['people']['developers'][] = "Mithrandir (Jan Keller Pedersen)";

$modversion['people']['testers'][] = "SmartFactory Team";

//$modversion['people']['translators'][] = "translator 1";

//$modversion['people']['documenters'][] = "documenter 1";

//$modversion['people']['other'][] = "other 1";

//$modversion['demo_site_url'] = "http://inboxfactory.net/smartmail";
//$modversion['demo_site_name'] = "SmartMail Sandbox";
$modversion['support_site_url'] = "http://smartfactory.ca/modules/newbb";
$modversion['support_site_name'] = "SmartFactory Support Forums";
//$modversion['submit_bug'] = "http://dev.xoops.org/modules/xfmod/tracker/?group_id=1352&atid=1562";
//$modversion['submit_feature'] = "http://dev.xoops.org/modules/xfmod/tracker/?group_id=1352&atid=1565";

$modversion['author_word'] = "Set all SmartBlocks that you want to use visible TO ALL on ALL pages in System => Blocks administration and set the corresponding position as you want it. Then add blocks through the SmartBlocks module administration";
$modversion['warning'] = "";
?>