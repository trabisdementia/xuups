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
 * @version         $Id: core.php 0 2009-11-14 18:47:04Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

class MyinviterCorePreload extends XoopsPreloadItem
{

    function eventCoreHeaderStart($args)
    {
        if (MyinviterCorePreload::isActive()) {
            if (file_exists($filename = XOOPS_ROOT_PATH . '/modules/myinviter/include/functions.php')) {
                include_once $filename;
                myinviter_sendEmails();
            }
        }
    }

    function isActive()
    {
        $module_handler = xoops_getHandler('module');
        $module = $module_handler->getByDirname('myinviter');
        return ($module && $module->getVar('isactive')) ? true : false;
    }

}
?>