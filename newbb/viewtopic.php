<?php
// $Id$
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
//  Author: phppp (D.J., infomax@gmail.com)                                  //
//  URL: http://xoopsforge.com, http://xoops.org.cn                          //
//  Project: Article Project                                                 //
//  ------------------------------------------------------------------------ //
include 'header.php';
mod_loadFunctions("read", "newbb");
mod_loadFunctions("render", "newbb");
// To enable image auto-resize by js
// $xoops_module_header .= '<script src="'.XOOPS_URL.'/Frameworks/textsanitizer/xoops.js" type="text/javascript"></script>';

/*
 * Build the page query
 */
$query_vars = array("post_id", "topic_id", "status", "order", "start", "move", "mode");
$query_array = array();
foreach ($query_vars as $var) {
	if (!empty($_GET[$var])) $query_array[$var] = "{$var}={$_GET[$var]}";
}
$page_query = htmlspecialchars(implode("&", array_values($query_array)));
unset($query_array);

$topic_id = isset($_GET['topic_id']) ? intval($_GET['topic_id']) : 0;
$post_id = !empty($_GET['post_id']) ? intval($_GET['post_id']) : 0;
$forum_id = !empty($_GET['forum']) ? intval($_GET['forum']) : 0;
$move = isset($_GET['move'])? strtolower($_GET['move']) : '';
$start = !empty($_GET['start']) ? intval($_GET['start']) : 0;
$status = (!empty($_GET['status']) && in_array($_GET['status'], array("active", "pending", "deleted"))) ? $_GET['status'] : "";
$mode = !empty($_GET['mode']) ? intval($_GET['mode']) : (!empty($status) ? 2 : 0);
$read = (!empty($_GET['read']) && in_array($_GET['read'], array("new"))) ? $_GET['read'] : "";
$order = (!empty($_GET['order']) && in_array($_GET['order'], array("ASC","DESC"))) ? $_GET['order'] : "";
if ($order=="") {
    if ($xoopsUser) 
    {
        $order = ($xoopsUser->getVar('uorder')==1) ? 'DESC' : 'ASC';    
    }
    else
    {
        $order = ($xoopsConfig['com_order']==1) ? 'DESC' : 'ASC';
    
    }    
}

if ( !$topic_id && !$post_id ) {
  $redirect = empty($forum_id) ? "index.php" : "viewforum.php?forum={$forum_id}";  
  redirect_header($redirect, 2, _MD_ERRORTOPIC);
}
$topic_handler =& xoops_getmodulehandler('topic', 'newbb');
if ( !empty($post_id) ) {
    $topic_obj =& $topic_handler->getByPost($post_id);
} elseif (!empty($move)) {
    $topic_obj =& $topic_handler->getByMove($topic_id, ($move == "prev") ? -1 : 1, $forum_id);
    $topic_id = $topic_obj->getVar("topic_id");
} else {
    $topic_obj =& $topic_handler->get($topic_id);
}
if ( !is_object($topic_obj) || !$topic_id = $topic_obj->getVar('topic_id') ) {
	$redirect = empty($forum_id) ? "index.php" : "viewforum.php?forum={$forum_id}";
    redirect_header($redirect, 2, _MD_ERRORTOPIC);
}
$forum_id = $topic_obj->getVar('forum_id');
$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
$forum_obj =& $forum_handler->get($forum_id);

$isadmin = newbb_isAdmin($forum_obj);

if ( !$isadmin && $topic_obj->getVar('approved') < 0 ) {
    redirect_header("viewforum.php?forum=".$forum_id, 2, _MD_NORIGHTTOVIEW);
    exit();
}
if (!$forum_handler->getPermission($forum_obj)) {
    redirect_header("index.php", 2, _MD_NORIGHTTOACCESS);
    exit();
}
/* Only admin has access to admin mode */
if (!$isadmin) {
	$status = "";
	$mode = 0;
}

if (!$topic_handler->getPermission($forum_obj, $topic_obj->getVar('topic_status'), "view")) {
    redirect_header("viewforum.php?forum=".$forum_id, 2, _MD_NORIGHTTOVIEW);
    exit();
}

