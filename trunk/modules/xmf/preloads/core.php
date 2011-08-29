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
 * @package         Xmf
 * @since           0.1
 * @author          Gr�gory Mage (Aka Mage)
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

class XmfCorePreload extends XoopsPreloadItem
{
    function eventCoreIncludeCommonEnd($args)
    {
        if (file_exists($filename = XOOPS_ROOT_PATH . '/modules/xmf/include/bootstrap.php')) {
            include_once $filename;
        }
    }
}