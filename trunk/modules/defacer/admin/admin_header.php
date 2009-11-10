<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Defacer
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: admin_header.php 0 2009-06-11 18:47:04Z trabis $
 */

require_once dirname(dirname(dirname(dirname(__FILE__)))) . '/include/cp_header.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

include_once dirname(dirname(__FILE__)) . '/include/common.php';
include_once dirname(__FILE__) . '/admin_functions.php';

if (!isset($xoopsTpl) || !is_object($xoopsTpl)) {
    include_once XOOPS_ROOT_PATH . '/class/template.php';
	$xoopsTpl = new XoopsTpl();
}
?>
