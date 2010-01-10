<?php
// $Id: modinfo.php,v 1.1.1.1 2005/11/10 19:51:19 phppp Exp $
// _LANGCODE: en
// _CHARSET : ISO-8859-1
// Translator: D.J., http://xoopsforge.com, http://xoops.org.cn

if (!defined('XOOPS_ROOT_PATH')){ exit(); }

$current_path = __FILE__;
if ( DIRECTORY_SEPARATOR != "/" ) $current_path = str_replace( strpos( $current_path, "\\\\", 2 ) ? "\\\\" : DIRECTORY_SEPARATOR, "/", $current_path);
$url_arr = explode("/",strstr($current_path,"/modules/"));
include XOOPS_ROOT_PATH."/modules/".$url_arr[2]."/include/vars.php";

if(defined($GLOBALS["ART_VAR_PREFIXU"]."_LANG_EN_MODINFO")) return; define($GLOBALS["ART_VAR_PREFIXU"]."_LANG_EN_MODINFO",1);

define($GLOBALS["ART_VAR_PREFIXU"]."_MI_NAME", "Article");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DESC", "Article Management");

define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PAGE_INDEX", "Index");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PAGE_ARTICLE", "Article");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PAGE_CATEGORY", "Category");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PAGE_TOPIC", "Topic");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PAGE_AUTHOR", "Author");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PAGE_KEYWORD", "Keyword");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PAGE_BLOCKS", "Blocks");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PAGE_ARCHIVE", "Archive");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PAGE_LIST", "List");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PAGE_SEARCH", "Search");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PAGE_MYPAGE", "My page");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PAGE_TAGS", "Tag list");

define($GLOBALS["ART_VAR_PREFIXU"]."_MI_SUBMIT", "Submit");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_SPOTLIGHT", "Spotlight");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_SPOTLIGHT_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ARTICLE", "Articles");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ARTICLE_DESC", "");

define($GLOBALS["ART_VAR_PREFIXU"]."_MI_CATEGORY", "Categories");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_CATEGORY_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_TOPIC", "Topics");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_TOPIC_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_AUTHOR", "Authors");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_AUTHOR_DESC", "");

define($GLOBALS["ART_VAR_PREFIXU"]."_MI_BLOCK_RECENTNEWS", "Recent news");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_BLOCK_TAG_CLOUD", "Tag Cloud");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_BLOCK_TAG_TOP", "Top Tags");

define($GLOBALS["ART_VAR_PREFIXU"]."_MI_TIMEFORMAT", "Time format for display");
xoops_load("xoopslocal");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_TIMEFORMAT_DESC", XoopsLocal::getTimeFormatDesc());
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_TIMEFORMAT_CUSTOM", "Custom");

define($GLOBALS["ART_VAR_PREFIXU"]."_MI_CONFIGCAT_MODULE", "General setting");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_CONFIGCAT_MODULE_DESC", "Module-wide preferences");

define($GLOBALS["ART_VAR_PREFIXU"]."_MI_CONFIGCAT_ARTICLE", "Article setting");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_CONFIGCAT_ARTICLE_DESC", "Article related");

define($GLOBALS["ART_VAR_PREFIXU"]."_MI_THEMESET", "Theme set");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_THEMESET_DESC", "Module-wide, select '"._NONE."' will use site-wide theme");

define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DISPLAY_SUMMARY", "Display summary on article list");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DISPLAY_SUMMARY_DESC", "On index, category and topic pages");

