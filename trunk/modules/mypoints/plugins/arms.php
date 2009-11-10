<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

function arms_useritems_count($uid, $since)
{
    global $xoopsDB;
	list($ret) = $xoopsDB->fetchRow($xoopsDB->query("SELECT  COUNT(*)  FROM ".$xoopsDB->prefix("arms_pages")." WHERE uid ='$uid' AND page_posttime > '$since'"));
	return $ret;
}

function arms_uservotes_count($uid, $since)
{
    global $xoopsDB;
    list($ret) = $xoopsDB->fetchRow($xoopsDB->query("SELECT  COUNT(*)  FROM ".$xoopsDB->prefix("arms_votelog")." WHERE uid ='$uid' AND vote_time > '$since'"));
	return $ret;
}
?>
