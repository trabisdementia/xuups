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
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id$
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

define("XOOPSPOLL_DIRNAME", basename(dirname(dirname(__FILE__))));
define("XOOPSPOLL_URL", XOOPS_URL . '/modules/' . XOOPSPOLL_DIRNAME);
define("XOOPSPOLL_ROOT_PATH", XOOPS_ROOT_PATH . '/modules/' . XOOPSPOLL_DIRNAME);

$xoopspoll = Xmf_Module_Helper::getInstance(XOOPSPOLL_DIRNAME);
$xoopspoll->setDebug(true);
$GLOBALS['xoopspoll'] =& $xoopspoll;