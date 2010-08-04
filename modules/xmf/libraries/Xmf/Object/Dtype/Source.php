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

class Xmf_Object_Dtype_Source extends Xmf_Object_Dtype_Abstract
{

    function cleanVars($obj, $k, $v, $cleanv)
    {
        $cleanv = trim($cleanv);
        if (!$v['not_gpc']) {
            $cleanv = $this->ts->stripSlashesGPC($cleanv);
        } else {
            $cleanv = $cleanv;
        }
        $cleanv = $this->db->quote($cleanv);
        return $cleanv;
    }

    function getVar($obj, $key, $format, $ret)
    {
         switch (strtolower($format)) {
            case 's':
            case 'show':
                break 1;
            case 'e':
            case 'edit':
                return htmlspecialchars($ret, ENT_QUOTES);
                break 1;
            case 'p':
            case 'preview':
                return $this->ts->stripSlashesGPC($ret);
                break 1;
            case 'f':
            case 'formpreview':
                return htmlspecialchars($this->ts->stripSlashesGPC($ret), ENT_QUOTES);
                break 1;
            case 'n':
            case 'none':
            default:
                break 1;
         }
         return $ret;
    }

    function getVarControl()
    {
            return array('name' => 'textarea');
    }

}