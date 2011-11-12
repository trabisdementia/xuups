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

class Xmf_Object_Dtype_Abstract
{
    var $db;
    var $ts;

    function init()
    {
        $this->db =& XoopsDatabaseFactory::getDatabaseConnection();
        $this->ts =& Xmf_Sanitizer::getInstance();
    }

    function cleanVars($obj, $k, $v, $cleanv)
    {
        $cleanv = $this->db->quote($cleanv);
        return $cleanv;
    }

    function getVar($obj, $key, $format, $ret)
    {
        if ($obj->vars[$key]['options'] != '' && $ret != '') {
            switch (strtolower($format)) {
                case 's':
                case 'show':
                    $selected = explode('|', $ret);
                    $options = explode('|', $obj->vars[$key]['options']);
                    $i = 1;
                    $ret = array();
                    foreach ($options as $op) {
                        if (in_array($i, $selected)) {
                            $ret[] = $op;
                        }
                        $i++;
                    }
                    return implode(', ', $ret);
                case 'e':
                case 'edit':
                    $ret = explode('|', $ret);
                    break 1;
                default:
                    break 1;
            }
        }
        return $ret;
    }

    function getVarControl($key)
    {
        return array('name' => 'select');
    }

}