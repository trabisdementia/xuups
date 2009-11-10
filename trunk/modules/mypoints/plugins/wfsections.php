<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

function wfsections_useritems_count($uid, $since)
{
    global $xoopsDB;
	list($ret) = $xoopsDB->fetchRow($xoopsDB->query("SELECT  COUNT(*)  FROM ".$xoopsDB->prefix("wfs_article")." WHERE uid ='$uid' AND (published > 0 AND published <= '$since') AND noshowart = 0 AND offline = '0'" ));
	return $ret;
}

function wfsections_uservotes_count($uid, $since)
{
    global $xoopsDB;
    list($ret) = $xoopsDB->fetchRow($xoopsDB->query("SELECT  COUNT(*)  FROM ".$xoopsDB->prefix("wfs_votedata")." WHERE ratinguser ='$uid' AND ratingtimestamp > '$since'"));
	return $ret;
}
?>
