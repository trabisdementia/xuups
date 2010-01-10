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
 * @version         $Id: am.article.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";

$category_id = empty($_GET["category"]) ? ( empty($_POST["category"]) ? 0 : intval($_POST["category"]) ) : intval($_GET["category"]);
$topic_id = empty($_GET["topic"]) ? ( empty($_POST["topic"]) ? 0 : intval($_POST["topic"]) ) : intval($_GET["topic"]);
$article_id = empty($_GET["article"]) ? ( empty($_POST["article"]) ? 0 : intval($_POST["article"]) ) : intval($_GET["article"]);
$start = empty($_GET["start"]) ? ( empty($_POST["start"]) ? 0 : intval($_POST["start"]) ) : intval($_GET["start"]);
$type = empty($_GET["type"]) ? ( empty($_POST["type"]) ? "" : $_POST["type"] ) : $_GET["type"];
$op = empty($_GET["op"]) ? ( empty($_POST["op"]) ? "" : $_POST["op"] ) : $_GET["op"];
$art_id_post = empty($_POST["art_id"]) ? array() : $_POST["art_id"];
$top_id_post = empty($_POST["top_id"]) ? 0 : $_POST["top_id"];
$from = intval( @$_POST["from"] );

if (!empty($article_id)) {
    $art_id[] = $article_id;
    $cat_id[] = $category_id;
} else {
    $postdata=array();
    $art_id = array_keys($art_id_post);
}
$count_artid = count($art_id);

if ( $count_artid == 0 && empty($article_id) ) {
    $redirect = empty($from) ? XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/index.php" : XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/admin/admin.article.php";
    redirect_header($redirect, 2, art_constant("MD_INVALID"));
}

if (!empty($topic_id)) {
    $topic_handler =& xoops_getmodulehandler("topic", $GLOBALS["artdirname"]);
    $topic_obj =& $topic_handler->get($topic_id);
    $category_id = $topic_obj->getVar("cat_id");
}

$article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
if (!empty($article_id)) {
    $criteria = null;
    if ( $op != "approve" && $op != "terminate" ) {
        $criteria = new Criteria("ac_publish", 0, ">");
    }
    $article_cats = $article_handler->getCategoryIds($article_id, $criteria);
    if (!is_array($article_cats) || !in_array($category_id, $article_cats)) {
        $category_id = 0;
    }
}

$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
$category_obj =& $category_handler->get($category_id);

if (!$category_handler->getPermission($category_obj, "moderate")) {
    redirect_header("index.php", 2, art_constant("MD_NOACCESS"));
}

$xoopsOption["xoops_pagetitle"] = $xoopsModule->getVar("name"). " - " .art_constant("MD_CPARTICLE");
include_once XOOPS_ROOT_PATH . "/header.php";
include XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";

$update_topic = false;
$update_category = false;

