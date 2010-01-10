<?php
/**
 * Article module for XOOPS
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code 
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         article
 * @since           1.0
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: view.topic.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";

if (art_parse_args($args_num, $args, $args_str)) {
	$args["topic"] = !empty($args["topic"]) ? $args["topic"] : @$args_num[0];
}

$topic_id = intval( empty($_GET["topic"])?@$args["topic"]:$_GET["topic"] );
$start = intval( empty($_GET["start"])?@$args["start"]:$_GET["start"] );

$topic_handler =& xoops_getmodulehandler("topic", $GLOBALS["artdirname"]);
$topic_obj =& $topic_handler->get($topic_id);
/*
 * Global Xoops Entity could be used by blocks or other add-ons
 * Designed by Skalpa for Xoops 2.3+
 */
$xoopsEntity =& $topic_obj;

$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
$category_obj =& $category_handler->get($topic_obj->getVar("cat_id"));
if (!$category_handler->getPermission($category_obj, "access")) {
    redirect_header(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/index.php", 2, art_constant("MD_NOACCESS"));
}

// Disable cache for category moderators since we don't have proper cache handling way for them
if (art_isModerator($category_obj)) {
	$xoopsConfig["module_cache"][$xoopsModule->getVar("mid")] = 0;
}
$xoopsOption["xoops_pagetitle"] = $xoopsModule->getVar("name") . " - " . $topic_obj->getVar("top_title");
$template = $topic_obj->getVar("top_template");
$xoopsOption["template_main"] = art_getTemplate("topic", $template);
$xoopsOption["xoops_module_header"] = art_getModuleHeader($template);
include_once XOOPS_ROOT_PATH . "/header.php";
include XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";

$article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
$articles_object = $topic_handler->getArticles($topic_obj, $xoopsModuleConfig["articles_perpage"], $start);

$articles = array();
$uids = array();
foreach (array_keys($articles_object) as $id) {
	$uids[$articles_object[$id]->getVar("uid")] = 1;
}

$author_array = array_keys($uids);
$users = art_getUnameFromId($author_array);

$articles = array();
foreach ($articles_object as $id => $article) {
	$author =& $article->getAuthor();
	$author["name"] = $users[$article->getVar("uid")];
	$articles[] = array(
		"id"		=> $id,
		"title"		=> $article->getVar("art_title"),
		"author"	=> $author,
		"time"		=> $article->getTime($xoopsModuleConfig["timeformat"])
		);
}

$count_article = $topic_handler->getArticleCount($topic_id);
if ( $count_article > $xoopsModuleConfig["articles_perpage"]) {
	include XOOPS_ROOT_PATH . "/class/pagenav.php";
	$nav = new XoopsPageNav($count_article, $xoopsModuleConfig["articles_perpage"], $start, "start", "topic=" . $topic_id);
	$pagenav = $nav->renderNav(4);
} else {
	$pagenav = "";
}

$topic_data = array();
if (empty($start)) {
    $topic_data = array(
    	"id"		=> $topic_obj->getVar("top_id"),
    	"cat_id"	=> $topic_obj->getVar("cat_id"),
    	"title"		=> $topic_obj->getVar("top_title"),
    	"description" => $topic_obj->getVar("top_description"),
    	"time"		=> $topic_obj->getTime($xoopsModuleConfig["timeformat"]),
    	"expire"	=> $topic_obj->getExpire(),
    	"articles"	=> $count_article
    );
}
$xoopsTpl -> assign("modulename", $xoopsModule->getVar("name"));

$xoopsTpl -> assign("tracks", $category_handler->getTrack($category_obj, true));
$xoopsTpl -> assign_by_ref("topic", $topic_data);
$xoopsTpl -> assign("sponsors", array_merge($topic_obj->getSponsor(), $category_obj->getSponsor()));

$xoopsTpl -> assign_by_ref("articles", $articles);
$xoopsTpl -> assign_by_ref("pagenav", $pagenav);

// Loading module meta data, NOT THE RIGHT WAY DOING IT
$xoopsTpl -> assign("xoops_module_header", $xoopsOption["xoops_module_header"]);
$xoopsTpl -> assign("xoops_pagetitle", $xoopsOption["xoops_pagetitle"]);

include_once "footer.php";
?>