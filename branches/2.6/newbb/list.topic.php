<?php
/**
 * CBB 4.0, or newbb, the forum module for XOOPS project
 *
 * @copyright	The XOOPS Project http://xoops.sf.net
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <phppp@users.sourceforge.net>
 * @since		4.00
 * @version		$Id $
 * @package		module::newbb
 */

include "header.php";

if (!empty($xoopsModuleConfig['rss_enable'])) {
	$xoops_module_header .= '<link rel="alternate" type="application/xml+rss" title="'.$xoopsModule->getVar('name').'" href="'.XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname', 'n').'/rss.php" />';
}
$xoopsOption['xoops_module_header']= $xoops_module_header;
$xoopsOption['template_main'] = 'newbb_viewall.html';
include XOOPS_ROOT_PATH."/header.php";

$xoopsTpl->assign('xoops_module_header', $xoops_module_header);

mod_loadFunctions("time", "newbb");
mod_loadFunctions("render", "newbb");

require "./class/topic.renderer.php";
$topic_renderer = NewbbTopicRenderer::instance();
$topic_renderer->userlevel = $GLOBALS["xoopsUserIsAdmin"] ? 2 : is_object($xoopsUser);
$topic_renderer->is_multiple = true;
$topic_renderer->config =& $xoopsModuleConfig;
$topic_renderer->setVars( @$_GET );

$type = intval( @$_GET['type'] );
$status = (!empty($_GET['status']) && in_array($_GET['status'], array("active", "pending", "deleted", "digest", "unreplied", "unread")))? $_GET['status'] : "all";
$mode = (!empty($status) && in_array($status, array("active", "pending", "deleted"))) ? 2 : (!empty($_GET['mode']) ? intval($_GET['mode']) : 0);

$isadmin = $GLOBALS["xoopsUserIsAdmin"];
/* Only admin has access to admin mode */
if (!$isadmin) {
	$mode = 0;
}

if ($xoopsModuleConfig['wol_enabled']) {
	$online_handler =& xoops_getmodulehandler('online', 'newbb');
	$online_handler->init();
	$online_handler->render($xoopsTpl);
}

$topic_renderer->buildHeaders($xoopsTpl);
$topic_renderer->buildFilters($xoopsTpl);
$topic_renderer->buildTypes($xoopsTpl);
$topic_renderer->buildCurrent($xoopsTpl);
$topic_renderer->renderTopics($xoopsTpl);
$topic_renderer->buildSearch($xoopsTpl);
$topic_renderer->buildPagenav($xoopsTpl);
$topic_renderer->buildSelection($xoopsTpl);

$xoopsTpl->assign('rating_enable', $xoopsModuleConfig['rating_enabled']);

$xoopsTpl->assign('img_newposts', newbb_displayImage('topic_new'));
$xoopsTpl->assign('img_hotnewposts', newbb_displayImage('topic_hot_new'));
$xoopsTpl->assign('img_folder', newbb_displayImage('topic'));
$xoopsTpl->assign('img_hotfolder', newbb_displayImage('topic_hot'));
$xoopsTpl->assign('img_locked', newbb_displayImage('topic_locked'));

$xoopsTpl->assign('img_sticky', newbb_displayImage('topic_sticky', _MD_TOPICSTICKY));
$xoopsTpl->assign('img_digest', newbb_displayImage('topic_digest', _MD_TOPICDIGEST));
$xoopsTpl->assign('img_poll', newbb_displayImage('poll', _MD_TOPICHASPOLL));

$xoopsTpl->assign('post_link', "viewpost.php");
$xoopsTpl->assign('newpost_link', "viewpost.php?status=new");


if (!empty($xoopsModuleConfig['show_jump'])) {
	mod_loadFunctions("forum", "newbb");
	$xoopsTpl->assign('forum_jumpbox', newbb_make_jumpbox());
}
$xoopsTpl->assign('menumode', $menumode);
$xoopsTpl->assign('menumode_other', $menumode_other);

$xoopsTpl->assign('mode', $mode);
$xoopsTpl->assign('status', $status);
$xoopsTpl->assign('viewer_level', ($isadmin) ? 2 : is_object($xoopsUser) );

$pagetitle = sprintf(_MD_FORUMINDEX, htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES));
$xoopsTpl->assign('forum_index_title', $pagetitle);
$xoopsTpl->assign('xoops_pagetitle', $pagetitle);

include XOOPS_ROOT_PATH."/footer.php";
?>