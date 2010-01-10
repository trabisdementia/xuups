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
 * @version         $Id: index.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";

/* 
 * Set groups for cache purposes
 * Group-based cache is available with XOOPS 2.2*
 * Will be re-implemented in 2.30+
 */
if (!empty($xoopsUser)) {
    $xoopsOption["cache_group"] = implode(",", $xoopsUser->groups());
}

$xoopsOption["template_main"] = art_getTemplate("index", $xoopsModuleConfig["template"]);
$xoops_module_header = art_getModuleHeader($xoopsModuleConfig["template"]) . '
    <link rel="alternate" type="application/rss+xml" title="' . $xoopsModule->getVar('name') . ' rss" href="' . XOOPS_URL . '/modules/' . $GLOBALS["artdirname"] . '/xml.php' . URL_DELIMITER . 'rss" />
    <link rel="alternate" type="application/rss+xml" title="' . $xoopsModule->getVar('name') . ' rdf" href="' . XOOPS_URL . '/modules/' . $GLOBALS["artdirname"] . '/xml.php' . URL_DELIMITER . 'rdf" />
    <link rel="alternate" type="application/atom+xml" title="' . $xoopsModule->getVar('name') . ' atom" href="' . XOOPS_URL . '/modules/' . $GLOBALS["artdirname"] . '/xml.php' . URL_DELIMITER . 'atom" />
    ';

$xoopsOption["xoops_module_header"] = $xoops_module_header;
include_once XOOPS_ROOT_PATH . "/header.php";
include XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";

// Dispatch upon templates 
if (!empty($xoopsModuleConfig["template"]) && "default" != $xoopsModuleConfig["template"]) {
    if (@include XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/index." . $xoopsModuleConfig["template"] . ".php") {
        include "footer.php";
        return;
    }
}

// Following part will not be executed if cache enabled

// Instantiate the handlers
$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
$article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);

$articles_index_id = array();
$articles_category_id = array();
$categories_id = array();

$categories_obj = $category_handler->getChildCategories();
if (!empty($categories_obj)):
$categories_id = array_keys($categories_obj);
if ( !empty($xoopsModuleConfig["articles_category"]) ) { 
    foreach ($categories_obj as $id => $cat_obj) {
        $articles_category_id = array_merge($articles_category_id, $category_handler->getLastArticleIds($cat_obj, $xoopsModuleConfig["articles_category"]));
    }
}
endif;

// Get spotlight if enabled && isFirstPage
if (!empty($xoopsModuleConfig["do_spotlight"])) {
    $spotlight_handler =& xoops_getmodulehandler("spotlight", $GLOBALS["artdirname"]);
    $sp_data =& $spotlight_handler->getContent();
    $article_spotlight_id = $sp_data["art_id"];
    //$article_spotlight_image = $sp_data["sp_image"];
}
// Get featured articles if enabled && isFirstPage
if ($xoopsModuleConfig["featured_index"]) {
    if ( "news" == $xoopsModuleConfig["template"] ) {
        $criteria = new CriteriaCompo(new Criteria("ac.ac_publish", 0, ">"));
    } else {
        $criteria = new CriteriaCompo(new Criteria("ac.ac_feature", 0, ">"));
    }
    $articles_featured_id =& $article_handler->getIdsByCategory($categories_id, $xoopsModuleConfig["featured_index"], 0, $criteria);
} else {
    $articles_featured_id = array();
}

$art_ids = $articles_featured_id;
if (!empty($article_spotlight_id)) {
    $art_ids[] = $article_spotlight_id;
}
// Ids of spotligh and featured
$art_ids_special = $art_ids;
if (count($articles_index_id)) { $art_ids = array_merge($art_ids, $articles_index_id); }
if (count($articles_category_id)) { $art_ids = array_merge($art_ids, $articles_category_id); }
$art_ids = array_unique($art_ids);
if (count($art_ids) > 0) {
    $criteria = new Criteria("art_id", "(" . implode(",", $art_ids) . ")", "IN");
    $tags = array("uid", "writer_id", "art_title", "art_summary", "art_image", "art_pages", "art_categories", "art_time_publish", "art_counter", "art_comments");
    $articles_obj = $article_handler->getAll($criteria, $tags);
} else {
    $articles_obj = array();
}

$author_array = array();
$writer_array = array();
$users = array();
$writers = array();
foreach (array_keys($articles_obj) as $id) {
    $author_array[$articles_obj[$id]->getVar("uid")] = 1;
    $writer_array[$articles_obj[$id]->getVar("writer_id")] = 1;
}
if (!empty($author_array)) {
    include_once XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/functions.author.php";
    $users = art_getAuthorNameFromId(array_keys($author_array), true, true);
}

if (!empty($writer_array)) {
    include_once XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/functions.author.php";
    $writers = art_getWriterNameFromIds(array_keys($writer_array));
}

