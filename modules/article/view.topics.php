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
 * @version         $Id: view.topics.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";

if (art_parse_args($args_num, $args, $args_str)) {
    $args["category"] = !empty($args["category"]) ? $args["category"] : @$args_num[0];
}

$category_id = intval( empty($_GET["category"]) ? @$args["category"] : $_GET["category"] );
$start = intval( empty($_GET["start"]) ? @$args["start"] : $_GET["start"] );

$topic_handler =& xoops_getmodulehandler("topic", $GLOBALS["artdirname"]);
$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
$category =& $category_handler->get($category_id);
if (!$category_handler->getPermission($category, "access")) {
    redirect_header(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/index.php", 2, art_constant("MD_NOACCESS"));
}

if (!empty($xoopsUser)) {
    $xoopsOption["cache_group"] = implode(",", $xoopsUser->groups());
}
$xoopsOption["xoops_pagetitle"] = $xoopsModule->getVar("name") . " - " . $category->getVar("cat_title");
$template = $category->getVar("cat_template");
$xoopsOption["template_main"] = art_getTemplate("topics", $template);
$xoopsOption["xoops_module_header"] = art_getModuleHeader($template);
include_once XOOPS_ROOT_PATH . "/header.php";
include XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";


$topic_handler =& xoops_getmodulehandler("topic", $GLOBALS["artdirname"]);
$criteria = new CriteriaCompo(new Criteria("top_expire", time(), ">"));
$criteria->setSort("top_time");
$criteria->setOrder("DESC");
$topic_array =& $topic_handler->getByCategory($category_id, $xoopsModuleConfig["topics_max"], 0, $criteria);
$topics = array();
if (count($topic_array)>0) {
    $counts =& $topic_handler->getArticleCounts(array_keys($topic_array));
    foreach ($topic_array as $id => $topic) {
        $topics[] = array(
            "id"        => $id,
            "title"        => $topic->getVar("top_title"),
            "description" => $topic->getVar("top_description"),
            "articles"    => @intval($counts[$id])
        );
    }
}

$count_topic =& $topic_handler->getCountByCategory($category_id, $criteria);
if ( $count_topic > $xoopsModuleConfig["articles_perpage"]) {
    include XOOPS_ROOT_PATH . "/class/pagenav.php";
    $nav = new XoopsPageNav($count_topic, $xoopsModuleConfig["topics_max"], $start, "start", "category=".$category_id);
    $pagenav = $nav->renderNav(5);
} else {
    $pagenav = "";
}

$category_data = array();
if (!$category->isNew()) {
    $category_data = array(
        "id"        => $category->getVar("cat_id"),
        "title"        => $category->getVar("cat_title"),
        "description" => $category->getVar("cat_description")
    );
}
$xoopsTpl -> assign("modulename", $xoopsModule->getVar("name"));
$xoopsTpl -> assign("tracks", $category_handler->getTrack($category));
$xoopsTpl -> assign_by_ref("category", $category_data);
$xoopsTpl -> assign_by_ref("topics", $topics);
$xoopsTpl -> assign_by_ref("pagenav", $pagenav);

// Loading module meta data, NOT THE RIGHT WAY DOING IT
$xoopsTpl -> assign("xoops_module_header", $xoopsOption["xoops_module_header"]);
$xoopsTpl -> assign("xoops_pagetitle", $xoopsOption["xoops_pagetitle"]);

include_once "footer.php";
?>