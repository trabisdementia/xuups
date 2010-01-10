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
 * @version         $Id: view.article.php 2283 2008-10-12 03:36:13Z phppp $
 */
 
include "header.php";

//if(!empty($xoopsModuleConfig["do_urw"])):

/**
 * The comment detection scripts should be removed once absolute url is used in comment_view.php
 * The notification detection scripts should be removed once absolute url is used in notification_select.php
 *
 */
//if(preg_match("/(\/comment_[^\.]*\.php\?com_[a-z]*=.*)/i", $_SERVER["REQUEST_URI"], $matches)){
if (preg_match("/(\/comment_[^\.]*\.php\?.*=.*)/i", $_SERVER["REQUEST_URI"], $matches)) {
    header("location: " . XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . $matches[1]);
    exit();
}
if ( !empty($_POST['not_submit']) && preg_match("/\/notification_update\.php/i", $_SERVER["REQUEST_URI"], $matches)) {
    include XOOPS_ROOT_PATH . "/include/notification_update.php";
    exit();
}

//endif;

if ($REQUEST_URI_parsed = art_parse_args($args_num, $args, $args_str)) {
    $args["article"] = !empty($args["article"]) ? $args["article"] : @$args_num[0];
}

$article_id = intval( empty($_GET["article"]) ? @$args["article"] : $_GET["article"] );
$category_id = intval( empty($_GET["category"]) ? @$args["category"] : $_GET["category"] );
$page = intval( !isset($_GET["page"]) ? @$args["page"] : $_GET["page"] );

$idCategorized = $category_id;

$article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
$article_obj =& $article_handler->get($article_id);
/*
 * Global Xoops Entity could be used by blocks or other add-ons
 * Designed by Skalpa for Xoops 2.3+
 */
$xoopsEntity =& $article_obj;

$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
$criteria = new CriteriaCompo(new Criteria("ac.ac_publish", 0, ">"));
$categories_obj =& $category_handler->getByArticle($article_id, $criteria);
if (count($categories_obj) ==0 || !in_array($category_id, array_keys($categories_obj))) $category_id=0;
$category_id = empty($category_id) ? $article_obj->getVar("cat_id") : $category_id;

$categories = array();
foreach($categories_obj as $id => $category) {
    if ($id==$category_id) continue;
    $categories[] = array(
        "id" => $id,
        "title" => $category->getVar("cat_title")
    );
}
unset($categories_obj);
$category_obj =& $category_handler->get($category_id);

$uid = (empty($xoopsUser)) ? 0 : $xoopsUser->getVar("uid");
$isAuthor = ( $uid >0 && $uid == $article_obj->getVar("uid") );
$isAdmin = $category_handler->getPermission($category_obj, "moderate");

