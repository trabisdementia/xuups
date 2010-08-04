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

class Xmf_Object_Dtype_Textarea extends Xmf_Object_Dtype_Abstract
{

    function cleanVars($obj, $k, $v, $cleanv)
    {
        if ($v['required'] && $cleanv != '0' && $cleanv == '') {
            $errors[] = sprintf( _XMF_OBJ_ERR_REQUIRED, $k );
            continue;
        }
        if (!$v['not_gpc']) {
            if ( !empty($vars['dohtml']['value']) ) {
                $cleanv = $this->ts->textFilter($cleanv);
            }
            $cleanv = $this->ts->stripSlashesGPC($this->ts->censorString($cleanv));
        } else {
            $cleanv = $this->ts->censorString($cleanv);
        }
        $cleanv = $this->db->quote($cleanv);
        return $cleanv;
    }

    function getVar($obj, $key, $format, $ret)
    {
         switch (strtolower($format)) {
            case 's':
            case 'show':
                $html = !empty($obj->vars['dohtml']['value']) ? 1 : 0;
                $xcode = (!isset($obj->vars['doxcode']['value']) || $obj->vars['doxcode']['value'] == 1) ? 1 : 0;
                $smiley = (!isset($obj->vars['dosmiley']['value']) || $obj->vars['dosmiley']['value'] == 1) ? 1 : 0;
                $image = (!isset($obj->vars['doimage']['value']) || $obj->vars['doimage']['value'] == 1) ? 1 : 0;
                $br = (!isset($obj->vars['dobr']['value']) || $obj->vars['dobr']['value'] == 1) ? 1 : 0;
                return $this->ts->displayTarea($ret, $html, $smiley, $xcode, $image, $br);
                break 1;
            case 'e':
            case 'edit':
                return htmlspecialchars($ret, ENT_QUOTES);
                break 1;
            case 'p':
            case 'preview':
                $html = !empty($obj->vars['dohtml']['value']) ? 1 : 0;
                $xcode = (!isset($obj->vars['doxcode']['value']) || $obj->vars['doxcode']['value'] == 1) ? 1 : 0;
                $smiley = (!isset($obj->vars['dosmiley']['value']) || $obj->vars['dosmiley']['value'] == 1) ? 1 : 0;
                $image = (!isset($obj->vars['doimage']['value']) || $obj->vars['doimage']['value'] == 1) ? 1 : 0;
                $br = (!isset($obj->vars['dobr']['value']) || $obj->vars['dobr']['value'] == 1) ? 1 : 0;
                return $this->ts->previewTarea($ret, $html, $smiley, $xcode, $image, $br);
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