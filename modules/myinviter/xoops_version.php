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
 * @copyright       The XUUPS Project http://www.xuups.com
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Myinviter
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: xoops_version.php 0 2009-11-14 18:47:04Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

global $xoopsConfig, $xoopsUser;

$modversion['name'] = _MI_MYINV_MD_NAME;
$modversion['version'] = 1.00;
$modversion['description'] = _MI_MYINV_MD_DESC;
$modversion['credits'] = "Xuups, OpenInviter <a href='openinviter.com'>http://openinviter.com</a>";
$modversion['author'] = "Xuups";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/myinviter_slogo.png";
$modversion['dirname'] = "myinviter";

// Menu
$modversion['hasMain'] = 1;

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Search
$modversion['hasSearch'] = 0;
// Comments
$modversion['hasComments'] = 0;

// Sql
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tables created by sql file (without prefix!)
$i=0;
$i++;
$modversion['tables'][$i] = "myinviter_waiting";
$i++;
$modversion['tables'][$i] = "myinviter_blacklist";

// Templates
$i=0;
$i++;
$modversion['templates'][$i]['file'] = "myinviter_index.html";
$modversion['templates'][$i]['description'] = _MI_MYINV_PAGE_INDEX;

$i++;
$modversion['templates'][$i]['file'] = "myinviter_about.html";
$modversion['templates'][$i]['description'] = _MI_MYINV_PAGE_ABOUT;

// Blocks
$i=0;
$i++;
$modversion['blocks'][$i]['file'] = "myinviter_add.php";
$modversion['blocks'][$i]['name'] = _MI_MYINV_BLK_ADD;
$modversion['blocks'][$i]['description'] = _MI_MYINV_BLK_ADD_DSC;
$modversion['blocks'][$i]['show_func'] = "myinviter_add_show";
$modversion['blocks'][$i]['template'] = "myinviter_add.html";

//Module config setting
$i=0;
$i++;
$modversion['config'][$i]['name'] = 'sandbox';
$modversion['config'][$i]['title'] = '_MI_MYINV_CONF_SANDBOX';
$modversion['config'][$i]['description'] = '_MI_MYINV_CONF_SANDBOX_DSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'sandboxemail';
$modversion['config'][$i]['title'] = '_MI_MYINV_CONF_SANDBOXEMAIL';
$modversion['config'][$i]['description'] = '_MI_MYINV_CONF_SANDBOXEMAIL_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = $xoopsConfig['adminmail'];

$i++;
$modversion['config'][$i]['name'] = 'html';
$modversion['config'][$i]['title'] = '_MI_MYINV_CONF_HTML';
$modversion['config'][$i]['description'] = '_MI_MYINV_CONF_HTML_DSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

$i++;
$modversion['config'][$i]['name'] = 'emailsperpack';
$modversion['config'][$i]['title'] = '_MI_MYINV_CONF_EMAILSPERPACK';
$modversion['config'][$i]['description'] = '_MI_MYINV_CONF_EMAILSPERPACK_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;

$i++;
$modversion['config'][$i]['name'] = 'timebpacks';
$modversion['config'][$i]['title'] = '_MI_MYINV_CONF_TIMEBPACKS';
$modversion['config'][$i]['description'] = '_MI_MYINV_CONF_TIMEBPACKS_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 3600;

$i++;
$modversion['config'][$i]['name'] = 'fromname';
$modversion['config'][$i]['title'] = '_MI_MYINV_CONF_FROMNAME';
$modversion['config'][$i]['description'] = '_MI_MYINV_CONF_FROMNAME_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = $xoopsConfig['sitename'];

$i++;
$modversion['config'][$i]['name'] = 'fromemail';
$modversion['config'][$i]['title'] = '_MI_MYINV_CONF_FROMEMAIL';
$modversion['config'][$i]['description'] = '_MI_MYINV_CONF_FROMEMAIL_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = $xoopsConfig['adminmail'];

$i++;
$modversion['config'][$i]['name'] = 'from';
$modversion['config'][$i]['title'] = '_MI_MYINV_CONF_FROM';
$modversion['config'][$i]['description'] = '_MI_MYINV_CONF_FROM_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'custom';
$modversion['config'][$i]['options'] = array(_MI_MYINV_CONF_FROM_CUSTOM => 'custom',
_MI_MYINV_CONF_FROM_SYSTEM => 'system',
_MI_MYINV_CONF_FROM_USER => 'user');

$i++;
$modversion['config'][$i]['name'] = 'defaultuid';
$modversion['config'][$i]['title'] = '_MI_MYINV_CONF_DEFAULTUID';
$modversion['config'][$i]['description'] = '_MI_MYINV_CONF_DEFAULTUID_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = is_object($xoopsUser) ? $xoopsUser->getVar('uid') : 0;

// About stuff
$modversion['status_version'] = "Final";
$modversion['developer_website_url'] = "http://www.xuups.com";
$modversion['developer_website_name'] = "Xuups";
$modversion['developer_email'] = "lusopoemas@gmail.com";
$modversion['status'] = "Final";
$modversion['date'] = "14/11/2009";

$modversion['people']['developers'][] = "Trabis";
$modversion['people']['developers'][] = "OpenInviter - import addressbook/contacts from different email providers like Yahoo, Gmail, Hotmail, Live etc.<br />Available at <a href='openinviter.com'>http://openinviter.com</a>";
//$modversion['people']['testers'][] = "";
//$modversion['people']['translaters'][] = "";
//$modversion['people']['documenters'][] = "";
//$modversion['people']['other'][] = "";

$modversion['demo_site_url'] = "http://www.xuups.com";
$modversion['demo_site_name'] = "Xuups.com";
$modversion['support_site_url'] = "http://www.xuups.com/modules/newbb";
$modversion['support_site_name'] = "Xuups Support Forums";
//$modversion['submit_bug'] = "";
//$modversion['submit_feature'] = "";

//$modversion['author_word'] = "";
//$modversion['warning'] = "";

?>