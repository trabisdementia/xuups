<?php

/**
* $Id: backend.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

include_once("header.php");

include_once XOOPS_ROOT_PATH.'/class/template.php';
if (function_exists('mb_http_output')) {
	mb_http_output('pass');
}

$categoryid = isset($_GET['categoryid']) ? $_GET['categoryid'] : -1 ;

if ($categoryid != -1) {
	$categoryObj = $publisher_category_handler->get($categoryid);
}

header ('Content-Type:text/xml; charset=utf-8');
$tpl = new XoopsTpl();
$tpl->xoops_setCaching(2);
$tpl->xoops_setCacheTime(0);
$myts = MyTextSanitizer::getInstance();
if (!$tpl->is_cached('db:publisher_rss.html')) {
	$channel_category =  $xoopsModule->name();
	// Check if ML Hack is installed, and if yes, parse the $content in formatForML
	if (method_exists($myts, 'formatForML')) {
		$xoopsConfig['sitename'] = $myts->formatForML($xoopsConfig['sitename']);
		$xoopsConfig['slogan'] = $myts->formatForML($xoopsConfig['slogan']);
		$channel_category =  $myts->formatForML($channel_category);
	}
	$tpl->assign('channel_title', xoops_utf8_encode(htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)));
	$tpl->assign('channel_link', PUBLISHER_URL);
	$tpl->assign('channel_desc', xoops_utf8_encode(htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES)));
	$tpl->assign('channel_lastbuild', formatTimestamp(time(), 'rss'));
	$tpl->assign('channel_webmaster', $xoopsConfig['adminmail']);
	$tpl->assign('channel_editor', $xoopsConfig['adminmail']);

	if ($categoryid != -1) {
		$channel_category .= " > " . $categoryObj->name();
	}

	$tpl->assign('channel_category', xoops_utf8_encode(htmlspecialchars($channel_category)));
	$tpl->assign('channel_generator', 'Publisher');
	$tpl->assign('channel_language', _LANGCODE);
	$tpl->assign('image_url', XOOPS_URL.'/images/logo.gif');
	$dimention = getimagesize(XOOPS_ROOT_PATH.'/images/logo.gif');
	if (empty($dimention[0])) {
		$width = 140;
		$height = 140;
	} else {
		$width = ($dimention[0] > 140) ? 140 : $dimention[0];
		$dimention[1] = $dimention[1] * $width / $dimention[0];
		$height = ($dimention[1] > 140) ? $dimention[1] * $dimention[0] / 140 : $dimention[1];
	}
	$tpl->assign('image_width', $width);
	$tpl->assign('image_height', $height);
	$sarray = $publisher_item_handler->getAllPublished(10,0,$categoryid);
	if (is_array($sarray)) {

		$count = $sarray;
		foreach ($sarray as $item) {
			$tpl->append('items',
			      array('title' => xoops_utf8_encode(htmlspecialchars($item->title(), ENT_QUOTES)),
			            'link' => $item->getItemUrl(),
			            'guid' => $item->getItemUrl(),
			            'pubdate' => formatTimestamp($item->getVar('datesub'), 'rss'),
			            'description' => xoops_utf8_encode(htmlspecialchars($item->summary(), ENT_QUOTES))));
		}
	}
}
$tpl->display('db:publisher_rss.html');
?>