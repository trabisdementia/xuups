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
 * @version         $Id: vars.php 2292 2008-10-12 04:53:18Z phppp $
 * @package         tag
 */

if (!defined("TAG_INI")) define("TAG_INI",1);

//include_once XOOPS_ROOT_PATH . "/Frameworks/art/functions.ini.php";
require_once XOOPS_ROOT_PATH . "/modules/tag/include/functions.ini.php";

// include customized variables
if( is_object($GLOBALS["xoopsModule"]) && "tag" == $GLOBALS["xoopsModule"]->getVar("dirname", "n") ) {
    $GLOBALS["xoopsModuleConfig"] = tag_load_config();
}

//load_object();
?>