$articles = array();
foreach (array_keys($articles_obj) as $id) {
    $_article = array(
        "id"         => $id,
        "title"        => $articles_obj[$id]->getVar("art_title"),
        "author"    => @$users[$articles_obj[$id]->getVar("uid")],
        "writer"    => @$writers[$articles_obj[$id]->getVar("writer_id")],
        "time"        => $articles_obj[$id]->getTime($xoopsModuleConfig["timeformat"]),
        "image"        => $articles_obj[$id]->getImage(),
        "counter"    => $articles_obj[$id]->getVar("art_counter"),
        "summary"    => $articles_obj[$id]->getSummary( !empty($xoopsModuleConfig["display_summary"]) )
        );
    $cats = $articles_obj[$id]->getCategories();
    foreach ($cats as $catid) {
        if ($catid==0 || !isset($categories_obj[$catid])) continue;
        $_article["categories"][$catid] = array("id" => $catid, "title" => $categories_obj[$catid]->getVar("cat_title"));
    }
    $articles[$id] = $_article;
    unset($_article);
}

$spotlight = array();
if (!empty($article_spotlight_id) && isset($articles[$article_spotlight_id])) {
    $spotlight = $articles[$article_spotlight_id];
    $spotlight["note"] = $sp_data["sp_note"];
    if (empty($xoopsModuleConfig["display_summary"]) && empty($spotlight["summary"])) {
        $spotlight["summary"] = $articles_obj[$article_spotlight_id]->getSummary(true);
    }
    if (empty($spotlight["image"])) {
        $spotlight["image"] = $sp_data["image"];
    }
}

// an article can only be marked as feature from its basic category
$features = array();
foreach ($articles_featured_id as $id) {
    $_article = $articles[$id];
    if (empty($xoopsModuleConfig["display_summary"]) && empty($_article["summary"])) {
        $_article["summary"] = $articles_obj[$id]->getSummary(true);
    }
    $features[] = $_article;
    unset($_article);
}

$articles_index = array();
// Exclude spotlight and features
$articles_index_id = array_diff($articles_index_id, $art_ids_special);
foreach ($articles_index_id as $id) {
    $_article = $articles[$id];
    if (!empty($xoopsModuleConfig["display_summary"]) && empty($_article["summary"])) {
        $_article["summary"] = $articles_obj[$id]->getSummary(true);
    }
    $articles_index[] = $_article;
    unset($_article);
}

$categories = array();
$topics = array();
if (count($categories_obj) > 0) {
    $criteria = new CriteriaCompo(new Criteria("ac.ac_publish", 0, ">"));
    $counts_article =& $category_handler->getArticleCounts(array_keys($categories_obj), $criteria);
    $counts_category =& $category_handler->getCategoryCounts(array_keys($categories_obj), "access");

    foreach ($categories_obj as $id => $category) {
        $cat = array(
            "id"                 => $id,
            "title"             => $category->getVar("cat_title"),
            "image"             => $category->getImage(),
            "count_article"        => @intval($counts_article[$id]),
            "count_category"    => @intval($counts_category[$id])
        );
        $articles_category_id = array();
        if (!empty($xoopsModuleConfig["articles_index"])) {
            $articles_category_id = $category_handler->getLastArticleIds($category, $xoopsModuleConfig["articles_index"]);
        }
        if (is_array($articles_category_id) && count($articles_category_id) > 0) {
            foreach ($articles_category_id as $art_id) {
                if (!isset($articles[$art_id])) continue;
                $_article = $articles[$art_id];
                if (!empty($xoopsModuleConfig["display_summary"]) && empty($_article["summary"])) {
                    $_article["summary"] = $articles_obj[$art_id]->getSummary(true);
                }
                $cat["articles"][]=& $_article;
                unset($_article);
            }
        }
        $categories[] =& $cat;
        unset($cat);
    }

    $topic_handler =& xoops_getmodulehandler("topic", $GLOBALS["artdirname"]);
    $criteria = new CriteriaCompo(new Criteria("top_expire", time(), ">"));
    $criteria->setSort("top_time");
    $criteria->setOrder("DESC");
    $tags = array("top_title");
    $topics_obj =& $topic_handler->getByCategory(array_keys($categories_obj), $xoopsModuleConfig["topics_max"], 0, $criteria, $tags);
    foreach($topics_obj as $topic) {
        $topics[] = array(
            "id"     => $topic->getVar("top_id"),
            "title" => $topic->getVar("top_title")
            //"description" =>  $topic->getVar("top_description")
        );
    }
    unset($topics_obj);
}

$sponsors = array();
if (!empty($xoopsModuleConfig["sponsor"])) {
    $sponsors = art_parseLinks($xoopsModuleConfig["sponsor"]);
}
unset($articles_obj, $categories_obj);

$xoopsTpl -> assign("header", $xoopsModuleConfig["header"]);
$xoopsTpl -> assign_by_ref("spotlight", $spotlight);
$xoopsTpl -> assign_by_ref("features", $features);
$xoopsTpl -> assign_by_ref("articles", $articles_index);
$xoopsTpl -> assign_by_ref("categories", $categories);
$xoopsTpl -> assign_by_ref("topics", $topics);
$xoopsTpl -> assign_by_ref("sponsors", $sponsors);

// Loading module meta data, NOT THE RIGHT WAY DOING IT
$xoopsTpl -> assign("xoops_module_header", $xoopsOption["xoops_module_header"]);

include_once "footer.php";
?>