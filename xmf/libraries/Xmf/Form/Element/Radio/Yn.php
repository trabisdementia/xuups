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
 * Yes/No radio buttons.
 *
 * A pair of radio buttons labelled _YES and _NO with values 1 and 0
 *
 * @package     kernel
 * @subpackage  form
 *
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
class Xmf_Form_Element_Radio_Yn extends Xmf_Form_Element_Radio
{
    /**
     * Constructor
     *
     * @param	string	$caption
     * @param	string	$name
     * @param	string	$value		Pre-selected value, can be "0" (No) or "1" (Yes)
     * @param	string	$yes		String for "Yes"
     * @param	string	$no			String for "No"
     */
    function __construct($caption, $name, $value = null, $yes = _YES, $no = _NO)
    {
        parent::__construct($caption, $name, $value);
        $this->addOption(1, $yes);
        $this->addOption(0, $no);
    }
}