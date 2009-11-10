<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

function xoopstube_useritems_count($uid, $since)
{
    global $xoopsDB;
	list($ret) = $xoopsDB->fetchRow($xoopsDB->query("SELECT  COUNT(*)  FROM ".$xoopsDB->prefix("xoopstube_videos")." WHERE (submitter ='$uid' AND date > '$since') AND status > '0'"));
    return $ret;
}

function xoopstube_uservotes_count($uid, $since)
{
    global $xoopsDB;
    list($ret) = $xoopsDB->fetchRow($xoopsDB->query("SELECT  COUNT(*)  FROM ".$xoopsDB->prefix("xoopstube_votedata")." WHERE ratinguser ='$uid' AND ratingtimestamp > '$since'"));
    return $ret;
}
?>