$karma_handler =& xoops_getmodulehandler('karma', 'newbb');
$user_karma = $karma_handler->getUserKarma();
//$viewmode = "flat";             

$total_posts = $topic_handler->getPostCount($topic_obj, $status);
$xoopsOption['template_main'] =  'newbb_viewtopic.html';
$postsArray = $topic_handler->getAllPosts($topic_obj, $order, $xoopsModuleConfig['posts_per_page'], $start, $post_id, $status);


$topic_obj->incrementCounter();
newbb_setRead("topic", $topic_id, $topic_obj->getVar("topic_last_post_id"));

if (!empty($xoopsModuleConfig['rss_enable'])) {
	$xoops_module_header .= '<link rel="alternate" type="application/rss+xml" title="'.$xoopsModule->getVar('name').'-'.$forum_obj->getVar('forum_name').'" href="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/rss.php?f='.$forum_obj->getVar("forum_id").'" />';
}

$xoopsOption['xoops_module_header']= $xoops_module_header;
include XOOPS_ROOT_PATH."/header.php";
$xoopsTpl->assign('xoops_module_header', $xoops_module_header);

if ($xoopsModuleConfig['wol_enabled']) {
	$online_handler =& xoops_getmodulehandler('online', 'newbb');
	$online_handler->init($forum_obj, $topic_obj);
    $xoopsTpl->assign('online', $online_handler->show_online());
}

$infobox = intval($xoopsModuleConfig['show_infobox']); //4.05
$xoopsTpl->assign('infobox', $infobox); //4.05

$xoopsTpl->assign("parentforum", $forum_handler->getParents($forum_obj));
$xoopsTpl->assign("icon_path", XOOPS_URL."/modules/".$xoopsModule->getVar("dirname", "n")."/templates/images/icon/");

$xoopsTpl->assign(array(
	'topic_title' 		=> '<a href="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar("dirname", "n").'/viewtopic.php?topic_id='.$topic_id.'">'. $topic_obj->getFullTitle().'</a>', 
	'forum_name' 		=> $forum_obj->getVar('forum_name'), 
	'lang_nexttopic' 	=> _MD_NEXTTOPIC, 
	'lang_prevtopic' 	=> _MD_PREVTOPIC,
    'topic_status'      => $topic_obj->getVar('topic_status')
	));

$category_handler =& xoops_getmodulehandler("category");
$category_obj =& $category_handler->get($forum_obj->getVar("cat_id"), array("cat_title"));
$xoopsTpl->assign('category', array("id" => $forum_obj->getVar("cat_id"), "title" => $category_obj->getVar('cat_title')));

$xoopsTpl->assign('post_id', $post_id);
$xoopsTpl->assign('topic_id', $topic_id);
$xoopsTpl->assign('forum_id', $forum_id);

$order_current = ($order == 'DESC') ? 'DESC' : 'ASC';
$xoopsTpl->assign('order_current', $order_current);

$t_new = newbb_displayImage('t_new', _MD_POSTNEW);
$t_reply = newbb_displayImage('t_reply', _MD_REPLY);

if ($topic_handler->getPermission($forum_obj, $topic_obj->getVar('topic_status'), "post")) {
    $xoopsTpl->assign('forum_post_or_register', "<a href=\"newtopic.php?forum=".$forum_id."\">".$t_new."</a>");
} elseif ( !empty($GLOBALS["xoopsModuleConfig"]["show_reg"]) ) {
    if ($topic_obj->getVar('topic_status')) {
    	$xoopsTpl->assign('forum_post_or_register', _MD_TOPICLOCKED);
    } elseif ( !is_object($xoopsUser)) {
    	$xoopsTpl->assign('forum_post_or_register', '<a href="'.XOOPS_URL.'/user.php?xoops_redirect='.htmlspecialchars($xoopsRequestUri).'">'._MD_REGTOPOST.'</a>');
	}
} else {
    $xoopsTpl->assign('forum_post_or_register', '');
}
if ($topic_handler->getPermission($forum_obj, $topic_obj->getVar('topic_status'), "reply")) {
    $xoopsTpl->assign('forum_reply', "<a href=\"reply.php?topic_id=".$topic_id."\">".$t_reply."</a>");
}

