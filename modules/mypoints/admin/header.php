<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/include/cp_header.php';
include_once dirname(__FILE__) . '/functions.php';
include_once dirname(dirname(__FILE__)) . '/include/functions.php';


if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
	include_once XOOPS_ROOT_PATH . '/class/template.php';
	$xoopsTpl = new XoopsTpl();
}
?>
