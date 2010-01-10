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
 * @version         $Id: admin.utility.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";
/* 
 * The feature is to be reactivated after article 1.0 release
 * 
 * redirect to index page by now
 */

xoops_cp_header();
require XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname", "n") . "/include/vars.php";
loadModuleAdminMenu(9);

echo "<fieldset><legend style=\"font-weight: bold; color: #900;\">" . art_constant("AM_ARTICLES") . "</legend>";
echo "<div style=\"padding: 8px;\">";
//echo "<br /><a style=\"border: 1px solid #5E5D63; padding: 4px 8px;\" href=\"".XOOPS_URL."/modules/".$GLOBALS["artdirname"]."/cp.article.php?from=1\">" . art_constant("AM_CPARTICLE") . "</a>";
echo "<h2>Coming soon ...</h2>";
echo "</div>";
echo "</fieldset><br />";

xoops_cp_footer();
?>