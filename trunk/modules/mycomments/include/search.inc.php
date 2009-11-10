<?php
//  Author: Trabis, Kaper
//  URL: http://www.xuups.com, http://kaper.zk-p.pl
//  E-Mail: lusopoemas@gmail.com , kaper@zk-p.pl

function mycomments_search($queryarray, $andor, $limit, $offset, $userid){
	global $xoopsDB;
	$sql = "SELECT com_id, com_pid, com_rootid, com_modid, com_itemid, com_created, com_uid, com_title, com_text, com_status FROM ".$xoopsDB->prefix("xoopscomments")." WHERE com_id>0 ";
	if ( $userid != 0 ) {
		$sql .= " AND com_uid=".$userid." ";
	}
	// because count() returns 1 even if a supplied variable
	// is not an array, we must check if $querryarray is really an array
	if ( is_array($queryarray) && $count = count($queryarray) ) {
		$sql .= " AND ((com_title LIKE '%$queryarray[0]%' OR com_text LIKE '%$queryarray[0]%')";
		for($i=1;$i<$count;$i++){
			$sql .= " $andor ";
			$sql .= "(com_title LIKE '%$queryarray[$i]%' OR com_text LIKE '%$queryarray[$i]%')";
		}
		$sql .= ") ";
	}
	$sql .= "ORDER BY com_created DESC";
	$result = $xoopsDB->query($sql,$limit,$offset);

	$module_handler =& xoops_gethandler('module');
	$modules =& $module_handler->getObjects(new Criteria('hascomments', 1), true);

	$ret = array();
	$i = 0;
 	while($myrow = $xoopsDB->fetchArray($result)){

		$com_id = $myrow['com_id'];
		$com_modid=$myrow['com_modid'];
		$com_pid=$myrow['com_pid'];
		$com_rootid=$myrow['com_rootid'];
		$com_itemid=$myrow['com_itemid'];

		$comment_config = array();
		$comment_config = $modules[$com_modid]->getInfo('comments'); 
		
		$link = "../".$modules[$com_modid]->getVar('dirname').'/';
		$link .= $comment_config['pageName'].'?';
		$link .= $comment_config['itemName'].'=';
		$link .= $com_itemid.'&amp;com_id='.$com_id.'&amp;com_rootid='.$com_rootid;
		$link .= '&amp;com_mode=thread&amp;#comment'.$com_id;
		
		$ret[$i]['image'] = "images/img.gif";
		$ret[$i]['link'] = $link;
		$ret[$i]['title'] = $myrow['com_title'];
		$ret[$i]['time'] = $myrow['com_created'];
		$ret[$i]['uid'] = $myrow['com_uid'];
		$i++;
	}
	return $ret;
}

?>