$poster_array = array();
$require_reply = false;
foreach ($postsArray as $eachpost) {
	if ($eachpost->getVar('uid') > 0) $poster_array[$eachpost->getVar('uid')] = 1;
	if ($eachpost->getVar('require_reply') > 0) $require_reply = true;
}

$userid_array=array();
$online = array();
if (count($poster_array)>0) {
	$member_handler =& xoops_gethandler('member');
	$userid_array = array_keys($poster_array);
	$user_criteria = "(".implode(",",$userid_array).")";
	$users = $member_handler->getUsers( new Criteria('uid', $user_criteria, 'IN'), true);
} else {
	$users = array();
}


$viewtopic_users = array();
if (count($userid_array) > 0) {
	require_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname", "n")."/class/user.php";
	$user_handler = new NewbbUserHandler($xoopsModuleConfig['groupbar_enabled'], $xoopsModuleConfig['wol_enabled']);
	$user_handler->users = $users;
	$user_handler->online = $online;
	$viewtopic_users = $user_handler->getUsers();
}
unset($users);

if ($xoopsModuleConfig['allow_require_reply'] && $require_reply) {
	if (!empty($xoopsModuleConfig['cache_enabled'])) {
		$viewtopic_posters = newbb_getsession("t".$topic_id, true);
		if (!is_array($viewtopic_posters) || count($viewtopic_posters) == 0) {
			$viewtopic_posters = $topic_handler->getAllPosters($topic_obj);
			newbb_setsession("t".$topic_id, $viewtopic_posters);
		}
	} else {
		$viewtopic_posters = $topic_handler->getAllPosters($topic_obj);
	}
} else {
	$viewtopic_posters =array();
}


foreach ($postsArray as $eachpost) {
  	$xoopsTpl->append('topic_posts', $eachpost->showPost($isadmin));
}


if ( $total_posts > $xoopsModuleConfig['posts_per_page'] ) {
    include XOOPS_ROOT_PATH.'/class/pagenav.php';    
    $nav = new XoopsPageNav($total_posts, $xoopsModuleConfig['posts_per_page'] , $start , "start", 'topic_id='.$topic_id.'&amp;order='.$order.'&amp;status='.$status."&amp;mode=".$mode);
    $xoopsTpl->assign('forum_page_nav', $nav->renderNav(4));
} else {
    $xoopsTpl->assign('forum_page_nav', '');
}


if (empty($post_id)) {
   $first = array_keys ($postsArray);
   $post_id = (!empty($first[0])) ? $first[0] : 0;
}
if (!empty($postsArray[$post_id])) {
    $xoops_pagetitle = $postsArray[$post_id]->getVar('subject') . ' [' . $forum_obj->getVar('forum_name') .  "]";
    $xoopsTpl->assign('xoops_pagetitle', $xoops_pagetitle);
    $xoopsOption['xoops_pagetitle']= $xoops_pagetitle;
    $kw = array_unique(explode(" ",strip_tags($postsArray[$post_id]->getVar('post_text')),150));
    arsort($kw);
    $kwort = "";
    $z = 0;
    foreach ($kw as $k) {
        if (strlen(trim($k)) > 5 && $z < 30) {
            $kwort.= trim($k)." ";
            $z++;
        }
    }
    $xoTheme->addMeta('meta', 'keywords', $kwort); 
    $xoTheme->addMeta('meta', 'description', substr(strip_tags($postsArray[$post_id]->getVar('post_text')),0,100));
}
unset($postsArray);

$xoopsTpl->assign('topic_print_link', "print.php?form=1&amp;{$page_query}");

$admin_actions = array();

$ad_merge = "";
$ad_move = "";
$ad_delete = "";
$ad_lock = "";
$ad_unlock = "";
$ad_sticky = "";
$ad_unsticky = "";
$ad_digest = "";
$ad_undigest = "";

$admin_actions['merge'] = array(
	"link"	=> XOOPS_URL.'/modules/'.$xoopsModule->getVar("dirname", "n").'/topicmanager.php?mode=merge&amp;topic_id='.$topic_id,
	"name"	=> _MD_MERGETOPIC,
	"image"	=> $ad_merge);
