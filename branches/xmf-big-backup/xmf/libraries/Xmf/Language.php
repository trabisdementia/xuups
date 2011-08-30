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

class Xmf_Language
{
    /**
     * Returns a translated string
     */
    public static function _($string, $default = null)
    {
   	    if (defined(strtoupper($string))) {
            return constant(strtoupper($string));
        } else {
            return self::translate($string, $default);
        }
    }

    public static function translate($string, $default = null)
    {
        if (isset($default)) $string = '';
        return $string;
    }

    public static function load($name, $domain = '', $language = null)
    {
        $language = empty($language) ? $GLOBALS['xoopsConfig']['language'] : $language;
        $path = XOOPS_ROOT_PATH . '/' . ( (empty($domain) || 'global' == $domain) ? '' : "modules/{$domain}/" ) . 'language';
        if (!$ret = Xmf_Loader::loadFile("{$path}/{$language}/{$name}.php")) {
            $ret = Xmf_Loader::loadFile("{$path}/english/{$name}.php");
        }
        return $ret;
    }
}