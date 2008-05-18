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

$modversion['name'] = "mytabs";
$modversion['version'] = 1.00;
$modversion['description'] = "Module for managing tabs";
$modversion['author'] = "Trabis & Jan Keller Pedersen <jkp@cusix.dk>";
$modversion['credits'] = "Michael Wulff Nielsen <naish@klanen.net>";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/module_logo.gif";
$modversion['dirname'] = "mytabs";

//Database
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][0] = "mytabs_page";
$modversion['tables'][1] = "mytabs_tab";
$modversion['tables'][2] = "mytabs_pageblock";

$modversion['hasMain'] = 1;

//Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

$modversion['templates'][] = array('file' => "mytabs_admin_blocks.html",
                                   'description' => "");
$modversion['templates'][] = array('file' => "mytabs_admin_page.html",
                                   'description' => "");
$modversion['templates'][] = array('file' => "mytabs_block.html",
                                   'description' => "");
$modversion['templates'][] = array('file' => "mytabs_index.html",
                                   'description' => "");

// About stuff
$modversion['status_version'] = "Alpha";
$modversion['developer_website_url'] = "http://www.xuups.com";
$modversion['developer_website_name'] = "Xuups";
$modversion['developer_email'] = "lusopoemas@gmail.com";
$modversion['status'] = "Alpha";
$modversion['date'] = "Unreleased";

$modversion['people']['developers'][] = "Tabis, Mithrandir (Jan Keller Pedersen)";

$modversion['people']['testers'][] = "Xoops Br";

//$modversion['people']['translators'][] = "translator 1";

//$modversion['people']['documenters'][] = "documenter 1";

//$modversion['people']['other'][] = "other 1";

//$modversion['demo_site_url'] = "http://inboxfactory.net/smartmail";
//$modversion['demo_site_name'] = "SmartMail Sandbox";
$modversion['support_site_url'] = "http://www.xuups.com/modules/newbb";
$modversion['support_site_name'] = "Xuups Support Forums";
//$modversion['submit_bug'] = "http://dev.xoops.org/modules/xfmod/tracker/?group_id=1352&atid=1562";
//$modversion['submit_feature'] = "http://dev.xoops.org/modules/xfmod/tracker/?group_id=1352&atid=1565";

$modversion['author_word'] = "";
$modversion['warning'] = "";
?>
