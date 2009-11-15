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
 * @copyright       The XUUPS Project http://www.xuups.com
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Myinviter
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: header.php 0 2009-11-14 18:47:04Z trabis $
 */

function_exists('curl_init') or die('Sorry, you need php curl extension to run this');
include_once dirname(dirname(dirname(__FILE__))) . '/mainfile.php';
include_once XOOPS_ROOT_PATH . '/modules/myinviter/include/functions.php';
include_once XOOPS_ROOT_PATH . '/modules/myinviter/class/openinviter.php';
?>