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
 * XoopsFormColorPicker component class file
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         kernel
 * @subpackage      form
 * @since           2.0.0
 * @author          Zoullou <webmaster@zoullou.org>
 * @version         $Id$
 */

class Xmf_Form_Element_Text_Colorpicker extends Xmf_Form_Element_Text
{
    function __construct($caption, $name, $value = "#FFFFFF")
    {
        parent::__construct($caption, $name, 9, 7, $value);
    }

    function render()
    {
        if (isset($GLOBALS['xoTheme'])) {
            $GLOBALS['xoTheme']->addScript('include/color-picker.js');
        } else {
            echo "<script type=\"text/javascript\" src=\"".XOOPS_URL."/include/color-picker.js\"></script>";
        }
        $this->setExtra(' style="background-color:' . $this->getValue() . ';"');
        return parent::render() . "\n<input type='reset' value=' ... ' onclick=\"return TCP.popup('" . XOOPS_URL . "/include/',document.getElementById('" . $this->getName() . "'));\">\n";
    }

    /**
     * Returns custom validation Javascript
     *
     * @return	string	Element validation Javascript
     */
    function renderValidationJS()
    {
        $eltname    = $this->getName();
        $eltcaption = $this->getCaption();
        $eltmsg = empty($eltcaption) ? sprintf( _FORM_ENTER, $eltname ) : sprintf( _FORM_ENTER, $eltcaption );

        return "if ( !(new RegExp(\"^#[0-9a-fA-F]{6}\",\"i\").test(myform.{$eltname}.value)) ) { window.alert(\"{$eltmsg}\"); myform.{$eltname}.focus(); return false; }";
    }

}