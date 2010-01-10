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
 * @version         $Id: view.list.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";

// Valid types of articles for regular applications, except author view
$valid_types = array(
    "p"        => art_constant("MD_REGULAR"),
    "f"        => art_constant("MD_FEATURED"),
    "s"        => art_constant("MD_SPOTLIGHT"), 
    "a"        => _ALL,
    );
    
// Valid sort criteria for articles for regular applications, except spotlight
$valid_sorts = array(
    "id"            => array(
                            "key"     => "art_id", 
                            "title" => art_constant("MD_DEFAULT") ),
    "time_publish"    => array(
                            "key"     => "art_time_publish", 
                            "title" => art_constant("MD_TIME") ), 
    "title"            => array(
                            "key"     => "art_title", 
                            "title" => art_constant("MD_TITLE") ), 
    "rating"        => array(
                            "key"     => "art_rating/art_rates", 
                            "tag"     => "art_rating, art_rates", 
                            "title" => art_constant("MD_RATE") ), 
    "counter"        => array(
                            "key"    => "art_counter", 
                            "title" => art_constant("MD_VIEWS") ), 
    "comments"        => array(
                            "key"    => "art_comments", 
                            "title" => art_constant("MD_COMMENTS") ), 
    "trackbacks"    => array(
                            "key"     => "art_trackbacks", 
                            "title" => art_constant("MD_TRACKBACKS") ), 
    );
// Sort order
$valid_orders = array(
    "DESC"    => art_constant("MD_DESC"), 
    "ASC"    => art_constant("MD_ASC")
    );

/*
 * Parse the variables
 */
if ($REQUEST_URI_parsed = art_parse_args($args_num, $args, $args_str)) {
    $args["start"]    = !empty($args["start"]) ? $args["start"] : @$args_num[0];
    $args["type"]    = @$args_str[0];
    $args["sort"]    = @$args_str[1];
    $args["order"]    = @$args_str[2];
}

$category_id    = intval( empty($_GET["category"]) ? @$args["category"] : $_GET["category"] );
$topic_id        = intval( empty($_GET["topic"]) ? @$args["topic"] : $_GET["topic"] );
$uid            = intval( empty($_GET["uid"]) ? @$args["uid"] : $_GET["uid"] );
$start            = intval( empty($_GET["start"]) ? @$args["start"] : $_GET["start"] );
$type             = empty($_GET["type"]) ? @$args["type"] : $_GET["type"];
$sort             = empty($_GET["sort"]) ? @$args["sort"] : $_GET["sort"];
$order            = in_array( $order = strtoupper( empty($_GET["order"]) ? @$args["order"] : $_GET["order"] ), array_keys($valid_orders) ) ? $order : "DESC" ;


/*
 * Instantiate category object and check access permissions
 */
