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
 * @version         $Id: blocks.article.php 2283 2008-10-12 03:36:13Z phppp $
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
 * Function to display articles
 *
 * {@link article} 
 * {@link xcategory} 
 * {@link permission} 
 * {@link config} 
 *
 * @param    array     $options: 
 *                        0 - criteria for fetching articles; 
 *                        1 - limit for article count; 
 *                        2 - bool flag for displaying summary: 0 - none; 1 - summary; 2 - summary and image
 *                        3 - title length; 
 *                        4 - time format; 
 *                        5 - allowed categories; 
 */
function [VAR_PREFIX]_article_show($options)
{
    global $xoopsDB;
    static $access_cats;

    $artConfig = art_load_config();
    art_define_url_delimiter();

    $block = array();
    $select = "art_id";
    $disp_tag = "";
    $from = "";
    $where = "";
    $order = "art_time_publish DESC";
    switch ($options[0]) {
        case "views":
            $select .= ", art_counter";
            $order = "art_counter DESC";
            $disp_tag = "art_counter";
            break;
        case "rates":
            $select .= ", art_rates";
            $order = "art_rates DESC";
            $disp_tag = "art_rates";
            break;
        case "rating":
            $select .= ", art_rating/art_rates AS ave_rating";
            $order = "ave_rating DESC";
            $disp_tag = "ave_rating";
            break;
        case "random":
            $order = "RAND()";
            $mysqlOldClient = version_compare( mysql_get_server_info(), "4.1.0", "lt" );
            /* for MySQL 4.1+ */
            if (!$mysqlOldClient) {
                $from = " LEFT JOIN (SELECT art_id AS aid FROM " . art_DB_prefix("article") . " LIMIT 1000 ORDER BY art_id DESC) AS random ON art_id = random.aid";
            }
            break;
        case "time":
        default:
            $order = "art_time_publish DESC";
            $disp_tag = "art_counter";
            break;
    }
    $select .= ", cat_id, art_title, uid, writer_id, art_time_publish";
    if (!empty($options[2])) {
        $select .= ", art_summary, art_pages";
        if ($options[2] == 2) $select .= ", art_image";
    }
    if (!isset($access_cats)) {
        $permission_handler =& xoops_getmodulehandler("permission", $GLOBALS["artdirname"]);
        $access_cats = $permission_handler->getCategories("access");
    }
    if (!empty($options[5])) {
        $allowed_cats = array_filter(array_slice($options, 5));
    } else {
        $allowed_cats = $access_cats;
    }
    $allowed_cats = array_intersect($allowed_cats, $access_cats);
    
    if (count($allowed_cats) ==0 ) {
        return $block;
    }

    $query = "SELECT {$select} FROM " . art_DB_prefix("article") . $from;
    $query .= " WHERE cat_id IN (" . implode(",", $allowed_cats) . ") AND art_time_publish > 0 " . $where;
    $query .= " ORDER BY " . $order;
    if (!$result = $xoopsDB->query($query, $options[1], 0)) {
        //xoops_error($xoopsDB->error());
        return $block;
    }
    
    $author_array = array();
    $writer_array = array();
    $users = array();
    $writers = array();
    $rows = array();
    while ($row = $xoopsDB->fetchArray($result)) {
        $rows[] = $row;
        $author_array[$row["uid"]] = 1;
        $writer_array[$row["writer_id"]] = 1;
    }
    if (count($rows) < 1) return $block;
    
    if (!empty($author_array)) {
        include_once XOOPS_ROOT_PATH . "/modules/" . $GLOBALS["artdirname"] . "/include/functions.author.php";
        $users = art_getAuthorNameFromId(array_keys($author_array), true, true);
    }
    
    if (!empty($writer_array)) {
        include_once XOOPS_ROOT_PATH . "/modules/" . $GLOBALS["artdirname"] . "/include/functions.author.php";
        $writers = art_getWriterNameFromIds(array_keys($writer_array));
    }

    $arts = array();
    $uids = array();
    $cids = array();
    $article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
    foreach ($rows as $row) {
        if (!empty($row["ave_rating"])) {
            $row["ave_rating"] = number_format($row["ave_rating"], 1);
        }
        $article =& $article_handler->create(false);
        $article->assignVars($row);
        $_art = array();
        foreach ($row as $tag => $val) {
            $_art[$tag] = @$article->getVar($tag);
        }
        $_art["author"] = $users[$row["uid"]];
        $_art["writer"] = @$writers[$row["writer_id"]];
        $_art["time"] = $article->getTime($options[4]);
        $_art["summary"] = $article->getSummary($options[2]);
        $_art["image"] = $article->getImage();
        if (!empty($disp_tag)) {
            $_art["disp"] = @$article->getVar($disp_tag);
            if (!empty($row[$disp_tag]) && empty($_art["disp"])) {
                $_art["disp"] = $row[$disp_tag];
            }
        }
        if (!empty($options[3])) {
            $_art["art_title"] = xoops_substr($_art["art_title"], 0, $options[3]);
        }
        $arts[] = $_art;
        unset($article, $_art);
        $cids[$row["cat_id"]] = 1;
    }
    
    $category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
    $criteria = new Criteria("cat_id", "(" . implode(",",array_keys($cids)) . ")", "IN");
    $cats = $category_handler->getList($criteria);

    for ($i = 0; $i < count($arts); $i++) {
        $arts[$i]["category"]=$cats[$arts[$i]["cat_id"]];
    }
    $block["articles"] = $arts;
    unset($users, $cats, $arts);

    $block["dirname"] = $GLOBALS["artdirname"];
    return $block;
}

