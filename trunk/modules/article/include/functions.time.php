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
 * @version         $Id: functions.time.php 2283 2008-10-12 03:36:13Z phppp $
 */
 
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

include dirname(__FILE__) . "/vars.php";
define($GLOBALS["artdirname"] . "_FUNCTIONS_TIME_LOADED", TRUE);

if (!defined("ART_FUNCTIONS_TIME")):
define("ART_FUNCTIONS_TIME", 1);

/**
 * Function to convert UNIX time to formatted time string
 */
function art_formatTimestamp($time, $format = "c", $timeoffset = null)
{
    $artConfig = art_load_config();
    
    if (strtolower($format) == "reg" || strtolower($format) == "") {
        $format = "c";
    }
    if ( (strtolower($format) == "custom" || strtolower($format) == "c") && !empty($artConfig["formatTimestamp_custom"]) ) {
        $format = $artConfig["formatTimestamp_custom"];
    }
    
    xoops_load("xoopslocal");
    return XoopsLocal::formatTimestamp($time, $format, $timeoffset);
}
ENDIF;
?>