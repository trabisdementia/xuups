<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

function news_useritems_count($uid, $since)
{
    global $xoopsDB;
	list($ret) = $xoopsDB->fetchRow($xoopsDB->query("SELECT  COUNT(*)  FROM ".$xoopsDB->prefix("stories")." WHERE (uid='$uid' AND published > '$since')"));
	return $ret;
}

function news_uservotes_count($uid, $since)
{
    global $xoopsDB;
    list($ret) = $xoopsDB->fetchRow($xoopsDB->query("SELECT  COUNT(*)  FROM ".$xoopsDB->prefix("stories_votedata")." WHERE ratinguser ='$uid' AND ratingtimestamp > '$since'"));
	return $ret;
}
?>