$admin_actions['move'] = array(
	"link"	=> XOOPS_URL.'/modules/'.$xoopsModule->getVar("dirname", "n").'/topicmanager.php?mode=move&amp;topic_id='.$topic_id,
	"name"	=> _MD_MOVETOPIC,
	"image"	=> $ad_move);
$admin_actions['delete'] = array(
	"link"	=> XOOPS_URL.'/modules/'.$xoopsModule->getVar("dirname", "n").'/topicmanager.php?mode=delete&amp;topic_id='.$topic_id,
	"name"	=> _MD_DELETETOPIC,
	"image"	=> $ad_delete);
if ( !$topic_obj->getVar('topic_status') ) {
    $admin_actions['lock'] = array(
    	"link"	=> XOOPS_URL.'/modules/'.$xoopsModule->getVar("dirname", "n").'/topicmanager.php?mode=lock&amp;topic_id='.$topic_id,
    	"image"	=> $ad_lock,
    	"name"	=> _MD_LOCKTOPIC);
} else {
    $admin_actions['unlock'] = array(
    	"link"	=> XOOPS_URL.'/modules/'.$xoopsModule->getVar("dirname", "n").'/topicmanager.php?mode=unlock&amp;topic_id='.$topic_id,
    	"image"	=> $ad_unlock,
    	"name"	=> _MD_UNLOCKTOPIC);
}
if ( !$topic_obj->getVar('topic_sticky') ) {
    $admin_actions['sticky'] = array(
    	"link"	=> XOOPS_URL.'/modules/'.$xoopsModule->getVar("dirname", "n").'/topicmanager.php?mode=sticky&amp;topic_id='.$topic_id,
    	"image"	=> $ad_sticky,
    	"name"	=> _MD_STICKYTOPIC);
} else {
    $admin_actions['unsticky'] = array(
    	"link"	=> XOOPS_URL.'/modules/'.$xoopsModule->getVar("dirname", "n").'/topicmanager.php?mode=unsticky&amp;topic_id='.$topic_id,
    	"image"	=> $ad_unsticky,
    	"name"	=> _MD_UNSTICKYTOPIC);
}
if ( !$topic_obj->getVar('topic_digest') ) {
    $admin_actions['digest'] = array(
    	"link"	=> XOOPS_URL.'/modules/'.$xoopsModule->getVar("dirname", "n").'/topicmanager.php?mode=digest&amp;topic_id='.$topic_id,
    	"image"	=> $ad_digest,
    	"name"	=> _MD_DIGESTTOPIC);
} else {
    $admin_actions['undigest'] = array(
    	"link"	=> XOOPS_URL.'/modules/'.$xoopsModule->getVar("dirname", "n").'/topicmanager.php?mode=undigest&amp;topic_id='.$topic_id,
    	"image"	=> $ad_undigest,
    	"name"	=> _MD_UNDIGESTTOPIC);
}
$xoopsTpl->assign_by_ref('admin_actions', $admin_actions);

$xoopsTpl->assign('viewer_level', ($isadmin) ? 2 : is_object($xoopsUser) );

if ($xoopsModuleConfig['show_permissiontable']) {
	$perm_handler =& xoops_getmodulehandler('permission', 'newbb');
	$permission_table = $perm_handler->permission_table($forum_obj, $topic_obj->getVar('topic_status'), $isadmin);
	$xoopsTpl->assign_by_ref('permission_table', $permission_table);
}

///////////////////////////////
// show Poll
$pollmodul = false;
$module_handler =& xoops_gethandler( 'module' );
$PollModule =& $module_handler->getByDirname('xoopspoll');
if ($PollModule && $PollModule->getVar('isactive')) {
    $pollmodul = 'xoopspoll';
} else {
    $PollModule =& $module_handler->getByDirname('umfrage');
    if ($PollModule && $PollModule->getVar('isactive')) {
        $pollmodul = 'umfrage';
    }
} 

