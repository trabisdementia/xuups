<?php
// $Id: blocks.php,v 1.1.1.1 2005/11/10 19:51:18 phppp Exp $
// _LANGCODE: zh-CN
// _CHARSET : gb2312
// Translator: A.D.Horse, http://www.tv-io.com

if (!defined('XOOPS_ROOT_PATH')){ exit(); }

$current_path = __FILE__;
if ( DIRECTORY_SEPARATOR != "/" ) $current_path = str_replace( strpos( $current_path, "\\\\", 2 ) ? "\\\\" : DIRECTORY_SEPARATOR, "/", $current_path);
$url_arr = explode("/",strstr($current_path,"/modules/"));
include XOOPS_ROOT_PATH."/modules/".$url_arr[2]."/include/vars.php";

if(defined($GLOBALS["ART_VAR_PREFIXU"]."_LANG_GB_BLOCKS")) return; 
define($GLOBALS["ART_VAR_PREFIXU"]."_LANG_GB_BLOCKS",1);

define($GLOBALS["ART_VAR_PREFIXU"]."_MB_TYPE", "����");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_TYPE_TIME", "����ʱ��");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_TYPE_VIEWS", "�Ķ�����");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_TYPE_RATES", "���ִ���");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_TYPE_RATING", "ƽ���÷�");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_TYPE_RANDOM", "���");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_ITEMS", "��Ŀ����");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_TITLE_LENGTH", "���ⳤ��");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_TIMEFORMAT", "ʱ���ʽ");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_TIMEFORMAT_CUSTOM", "����");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_SHOWSUMMARY", "��ʾժҪ");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_SUMMARY_IMAGE", "ժҪ��ͼƬ");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_CATEGORYLIST", "����ķ���");

define($GLOBALS["ART_VAR_PREFIXU"]."_MB_AUTHOR", "����");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_TIME", "ʱ��");

define($GLOBALS["ART_VAR_PREFIXU"]."_MB_SPECIFIED_ONLY", "ֻ��ʾ��ע������");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_SHOW_NOTE", "��ʾ���߰�");

define($GLOBALS["ART_VAR_PREFIXU"]."_MB_CATEGORIES", "����");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_ARTICLES", "����");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_COMMENTS", "����");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_VIEWS", "�Ķ�");
define($GLOBALS["ART_VAR_PREFIXU"]."_MB_DISPLAY_MODE", "��ʾģʽ ( 0 - ���б�; ���� - ��������ʾ, ����Ϊ���� )");
?>