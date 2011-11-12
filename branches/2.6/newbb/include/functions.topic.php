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
define("NEWBB_FUNCTIONS_TOPIC_LOADED", TRUE);


if (!defined("NEWBB_FUNCTIONS_TOPIC")):
define("NEWBB_FUNCTIONS_TOPIC", 1);

/**
 * Create full title of a topic
 *
 * the title is composed of [type_name] if type_id is greater than 0 plus topic_title
 *
 */
function newbb_getTopicTitle($topic_title, $prefix_name = null, $prefix_color = null)
{
  return getTopicTitle($topic_title, $prefix_name = null, $prefix_color = null);
}

function getTopicTitle($topic_title, $prefix_name = null, $prefix_color = null)
{
	if (empty($prefix_name)) return $topic_title;
	$topic_prefix = $prefix_color? "<em style=\"font-style: normal; color: ".$prefix_color.";\">[".$prefix_name."]</em> ":"[".$prefix_name."] ";
	
	return $topic_prefix.$topic_title;
}

ENDIF;
?>