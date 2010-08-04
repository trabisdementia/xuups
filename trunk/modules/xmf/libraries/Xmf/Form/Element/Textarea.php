<?php

/**
 * A textarea
 *
 * @author	Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 *
 * @package     kernel
 * @subpackage  form
 */
class Xmf_Form_Element_Textarea extends Xmf_Form_Element
{
    /**
     * number of columns
     * @var	int
     * @access  private
     */
    var $_cols;

    /**
     * number of rows
     * @var	int
     * @access  private
     */
    var $_rows;

    /**
     * initial content
     * @var	string
     * @access  private
     */
    var $_value;

    /**
     * Constuctor
     *
     * @param	string  $caption    caption
     * @param	string  $name       name
     * @param	string  $value      initial content
     * @param	int     $rows       number of rows
     * @param	int     $cols       number of columns
     */
    function __construct($caption, $name, $value = "", $rows = 5, $cols = 50)
    {
        $this->setCaption($caption);
        $this->setName($name);
        $this->_rows = intval($rows);
        $this->_cols = intval($cols);
        $this->setValue($value);
    }

    /**
     * get number of rows
     *
     * @return	int
     */
    function getRows()
    {
        return $this->_rows;
    }

    /**
     * Get number of columns
     *
     * @return	int
     */
    function getCols()
    {
        return $this->_cols;
    }

    /**
     * Get initial content
     *
     * @param	bool    $encode To sanitizer the text? Default value should be "true"; however we have to set "false" for backward compat
     * @return	string
     */
    function getValue($encode = false)
    {
        return $encode ? htmlspecialchars($this->_value) : $this->_value;
    }

    /**
     * Set initial content
     *
     * @param	$value	string
     */
    function setValue($value)
    {
        $this->_value = $value;
    }

    /**
     * prepare HTML for output
     *
     * @return	sting HTML
     */
    function render()
    {
        return "<textarea name='".$this->getName()."' id='".$this->getName()."' rows='".$this->getRows()."' cols='".$this->getCols()."'".$this->getExtra().">".$this->getValue()."</textarea>";
    }
}