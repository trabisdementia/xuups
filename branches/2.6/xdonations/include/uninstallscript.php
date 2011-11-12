<?php
/**
 *  Uninstall Script
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @package::    xdonations
 * @subpackage:: admin
 * @author::	 zyspec (owners@zyspec.com)
 * @license::    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @since::      File available since version 1.96
 * @version::    $Id$
 */

include_once XOOPS_ROOT_PATH . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'cp_functions.php';
$xdonDir = basename ( dirname( dirname( __FILE__ ) ) ) ;
global $xoopsConfig;

xoops_loadLanguage('main', $xdonDir);

// Delete the ipn log file if it exists
$lpFile = XOOPS_UPLOAD_PATH . DIRECTORY_SEPARATOR . 'xdonations_ipn.log';
if (file_exists($lpFile)) {
    unlink($lpFile);
}
?>