<?php
/**
 * Newbb module
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
 * @package         newbb
 * @since           4.0
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: admin_header.php 2167 2008-09-23 13:33:57Z phppp $
 */

include "../../../include/cp_header.php";
include_once XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";
include_once XOOPS_ROOT_PATH . "/Frameworks/art/functions.admin.php";
xoops_loadLanguage("admin", $xoopsModule->getVar("dirname"));

$myts =& MyTextSanitizer::getInstance();

?>