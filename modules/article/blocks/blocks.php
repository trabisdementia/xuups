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
 * @version         $Id: blocks.php 2178 2008-09-26 08:34:09Z phppp $
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

/**#@-*/

/**#@+
 * Function to display spotlight
 *
 * {@link spotlight} 
 * {@link config} 
 *
 * @param    array     $options:  
 *                    $options[0] - use specified spotlight only
 *                    $options[1] - show editor note if available
 */
function [VAR_PREFIX]_spotlight_show( $options )
{
    global $xoopsDB;

    $block = array();
    $artConfig = art_load_config();
    art_define_url_delimiter();
    
    $spotlight_handler =& xoops_getmodulehandler("spotlight", $GLOBALS["artdirname"]);
    $sp_data = $spotlight_handler->getContent(false, $options[0]);
    if (empty($sp_data)) return $block;
    foreach ($sp_data as $key => $val) {
        $block[$key] = $val;
    }
    if (isset($block["sp_note"]) && empty($optioins[1])) unset($block["sp_note"]);
    
    $block["url"] = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.article.php" . URL_DELIMITER . $sp_data["art_id"];
    
    include_once XOOPS_ROOT_PATH . "/modules/" . $GLOBALS["artdirname"] . "/include/functions.author.php";
    $users = art_getAuthorNameFromId($sp_data["uid"], true, true);
    $block["author"] = $users[$sp_data["uid"]] ;
    if (!empty($sp_data["writer_id"])) {
        $writers = art_getWriterNameFromIds($sp_data["writer_id"]);
        $block["writer"] = $writers[$sp_data["writer_id"]] ;
    }
    
    $block["lang_author"] = art_constant("MB_AUTHOR");
    $block["lang_time"] = art_constant("MB_TIME");
    return $block;
}


function [VAR_PREFIX]_spotlight_edit($options)
{

    $form = art_constant("MB_SPECIFIED_ONLY") . "&nbsp;&nbsp;<input type=\"radio\" name=\"options[0]\" value=\"1\"";
    if ($options[0] == 1) $form .= " checked=\"checked\"";
    $form .= " />" . _YES . "<input type=\"radio\" name=\"options[0]\" value=\"0\"";
    if ($options[0] == 0) $form .= " checked=\"checked\"";
    $form .= " />" . _NO.  "<br />";

    $form .= art_constant("MB_SHOW_NOTE") . "&nbsp;&nbsp;<input type=\"radio\" name=\"options[1]\" value=\"1\"";
    if ($options[1] == 1) $form .= " checked=\"checked\"";
    $form .= " />" . _YES . "<input type=\"radio\" name=\"options[1]\" value=\"0\"";
    if ($options[1] == 0) $form .= " checked=\"checked\"";
    $form .= " />"._NO."<br />";

    return $form;
}

/**#@-*/

/**#@+
 * Function to display categories
 *
 * {@link Xcategory} 
 * {@link config} 
 *
 * @param    array     $options (not used) 
 */
function [VAR_PREFIX]_category_show($options)
{
    art_define_url_delimiter();
    
    $block = array();
    $category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
    $categories = $category_handler->getTree();
    $cats_counts = $category_handler->getArticleCounts(array_keys($categories));
    foreach ($categories as $id => $cat) {
        $block["categories"][] = array(
                                    "cat_id"    => $id,
                                    "cat_title"    => $cat["prefix"].$cat["cat_title"], 
                                    "articles"    => @$cats_counts[$id]);
    }
    $block["dirname"] = $GLOBALS["artdirname"];
    unset($categories, $cats_stats);
    return $block;
}
/**#@-*/

/**#@+
 * Function to display topics
 *
 * {@link Xtopic} 
 * {@link Xcategory} 
 * {@link permission} 
 * {@link config} 
 *
 * @param    array     $options: 
 *                        0 - limit for topic count; 
 *                        1 - allowed categories; 
 */
