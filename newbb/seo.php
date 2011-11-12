<?php
/*
 * $Id$
 * Module: newbbss
 * Author: Sudhaker Raj <http://xoops.biz>
 * Licence: GNU
 */

$seoOp = $_GET['seoOp'];
$seoArg = $_GET['seoArg'];
$seoOther = $_GET['seoOther'];

$seos=array('c','f','t','p','rc','rf','v');

$seoMap = array(
	'c'     => 'index.php',
	'f'     => 'viewforum.php',
	't'     => 'viewtopic.php',
    'p'     => 'viewtopic.php',
    'rc'    => 'rss.php',
    'rf'    => 'rss.php'
);

if (! empty($seoOp) && ! empty($seoMap[$seoOp]) && in_array($seoOp,$seos))
{
	// module specific dispatching logic, other module must implement as
	// per their requirements.
	$newUrl = '/modules/newbb/' . $seoMap[$seoOp];
	$_ENV['PHP_SELF'] = $newUrl;
	$_SERVER['SCRIPT_NAME'] = $newUrl;
	$_SERVER['PHP_SELF'] = $newUrl;
	switch ($seoOp) {
		case 'c':
			$_SERVER['REQUEST_URI'] = $newUrl . '?cat=' . $seoArg;
			$_GET['cat'] = $seoArg;
			break;
		case 'f':
			$_SERVER['REQUEST_URI'] = $newUrl . '?forum=' . $seoArg;
			$_GET['forum'] = $seoArg;            
			break;
        case 'p':
			$_SERVER['REQUEST_URI'] = $newUrl . '?post_id=' . $seoArg;
			$_GET['post_id'] = $seoArg;
            break;
        case 'rc':
			$_SERVER['REQUEST_URI'] = $newUrl . '?c=' . $seoArg;
			$_GET['c'] = $seoArg;
            break;
        case 'rf':
			$_SERVER['REQUEST_URI'] = $newUrl . '?f=' . $seoArg;
			$_GET['f'] = $seoArg;
            break;
        default:        
		case 't':		
			$_SERVER['REQUEST_URI'] = $newUrl . '?topic_id=' . $seoArg;
			$_GET['topic_id'] = $seoArg;
            break;
	}
    include( $seoMap[$seoOp]);
} else {
    $last = $seoOp ."/". $seoArg ;
    if ($seoOther!='') $last .= "/". $seoOther;
    include $last;
}
exit();
?>