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
 * @version         $Id: functions.php 2283 2008-10-12 03:36:13Z phppp $
 */
 
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

include dirname(__FILE__) . "/vars.php";
define($GLOBALS["artdirname"] . "_FUNCTIONS_LOADED", TRUE);

if (!defined("ART_FUNCTIONS")):
define("ART_FUNCTIONS", 1);

load_functions();
mod_loadFunctions("parse", $GLOBALS["artdirname"]);
mod_loadFunctions("url", $GLOBALS["artdirname"]);
mod_loadFunctions("render", $GLOBALS["artdirname"]);
mod_loadFunctions("user", $GLOBALS["artdirname"]);
mod_loadFunctions("rpc", $GLOBALS["artdirname"]);
mod_loadFunctions("time", $GLOBALS["artdirname"]);
//mod_loadFunctions("cache", $GLOBALS["artdirname"]);
mod_loadFunctions("recon", $GLOBALS["artdirname"]);

/**
 * Function to display messages
 * 
 * @var mixed     $messages
 */
function art_message( $message )
{
    return mod_message( $message );
}

// Backword compatible
function art_load_lang_file( $filename, $module = '', $default = 'english' )
{
    if (empty($module) && is_object($GLOBALS["xoopsModule"])) {
        $module = $GLOBALS["xoopsModule"]->getVar("dirname");
    }
    return xoops_loadLanguage($filename, $module);
}

/**
 * Function to set a cookie with module-specified name
 *
 * using customized serialization method
 */
function art_setcookie($name, $string = '', $expire = 0)
{
    if (is_array($string)) {
        $value = array();
        foreach ($string as $key => $val) {
            $value[] = $key . "|" . $val;
        }
        $string = implode(",", $value);
    }
    $expire = empty($expire) ? 3600 * 24 * 30 : intval($expire);
    //setcookie($GLOBALS["ART_VAR_PREFIX"].$name, $string, intval($expire), '/');
    setcookie($name, $string, time() + $expire, '/');
}

function art_getcookie($name, $isArray = false)
{
    //$value = isset($_COOKIE[$GLOBALS["ART_VAR_PREFIX"].$name]) ? $_COOKIE[$GLOBALS["ART_VAR_PREFIX"].$name] : null;
    $value = isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
    if ($isArray) {
        $_value = ($value) ? explode(",", $value) : array();
        $value = array();
        foreach ($_value as $string) {
            $key = substr($string, 0, strpos($string, "|"));
            $val = substr($string, (strpos($string, "|") + 1));
            $value[$key] = $val;
        }
        unset($_value);
    }
    return $value;
}


/**
 * Get structured categories
 * 
 * @int integer     $pid    parent category ID
 *
 * @return array
 */
function art_getSubCategory($pid = 0, $refresh = false)
{
    
    $list = @mod_loadCacheFile("category", $GLOBALS["artdirname"]);
    if ( !is_array($list) || $refresh ) {
        $list = art_createSubCategoryList();
    }
    if ($pid == 0) return $list;
    else return @$list[$pid];
}

function art_createSubCategoryList() 
{
    $category_handler =& xoops_getModuleHandler("category", $GLOBALS["artdirname"]);
    $criteria =& new CriteriaCompo("1", 1);
    $criteria->setSort("cat_pid ASC, cat_order");
    $criteria->setOrder("ASC");
    $categories_obj = $category_handler->getObjects($criteria);
    require_once XOOPS_ROOT_PATH . "/modules/" . $GLOBALS["artdirname"] . "/class/tree.php";
    $tree = new artTree($categories_obj, "cat_id", "cat_pid");
    $category_array = array();
    foreach (array_keys($categories_obj) as $key) {
        if (!$child = array_keys($tree->getAllChild($categories_obj[$key]->getVar("cat_id")))) continue;
        $category_array[$categories_obj[$key]->getVar("cat_id")] = $child;
    }
    unset($categories_obj, $tree, $criteria);
    mod_createCacheFile($category_array, "category", $GLOBALS["artdirname"]);
    return $category_array;
}
ENDIF;
?>