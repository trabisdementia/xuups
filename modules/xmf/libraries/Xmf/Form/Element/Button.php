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
 * A button
 *
 * @author	Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 *
 * @package     kernel
 * @subpackage  form
 */
class Xmf_Form_Element_Button extends Xmf_Form_Element
{

    /**
     * Value
     * @var	string
     * @access	private
     */
    var $_value;

    /**
     * Type of the button. This could be either "button", "submit", or "reset"
     * @var	string
     * @access	private
     */
    var $_type;

    /**
     * Constructor
     *
     * @param	string  $caption    Caption
     * @param	string  $name
     * @param	string  $value
     * @param	string  $type       Type of the button. Potential values: "button", "submit", or "reset"
     */
    function __construct($caption, $name, $value = "", $type = "button")
    {
        $this->setCaption($caption);
        $this->setName($name);
        $this->_type = $type;
        $this->setValue($value);
    }

    /**
     * Get the initial value
     *
     * @param	bool    $encode To sanitizer the text?
     * @return	string
     */
    function getValue($encode = false)
    {
        return $encode ? htmlspecialchars($this->_value, ENT_QUOTES) : $this->_value;
    }

    /**
     * Set the initial value
     *
     * @return	string
     */
    function setValue($value)
    {
        $this->_value = $value;
    }

    /**
     * Get the type
     *
     * @return	string
     */
    function getType()
    {
        return in_array( strtolower($this->_type), array("button", "submit", "reset") ) ? $this->_type : "button";
    }

    /**
     * prepare HTML for output
     *
     * @return	string
     */
    function render()
    {
        return "<input type='" . $this->getType() . "' class='formButton' name='" . $this->getName() . "'  id='" . $this->getName() . "' value='" . $this->getValue() . "' title='" . $this->getValue() . "'" . $this->getExtra() . " />";
    }
}