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
 * @version         $Id: admin.topic.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";

xoops_cp_header();
require XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";
loadModuleAdminMenu(2);

echo "<fieldset><legend style='font-weight: bold; color: #900;'>" . art_constant("AM_TOPICS") . "</legend>";
echo "<div style='padding: 8px;'>";

$topic_handler =& xoops_getmodulehandler("topic", $GLOBALS["artdirname"]);
$topic_counts =& $topic_handler->getCountsByCategory();
$counts = array();
foreach ($topic_counts as $id => $count) {
    if ($count > 0) $counts[$id] = $count;
}
$ids = array_keys($counts);
if (count($ids) > 0) {
    echo "<br /><span style=\"border: 1px solid #5E5D63; padding: 4px 8px;\">" . art_constant("AM_CPTOPIC") ."</span>";
    $category_handler =& xoops_getmodulehandler('category', $GLOBALS["artdirname"]);
    $criteria = new Criteria("cat_id", "(" . implode(",", $ids) . ")", "IN");
    $cat_titles = $category_handler->getList($criteria);
    echo "<ul>";
    foreach ($cat_titles as $id => $cat) {
        echo "<li><a href=\"" . XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/cp.topic.php?category=" . $id . "&amp;from=1\">" . $cat . " (" . $counts[$id] . ")</a></li>";
    }
    echo "</ul>";
}
echo "<br /><br /><a style=\"border: 1px solid #5E5D63; padding: 4px 8px;\" href=\"" . XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/edit.topic.php?from=1\">" . art_constant("AM_ADDTOPIC") . "</a>";
echo "</div>";
echo "</fieldset><br />";

xoops_cp_footer();
?>