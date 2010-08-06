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
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

class Xmf_Object_Dtype_Array extends Xmf_Object_Dtype_Abstract
{
    function cleanVars($obj, $k, $v, $cleanv)
    {
        if (!$v['not_gpc']){
            $cleanv = array_map(array(&$this->ts, "stripSlashesGPC"), $cleanv);
        }
        foreach (array_keys($cleanv) as $key) {
            $cleanv[$key] = str_replace('\\"', '"', addslashes($cleanv[$key]));
        }

        // TODO: Not encoding safe, should try base64_encode -- phppp
        $cleanv = "'" . serialize($cleanv) . "'";
        return $cleanv;
    }

    function getVar($obj, $key, $format, $ret)
    {
        if (!is_array($ret)) {
            if ($ret != "") {
                $ret = @unserialize( $ret );
            }
            $ret = is_array($ret) ? $ret : array();
        }

        return $ret;
    }

    function getVarControl()
    {
        return array('name' => 'text');
    }
}