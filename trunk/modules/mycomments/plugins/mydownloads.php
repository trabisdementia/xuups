<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

function mydownloads_useritems($uid, $limit=0, $offset=0){
	global $xoopsDB;
    $ret = array();

    $sql = "SELECT lid, title, date
    FROM ".$xoopsDB->prefix("mydownloads_downloads")."
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

function mydownloads_iteminfo($items, $limit=0, $offset=0){

    global $xoopsDB;
	$ret = array();
    $URL_MOD = XOOPS_URL."/modules/mydownloads";

    $sql = "SELECT d.lid, d.title as dtitle, d.date, d.cid, d.submitter, d.hits, t.description, c.title as ctitle
    FROM ".$xoopsDB->prefix("mydownloads_downloads")." d, ".$xoopsDB->prefix("mydownloads_text")." t, ".$xoopsDB->prefix("mydownloads_cat")." c
    WHERE d.lid IN (".implode(',',$items).")
    AND t.lid=d.lid
    AND d.cid=c.cid
    AND d.status>0
    ORDER BY d.date DESC";
    $result = $xoopsDB->query($sql, $limit, $offset);

	$i = 0;
 	while( $row = $xoopsDB->fetchArray($result) ){
 		$lid = $row['lid'];
		$ret[$i]['link']     = $URL_MOD."/singlefile.php?lid=".$lid;
		$ret[$i]['cat_link'] = $URL_MOD."/viewcat.php?cid=".$row['cid'];
		$ret[$i]['title'] = $row['dtitle'];
		$ret[$i]['time']  = $row['date'];
		$ret[$i]['id'] = $lid;
	    // uid
		$ret[$i]['uid'] = $row['submitter'];
        // category
		$ret[$i]['cat_name'] = $row['ctitle'];
        // counter
		$ret[$i]['hits'] = $row['hits'];
        // comments
        $ret[$i]['replies'] = $row['comments'];
        // description
        $myts =& MyTextSanitizer::getInstance();
        $html   = 1;
        $smiley = 1;
        $xcodes = 1;
        $ret[$i]['description'] = $myts->displayTarea($row['description'], $html, $smiley, $xcodes);
        $i++;
	}
	
	return $ret;
}

?>
