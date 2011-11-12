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

class Xmf_Object_Dtype_Email extends Xmf_Object_Dtype_Abstract
{
    function cleanVars($obj, $k, $v, $cleanv)
    {
        $cleanv = trim($cleanv);
        if ($v['required'] && $cleanv == '') {
            $obj->setErrors(sprintf(_XMF_OBJ_ERR_REQUIRED, $k));
            return $cleanv;
        }
        if ($cleanv != '' && !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i",$cleanv)) {
            $obj->setErrors("Invalid Email");
            return $cleanv;
        }
        if (!$v['not_gpc']) {
            $cleanv = $this->ts->stripSlashesGPC($cleanv);
        }
        $cleanv = $this->db->quote($cleanv);
        return $cleanv;
    }

    function getVarControl()
    {
        return array('name' => 'text');
    }
}