if (!$isAuthor && !$article_obj->getVar("art_time_submit")) {
    redirect_header(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/index.php", 2, art_constant("MD_NOACCESS"));
}

if ($isAuthor || ($isAdmin && $article_handler->getCategoryStatus($category_id, $article_id) !== NULL)) {
} elseif ( empty($category_id) || !$category_handler->getPermission($category_obj, "view") || !$article_obj->getVar("art_time_publish") ) {
    redirect_header(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/index.php", 2, art_constant("MD_NOACCESS"));
}

// restore $_SERVER["REQUEST_URI"]
if (!empty($REQUEST_URI_parsed)) {
    $args_REQUEST_URI = array();
    if (!empty($article_id)) {
        $args_REQUEST_URI[] = "article=" . $article_id;
    }
    if (!empty($page)) {
        $args_REQUEST_URI[] = "page=" . $page;
    }
    if (!empty($category_id)) {
        $args_REQUEST_URI[] = "category=" . $category_id;
    }
    $_SERVER["REQUEST_URI"] = substr($_SERVER["REQUEST_URI"], 0, strpos($_SERVER["REQUEST_URI"], "/modules/" . $GLOBALS["artdirname"] . "/view.article.php")) . 
        "/modules/" . $GLOBALS["artdirname"] . "/view.article.php" .
        (empty($args_REQUEST_URI) ? "" : "?" . implode("&",$args_REQUEST_URI));
}

$xoopsOption["xoops_pagetitle"] = $xoopsModule->getVar("name") . " - " . $article_obj->getVar("art_title");
$template = $article_obj->getVar("art_template");
$xoopsOption["template_main"] = art_getTemplate("article", $template);
// Disable cache for author and category moderator since we don't have proper cache handling way for them
if ($isAuthor || art_isModerator($category_obj)) {
    $xoopsConfig["module_cache"][$xoopsModule->getVar("mid")] = 0;
}
$xoopsOption["xoops_module_header"] = art_getModuleHeader($template) . "
    <link rel=\"alternate\" type=\"application/rss+xml\" title=\"" . $xoopsModule->getVar("name") . " article rss\" href=\"" . XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/xml.php" . URL_DELIMITER . "rss/" . $article_id . "/c" . $category_id . "\" />
    <link rel=\"alternate\" type=\"application/rss+xml\" title=\"" . $xoopsModule->getVar("name") . " article rdf\" href=\"" . XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/xml.php" . URL_DELIMITER . "rdf/" . $article_id . "/c" . $category_id . "\" />
    <link rel=\"alternate\" type=\"application/atom+xml\" title=\"" . $xoopsModule->getVar("name") . " article atom\" href=\"" . XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/xml.php" . URL_DELIMITER . "atom/" . $article_id . "/c" . $category_id . "\" />
    ";
// To enable image auto-resize by js
//$xoopsOption["xoops_module_header"] .= '<script src="' . XOOPS_URL . '/Frameworks/textsanitizer/xoops.js" type="text/javascript"></script>';
include XOOPS_ROOT_PATH . "/header.php";
include XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";

// Topics
$topic_handler =& xoops_getmodulehandler("topic", $GLOBALS["artdirname"]);
$criteria = new CriteriaCompo(new Criteria("t.top_expire", time(), ">"));
$topics_obj =& $topic_handler->getByArticle($article_id, $criteria);
$topics = array();
foreach ($topics_obj as $id => $topic) {
    $topics[] = array(
        "id" => $id,
        "title" => $topic->getVar("top_title")
    );
}

$article_data = array();

$article_data["id"] = $article_obj->getVar("art_id");
$article_data["cat_id"] = $category_id;
if ($article_obj->getVar("art_forum")) {
    $article_data["forum"] = XOOPS_URL . "/modules/" . sprintf($xoopsModuleConfig["url_forum"], $article_obj->getVar("art_forum"), $xoopsModuleConfig["forum"]);
}

// title
$article_data["title"] = $article_obj->getVar("art_title");

// image
$article_data["image"] = $article_obj->getImage();

// Author
/*
 * name
 * uid
 */
//$article_data["author"] = $article_obj->getAuthor(true);
mod_loadFunctions("author");
$authors = art_getAuthorNameFromId($article_obj->getVar("uid"), false, true);
$article_data["author"] = $authors[$article_obj->getVar("uid")];

// Writer
/*
 * name
 * profile
 * avatar
 */
$article_data["writer"] = $article_obj->getWriter();

// source
$article_data["source"] = $article_obj->getVar("art_source");

// publish time
$article_data["time"] = $article_obj->getTime($xoopsModuleConfig["timeformat"]);

// counter
$article_data["counter"] = $article_obj->getVar("art_counter");

// rating data
/* rating: average
 * votes: total rates
 */
$article_data["rates"] = $article_obj->getVar("art_rates");
$article_data["rating"] = $article_obj->getRatingAverage();

if ($page==0) {
    // summary
    $article_data["summary"] = $article_obj->getSummary();
}

// current category
$article_data["category"] = $category_id;

// text of page
$text = $article_obj->getText($page);
$article_data["text"] = $text;
if (!empty($xoopsModuleConfig["do_keywords"])) {
    $keywords_handler =& xoops_getmodulehandler("keywords", $GLOBALS["artdirname"], true);
    if ($keywords_handler->init()) {
        $article_data["text"]["body"] = $keywords_handler->process($article_data["text"]["body"]);
    }
}

$article_data["headings"] =& $article_obj->headings;
$article_data["notes"] =& $article_obj->notes;

// pages
$count_page = count($article_obj->getPages(false));
if ( $count_page > 1) {
    $pages = $article_obj->getPages(true);
    require_once XOOPS_ROOT_PATH . "/class/pagenav.php";
    $nav = new XoopsPageNav($count_page, 1, $page, "page", "category=" . $category_id . "&amp;article=" . $article_id);
    //$nav = new XoopsPageNav($count_page, 1, $page, "page");
    $article_data["pages"] = $nav->renderNav(5);
    if ($xoopsModuleConfig["do_subtitle"]) {
        for ($ipage = 0; $ipage < $count_page; $ipage++) {
            if (empty($pages[$ipage]["title"])) continue;
            $title = $pages[$ipage]["title"];
            if ($page == $ipage) $title = "<strong>" . $title . "</strong>";
            $article_data["subtitles"][] = array(
                "url"    => XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.article.php" . URL_DELIMITER . "c" . $category_id . "/" . $article_id . "/p" . $ipage,
                "title"    => $title
            );
        }
    }
}

// trackbacks
/* trackback.title
 * trackback.url
 */
if ($xoopsModuleConfig["trackback_option"] != 2) { // trackback open
    $trackback_handler =& xoops_getmodulehandler("trackback", $GLOBALS["artdirname"]);
    $trackback_array =& $trackback_handler->getByArticle($article_obj->getVar("art_id"));
    $trackbacks = array();
    foreach($trackback_array as $id => $trackback) {
        $trackbacks[]= array(
            "id"        => $id,
            "title"        => $trackback->getVar("tb_title"),
            "url"        => $trackback->getVar("tb_url"),
            "excerpt"    => $trackback->getVar("tb_excerpt"),
            "time"        => $trackback->getTime($xoopsModuleConfig["timeformat"]),
            "ip"        => $trackback->getIp(),
            "name"        => $trackback->getVar("tb_blog_name"),
            );
    }
}

if (!empty($xoopsModuleConfig["do_sibling"])) {
    if (empty($idCategorized)) {
        $cats = array_keys($category_handler->getAllByPermission($permission = "access", array("cat_id")));
    } else {
        $cats = array($idCategorized);
    }    
    $articles_sibling =& $article_handler->getSibling($article_obj, $cats);
    if (!empty($articles_sibling["previous"])) {
        $articles_sibling["previous"]["url"] = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.article.php" . URL_DELIMITER . $articles_sibling["previous"]["id"] . "/c" . $idCategorized;
        $articles_sibling["previous"]["title"] = $myts->htmlSpecialChars($articles_sibling["previous"]["title"]);
        if (!empty($xoopsModuleConfig["sibling_length"])) {
            $articles_sibling["previous"]["title"] = xoops_substr($articles_sibling["previous"]["title"], 0, $xoopsModuleConfig["sibling_length"]);
        }
    }
    if (!empty($articles_sibling["next"])) {
        $articles_sibling["next"]["url"] = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.article.php" . URL_DELIMITER . $articles_sibling["next"]["id"] . "/c" . $idCategorized;
        $articles_sibling["next"]["title"] = $myts->htmlSpecialChars($articles_sibling["next"]["title"]);
        if (!empty($xoopsModuleConfig["sibling_length"])) {
            $articles_sibling["next"]["title"] = xoops_substr($articles_sibling["next"]["title"], 0, $xoopsModuleConfig["sibling_length"]);
        }
    }
}

$xoopsTpl -> assign("modulename", $xoopsModule->getVar("name"));
$xoopsTpl -> assign("copyright", sprintf($xoopsModuleConfig["copyright"], !empty($article_data["writer"]["name"]) ? $article_data["writer"]["name"] : $article_data["author"]));

$xoopsTpl -> assign("tracks", $category_handler->getTrack($category_obj, true));
$xoopsTpl -> assign("links", art_parseLinks($article_obj->getVar("art_elinks", "E"))); // related external links

$xoopsTpl -> assign_by_ref("article", $article_data);
$xoopsTpl -> assign_by_ref("categories", $categories);
$xoopsTpl -> assign_by_ref("topics", $topics);
$xoopsTpl -> assign_by_ref("trackbacks", $trackbacks);
$xoopsTpl -> assign_by_ref("sibling", $articles_sibling);

$xoopsTpl -> assign("isadmin", $isAdmin);
$xoopsTpl -> assign("isauthor", $isAuthor);

$xoopsTpl -> assign("do_counter", $xoopsModuleConfig["do_counter"]);
$xoopsTpl -> assign("do_trackback", $xoopsModuleConfig["do_trackback"]);

$xoopsTpl -> assign("canRate", !empty($xoopsModuleConfig["do_rate"]) && $category_handler->getPermission($category_obj,"rate"));
$xoopsTpl -> assign("page", $page);

$xoopsTpl -> assign("sponsors", $category_obj->getSponsor());

if (@include_once XOOPS_ROOT_PATH . "/modules/tag/include/tagbar.php") {
    $xoopsTpl->assign('tagbar', tagBar($article_obj->getVar("art_keywords", "n")));
}


if ($transferbar = @include(XOOPS_ROOT_PATH . "/Frameworks/transfer/bar.transfer.php")) {
    $xoopsTpl->assign('transfer', $transferbar);
}

// Loading module meta data, NOT THE RIGHT WAY DOING IT
$xoopsTpl -> assign("xoops_module_header", $xoopsOption["xoops_module_header"]);
$xoopsTpl -> assign("xoops_pagetitle", $xoopsOption["xoops_pagetitle"]);

// for comment and notification
//$_SERVER["REQUEST_URI"] = XOOPS_URL."/modules/".$GLOBALS["artdirname"]."/view.article.php";
$_GET["article"] = $article_obj->getVar("art_id");

// for comment
$category = $category_id; // The $comment_config["extraParams"]
include XOOPS_ROOT_PATH . "/include/comment_view.php";

include_once "footer.php";
?>