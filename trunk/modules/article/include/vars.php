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
 * @version         $Id: vars.php 2283 2008-10-12 03:36:13Z phppp $
 */
 
if (!defined("ARTICLE_INI")) define("ARTICLE_INI", 1);


/* 
 * The prefix for database table name prefix
 * You can change to any term but be consistent with the table names in /sql/mysql.sql, and be unique , no conflict with other modules
 */
$GLOBALS["ART_DB_PREFIX"]    = "art";

/* You are not supposed to modify following contents */
defined("FRAMEWORKS_ART_FUNCTIONS_INI") || require_once XOOPS_ROOT_PATH . "/Frameworks/art/functions.ini.php";
$GLOBALS["artdirname"] = basename(dirname(dirname(__FILE__)));

/* 
 * The prefix for module variables
 * You can change to any term but be unique, no conflict with other modules
 */
$GLOBALS["ART_VAR_PREFIX"] = $GLOBALS["artdirname"];

/* 
 * The prefix for module language constants
 * You can chnage to any term but be capital and unique, no conflict with other modules
 */
$GLOBALS["ART_VAR_PREFIXU"] = strtoupper($GLOBALS["artdirname"]);
require_once XOOPS_ROOT_PATH . "/modules/" . $GLOBALS["artdirname"] . "/include/functions.ini.php";

// include customized variables
if ( is_object($GLOBALS["xoopsModule"]) && $GLOBALS["artdirname"] == $GLOBALS["xoopsModule"]->getVar("dirname", "n") ) {
    $GLOBALS["xoopsModuleConfig"] = art_load_config();
}

//art_load_object();
?>