function [VAR_PREFIX]_topic_show($options)
{
    global $xoopsDB;
    static $access_cats;

    art_define_url_delimiter();
    
    $block = array();
    if (!isset($access_cats)) {
        $permission_handler =& xoops_getmodulehandler("permission", $GLOBALS["artdirname"]);
        $access_cats = $permission_handler->getCategories("access"); // get all accessible categories
    }
    if (!empty($options[1])) {
        $allowed_cats = array_filter(array_slice($options, 1)); // get allowed cats
    } else {
        $allowed_cats = $access_cats;
    }
    $allowed_cats = array_intersect($allowed_cats, $access_cats);
    if ( count($allowed_cats) == 0 ) return $block;

    $query = "SELECT top_id, top_title, top_time, cat_id FROM " . art_DB_prefix("topic");
    $query .= " WHERE cat_id IN (" . implode(",", $allowed_cats) . ") ";
    $query .= " ORDER BY top_time DESC";
    $result = $xoopsDB->query($query, $options[0], 0);
    if (!$result) {
        //xoops_error($xoopsDB->error());
        return $block;
    }
    $tops = array();
    $cids = array();
    $topic_handler =& xoops_getmodulehandler("topic", $GLOBALS["artdirname"]);
    while ($row = $xoopsDB->fetchArray($result)) {
        $topic =& $topic_handler->create(false);
        $topic->assignVars($row);
        $_top = array();
        foreach ($row as $tag => $val) {
            $_top[$tag] = $topic->getVar($tag);
        }
        $_top["time"] = $topic->getTime();
        $tops[] = $_top;
        unset($topic, $_top);
        $cids[$row["cat_id"]] = 1;
    }

    $category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
    $criteria = new Criteria("cat_id", "(" . implode(",", array_keys($cids)) . ")", "IN");
    $cats = $category_handler->getList($criteria);

    for ($i = 0; $i < count($tops); $i++) {
        $tops[$i]["category"]=$cats[$tops[$i]["cat_id"]];
    }
    $block["topics"] = $tops;
    unset($cats, $tops);

    $block["dirname"] = $GLOBALS["artdirname"];
    return $block;
}

function [VAR_PREFIX]_topic_edit($options)
{
    $form = art_constant("MB_ITEMS") . "&nbsp;&nbsp;<input type=\"text\" name=\"options[0]\" value=\"" . $options[0] . "\" /><br /><br />";

    $category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
    $isAll = empty($options[1]);
    $options_cat = array_slice($options, 1); // get allowed categories
    
    $form .= art_constant("MB_CATEGORYLIST") . "&nbsp;&nbsp;<select name=\"options[]\" multiple=\"multiple\">";
    $form .= "<option value=\"0\" ";
    if ($isAll) $form .= " selected=\"selected\"";
    $form .= ">" . _ALL . "</option>";
    
    $categories = $category_handler->getTree(0, "moderate", "----");
    foreach ($categories as $id => $cat) {
        $sel = ($isAll || in_array($id, $options_cat)) ? " selected":"";
        $form .= "<option value=\"{$id}\" {$sel}>" . $cat["prefix"] . $cat["cat_title"] . "</option>";
    }
    $form .= "</select><br />";

    return $form;
}
/**#@-*/

/**#@+
 * Function to display authors
 *
 * {@link config} 
 *
 * @param    array     $options: 
 *                        0 - limit for author count; 
 */
function [VAR_PREFIX]_author_show($options)
{
    global $xoopsDB;
    
    $block = array();
    $artConfig = art_load_config();
    art_define_url_delimiter();

    $query = "SELECT COUNT(*) AS count, uid" .
        " FROM " . art_DB_prefix("article") .
        " WHERE art_time_publish>0 AND uid>0" .
        " GROUP BY uid ORDER BY count DESC";
    $result = $xoopsDB->query($query, $options[0], 0);
    if (!$result) {
        //xoops_error($xoopsDB->error());
        return $block;
    }
    $rows = array();
    $author = array();
    while ($row = $xoopsDB->fetchArray($result)) {
        $rows[] = $row;
        $author[$row["uid"]] = 1;
    }
    if (count($rows) < 1) return $block;
    mod_loadFunctions("user", $GLOBALS["artdirname"]);
    $author_name = art_getUnameFromId(array_keys($author));
    foreach ($rows as $row) {
        $block["authors"][] = array( "uid" => $row["uid"], "name" => $author_name[$row["uid"]], "articles" => $row["count"]);
    }
    $block["dirname"] = $GLOBALS["artdirname"];
    return $block;
}

function [VAR_PREFIX]_author_edit($options)
{
    $form = art_constant("MB_ITEMS") . "&nbsp;&nbsp;<input type=\"text\" name=\"options[0]\" value=\"" . $options[0] . "\" /><br /><br />";
    return $form;
}
/**#@-*/

');
?>