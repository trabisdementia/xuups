<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code 
 which is considered copyrighted (c) material of the original comment or credit authors.
 
 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * XOOPS tag management module
 *
 * @copyright       The XOOPS project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @since           1.0.0
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: menu.php 1575 2008-05-04 15:54:26Z phppp $
 * @package         tag
 */

if (!defined('XOOPS_ROOT_PATH')) { exit(); }

global $adminmenu;

$adminmenu = array();

$adminmenu[]= array("link"    => "admin/index.php",
                    "title"    => TAG_MI_ADMENU_INDEX);
$adminmenu[]= array("link"    => "admin/admin.tag.php",
                    "title"    => TAG_MI_ADMENU_EDIT);
$adminmenu[]= array("link"    => "admin/syn.tag.php",
                    "title"    => TAG_MI_ADMENU_SYNCHRONIZATION);
?>