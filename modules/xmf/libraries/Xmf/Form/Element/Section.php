<?php

class Xmf_Form_Element_Section extends Xmf_Form_Element
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
     * @param	string  $sectionname    name of the form section
     * @param	bool    $value          value of the form section
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
    function getValue(){
        return $this->_value;
    }

    /**
     * Prepare HTML for output
     *
     * @return	string
     */
    function render(){
        return $this->getValue();
    }
}