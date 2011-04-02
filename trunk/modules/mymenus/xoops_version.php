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
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Mymenus
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: xoops_version.php 0 2010-07-21 18:47:04Z trabis $
 */

defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

$modversion['name'] = _MI_MYMENUS_MD_NAME;
$modversion['version'] = 1.3;
$modversion['description'] = _MI_MYMENUS_MD_DESC;
$modversion['credits'] = "Xuups";
$modversion['author'] = "Xuups";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/mymenus.png";
$modversion['dirname'] = "mymenus";

// Menu
$modversion['hasMain'] = 0;

// Admin things
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu']  = "admin/menu.php";

// Search
$modversion['hasSearch'] = 0;

// Comments
$modversion['hasComments'] = 0;

// Sql
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$i = 0;
$i++;
$modversion['tables'][$i] = "mymenus_menu";
$i++;
$modversion['tables'][$i] = "mymenus_menus";

// Config
$i = 0;
$i++;
$modversion['config'][$i]['name'] = 'assign_method';
$modversion['config'][$i]['title'] = '_MI_MENUS_CONF_ASSIGN_METHOD';
$modversion['config'][$i]['description'] = '_MI_MENUS_CONF_ASSIGN_METHOD_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = 'xotheme';
$modversion['config'][$i]['options'] = array(
    _MI_MENUS_CONF_ASSIGN_METHOD_XOOPSTPL   => 'xoopstpl',
    _MI_MENUS_CONF_ASSIGN_METHOD_XOTHEME    => 'xotheme'
);

// Blocks
$i = 0;
$i++;
$modversion['blocks'][$i]['file'] = "mymenus_block.php";
$modversion['blocks'][$i]['name'] = _MI_MYMENUS_BLK;
$modversion['blocks'][$i]['description'] = _MI_MYMENUS_BLK_DSC;
$modversion['blocks'][$i]['show_func'] = "mymenus_block_show";
$modversion['blocks'][$i]['edit_func'] = "mymenus_block_edit";
$modversion['blocks'][$i]['options'] = "0|default|0|block|0";
$modversion['blocks'][$i]['template'] = "mymenus_block.html";
