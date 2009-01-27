<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

require_once '../../../include/cp_header.php';
include_once 'admin_functions.php';
include_once '../include/functions.php';
include_once '../../../class/xoopsformloader.php';
include_once '../../../class/template.php';

if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
	include_once(XOOPS_ROOT_PATH."/class/template.php");
	$xoopsTpl = new XoopsTpl();
}
?>