define($GLOBALS["ART_VAR_PREFIXU"]."_MI_FORUM", "Forum");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_FORUM_DESC", "The forum to be used for discussion");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_URLFORUM", "Forum URL");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_URLFORUM_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_URLBLOG", "Blog URL");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_URLBLOG_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOFORMADVANCE", "Use advanced form by default");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOFORMADVANCE_DESC", "For article edit");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOSPOTLIGHT", "Enable spotlight");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOSPOTLIGHT_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOREALNAME", "User realname");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOREALNAME_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOTRACKBACK", "Enable trackback");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOTRACKBACK_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOTRACKBACKUTF8", "Use UTF-8 encoding for trackback");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOTRACKBACKUTF8_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOAPISTATS", "Enable article api stats");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOAPISTATS_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOIMAGEUPLOAD", "Enable image upload");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOIMAGEUPLOAD_DESC", "For each article");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DORSSUTF8", "Use UTF-8 encoding for XML");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DORSSUTF8_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DODEBUG", "Enable debug");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DODEBUG_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOURLREWRITE", "Enable URL rewrite");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOURLREWRITE_DESC", "AcceptPathInfo On for Apache2 is required");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOCOUNTER", "Enable article view count");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOCOUNTER_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOPINGBACK", "Enable pingback");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOPINGBACK_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOSIBLING", "Enable sibling articles");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOSIBLING_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOSUBTITLE", "Enable subtitle display");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOSUBTITLE_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOHEADING", "Enable heading parsing and display");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOHEADING_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOFOOTNOTE", "Enable footnote parsing and display");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOFOOTNOTE_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DORATE", "Enable rate for articles");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DORATE_DESC", "Relevant permission need be set once enabled");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOKEYWORDS", "Enable keywords highlight");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DOKEYWORDS_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_SIBLINGLENGTH", "Sibling title length");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_SIBLINGLENGTH_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_KEYWORDS", "Keywords");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_KEYWORDS_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_COUNTINGSUBCATEGORY", "Counting subcategories");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_COUNTINGSUBCATEGORY_DESC", "For article count");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ARTICLESPERPAGE", "Articles on one page");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ARTICLESPERPAGE_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ARTICLES_INDEX", "Articles on index page");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ARTICLESINDEX_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_FEATURED_INDEX", "Featured articles on index page");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_FEATUREDINDEX_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ARTICLES_CATEGORY", "Articles of each category on category page");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ARTICLES_CATEGORY_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_FEATURED_CATEGORY", "Featured articles on category page");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_FEATURED_CATEGORY_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_LENGTHEXCERPT", "Excerpt length");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_LENGTHEXCERPT_DESC", "In case \"summary\" not specified in an article, the length of its first page to use");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ARTICLE_EXPIRE", "Article expire");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ARTICLE_EXPIRE_DESC", "Days for an created article to expire before submit");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_TOPIC_EXPIRE", "Days for a topic to expire");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_TOPIC_EXPIRE_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_TOPIC_MAX", "Maximum active topics");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_TOPIC_MAX_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_TEMPLATE", "Template");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_TEMPLATE_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DISCLAIMER", "Disclaimer");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DISCLAIMER_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_DISCLAIMER_TEXT", "Your publish shall be subject to GPL and &copy; ".$GLOBALS["xoopsConfig"]["sitename"]);
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_SPONSOR", "Sponsors");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_SPONSOR_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PING", "Pings");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PING_DESC", "URLs to ping");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PATHCACHE", "Path to cached files");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PATHCACHE_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PATHFILE", "Path to uploaded files");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PATHFILE_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PATHIMAGE", "Path to module images");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PATHIMAGE_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PATHHTML", "Path to uploaded HTMLs");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_PATHHTML_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_SINCE_OPTIONS", "Since options");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_SINCE_OPTIONS_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_EDITORS", "Editors");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_EDITORS_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_COPYRIGHT", "Copyright");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_COPYRIGHT_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_HEADER", "Index Page Header");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_HEADER_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_TRACKBACK_OPTION", "Option for recieved trackbacks");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_TRACKBACK_OPTION_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_MODERATION", "Moderation");


