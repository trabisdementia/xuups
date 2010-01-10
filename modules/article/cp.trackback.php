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
 * @version         $Id: cp.trackback.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";

$category_id = intval( empty($_GET["category"]) ? @$_POST["category"] : $_GET["category"] );
$article_id = intval( empty($_GET["article"]) ? @$_POST["article"] : $_GET["article"] );
$start = intval( empty($_GET["start"]) ? @$_POST["start"] : $_GET["start"] );
$type = empty($_GET["type"]) ? @$_POST["type"] : $_GET["type"];
$from = ( !empty($_GET["from"]) || !empty($_POST["from"]) ) ? 1 : 0;

$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
$category_obj =& $category_handler->get($category_id);
if ( (!empty($category_id) && !$category_handler->getPermission($category_obj, "moderate")) || (empty($category_id) && !art_isAdministrator()) ) {
    redirect_header(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.category.php" . URL_DELIMITER . $category_id, 2, art_constant("MD_NOACCESS"));
}

$xoopsOption["xoops_pagetitle"] = $xoopsModule->getVar("name") . " - " . art_constant("MD_CPTRACKBACK");
$template = ( empty($category_obj) ? $xoopsModuleConfig["template"] : $category_obj->getVar("cat_template"));
$xoopsOption["template_main"] = art_getTemplate("cptrackback", $template);
$xoopsOption["xoops_module_header"] = art_getModuleHeader($template);

// Disable cache
$xoopsConfig["module_cache"][$xoopsModule->getVar("mid")] = 0;

include_once XOOPS_ROOT_PATH . "/header.php";
include XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";

$criteria = new CriteriaCompo();
if ( !empty($category_id) ) {
    $criteria->add(new Criteria("cat_id", $category_id));
}
if ( !empty($article_id) ) {
    $criteria->add(new Criteria("art_id", $article_id));
}

if ($type == "pending") {
    $criteria->add(new Criteria("tb_status", 0));
    $type_name = art_constant("MD_PENDING");
} elsei f($type == "approved") {
    $criteria->add(new Criteria("tb_status", 0, ">"));
    $type_name = art_constant("MD_APPROVED");
} else {
    $type_name = _ALL;
}

$trackback_handler =& xoops_getmodulehandler("trackback", $GLOBALS["artdirname"]);
$tb_count = $trackback_handler->getCount($criteria);
$criteria->setStart($start);
$criteria->setLimit($xoopsModuleConfig["articles_perpage"]);
$trackbacks_obj = $trackback_handler->getAll($criteria);

$articleIds = array();
$trackbacks = array();
$article_list = array();
if (!empty($article_id)) {
    $articleIds[$article_id] = 1;
} elseif (count($trackbacks_obj) > 0) {
    foreach ($trackbacks_obj as $id => $trackback) {
        $trackbacks[] = array(
            "id"        => $id,
            "art_id"    => $trackback->getVar("art_id"),
            "title"        => $trackback->getVar("tb_title"),
            "url"        => $trackback->getVar("tb_url"),
            "excerpt"    => $trackback->getVar("tb_excerpt"),
            "time"        => $trackback->getTime($xoopsModuleConfig["timeformat"]),
            "ip"        => $trackback->getIp(),
            "name"        => $trackback->getVar("tb_blog_name"),
        );
        $articleIds[$trackback->getVar("art_id")] = 1;
    }
}
$article_list = array();
if (!empty($articleIds)) {
    $article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
    $criteria = new CriteriaCompo(new Criteria("art_id", "(" . implode(",", array_keys($articleIds)) . ")", "IN"));
    $article_list = $article_handler->getList($criteria);
}
foreach (array_keys($trackbacks) as $i) {
    if (empty($article_list[$trackbacks[$i]["art_id"]])) continue;
    $trackbacks[$i]["article"] = $article_list[$trackbacks[$i]["art_id"]]["title"];
}

if ( $tb_count > $xoopsModuleConfig["articles_perpage"]) {
    include XOOPS_ROOT_PATH . "/class/pagenav.php";
    $nav = new XoopsPageNav($tb_count, $xoopsModuleConfig["articles_perpage"], $start, "start", "category={$category_id}&amp;type={$type}&amp;from={$from}");
    $pagenav = $nav->renderNav(4);
} else {
    $pagenav = "";
}

$category_data = array();
if (!empty($category_id)) {
    $category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
    $category_obj =& $category_handler->get($category_id);
    $category_data = array(
        "id"            => $category_obj->getVar("cat_id"),
        "title"            => $category_obj->getVar("cat_title"),
        "description"    => $category_obj->getVar("cat_description"),
        "trackbacks"    => $tb_count
    );
}

$article_data = array();
if (!empty($article_id)) {
    $article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
    $article_obj =& $article_handler->get($article_id);
    $article_data = array(
        "id"            => $article_obj->getVar("cat_id"),
        "title"            => $article_obj->getVar("art_title"),
        "description"    => $article_obj->getSummary(),
        "trackbacks"    => $tb_count
    );
}

$xoopsTpl -> assign("modulename", $xoopsModule->getVar("name"));
$xoopsTpl -> assign("from", $from);
$xoopsTpl -> assign("start", $start);
$xoopsTpl -> assign("type", $type);
$xoopsTpl -> assign("type_name", $type_name);
$xoopsTpl -> assign_by_ref("category", $category_data);
$xoopsTpl -> assign_by_ref("article", $article_data);
$xoopsTpl -> assign_by_ref("trackbacks", $trackbacks);
$xoopsTpl -> assign_by_ref("pagenav", $pagenav);

// Loading module meta data, NOT THE RIGHT WAY DOING IT
$xoopsTpl -> assign("xoops_module_header", $xoopsOption["xoops_module_header"]);
$xoopsTpl -> assign("xoops_pagetitle", $xoopsOption["xoops_pagetitle"]);

include_once "footer.php";
?>