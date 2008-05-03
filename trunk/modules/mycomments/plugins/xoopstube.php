<?php
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

function xoopstube_useritems_num($uid)
{
	global $xoopsDB;
	$sql = "SELECT count(*)
    FROM " . $xoopsDB -> prefix( 'xoopstube_videos' ) . "
    WHERE submitter=" . $uid . "
    AND published > 0 AND published <= " . time() . " AND (expired = 0 OR expired > " . time() . ")
    AND offline = 0";
    $array = $xoopsDB->fetchRow( $xoopsDB->query($sql) );
	$ret = $array[0];
	if (empty($ret)) $ret = 0;
	return $ret;
}

function xoopstube_iteminfo($itemid, $limit=0, $offset=0)
{
	global $xoopsDB;
	$ret = array();
    $URL_MOD = XOOPS_URL."/modules/xoopstube";
    $sql = "SELECT v.lid, v.cid, v.submitter, v.title, v.hits, v.comments, v.published, v.expired, v.offline, c.title as cat_title, c.description
    FROM " . $xoopsDB -> prefix( 'xoopstube_videos' ) . " v, ". $xoopsDB -> prefix( 'xoopstube_cat' ) ." c
	WHERE v.lid = " . $itemid . "
    AND v.cid = c.cid
	AND v.published > 0 AND v.published <= " . time() . "
    AND (v.expired = 0 OR v.expired > " . time() . ")
	AND v.offline = 0
    ORDER by v.published DESC";

    $result = $xoopsDB->query($sql, $limit, $offset);
    $row = $xoopsDB->fetchArray($result);

    $lid = $row['lid'];
    $ret['link']     = $URL_MOD."/singlevideo.php?cid=".$row['cid']."&lid=".$lid;
	$ret['cat_link'] = $URL_MOD."/viewcat.php?cid=".$row['cid'];
    $ret['title'] = $row['title'];
	$ret['time']  = $row['published'];
// uid
    $ret['uid'] = $row['submitter'];
// category
    $ret['cat_name'] = $row['cat_title'];
// counter
    $ret['hits'] = $row['hits'];
//comments
    $ret['replies'] = $row['comments'];
// description
    $myts =& MyTextSanitizer::getInstance();
    $ret['description'] = $myts->makeTareaData4Show($row['description'], 1, 1, 1);

	return $ret;
}

?>
