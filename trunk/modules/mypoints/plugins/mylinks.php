<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

function mylinks_useritems_count($uid, $since)
{
    global $xoopsDB;
	list($ret) = $xoopsDB->fetchRow($xoopsDB->query("SELECT  COUNT(*)  FROM ".$xoopsDB->prefix("mylinks_links")." WHERE (submitter ='$uid' AND date > '$since')  AND status > '0'"));
	return $ret;
}

function mylinks_uservotes_count($uid, $since)
{
    global $xoopsDB;
    list($ret) = $xoopsDB->fetchRow($xoopsDB->query("SELECT  COUNT(*)  FROM ".$xoopsDB->prefix("mylinks_votedata")." WHERE ratinguser ='$uid' AND ratingtimestamp > '$since'"));
	return $ret;
}
?>
