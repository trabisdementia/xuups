<?php

class Xmf_Form_Element_Section_Close extends Xmf_Form_Element
{

    /**
     * Text
     * @var	string
     * @access	private
     */
    var $_value;

    /**
     * Constructor
     * @param	string    $sectionname  name of the section to close
     * @param	string    $value        value of the section to close
     */
    function __construct($sectionname, $value = false)
    {
        $this->setName($sectionname);
        $this->_value = $value;
    }

    /**
     * Get the text
     *
     * @return	string
     */
    function getValue()
    {
        return $this->_value;
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