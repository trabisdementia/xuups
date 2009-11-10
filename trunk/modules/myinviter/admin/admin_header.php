<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

include_once dirname(dirname(dirname(dirname(__FILE__)))) .'/include/cp_header.php';
include_once dirname(dirname(__FILE__)) . '/include/functions.php';

$xoopsModuleConfig =& myinviter_getModuleConfig(); //must come first
$xoopsModule =& myinviter_getModuleHandler();

$myts =& MyTextSanitizer::getInstance();

if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
	include_once XOOPS_ROOT_PATH . '/class/template.php';
	$xoopsTpl = new XoopsTpl();
}

xoops_loadLanguage('admin', 'myinviter');
xoops_loadLanguage('modinfo', 'myinviter');

?>