define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ADMENU_INDEX", "Index");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ADMENU_CATEGORY", "Category");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ADMENU_TOPIC", "Topic");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ADMENU_ARTICLE", "Article");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ADMENU_PERMISSION", "Permission");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ADMENU_BLOCK", "Block");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ADMENU_SPOTLIGHT", "Spotlight");
//define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ADMENU_TEMPLATE", "Template");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ADMENU_TRACKBACK", "Trackback");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ADMENU_FILE", "File");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ADMENU_UTILITY", "Utility");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ADMENU_ABOUT", "About");

define($GLOBALS["ART_VAR_PREFIXU"]."_MI_GLOBAL_NOTIFY", "Global");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_GLOBAL_NOTIFYDSC", "Global notification options");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_CATEGORY_NOTIFY", "Category");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_CATEGORY_NOTIFYDSC", "Category notification options");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ARTICLE_NOTIFY", "Article");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ARTICLE_NOTIFYDSC", "Article notification options");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_GLOBAL_ARTICLESUBMIT_NOTIFY", "Article submission");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_GLOBAL_ARTICLESUBMIT_NOTIFYCAP", "Notify me of any pending article");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_GLOBAL_ARTICLESUBMIT_NOTIFYDSC", "Receive notification when a new article is submitted");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_GLOBAL_ARTICLESUBMIT_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New article submitted");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_GLOBAL_NEWARTICLE_NOTIFY", "New article");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_GLOBAL_NEWARTICLE_NOTIFYCAP", "Notify of any new article published");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_GLOBAL_NEWARTICLE_NOTIFYDSC", "Receive notification when a new article is published");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_GLOBAL_NEWARTICLE_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New article published");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_GLOBAL_ARTICLEMONITOR_NOTIFY", "Article monitor");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_GLOBAL_ARTICLEMONITOR_NOTIFYCAP", "Notify me of all actions on my articles");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_GLOBAL_ARTICLEMONITOR_NOTIFYDSC", "Receive notification when an action is taken over my articles");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_GLOBAL_ARTICLEMONITOR_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New action");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_GLOBAL_ARTICLETRACKBACK_NOTIFY", "Trackbacks moderation");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_GLOBAL_ARTICLETRACKBACK_NOTIFYCAP", "Notify me of all pending trackbacks");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_GLOBAL_ARTICLETRACKBACK_NOTIFYDSC", "Receive notification when a new trackback is received for approval");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_GLOBAL_ARTICLETRACKBACK_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New trackback to be approved");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_CATEGORY_ARTICLESUBMIT_NOTIFY", "Article submission");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_CATEGORY_ARTICLESUBMIT_NOTIFYCAP", "Notify me of any pending article");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_CATEGORY_ARTICLESUBMIT_NOTIFYDSC", "Receive notification when a new article is submitted for approval in this category");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_CATEGORY_ARTICLESUBMIT_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New article to be approved");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_CATEGORY_NEWARTICLE_NOTIFY", "New article");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_CATEGORY_NEWARTICLE_NOTIFYCAP", "Notify of any new article published in this category");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_CATEGORY_NEWARTICLE_NOTIFYDSC", "Receive notification when a new article is published in the category");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_CATEGORY_NEWARTICLE_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New article published");

define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ARTICLE_ARTICLEAPPROVE_NOTIFY", "Article approved");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ARTICLE_ARTICLEAPPROVE_NOTIFYCAP", "Notify me of approval of this article");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ARTICLE_ARTICLEAPPROVE_NOTIFYDSC", "Receive notification when the article is approved");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ARTICLE_ARTICLEAPPROVE_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : Article approved");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ARTICLE_ARTICLEMONITOR_NOTIFY", "Article monitor");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ARTICLE_ARTICLEMONITOR_NOTIFYCAP", "Notify me of any action taken on this article");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ARTICLE_ARTICLEMONITOR_NOTIFYDSC", "Receive notification when an action is taken on this article");
define($GLOBALS["ART_VAR_PREFIXU"]."_MI_ARTICLE_ARTICLEMONITOR_NOTIFYSBJ", "[{X_SITENAME}] {X_MODULE} auto-notify : New article published");
?>