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
 * @version         $Id: admin.category.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";
xoops_cp_header();
require XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";
loadModuleAdminMenu(1);

$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
$article_counts =& $category_handler->getArticleCountsRegistered();
$counts = array();
foreach ($article_counts as $id => $count) {
    if ($count > 0) $counts[$id] = $count;
}
$ids = array_keys($counts);
if (count($ids) > 0) {
    echo "<fieldset><legend style=\"font-weight: bold; color: #900;\">" . art_constant("AM_SUBMITTED") . "</legend>";
    echo "<div style=\"padding: 8px;\">";
    $category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
    $criteria = new Criteria("cat_id", "(" . implode(",", $ids) . ")", "IN");
    $cat_titles = $category_handler->getList($criteria);
    foreach ($cat_titles as $id => $title) {
        echo "<br clear=\"all\" /><a href=\"" . XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/cp.article.php?category=" . $id . "&amp;type=submitted&amp;from=1\">" . $title . "(<font color=\"red\">" . $counts[$id] . "</font>)</a>";
    }
    echo "</div>";
    echo "</fieldset><br style=\"clear:both\"/>";
}

echo "<fieldset><legend style=\"font-weight: bold; color: #900;\">" . art_constant("AM_CATEGORIES") . "</legend>";
echo "<div style=\"padding: 8px;\">";
echo "<br clear=\"all\" /><a style=\"border: 1px solid #5E5D63; padding: 4px 8px;\" href=\"" . XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/cp.category.php?from=1\">" . art_constant("AM_CPCATEGORY") . "</a>";
echo "<br clear=\"all\" />";
echo "<br clear=\"all\" /><a style=\"border: 1px solid #5E5D63; padding: 4px 8px;\" href=\"" . XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/edit.category.php?from=1\">" . art_constant("AM_ADDCATEGORY") . "</a>";
echo "</div>";
echo "</fieldset><br clear=\"all\" />";

xoops_cp_footer();
?>