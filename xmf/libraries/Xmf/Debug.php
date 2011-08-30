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
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

class Xmf_Debug
{
    /**
     * Output a dump of a variable
     *
     * @param string $var variable which will be dumped
     */
    function dump($var, $echo = true, $exit = false)
    {
        $myts = Xmf_Sanitizer::getInstance();
        $msg = $myts->displayTarea(var_export($var, true));
        $msg = "<div style='padding: 5px; font-weight: bold'>{$msg}</div>";
        if (!$echo) {
            return $msg;
        }
        echo $msg;
        if ($exit) {
            die();
        }
    }
}