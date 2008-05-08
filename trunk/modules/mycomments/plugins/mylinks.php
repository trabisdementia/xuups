<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

function mylinks_useritems($uid, $limit=0, $offset=0){
    global $xoopsDB;
	$ret = array();

	$sql = "SELECT lid, title, date
    FROM ".$xoopsDB->prefix("mylinks_links")."
    WHERE submitter=" . $uid . "
    AND status>0
    ORDER BY lid";
	$result = $xoopsDB->query($sql,$limit,$offset);

    if ( $result ) {
        while ($row = $xoopsDB->fetchArray($result)){
		  $ret[] = $row['lid'];
		}
	}

	return $ret;
}

function mylinks_iteminfo($items, $limit=0, $offset=0){

    global $xoopsDB;
	$ret = array();
    $URL_MOD = XOOPS_URL."/modules/mylinks";

	$sql = "SELECT l.lid, l.title as ltitle, l.date, l.cid, l.submitter, l.hits, l.comments, t.description, c.title as ctitle
    FROM ".$xoopsDB->prefix("mylinks_links")." l, ".$xoopsDB->prefix("mylinks_text")." t, ".$xoopsDB->prefix("mylinks_cat")." c
    WHERE l.lid IN (".implode(',',$items).")
    AND t.lid=l.lid
    AND l.cid=c.cid
    AND l.status>0
    ORDER BY l.date DESC";
	$result = $xoopsDB->query($sql,$limit,$offset);

	$i = 0;
 	while($row = $xoopsDB->fetchArray($result)){
		$ret[$i]['link']     = $URL_MOD."/singlelink.php?lid=".$row['lid'];
		$ret[$i]['cat_link'] = $URL_MOD."/viewcat.php?cid=".$row['cid'];
		$ret[$i]['title'] = $row['ltitle'];
		$ret[$i]['time']  = $row['date'];
		$ret[$i]['id'] = $row['lid'];
        //uid
		$ret[$i]['uid'] = $row['submitter'];
        // category
		$ret[$i]['cat_name'] = $row['ctitle'];
        // counter
		$ret[$i]['hits'] = $row['hits'];
        // comments
        $ret[$i]['replies'] = $row['comments'];
        // description
        $myts =& MyTextSanitizer::getInstance();
        $method = method_exists($myts,'displayTarea')?'displayTarea':'makeTareaData4Show';
        $html   = 1;
        $smiley = 1;
        $xcodes = 1;
        $ret[$i]['description'] = $myts->$method($row['description'], $html, $smiley, $xcodes);
        $i++;
	}
	return $ret;
}

?>
