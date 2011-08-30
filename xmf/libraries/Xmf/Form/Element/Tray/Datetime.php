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

/**
 *
 *
 * @package     kernel
 * @subpackage  form
 *
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */

/**
 * Date and time selection field
 *
 * @author	Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 *
 * @package     kernel
 * @subpackage  form
 */
class Xmf_Form_Element_Tray_Datetime extends Xmf_Form_Element_Tray
{

    function __construct($caption, $name, $size = 15, $value=0)
    {
        parent::__construct($caption, '&nbsp;');
        $value = intval($value);
        $value = ($value > 0) ? $value : time();
        $datetime = getDate($value);
        $this->addElement(new Xmf_Form_Element_Text_DateSelect('', $name.'[date]', $size, $value));
        $timearray = array();
        for ($i = 0; $i < 24; $i++) {
            for ($j = 0; $j < 60; $j = $j + 10) {
                $key = ($i * 3600) + ($j * 60);
                $timearray[$key] = ($j != 0) ? $i . ':' . $j : $i . ':0' . $j;
            }
        }
        ksort($timearray);
        $timeselect = new Xmf_Form_Element_Select('', $name.'[time]', $datetime['hours'] * 3600 + 600 * ceil($datetime['minutes'] / 10));
        $timeselect->addOptionArray($timearray);
        $this->addElement($timeselect);
    }
}