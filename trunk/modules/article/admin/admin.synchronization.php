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
 * @version         $Id: admin.synchronization.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";

xoops_cp_header();
require XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";
loadModuleAdminMenu(9);

$type = @$_GET['type'];
//if (!empty($_GET['type'])) {
    $start = intval( @$_GET['start'] );
    
    switch ( $type ) {
    case "category":
        $category_handler =& xoops_getmodulehandler("category", $xoopsModule->getVar("dirname", "n"));
        if ( $start >= ($count = $category_handler->getCount()) ) {
            break;
        }
        
        $limit = empty($_GET['limit']) ? 20 : intval($_GET['limit']);
        $criteria = new Criteria("1", 1);
        $criteria->setStart($start);
        $criteria->setLimit($limit);
        $categories_obj = $category_handler->getAll($criteria);
        foreach (array_keys($categories_obj) as $key) {
            $category_handler->updateTrack($categories_obj[$key]);
            $category_handler->_setLastArticleIds($categories_obj[$key]);
        }
        
        redirect_header("admin.synchronization.php?type={$type}&amp;start=" . ($start + $limit) . "&amp;limit={$limit}", 2, art_constant("AM_SYNC_SYNCING") . " {$count}: {$start} - " . ($start + $limit));
        exit();
        break;
    
    case "article":
        
        $article_handler =& xoops_getmodulehandler("article", $xoopsModule->getVar("dirname", "n"));
        if ( $start >= ($count = $article_handler->getCount()) ) {
            break;
        }
        
        $limit = empty($_GET['limit']) ? 100 : intval($_GET['limit']);
        $criteria = new Criteria("1", 1);
        $criteria->setStart($start);
        $criteria->setLimit($limit);
        $articles_obj = $article_handler->getAll($criteria);
        $rates = array();
        $tbs = array();
        
        $sql =  "    SELECT art_id, COUNT(*) AS art_rates, SUM(rate_rating) AS art_rating " .
                "    FROM " . art_DB_prefix("rate") .
                "    WHERE art_id IN(" . implode(",", array_keys($articles_obj)) . ")" .
                "    GROUP BY art_id";
        $result = $xoopsDB->query($sql);
        while ($myrow = $xoopsDB->fetchArray($result)) {
            $rates[$myrow["art_id"]] = array("art_rates" => $myrow["art_rates"], "art_rating" => $myrow["art_rating"]);
        }
        
        $sql =  "    SELECT art_id, COUNT(*) AS art_trackbacks " .
                "    FROM " . art_DB_prefix("trackback") .
                "    WHERE art_id IN (" . implode(", ", array_keys($articles_obj)) . ")" .
                "        AND tb_status > 0" .
                "    GROUP BY art_id";
        $result = $xoopsDB->query($sql);
        while ($myrow = $xoopsDB->fetchArray($result)) {
            $tbs[$myrow["art_id"]] = $myrow["art_trackbacks"];
        }
        
        foreach (array_keys($articles_obj) as $key) {
            $article_handler->updateCategories($articles_obj[$key]);
            $article_handler->updateTopics($articles_obj[$key]);
            $article_handler->updateKeywords($articles_obj[$key]);
            
            $pages_all = $articles_obj[$key]->getPages(false, true);
            if ( serialize($pages_all) != serialize($articles_obj[$key]->getPages()) ) {
                $articles_obj[$key]->setVar("art_pages", $pages_all, true);
            }
            if ( intval( @$rates[$key]["art_rates"] ) != $articles_obj[$key]->getVar("art_rates") ) {
                $articles_obj[$key]->setVar("art_rates", intval(@$rates[$key]["art_rates"]), true);
            }
            if ( intval( @$rates[$key]["art_rating"] ) != $articles_obj[$key]->getVar("art_rating") ) {
                $articles_obj[$key]->setVar("art_rating", intval(@$rates[$key]["art_rating"]), true);
            }
            if ( intval( @$tbs[$key] ) != $articles_obj[$key]->getVar("art_trackbacks") ) {
                $articles_obj[$key]->setVar("art_trackbacks", intval(@$tbs[$key]), true);
            }
            
            $article_handler->insert($articles_obj[$key]);
        }
        
        redirect_header("admin.synchronization.php?type={$type}&amp;start=" . ($start + $limit) . "&amp;limit={$limit}", 2, art_constant("AM_SYNC_SYNCING") . " {$count}: {$start} - " . ($start+$limit));
        exit();

    case "misc":
    default:
        mod_loadFunctions("recon", $xoopsModule->getVar("dirname", "n"));
        art_synchronization();
        break;
    }
    

$form = '<fieldset><legend style="font-weight: bold; color: #900;">' . art_constant("AM_SYNC_TITLE") . '</legend>';

$form .= '<form action="admin.synchronization.php" method="get">';
$form .= '<div style="padding: 10px 2px;">';
$form .= '<h2>'.art_constant("AM_SYNC_CATEGORY").'</h2>';
$form .= '<input type="hidden" name="type" value="category">';
$form .= art_constant("AM_SYNC_ITEMS") . '<input type="text" name="limit" value="20"> ';
$form .= '<input type="submit" name="submit" value=' . _SUBMIT . ' />';
$form .= '</div>';
$form .= '</form>';

$form .= '<form action="admin.synchronization.php" method="get">';
$form .= '<div style="padding: 10px 2px;">';
$form .= '<h2>'.art_constant("AM_SYNC_ARTICLE").'</h2>';
$form .= '<input type="hidden" name="type" value="article">';
$form .= art_constant("AM_SYNC_ITEMS") . '<input type="text" name="limit" value="100"> ';
$form .= '<input type="submit" name="submit" value=' . _SUBMIT . ' />';
$form .= '</div>';
$form .= '</form>';

$form .= '<form action="admin.synchronization.php" method="get">';
$form .= '<div style="padding: 10px 2px;">';
$form .= '<h2>'.art_constant("AM_SYNC_MISC") . '</h2>';
$form .= '<input type="hidden" name="type" value="misc">';
$form .= '<input type="submit" name="submit" value=' . _SUBMIT . ' />';
$form .= '</div>';
$form .= '</form>';

$form .= "</fieldset>";

echo $form;
xoops_cp_footer();
?>