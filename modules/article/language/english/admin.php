<?php
// $Id: admin.php,v 1.1.1.1 2005/11/10 19:51:18 phppp Exp $
// _LANGCODE: en
// _CHARSET : ISO-8859-1
// Translator: D.J., http://xoopsforge.com, http://xoops.org.cn

if (!defined('XOOPS_ROOT_PATH')){ exit(); }

$current_path = __FILE__;
if ( DIRECTORY_SEPARATOR != "/" ) $current_path = str_replace( strpos( $current_path, "\\\\", 2 ) ? "\\\\" : DIRECTORY_SEPARATOR, "/", $current_path);
$url_arr = explode("/",strstr($current_path,"/modules/"));
include XOOPS_ROOT_PATH."/modules/".$url_arr[2]."/include/vars.php";

if(defined($GLOBALS["ART_VAR_PREFIXU"]."_LANG_EN_ADMIN")) return; define($GLOBALS["ART_VAR_PREFIXU"]."_LANG_EN_ADMIN",1);

define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ARTICLES", "Article Manager");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_APPROVEARTICLE", "Approve articles");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_CPARTICLE", "Article Cpanel");

define($GLOBALS["ART_VAR_PREFIXU"]."_AM_SPOTLIGHT", "Spotlight Manager");
//define($GLOBALS["ART_VAR_PREFIXU"]."_AM_SPOTLIGHT_LATEST", "Use latest article");;
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_SPOTLIGHT_CURRENT", "Current Spotlight");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_SPOTLIGHT_CATEGORIES", "Accessible categories");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_IMAGE_UPLOAD", "Upload image");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_IMAGE_SELECT", "Select image");
//define($GLOBALS["ART_VAR_PREFIXU"]."_AM_SPOTLIGHT_CHOOSE", "Choose an article");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_SPOTLIGHT_OPTION", "Spotlight option");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_SPOTLIGHT_LASTARTICLE", "Last article");
//define($GLOBALS["ART_VAR_PREFIXU"]."_AM_SPOTLIGHT_LASTFEATURE", "Last featured article");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_SPOTLIGHT_SPECIFIED", "Specified article");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_SPOTLIGHT_NOTE", "Spotlight note");

define($GLOBALS["ART_VAR_PREFIXU"]."_AM_TITLE", "Title");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_CATEGORY", "Category");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_SPOTIT", "Choose");

define($GLOBALS["ART_VAR_PREFIXU"]."_AM_SUBMITTED", "Submitted articles");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_CATEGORIES", "Categories");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_CPCATEGORY", "Category Cpanel");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ADDCATEGORY", "Add Category");

define($GLOBALS["ART_VAR_PREFIXU"]."_AM_FILES", "File Manager");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_FILES_ALL", "All");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_FILES_ORPHAN", "Orphan");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_FILENAME", "Filename");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ARTICLE", "Article");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_LOST", "Lost");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ORPHAN", "Orphan");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ACTION", "Action");

define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERMISSION", "Permission Manager");

define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERM_ACCESS", "Access");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERM_ACCESS_DESC", "\"access\" of a category is subject to its parent category's access permission");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERM_VIEW", "View");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERM_VIEW_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERM_SUBMIT", "Submit");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERM_SUBMIT_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERM_PUBLISH", "Publish");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERM_PUBLISH_DEC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERM_RATE", "Rate");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERM_RATE_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERM_MODERATE", "Moderate");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERM_MODERATE_DESC", "");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERMISSION_GLOBAL", "Global");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERMISSION_GLOBAL_DESC", "Module wide");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERM_SEARCH", "Search");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERM_HTML", "Use HTML");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERM_UPLOAD", "Upload");

define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERMISSION_DESC", 
	"Available category permissions: ".
	art_constant("AM_PERM_ACCESS").", ".
	art_constant("AM_PERM_VIEW").", ".
	art_constant("AM_PERM_SUBMIT").", ".
	art_constant("AM_PERM_RATE").", ".
	art_constant("AM_PERM_MODERATE")."<br />". 
	"Available global permissions: ".
	art_constant("AM_PERM_SEARCH").", ".
	art_constant("AM_PERM_HTML").", ".
	art_constant("AM_PERM_UPLOAD")
);