if ( !empty($topic_id) && $op == "terminate" ) {
    foreach ($art_id as $id) {
        $article_handler->terminateTopic($id, $topic_id);
    }
    $message = art_constant("MD_ACTIONDONE");
    $update_topic = true;
} elseif ( !empty($category_id) ) {
    switch($op) {
    case "update_time":
        if ($type == "featured") {
            $status = 2;
            $time = time();
        } else {
            $status = 1;
            $time = 0;
        }
        foreach ($art_id as $id) {
            $article_handler->setCategoryStatus($id, $category_id, $status, $time);
        }
        break;
    case "terminate":
        foreach ($art_id as $id) {
            $article_handler->terminateCategory($id, $category_id);
        }
        $update_topic = true;
        $update_category = true;
        break;
    case "approve":
        $valid_id = array();
        foreach ($art_id as $id) {
            $old_category = $article_handler->getCategoryArray($id);
            if (!empty($old_category[$category_id])) continue;
            $article_handler->publishCategory($id, $category_id);
            $valid_id[] = $id;
            $update_category = true;
        }
        $art_id = $valid_id;
        
        break;
    case "feature":
        foreach ($art_id as $id) {
            $old_category =& $article_handler->getCategoryArray($id);
            if (isset($old_category[$category_id]) && $old_category[$category_id] == 2) continue;
            $article_handler->featureCategory($id, $category_id);
        }
        break;
    case "unfeature":
        foreach ($art_id as $id) {
            $old_category = $article_handler->getCategoryArray($id);
            if (!isset($old_category[$category_id]) && $old_category[$category_id] < 2) continue;
            $article_handler->unfeatureCategory($id, $category_id);
        }
        break;
    case "registertopic":
        $valid_id = array();
        $criteria = new Criteria("art_id", "(" . implode(",", $art_id) . ")", "IN");
        $arts =& $article_handler->getAll($criteria, array("uid"));
        $criteria = new CriteriaCompo(new Criteria("1", 1));
        foreach (array_keys($arts) as $aid) {
            $old_topic =& $article_handler->getTopicIds($aid, $criteria);
            if (in_array($top_id_post, $old_topic)) continue;
            $article_handler->registerTopic($arts[$aid], $top_id_post);
            $update_topic = true;
            $valid_id[] = $aid;
        }
        $art_id = $valid_id;
        break;
    }
    $message = art_constant("MD_ACTIONDONE");
}
if ( $op == "rate") {
    
    if ($xoopsUserIsAdmin) {
        $art_id_valid = $art_id;
    } else {
        $criteria = new Criteria("art_id", "(" . implode(",", $art_id) . ")", "IN");
        $arts = $article_handler->getAll($criteria, array("cat_id"), false);
        $art_id_valid = array();
        foreach ($arts as $aid => $art) {
            if (art_isModerator($art["cat_id"])) $art_id_valid[] = $aid;
        }
    }
    if ($art_id_valid) {
        $rate_handler =& xoops_getmodulehandler("rate", $GLOBALS["artdirname"]);
        $rate_handler->deleteByArticle($art_id_valid);
        $article_handler->updateAll("art_rating", 0, new Criteria("art_id", "(" . implode(",", $art_id_valid) . ")", "IN"), true);
        $article_handler->updateAll("art_rates", 0, new Criteria("art_id", "(" . implode(",", $art_id_valid) . ")", "IN"), true);
    }
    $message = art_constant("MD_ACTIONDONE");
}
/*
}elseif(art_isAdministrator()){
    for($i=0;$i<$count_artid;$i++){
        switch($op){
        case "terminate":
            $article_handler->terminateCategory($art_id[$i], $cat_id[$i]);
            $update_topic = true;
            $update_category = true;
            break;
        case "approve":
            $article_handler->publishCategory($art_id[$i], $cat_id[$i]);
            $update_category = true;
        
            if (!empty($xoopsModuleConfig['notification_enabled'])) {
                $notification_handler =& xoops_gethandler('notification');
                $tags = array();
                $tags['ARTICLE_ACTION'] = art_constant("MD_NOT_ACTION_PUBLISHED");
                $article_obj =& $article_handler->get($art_id[$i]);
                $category_obj =& $category_handler->get($cat_id[$i]);
                $tags['ARTICLE_TITLE'] = $article_obj->getVar("art_title");
                $tags['ARTICLE_URL'] = XOOPS_URL . '/modules/' . $GLOBALS["artdirname"] . '/view.article.php'.URL_DELIMITER.'' .$art_id[$i].'/c'.$cat_id[$i];
                $tags['CATEGORY_TITLE'] = $category_obj->getVar("cat_title");
                $notification_handler->triggerEvent('global', 0, 'article_new', $tags);
                $notification_handler->triggerEvent('global', 0, 'article_monitor', $tags);
                $notification_handler->triggerEvent('category', $cat_id[$i], 'article_new', $tags);
                $notification_handler->triggerEvent('article', $art_id[$i], 'article_approve', $tags);
                unset($article_obj, $category_obj);
            }
            
            break;
        case "feature":
            $article_handler->featureCategory($art_id[$i], $cat_id[$i]);
        
            if (!empty($xoopsModuleConfig['notification_enabled'])) {
                $notification_handler =& xoops_gethandler('notification');
                $tags = array();
                $tags['ARTICLE_ACTION'] = art_constant("MD_NOT_ACTION_FEATURED");
                $article_obj =& $article_handler->get($art_id[$i]);
                $category_obj =& $category_handler->get($cat_id[$i]);
                $tags['ARTICLE_TITLE'] = $article_obj->getVar("art_title");
                $tags['ARTICLE_URL'] = XOOPS_URL . '/modules/' . $GLOBALS["artdirname"] . '/view.article.php'.URL_DELIMITER.'' .$art_id[$i].'/c'.$cat_id[$i];
                $tags['CATEGORY_TITLE'] = $category_obj->getVar("cat_title");
                $notification_handler->triggerEvent('global', 0, 'article_new', $tags);
                $notification_handler->triggerEvent('global', 0, 'article_monitor', $tags);
                $notification_handler->triggerEvent('category', $cat_id[$i], 'article_new', $tags);
                $notification_handler->triggerEvent('article', $art_id[$i], 'article_monitor', $tags);
                unset($article_obj, $category_obj);
            }
            
            break;
        case "unfeature":
            $article_handler->unfeatureCategory($art_id[$i], $cat_id[$i]);
            break;
        }
    }
    $message = art_constant("MD_ACTIONDONE");
}
*/    



    
if ($update_topic || $update_category) {
    foreach ($art_id as $id) {
        $art_obj =& $article_handler->get($id);
        if ( !is_object($art_obj) || @$art_obj->getVar("art_id") ==0 ) continue;
        if ($update_topic) $article_handler->updateTopics($art_obj);
        if ($update_category) $article_handler->updateCategories($art_obj);
        unset($art_obj);
    }
}

$redirect = empty($from) 
    ? XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/cp.article.php?category=" . $category_id . "&amp;topic=" . $topic_id . "&amp;start=" . $start . "&amp;type=" . $type
    : XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/admin/admin.article.php";
$message = empty($message) ? art_constant("MD_INVALID") : $message;
redirect_header($redirect, 2, $message);

include_once XOOPS_ROOT_PATH . "/footer.php";
?>