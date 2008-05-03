<?php
// $Id: data.inc.php,v 1.4 2005/10/22 08:37:48 ohwada Exp $

// 2005-10-01 K.OHWADA
// category, counter

// 2005-06-20 K.OHWADA
// for PDA

//================================================================
// What's New Module
// get aritciles from module
// for news 1.1 <http://www.xoops.org/>
// 2003.12.20 K.OHWADA
//================================================================
//include_once XOOPS_ROOT_PATH."/myfunc.php";

function news_new($limit=0, $offset=0)
{
	global $xoopsDB;

//	$sql = "SELECT storyid, title, hometext, created FROM ".$xoopsDB->prefix("stories")." WHERE published>0 AND published<=".time()." ORDER BY created DESC";

	$sql = "SELECT s.storyid, s.title, s.published, s.hometext, s.nohtml, s.nosmiley, s.created, s.uid, s.counter, s.comments, t.topic_id, t.topic_title FROM ".$xoopsDB->prefix("stories")." s, ".$xoopsDB->prefix("topics")." t WHERE s.topicid=t.topic_id AND s.published>0 AND s.published<=".time()." ORDER BY s.published DESC";

	$result = $xoopsDB->query($sql, $limit, $offset);

	$URL_MOD = XOOPS_URL."/modules/news";

	$i = 0;
	$ret = array();
        $com = array();

	while($row = $xoopsDB->fetchArray($result))
	{
		$storyid = $row['storyid'];
		$ret[$i]['link']     = $URL_MOD."/article.php?storyid=".$storyid;
		$ret[$i]['pda']      = $URL_MOD."/print.php?storyid=".$storyid;
		$ret[$i]['cat_link'] = $URL_MOD."/index.php?storytopic=".$row['topic_id'];

		$ret[$i]['title'] = $row['title'];
		$ret[$i]['time']  = $row['published'];

// uid
		$ret[$i]['uid'] = $row['uid'];

// category
		$ret[$i]['cat_name'] = $row['topic_title'];

// counter
		$ret[$i]['hits'] = $row['counter'];
                
// comments by trabis
               // $com = comentarios('12',$row['storyid'],$row['comments']);//added by trabis
        
                $ret[$i]['replies'] = $row['comments'];//$com['comments']['0']['link'];
                
               
// description
		$myts =& MyTextSanitizer::getInstance();

		$html   = 1;
		$smiley = 1;
		$xcodes = 1;

		if ( $row['nohtml'] )   $html   = 0;
		if ( $row['nosmiley'] ) $smiley = 0;

		$ret[$i]['description'] = 
			$myts->makeTareaData4Show($row['hometext'], $html, $smiley, $xcodes);

		$i++;
	}

	return $ret;
}

function news_num()
{
	global $xoopsDB;

	$sql = "SELECT count(*) FROM ".$xoopsDB->prefix("stories")." WHERE published>0 AND published<=".time()." ORDER BY storyid";
	$array = $xoopsDB->fetchRow( $xoopsDB->query($sql) );
	$num   = $array[0];
	if (empty($num)) $num = 0;

	return $num;

}

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
?>
