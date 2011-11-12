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
define("NEWBB_FUNCTIONS_READ_LOADED", TRUE);


IF (!defined("NEWBB_FUNCTIONS_READ")):
define("NEWBB_FUNCTIONS_READ", 1);

function newbb_setRead($type, $item_id, $post_id, $uid = null)
{
	$read_handler =& xoops_getmodulehandler("read".$type, "newbb");
	return $read_handler->setRead($item_id, $post_id, $uid);
}

function newbb_getRead($type, $item_id, $uid = null)
{
	$read_handler =& xoops_getmodulehandler("read".$type, "newbb");
	return $read_handler->getRead($item_id, $uid);
}

function newbb_setRead_forum($status = 0, $uid = null)
{
	$read_handler =& xoops_getmodulehandler("readforum", "newbb");
	return $read_handler->setRead_items($status, $uid);
}

function newbb_setRead_topic($status = 0, $forum_id = 0, $uid = null)
{
	$read_handler =& xoops_getmodulehandler("readtopic", "newbb");
	return $read_handler->setRead_items($status, $forum_id, $uid);
}

function newbb_isRead($type, &$items, $uid = null)
{
	$read_handler =& xoops_getmodulehandler("read".$type, "newbb");
	return $read_handler->isRead_items($items, $uid);
}
ENDIF;
?>