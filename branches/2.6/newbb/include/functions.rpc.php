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
define("NEWBB_FUNCTIONS_RPC_LOADED", TRUE);


IF (!defined("NEWBB_FUNCTIONS_RPC")):
define("NEWBB_FUNCTIONS_RPC", 1);

/**
 * Function to respond to a trackback
 */
function newbb_trackback_response($error = 0, $error_message = '') 
{
	$moduleConfig = newbb_load_config();
	
	if (!empty($moduleConfig["rss_utf8"])) {
		$charset = "utf-8";
		$error_message = xoops_utf8_encode($error_message);
	} else {
		$charset = _CHARSET;
	}
	header('Content-Type: text/xml; charset="'.$charset.'"');
	if ($error) {
		echo '<?xml version="1.0" encoding="'.$charset.'"?'.">\n";
		echo "<response>\n";
		echo "<error>1</error>\n";
		echo "<message>$error_message</message>\n";
		echo "</response>";
		die();
	} else {
		echo '<?xml version="1.0" encoding="'.$charset.'"?'.">\n";
		echo "<response>\n";
		echo "<error>0</error>\n";
		echo "</response>";
	}
}
ENDIF;
?>