if (
	(
		$topic_obj->getVar('topic_haspoll')
		&& $topic_handler->getPermission($forum_obj, $topic_obj->getVar('topic_status'), "vote")
        && $pollmodul
	)
	|| 
    (
        $topic_handler->getPermission($forum_obj, $topic_obj->getVar('topic_status'), "addpoll")
        && $pollmodul
    )
) {
    if ($pollmodul == 'xoopspoll') {
        @include_once XOOPS_ROOT_PATH."/modules/xoopspoll/class/xoopspoll.php";
        @include_once XOOPS_ROOT_PATH."/modules/xoopspoll/class/xoopspolloption.php";
        @include_once XOOPS_ROOT_PATH."/modules/xoopspoll/class/xoopspolllog.php";
        @include_once XOOPS_ROOT_PATH."/modules/xoopspoll/class/xoopspollrenderer.php";
    } else {
        @include_once XOOPS_ROOT_PATH."/modules/umfrage/class/umfrage.php";
        @include_once XOOPS_ROOT_PATH."/modules/umfrage/class/umfrageoption.php";
        @include_once XOOPS_ROOT_PATH."/modules/umfrage/class/umfragelog.php";
        @include_once XOOPS_ROOT_PATH."/modules/umfrage/class/umfragerenderer.php";
    }
}

if ( $topic_obj->getVar('topic_haspoll') 
	&& $topic_handler->getPermission($forum_obj, $topic_obj->getVar('topic_status'), "vote")
    && $pollmodul
) {

	$xoopsTpl->assign('topic_poll', 1);
    $uid = is_object($xoopsUser)?$xoopsUser->getVar("uid"):0;
	if ($pollmodul == 'xoopspoll') {
        $poll = new XoopsPoll($topic_obj->getVar('poll_id'));
        $renderer = new XoopsPollRenderer($poll);
        if ( XoopsPollLog::hasVoted($topic_obj->getVar('poll_id'), $_SERVER['REMOTE_ADDR'], $uid) ) {
            $renderer->assignResults($xoopsTpl);
            $xoopsTpl->assign('topic_pollresult', 1);
            setcookie("bb_polls[".$topic_obj->getVar("poll_id")."]", 1);
        } else {
            $renderer->assignForm($xoopsTpl);
            $xoopsTpl->assign('lang_vote' , _PL_VOTE);
            $xoopsTpl->assign('lang_results' , _PL_RESULTS);
            setcookie("bb_polls[".$topic_obj->getVar("poll_id")."]", 1);
        }
    } else {   
        $poll = new Umfrage($topic_obj->getVar('poll_id'));
        $renderer = new UmfrageRenderer($poll);
        $xoopsTpl->assign('lang_alreadyvoted2' , _PL_ALREADYVOTED2);
        $xoopsTpl->assign('has_ended' , $poll->getVar('end_time')<time() ? 1 : 0);
        $xoopsTpl->assign('polltype',$poll->getVar('polltype'));
        switch ($poll->getVar('polltype')){
            case 1: 
            $xoopsTpl->assign('polltypecomment','');
            break;
            case 2:
            $xoopsTpl->assign('polltypecomment',_PL_FULLBLIND);
            break;
            case 3:	
            $xoopsTpl->assign('polltypecomment',_PL_HALFBLIND);
            break;
	    
        }

        $hasvoted=0;
        if($xoopsUser)
        {
            if(UmfrageLog::hasVoted($topic_obj->getVar('poll_id'),xoops_getenv('REMOTE_ADDR'),$xoopsUser->getVar("uid"))){
                $hasvoted=1;
            }	
        } else {
            $hasvoted=1;
        }

        $xoopsTpl->assign('hasVoted' , $hasvoted);
        $xoopsTpl->assign('lang_vote' , _PL_VOTE);
        $xoopsTpl->assign('lang_results' , $poll->getVar("end_time")< time() ?  _PL_RESULTS : _PL_STANDINGS);
	
        if ( UmfrageLog::hasVoted($topic_obj->getVar('poll_id'), $_SERVER['REMOTE_ADDR'], $uid) || $poll->getVar('end_time')<time() ) {
            $renderer->assignResults($xoopsTpl);
            //pollresults($forumtopic->getVar('poll_id'));
            $xoopsTpl->assign('topic_pollresult', 1);
            setcookie("bb_polls[".$topic_obj->getVar("poll_id")."]", 1);
        } else {
            $renderer->assignForm($xoopsTpl);
            //pollview($forumtopic->getVar('poll_id'));
            setcookie("bb_polls[".$topic_obj->getVar("poll_id")."]", 1);

        }
    } 	
}
if ($topic_handler->getPermission($forum_obj, $topic_obj->getVar('topic_status'), "addpoll") && $pollmodul
) {    
    if (!$topic_obj->getVar('topic_haspoll')) {	
		if ( is_object($xoopsUser) && $xoopsUser->getVar("uid")==$topic_obj->getVar("topic_poster") ) {
			$t_poll = newbb_displayImage('t_poll',_MD_ADDPOLL);
			$xoopsTpl->assign('forum_addpoll', "<a href=\"polls.php?op=add&amp;topic_id=".$topic_id."\">".$t_poll."</a>&nbsp;");
		}
	} elseif ($isadmin
		|| (is_object($poll) && is_object($xoopsUser) && $xoopsUser->getVar("uid")==$poll->getVar("user_id") )
	) {
    
		$poll_edit = "";
	    $poll_delete = "";
	    $poll_restart = "";

		$adminpoll_actions = array();
	    $adminpoll_actions['editpoll'] = array(
	    	"link"	=> XOOPS_URL.'/modules/'.$xoopsModule->getVar("dirname", "n").'/polls.php?op=edit&amp;poll_id='.$topic_obj->getVar('poll_id').'&amp;topic_id='.$topic_id,
	    	"image"	=> $poll_edit,
	    	"name"	=> _MD_EDITPOLL);
	    $adminpoll_actions['deletepoll'] = array(
	    	"link"	=> XOOPS_URL.'/modules/'.$xoopsModule->getVar("dirname", "n").'/polls.php?op=delete&amp;poll_id='.$topic_obj->getVar('poll_id').'&amp;topic_id='.$topic_id,
	    	"image"	=> $poll_delete,
	    	"name"	=> _MD_DELETEPOLL);
	    $adminpoll_actions['restartpoll'] = array(
	    	"link"	=> XOOPS_URL.'/modules/'.$xoopsModule->getVar("dirname", "n").'/polls.php?op=restart&amp;poll_id='.$topic_obj->getVar('poll_id').'&amp;topic_id='.$topic_id.'&amp;forum='.$forum_id,
	    	"image"	=> $poll_restart,
	    	"name"	=> _MD_RESTARTPOLL);

	    $xoopsTpl->assign_by_ref('adminpoll_actions', $adminpoll_actions);	
	}
}
if (isset($poll)) unset($poll);

