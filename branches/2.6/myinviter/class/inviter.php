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
 * @package         myinviter
 * @since           1.1
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id$
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

include_once dirname(dirname(__FILE__)) . '/OpenInviter/openinviter.php';

class MyinviterInviterHandler extends openinviter
{
    public $pluginTypes = array('email' => _MA_MYINVITER_EMAILPROVIDERS, 'social' => _MA_MYINVITER_SOCIALNETWORKS);

    public function __construct($db)
    {
        parent::__construct();
        //$this->configOK = true;
        //$this->internalError = false;
        $this->settings = array_merge($this->settings, array(
            'username' => 'TrabisDeMentia',
            'private_key' => '2698213935f6c3ab24134c0f2503926e',
            'cookie_path' => XOOPS_CACHE_PATH,
            'transport' => 'curl',
            'local_debug' => 'error',
         ));
    }
}