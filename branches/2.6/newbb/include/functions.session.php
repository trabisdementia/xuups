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

defined("NEWBB_FUNCTIONS_INI") || include_once dirname(__FILE__)."/functions.ini.php";
define("NEWBB_FUNCTIONS_SESSION_LOADED", TRUE);


if (!defined("NEWBB_FUNCTIONS_SESSION")):
define("NEWBB_FUNCTIONS_SESSION", 1);

/*
 * Currently the newbb session/cookie handlers are limited to:
 * -- one dimension
 * -- "," and "|" are preserved
 *
 */
function newbb_setsession($name, $string = '')
{
	if (is_array($string)) {
		$value = array();
		foreach ($string as $key => $val) {
			$value[]=$key."|".$val;
		}
		$string = implode(",", $value);
	}
	$_SESSION['newbb_'.$name] = $string;
}

function newbb_getsession($name, $isArray = false)
{
	$value = !empty($_SESSION['newbb_'.$name]) ? $_SESSION['newbb_'.$name] : false;
	if ($isArray) {
		$_value = ($value)?explode(",", $value):array();
		$value = array();
		if (count($_value)>0) foreach ($_value as $string) {
			$key = substr($string, 0, strpos($string,"|"));
			$val = substr($string, (strpos($string,"|")+1));
			$value[$key] = $val;
		}
		unset($_value);
	}
	return $value;
}

function newbb_setcookie($name, $string = '', $expire = 0)
{
	global $forumCookie;
	if (is_array($string)) {
		$value = array();
		foreach ($string as $key => $val) {
			$value[]=$key."|".$val;
		}
		$string = implode(",", $value);
	}
	setcookie($forumCookie['prefix'].$name, $string, intval($expire), $forumCookie['path'], $forumCookie['domain'], $forumCookie['secure']);
}

function newbb_getcookie($name, $isArray = false)
{
	global $forumCookie;
	$value = !empty($_COOKIE[$forumCookie['prefix'].$name]) ? $_COOKIE[$forumCookie['prefix'].$name] : null;
	if ($isArray) {
		$_value = ($value)?explode(",", $value):array();
		$value = array();
		if (count($_value)>0) foreach ($_value as $string) {
			$sep = strpos($string,"|");
			if ($sep===false) {
				$value[]=$string;
			} else {
				$key = substr($string, 0, $sep);
				$val = substr($string, ($sep+1));
				$value[$key] = $val;
			}
		}
		unset($_value);
	}
	return $value;
}

ENDIF;
?>