$xoopsTpl->assign('p_up', newbb_displayImage('up',_MD_TOP));
$xoopsTpl->assign('rating_enable', $xoopsModuleConfig['rating_enabled']);
$xoopsTpl->assign('groupbar_enable', $xoopsModuleConfig['groupbar_enabled']);
$xoopsTpl->assign('anonymous_prefix', $xoopsModuleConfig['anonymous_prefix']);

$xoopsTpl->assign('previous', newbb_displayImage('previous'));
$xoopsTpl->assign('next', newbb_displayImage('next'));
$xoopsTpl->assign('down', newbb_displayImage('down'));
$xoopsTpl->assign('post_content', newbb_displayImage('post'));

if (!empty($xoopsModuleConfig['rating_enabled'])) {
	$xoopsTpl->assign('votes',$topic_obj->getVar('votes'));
	$rating = number_format($topic_obj->getVar('rating')/2, 0);
	if ( $rating < 1 ) {
		$rating_img = newbb_displayImage('blank');
	} else {
		$rating_img  = newbb_displayImage('rate'.$rating);
	}
	$xoopsTpl->assign('rating_img',$rating_img);
	$xoopsTpl->assign('rate1', newbb_displayImage('rate1', _MD_RATE1));
	$xoopsTpl->assign('rate2', newbb_displayImage('rate2', _MD_RATE2));
	$xoopsTpl->assign('rate3', newbb_displayImage('rate3', _MD_RATE3));
	$xoopsTpl->assign('rate4', newbb_displayImage('rate4', _MD_RATE4));
	$xoopsTpl->assign('rate5', newbb_displayImage('rate5', _MD_RATE5));
}

