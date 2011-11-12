<?php
/**
 * CBB 4.0, or newbb, the forum module for XOOPS project
 *
 * @copyright	The XOOPS Project http://xoops.sf.net
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <phppp@users.sourceforge.net>
 * @since		4.00
 * @version		$Id $
 * @package		module::newbb
 */

if (!defined('XOOPS_ROOT_PATH')) { exit(); }

defined("NEWBB_FUNCTIONS_INI") || include dirname(__FILE__)."/functions.ini.php";
define("NEWBB_FUNCTIONS_RECON_LOADED", TRUE);

if (!defined("NEWBB_FUNCTIONS_RECON")):
define("NEWBB_FUNCTIONS_RECON", 1);

function newbb_synchronization($type = "")
{
	switch($type) {
	case "rate":
	case "report":
	case "post":
	case "topic":
	case "forum":
	case "category":
	case "moderate":
	case "read":
		$type = array($type);
		$clean = $type;
		break;
	default:
		$type = null;
		$clean = array("category", "forum", "topic", "post", "report", "rate", "moderate", "readtopic", "readforum");
		break;
	}
	foreach ($clean as $item) {
		$handler =& xoops_getmodulehandler($item, "newbb");
        $handler->cleanOrphan();
		unset($handler);
	}
    $newbbConfig = newbb_load_config();
	if (empty($type) || in_array("post", $type)):
		$post_handler =& xoops_getmodulehandler("post", "newbb");
        $expires = isset($newbbConfig["pending_expire"]) ? intval($newbbConfig["pending_expire"]) : 7;
		$post_handler->cleanExpires($expires*24*3600);
	endif;
	if (empty($type) || in_array("topic", $type)):
		$topic_handler =& xoops_getmodulehandler("topic", "newbb");
        $expires = isset($newbbConfig["pending_expire"]) ? intval($newbbConfig["pending_expire"]) : 7;
		$topic_handler->cleanExpires($expires*24*3600);
		//$topic_handler->synchronization();
	endif;
	/*
	if (empty($type) || in_array("forum", $type)):
		$forum_handler =& xoops_getmodulehandler("forum", "newbb");
		$forum_handler->synchronization();
	endif;
	*/
	if (empty($type) || in_array("moderate", $type)):
		$moderate_handler =& xoops_getmodulehandler("moderate", "newbb");
		$moderate_handler->clearGarbage();
	endif;
	if (empty($type) || in_array("read", $type)):
		$read_handler =& xoops_getmodulehandler("readforum", "newbb");
		$read_handler->clearGarbage();
		//$read_handler->synchronization();
		$read_handler =& xoops_getmodulehandler("readtopic", "newbb");
		$read_handler->clearGarbage();
		//$read_handler->synchronization();
	endif;
	return true;
}

endif;
?>