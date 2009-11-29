<?php
// $Id: xoops_version.php,v 1.34 2004/09/01 17:48:07 hthouzard Exp $
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
if (!defined('XOOPS_ROOT_PATH')) {
	die('XOOPS root path not defined');
}

$modversion['name'] = _MI_NEWS_NAME;
$modversion['version'] = 1.64;
$modversion['description'] = _MI_NEWS_DESC;
$modversion['credits'] = "The XOOPS Project, Christian, Pilou, Marco, ALL the members of the Newbb Team, GIJOE, Zoullou, Mithrandir, Setec Astronomy, Marcan, 5vision, Anne";
$modversion['author'] = "The XOOPS Project Module Dev Team & Instant Zero";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 1;
$modversion['image'] = "images/news_slogo.png";
$modversion['dirname'] = "news";

$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tables created by sql file (without prefix!)
$modversion['tables'][0] = 'stories';
$modversion['tables'][1] = 'topics';
$modversion['tables'][2] = 'stories_files';
$modversion['tables'][3] = 'stories_votedata';

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Templates
$modversion['templates'][1]['file'] = 'news_item.html';
$modversion['templates'][1]['description'] = '';
$modversion['templates'][2]['file'] = 'news_archive.html';
$modversion['templates'][2]['description'] = '';
$modversion['templates'][3]['file'] = 'news_article.html';
$modversion['templates'][3]['description'] = '';
$modversion['templates'][4]['file'] = 'news_index.html';
$modversion['templates'][4]['description'] = '';
$modversion['templates'][5]['file'] = 'news_by_topic.html';
$modversion['templates'][5]['description'] = '';
$modversion['templates'][6]['file'] = 'news_by_this_author.html';
$modversion['templates'][6]['description'] = 'Shows a page resuming all the articles of the same author (according to the perms)';
$modversion['templates'][7]['file'] = 'news_ratenews.html';
$modversion['templates'][7]['description'] = 'Template used to rate a news';
$modversion['templates'][8]['file'] = 'news_rss.html';
$modversion['templates'][8]['description'] = 'Used for RSS per topics';
$modversion['templates'][9]['file'] = 'news_whos_who.html';
$modversion['templates'][9]['description'] = "Who's who";
$modversion['templates'][10]['file'] = 'news_topics_directory.html';
$modversion['templates'][10]['description'] = "Topics Directory";


// Blocks
$modversion['blocks'][1]['file'] = "news_topics.php";
$modversion['blocks'][1]['name'] = _MI_NEWS_BNAME1;
$modversion['blocks'][1]['description'] = "Shows news topics";
$modversion['blocks'][1]['show_func'] = "b_news_topics_show";
$modversion['blocks'][1]['template'] = 'news_block_topics.html';

$modversion['blocks'][2]['file'] = "news_bigstory.php";
$modversion['blocks'][2]['name'] = _MI_NEWS_BNAME3;
$modversion['blocks'][2]['description'] = "Shows most read story of the day";
$modversion['blocks'][2]['show_func'] = "b_news_bigstory_show";
$modversion['blocks'][2]['template'] = 'news_block_bigstory.html';

$modversion['blocks'][3]['file'] = "news_top.php";
$modversion['blocks'][3]['name'] = _MI_NEWS_BNAME4;
$modversion['blocks'][3]['description'] = "Shows top read news articles";
$modversion['blocks'][3]['show_func'] = "b_news_top_show";
$modversion['blocks'][3]['edit_func'] = "b_news_top_edit";
$modversion['blocks'][3]['options'] = "counter|10|25|0|0|0|0||1||||||";
$modversion['blocks'][3]['template'] = 'news_block_top.html';

$modversion['blocks'][4]['file'] = "news_top.php";
$modversion['blocks'][4]['name'] = _MI_NEWS_BNAME5;
$modversion['blocks'][4]['description'] = "Shows recent articles";
$modversion['blocks'][4]['show_func'] = "b_news_top_show";
$modversion['blocks'][4]['edit_func'] = "b_news_top_edit";
$modversion['blocks'][4]['options'] = "published|10|25|0|0|0|0||1||||||";
$modversion['blocks'][4]['template'] = 'news_block_top.html';

$modversion['blocks'][5]['file'] = "news_moderate.php";
$modversion['blocks'][5]['name'] = _MI_NEWS_BNAME6;
$modversion['blocks'][5]['description'] = "Shows a block to moderate articles";
$modversion['blocks'][5]['show_func'] = "b_news_topics_moderate";
$modversion['blocks'][5]['template'] = 'news_block_moderate.html';

