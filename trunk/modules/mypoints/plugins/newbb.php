<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

function newbb_useritems_count($uid, $since)
{
    global $xoopsDB;
	list($ret) = $xoopsDB->fetchRow($xoopsDB->query("SELECT  COUNT(*)  FROM ".$xoopsDB->prefix("bb_posts")." WHERE uid='$uid' AND post_time > '$since'"));
	return $ret;
}
?>
