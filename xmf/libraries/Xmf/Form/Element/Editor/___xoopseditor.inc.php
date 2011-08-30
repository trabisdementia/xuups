<?php
/**
 * XoopsEditor initializer
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         class
 * @subpackage      editor
 * @since           2.3.0
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id$
 */

if (!function_exists("xoopseditor_get_rootpath")) {
    function xoopseditor_get_rootpath()
    {
        return dirname(__FILE__);
    }
}

if (defined("XOOPS_ROOT_PATH")) {
    return true;
}

$mainfile = dirname(dirname(dirname(__FILE__))) . "/mainfile.php";
if ( DIRECTORY_SEPARATOR != "/" ) $mainfile = str_replace( DIRECTORY_SEPARATOR, "/", $mainfile);

include $mainfile;
return defined("XOOPS_ROOT_PATH");
?>