$modversion['blocks'][6]['file'] = "news_topicsnav.php";
$modversion['blocks'][6]['name'] = _MI_NEWS_BNAME7;
$modversion['blocks'][6]['description'] = "Shows a block to navigate topics";
$modversion['blocks'][6]['show_func'] = "b_news_topicsnav_show";
$modversion['blocks'][6]['template'] = 'news_block_topicnav.html';
$modversion['blocks'][6]['options'] = "0";
$modversion['blocks'][6]['edit_func'] = "b_news_topicsnav_edit";

$modversion['blocks'][7]['file'] = "news_randomnews.php";
$modversion['blocks'][7]['name'] = _MI_NEWS_BNAME8;
$modversion['blocks'][7]['description'] = "Shows a block where news appears randomly";
$modversion['blocks'][7]['show_func'] = "b_news_randomnews_show";
$modversion['blocks'][7]['template'] = 'news_block_randomnews.html';
$modversion['blocks'][7]['options'] = "published|10|25|0|0";
$modversion['blocks'][7]['edit_func'] = "b_news_randomnews_edit";

$modversion['blocks'][8]['file'] = "news_archives.php";
$modversion['blocks'][8]['name'] = _MI_NEWS_BNAME9;
$modversion['blocks'][8]['description'] = "Shows a block where you can see archives";
$modversion['blocks'][8]['show_func'] = "b_news_archives_show";
$modversion['blocks'][8]['template'] = 'news_block_archives.html';
$modversion['blocks'][8]['options'] = "0|0|0|0|1|1";	// Starting date (year, month), ending date (year, month), until today, sort order
$modversion['blocks'][8]['edit_func'] = "b_news_archives_edit";

// Added in v1.63
$modversion['blocks'][9]['file'] = "news_block_tag.php";
$modversion['blocks'][9]['name'] = _MI_NEWS_BNAME10;
$modversion['blocks'][9]['description'] = "Show tag cloud";
$modversion['blocks'][9]['show_func'] = "news_tag_block_cloud_show";
$modversion['blocks'][9]['edit_func'] = "news_tag_block_cloud_edit";
$modversion['blocks'][9]['options'] = "100|0|150|80";
$modversion['blocks'][9]['template'] = 'news_tag_block_cloud.html';

$modversion['blocks'][10]['file'] = "news_block_tag.php";
$modversion['blocks'][10]['name'] = _MI_NEWS_BNAME11;
$modversion['blocks'][10]['description'] = "Show top tags";
$modversion['blocks'][10]['show_func'] = "news_tag_block_top_show";
$modversion['blocks'][10]['edit_func'] = "news_tag_block_top_edit";
$modversion['blocks'][10]['options'] = "50|30|c";
$modversion['blocks'][10]['template'] = 'news_tag_block_top.html';


// Menu
$modversion['hasMain'] = 1;

$cansubmit = 0;

/**
 * This part inserts the selected topics as sub items in the Xoops main menu
 */
$module_handler =& xoops_gethandler('module');
$module =& $module_handler->getByDirname($modversion['dirname']);
if ($module) {
    global $xoopsUser;
    if (is_object($xoopsUser)) {
        $groups = $xoopsUser->getGroups();
    } else {
        $groups = XOOPS_GROUP_ANONYMOUS;
    }
    $gperm_handler =& xoops_gethandler('groupperm');
    if ($gperm_handler->checkRight("news_submit", 0, $groups, $module->getVar('mid'))) {
          $cansubmit = 1;
    }
}

