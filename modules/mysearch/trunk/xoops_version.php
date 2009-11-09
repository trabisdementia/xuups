<?php
//  ------------------------------------------------------------------------ //
//                       mysearch - MODULE FOR XOOPS 2                        //
//                  Copyright (c) 2005-2006 Instant Zero                     //
//                     <http://xoops.instant-zero.com/>                      //
// ------------------------------------------------------------------------- //
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
if (!defined('XOOPS_ROOT_PATH')) {
	die('XOOPS root path not defined');
}

$modversion['name'] = _MI_MYSEARCH_NAME;
$modversion['version'] = 1.1;
$modversion['description'] = _MI_MYSEARCH_DESC;
$modversion['credits'] = "Christian, Marco, Lankford, Smart2, Trabis";
$modversion['author'] = 'Instant Zero - http://xoops.instant-zero.com , Xuups & Others';
$modversion['help'] = "";
$modversion['license'] = "GPL";
$modversion['official'] = 0;
$modversion['image'] = "images/mysearch_logo.png";
$modversion['dirname'] = "mysearch";

//About
$modversion['developer_website_url'] = "http://www.xuups.com";
$modversion['developer_website_name'] = "Xuups";
$modversion['developer_email'] = "lusopoemas@gmail.com";
$modversion['status_version'] = "Final";
$modversion['status'] = "Final";
$modversion['date'] = "2008-11-01";

$modversion['people']['developers'][] = "Hervet(xoops.instant-zero.com)";
$modversion['people']['developers'][] = "Marco(xoops.instant-zero.com)";
$modversion['people']['developers'][] = "Lankford(lankfordfamily.com)";
$modversion['people']['developers'][] = "Smart2(s-martinez.com)";
$modversion['people']['developers'][] = "Trabis(xuups.com)";


$modversion['people']['testers'][] = "";

$modversion['people']['translators'][] = "";

$modversion['people']['documenters'][] = "";

$modversion['people']['other'][] = "";

$modversion['demo_site_url'] = "";
$modversion['demo_site_name'] = "";
$modversion['support_site_url'] = "http://www.xuups.com";
$modversion['support_site_name'] = "Xuups";
$modversion['submit_bug'] = "http://www.xuups.com";
$modversion['submit_feature'] = "http://www.xuups.com";

$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

$modversion['tables'][0] = "mysearch_searches";

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Templates
$modversion['templates'][1]['file'] = 'mysearch_index.html';
$modversion['templates'][1]['description'] = '';

$modversion['templates'][2]['file'] = 'mysearch_search.html';
$modversion['templates'][2]['description'] = '';


// Blocks
$modversion['blocks'][1]['file'] = "mysearch_last_search.php";
$modversion['blocks'][1]['name'] = _MI_MYSEARCH_BNAME1;
$modversion['blocks'][1]['description'] = "Show last searches";
$modversion['blocks'][1]['show_func'] = "b_mysearch_last_search_show";
$modversion['blocks'][1]['template'] = 'mysearch_block_last_search.html';

$modversion['blocks'][2]['file'] = "mysearch_biggest_users.php";
$modversion['blocks'][2]['name'] = _MI_MYSEARCH_BNAME2;
$modversion['blocks'][2]['description'] = "Show people who are the biggest users of the search";
$modversion['blocks'][2]['show_func'] = "b_mysearch_big_user_show";
$modversion['blocks'][2]['template'] = 'mysearch_block_big_user.html';

$modversion['blocks'][3]['file'] = "mysearch_stats.php";
$modversion['blocks'][3]['name'] = _MI_MYSEARCH_BNAME3;
$modversion['blocks'][3]['description'] = "Show statistics";
$modversion['blocks'][3]['show_func'] = "b_mysearch_stats_show";
$modversion['blocks'][3]['template'] = 'mysearch_block_stats.html';

$modversion['blocks'][4]['file'] = "mysearch_ajax_search.php";
$modversion['blocks'][4]['name'] = _MI_MYSEARCH_BNAME4;
$modversion['blocks'][4]['description'] = _MI_MYSEARCH_BNAME4;
$modversion['blocks'][4]['show_func'] = "b_mysearch_ajaxsearch_show";
$modversion['blocks'][4]['template'] = 'mysearch_block_ajax_search.html';

// Menu
$modversion['hasMain'] = 1;

// Comments
$modversion['hasComments'] = 0;


/**
 * Show last searches on the module's index page ?
*/
$i = 0;
$i++;
$modversion['config'][$i]['name'] = 'showindex';
$modversion['config'][$i]['title'] = '_MI_MYSEARCH_OPT0';
$modversion['config'][$i]['description'] = '_MI_MYSEARCH_OPT0_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;

/**
 * Groups that should not be recorded
*/
$member_handler =& xoops_gethandler('member');
$i++;
$modversion['config'][$i]['name'] = 'bannedgroups';
$modversion['config'][$i]['title'] = "_MI_MYSEARCH_OPT1";
$modversion['config'][$i]['description'] = "_MI_MYSEARCH_OPT1_DSC";
$modversion['config'][$i]['formtype'] = 'select_multi';
$modversion['config'][$i]['valuetype'] = 'array';
$modversion['config'][$i]['default'] = array();
$modversion['config'][$i]['options'] = array_flip($member_handler->getGroupList());

/**
 * How many keywords to see at a time in the admin's part of the module ?
*/
$i++;
$modversion['config'][$i]['name'] = 'admincount';
$modversion['config'][$i]['title'] = '_MI_MYSEARCH_OPT2';
$modversion['config'][$i]['description'] = '_MI_MYSEARCH_OPT2_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;

$i++;
$modversion['config'][$i]['name'] = 'keyword_min';
$modversion['config'][$i]['title'] = '_MI_MYSEARCH_MIN_SEARCH';
$modversion['config'][$i]['description'] = '_MI_MYSEARCH_MIN_SEARCH_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 3;

$i++;
$modversion['config'][$i]['name'] = 'enable_deep_search';
$modversion['config'][$i]['title'] = '_MI_MYSEARCH_DO_DEEP_SEARCH';
$modversion['config'][$i]['description'] = '_MI_MYSEARCH_DO_DEEP_SEARCH_DSC';
$modversion['config'][$i]['formtype'] = 'yesno';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 0;

$i++;
$modversion['config'][$i]['name'] = 'num_shallow_search';
$modversion['config'][$i]['title'] = '_MI_MYSEARCH_INIT_SRCH_RSLTS';
$modversion['config'][$i]['description'] = '_MI_MYSEARCH_INIT_SRCH_RSLTS_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 5;

$i++;
$modversion['config'][$i]['name'] = 'num_module_search';
$modversion['config'][$i]['title'] = '_MI_MYSEARCH_MDL_SRCH_RESULTS';
$modversion['config'][$i]['description'] = '_MI_MYSEARCH_MDL_SRCH_RESULTS_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;

// Notifications
$modversion['hasNotification'] = 0;
?>
