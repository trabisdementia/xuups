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
 * @version         $Id: index.list.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined('XOOPS_ROOT_PATH') || !is_object($xoopsModule)) { 
    return false;
    exit(); 
}

// Instantiate the handlers
$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
$article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);

if ( !$categories_obj = $category_handler->getAllByPermission("access", array("cat_title", "cat_pid")) ) {
    redirect_header("index.php", 2, art_constant("MD_NOACCESS"));
}
$categories_id = array_keys($categories_obj);

// Get spotlight if enabled && isFirstPage
if (!empty($xoopsModuleConfig["do_spotlight"])) {
    $spotlight_handler =& xoops_getmodulehandler("spotlight", $GLOBALS["artdirname"]);
    $sp_data = $spotlight_handler->getContent();
    $article_spotlight_id = $sp_data["art_id"];
}
// Get featured articles if enabled && isFirstPage
if ($xoopsModuleConfig["featured_index"]) {
    $criteria = new CriteriaCompo(new Criteria("ac.ac_feature", 0, ">"));
    $articles_featured_id = $article_handler->getIdsByCategory($categories_id, $xoopsModuleConfig["featured_index"], 0, $criteria);
} else {
    $articles_featured_id = array();
}

$art_ids_special = $articles_featured_id;
if (!empty($article_spotlight_id)) {
    $art_ids_special[] = $article_spotlight_id;
}

$art_criteria = new CriteriaCompo(new Criteria("ac.ac_publish", 0, ">"));
if (!empty($art_ids_special)) {
    $art_criteria->add(new Criteria("ac.art_id", "(" . implode(",", $art_ids_special) . ")", "NOT IN"));
}
$art_ids_index = $article_handler->getIdsByCategory($categories_id, $xoopsModuleConfig["articles_perpage"], 0, $art_criteria);

// Ids of spotligh and featured
$art_ids = array_unique(array_merge($art_ids_index, $art_ids_special));
if (count($art_ids) > 0 ) {
    $criteria = new Criteria("art_id", "(" . implode(",", $art_ids) . ")", "IN");
    $tags = array("uid", "writer_id", "art_title", "art_image", "art_pages", "art_categories", "art_time_publish", "art_counter", "art_comments", "art_trackbacks");
    if (!empty($xoopsModuleConfig["display_summary"])) {
        $tags[] = "art_summary";
    }
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
if(!empty($author_array)) {
    include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/functions.author.php";
    $users = art_getAuthorNameFromId(array_keys($author_array), true, true);
}

if(!empty($writer_array)) {
    include_once XOOPS_ROOT_PATH."/modules/".$xoopsModule->getVar("dirname")."/include/functions.author.php";
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
    foreach($cats as $catid){
        if($catid==0 || !isset($categories_obj[$catid])) continue;
        $_article["categories"][$catid] = array("id"=>$catid,"title"=>$categories_obj[$catid]->getVar("cat_title"));
    }
    $articles[$id] = $_article;
    unset($_article);
}

$spotlight = array();
if(!empty($article_spotlight_id) && isset($articles[$article_spotlight_id])){
    $spotlight = $articles[$article_spotlight_id];
    $spotlight["note"] = $sp_data["sp_note"];
    if(empty($xoopsModuleConfig["display_summary"]) && empty($spotlight["summary"])){
        $spotlight["summary"] = $articles_obj[$article_spotlight_id]->getSummary(true);
    }
    if(empty($spotlight["image"])){
        $spotlight["image"] = $sp_data["image"];
    }
}

// an article can only be marked as feature from its basic category
$features = array();
foreach($articles_featured_id as $id){
    $_article = $articles[$id];
    if(empty($xoopsModuleConfig["display_summary"]) && empty($_article["summary"])){
        $_article["summary"] = $articles_obj[$id]->getSummary(true);
    }
    $features[] = $_article;
    unset($_article);
}

$articles_index = array();
foreach($art_ids_index as $id){
    $articles_index[] =& $articles[$id];
}

foreach(array_keys($categories_obj) as $id){
    if($categories_obj[$id]->getVar("cat_pid")) {
        unset($categories_obj[$id]);
    }
}

$categories = array();
$topics = array();
if(count($categories_obj)>0) {
    $criteria = new CriteriaCompo(new Criteria("ac.ac_publish", 0, ">"));
    $counts_article =& $category_handler->getArticleCounts(array_keys($categories_obj), $criteria);
    $counts_category =& $category_handler->getCategoryCounts(array_keys($categories_obj), "access");

    foreach($categories_obj as $id=>$category){
        $categories[] = array(
            "id"             => $id,
            "title"         => $category->getVar("cat_title"),
            "articles"        => @intval($counts_article[$id]),
            "categories"    => @intval($counts_category[$id])
        );
    }

    $topic_handler =& xoops_getmodulehandler("topic", $GLOBALS["artdirname"]);
    $criteria = new CriteriaCompo(new Criteria("top_expire", time(), ">"));
    $criteria->setSort("top_time");
    $criteria->setOrder("DESC");
    $tags = array("top_title");
    $topics_obj = $topic_handler->getByCategory(array_keys($categories_obj), $xoopsModuleConfig["topics_max"], 0, $criteria, $tags);
    if(count($topics_obj)>0) foreach($topics_obj as $topic){
        $topics[] = array(
            "id"    => $topic->getVar("top_id"),
            "title"    => $topic->getVar("top_title")
        );
    }
    unset($topics_obj);
}

$sponsors = array();
if(!empty($xoopsModuleConfig["sponsor"])){
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
$xoopsTpl -> assign("xoops_pagetitle", $xoopsOption["xoops_pagetitle"]);

include_once "footer.php";
?>