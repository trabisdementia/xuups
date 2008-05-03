<?php
function publisher_useritems($uid, $limit=0, $offset=0)
{
    global $xoopsDB;
	$ret = array();

    $sql = "SELECT storyid FROM ".$xoopsDB->prefix("publisher_stories")." WHERE published>0 AND published<=".time()." AND uid=".$uid;
    $result = $xoopsDB->query($sql, $limit, $offset);
	if ( $result ) {
        while ($row = $xoopsDB->fetchArray($result)){
		  $ret[] = $row['storyid'];
		}
	}
	return $ret;
}

function publisher_useritems_num($uid)
{
	global $xoopsDB;

	$sql = "SELECT count(*) FROM ".$xoopsDB->prefix("publisher_stories")." WHERE published>0 AND published<=".time()." AND uid=".$uid;
	$array = $xoopsDB->fetchRow( $xoopsDB->query($sql) );
	$ret = $array[0];
	if (empty($ret)) $ret = 0;

	return $ret;

}

function publisher_iteminfo($itemid, $limit=0, $offset=0)
{
	global $xoopsDB;
	$ret = array();
    $URL_MOD = XOOPS_URL."/modules/publisher";

    $sql = "SELECT s.storyid, s.title, s.published, s.bodytext, s.uid, s.counter, s.comments, t.topic_id, t.topic_title FROM ".$xoopsDB->prefix("publisher_stories")." s, ".$xoopsDB->prefix("publisher_topics")." t WHERE s.topicid=t.topic_id AND s.storyid=".$itemid." AND s.published>0 AND s.published<=".time()." ORDER BY s.published DESC";
	$result = $xoopsDB->query($sql, $limit, $offset);
    $row = $xoopsDB->fetchArray($result);

    $storyid = $row['storyid'];
    $ret['link']     = $URL_MOD."/article.php?storyid=".$storyid;
	$ret['pda']      = $URL_MOD."/print.php?storyid=".$storyid;
	$ret['cat_link'] = $URL_MOD."/index.php?storytopic=".$row['topic_id'];
    $ret['title'] = $row['title'];
	$ret['time']  = $row['published'];
// uid
    $ret['uid'] = $row['uid'];
// category
    $ret['cat_name'] = $row['topic_title'];
// counter
    $ret['hits'] = $row['counter'];
//comments
    $ret['replies'] = $row['comments'];
// description
    $myts =& MyTextSanitizer::getInstance();
    $ret['description'] = $myts->makeTareaData4Show($row['hometext'], 1, 1, 1);

	return $ret;
}


/*
function news_data($limit=0, $offset=0)
{
	global $xoopsDB;

	$sql = "SELECT storyid, title, created FROM ".$xoopsDB->prefix("stories")." WHERE published>0 AND published<=".time()." ORDER BY storyid";
	$result = $xoopsDB->query($sql,$limit,$offset);

	$i = 0;
	$ret = array();

	while($row = $xoopsDB->fetchArray($result))
	{
	    $id = $row['storyid'];
	    $ret[$i]['id']    = $id;
		$ret[$i]['link'] = XOOPS_URL."/modules/news/article.php?storyid=".$id."";
		$ret[$i]['title'] = $row['title'];
		$ret[$i]['time']  = $row['created'];
		$i++;
	}

	return $ret;
}
*/
?>
