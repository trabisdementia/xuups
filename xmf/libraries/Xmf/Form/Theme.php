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
Xmf_Language::load('form', 'xmf');


/**
 * Form that will output as a theme-enabled HTML table
 *
 * Also adds JavaScript to validate required fields
 *
 * @author	Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 *
 * @package     kernel
 * @subpackage  form
 */
class Xmf_Form_Theme extends Xmf_Form
{
    /**
     * Insert an empty row in the table to serve as a seperator.
     *
     * @param	string  $extra  HTML to be displayed in the empty row.
     * @param	string	$class	CSS class name for <td> tag
     */
    function insertBreak($extra = '', $class= '')
    {
        $class = ($class != '') ? " class='".htmlspecialchars($class, ENT_QUOTES)."'" : '';
        //Fix for $extra tag not showing
        if ($extra) {
            $extra = "<tr><td colspan='2' $class>$extra</td></tr>";
            $this->addElement($extra);
        } else {
            $extra = "<tr><td colspan='2' $class>&nbsp;</td></tr>";
            $this->addElement($extra);
        }
    }

    /**
     * create HTML to output the form as a theme-enabled table with validation.
     *
     * @return	string
     */
    function render()
    {
        $ele_name = $this->getName();
        $ret = "
            <form name='".$ele_name."' id='".$ele_name."' action='".$this->getAction()."' method='".$this->getMethod()."' onsubmit='return xoopsFormValidate_".$ele_name."();'".$this->getExtra().">
            <table width='100%' class='outer' cellspacing='1'>
            <tr><th colspan='2'>".$this->getTitle()."</th></tr>
            ";
        $hidden = '';
        $class ='even';
        foreach ($this->getElements() as $ele) {
            if (!is_object($ele)) {
                $ret .= $ele;
            } elseif ( !$ele->isHidden() ) {
                $ret .= "<tr valign='top' align='left'><td class='head'>";
                if ( ($caption = $ele->getCaption()) != '' ) {
                    $ret .=
                        "<div class='xoops-form-element-caption" . ($ele->isRequired() ? "-required" : "" ) . "'>".
                        "<span class='caption-text'>{$caption}</span>".
                        "<span class='caption-marker'>*</span>".
                        "</div>";
                }
                if ( ($desc = $ele->getDescription()) != '' ) {
                    $ret .= "<div class='xoops-form-element-help'>{$desc}</div>";
                }
                $ret .= "</td><td class='$class'>".$ele->render()."</td></tr>\n";
            } else {
                $hidden .= $ele->render();
            }
        }
        $ret .= "</table>\n$hidden\n</form>\n";
        $ret .= $this->renderValidationJS( true );
        return $ret;
    }
}