$tracks_extra = array();
$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
if (!empty($topic_id)) {
    $topic_handler =& xoops_getmodulehandler("topic", $GLOBALS["artdirname"]);
    $topic_obj =& $topic_handler->get($topic_id);
    $category_id = $topic_obj->getVar("cat_id");
    $tracks_extra[] = array(
                            "title"    => $topic_obj->getVar("top_title"),
                            "link"    => XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.topic.php" . URL_DELIMITER . $topic_id
                            );
}
if (!empty($category_id)) {
    $category_obj =& $category_handler->get($category_id);
    if (!$category_handler->getPermission($category_obj, "access")) {
        redirect_header(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/index.php", 2, art_constant("MD_NOACCESS"));
    }
    $categories_id = array($category_id);
}

$tags = array("cat_title");
if ( !empty($uid) ) {
    $tags[] = "cat_moderator";
}
if ( !$categories_obj = $category_handler->getAllByPermission("access", $tags) ) {
    redirect_header("index.php", 2, art_constant("MD_NOACCESS"));
}
$categories_id = empty($categories_id) ? array_keys($categories_obj) : $categories_id;

/*
 * Instantiate user object
 */
if (!empty($category_obj)) {
    $xoopsuser_is_admin = art_isAdministrator() || art_isModerator($category_obj);
} else {
    $xoopsuser_is_admin = art_isAdministrator();
}
$xoopsuser_is_author = false;
if ( !empty($uid) ) {
    if ( !empty($xoopsUser) && $uid == $xoopsUser->getVar("uid")) {
        $author_obj =& $xoopsUser;
        $xoopsuser_is_author = true;
    } else {
        $member_handler =& xoops_gethandler("member");
        $author_obj =& $member_handler->getUser($uid);
    }
    if ( empty($author_obj) || !$author_obj->isActive() ) {
        redirect_header(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/index.php", 2, art_constant("MD_INVALID"));
        exit();
    }
    $tracks_extra[] = array(
                            "title"    => $author_obj->getVar("uname"),
                            "link"    => XOOPS_URL . "/userinfo.php?uid={$uid}"
                            );
    
    unset($valid_types["s"]);
    $valid_types_author = array();
    if ($xoopsuser_is_author) {
        $valid_types_author = array(
            "c"        => art_constant("MD_CREATED"), 
            "m"        => art_constant("MD_SUBMITTED"), 
            "r"        => art_constant("MD_REGISTERED"), 
            );
    } elseif ($xoopsuser_is_admin) {
        $valid_types_author = array(
            "m"        => art_constant("MD_SUBMITTED"), 
            "r"        => art_constant("MD_REGISTERED"), 
            );
    }
    $valid_types = array_merge( $valid_types_author, $valid_types );
}

$type = in_array( $type, array_keys($valid_types) ) ? $type : "a" ;
$byCategory = true;
switch (strtolower($type)) {
        
    case "created":
    case "c":
        $art_criteria = new CriteriaCompo( new Criteria("art_time_submit", 0) );
        $art_criteria->add( new Criteria("cat_id", 0), "OR" );
        $byCategory = false;
        break;
        
    case "submitted":
    case "m":
        $art_criteria = new CriteriaCompo( new Criteria("art_time_publish", 0) );
        $art_criteria->add( new Criteria("art_time_submit", 0, ">") );
        $art_criteria->add( new Criteria("cat_id", 0, ">") );
        $byCategory = false;
        break;
        
    case "registered":
    case "r":
        $art_criteria = new CriteriaCompo( new Criteria("ac.ac_publish", 0) );
        break;
        
    case "published":
    case "p":
        $art_criteria = new CriteriaCompo( new Criteria("ac.ac_publish", 0, ">") );
        $art_criteria->add( new Criteria("ac.ac_feature", 0) );
        break;
        
    case "featured":
    case "f":
        $art_criteria = new CriteriaCompo( new Criteria("ac.ac_feature", 0, ">") );
        break;
        
    case "spotlight":
    case "s":
        $art_criteria = new CriteriaCompo( new Criteria("art_id", 0, ">") );
        $type = "s";
        $_sort = $valid_sorts["id"];
        unset($valid_sorts);
        $valid_sorts = array( "id" => $_sort );
        $byCategory = false;
        break;
        
    default:
        $art_criteria = new CriteriaCompo(new Criteria("ac.ac_publish", 0, ">"));
        $type = "a";
        break;
}
$type_title = $valid_types[$type];

// Disable cache for author since we don't have proper cache handling way for them
if ($xoopsuser_is_author) {
    $xoopsConfig["module_cache"][$xoopsModule->getVar("mid")] = 0;
}
$xoopsOption["xoops_pagetitle"] =   $xoopsModule->getVar("name") . 
                                    ( empty($category_obj) ? "" : " - " . $category_obj->getVar("cat_title") ) . " - " . 
                                    ( empty($author_obj) ? "" : " - " . $author_obj->getVar("uname") ) . " - " . 
                                    art_constant("MD_LIST") . " - " . $type_title;
                                    
$xoopsOption["template_main"] = art_getTemplate("list", $xoopsModuleConfig["template"]);
$xoopsOption["xoops_module_header"] = art_getModuleHeader($xoopsModuleConfig["template"]);
include_once XOOPS_ROOT_PATH . "/header.php";
include XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";

$article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);

if (!empty($uid)) {
    $art_criteria->add( new Criteria( ( ($byCategory) ? "a." : "" ) . "uid", $uid) );
}
$sort = in_array( $sort, array_keys($valid_sorts) ) ? $sort : "id" ;

$sp_data = array();
$articles_id = array();
if ($type == "s") {
    $spotlight_handler =& xoops_getmodulehandler("spotlight", $GLOBALS["artdirname"]);
    $articles_count = $spotlight_handler->getCount($art_criteria);    
    $art_criteria->setSort($valid_sorts[$sort]["key"]);
    $art_criteria->setOrder($order);
    $art_criteria->setStart($start);
    $art_criteria->setLimit($xoopsModuleConfig["articles_perpage"]);
    $spotlights_obj = $spotlight_handler->getAll($art_criteria, array("art_id", "sp_image", "sp_note", "sp_time"));
    foreach (array_keys($spotlights_obj) as $sid) {
        $articles_id[$spotlights_obj[$sid]->getVar("art_id")] = 1;
        $sp_data[$spotlights_obj[$sid]->getVar("art_id")] = array(
            "id"        => $spotlights_obj[$sid]->getVar("art_id"),
            //"image"        => $spotlights_obj[$sid]->getImage(),
            "time"        => $spotlights_obj[$sid]->getTime($xoopsModuleConfig["timeformat"]),
            "sp_note"    => $spotlights_obj[$sid]->getVar("sp_note")
            );
    }
    $articles_id = array_keys($articles_id);
} elseif ($byCategory) {
    $articles_count = $article_handler->getCountByCategory($categories_id, $art_criteria);    
    $art_criteria->setSort($valid_sorts[$sort]["key"]);
    $art_criteria->setOrder($order);
    $articles_id = $article_handler->getIdsByCategory($categories_id, $xoopsModuleConfig["articles_perpage"], $start, $art_criteria);
} else {
    $art_criteria->add( new Criteria("cat_id", "(" . implode(", ", $categories_id) . ")", "IN") );
    $articles_count = $article_handler->getCount($art_criteria);    
    $art_criteria->setSort($valid_sorts[$sort]["key"]);
    $art_criteria->setOrder($order);
    $art_criteria->setLimit($xoopsModuleConfig["articles_perpage"]);
    $art_criteria->setStart($start);
    $articles_id = $article_handler->getIds($art_criteria);
}
unset($art_criteria);

if (count($articles_id) > 0) {
    $art_criteria = new Criteria("art_id", "(" . implode(", ", $articles_id) . ")", "IN");
    $tags = array("uid", "writer_id", "art_title", "art_image", "art_pages", "art_categories", "art_time_publish", "art_counter");
    if (!empty($xoopsModuleConfig["display_summary"])) {
        $tags[] = "art_summary";
    }
    if (!empty($valid_sorts[$sort]["tag"]) && !in_array($valid_sorts[$sort]["tag"], $tags)) {
        $tags[] = $valid_sorts[$sort]["tag"];
    } elseif (!in_array($valid_sorts[$sort]["key"], $tags)) {
        $tags[] = $valid_sorts[$sort]["key"];
    }
    $articles_obj = $article_handler->getAll($art_criteria, $tags);
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
foreach ($articles_id as $id) {
    $article =& $articles_obj[$id];
    $_article = array(
        "id"        => $id,
        "title"        => $articles_obj[$id]->getVar("art_title"),
        "author"    => @$users[$articles_obj[$id]->getVar("uid")],
        "writer"    => @$writers[$articles_obj[$id]->getVar("writer_id")],
        "time"        => $articles_obj[$id]->getTime($xoopsModuleConfig["timeformat"]),
        "counter"    => $articles_obj[$id]->getVar("art_counter"),
        "image"        => $articles_obj[$id]->getVar("art_image") ? 1 : 0,
        "summary"    => $article->getSummary( !empty($xoopsModuleConfig["display_summary"]) )
    );
    if ( in_array($sort, array("comments", "trackbacks")) ) {
        $_article[$sort] = $articles_obj[$id]->getVar($valid_sorts[$sort]["key"]);
    }
    if ( $sort == "rating" ) {
        $_article[$sort] = $articles_obj[$id]->getRatingAverage() . "/" .  intval( $articles_obj[$id]->getVar("art_rates") );
    }
    if (empty($category_id)) {
        $cats = $article->getCategories();
        if (count($cats)>0) foreach($cats as $catid) {
            if ($catid==0 || !isset($categories_obj[$catid])) continue;
            $_article["categories"][$catid] = array( "id" => $catid, "title" => $categories_obj[$catid]->getVar("cat_title") );
        }
    }
    $articles[$id] = $_article;
    unset($_article);
}

if (count($sp_data)>0) {
    foreach (array_keys($articles) as $i) {
        $articles[$i]["note"] = $sp_data[$i]["sp_note"];
        $articles[$i]["time"] = $sp_data[$i]["time"];
    }
}

// The author's profile
if (!empty($author_obj)):

if ( $author_obj->getVar("user_avatar") != "blank.gif" && file_exists(XOOPS_ROOT_PATH . "/uploads/" . $author_obj->getVar("user_avatar")) ) {
    $avatar = XOOPS_URL . "/uploads/" . $author_obj->getVar("user_avatar");
} else {
    $avatar = "";
}
$author = array(
    "uid"        => $uid,
    "avatar"    => $avatar,
    "uname"        => $author_obj->getVar("uname")
);

xoops_loadLanguage("user");
if ($author_obj->getVar("name")) {
    $author["profiles"][] = array(
                            "title"        => _US_REALNAME, 
                            "content"    => $author_obj->getVar("name"));
}
if ($author_obj->getVar("url")) {
    $author["profiles"][] = array(
                            "title"        => _US_WEBSITE, 
                            "content"    => $author_obj->getVar("url"));
}
if ($author_obj->getVar("user_viewemail") || (!empty($xoopsUser) && $xoopsUser->isAdmin())) {
    $author["profiles"][] = array(
                            "title"        => _US_EMAIL, 
                            "content"    => checkEmail($author_obj->getVar("email"), true));
}
if ($author_obj->getVar("bio")) {
    $author["profiles"][] = array(
                            "title"        => _US_EXTRAINFO, 
                            "content"    => $author_obj->getVar("bio"));
}

if (empty($start)) {
    $criteria = new CriteriaCompo( new Criteria("art_time_publish", 0, ">") );
    $criteria->add( new Criteria("uid", $uid) );
    $count_articles = $article_handler->getCount($criteria);
    unset($criteria);
    
    $criteria = new CriteriaCompo( new Criteria("a.uid", intval($uid)) );
    $criteria->add( new Criteria("ac.ac_feature", 0, ">") );
    $count_featured = $article_handler->getCountByCategory($categories_id, $criteria);
    unset($criteria);
    
    $criteria = new CriteriaCompo( new Criteria("uid", $uid) );
    $count_topic = $article_handler->getCountByTopic($uid, $criteria);
    unset($criteria);
    
    $mods = array();
    if ($xoopsuser_is_admin) {
        $mods[] = array(
            "url"    => XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/",
            "title"    => $xoopsModule->getVar("name")
        );
    }
    foreach ($categories_obj as $id => $cat_obj) {
        if (!@in_array($uid, $cat_obj->getVar("cat_moderator"))) continue;
        $mods[] = array(
            "url"=>XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.category.php" . URL_DELIMITER . $id,
            "title"=>$cat_obj->getVar("cat_title")
        );
    }
    $author["mods"] = $mods;
    $author["stats"] = array(
                    "articles"    => $count_articles, 
                    "featured"    => $count_featured, 
                    "topics"    => $count_topic);
}
endif;
// End of author profile

$pagequery =    
    ( !empty($topic_id) ? "t{$topic_id}/" :  ( !empty($category_id) ? "c{$category_id}/" : "" ) ) .
    ( empty($uid) ? "" : "u{$uid}/" );

if ( $articles_count > $xoopsModuleConfig["articles_perpage"]) {
    include XOOPS_ROOT_PATH . "/class/pagenav.php";
    $_query = $pagequery.
        ( empty($uid) ? "" : "u{$uid}/" ).
        ( empty($type) ? "a/" : "{$type}/" ).
        ( empty($sort) ? "id" : "{$sort}/" ).
        ( empty($order) ? "" : "{$order}/" );
    
    $nav = new XoopsPageNav($articles_count, $xoopsModuleConfig["articles_perpage"], $start, "start", $pagequery);
    $pagenav = $nav->renderNav(4);
} else {
    $pagenav = "";
}

$link_options = array();
$basic_link = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.list.php" . URL_DELIMITER . $pagequery;
foreach ($valid_types as $val => $name) {
    if ($val == $type) {
        $link_options["type"][] = $name;
    } else {
        $link_options["type"][] = "<a href=\"{$basic_link}{$val}\">{$name}</a>";
    }
}

$basic_link .= ( empty($type) ? "a/" : "{$type}/" );
foreach ($valid_sorts as $val => $_sort) {
    if ($val == $sort) {
        $link_options["sort"][] = $_sort["title"];
    } else {
        $link_options["sort"][] = "<a href=\"{$basic_link}{$val}\">{$_sort['title']}</a>";
    }
}

$basic_link .= ( empty($sort) ? "id/" : "{$sort}/" );
foreach ($valid_orders as $val => $name) {
    if ($val == $order) {
        $link_options["order"][] = $name;
    } else {
        $link_options["order"][] = "<a href=\"{$basic_link}{$val}\">{$name}</a>";
    }
}

$i = 0;
$page_meta = array();
if ( !empty($author_obj) ):
$i++;
$page_meta[$i] = array(
                        "title"    => $author_obj->getVar("uname"), 
                         "link"    => XOOPS_URL . "/userinfo.php?uid={$uid}" );
endif;
$i++;
$page_meta[$i] = array(
                        "title"    => art_constant("MD_LIST"), 
                         "link"    => XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.list.php" . URL_DELIMITER . $pagequery );
$i++;
$page_meta[$i] = array(
                        "title"    => $type_title, 
                         "link"    => $page_meta[($i - 1)]["link"] . ( empty($type) ? "a/" : "{$type}/" ) );
if ($sort != "id"):
$i++;
$page_meta[$i] = array(
                        "title"    => sprintf(art_constant("MD_SORTORDER"), $valid_sorts[$sort]["title"], $valid_orders[$order]), 
                         "link"    => $page_meta[($i - 1)]["link"] . "{$sort}/{$order}/" );
endif;

$xoopsTpl -> assign("modulename", $xoopsModule->getVar("name"));
$xoopsTpl -> assign_by_ref("articles", $articles);
$xoopsTpl -> assign_by_ref("author", $author);

if (!empty($category_obj)) {
    $xoopsTpl -> assign("tracks", $category_handler->getTrack($category_obj, true));
}
$xoopsTpl -> assign_by_ref("tracks_extra", $tracks_extra);
$xoopsTpl -> assign_by_ref("page_meta", $page_meta);
$xoopsTpl -> assign_by_ref("options", $link_options);
$xoopsTpl -> assign_by_ref("pagenav", $pagenav);

// Loading module meta data, NOT THE RIGHT WAY DOING IT
$xoopsTpl -> assign("xoops_module_header", $xoopsOption["xoops_module_header"]);
$xoopsTpl -> assign("xoops_pagetitle", $xoopsOption["xoops_pagetitle"]);

include_once "footer.php";
?>