// ************
$i = 1;
global $xoopsDB, $xoopsUser, $xoopsConfig, $xoopsModule, $xoopsModuleConfig;
// We try to "win" some time
// 1)  Check to see it the module is the current module
if (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $modversion['dirname'] && $xoopsModule->getVar('isactive')) {
	// 2) If there's no topics to display as sub menus we can go on
	if(!isset($_SESSION['items_count']) || $_SESSION['items_count']== -1) {
		$sql = "SELECT COUNT(*) as cpt FROM ".$xoopsDB->prefix("topics")." WHERE menu=1";
		$result = $xoopsDB->query($sql);
		list($count) = $xoopsDB->fetchRow($result);
		$_SESSION['items_count'] = $count;
	} else {
		$count = $_SESSION['items_count'];
	}
	if($count>0) {
		include_once XOOPS_ROOT_PATH.'/class/tree.php';
		include_once XOOPS_ROOT_PATH.'/modules/news/class/class.newstopic.php';
		include_once XOOPS_ROOT_PATH.'/modules/news/include/functions.php';
		$xt = new NewsTopic();
		$allTopics = $xt->getAllTopics(news_getmoduleoption('restrictindex'));
		$topic_tree = new XoopsObjectTree($allTopics, 'topic_id', 'topic_pid');
		$topics_arr = $topic_tree->getAllChild(0);
		if ($module) {
			foreach ($topics_arr as $onetopic) {
				if ($gperm_handler->checkRight('news_view', $onetopic->topic_id(), $groups, $xoopsModule->getVar('mid')) && $onetopic->menu()) {
	            	$modversion['sub'][$i]['name'] = $onetopic->topic_title();
  					$modversion['sub'][$i]['url'] = "index.php?storytopic=" . $onetopic->topic_id();
   				}
       			$i++;
   			}
		}
		unset($xt);
	}
}

$modversion['sub'][$i]['name'] = _MI_NEWS_SMNAME2;
$modversion['sub'][$i]['url'] = "archive.php";
if ($cansubmit) {
	$i++;
    $modversion['sub'][$i]['name'] = _MI_NEWS_SMNAME1;
    $modversion['sub'][$i]['url'] = "submit.php";
}
unset($cansubmit);

include_once XOOPS_ROOT_PATH.'/modules/news/include/functions.php';
if(news_getmoduleoption('newsbythisauthor')) {
	$i++;
	$modversion['sub'][$i]['name'] = _MI_NEWS_WHOS_WHO;
	$modversion['sub'][$i]['url'] = "whoswho.php";
}

$i++;
$modversion['sub'][$i]['name'] = _MI_NEWS_TOPICS_DIRECTORY;
$modversion['sub'][$i]['url'] = "topics_directory.php";


// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "news_search";

// Comments
$modversion['hasComments'] = 1;
$modversion['comments']['pageName'] = 'article.php';
$modversion['comments']['itemName'] = 'storyid';
// Comment callback functions
$modversion['comments']['callbackFile'] = 'include/comment_functions.php';
$modversion['comments']['callback']['approve'] = 'news_com_approve';
$modversion['comments']['callback']['update'] = 'news_com_update';

/**
 * Select the number of news items to display on top page
 */
$modversion['config'][1]['name'] = 'storyhome';
$modversion['config'][1]['title'] = '_MI_STORYHOME';
$modversion['config'][1]['description'] = '_MI_STORYHOMEDSC';
$modversion['config'][1]['formtype'] = 'select';
$modversion['config'][1]['valuetype'] = 'int';
$modversion['config'][1]['default'] = 5;
$modversion['config'][1]['options'] = array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30);

/**
 * Format of the date to use in the module, if you don't specify anything then the default date's format will be used
 */
$modversion['config'][2]['name'] = 'dateformat';
$modversion['config'][2]['title'] = '_MI_NEWS_DATEFORMAT';
$modversion['config'][2]['description'] = '_MI_NEWS_DATEFORMAT_DESC';
$modversion['config'][2]['formtype'] = 'textbox';
$modversion['config'][2]['valuetype'] = 'text';
$modversion['config'][2]['default'] = "";

/**
 * Display a navigation's box on the pages ?
 * This navigation's box enable you to jump from one topic to another
 */
$modversion['config'][3]['name'] = 'displaynav';
$modversion['config'][3]['title'] = '_MI_DISPLAYNAV';
$modversion['config'][3]['description'] = '_MI_DISPLAYNAVDSC';
$modversion['config'][3]['formtype'] = 'yesno';
$modversion['config'][3]['valuetype'] = 'int';
$modversion['config'][3]['default'] = 1;

/*
$modversion['config'][4]['name'] = 'anonpost';
$modversion['config'][4]['title'] = '_MI_ANONPOST';
$modversion['config'][4]['description'] = '';
$modversion['config'][4]['formtype'] = 'yesno';
$modversion['config'][4]['valuetype'] = 'int';
$modversion['config'][4]['default'] = 0;
*/

/**
 * Auto approuve submited stories
 */
$modversion['config'][5]['name'] = 'autoapprove';
$modversion['config'][5]['title'] = '_MI_AUTOAPPROVE';
$modversion['config'][5]['description'] = '_MI_AUTOAPPROVEDSC';
$modversion['config'][5]['formtype'] = 'yesno';
$modversion['config'][5]['valuetype'] = 'int';
$modversion['config'][5]['default'] = 0;

