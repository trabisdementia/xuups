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
 * @package         Include
 * @since           1.1
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: common.php 0 2009-06-11 18:47:04Z trabis $
 */

defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

//XMF inclusion
if (!xoops_isActiveModule('xmf')) {
    if (file_exists($file = dirname(dirname(dirname(__FILE__))) . '/xmf/include/bootstrap.php')) {
        include_once $file;
        echo 'Please install or reactivate XMF module';
    } else {
        redirect_header(XOOPS_URL, 5, 'Please install XMF module');
    }
}


define("MYINVITER_DIRNAME", basename(dirname(dirname(__FILE__))));
define("MYINVITER_URL", XOOPS_URL . '/modules/' . MYINVITER_DIRNAME);
define("MYINVITER_ROOT_PATH", XOOPS_ROOT_PATH . '/modules/' . MYINVITER_DIRNAME);

define('MYINVITER_STATUS_WAITING', 0);
define('MYINVITER_STATUS_BLACKLIST', 1);
define('MYINVITER_STATUS_ERROR', 2);
define('MYINVITER_STATUS_NOTSENT', 3);
define('MYINVITER_STATUS_SENT', 4);

$myinviter = Xmf_Module_Helper::getInstance(MYINVITER_DIRNAME);
$myinviter->setDebug(true);
$GLOBALS['myinviter'] =& $myinviter;

include_once MYINVITER_ROOT_PATH . '/include/functions.php';