// create jump box
if (!empty($xoopsModuleConfig['show_jump'])) {
	mod_loadFunctions("forum", "newbb");
	$xoopsTpl->assign('forum_jumpbox', newbb_make_jumpbox($forum_id));
}
$xoopsTpl->assign(array(
			'lang_forum_index'	=> sprintf(_MD_FORUMINDEX, htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES)), 
			'lang_from'			=> _MD_FROM, 
			'lang_joined'		=> _MD_JOINED, 
			'lang_posts'		=> _MD_POSTS, 
			'lang_poster'		=> _MD_POSTER, 
			'lang_thread'		=> _MD_THREAD, 
			'lang_edit'			=> _EDIT, 
			'lang_delete'		=> _DELETE, 
			'lang_reply'		=> _REPLY, 
			'lang_postedon'		=> _MD_POSTEDON,
			'lang_groups'		=> _MD_GROUPS));

$viewmode_options = array();
if ($order == 'DESC') {
	$viewmode_options[]= array("link"=>XOOPS_URL.'/modules/'.$xoopsModule->getVar("dirname", "n")."/viewtopic.php?order=ASC&amp;status=$status&amp;topic_id=".$topic_id, "title"=>_OLDESTFIRST);
} else {
	$viewmode_options[]= array("link"=>XOOPS_URL.'/modules/'.$xoopsModule->getVar("dirname", "n")."/viewtopic.php?order=DESC&amp;status=$status&amp;topic_id=".$topic_id, "title"=>_NEWESTFIRST);
}

switch ($status) {
	case 'active':
		$current_status = '['._MD_TYPE_ADMIN.']';
		break;
	case 'pending':
		$current_status = '['._MD_TYPE_PENDING.']';
		break;
	case 'deleted':
		$current_status = '['._MD_TYPE_DELETED.']';
		break;
	default:
		$current_status = '';
		break;
	}
$xoopsTpl->assign('topicstatus', $current_status);

$xoopsTpl->assign('mode', $mode);
$xoopsTpl->assign('status', $status);
//$xoopsTpl->assign('viewmode_compact', ($viewmode=="compact")?1:0);
$xoopsTpl->assign_by_ref('viewmode_options', $viewmode_options);
unset($viewmode_options);
$xoopsTpl->assign('menumode',$menumode);
$xoopsTpl->assign('menumode_other',$menumode_other);


