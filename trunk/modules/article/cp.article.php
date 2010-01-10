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
 * @version         $Id: cp.article.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";

$category_id = empty($_GET["category"]) ? 0 : intval($_GET["category"]);
$topic_id = empty($_GET["topic"]) ? 0 : intval($_GET["topic"]);
$start = empty($_GET["start"]) ? 0 : intval($_GET["start"]);
$from = ( !empty($_GET["from"]) || !empty($_POST["from"])) ? 1 : 0;

$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
$topic_handler =& xoops_getmodulehandler("topic", $GLOBALS["artdirname"]);

$isAdmin = art_isAdministrator();

if (!empty($topic_id)) {
    $topic_obj =& $topic_handler->get($topic_id);
    $category_id = $topic_obj->getVar("cat_id");
    $category_obj =& $category_handler->get($category_id);
    $allowed_type = array("all");
} else {
    if (!empty($category_id)) {
        $category_obj =& $category_handler->get($category_id);
        $categories_obj = array($category_id=>$category_obj); 
    } else {
        $categories_obj = $category_handler->getAllByPermission("moderate", array("cat_title", "cat_pid"));
    }
    $categories_id = array_keys($categories_obj);
    $topic_obj = false;
    $allowed_type = array("published", "registered", "featured", "submitted", "all");
}

if( (!empty($category_id) && !$category_handler->getPermission($category_obj, "moderate")) ||(empty($category_id) && !$isAdmin) ) {
    redirect_header(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/", 2, art_constant("MD_NOACCESS"));
}

$xoopsOption["xoops_pagetitle"] = $xoopsModule->getVar("name") . " - " . art_constant("MD_CPARTICLE");
$template = empty($topic_obj)
    ? (empty($category_obj) ? $xoopsModuleConfig["template"] : $category_obj->getVar("cat_template") )
    : $topic_obj->getVar("top_template");
$xoopsOption["template_main"] = art_getTemplate("cparticle", $template);
$xoopsOption["xoops_module_header"] = art_getModuleHeader($template);
// Disable cache
$xoopsConfig["module_cache"][$xoopsModule->getVar("mid")] = 0;
include_once XOOPS_ROOT_PATH . "/header.php";
include XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";

$type = empty($_GET["type"]) ? "" : (in_array($_GET["type"], $allowed_type) ? $_GET["type"] : "");
$byCategory = true;
switch ($type) {
    case "submitted":
        $type_name = art_constant("MD_SUBMITTED");
        $criteria = new CriteriaCompo(new Criteria("art_time_publish", 0));
        $criteria->add(new Criteria("art_time_submit", 0, ">"));
        $byCategory = false;
        break;
        
    case "registered":
        $type_name = art_constant("MD_REGISTERED");
        $criteria = new CriteriaCompo(new Criteria("ac.ac_publish", 0));
        break;
        
    case "featured":
        $type_name = art_constant("MD_FEATURED");
        $criteria = new CriteriaCompo(new Criteria("ac.ac_feature", 0, ">"));
        break;
        
    case "published":
        $type="published";
        $type_name = art_constant("MD_PUBLISHED");
        $criteria = new CriteriaCompo(new Criteria("ac.ac_publish", 0, ">"));
        $criteria->add(new Criteria("ac.ac_feature", 0));
        break;
        
    case "all":
    default:
        $type_name = _ALL;
        $criteria = new CriteriaCompo(new Criteria("1", 1));
        break;
}

$article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);

if (!empty($topic_id)) {
    $articles_count = $topic_handler->getArticleCount($topic_id);
    $tags = array("a.art_summary", "a.art_title", "a.uid", "at.at_time", "a.cat_id");
    $articles_array = $article_handler->getByTopic(
        $topic_id,
        $xoopsModuleConfig["articles_perpage"],
        $start,
        null,
        $tags,
        false);
} elseif($byCategory) {
    $articles_count = $category_handler->getArticleCount($categories_id, $criteria);
    $tags = array("a.cat_id AS basic_cat_id", "a.art_summary", "a.art_title", "a.uid", "a.art_time_submit", "a.art_time_publish", "ac.cat_id", "ac.ac_register", "ac.ac_publish", "ac.ac_feature");
    $articles_array = $category_handler->getArticles(
        $categories_id,
        $xoopsModuleConfig["articles_perpage"],
        $start,
        $criteria,
        $tags,
        false);
} else {
    $articles_count = $article_handler->getCount($criteria);
    $tags = array("cat_id", "art_summary", "art_title", "art_time_submit", "art_time_publish", "art_summary", "uid");
    $criteria->setStart($start);
    $criteria->setLimit($xoopsModuleConfig["articles_perpage"]);
    $articles_array = $article_handler->getAll(
        $criteria,
        $tags,
        false);
}

