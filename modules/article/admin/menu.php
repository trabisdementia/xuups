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
 * @version         $Id: menu.php 2178 2008-09-26 08:34:09Z phppp $
 */

if (!defined('XOOPS_ROOT_PATH')) { exit(); }

global $adminmenu;

$adminmenu = array();

$adminmenu[]= array("link" => "admin/index.php",
					"title" => art_constant("MI_ADMENU_INDEX"));
$adminmenu[]= array("link" => "admin/admin.category.php",
					"title" => art_constant("MI_ADMENU_CATEGORY"));
$adminmenu[]= array("link" => "admin/admin.topic.php",
					"title" => art_constant("MI_ADMENU_TOPIC"));
$adminmenu[]= array("link" => "admin/admin.article.php",
					"title" => art_constant("MI_ADMENU_ARTICLE"));
$adminmenu[]= array("link" => "admin/admin.permission.php",
					"title" => art_constant("MI_ADMENU_PERMISSION"));
$adminmenu[]= array("link" => "admin/admin.block.php",
					"title" => art_constant("MI_ADMENU_BLOCK"));
$adminmenu[]= array("link" => "admin/admin.spotlight.php",
					"title" => art_constant("MI_ADMENU_SPOTLIGHT"));
$adminmenu[]= array("link" => "admin/admin.trackback.php",
					"title" => art_constant("MI_ADMENU_TRACKBACK"));
$adminmenu[]= array("link" => "admin/admin.file.php",
					"title" => art_constant("MI_ADMENU_FILE"));
$adminmenu[]= array("link" => "admin/admin.synchronization.php",
					"title" => art_constant("MI_ADMENU_UTILITY"));
$adminmenu[]= array("link" => "admin/about.php",
					"title" => art_constant("MI_ADMENU_ABOUT"));
// misc: comments, synchronize, achive, batch import
?>