function [VAR_PREFIX]_article_edit($options)
{
    $form = art_constant("MB_TYPE") . "&nbsp;&nbsp;<select name=\"options[0]\">";
    $form .= "<option value=\"time\"";
    if ($options[0] == "time") $form .= " selected=\"selected\" ";
    $form .= ">" . art_constant("MB_TYPE_TIME") . "</option>\n";
    $form .= "<option value=\"views\"";
    if ($options[0] == "views") $form .= " selected=\"selected\" ";
    $form .= ">" . art_constant("MB_TYPE_VIEWS") . "</option>\n";
    $form .= "<option value=\"rates\"";
    if ($options[0] == "rates") $form .= " selected=\"selected\" ";
    $form .= ">" . art_constant("MB_TYPE_RATES") . "</option>\n";
    $form .= "<option value=\"rating\"";
    if ($options[0] == "rating") $form .= " selected=\"selected\" ";
    $form .= ">" . art_constant("MB_TYPE_RATING") . "</option>\n";
    $form .= "<option value=\"random\"";
    if ($options[0] == "random") $form .= " selected=\"selected\" ";
    $form .= ">" . art_constant("MB_TYPE_RANDOM") . "</option>\n";
    $form .= "</select><br /><br />";

    $form .= art_constant("MB_ITEMS") . "&nbsp;&nbsp;<input type=\"text\" name=\"options[1]\" value=\"" . $options[1] . "\" /><br /><br />";

    $form .= art_constant("MB_SHOWSUMMARY") . "&nbsp;&nbsp;<input type=\"radio\" name=\"options[2]\" value=\"0\"";
    if ($options[2] == 0) $form .= " checked=\"checked\"";
    $form .= " />" . _NO . "&nbsp;&nbsp;<input type=\"radio\" name=\"options[2]\" value=\"1\"";
    if ($options[2] == 1) $form .= " checked=\"checked\"";
    $form .= " />" . _YES . "&nbsp;&nbsp;<input type=\"radio\" name=\"options[2]\" value=\"2\"";
    if ($options[2] == 2) $form .= " checked=\"checked\"";
    $form .= " />" . art_constant("MB_SUMMARY_IMAGE") . "<br /><br />";

    $form .= art_constant("MB_TITLE_LENGTH") . "&nbsp;&nbsp;<input type=\"text\" name=\"options[3]\" value=\"" . $options[3] . "\" /><br /><br />";
    
    $form .= art_constant("MB_TIMEFORMAT") . "&nbsp;&nbsp;<input type=\"text\" name=\"options[4]\" value=\"" . $options[4] . "\" /><br />";
    
    xoops_load("xoopslocal");
    $form .= "<p style=\"font-size: small; padding-left: 10px;\">" . XoopsLocal::getTimeFormatDesc() . "</p>";
    
    $category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
    $isAll = empty($options[5]) ? true : false;
    $options_cat = array_slice($options, 5); // get allowed categories
    
    $form ."<br />";
    $form .= art_constant("MB_CATEGORYLIST") . "<br /><select name=\"options[]\" multiple=\"multiple\">";
    $form .= "<option value=\"0\" ";
    if ($isAll) $form .= " selected=\"selected\"";
    $form .= ">" . _ALL . "</option>";
    
    $categories = $category_handler->getTree(0, "moderate", "----");
    foreach ($categories as $id => $cat) {
        $sel = ($isAll || in_array($id, $options_cat)) ? " selected" : "";
        $form .= "<option value=\"{$id}\" {$sel}>" . $cat["prefix"] . $cat["cat_title"] . "</option>";
    }
    $form .= "</select><br />";

    return $form;
}
/**#@-*/
');
?>