if ( !empty($xoopsModuleConfig['quickreply_enabled'])
	&& $topic_handler->getPermission($forum_obj, $topic_obj->getVar('topic_status'), "reply")
) {
	require_once XOOPS_ROOT_PATH."/class/xoopsform/formelement.php";
	require_once XOOPS_ROOT_PATH."/class/xoopsform/formhidden.php";
	require_once XOOPS_ROOT_PATH."/class/xoopsform/formhiddentoken.php";
	require_once XOOPS_ROOT_PATH."/class/xoopsform/formbutton.php";
	require_once XOOPS_ROOT_PATH."/class/xoopsform/themeform.php";
	require_once XOOPS_ROOT_PATH."/class/xoopsform/formtextarea.php";
	if (! @include_once XOOPS_ROOT_PATH."/class/xoopsform/formeditor.php") {
		require_once XOOPS_ROOT_PATH."/Frameworks/compat/class/xoopsform/formeditor.php";
	}

    $forum_form = new XoopsThemeForm(_MD_POSTREPLY, 'quick_reply', "post.php", 'post', true);

	if (!is_object($xoopsUser)) {
		require_once XOOPS_ROOT_PATH."/class/xoopsform/formpassword.php";
		require_once XOOPS_ROOT_PATH."/class/xoopsform/formcheckbox.php";
		require_once XOOPS_ROOT_PATH."/class/xoopsform/formtext.php";
		require_once XOOPS_ROOT_PATH."/class/xoopsform/formelementtray.php";
		require_once XOOPS_ROOT_PATH."/class/xoopsform/formcaptcha.php";
		$config_handler =& xoops_gethandler('config');
		$user_tray = new XoopsFormElementTray(_MD_ACCOUNT);
		$user_tray->addElement(new XoopsFormText(_MD_NAME, "uname", 26, 255));
		$user_tray->addElement(new XoopsFormPassword(_MD_PASSWORD, "pass", 10, 32));
		$login_checkbox = new XoopsFormCheckBox('', 'login', 1);
		$login_checkbox->addOption(1, _MD_LOGIN);
		$user_tray->addElement($login_checkbox);
		$forum_form->addElement($user_tray);
		$captcha = new XoopsFormCaptcha("", "topic_{$topic_id}_{$start}");
		$captcha->setConfig("mode", "text");
		$forum_form->addElement( $captcha );
	}

	$quickform = ( !empty($xoopsModuleConfig['qr_editor']) ) ? "dhtmltextarea" : "textarea";
	$editor_configs = array();
	$editor_configs["caption"] = _MD_MESSAGEC;
	$editor_configs["name"] ="message";
	$editor_configs["rows"] = 10;
	$editor_configs["cols"] = 60;
	$forum_form->addElement(new XoopsFormEditor(_MD_MESSAGEC, $quickform, $editor_configs, true), true);

	$forum_form->addElement(new XoopsFormHidden('dohtml', 0));
	$forum_form->addElement(new XoopsFormHidden('dosmiley', 1));
	$forum_form->addElement(new XoopsFormHidden('doxcode', 1));
	$forum_form->addElement(new XoopsFormHidden('dobr', 1));
	$forum_form->addElement(new XoopsFormHidden('attachsig', 1));

	$forum_form->addElement(new XoopsFormHidden('isreply', 1));
	
	$forum_form->addElement(new XoopsFormHidden('subject', _MD_RE.': '.$topic_obj->getVar('topic_title', 'e')));
	$forum_form->addElement(new XoopsFormHidden('pid', empty($post_id) ? $topic_handler->getTopPostId($topic_id) : $post_id));
	$forum_form->addElement(new XoopsFormHidden('topic_id', $topic_id));
	$forum_form->addElement(new XoopsFormHidden('forum', $forum_id));
	//$forum_form->addElement(new XoopsFormHidden('viewmode', $viewmode));
	$forum_form->addElement(new XoopsFormHidden('order', $order));
	$forum_form->addElement(new XoopsFormHidden('start', $start));

	// backward compatible
	if (!class_exists("XoopsSecurity")) {
		$post_valid = 1;
		$_SESSION['submit_token'] = $post_valid;
		$forum_form->addElement(new XoopsFormHidden('post_valid', $post_valid));
	}

	$forum_form->addElement(new XoopsFormHidden('notify', -1));
	$forum_form->addElement(new XoopsFormHidden('contents_submit', 1));
	
	$submit_button = new XoopsFormButton('', 'quick_submit', _SUBMIT, "submit");
	$submit_button->setExtra('onclick="if (document.forms.quick_reply.message.value == \'RE\' || document.forms.quick_reply.message.value == \'\') { alert(\''._MD_QUICKREPLY_EMPTY.'\'); return false;} else { return true;}"');
	$forum_form->addElement($submit_button);

	$toggles = newbb_getcookie('G', true);
	$display = (in_array('qr', $toggles)) ? 'none;' : 'block;';
    $xoopsTpl->assign('quickreply', array( 'show' => 1, 'display' => $display, 'icon' => newbb_displayImage('t_qr'), 'form' => $forum_form->render()));
	unset($forum_form);

} else {
	$xoopsTpl->assign('quickreply', array( 'show' => 0));
}

if ($xoopsModuleConfig["do_tag"] && @include_once XOOPS_ROOT_PATH."/modules/tag/include/tagbar.php") {
	$xoopsTpl->assign('tagbar', tagBar($topic_obj->getVar("topic_tags", "n")));
}

if ($xoopsModuleConfig["framework_toolbar"] && $transferbar = @include(XOOPS_ROOT_PATH."/Frameworks/transfer/bar.transfer.php")) {
	$xoopsTpl->assign('transfer', $transferbar);
} 
include XOOPS_ROOT_PATH.'/footer.php';
?>