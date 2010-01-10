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
 * @version         $Id: functions.ini.php 2283 2008-10-12 03:36:13Z phppp $
 */
 
/*

The functions loaded on initializtion
*/

if (!defined('XOOPS_ROOT_PATH')) { exit(); }

if (!defined("ART_FUNCTIONS_INI")):
define("ART_FUNCTIONS_INI", 1);

function art_constant($name)
{
	if (defined($GLOBALS["ART_VAR_PREFIXU"] . "_" . strtoupper($name))) {
		return CONSTANT($GLOBALS["ART_VAR_PREFIXU"] . "_" . strtoupper($name));
	} else {
		return strtolower($name);
	}
}

function art_DB_prefix($name, $isRel = false)
{
	$relative_name = $GLOBALS["ART_DB_PREFIX"] . "_" . $name;
	if ($isRel) return $relative_name;
	return $GLOBALS["xoopsDB"]->prefix($relative_name);
}

function art_load_object()
{
    // For backward compat
}

function art_load_config()
{
	static $moduleConfig;
	if (isset($moduleConfig[$GLOBALS["artdirname"]])) {
		return $moduleConfig[$GLOBALS["artdirname"]];
	}
	
	//load_functions("config");
	//$moduleConfig[$GLOBALS["artdirname"]] = mod_loadConfig($GLOBALS["artdirname"]);
	
    if (isset($GLOBALS["xoopsModule"]) && is_object($GLOBALS["xoopsModule"]) && $GLOBALS["xoopsModule"]->getVar("dirname", "n") == $GLOBALS["artdirname"]) {
	    if (!empty($GLOBALS["xoopsModuleConfig"])) {
		    $moduleConfig[$GLOBALS["artdirname"]] =& $GLOBALS["xoopsModuleConfig"];
	    } else {
		    return null;
	    }
    } else {
		$module_handler =& xoops_gethandler('module');
		$module = $module_handler->getByDirname($GLOBALS["artdirname"]);
	
	    $config_handler =& xoops_gethandler('config');
	    $criteria = new CriteriaCompo(new Criteria('conf_modid', $module->getVar('mid')));
	    $configs =& $config_handler->getConfigs($criteria);
	    foreach(array_keys($configs) as $i) {
		    $moduleConfig[$GLOBALS["artdirname"]][$configs[$i]->getVar('conf_name')] = $configs[$i]->getConfValueForOutput();
	    }
	    unset($configs);
    }
	if ($customConfig = @include XOOPS_ROOT_PATH . "/modules/" . $GLOBALS["artdirname"] . "/include/plugin.php") {
		$moduleConfig[$GLOBALS["artdirname"]] = array_merge($moduleConfig[$GLOBALS["artdirname"]], $customConfig);
	}
	
    return $moduleConfig[$GLOBALS["artdirname"]];

}

function art_define_url_delimiter()
{
	if (defined("URL_DELIMITER")) {
		if (!in_array(URL_DELIMITER, array("?", "/"))) die("Exit on security");
	} else {
		$moduleConfig = art_load_config();
		if (empty($moduleConfig["do_urw"])) {
			define("URL_DELIMITER", "?");
		} else {
			define("URL_DELIMITER", "/");
		}
	}
}
endif;
?>