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
 *  Publisher class
 *
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Include
 * @subpackage      Functions
 * @since           1.0
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


/** @define "PUBLISHER_DIRNAME" "publisher" */
define("PUBLISHER_DIRNAME", basename(dirname(dirname(__FILE__))));
define("PUBLISHER_URL", XOOPS_URL . '/modules/' . PUBLISHER_DIRNAME);
define("PUBLISHER_IMAGES_URL", PUBLISHER_URL . '/images');
define("PUBLISHER_ADMIN_URL", PUBLISHER_URL . '/admin');
define("PUBLISHER_UPLOADS_URL", XOOPS_URL . '/uploads/' . PUBLISHER_DIRNAME);

define("PUBLISHER_ROOT_PATH", XOOPS_ROOT_PATH . '/modules/' . PUBLISHER_DIRNAME);
define("PUBLISHER_UPLOADS_PATH", XOOPS_ROOT_PATH . '/uploads/' . PUBLISHER_DIRNAME);

xoops_loadLanguage('common', PUBLISHER_DIRNAME);

/** @define "PUBLISHER_DIRNAME" "publisher" */
include_once PUBLISHER_ROOT_PATH . '/include/functions.php';
include_once PUBLISHER_ROOT_PATH . '/include/constants.php';
include_once PUBLISHER_ROOT_PATH . '/include/seo_functions.php';
include_once PUBLISHER_ROOT_PATH . '/class/metagen.php';
include_once PUBLISHER_ROOT_PATH . '/class/session.php';
include_once PUBLISHER_ROOT_PATH . '/class/registry.php';

$publisher = Xmf_Module_Helper::getInstance(PUBLISHER_DIRNAME);
$publisher->setDebug(true);

//This is needed or it will not work in blocks.
global $publisher_isAdmin;

// Load only if module is installed
if (is_object($publisher->getObject())) {

    // Find if the user is admin of the module
    $publisher_isAdmin = publisher_userIsAdmin();

    // get current page
    $publisher_current_page = publisher_getCurrentPage();
}
?>