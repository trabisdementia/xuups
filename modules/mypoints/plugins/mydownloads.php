<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

function mydownloads_useritems_count($uid, $since)
{
    global $xoopsDB;
	list($ret) = $xoopsDB->fetchRow($xoopsDB->query("SELECT  COUNT(*)  FROM ".$xoopsDB->prefix("mydownloads_downloads")." WHERE (submitter ='$uid' AND date > '$since') AND status > '0'"));
	return $ret;
}

function mydownloads_uservotes_count($uid, $since)
{
    global $xoopsDB;
    list($ret) = $xoopsDB->fetchRow($xoopsDB->query("SELECT  COUNT(*)  FROM ".$xoopsDB->prefix("mydownloads_votedata")." WHERE ratinguser ='$uid' AND ratingtimestamp > '$since'"));
	return $ret;
}
?>
