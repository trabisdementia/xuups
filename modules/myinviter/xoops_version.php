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
 * @package         myinviter
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: xoops_version.php 0 2009-11-14 18:47:04Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

global $xoopsConfig, $xoopsUser;

$modversion['name'] = _MI_MYINVITER_MD_NAME;
$modversion['version'] = 1.1;
$modversion['description'] = _MI_MYINVITER_MD_DESC;
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

//Callbacks install/update
$modversion['onInstall'] = "include/install.inc.php";
$modversion['onUpdate'] = "include/install.inc.php";

// Sql
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tables created by sql file (without prefix!)
$i=0;
$i++;
$modversion['tables'][$i] = "myinviter_item";

//Module config setting
$i=0;
$i++;
$modversion['config'][$i]['name'] = 'sandbox';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_SANDBOX';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_SANDBOX_DSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

$i++;
$modversion['config'][$i]['name'] = 'sandboxemail';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_SANDBOXEMAIL';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_SANDBOXEMAIL_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = $xoopsConfig['adminmail'];

$i++;
$modversion['config'][$i]['name'] = 'html';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_HTML';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_HTML_DSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

$i++;
$modversion['config'][$i]['name'] = 'emailsperpack';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_EMAILSPERPACK';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_EMAILSPERPACK_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;

$i++;
$modversion['config'][$i]['name'] = 'timebpacks';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_TIMEBPACKS';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_TIMEBPACKS_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 3600;

$i++;
$modversion['config'][$i]['name'] = 'fromname';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_FROMNAME';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_FROMNAME_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = $xoopsConfig['sitename'];

$i++;
$modversion['config'][$i]['name'] = 'fromemail';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_FROMEMAIL';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_FROMEMAIL_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = $xoopsConfig['adminmail'];

$i++;
$modversion['config'][$i]['name'] = 'from';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_FROM';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_FROM_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'custom';
$modversion['config'][$i]['options'] = array(_MI_MYINVITER_CONF_FROM_CUSTOM => 'custom',
_MI_MYINVITER_CONF_FROM_SYSTEM => 'system',
_MI_MYINVITER_CONF_FROM_USER => 'user');

$i++;
$modversion['config'][$i]['name'] = 'defaultuid';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_DEFAULTUID';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_DEFAULTUID_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = is_object($xoopsUser) ? $xoopsUser->getVar('uid') : 0;

$i++;
$modversion['config'][$i]['name'] = 'subject';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_SUBJECT';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_SUBJECT_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_MYINVITER_CONF_SUBJECT_DEF;;

$i++;
$modversion['config'][$i]['name'] = 'socialsubject';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_SOCIALSUBJECT';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_SOCIALSUBJECT_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_MYINVITER_CONF_SOCIALSUBJECT_DEF;

$i++;
$modversion['config'][$i]['name'] = 'socialmessage';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_SOCIALMESSAGE';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_SOCIALMESSAGE_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_MYINVITER_CONF_SOCIALMESSAGE_DEF;

$i++;
$modversion['config'][$i]['name'] = 'googleurl';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_GOOGLEURL';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_GOOGLEURL_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_MYINVITER_CONF_GOOGLEURL_DEF;

$i++;
$modversion['config'][$i]['name'] = 'yahoourl';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_YAHOOURL';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_YAHOOURL_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_MYINVITER_CONF_YAHOOURL_DEF;

$i++;
$modversion['config'][$i]['name'] = 'bingurl';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_BINGURL';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_BINGURL_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_MYINVITER_CONF_BINGURL_DEF;

$i++;
$modversion['config'][$i]['name'] = 'providers';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_PROVIDERS';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_PROVIDERS_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = _MI_MYINVITER_CONF_PROVIDERS_DEF;

$i++;
$modversion['config'][$i]['name'] = 'autocrawl';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_AUTOCRAWL';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_AUROCRAWL_DSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

$i++;
$modversion['config'][$i]['name'] = 'autocrawlfolder';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_AUTOCRAWLFOLDER';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_AUTOCRAWLFOLDER_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'notsent';
$modversion['config'][$i]['options'] = array(_MI_MYINVITER_CONF_WAITING => 'waiting',
_MI_MYINVITER_CONF_NOTSENT => 'notsent');

$i++;
$modversion['config'][$i]['name'] = 'autocrawljobs';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_AUTOCRAWLJOBS';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_AUTOCRAWLJOBS_DSC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';


$i++;
$modversion['config'][$i]['name'] = 'hook';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_HOOK';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_HOOK_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'notsent';
$modversion['config'][$i]['options'] = array(_MI_MYINVITER_CONF_PRELOAD => 'preload',
_MI_MYINVITER_CONF_CRON => 'cron');

$i++;
$modversion['config'][$i]['name'] = 'cronkey';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_CRONKEY';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_CRONKEY_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = md5(XOOPS_URL . XOOPS_ROOT_PATH . XOOPS_DB_USER);

$i++;
$modversion['config'][$i]['name'] = 'debug';
$modversion['config'][$i]['title'] = '_MI_MYINVITER_CONF_DEBUG';
$modversion['config'][$i]['description'] = '_MI_MYINVITER_CONF_DEBUG_DSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 1;

// About stuff
$modversion['status_version'] = "Beta";
$modversion['status'] = "Beta";
$modversion['date'] = "05/09/2011";

$modversion['developer_lead'] = "trabis";
$modversion['developer_website_url'] = "http://www.xuups.com";
$modversion['developer_website_name'] = "Xuups";
$modversion['developer_email'] = "lusopoemas@gmail.com";

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

$modversion['min_xoops'] = "2.5.1";
$modversion['min_php'] = "5.2";
