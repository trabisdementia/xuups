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
 * @version         $Id: blocks.news.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

include dirname(dirname(__FILE__)) . "/include/vars.php";
mod_loadFunctions("parse", $GLOBALS["artdirname"]);

/**
 * Functions handling module blocks 
 * @package module::article
 *
 * @author  D.J. (phppp)
 * @copyright copyright &copy; 2000 The XOOPS Project
 *
 * @param VAR_PREFIX variable prefix for the function name
 */

art_parse_function('

/**#@+
 * Function to display news item: spotlight + recent news
 *
 * {@link spotlight} 
 * {@link config} 
 *
 * @param    array     $options:  
 *                        0 - display mode: 0 - compact title list; 1 sorted by categories 
 *                        1 - limit for article count; 
 *                        2 - title length; 
 *                        3 - time format; 
 *                        4 - allowed categories; 
 */
function [VAR_PREFIX]_block_news_show( $options )
{
    global $xoopsDB;
    static $access_cats;
    $block = array();
    
    if (!isset($access_cats)) {
        $permission_handler =& xoops_getmodulehandler("permission", $GLOBALS["artdirname"]);
        $access_cats = $permission_handler->getCategories("access");
    }
    if (!empty($options[4])) {
        $allowed_cats = array_filter(array_slice($options, 4));
    } else {
        $allowed_cats = $access_cats;
    }
    $allowed_cats = array_intersect($allowed_cats, $access_cats);
    
    if ( count($allowed_cats) == 0 ) {
        return $block;
    }
    
    mod_loadFunctions("url", $GLOBALS["artdirname"]);
    
    $spotlight_handler =& xoops_getmodulehandler("spotlight", $GLOBALS["artdirname"]);
    $sp_data = $spotlight_handler->getContent(false);
    foreach ($sp_data as $key => $val) {
        $block["spotlight"][$key] = $val;
    }
    $block["spotlight"]["url"] = art_buildUrl(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.article.php", array("article" => $block["spotlight"]["art_id"]));
    
    mod_loadFunctions("author", $GLOBALS["artdirname"]);
    $users = art_getAuthorNameFromId($sp_data["uid"], true, true);
    $block["spotlight"]["author"] = $users[$sp_data["uid"]] ;
    if (!empty($sp_data["writer_id"])) {
        $writers = art_getWriterNameFromIds($sp_data["writer_id"]);
        $block["spotlight"]["writer"] = $writers[$sp_data["writer_id"]] ;
    }
    
    $category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
    
    if (empty($options[0])):
    
    $sql =     "    SELECT art_id, art_title, art_time_publish, cat_id, ( art_comments + art_trackbacks ) AS comments " .
            "    FROM " . art_DB_prefix("article") .
            "    WHERE cat_id IN (" . implode(",", $allowed_cats) . ") " .
            "        AND art_time_publish >0 " .
            "    ORDER BY art_time_publish DESC";
    if (!$result = $xoopsDB->query($sql, $options[1], 0)) {
        //xoops_error($xoopsDB->error());
        return $block;
    }
    
    mod_loadFunctions("time", $GLOBALS["artdirname"]);
    $articles = array();
    $cids = array();
    while ($row = $xoopsDB->fetchArray($result)) {
        $_art = array();
        $_art["title_full"]    = htmlspecialchars($row["art_title"]);
        $_art["title"]        = $row["art_title"];
        $_art["time"]        = art_formatTimestamp($row["art_time_publish"], $options[3]);
        $_art["comments"]    = $row["comments"];
        $_art["category"]    = $row["cat_id"];
        $_art["url"]         = art_buildUrl(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.article.php", array("article" => $row["art_id"]));
        
        $articles[$row["art_id"]] = $_art;
        $cids[$row["cat_id"]] = 1;
    }
    
    $criteria = new CriteriaCompo( new Criteria("cat_id", "(" . implode(",", array_keys($cids)) . ")", "IN") );
    $criteria_top = new CriteriaCompo( new Criteria("cat_id", "(" . implode(",", $allowed_cats) . ")", "IN") ); 
    $criteria_top->add( new Criteria("cat_pid", 0) );
    $criteria->add( $criteria_top, "OR" );
    $criteria->setSort("cat_order");
    $categories_obj = $category_handler->getAll($criteria, array("cat_title", "cat_pid"));

    foreach (array_keys($articles) as $id) {
        $articles[$id]["title"] = "[" . $categories_obj[$articles[$id]["category"]]->getVar("cat_title", "n") . "] " . $articles[$id]["title"];
        if (!empty($options[2])) {
            $articles[$id]["title"] = xoops_substr($articles[$id]["title"], 0, $options[2]);
        }
        $articles[$id]["title"] = htmlspecialchars($articles[$id]["title"]);
    }
    
    $categories = array();
    foreach (array_keys($categories_obj) as $cid) {
        if($categories_obj[$cid]->getVar("cat_pid")) continue;
        $categories[$cid]["title"]    = $categories_obj[$cid]->getVar("cat_title");
        $categories[$cid]["url"]    = art_buildUrl(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.category.php", array("category" => $cid));
    }
    $block["articles"] = $articles;
    $block["categories"] = $categories;
    
    else:
    
    $articles_id = array();
    $criteria = new Criteria("cat_id", "(" . implode(",", $allowed_cats) . ")", "IN");
    $criteria->setSort("cat_order");
    $categories_obj = $category_handler->getAll($criteria, array("cat_title", "cat_lastarticles"));
    
    foreach (array_keys($categories_obj) as $id) {
        if (!$articles_category = $category_handler->getLastArticleIds($categories_obj[$id], $options[1])) continue;
        $articles_id = array_merge($articles_id, $articles_category);
    }
    
    if ( count($articles_id) ==0 ) {
        return $block;
    }
    
    $sql =     "    SELECT art_id, art_title, art_time_publish, ( art_comments + art_trackbacks ) AS comments " .
            "    FROM " . art_DB_prefix("article") .
            "    WHERE art_id IN (" . implode(",", array_unique($articles_id)) . ") ";
    if (!$result = $xoopsDB->query($sql)) {
        //xoops_error($xoopsDB->error());
        return $block;
    }
    
    $articles = array();
    while ($row = $xoopsDB->fetchArray($result)) {
        $_art = array();
        $_art["title_full"]    = htmlspecialchars($row["art_title"]);
        if (!empty($options[2])) {
            $row["art_title"] = xoops_substr($row["art_title"], 0, $options[2]);
        }
        $_art["title"]        = htmlspecialchars($row["art_title"]);
        $_art["time"]        = art_formatTimestamp($row["art_time_publish"], $options[3]);
        $_art["comments"]    = $row["comments"];
        $_art["url"]         = art_buildUrl(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.article.php", array("article" => $row["art_id"]));
        $articles[$row["art_id"]] = $_art;
    }
    
    $categories = array();
    foreach (array_keys($categories_obj) as $id) {
        $category =& $categories_obj[$id];
        $cat = array(
            "id"                 => $id,
            "title"             => $category->getVar("cat_title"),
            "image"             => $category->getImage(),
            "url"                 => art_buildUrl(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.category.php", array("category" => $id)),
            "articles"            => array(),
        );
        $articles_category_id = $category_handler->getLastArticleIds($category, $options[1]);
        foreach ($articles_category_id as $art_id) {
            if (!isset($articles[$art_id])) continue;
            $cat["articles"][] =& $articles[$art_id];
        }
        $categories[$id] = $cat;
        unset($cat);
    }
    $block["categories"] =& $categories;
    
    endif;
        
    $block["lang"]         = array(
                                "categories"    => art_constant("MB_CATEGORIES"), 
                                "articles"        => art_constant("MB_ARTICLES"),
                                "comments"        => art_constant("MB_COMMENTS"),
                                "views"            => art_constant("MB_VIEWS"),
                                );
    $block["mode"]         = $options[0];
    $block["dirname"]    = $GLOBALS["artdirname"];
    return $block;
}


function [VAR_PREFIX]_block_news_edit($options)
{
    $form = art_constant("MB_DISPLAY_MODE")."&nbsp;&nbsp;<input type=\"text\" name=\"options[0]\" value=\"" . $options[0] . "\" /><br />";
    $form .= art_constant("MB_ITEMS")."&nbsp;&nbsp;<input type=\"text\" name=\"options[1]\" value=\"" . $options[1] . "\" /><br />";
    $form .= art_constant("MB_TITLE_LENGTH")."&nbsp;&nbsp;<input type=\"text\" name=\"options[2]\" value=\"" . $options[2] . "\" /><br />";
    $form .= art_constant("MB_TIMEFORMAT")."&nbsp;&nbsp;<input type=\"text\" name=\"options[3]\" value=\"" . $options[3] . "\" />";
    
    xoops_load("xoopslocal");
    $form .= "<p style=\"font-size: small; padding-left: 10px;\">" . XoopsLocal::getTimeFormatDesc() . "</p>";
    
    $category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
    $isAll = empty($options[4]);
    $options_cat = array_slice($options, 4); // get allowed categories
    
    $form .= art_constant("MB_CATEGORYLIST") . "<br /><select name=\"options[]\" multiple=\"multiple\">";
    $form .= "<option value=\"0\" ";
    if ($isAll) $form .= " selected=\"selected\"";
    $form .= ">" . _ALL . "</option>";
    
    $categories = $category_handler->getTree(0, "moderate", "----");
    foreach ($categories as $id => $cat) {
        $sel = ( $isAll || in_array($id, $options_cat) ) ? " selected" : "";
        $form .= "<option value=\"{$id}\" {$sel}>" . $cat["prefix"] . $cat["cat_title"] . "</option>";
    }
    $form .= "</select><br />";

    return $form;
}
');
?>