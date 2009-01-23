<?php
/*
 * $Id: seo.php 331 2007-12-23 16:01:11Z malanciault $
 * Module: Publisher
 * Author: Sudhaker Raj <http://xoops.biz>
 * Licence: GNU
 */

$seoOp = $_GET['seoOp'];
$seoArg = $_GET['seoArg'];

if (empty($seoOp))
{
	// SEO mode is path-info
	/*
	Sample URL for path-info
	http://localhost/modules/publisher/seo.php/item.2/can-i-turn-the-ads-off.html
	*/
	$data = explode("/",$HTTP_SERVER_VARS['PATH_INFO']);

	$seoParts = explode('.', $data[1]);
	$seoOp = $seoParts[0];
	$seoArg = $seoParts[1];
	// for multi-argument modules, where itemid and catid both are required.
	// $seoArg = substr($data[1], strlen($seoOp) + 1);
}

$seoMap = array(
	'category' => 'category.php',
	'item' => 'item.php',
	'print' => 'print.php'
);

if (! empty($seoOp) && ! empty($seoMap[$seoOp]))
{
	// module specific dispatching logic, other module must implement as
	// per their requirements.
	$newUrl = '/modules/publisher/' . $seoMap[$seoOp];

	$_ENV['PHP_SELF'] = $newUrl;
	$_SERVER['SCRIPT_NAME'] = $newUrl;
	$_SERVER['PHP_SELF'] = $newUrl;
	switch ($seoOp) {
		case 'category':
			$_SERVER['REQUEST_URI'] = $newUrl . '?categoryid=' . $seoArg;
			$_GET['categoryid'] = $seoArg;
			break;
		case 'item':
		case 'print':
		default:
			$_SERVER['REQUEST_URI'] = $newUrl . '?itemid=' . $seoArg;
			$_GET['itemid'] = $seoArg;
	}

	include( $seoMap[$seoOp]);
}

exit;

?>