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

class Xmf_Form_Element_Password extends Xmf_Form_Element
{

    /**
     * Size of the field.
     * @var    int
     * @access    private
     */
    var $_size;

    /**
     * Maximum length of the text
     * @var    int
     * @access    private
     */
    var $_maxlength;

    /**
     * Initial content of the field.
     * @var    string
     * @access    private
     */
    var $_value;

    /**
     * Cache password with browser. Disabled by default for security consideration
     * Added in 2.3.1
     *
     * @var     boolean
     * @access    public
     */
    var $autoComplete = false;


    /**
     * Constructor
     *
     * @param    string     $caption        Caption
     * @param    string     $name           "name" attribute
     * @param    int        $size           Size of the field
     * @param    int        $maxlength      Maximum length of the text
     * @param    string     $value          Initial value of the field.
     *                                      <strong>Warning:</strong> this is readable in cleartext in the page's source!
     * @param    bool       $autoComplete   To enable autoComplete or browser cache
     */
    function __construct($caption, $name, $size, $maxlength, $value = "", $autoComplete = false)
    {
        $this->setCaption($caption);
        $this->setName($name);
        $this->_size = intval($size);
        $this->_maxlength = intval($maxlength);
        $this->setValue($value);
        $this->autoComplete = !empty($autoComplete);
    }

    /**
     * Get the field size
     *
     * @return    int
     */
    function getSize()
    {
        return $this->_size;
    }

    /**
     * Get the max length
     *
     * @return    int
     */
    function getMaxlength()
    {
        return $this->_maxlength;
    }

    /**
     * Get the "value" attribute
     *
     * @param    bool    $encode To sanitizer the text?
     * @return    string
     */
    function getValue($encode = false)
    {
        return $encode ? htmlspecialchars($this->_value, ENT_QUOTES) : $this->_value;
    }

    /**
     * Set the initial value
     *
     * @patam    $value    string
     */
    function setValue($value)
    {
        $this->_value = $value;
    }

    /**
     * Prepare HTML for output
     *
     * @return    string    HTML
     */
    function render()
    {
        $ele_name = $this->getName();
        return "<input type='password' name='{$ele_name}' id='{$ele_name}' size='" . $this->getSize() . "' maxlength='" . $this->getMaxlength() . "' value='" . $this->getValue() . "'" . $this->getExtra() . " " . ($this->autoComplete ? "" : "autocomplete='off' ") . "/>";
    }
}