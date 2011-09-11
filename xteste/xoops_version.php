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
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: $
 */

$modversion['dirname'] = basename(dirname(__FILE__));
$modversion['name'] = ucfirst(basename(dirname(__FILE__)));
$modversion['version'] = '0.1';
$modversion['description'] = '';
$modversion['author'] = "trabis";
$modversion['credits'] = "trabis(www.xuups.com)";
$modversion['help'] = "";
$modversion['license'] = "GNU GPL 2.0";
$modversion['license_url'] = "http://www.gnu.org/licenses/gpl-2.0.html/";
$modversion['official'] = 0;
$modversion['image'] = "images/dummy.png";

$modversion['hasMain'] = 1;

$modversion['onInstall'] = "include/install.inc.php";
$modversion['onUpdate'] = "include/install.inc.php";


// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu']  = "admin/menu.php";

$i = 0;
$i++;
$modversion['config'][$i]['name'] = 'config1';
$modversion['config'][$i]['title'] = '_MI_XTEST_CONFIG1';
$modversion['config'][$i]['description'] = '_MI_XTEST_CONFIG2_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'this is my test config1 value';

$i++;
$modversion['config'][$i]['name'] = 'config2';
$modversion['config'][$i]['title'] = '_MI_XTEST_CONFIG2';
$modversion['config'][$i]['description'] = '_MI_XTEST_CONFIG2_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'this is my test config2 value';

// About stuff
$modversion['module_status'] = "Alpha";
$modversion['status'] = "Alpha";
$modversion['release_date'] = "11/09/2011";

$modversion['developer_lead'] = "trabis";
$modversion['developer_website_url'] = "http://www.xuups.com";
$modversion['developer_website_name'] = "Xuups";
$modversion['developer_email'] = "lusopoemas@gmail.com";

$modversion['people']['developers'][] = "trabis";

$modversion['demo_site_url'] = "http://www.xuups.com";
$modversion['demo_site_name'] = "XOOPS User Utilitites";
$modversion['support_site_url'] = "http://www.xuups.com/modules/newbb";
$modversion['support_site_name'] = "Xuups Support Forums";

$modversion['min_xoops'] = "2.4.5";
$modversion['min_php'] = "5.2";
