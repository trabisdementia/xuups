<?php

/**
 * A text label
 *
 * @package     kernel
 * @subpackage  form
 *
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
class Xmf_Form_Element_Label extends Xmf_Form_Element
{

    /**
     * Text
     * @var	string
     * @access	private
     */
    var $_value;

    /**
     * Constructor
     *
     * @param	string	$caption	Caption
     * @param	string	$value		Text
     */
    function __construct($caption = "", $value = "", $name = "")
    {
        $this->setCaption($caption);
        $this->setName($name);
        $this->_value = $value;
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
     * Prepare HTML for output
     *
     * @return	string
     */
    function render()
    {
        return $this->getValue();
    }
}