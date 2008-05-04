<?php
function news_useritems($uid, $limit=0, $offset=0)
{
	global $xoopsDB;
	$ret = array();

    $sql = "SELECT storyid FROM ".$xoopsDB->prefix("stories")." WHERE published>0 AND published<=".time()." AND uid=".$uid;
	$result = $xoopsDB->query($sql, $limit, $offset);
    if ( $result ) {
        while ($row = $xoopsDB->fetchArray($result)){
		  $ret[] = $row['storyid'];
		}
	}
	return $ret;
}

function news_iteminfo($itemid, $limit=0, $offset=0)
{
	global $xoopsDB;
    $ret = array();
    $URL_MOD = XOOPS_URL."/modules/news";

    $sql = "SELECT s.storyid, s.title, s.published, s.hometext, s.nohtml, s.nosmiley, s.created, s.uid, s.counter, s.comments, t.topic_id, t.topic_title FROM ".$xoopsDB->prefix("stories")." s, ".$xoopsDB->prefix("topics")." t WHERE s.topicid=t.topic_id AND s.storyid=".$itemid." AND s.published>0 AND s.published<=".time()." ORDER BY s.published DESC";
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
    $html   = 1;
    $smiley = 1;
    $xcodes = 1;
    if ( $row['nohtml'] )   $html   = 0;
    if ( $row['nosmiley'] ) $smiley = 0;
    $ret['description'] = $myts->makeTareaData4Show($row['hometext'], $html, $smiley, $xcodes);

	return $ret;
}

?>
