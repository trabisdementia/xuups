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
 * @version         $Id: search.inc.php 2283 2008-10-12 03:36:13Z phppp $
 */
 
if (!defined("XOOPS_ROOT_PATH")) { exit(); }

include dirname(__FILE__) . "/vars.php";
mod_loadFunctions("parse", $GLOBALS["artdirname"]);

art_parse_function('
function &[VAR_PREFIX]_search($queryarray, $andor, $limit, $offset, $userid, $categories = array(), $sortby = 0, $searchin = "all", $extra = "")
{
    global $xoopsDB, $xoopsConfig, $myts, $xoopsUser;
    $ret = array();

    art_define_url_delimiter();
    
    $uid = (is_object($xoopsUser) && $xoopsUser->isactive()) ? $xoopsUser->getVar("uid") : 0;
    $permission_handler =& xoops_getmodulehandler("permission", $GLOBALS["artdirname"]);
    $allowed_ids = $permission_handler->getCategories();
    if (count($categories) > 0) {
        $allowed_ids = array_intersect($allowed_ids, $categories);
    }    
    if (empty($allowed_ids)) {
        return $ret;
    }
    
    $searchin = empty($searchin) ? array("all") : (is_array($searchin) ? $searchin : array($searchin));
    if (in_array("all", $searchin) || count($searchin) == 0) {
        $searchin = array("title", "author", "keywords", "summary", "text", "subtitle");
    }
    
    $isFulltext = ($searchin == array("text"));
    
    /* Fulltext search */
    if ($isFulltext):
     $sql = "SELECT" .
            " DISTINCT t.text_id, t.text_body, a.art_id, a.art_title, a.uid, a.art_time_publish, a.art_pages";
    $sql .= " FROM" .
            " " . art_DB_prefix("text") . " AS t" .
            " LEFT JOIN " . art_DB_prefix("article") . " AS a ON a.art_id=t.art_id" .
            " LEFT JOIN " . art_DB_prefix("artcat") . " AS ac ON a.art_id=ac.art_id";
    /* regular search */
    else:
     $sql = "SELECT" .
            " DISTINCT a.art_id, a.art_title, a.uid, a.art_time_publish";
    $sql .= " FROM" .
            " " . art_DB_prefix("article") . " AS a" .
            " LEFT JOIN " . art_DB_prefix("artcat") . " AS ac ON a.art_id=ac.art_id";
    if (in_array("text", $searchin) || in_array("subtitle", $searchin)):
    $sql .= " LEFT JOIN " . art_DB_prefix("text") . " AS t ON t.art_id =a.art_id";
    endif;
    endif;
    
    $sql .= " WHERE" .
            " a.art_time_publish > 0" .
            " AND ac.cat_id IN (" . implode(",", $allowed_ids) . ")" .
            " AND ac.ac_publish > 0";

    if (is_array($userid) && count($userid) > 0) {
        $userid = array_map("intval", $userid);
        $sql .= " AND a.uid IN (" . implode(",", $userid) . ") ";
    }elseif ( is_numeric($userid) && $userid > 0 ) {
        $sql .= " AND a.uid=" . $userid . " ";
    }

    $count = count($queryarray);
    if ( is_array($queryarray) && $count > 0) {
        foreach($queryarray as $query){
            $query_array["title"][] = "a.art_title LIKE " . $xoopsDB->quoteString("%" . $query."%");
            //$query_array["author"][] = "a.art_author LIKE " . $xoopsDB->quoteString("%" . $query."%");
            $query_array["keywords"][] = "a.art_keywords LIKE " . $xoopsDB->quoteString("%" . $query . "%");
            $query_array["summary"][] = "a.art_summary LIKE " . $xoopsDB->quoteString("%" . $query . "%");
            $query_array["text"][] = "t.text_body LIKE " . $xoopsDB->quoteString("%" . $query . "%");
            $query_array["subtitle"][] = "t.text_title LIKE " . $xoopsDB->quoteString("%" . $query . "%");
        }
        foreach ($query_array as $term => $terms) {
            $querys[$term] = "(" . implode(" $andor ", $terms) . ")";
        }
        foreach ($searchin as $term) {
            if (empty($query_array[$term])) continue;
            $query_term[] = $querys[$term];
        }
        $sql .= " AND (" . implode(" OR ", $query_term) . ") ";
    }

    if (empty($sortby)) {
        $sortby = "a.art_id DESC";
    }
    $sql .= $extra . " ORDER BY " . $sortby;
    
    if (!$result = $xoopsDB->query($sql, $limit, $offset)) {
        //xoops_error($xoopsDB->error());
        return $ret;
    }
    $_ret = array();
    $users = array();
    $arts = array();
    mod_loadFunctions("time", $GLOBALS["artdirname"]);
    while ($myrow = $xoopsDB->fetchArray($result)) {
        if (empty($isFulltext)):
        $ret[] = array(
            "link"        => "view.article.php" . URL_DELIMITER . $myrow["art_id"],
            "title"        => $myrow["art_title"],
            "time"        => $myrow["art_time_publish"],
            "uid"        => $myrow["uid"],
            "art_title"    => $myts->htmlSpecialChars($myrow["art_title"]),
            "art_time"    => art_formatTimestamp($myrow["art_time_publish"])
        );
        else:
        $_ret[] = $myrow;
        endif;
        $users[$myrow["uid"]] = 1;
    }
    
    if (!empty($isFulltext)):
    $article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
    xoops_load("xoopslocal");
    foreach ($_ret as $myrow) {
        $article_obj =& $article_handler->create(false);
        $article_obj->assignVars($myrow);
        $page = array_search($myrow["text_id"], $article_obj->getPages());
        $text = $myts->htmlSpecialChars($myrow["text_body"]);
        
        /* 
         * "Fulltext search"/highlight needs better formulize
         * 
         */
        $sanitized_text = "";
        $text_i = strtolower($text);
        foreach ($queryarray as $query) {
            $pos        = xoops_local("strpos", $text_i, strtolower($query));
            $start        = max(($pos - 100), 0);
            $length        = xoops_local("strlen", $query) + 200;
            $context    = preg_replace("/(" . preg_quote($query) . ")/si", "<span class=\"article-highlight\">$1</span>", xoops_substr($text, $start, $length, " [...]"));
            $sanitized_text .= "<p>[...] " . $context . "</p>";
        }
        
        $ret[] = array(
            "link"        => "view.article.php" . URL_DELIMITER . $myrow["art_id"] . "/p" . intval($page),
            "title"        => $myrow["art_title"],
            "time"        => $myrow["art_time_publish"],
            "uid"        => $myrow["uid"],
            "art_title"    => $article_obj->getVar("art_title"),
            "art_time"    => $article_obj->getTime(),
            "text"        => $sanitized_text
        );
        unset($article_obj, $page, $sanitized_text, $matches);
    }
    endif;    
    
    mod_loadFunctions("user", $GLOBALS["artdirname"]);
    $users = art_getUnameFromId(array_keys($users), false, true);
    foreach ( array_keys($ret) as $i) {
        if ($ret[$i]["uid"] >0) {
            $ret[$i]["author"] = @$users[$ret[$i]["uid"]];
        } else {
            $ret[$i]["author"] = $xoopsConfig["anonymous"];
        }
    }
    unset($users);

    return $ret;
}
');
?>