/**
 * Dispay layout, classic or by topics
 */
$modversion['config'][6]['name'] = 'newsdisplay';
$modversion['config'][6]['title'] = '_MI_NEWSDISPLAY';
$modversion['config'][6]['description'] = '_MI_NEWSDISPLAYDESC';
$modversion['config'][6]['formtype'] = 'select';
$modversion['config'][6]['valuetype'] = 'text';
$modversion['config'][6]['default'] = "Classic";
$modversion['config'][6]['options'] = array('_MI_NEWSCLASSIC' => 'Classic','_MI_NEWSBYTOPIC' => 'Bytopic');

/**
 * How to display Author's name, username, full name or nothing ?
 */
$modversion['config'][7]['name'] = 'displayname';
$modversion['config'][7]['title'] = '_MI_NAMEDISPLAY';
$modversion['config'][7]['description'] = '_MI_ADISPLAYNAMEDSC';
$modversion['config'][7]['formtype'] = 'select';
$modversion['config'][7]['valuetype'] = 'int';
$modversion['config'][7]['default'] = 1;
$modversion['config'][7]['options']	= array('_MI_DISPLAYNAME1' => 1, '_MI_DISPLAYNAME2' => 2, '_MI_DISPLAYNAME3' => 3);

/**
 * Number of columns to use to display news
 */
$modversion['config'][8]['name'] = 'columnmode';
$modversion['config'][8]['title'] = '_MI_COLUMNMODE';
$modversion['config'][8]['description'] = '_MI_COLUMNMODE_DESC';
$modversion['config'][8]['formtype'] = 'select';
$modversion['config'][8]['valuetype'] = 'int';
$modversion['config'][8]['default'] = 1;
$modversion['config'][8]['options'] = array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5);

/**
 * Number of news and topics to display in the module's admin part
 */
$modversion['config'][9]['name'] = 'storycountadmin';
$modversion['config'][9]['title'] = '_MI_STORYCOUNTADMIN';
$modversion['config'][9]['description'] = '_MI_STORYCOUNTADMIN_DESC';
$modversion['config'][9]['formtype'] = 'select';
$modversion['config'][9]['valuetype'] = 'int';
$modversion['config'][9]['default'] = 10;
$modversion['config'][9]['options'] = array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '35' => 35, '40' => 40);

/**
 * Authorized groups to upload
 */
$modversion['config'][10]['name'] = 'uploadgroups';
$modversion['config'][10]['title'] = '_MI_UPLOADGROUPS';
$modversion['config'][10]['description'] = '_MI_UPLOADGROUPS_DESC';
$modversion['config'][10]['formtype'] = 'select';
$modversion['config'][10]['valuetype'] = 'int';
$modversion['config'][10]['default'] = 2;
$modversion['config'][10]['options'] = array('_MI_UPLOAD_GROUP1' => 1, '_MI_UPLOAD_GROUP2' => 2, '_MI_UPLOAD_GROUP3' => 3);

/**
 * MAX Filesize Upload in kilo bytes
 */
$modversion['config'][11]['name'] = 'maxuploadsize';
$modversion['config'][11]['title'] = '_MI_UPLOADFILESIZE';
$modversion['config'][11]['description'] = '_MI_UPLOADFILESIZE_DESC';
$modversion['config'][11]['formtype'] = 'textbox';
$modversion['config'][11]['valuetype'] = 'int';
$modversion['config'][11]['default'] = 1048576;

/**
 * Restrict Topics on Index Page
 *
 * This is one of the mot important option in the module.
 * If you set it to No, then the users can see the introduction's text of each
 * story even if they don't have the right to see the topic attached to the news.
 * If you set it to Yes then you can only see what you have the right to see.
 * Many of the permissions are based on this option.
 */
$modversion['config'][12]['name'] = 'restrictindex';
$modversion['config'][12]['title'] = '_MI_RESTRICTINDEX';
$modversion['config'][12]['description'] = '_MI_RESTRICTINDEXDSC';
$modversion['config'][12]['formtype'] = 'yesno';
$modversion['config'][12]['valuetype'] = 'int';
$modversion['config'][12]['default'] = 0;

/**
 * Do you want to enable your visitors to see all the other articles
 * created by the author they are currently reading ?
 */
