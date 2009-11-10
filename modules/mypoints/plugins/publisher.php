<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

function publisher_useritems_count($uid, $since)
{
    global $xoopsDB;
	list($ret) = $xoopsDB->fetchRow($xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix("publisher_items") . " WHERE uid='{$uid}' AND datesub > '$since' AND status = 2"));
	return $ret;
}
?>
