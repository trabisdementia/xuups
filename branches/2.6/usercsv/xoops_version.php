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
 * @package         usercsv
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: xoops_version.php 0 2009-08-26 18:47:04Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

/**
 * General Information
 */
$modversion['name'] = _MI_UCSV_MD_NAME;
$modversion['version'] = 1.0;
$modversion['description'] = _MI_UCSV_MD_DSC;
$modversion['author'] = "Xuups";
$modversion['credits'] = "Trabis (http://www.xuups.com)";
$modversion['help'] = "";
$modversion['license'] = "GNU General Public License (GPL)";
$modversion['official'] = 0;
$modversion['dirname'] = basename(dirname(__FILE__));

/**
 * Images information
 */

$modversion['image'] = "images/module_slogo.png";

/**
 * Administrative information
 */
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

$modversion['hasMain'] = 0;

?>