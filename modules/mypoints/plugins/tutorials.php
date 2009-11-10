<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

function tutorials_useritems_count($uid, $since)
{
    global $xoopsDB;
	list($ret) = $xoopsDB->fetchRow($xoopsDB->query("SELECT  COUNT(*)  FROM ".$xoopsDB->prefix("tutorials")." WHERE (submitter ='$uid' AND date > '$since')  AND status > '0'"));
	return $ret;
}

function tutorials_uservotes_count($uid, $since)
{
    global $xoopsDB;
    list($ret) = $xoopsDB->fetchRow($xoopsDB->query("SELECT  COUNT(*)  FROM ".$xoopsDB->prefix("tutorials_votedata")." WHERE ratinguser ='$uid' AND ratingtimestamp > '$since'"));
	return $ret;
}
?>
