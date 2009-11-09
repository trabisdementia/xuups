<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

function xoopstube_useritems($uid, $limit=0, $offset=0){
	global $xoopsDB;
	$ret = array();
	
	$sql = "SELECT lid
    FROM " . $xoopsDB -> prefix( 'xoopstube_videos' ) . "
    WHERE submitter=" . $uid . "
    AND published > 0 AND published <= " . time() . " AND (expired = 0 OR expired > " . time() . ")
    AND offline = 0 ORDER by published DESC";
    $result = $xoopsDB->query($sql, $limit, $offset);
    
    if ( $result ) {
        while ($row = $xoopsDB->fetchArray($result)){
		  $ret[] = $row['lid'];
		}
	}
	return $ret;
}

function xoopstube_iteminfo($items, $limit=0, $offset=0)
{
	global $xoopsDB;
	$ret = array();
    $URL_MOD = XOOPS_URL."/modules/xoopstube";
    
    $sql = "SELECT v.lid, v.cid, v.submitter, v.title, v.hits, v.comments, v.published, v.expired, v.offline, c.title as cat_title, c.description
    FROM " . $xoopsDB -> prefix( 'xoopstube_videos' ) . " v, ". $xoopsDB -> prefix( 'xoopstube_cat' ) ." c
	WHERE v.lid IN (".implode(',',$items).")
    AND v.cid = c.cid
	AND v.published > 0 AND v.published <= " . time() . "
    AND (v.expired = 0 OR v.expired > " . time() . ")
	AND v.offline = 0
    ORDER by v.published DESC";
    $result = $xoopsDB->query($sql, $limit, $offset);

    $i = 0;
	while($row = $xoopsDB->fetchArray($result)){
        $lid = $row['lid'];
        $ret[$i]['link']     = $URL_MOD."/singlevideo.php?cid=".$row['cid']."&lid=".$lid;
	    $ret[$i]['cat_link'] = $URL_MOD."/viewcat.php?cid=".$row['cid'];
        $ret[$i]['title'] = $row['title'];
	    $ret[$i]['time']  = $row['published'];
        // uid
        $ret[$i]['uid'] = $row['submitter'];
        // category
        $ret[$i]['cat_name'] = $row['cat_title'];
        // counter
        $ret[$i]['hits'] = $row['hits'];
        //comments
        $ret[$i]['replies'] = $row['comments'];
        // description
        $myts =& MyTextSanitizer::getInstance();
        $html   = 1;
        $smiley = 1;
        $xcodes = 1;
        $ret[$i]['description'] = $myts->displayTarea($row['description'], $html, $smiley, $xcodes);
    }
	return $ret;
}

?>
