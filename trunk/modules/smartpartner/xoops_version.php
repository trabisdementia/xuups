<?php

/**
 * $Id: xoops_version.php,v 1.33 2005/06/08 19:16:54 fx2024 Exp $
 * Module: SmartPartner
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

// This must contain the name of the folder in which reside SmartPartner
if( !defined("SMARTPARTNER_DIRNAME") ){
    define("SMARTPARTNER_DIRNAME", 'smartpartner');
}

$modversion['name'] = _MI_SPARTNER_PARTNERS_NAME;
$modversion['version'] = 1.02;
$modversion['author'] = "The SmartFactory [www.smartfactory.ca]";
$modversion['description']	= _MI_SPARTNER_PARTNERS_DESC;
$modversion['credits'] = "Based on Raul Recio (AKA UNFOR)'s XoopsPartners module";
$modversion['license'] = "GNU General Public License (GPL)";
$modversion['help']	= "";
$modversion['official']	= 0;
$modversion['image'] = "images/module_logo.png";
$modversion['dirname']	= SMARTPARTNER_DIRNAME;

// Added by marcan for the About page in admin section
$modversion['adminMenu'] = "smartpartner_adminMenu";
$modversion['modFooter'] = "smartpartner_modFooter";
$modversion['developer_lead'] = "marcan [Marc-André Lanciault]";
$modversion['developer_contributor'] = "Raul Recio, chapi, Marco, Mariuss, outch, Christian, Philou, M4d3L, solo, GiJOE, Predator, phppp, AmiCalmant, hsalazar, Aidan Lister, fx2024, Zabou";
$modversion['developer_website_url'] = "http://www.smartfactory.ca";
$modversion['developer_website_name'] = "SmartFactory.ca";
$modversion['developer_email'] = "marcan@smartfactory";
$modversion['status_version'] = "Final";
$modversion['status'] = "Final";
$modversion['date'] = "2005-06-08";

$modversion['warning'] = _MI_SPARTNER_WARNING_FINAL;

$modversion['demo_site_url'] = "http://www.smartfactory.ca/modules/smartpartner/";
$modversion['demo_site_name'] = "SmartFactory.ca";
$modversion['support_site_url'] = "http://dev.xoops.org/modules/xfmod/project/?group_id=1109";
$modversion['support_site_name'] = "SmartPartner on XOOPS Developpers Forge";
$modversion['submit_bug'] = "http://dev.xoops.org/modules/xfmod/tracker/?func=add&group_id=1109&atid=581";
$modversion['submit_feature'] = "http://dev.xoops.org/modules/xfmod/tracker/?func=add&group_id=1109&atid=584";

$modversion['author_word'] = "
<b>The SmartFactory</b> would like to thank everyone involved in this project.<br />
<br />
A big thanks to chapi, Marco, Mariuss, oucth, Christian, Philou, solo, yoyo2021 and AmiCalmant for their feedback on the module.<br />
<br />
Thanks to hsalazar who originally created the admin interface the SmartModules are using. A lot of modules are now using it and it's because of your work. Thank you Horacio !<br />
<br />
Thanks to GiJoe for the blocks and groups management pages. Your code is very usefull to a lot of developers !<br />
<br />
Thanks to Zabou for supporting me ;-)<br />
<br />
Enjoy <b>SmartPartner</b> !
";

$modversion['version_history'] = "
=> Version 1.0.2 Final (2005-6-08)<br/>
===================================<br/>
<br/>
- Keyword highlighting added in the search function<br />
- A few bugs from 1.0.1 were fixed
<br/>
=> Version 1.0.1 Final (2005-05-09)<br/>
===================================<br/>
<br/>
- A bug was found in the logo url display, on the index and partner's page<br/>
- Undefined constants fixed<br/>
- The View All link on the partners block was not pointing to the partners page<br/>
- A bug was found when uploading a logo from the user side<br/>
- An error was fixed in the partner's template<br/>
<br/>
=> Version 1.0.1 Beta 1 (2005-03-28)<br/>
====================================<br/>
<br/>
- A bug was causing a fatal error in the user profile<br/>
- The search feature had some bugs that are now fixed<br/>
- The index page was not displaying the logo properly under IE<br/>
- The upload of a jpg file is now fixed<br/>
- The code of the module has been improve to facilitate the renaming of the module folder (see changing_directory.txt)<br/>
<br/>
=> Version 1.0 Final (2005-03-09)<br/>
=================================<br/>
<br/>
- The images folder was changed to xoops_root/uploads/smartpartner, for permissions reason.<br/>
- A search feature with keywords highlighting has been introduced.<br/>
- Jpeg files upload has been fixed.<br/>
- Errors fixed in the admin index sort options.<br/>
- Anonymous submit bug fixed.<br/>
<br/>
=> Version 1.0 RC1 (2004-12-22)<br/>
===============================<br/>
<br/>
- The partners block random functionnality now works perfectly.<br/>
- Error fixed when updating notification options on partner.php.<br/>
- If only the 'summary' field is completed, the partner will be considered as a basic partner and will not have a 'partner' page. Links on the partner logo will reflect this behavior.<br/>
- < h2> and < h3> tags have been replaced by custom classes.<br/>
- Any color definition has been removed from the module.<br/>
- New config option to display a 'Back to partners index' link.<br/>
- Changing the About page to use a class that create the page.<br/>
<br/>
=> Version 0.9 Beta 2 (2004-12-01)<br/>
==================================<br/>
<br/>
- When creating a new partner in the admin side, the status select box was not displayed, causing the partner's status to be incorrectly set. This has been fixed.<br/>
<br/>
=> Version 0.9 Beta 1 (2004-11-30)<br/>
==================================<br/>
<br/>
- As usual a lot of little bugs have been fixed.<br/>
- The status of a partner can now be set in the EditPartner form.<br/>
- Each partner now has a page on the public side displaying the partners info + some contact informations.<br/>
- The logo upload files are now held in xoops_root_path/uploads/smartpartner.<br/>
- The webmaster can create this folder directly in the admin side of the module (thanks to Newbb2 team:-) )<br/>
<br/>
=> Version 0.8 Beta 1 (2004-11-10)<br/>
==================================<br/>
<br/>
- First public release of the module.<br/>
";

// Tables
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][0] = "smartpartner_partner";

// Admin things
$modversion['hasAdmin']	= 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Blocks
$modversion['blocks'][1]['file'] = "partners_list.php";
$modversion['blocks'][1]['name'] = _MI_SPARTNER_BLOCK_PARTNERS_LIST;
$modversion['blocks'][1]['description']	= _MI_SPARTNER_BLOCK_PARTNERS_LIST_DESC;
$modversion['blocks'][1]['show_func'] = "b_partners_list_show";
$modversion['blocks'][1]['edit_func'] = "b_partners_list_edit";
$modversion['blocks'][1]['options']	= "1|1|1|5|1|hits|DESC|1";
$modversion['blocks'][1]['template'] = 'partners_block_list.html';

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "smartpartner_search";

// Menu
$modversion['hasMain'] = 1;

// Templates
$modversion['templates'][1]['file']	= 'smartpartner_index.html';
$modversion['templates'][1]['description'] = 'Partners main page';
$modversion['templates'][2]['file']	= 'smartpartner_partner.html';
$modversion['templates'][2]['description'] = "Full partner's page";
$modversion['templates'][3]['file']	= 'smartpartner_join.html';
$modversion['templates'][3]['description'] = 'Apply to be a partner form';
$modversion['templates'][4]['file']	= 'smartpartner_pdf.html';
$modversion['templates'][4]['description'] = 'Create a PDF page';

// Config options
$modversion['config'][1]['name'] = 'allowsubmit';
$modversion['config'][1]['title'] = '_MI_SPARTNER_ALLOWSUBMIT';
$modversion['config'][1]['description'] = '_MI_SPARTNER_ALLOWSUBMITDSC';
$modversion['config'][1]['formtype'] = 'yesno';
$modversion['config'][1]['valuetype'] = 'int';
$modversion['config'][1]['default'] = 0;

$modversion['config'][2]['name'] = 'anonpost';
$modversion['config'][2]['title'] = '_MI_SPARTNER_ANONPOST';
$modversion['config'][2]['description'] = '_MI_SPARTNER_ANONPOSTDSC';
$modversion['config'][2]['formtype'] = 'yesno';
$modversion['config'][2]['valuetype'] = 'int';
$modversion['config'][2]['default'] = 0;

$modversion['config'][3]['name'] = 'autoapprove_submitted';
$modversion['config'][3]['title'] = '_MI_SPARTNER_AUTOAPPROVE';
$modversion['config'][3]['description'] = '_MI_SPARTNER_AUTOAPPROVE_DSC';
$modversion['config'][3]['formtype'] = 'yesno';
$modversion['config'][3]['valuetype'] = 'int';
$modversion['config'][3]['default'] = 0;

$modversion['config'][4]['name'] = 'useimagenavpage';
$modversion['config'][4]['title'] = '_MI_SPARTNER_USEIMAGENAVPAGE';
$modversion['config'][4]['description'] = '_MI_SPARTNER_USEIMAGENAVPAGEDSC';
$modversion['config'][4]['formtype'] = 'yesno';
$modversion['config'][4]['valuetype'] = 'int';
$modversion['config'][4]['default'] = 0;

$modversion['config'][5]['name'] = 'img_max_width';
$modversion['config'][5]['title'] = '_MI_SPARTNER_IMG_MAX_WIDTH';
$modversion['config'][5]['description'] = '_MI_SPARTNER_IMG_MAX_WIDTH_DSC';
$modversion['config'][5]['formtype'] = 'textbox';
$modversion['config'][5]['valuetype'] = 'text';
$modversion['config'][5]['default'] = '150';

$modversion['config'][6]['name'] = 'img_max_height';
$modversion['config'][6]['title'] = '_MI_SPARTNER_IMG_MAX_HEIGHT';
$modversion['config'][6]['description'] = '_MI_SPARTNER_IMG_MAX_HEIGHT_DSC';
$modversion['config'][6]['formtype'] = 'textbox';
$modversion['config'][6]['valuetype'] = 'text';
$modversion['config'][6]['default'] = '150';

$modversion['config'][7]['name'] = 'cookietime';
$modversion['config'][7]['title'] = '_MI_SPARTNER_RECLICK';
$modversion['config'][7]['description']	= '';
$modversion['config'][7]['formtype'] = 'select';
$modversion['config'][7]['valuetype']	= 'int';
$modversion['config'][7]['default']	= 86400;
$modversion['config'][7]['options']	= array('_MI_SPARTNER_HOUR' => '3600','_MI_SPARTNER_3HOURS' => '10800','_MI_SPARTNER_5HOURS' =>  '18000','_MI_SPARTNER_10HOURS'  =>  '36000','_MI_SPARTNER_DAY' => '86400');

$modversion['config'][8]['name'] = 'perpage_user';
$modversion['config'][8]['title'] = '_MI_SPARTNER_PERPAGE_USER';
$modversion['config'][8]['description'] = '_MI_SPARTNER_PERPAGE_USER_DSC';
$modversion['config'][8]['formtype'] = 'select';
$modversion['config'][8]['valuetype'] = 'int';
$modversion['config'][8]['default'] = 5;
$modversion['config'][8]['options'] = array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50);

$modversion['config'][9]['name'] = 'perpage_admin';
$modversion['config'][9]['title'] = '_MI_SPARTNER_PERPAGE_ADMIN';
$modversion['config'][9]['description'] = '_MI_SPARTNER_PERPAGE_ADMIN_DSC';
$modversion['config'][9]['formtype'] = 'select';
$modversion['config'][9]['valuetype'] = 'int';
$modversion['config'][9]['default'] = 5;
$modversion['config'][9]['options'] = array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50);

$modversion['config'][10]['name'] = 'index_sortby';
$modversion['config'][10]['title'] = '_MI_SPARTNER_INDEX_SORTBY';
$modversion['config'][10]['description']	= '_MI_SPARTNER_INDEX_SORTBY_DSC';
$modversion['config'][10]['formtype'] = 'select';
$modversion['config'][10]['valuetype'] = 'text';
$modversion['config'][10]['default']	= 'hits';
$modversion['config'][10]['options']	= array('_MI_SPARTNER_ID' => 'id', '_MI_SPARTNER_HITS' => 'hits', '_MI_SPARTNER_TITLE' => 'title', '_MI_SPARTNER_WEIGHT' => 'weight');

$modversion['config'][11]['name'] = 'index_orderby';
$modversion['config'][11]['title'] = '_MI_SPARTNER_INDEX_ORDERBY';
$modversion['config'][11]['description']	= '_MI_SPARTNER_INDEX_ORDERBY_DSC';
$modversion['config'][11]['formtype'] = 'select';
$modversion['config'][11]['valuetype'] = 'text';
$modversion['config'][11]['default']	= 'DESC';
$modversion['config'][11]['options']	= array('_ASCENDING' => 'ASC', '_DESCENDING' => 'DESC');

$modversion['config'][12]['name'] = 'welcomemsg';
$modversion['config'][12]['title'] = '_MI_SPARTNER_WELCOMEMSG';
$modversion['config'][12]['description'] = '_MI_SPARTNER_WELCOMEMSG_DSC';
$modversion['config'][12]['formtype'] = 'textarea';
$modversion['config'][12]['valuetype'] = 'text';
$modversion['config'][12]['default'] = _MI_SPARTNER_WELCOMEMSG_DEF;

$member_handler = &xoops_gethandler('member');
$group_list = &$member_handler->getGroupList();
foreach ($group_list as $key=>$group) {
    $groups[$group] = $key;
}

$modversion['config'][13]['name'] = 'stats_group';
$modversion['config'][13]['title'] = '_MI_SPARTNER_STATS_GROUP';
$modversion['config'][13]['description'] = '_MI_SPARTNER_STATS_GROUP_DSC';
$modversion['config'][13]['formtype'] = 'select_multi';
$modversion['config'][13]['valuetype'] = 'array';
$modversion['config'][13]['options'] = $groups;
$modversion['config'][13]['default'] = $groups;

$modversion['config'][14]['name'] = 'backtoindex';
$modversion['config'][14]['title'] = '_MI_SPARTNER_BACKTOINDEX';
$modversion['config'][14]['description'] = '_MI_SPARTNER_BACKTOINDEX_DSC';
$modversion['config'][14]['formtype'] = 'yesno';
$modversion['config'][14]['valuetype'] = 'int';
$modversion['config'][14]['default'] = 1;

$modversion['config'][15]['name'] = 'highlight_color';
$modversion['config'][15]['title'] = '_MI_SPARTNER_HIGHLIGHT_COLOR';
$modversion['config'][15]['description'] = '_MI_SPARTNER_HIGHLIGHT_COLORDSC';
$modversion['config'][15]['formtype'] = 'textbox';
$modversion['config'][15]['valuetype'] = 'text';
$modversion['config'][15]['default'] = '#FFFF80';

$modversion['config'][16]['name'] = 'hide_module_name';
$modversion['config'][16]['title'] = '_MI_SPARTNER_HIDE_MOD_NAME';
$modversion['config'][16]['description'] = '_MI_SPARTNER_HIDE_MOD_NAMEDSC';
$modversion['config'][16]['formtype'] = 'yesno';
$modversion['config'][16]['valuetype'] = 'int';
$modversion['config'][16]['default'] = '0';

// Notification
$modversion['hasNotification'] = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'smartpartner_notify_iteminfo';

$modversion['notification']['category'][1]['name'] = 'global_partner';
$modversion['notification']['category'][1]['title'] = _MI_SPARTNER_PARTNER_NOTIFY;
$modversion['notification']['category'][1]['description'] = _MI_SPARTNER_PARTNER_NOTIFY_DSC;
$modversion['notification']['category'][1]['subscribe_from'] = array('index.php');

$modversion['notification']['category'][2]['name'] = 'partner';
$modversion['notification']['category'][2]['title'] = _MI_SPARTNER_PARTNER_NOTIFY;
$modversion['notification']['category'][2]['description'] = _MI_SPARTNER_PARTNER_NOTIFY_DSC;
$modversion['notification']['category'][2]['subscribe_from'] = array('partner.php');
$modversion['notification']['category'][2]['item_name'] = 'id';

$modversion['notification']['event'][1]['name'] = 'submitted';
$modversion['notification']['event'][1]['category'] = 'global_partner';
$modversion['notification']['event'][1]['admin_only'] = 1;
$modversion['notification']['event'][1]['title'] = _MI_SPARTNER_GLOBAL_PARTNER_SUBMITTED_NOTIFY;
$modversion['notification']['event'][1]['caption'] = _MI_SPARTNER_GLOBAL_PARTNER_SUBMITTED_NOTIFY_CAP;
$modversion['notification']['event'][1]['description'] = _MI_SPARTNER_GLOBAL_PARTNER_SUBMITTED_NOTIFY_DSC;
$modversion['notification']['event'][1]['mail_template'] = 'global_partner_submitted';
$modversion['notification']['event'][1]['mail_subject'] = _MI_SPARTNER_GLOBAL_PARTNER_SUBMITTED_NOTIFY_SBJ;

$modversion['notification']['event'][2]['name'] = 'approved';
$modversion['notification']['event'][2]['category'] = 'partner';
$modversion['notification']['event'][2]['invisible'] = 1;
$modversion['notification']['event'][2]['title'] = _MI_SPARTNER_PARTNER_APPROVED_NOTIFY;
$modversion['notification']['event'][2]['caption'] = _MI_SPARTNER_PARTNER_APPROVED_NOTIFY_CAP;
$modversion['notification']['event'][2]['description'] = _MI_SPARTNER_PARTNER_APPROVED_NOTIFY_DSC;
$modversion['notification']['event'][2]['mail_template'] = 'partner_approved';
$modversion['notification']['event'][2]['mail_subject'] = _MI_SPARTNER_PARTNER_APPROVED_NOTIFY_SBJ;


?>