$modversion['config'][13]['name'] = 'newsbythisauthor';
$modversion['config'][13]['title'] = '_MI_NEWSBYTHISAUTHOR';
$modversion['config'][13]['description'] = '_MI_NEWSBYTHISAUTHORDSC';
$modversion['config'][13]['formtype'] = 'yesno';
$modversion['config'][13]['valuetype'] = 'int';
$modversion['config'][13]['default'] = 0;

/**
 * If you set this option to yes then you will see two links at the bottom
 * of each article. The first link will enable you to go to the previous
 * article and the other link will bring you to the next article
 */
$modversion['config'][14]['name'] = 'showprevnextlink';
$modversion['config'][14]['title'] = '_MI_NEWS_PREVNEX_LINK';
$modversion['config'][14]['description'] = '_MI_NEWS_PREVNEX_LINK_DESC';
$modversion['config'][14]['formtype'] = 'yesno';
$modversion['config'][14]['valuetype'] = 'int';
$modversion['config'][14]['default'] = 0;

/**
 * Do you want to see a summary table at the bottom of each article ?
 */
$modversion['config'][15]['name'] = 'showsummarytable';
$modversion['config'][15]['title'] = '_MI_NEWS_SUMMARY_SHOW';
$modversion['config'][15]['description'] = '_MI_NEWS_SUMMARY_SHOW_DESC';
$modversion['config'][15]['formtype'] = 'yesno';
$modversion['config'][15]['valuetype'] = 'int';
$modversion['config'][15]['default'] = 0;

/**
 * Do you enable author's to edit their posts ?
 */
$modversion['config'][16]['name'] = 'authoredit';
$modversion['config'][16]['title'] = '_MI_NEWS_AUTHOR_EDIT';
$modversion['config'][16]['description'] = '_MI_NEWS_AUTHOR_EDIT_DESC';
$modversion['config'][16]['formtype'] = 'yesno';
$modversion['config'][16]['valuetype'] = 'int';
$modversion['config'][16]['default'] = 1;

/**
 * Do you want to enable your visitors to rate news ?
 */
$modversion['config'][17]['name'] = 'ratenews';
$modversion['config'][17]['title'] = "_MI_NEWS_RATE_NEWS";
$modversion['config'][17]['description'] = "";
$modversion['config'][17]['formtype'] = 'yesno';
$modversion['config'][17]['valuetype'] = 'int';
$modversion['config'][17]['default'] = 0;

/**
 * You can set RSS feeds per topic
 */
$modversion['config'][18]['name'] = 'topicsrss';
$modversion['config'][18]['title'] = "_MI_NEWS_TOPICS_RSS";
$modversion['config'][18]['description'] = "_MI_NEWS_TOPICS_RSS_DESC";
$modversion['config'][18]['formtype'] = 'yesno';
$modversion['config'][18]['valuetype'] = 'int';
$modversion['config'][18]['default'] = 0;

/**
 * If you set this option to yes then the approvers can type the keyword
 * and description's meta datas
 */
$modversion['config'][19]['name'] = 'metadata';
$modversion['config'][19]['title'] = "_MI_NEWS_META_DATA";
$modversion['config'][19]['description'] = "_MI_NEWS_META_DATA_DESC";
$modversion['config'][19]['formtype'] = 'yesno';
$modversion['config'][19]['valuetype'] = 'int';
$modversion['config'][19]['default'] = 0;

/**
 * Editor to use
 */
$modversion['config'][20]['name'] = 'form_options';
$modversion['config'][20]['title'] = "_MI_NEWS_FORM_OPTIONS";
$modversion['config'][20]['description'] = '_MI_NEWS_FORM_OPTIONS_DESC';
$modversion['config'][20]['formtype'] = 'select';
$modversion['config'][20]['valuetype'] = 'text';
$modversion['config'][20]['default'] = 'dhtml';
xoops_load('xoopseditorhandler');
$editor_handler = XoopsEditorHandler::getInstance();
$modversion['config'][20]['options'] = array_flip($editor_handler->getList());


/**
 * If you set this option to Yes then the keywords entered in the
 * search will be highlighted in the articles.
 */
$modversion['config'][21]['name'] = 'keywordshighlight';
$modversion['config'][21]['title'] = "_MI_NEWS_KEYWORDS_HIGH";
$modversion['config'][21]['description'] = "_MI_NEWS_KEYWORDS_HIGH_DESC";
$modversion['config'][21]['formtype'] = 'yesno';
$modversion['config'][21]['valuetype'] = 'int';
$modversion['config'][21]['default'] = 0;