define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERMISSION_TEMPLATE","Set default permission template");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERMISSION_TEMPLATE_DESC","Edit the following permission template so that it can be applied to a forum or a couple of forums");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERMISSION_TEMPLATE_CREATED","Permission template has been created");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERMISSION_TEMPLATE_ERROR","Error occurs during permission template creation");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERMISSION_TEMPLATE_APPLY","Apply default permission");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERMISSION_TEMPLATE_APPLIED","Default permissions have been applied to categories");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERMISSION_ACTION","Permission management tools");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERMISSION_SETBYGROUP","Set permissions directly by group");

define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PAGENAME", "Page");

define($GLOBALS["ART_VAR_PREFIXU"]."_AM_TOPICS", "Topic Manager");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_CPTOPIC", "Topic Cpanel");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ADDTOPIC", "Add topic");

define($GLOBALS["ART_VAR_PREFIXU"]."_AM_TRACKBACKS", "Trackback Manager");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_CPTRACKBACK", "Trackback Cpanel");

define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PREFERENCES", "Module Preferences");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ON", "ON");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_OFF", "OFF");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_SAFEMODE", "safemod");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_REGISTERGLOBALS", "register_globals");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_MAGICQUOTESGPC", "magic_quotes_gpc");
//define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ZLIBCOMPRESSION", "output_compression");
//define($GLOBALS["ART_VAR_PREFIXU"]."_AM_MEMORYLIMIT", "memory_limit");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_MAXPOSTSIZE", "post_max_size");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_MAXINPUTTIME", "max_input_time");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_OUTPUTBUFFERING", "output_buffering");

define($GLOBALS["ART_VAR_PREFIXU"]."_AM_XML_EXTENSION", "xml");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_MB_EXTENSION", "mbstring");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_CURL", "curl_init");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_FSOCKOPEN", "fsockopen");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_URLFOPEN", "allow_url_fopen");

define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PATH_IMAGE", "Image path");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PATH_FILE", "File path");
//define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PATH_HTML", "HTMLs path");
//define($GLOBALS["ART_VAR_PREFIXU"]."_AM_FILE_PERMDATA", "Permission file");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_STATS", "Module Stats");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_TOTAL_CATEGORIES", "Total categories");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_TOTAL_TOPICS", "Total topics");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_TOTAL_ARTICLES", "Total articles");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_TOTAL_AUTHORS", "Total authors");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_TOTAL_VIEWS", "Total views");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_TOTAL_RATES", "Total rates");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_AVAILABLE", "Available");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_NOTAVAILABLE", "Not available");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_CREATETHEDIR", "Create Folder");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_NOTWRITABLE", "Not writable");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_SETMPERM", "Set permission");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_DIRCREATED", "The directory has been created");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_DIRNOTCREATED", "The directory can not be created");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERMSET", "The permission has been set");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_PERMNOTSET", "The permission can not be set");

define($GLOBALS["ART_VAR_PREFIXU"]."_AM_DBUPDATED", "Database updated");

define($GLOBALS["ART_VAR_PREFIXU"]."_AM_IMAGE_CAPTION", "Image caption");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_IMAGE_CURRENT", "Current image");

define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ABOUT_RELEASEDATE", "Release date");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ABOUT_AUTHOR", "Author");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ABOUT_CREDITS", "Credits");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ABOUT_LICENSE", "License");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ABOUT_WEBSITE", "Homepage");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ABOUT_MODULE_INFO", "Module info");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ABOUT_MODULE_STATUS", "Status");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ABOUT_MODULE_TEAM", "Team members");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ABOUT_AUTHOR_INFO", "Author info");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ABOUT_AUTHOR_NAME", "Author name");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ABOUT_AUTHOR_WORD", "Author's word");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ABOUT_DISCLAIMER", "Disclaimer");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ABOUT_DISCLAIMER_TEXT", "GPL-licensed");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ABOUT_CHANGELOG", "Changelog");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_ABOUT_HELP", "Help document");

define($GLOBALS["ART_VAR_PREFIXU"]."_AM_SYNC_TITLE", "Synchronization");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_SYNC_SYNCING", "Synchronization in process");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_SYNC_CATEGORY", "Category");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_SYNC_ARTICLE", "Article");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_SYNC_MISC", "MISC");
define($GLOBALS["ART_VAR_PREFIXU"]."_AM_SYNC_ITEMS", "Items for each iteration: ");

?>