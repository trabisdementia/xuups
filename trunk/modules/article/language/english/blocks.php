<?php
// $Id: blocks.php,v 1.1.1.1 2005/11/10 19:51:18 phppp Exp $
// _LANGCODE: en
// _CHARSET : ISO-8859-1
// Translator: D.J., http://xoopsforge.com, http://xoops.org.cn

if (!defined('XOOPS_ROOT_PATH')){ exit(); }

$current_path = __FILE__;
if ( DIRECTORY_SEPARATOR != "/" ) $current_path = str_replace( strpos( $current_path, "\\\\", 2 ) ? "\\\\" : DIRECTORY_SEPARATOR, "/", $current_path);
$url_arr = explode("/",strstr($current_path,"/modules/"));
include XOOPS_ROOT_PATH."/modules/".$url_arr[2]."/include/vars.php";

if(defined($GLOBALS["ART_VAR_PREFIXU"]."_LANG_EN_BLOCKS")) return; 
define($GLOBALS["ART_VAR_PREFIXU"]."_LANG_EN_BLOCKS",1);

define($GLOBALS["ART_VAR_PREFIXU"]."_MB_TYPE", "Type");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_TYPE_TIME", "Publish time");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_TYPE_VIEWS", "Views");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_TYPE_RATES", "Rate times");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_TYPE_RATING", "Rating");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_TYPE_RANDOM", "Random");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_ITEMS", "Item count");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_TITLE_LENGTH", "Title length");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_TIMEFORMAT", "Time format");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_TIMEFORMAT_CUSTOM", "Custom");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_SHOWSUMMARY", "Show summary");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_SUMMARY_IMAGE", "Summary and image");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_CATEGORYLIST", "Allowed categories");

define($GLOBALS["ART_VAR_PREFIXU"]."_MB_AUTHOR", "Author");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_TIME", "Time");

define($GLOBALS["ART_VAR_PREFIXU"]."_MB_SPECIFIED_ONLY", "Only display specified article");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_SHOW_NOTE", "Display editor's note if available");

define($GLOBALS["ART_VAR_PREFIXU"]."_MB_CATEGORIES", "Categories");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_ARTICLES", "Articles");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_COMMENTS", "Comments");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_VIEWS", "Views");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_DISPLAY_MODE", "Display mode ( 0 - compact list; Otherwise -column number for categories )");
?>