/**
 * If you have enabled the previous option then with this one
 * you can select the color to use to highlight words
 */
$modversion['config'][22]['name'] = 'highlightcolor';
$modversion['config'][22]['title'] = '_MI_NEWS_HIGH_COLOR';
$modversion['config'][22]['description'] = '_MI_NEWS_HIGH_COLOR_DES';
$modversion['config'][22]['formtype'] = 'textbox';
$modversion['config'][22]['valuetype'] = 'text';
$modversion['config'][22]['default'] = "#FFFF80";

/**
 * Tooltips, or infotips are some small textes you can see when you
 * move your mouse over an article's title. This text contains the
 * first (x) characters of the story
 */
$modversion['config'][23]['name'] = 'infotips';
$modversion['config'][23]['title'] = '_MI_NEWS_INFOTIPS';
$modversion['config'][23]['description'] = '_MI_NEWS_INFOTIPS_DES';
$modversion['config'][23]['formtype'] = 'textbox';
$modversion['config'][23]['valuetype'] = 'int';
$modversion['config'][23]['default'] = "0";

/**
 * This option is specific to Mozilla/Firefox and Opera
 * Both of them can display a toolbar wich contains buttons to
 * go from article to article. It can show other information too
 */
$modversion['config'][24]['name'] = 'sitenavbar';
$modversion['config'][24]['title'] = "_MI_NEWS_SITE_NAVBAR";
$modversion['config'][24]['description'] = "_MI_NEWS_SITE_NAVBAR_DESC";
$modversion['config'][24]['formtype'] = 'yesno';
$modversion['config'][24]['valuetype'] = 'int';
$modversion['config'][24]['default'] = 0;

/**
 * With this option you can select the skin (apparence) to use for the blocks containing tabs
 */
$modversion['config'][25]['name'] = 'tabskin';
$modversion['config'][25]['title'] = "_MI_NEWS_TABS_SKIN";
$modversion['config'][25]['description'] = "_MI_NEWS_TABS_SKIN_DESC";
$modversion['config'][25]['formtype'] = 'select';
$modversion['config'][25]['valuetype'] = 'int';
$modversion['config'][25]['options'] = array(
											_MI_NEWS_SKIN_1=>1,
											_MI_NEWS_SKIN_2=>2,
											_MI_NEWS_SKIN_3=>3,
											_MI_NEWS_SKIN_4=>4,
											_MI_NEWS_SKIN_5=>5,
											_MI_NEWS_SKIN_6=>6,
											_MI_NEWS_SKIN_7=>7,
											_MI_NEWS_SKIN_8=>8
											);
$modversion['config'][25]['default'] = 6;


/**
 * Display a navigation's box on the pages ?
 * This navigation's box enable you to jump from one topic to another
 */
$modversion['config'][26]['name'] = 'footNoteLinks';
$modversion['config'][26]['title'] = '_MI_NEWS_FOOTNOTES';
$modversion['config'][26]['description'] = '';
$modversion['config'][26]['formtype'] = 'yesno';
$modversion['config'][26]['valuetype'] = 'int';
$modversion['config'][26]['default'] = 1;


/**
 * Activate Dublin Core Metadata ?
 */
$modversion['config'][27]['name'] = 'dublincore';
$modversion['config'][27]['title'] = '_MI_NEWS_DUBLINCORE';
$modversion['config'][27]['description'] = '_MI_NEWS_DUBLINCORE_DSC';
$modversion['config'][27]['formtype'] = 'yesno';
$modversion['config'][27]['valuetype'] = 'int';
$modversion['config'][27]['default'] = 0;


/**
 * Display a "Bookmark this article at these sites" block ?
 */
$modversion['config'][28]['name'] = 'bookmarkme';
$modversion['config'][28]['title'] = '_MI_NEWS_BOOKMARK_ME';
$modversion['config'][28]['description'] = '_MI_NEWS_BOOKMARK_ME_DSC';
$modversion['config'][28]['formtype'] = 'yesno';
$modversion['config'][28]['valuetype'] = 'int';
$modversion['config'][28]['default'] = 0;

/**
 * Activate Firefox 2 microformats ?
 */
$modversion['config'][29]['name'] = 'firefox_microsummaries';
$modversion['config'][29]['title'] = '_MI_NEWS_FF_MICROFORMAT';
$modversion['config'][29]['description'] = '_MI_NEWS_FF_MICROFORMAT_DSC';
$modversion['config'][29]['formtype'] = 'yesno';
$modversion['config'][29]['valuetype'] = 'int';
$modversion['config'][29]['default'] = 0;

