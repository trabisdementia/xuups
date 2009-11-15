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
 * @version         $Id: admin_header.php 0 2009-11-14 18:47:04Z trabis $
 */

include_once dirname(dirname(dirname(dirname(__FILE__)))) .'/include/cp_header.php';
include_once dirname(dirname(__FILE__)) . '/include/functions.php';

$xoopsModuleConfig = myinviter_getModuleConfig(); //must come first
$xoopsModule = myinviter_getModuleHandler();

$myts = MyTextSanitizer::getInstance();

xoops_loadLanguage('admin', 'myinviter');
xoops_loadLanguage('modinfo', 'myinviter');

?>