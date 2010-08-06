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
 * @version         $Id: xoops_version.php 2292 2008-10-12 04:53:18Z phppp $
 * @package         tag
 */


if (!defined('XOOPS_ROOT_PATH')) { exit(); }

$modversion = array();
$modversion["name"]         = TAG_MI_NAME;
$modversion["version"]      = 2.30;
$modversion["description"]  = TAG_MI_DESC;
$modversion["image"]        = "images/logo.gif";
$modversion["dirname"]      = "tag";
$modversion["author"]       = "Taiwen Jiang <phppp@users.sourceforge.net>";

// database tables
$modversion["sqlfile"]["mysql"] = "sql/mysql.sql";
$modversion["tables"] = array(
    "tag_tag",
    "tag_link",
    "tag_stats",
);

// Admin things
$modversion["hasAdmin"] = 1;
$modversion["adminindex"] = "admin/index.php";
$modversion["adminmenu"] = "admin/menu.php";

// Menu
$modversion["hasMain"] = 1;

$modversion["onInstall"] = "include/action.module.php";
$modversion["onUpdate"] = "include/action.module.php";
$modversion["onUninstall"] = "include/action.module.php";

// Use smarty
$modversion["use_smarty"] = 1;

/**
 * Templates
 */
$modversion['templates']    = array();
$modversion['templates'][1]    = array(
    'file'          => 'tag_index.html',
    'description'   => 'Index page of tag module'
    );
    $modversion['templates'][]    = array(
    'file'          => 'tag_list.html',
    'description'   => 'List of tags'
    );
    $modversion['templates'][]    = array(
    'file'          => 'tag_view.html',
    'description'   => 'Links of a tag'
    );
    $modversion['templates'][]    = array(
    'file'          => 'tag_bar.html',
    'description'   => 'Tag list in an item'
    );

    // Blocks
    $modversion['blocks']    = array();

    /*
     * $options:
     *                    $options[0] - number of tags to display
     *                    $options[1] - max font size (px or %)
     *                    $options[2] - min font size (px or %)
     */
    $modversion["blocks"][1]    = array(
    "file"          => "block.php",
    "name"          => TAG_MI_BLOCK_CLOUD,
    "description"   => TAG_MI_BLOCK_CLOUD_DESC,
    "show_func"     => "tag_block_cloud_show",
    "edit_func"     => "tag_block_cloud_edit",
    "options"       => "100|0|150|80",
    "template"      => "tag_block_cloud.html",
    );

    /*
     * $options:
     *                    $options[0] - number of tags to display
     *                    $options[1] - time duration, in days, 0 for all the time
     *                    $options[2] - sort: a - alphabet; c - count; t - time
     */
    $modversion["blocks"][]    = array(
    "file"          => "block.php",
    "name"          => TAG_MI_BLOCK_TOP,
    "description"   => TAG_MI_BLOCK_TOP_DESC,
    "show_func"     => "tag_block_top_show",
    "edit_func"     => "tag_block_top_edit",
    "options"       => "50|30|a",
    "template"      => "tag_block_top.html",
    );

    // Search
    $modversion["hasSearch"] = 1;
    $modversion['search']['file'] = "include/search.inc.php";
    $modversion['search']['func'] = "tag_search";

    // Comments
    $modversion["hasComments"] = 0;

    // Configs
    $modversion["config"] = array();

    $modversion["config"][1] = array(
    "name"          => "do_urw",
    "title"         => "TAG_MI_DOURLREWRITE",
    "description"   => "TAG_MI_DOURLREWRITE_DESC",
    "formtype"      => "yesno",
    "valuetype"     => "int",
    "default"       => in_array(php_sapi_name(), array("apache", "apache2handler")),
    );

    $modversion["config"][] = array(
    "name"          => "items_perpage",
    "title"         => "TAG_MI_ITEMSPERPAGE",
    "description"   => "TAG_MI_ITEMSPERPAGE_DESC",
    "formtype"      => "textbox",
    "valuetype"     => "int",
    "default"       => 10
    );


    // Notification

    $modversion["hasNotification"] = 0;
    $modversion["notification"] = array();
    ?>