/**
 * Advertisement
 */
$modversion['config'][30]['name'] = 'advertisement';
$modversion['config'][30]['title'] = '_MI_NEWS_ADVERTISEMENT';
$modversion['config'][30]['description'] = '_MI_NEWS_ADV_DESCR';
$modversion['config'][30]['formtype'] = 'textarea';
$modversion['config'][30]['valuetype'] = 'text';
$modversion['config'][30]['default'] = '';

/**
 * Mime Types
 *
 * Default values : Web pictures (png, gif, jpeg), zip, pdf, gtar, tar, pdf
 */
$modversion['config'][31]['name'] = 'mimetypes';
$modversion['config'][31]['title'] = '_MI_NEWS_MIME_TYPES';
$modversion['config'][31]['description'] = '';
$modversion['config'][31]['formtype'] = 'textarea';
$modversion['config'][31]['valuetype'] = 'text';
$modversion['config'][31]['default'] = "image/gif\nimage/jpeg\nimage/pjpeg\nimage/x-png\nimage/png\napplication/x-zip-compressed\napplication/zip\napplication/pdf\napplication/x-gtar\napplication/x-tar";

/**
 * Use enhanced page separator ?
 */
$modversion['config'][32]['name'] = 'enhanced_pagenav';
$modversion['config'][32]['title'] = '_MI_NEWS_ENHANCED_PAGENAV';
$modversion['config'][32]['description'] = '_MI_NEWS_ENHANCED_PAGENAV_DSC';
$modversion['config'][32]['formtype'] = 'yesno';
$modversion['config'][32]['valuetype'] = 'int';
$modversion['config'][32]['default'] = 0;

/**
 * Use the TAGS system ?
 */
$modversion['config'][33]['name'] = 'tags';
$modversion['config'][33]['title'] = '_MI_NEWS_TAGS';
$modversion['config'][33]['description'] = '_MI_NEWS_TAGS_DSC';
$modversion['config'][33]['formtype'] = 'yesno';
$modversion['config'][33]['valuetype'] = 'int';
$modversion['config'][33]['default'] = 0;

/**
 * Introduction text to show on the submit page
 */
$modversion['config'][34]['name'] = 'submitintromsg';
$modversion['config'][34]['title'] = '_MI_NEWS_INTRO_TEXT';
$modversion['config'][34]['description'] = '';
$modversion['config'][34]['formtype'] = 'textarea';
$modversion['config'][34]['valuetype'] = 'text';
$modversion['config'][34]['default'] = '';

/**
 * Max width
 */
$i++;
$modversion['config'][35]['name'] = 'maxwidth';
$modversion['config'][35]['title'] = '_MI_NEWS_IMAGE_MAX_WIDTH';
$modversion['config'][35]['description'] = '';
$modversion['config'][35]['formtype'] = 'textbox';
$modversion['config'][35]['valuetype'] = 'int';
$modversion['config'][35]['default'] = 640;

/**
 * Max height
 */
$i++;
$modversion['config'][36]['name'] = 'maxheight';
$modversion['config'][36]['title'] = '_MI_NEWS_IMAGE_MAX_HEIGHT';
$modversion['config'][36]['description'] = '';
$modversion['config'][36]['formtype'] = 'textbox';
$modversion['config'][36]['valuetype'] = 'int';
$modversion['config'][36]['default'] = 480;


// Notification
$modversion['hasNotification'] = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'news_notify_iteminfo';

$modversion['notification']['category'][1]['name'] = 'global';
$modversion['notification']['category'][1]['title'] = _MI_NEWS_GLOBAL_NOTIFY;
$modversion['notification']['category'][1]['description'] = _MI_NEWS_GLOBAL_NOTIFYDSC;
$modversion['notification']['category'][1]['subscribe_from'] = array('index.php', 'article.php');

$modversion['notification']['category'][2]['name'] = 'story';
$modversion['notification']['category'][2]['title'] = _MI_NEWS_STORY_NOTIFY;
$modversion['notification']['category'][2]['description'] = _MI_NEWS_STORY_NOTIFYDSC;
$modversion['notification']['category'][2]['subscribe_from'] = array('article.php');
$modversion['notification']['category'][2]['item_name'] = 'storyid';
$modversion['notification']['category'][2]['allow_bookmark'] = 1;

