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
define("NEWBB_FUNCTIONS_TIME_LOADED", TRUE);


if (!defined("NEWBB_FUNCTIONS_TIME")):
define("NEWBB_FUNCTIONS_TIME", 1);

/**
 * Function to convert UNIX time to formatted time string
 */
function newbb_formatTimestamp($time, $format = "c", $timeoffset = "")
{
	load_functions("locale");
	$newbbConfig = newbb_load_config();

	$format = strtolower($format);
	if ($format == "reg" || $format == "") {
		$format = "c";
	}
	if ( ($format == "custom" || $format == "c") && !empty($newbbConfig["formatTimestamp_custom"]) ) {
		$format = $newbbConfig["formatTimestamp_custom"];
	}
	
	return XoopsLocal::formatTimestamp($time, $format, $timeoffset);
}

function newbb_sinceSelectBox($selected = 100)
{
	$newbbConfig = newbb_load_config();

	$select_array = explode(',', $newbbConfig['since_options']);
	$select_array = array_map('trim', $select_array);

	$forum_selection_since = '<select name="since">';
	foreach ($select_array as $since) {
		$forum_selection_since .= '<option value="'.$since.'"'.(($selected == $since) ? ' selected="selected"' : '').'>';
		if ($since>0) {
			$forum_selection_since .= sprintf(_MD_FROMLASTDAYS, $since);
		} else {
			$forum_selection_since .= sprintf(_MD_FROMLASTHOURS, abs($since));
		}
		$forum_selection_since .= '</option>';
	}
	$forum_selection_since .= '<option value="365"'.(($selected == 365) ? ' selected="selected"' : '').'>'._MD_THELASTYEAR.'</option>';
	$forum_selection_since .= '<option value="0"'.(($selected == 0) ? ' selected="selected"' : '').'>'._MD_BEGINNING.'</option>';
	$forum_selection_since .= '</select>';

	return $forum_selection_since;
}

function newbb_getSinceTime($since = 100)
{
	if ($since==1000) return 0;
	if ($since>0) return intval($since) * 24 * 3600;
	else return intval(abs($since)) * 3600;
}


ENDIF;
?>