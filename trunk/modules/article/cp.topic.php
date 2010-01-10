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
 * @version         $Id: cp.topic.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";

$category_id = empty($_GET["category"]) ? 0 : intval($_GET["category"]);
$start = empty($_GET["start"]) ? 0 : intval($_GET["start"]);
$from = ( !empty($_GET["from"]) || !empty($_POST["from"])) ? 1 : 0;
$type = empty($_GET["type"]) ? "" : strtolower($_GET["type"]);

$isAdmin = art_isAdministrator();
$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
$category_obj =& $category_handler->get($category_id);
if ( (!empty($category_id) && !$category_handler->getPermission($category_obj, "moderate")) ||(empty($category_id) && !$isAdmin) ) {
    redirect_header(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/", 2, art_constant("MD_NOACCESS"));
}

$xoopsOption["xoops_pagetitle"] = $xoopsModule->getVar("name") . " - " . art_constant("MD_CPTOPIC");
$template = $category_obj->getVar("cat_template");
$xoopsOption["template_main"] = art_getTemplate("cptopic", $template);
$xoopsOption["xoops_module_header"] = art_getModuleHeader($template);
// Disable cache
$xoopsConfig["module_cache"][$xoopsModule->getVar("mid")] = 0;
include_once XOOPS_ROOT_PATH . "/header.php";
include XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";

$topic_handler =& xoops_getmodulehandler("topic", $GLOBALS["artdirname"]);
$tags = array("top_id", "top_title", "top_order", "top_time", "top_expire");
switch ($type) {
    case "expired":
        $criteria = new CriteriaCompo(new Criteria("top_expire", time(), "<"));
        $type_name = art_constant("MD_EXPIRED");
        break;
    case "all":
        $criteria = null;
        $type_name = _ALL;
        break;
    case "active":
    default:
        $type="active";
        $type_name = art_constant("MD_ACTIVE");
        $criteria = new CriteriaCompo(new Criteria("top_expire", time(), ">"));
        break;
}

$topics_count = $topic_handler->getCountByCategory($category_id, $criteria);
$topics_obj = $topic_handler->getByCategory($category_id, $xoopsModuleConfig["topics_max"], $start, $criteria, $tags);
$pagenav = "";
if ( $topics_count > $xoopsModuleConfig["articles_perpage"]) {
    include XOOPS_ROOT_PATH . "/class/pagenav.php";
    $nav = new XoopsPageNav($topics_count, $xoopsModuleConfig["topics_max"], $start, "start", "category=" . $category_id . "&amp;from=" . $from . "&amp;type=" . $type);
    $pagenav = $nav->renderNav(4);
}

$topics = array();
foreach ($topics_obj as $id => $topic) {
    $topics[$id] = array(
        "id"        => $id,
        "title"        => $topic->getVar("top_title"),
        "order"        => $topic->getVar("top_order"),
        "time"        => $topic->getTime($xoopsModuleConfig["timeformat"]),
        "expire"    => $topic->getExpire()
        );
}

$category_data = array();
if (!empty($category_id)) {
    $category_data = array(
        "id"    => $category_obj->getVar("cat_id"),
        "title"    => $category_obj->getVar("cat_title")
    );
}

if (!empty($category_id)) {
    $xoopsTpl -> assign("tracks", $category_handler->getTrack($category_obj, true));
}
$xoopsTpl -> assign("modulename", $xoopsModule->getVar("name"));

$xoopsTpl -> assign("category", $category_data);
$xoopsTpl -> assign("topics", $topics);
$xoopsTpl -> assign("pagenav", $pagenav);
$xoopsTpl -> assign("start", $start);
$xoopsTpl -> assign("type", $type);
$xoopsTpl -> assign("type_name", $type_name);
$xoopsTpl -> assign("from", $from);

// Loading module meta data, NOT THE RIGHT WAY DOING IT
$xoopsTpl -> assign("xoops_module_header", $xoopsOption["xoops_module_header"]);
$xoopsTpl -> assign("xoops_pagetitle", $xoopsOption["xoops_pagetitle"]);

include_once "footer.php";
?>