// Added by Lankford on 2007/3/23
$modversion['notification']['category'][3]['name'] = 'category';
$modversion['notification']['category'][3]['title'] = _MI_NEWS_CATEGORY_NOTIFY;
$modversion['notification']['category'][3]['description'] = _MI_NEWS_CATEGORY_NOTIFYDSC;
$modversion['notification']['category'][3]['subscribe_from'] = array('index.php', 'article.php');
$modversion['notification']['category'][3]['item_name'] = 'storytopic';
$modversion['notification']['category'][3]['allow_bookmark'] = 1;

$modversion['notification']['event'][1]['name'] = 'new_category';
$modversion['notification']['event'][1]['category'] = 'global';
$modversion['notification']['event'][1]['title'] = _MI_NEWS_GLOBAL_NEWCATEGORY_NOTIFY;
$modversion['notification']['event'][1]['caption'] = _MI_NEWS_GLOBAL_NEWCATEGORY_NOTIFYCAP;
$modversion['notification']['event'][1]['description'] = _MI_NEWS_GLOBAL_NEWCATEGORY_NOTIFYDSC;
$modversion['notification']['event'][1]['mail_template'] = 'global_newcategory_notify';
$modversion['notification']['event'][1]['mail_subject'] = _MI_NEWS_GLOBAL_NEWCATEGORY_NOTIFYSBJ;

$modversion['notification']['event'][2]['name'] = 'story_submit';
$modversion['notification']['event'][2]['category'] = 'global';
$modversion['notification']['event'][2]['admin_only'] = 1;
$modversion['notification']['event'][2]['title'] = _MI_NEWS_GLOBAL_STORYSUBMIT_NOTIFY;
$modversion['notification']['event'][2]['caption'] = _MI_NEWS_GLOBAL_STORYSUBMIT_NOTIFYCAP;
$modversion['notification']['event'][2]['description'] = _MI_NEWS_GLOBAL_STORYSUBMIT_NOTIFYDSC;
$modversion['notification']['event'][2]['mail_template'] = 'global_storysubmit_notify';
$modversion['notification']['event'][2]['mail_subject'] = _MI_NEWS_GLOBAL_STORYSUBMIT_NOTIFYSBJ;

$modversion['notification']['event'][3]['name'] = 'new_story';
$modversion['notification']['event'][3]['category'] = 'global';
$modversion['notification']['event'][3]['title'] = _MI_NEWS_GLOBAL_NEWSTORY_NOTIFY;
$modversion['notification']['event'][3]['caption'] = _MI_NEWS_GLOBAL_NEWSTORY_NOTIFYCAP;
$modversion['notification']['event'][3]['description'] = _MI_NEWS_GLOBAL_NEWSTORY_NOTIFYDSC;
$modversion['notification']['event'][3]['mail_template'] = 'global_newstory_notify';
$modversion['notification']['event'][3]['mail_subject'] = _MI_NEWS_GLOBAL_NEWSTORY_NOTIFYSBJ;

$modversion['notification']['event'][4]['name'] = 'approve';
$modversion['notification']['event'][4]['category'] = 'story';
$modversion['notification']['event'][4]['invisible'] = 1;
$modversion['notification']['event'][4]['title'] = _MI_NEWS_STORY_APPROVE_NOTIFY;
$modversion['notification']['event'][4]['caption'] = _MI_NEWS_STORY_APPROVE_NOTIFYCAP;
$modversion['notification']['event'][4]['description'] = _MI_NEWS_STORY_APPROVE_NOTIFYDSC;
$modversion['notification']['event'][4]['mail_template'] = 'story_approve_notify';
$modversion['notification']['event'][4]['mail_subject'] = _MI_NEWS_STORY_APPROVE_NOTIFYSBJ;

// Added by Lankford on 2007/3/23
$modversion['notification']['event'][5]['name'] = 'new_story';
$modversion['notification']['event'][5]['category'] = 'category';
$modversion['notification']['event'][5]['title'] = _MI_NEWS_CATEGORY_STORYPOSTED_NOTIFY;
$modversion['notification']['event'][5]['caption'] = _MI_NEWS_CATEGORY_STORYPOSTED_NOTIFYCAP;
$modversion['notification']['event'][5]['description'] = _MI_NEWS_CATEGORY_STORYPOSTED_NOTIFYDSC;
$modversion['notification']['event'][5]['mail_template'] = 'category_newstory_notify';
$modversion['notification']['event'][5]['mail_subject'] = _MI_NEWS_CATEGORY_STORYPOSTED_NOTIFYSBJ;
?>