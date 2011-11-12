<?php
/**
 * XoopsPartners module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright::  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license::    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package::    XoopsPartners
 * @subpackage:: admin
 * @since::		 2.5.0
 * @author::     XOOPS Team
 * @version::    $Id $
**/

include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/mainfile.php';
include_once dirname(dirname(__FILE__)) . '/include/common.php';
include_once XOOPS_ROOT_PATH . '/include/cp_header.php';

 $module_handler =& xoops_gethandler('module');
 $xoopsModule =& XoopsModule::getByDirname('xoopspoll');
 $moduleInfo =& $module_handler->get($xoopsModule->getVar('mid'));
 $pathIcon16 = $moduleInfo->getInfo('icons16');
 $pathIcon32 = $moduleInfo->getInfo('icons32');

 //Load languages
 xoops_loadLanguage('admin', $xoopsModule->getVar("dirname"));
 xoops_loadLanguage('modinfo', $xoopsModule->getVar("dirname"));
 xoops_loadLanguage('main', $xoopsModule->getVar("dirname"));