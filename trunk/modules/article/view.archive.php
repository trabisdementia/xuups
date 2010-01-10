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
 * @version         $Id: view.archive.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";

if (art_parse_args($args_num, $args, $args_str)) {
    $args["year"] = !empty($args["year"]) ? $args["year"] : @$args_num[0];
    $args["month"] = !empty($args["month"]) ? $args["month"] : @$args_num[1];
    $args["day"] = !empty($args["day"]) ? $args["day"] : @$args_num[2];
}

$year = intval( empty($_GET["year"]) ? @$args["year"] : $_GET["year"] );
$month = intval( empty($_GET["month"]) ? @$args["month"] : $_GET["month"] );
$day = intval( empty($_GET["day"]) ? @$args["day"] : $_GET["day"] );
$category_id = intval( empty($_GET["category"]) ? @$args["category"] : $_GET["category"] );
$start = intval( empty($_GET["start"]) ? @$args["start"] : $_GET["start"] );

$page["title"] = art_constant("MD_ACHIVE");

$article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
$categories_obj = $category_handler->getAllByPermission("access", array("cat_title", "cat_moderator"));
$categories_id = array_keys($categories_obj);
if (count($categories_id) ==0 ) {
    redirect_header("index.php", 2, art_constant("MD_NOACCESS"));
}
if (!empty($category_id)) {
    if (!in_array($category_id, $categories_id)) {
        redirect_header(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/index.php", 2, art_constant("MD_NOACCESS"));
    }
    $category_obj =& $category_handler->get($category_id);
    $page["category"] = $category_obj->getVar("cat_title");
    $categories = array($category_id);
} else {
    $categories = $categories_id;
}

if (!empty($xoopsUser)) {
    $xoopsOption["cache_group"] = implode(",", $xoopsUser->groups());
}
$xoopsOption["xoops_pagetitle"] = $xoopsModule->getVar("name") . " - " . art_constant("MD_ACHIVE");
$xoopsOption["template_main"] = art_getTemplate("archive", $xoopsModuleConfig["template"]);
$xoopsOption["xoops_module_header"] = art_getModuleHeader($xoopsModuleConfig["template"]);
include_once XOOPS_ROOT_PATH . "/header.php";
include XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";

$year = empty($year) ? date("Y") : $year;
if ($month < 1) {
    $month = $day = 0;
    $page["time"] = sprintf(art_constant("MD_TIME_Y"), $year);
} elseif ($day < 1) {
    $day = 0;
    $page["time"] = sprintf(art_constant("MD_TIME_YM"), $year, $month);
} else {
    $page["time"] = sprintf(art_constant("MD_TIME_YMD"), $year, $month, $day);
}
$time = array("year" => $year, "month" => $month, "day" => $day);
if ($xoopsUser) {
    $timeoffset = ($xoopsUser->getVar("timezone_offset") - $xoopsConfig['server_TZ']) * 3600;
} else {
    $timeoffset = ($xoopsConfig['default_TZ'] - $xoopsConfig['server_TZ']) * 3600;
}

$field_article_time = empty($category_id) ? "a.art_time_publish" : "ac.ac_publish";
$criteria = new CriteriaCompo( new Criteria("YEAR(FROM_UNIXTIME({$field_article_time} - {$timeoffset}))", $year) );
if ($month) {
    $criteria->add(new Criteria("MONTH(FROM_UNIXTIME({$field_article_time} - {$timeoffset}))", $month));
    if ($day) {
        $criteria->add(new Criteria("DAY(FROM_UNIXTIME({$field_article_time} - {$timeoffset}))", $day));
    }
}
$articles_count = $article_handler->getCountByCategory($categories, $criteria);    

$criteria->setSort($field_article_time);
$criteria->setOrder("DESC");

$articles_obj = $article_handler->getByCategory(
    $categories,
    $xoopsModuleConfig["articles_perpage"],
    $start,
    $criteria,
    array("a.uid", "a.writer_id", "a.art_title", "a.art_time_publish", "a.cat_id", "a.art_categories", "a.art_summary", "a.art_counter")
);

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
$users_id = array();
foreach (array_keys($articles_obj) as $id) {
    $article =& $articles_obj[$id];
    $_category = $article->getVar("cat_id") ? array( "id" => $article->getVar("cat_id"), "title" => $categories_obj[$article->getVar("cat_id")]->getVar("cat_title") ) : array();
    $_article = array(
        "id"        => $id,
        "uid"        => $article->getVar("uid"),
        "title"        => $article->getVar("art_title"),
        "author"    => @$users[$article->getVar("uid")],
        "writer"    => @$writers[$article->getVar("writer_id")],
        "time"        => $article->getTime($xoopsModuleConfig["timeformat"]),
        "counter"    => $article->getVar("art_counter"),
        "category"    => $_category,
        "summary"    => $article->getSummary(true)
    );
    
    $cats = @array_diff($article->getCategories(), array($article->getVar("cat_id")));
    foreach ($cats as $catid) {
        if ($catid==0 || !isset($categories_obj[$catid])) continue;
        $_article["categories"][$catid] = array( "id" => $catid, "title" => $categories_obj[$catid]->getVar("cat_title") );
    }
    $articles[] = $_article;
    unset($_article);
}

if ( $articles_count > $xoopsModuleConfig["articles_perpage"]) {
    include_once XOOPS_ROOT_PATH . "/class/pagenav.php";
    $pagequery = array();
    if ( !empty($year) )            $pagequery[] = "year={$year}";
    if ( !empty($month) )        $pagequery[] = "month={$month}";
    if ( !empty($day) )            $pagequery[] = "day={$day}";
    if ( !empty($category_id) )    $pagequery[] = "category={$category_id}";
    
    $nav = new XoopsPageNav($articles_count, $xoopsModuleConfig["articles_perpage"], $start, "start", implode("&amp;", $pagequery));
    $pagenav = $nav->renderNav(4);
} else {
    $pagenav = "";
}

$categories = array();
$timenav = array();
$calendar = "";
$months = array();
if (empty($start)) {
    // Get category list
    $categories_array = $category_handler->getTree($category_id);
    unset($categories_array[$category_id]);
    $criteria_time = new CriteriaCompo(new Criteria("YEAR(FROM_UNIXTIME(ac.ac_publish - {$timeoffset}))", $year));
    if ($month) {
        $criteria_time->add(new Criteria("MONTH(FROM_UNIXTIME(ac.ac_publish - {$timeoffset}))", $month));
        if ($day) {
            $criteria_time->add(new Criteria("DAY(FROM_UNIXTIME(ac.ac_publish - {$timeoffset}))", $day));
        }
    }
    $cats_counts = $category_handler->getArticleCounts(array_keys($categories_array), $criteria_time);
    $cat_top = @$category_id;
    $cat_pid = $cat_top;
    foreach (array_keys($categories_array) as $id) {
        $cat = $categories_array[$id];
        $_category = array(
            // url of the current category
            "url"    => XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.archive.php" . URL_DELIMITER . "c" . $id . "/" . $year,
            // title of the current category
            "title"    => $cat["prefix"] . $cat["cat_title"] . " (" . @intval($cats_counts[$id]) . ")"
            ); 
            
        if ($cat["cat_pid"] == $cat_top) {
            $categories[$id]["category"] = $_category;
            $cat_pid = $id;
        } else {
            $categories[$cat_pid]["sub"][] = $_category;
        }
    }
    
    $cats = empty($category_id) ? array_keys($categories_array) : array($category_id);
    $cat_criteria = " IN (" . implode( ",", $cats ) . ") ";
    // Get annual list
    if (empty($month)) {
        $sql =  "    SELECT " .
                "        MONTH( FROM_UNIXTIME(ac.ac_publish - {$timeoffset}) ) AS mon, " .
                "        COUNT(DISTINCT a.art_id) AS count " . 
                "    FROM " . art_DB_prefix("article") . " AS a " . 
                "        LEFT JOIN " . art_DB_prefix("artcat") . " AS ac ON ac.art_id = a.art_id " .
                "    WHERE " .
                "        YEAR( FROM_UNIXTIME(ac.ac_publish - {$timeoffset}) ) = {$year} " .
                "        AND ac.cat_id {$cat_criteria} " .
                   "    GROUP BY mon";
        $result = $xoopsDB->query($sql);
        $months = array();
        while ($myrow = $xoopsDB->fetchArray($result)) {
            $months[] = array(
                "title"    => art_constant("MD_MONTH_" . intval($myrow["mon"])) . " (" . intval($myrow["count"]) . ")",
                "url"    => XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.archive.php" . URL_DELIMITER . $year . "/" . $myrow["mon"],
                );
        }
        $timenav["prev"] = array(
            "url"    => XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.archive.php" . URL_DELIMITER . ($year - 1),
            "title"    => sprintf(art_constant("MD_TIME_Y"), ($year - 1))
            );
        if($year < date("Y")){
            $timenav["next"] = array(
                "url"    => XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.archive.php" . URL_DELIMITER . ($year + 1),
                "title" => sprintf(art_constant("MD_TIME_Y"), ($year + 1))
                );
        }
    // Get monthly list
    } elseif (empty($day)) {
        $sql =  "    SELECT " .
                "        DAY( FROM_UNIXTIME(ac.ac_publish - $timeoffset)) AS day, " .
                "        COUNT(DISTINCT a.art_id) AS count " . 
                "    FROM " . art_DB_prefix("article") . " AS a " .
                "        LEFT JOIN " . art_DB_prefix("artcat") . " AS ac ON ac.art_id = a.art_id " .
                "    WHERE YEAR( FROM_UNIXTIME(ac.ac_publish - {$timeoffset}) ) = {$year} " .
                "        AND MONTH( FROM_UNIXTIME(ac.ac_publish - {$timeoffset}) ) = {$month} " .
                "        AND ac.cat_id {$cat_criteria} " .
                "    GROUP BY day";
        $result = $xoopsDB->query($sql);
        $days = array();
        while ($myrow = $xoopsDB->fetchArray($result)) {
            $days[$myrow["day"]]["count"] = $myrow["count"];
        }
        for ($i = 1 ; $i <= 31; $i++) {
            if (!isset($days[$i])) continue;
            $days[$i] = array(
                "title"    => $days[$i]["count"],
                "url"    => XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.archive.php" . URL_DELIMITER . $year . "/" . $month . "/" . $i
                );
        }
        $calendar = art_getCalendar($year, $month, $days);
        $month_next = $month + 1;
        $month_prev = $month - 1;
        $year_prev = $year_next = $year;
        if ($month == 12) {
            $month_next = 1;
            $year_next = $year + 1;
        }
        if ($month == 1) {
            $month_prev = 12;
            $year_prev = $year - 1;
        }
        $timenav["prev"] = array(
            "url"    => XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.archive.php" . URL_DELIMITER . $year_prev . "/" . $month_prev,
            "title"    => art_constant("MD_MONTH_" . $month_prev)
            );
        if ($year<date("Y") || $month < date("n")) {
            $timenav["next"] = array(
                "url"    => XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.archive.php" . URL_DELIMITER . $year_next . "/" . $month_next,
                "title"    => art_constant("MD_MONTH_" . $month_next)
                );
        }
    }
}

$xoopsTpl -> assign("modulename", $xoopsModule->getVar("name"));
$xoopsTpl -> assign("time", $time);
$xoopsTpl -> assign("page", $page);

if (!empty($category_obj)) {
    $xoopsTpl -> assign( "category", array("id" => $category_id, "title" => $category_obj->getVar("cat_title")) );
}
$xoopsTpl -> assign_by_ref("articles", $articles);
$xoopsTpl -> assign_by_ref("categories", $categories);
$xoopsTpl -> assign_by_ref("months", $months);
$xoopsTpl -> assign_by_ref("calendar", $calendar);
$xoopsTpl -> assign_by_ref("timenav", $timenav);
$xoopsTpl -> assign_by_ref("pagenav", $pagenav);

// Loading module meta data, NOT THE RIGHT WAY DOING IT
$xoopsTpl -> assign("xoops_module_header", $xoopsOption["xoops_module_header"]);
$xoopsTpl -> assign("xoops_pagetitle", $xoopsOption["xoops_pagetitle"]);

include_once "footer.php";

/**
 * The calendar functions were adapted from WordPress Calendar scripts
 */
function art_getCalendar($year = null, $month = null, $days = null)
{
    $year = empty($year) ? date("Y") : $year;
    $month = empty($month) ? date("n") : $month;
    $unixmonth = mktime(0, 0 , 0, $month, 1, $year);
    
    ob_start();
    echo '<table id="calendar">';
    echo '<caption>';
    printf(art_constant("MD_TIME_YM"), $year, art_constant("MD_MONTH_" . $month));
    echo '</caption>';
    
    for ($i = 1; $i <= 7; $i++) {
        echo "\n\t\t<th abbr=\"" . art_constant("MD_WEEK_{$i}") . "\" scope=\"col\" title=\"" . art_constant("MD_WEEK_{$i}") . "\">" . art_constant("MD_WEEK_{$i}") . '</th>';
    }

    echo '<tr>';
    
    // See how much we should pad in the beginning
    $week_begins = 1;
    $pad = art_calendar_week_mod( date('w', $unixmonth) - $week_begins );
    if (0 != $pad) echo "\n\t\t" . '<td colspan="' . $pad . '">&nbsp;</td>';

    $daysinmonth = intval( date('t', $unixmonth) );
    for ($day = 1; $day <= $daysinmonth; ++$day) {
        if (isset($newrow) && $newrow) {
            echo "\n\t</tr>\n\t<tr>\n\t\t";
        }
        $newrow = false;

        echo '<td>';

        if (!empty($days[$day]["url"])) {
            echo '<a href="' . $days[$day]["url"] . "\"";
            if (!empty($days[$day]["title"])) echo "title=\"" . $days[$day]["title"] . "\"";
            echo ">$day</a>";
        } elseif (!empty($days[$day]["title"])) {
            echo "<acronym title=\"" . $days[$day]["title"] . "\">$day</acronym>";
        } else {
            echo $day;
        }
        echo '</td>';

        if (6 == art_calendar_week_mod(date('w', mktime(0, 0 , 0, $month, $day, $year))-$week_begins)) {
            $newrow = true;
        }
    }

    $pad = 7 - art_calendar_week_mod(date('w', mktime(0, 0 , 0, $month, $day, $year))-$week_begins);
    if ($pad != 0 && $pad != 7) {
        echo "\n\t\t".'<td class="pad" colspan="' . $pad . '">&nbsp;</td>';
    }

    echo "\n\t</tr>\n\t</tbody>\n\t</table>";
    $calendar = ob_get_contents();
    ob_end_clean();    
    
    return $calendar;
}

// Used in get_calendar
function art_calendar_week_mod($num)
{
    $base = 7;
    return ($num - $base * floor($num / $base));
}

?>