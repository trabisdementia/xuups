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
define("NEWBB_FUNCTIONS_LOADED", TRUE);

IF (!defined("NEWBB_FUNCTIONS")):
define("NEWBB_FUNCTIONS", 1);

load_functions();
mod_loadFunctions("image", "newbb");
mod_loadFunctions("user", "newbb");
mod_loadFunctions("render", "newbb");
mod_loadFunctions("forum", "newbb");
mod_loadFunctions("session", "newbb");
mod_loadFunctions("stats", "newbb");

endif;
?>