$articles = array();
if (count($articles_array) > 0) {
    $author_array = array();
    foreach ($articles_array as $id => $artcile) {
        if ($artcile["uid"] > 0) $author_array[$artcile["uid"]] = 1;
    }

    if (!empty($author_array)) {
        mod_loadFunctions("author");
        $users = art_getAuthorNameFromId(array_keys($author_array), true, true);
    }

    foreach ($articles_array as $id => $article) {
        $_article = array(
            "id"                => $article["art_id"],
            "cat_id"            => empty($article["basic_cat_id"]) ? $article["cat_id"] : $article["basic_cat_id"],
            "title"             => $article["art_title"],
            "submit"            => art_formatTimestamp(@$article["art_time_submit"]),
            "publish"           => art_formatTimestamp(@$article["art_time_publish"]),
            "register_category" => art_formatTimestamp(@$article["ac_register"]),
            "time_topic"        => art_formatTimestamp(@$article["at_time"]),
            "summary"           => $article["art_summary"],
            "author"            => $users[$article["uid"]]
            );
        if (!empty($article["ac_feature"])) {
            $_article["feature_category"] = art_formatTimestamp($article["ac_feature"]);
        }
        if (!empty($article["ac_publish"])) {
            $_article["publish_category"] = art_formatTimestamp($article["ac_publish"]);
        }
            
        if (!empty($category_obj)) {
            $_article["category"] = array("id" => $category_obj->getVar("cat_id"));
        } else {
            $_article["category"] = array("id" => $article["cat_id"], "title" => $categories_obj[$article["cat_id"]]->getVar("cat_title"));
        }
        if ( (!empty($category_obj) && $category_obj->getVar("cat_id") == @$article["cat_id"]) || $isAdmin ) {
            $_article["admin"] = 1;
        }
        $articles[] = $_article;
        unset($_article);
    }
}

if ( $articles_count > $xoopsModuleConfig["articles_perpage"]) {
    include XOOPS_ROOT_PATH . "/class/pagenav.php";
    $nav = new XoopsPageNav($articles_count, $xoopsModuleConfig["articles_perpage"], $start, "start", "category=" . $category_id . "&amp;topic=" . $topic_id . "&amp;type=" . $type . "&amp;from=" . $from);
    $pagenav = $nav->renderNav(4);
} else {
    $pagenav = "";
}

$category_data = array();
$topic_data = array();
if (!empty($topic_obj)) {
    $topic_data = array(
        "id"            => $topic_id,
        "title"         => $topic_obj->getVar("top_title"),
        "description"   => $topic_obj->getVar("top_description"),
        "articles"      => $articles_count
    );
} elseif (!empty($category_obj)) {
    $category_data = array(
        "id"            => $category_obj->getVar("cat_id"),
        "title"         => $category_obj->getVar("cat_title"),
        "description"   => $category_obj->getVar("cat_description"),
        "articles"  => $articles_count
    );
}

$categories = array();
$topics = array();
if (empty($topic_obj)) {
    $subCategories_obj = $category_handler->getChildCategories($category_id, "moderate");
    foreach ($subCategories_obj as $id => $cat) {
        $categories[] = array(
            "id" => $id,
            "title" => $cat->getVar("cat_title")
        );
    }
    unset($subCategories_obj);
    if (!empty($category_id)) {
        $criteria = new CriteriaCompo(new Criteria("top_expire", time(), ">"));
        $topics_obj =& $topic_handler->getByCategory($category_id, $xoopsModuleConfig["topics_max"], 0, $criteria, array("top_title"));
        foreach ($topics_obj as $id => $topic) {
            $topics[] = array(
                "id" => $id,
                "title" => $topic->getVar("top_title")
            );
        }
        unset($topics_obj);
    }
}

if (!empty($category_obj)) {
    $xoopsTpl -> assign("tracks", $category_handler->getTrack($category_obj, true));
}

$xoopsTpl -> assign("modulename", $xoopsModule->getVar("name"));
$xoopsTpl -> assign("category", $category_data);
$xoopsTpl -> assign("topic", $topic_data);
$xoopsTpl -> assign("articles", $articles);
$xoopsTpl -> assign("pagenav", $pagenav);
$xoopsTpl -> assign("start", $start);
$xoopsTpl -> assign("type", $type);
$xoopsTpl -> assign("type_name", $type_name);
$xoopsTpl -> assign("categories", $categories);
$xoopsTpl -> assign("topics", $topics);
$xoopsTpl -> assign("from", $from);

// Loading module meta data, NOT THE RIGHT WAY DOING IT
$xoopsTpl -> assign("xoops_module_header", $xoopsOption["xoops_module_header"]);
$xoopsTpl -> assign("xoops_pagetitle", $xoopsOption["xoops_pagetitle"]);

include_once "footer.php";
?>