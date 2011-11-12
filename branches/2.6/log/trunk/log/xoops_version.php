<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id$
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

global $xoopsConfig, $xoopsUser;

$modversion['name'] = _MI_LOG_MD_NAME;
$modversion['version'] = 1.0;
$modversion['description'] = _MI_LOG_MD_DESC;
$modversion['credits'] = "Xuups";
$modversion['author'] = "trabis";
$modversion['help'] = "";
$modversion['license'] = "GNU GPL 2.0";
$modversion['license_url'] = "http://www.gnu.org/licenses/gpl-2.0.html/";
$modversion['official'] = 0;
$modversion['image'] = "images/module_logo.png";
$modversion['dirname'] = basename(dirname(__FILE__));

// Menu
$modversion['hasMain'] = 0;

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Search
$modversion['hasSearch'] = 0;

// Comments
$modversion['hasComments'] = 0;

//Callbacks install/update
$modversion['onInstall'] = "include/install.inc.php";
$modversion['onUpdate'] = "include/install.inc.php";

// Sql
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tables created by sql file (without prefix!)
$i=0;
$i++;
$modversion['tables'][$i] = "log_item";

//Module config setting

// About stuff
$modversion['module_status'] = "Beta";
$modversion['status'] = "Beta";
$modversion['release_date'] = "09/09/2011";

$modversion['developer_lead'] = "trabis";
$modversion['developer_website_url'] = "http://www.xuups.com";
$modversion['developer_website_name'] = "Xuups";
$modversion['developer_email'] = "lusopoemas@gmail.com";

$modversion['people']['developers'][] = "trabis";

$modversion['demo_site_url'] = "http://www.xuups.com";
$modversion['demo_site_name'] = "Xuups.com";
$modversion['support_site_url'] = "http://www.xuups.com/modules/newbb";
$modversion['support_site_name'] = "Xuups Support Forums";

$modversion['min_xoops'] = "2.4.5";
$modversion['min_php'] = "5.2";
