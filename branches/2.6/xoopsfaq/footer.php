<?php
/**
 * Name: footer.php
 * Description: Footer for Xoops FAQ
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package : XOOPS
 * @Module : Xoops FAQ
 * @subpackage :
 * @since 2.3.0
 * @author John Neill
 * @version $Id$
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

/**
 * Module specific tpl includes
 */
$xoTheme->addStylesheet('browse.php?modules/' . $xoopsModule->getVar('dirname') . '/language/' . $xoopsConfig['language'] . '/css/module.css');
/*
$xoops_module_header = '<link rel="stylesheet" type="text/css" href="' . XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/templates/css/module.css" />';
$xoopsTpl->assign('xoops_module_header', $xoops_module_header);
*/
include_once XOOPS_ROOT_PATH . '/footer.php';