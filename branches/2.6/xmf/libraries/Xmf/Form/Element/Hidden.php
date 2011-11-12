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
 * A hidden field
 *
 * @package     kernel
 * @subpackage  form
 *
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
class Xmf_Form_Element_Hidden extends Xmf_Form_Element
{

    /**
     * Value
     * @var	string
     * @access	private
     */
    var $_value;

    /**
     * Constructor
     *
     * @param	string	$name	"name" attribute
     * @param	string	$value	"value" attribute
     */
    function __construct($name, $value)
    {
        $this->setName($name);
        $this->setHidden();
        $this->setValue($value);
        $this->setCaption("");
    }

    /**
     * Get the "value" attribute
     *
     * @param	bool    $encode To sanitizer the text?
     * @return	string
     */
    function getValue($encode = false)
    {
        return $encode ? htmlspecialchars($this->_value, ENT_QUOTES) : $this->_value;
    }

    /**
     * Sets the "value" attribute
     *
     * @patam  $value	string
     */
    function setValue($value)
    {
        $this->_value = $value;
    }

    /**
     * Prepare HTML for output
     *
     * @return	string	HTML
     */
    function render()
    {
        $ele_name = $this->getName();
        return "<input type='hidden' name='".$ele_name."' id='".$ele_name."' value='".$this->getValue()."' />";
    }
}