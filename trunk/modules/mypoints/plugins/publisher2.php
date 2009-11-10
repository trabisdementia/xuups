<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

function publisher2_useritems_count($uid, $since)
{
    global $xoopsDB;
	list($ret) = $xoopsDB->fetchRow($xoopsDB->query("SELECT  COUNT(*)  FROM ".$xoopsDB->prefix("publisher2_stories")." WHERE (uid='$uid' AND published > '$since')"));
	return $ret;
}
?>
