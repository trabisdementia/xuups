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
 * @package         Xmf
 * @since           0.1
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: Dtype.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

class Xmf_Object_Dtype
{

    function cleanVars($obj, $k, $v, $cleanv)
    {
        return Xmf_Object_Dtype::_loadDtype($obj->vars[$k]['data_type'])->cleanVars($obj, $k, $v, $cleanv);
    }

    function getVar($obj, $key, $format, $ret)
    {
        return Xmf_Object_Dtype::_loadDtype($obj->vars[$key]['data_type'])->getVar($obj, $key, $format, $ret);

    }

    function getVarControl($key)
    {
        return Xmf_Object_Dtype::_loadDtype($key)->getVarControl($key);
    }

    function _loadDtype($name)
    {
        static $dtypes;

        $name = strtolower($name);
        if (!isset($dtypes[$name])) {
            $helper = null;
            if (@include_once dirname(__FILE__) . "/Dtype/{$name}.php") {
                $className = "Xmf_Object_Dtype_" . ucfirst($name);
                $dtype = new $className();
            }

            if (!is_object($dtype)) {
                return null;
            }
            $dtypes[$name] = $dtype;
            $dtypes[$name]->init();
        }

        return $dtypes[$name];
    }
}