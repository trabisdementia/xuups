<?php

/**
 * A select box with available themes
 *
 * @package     kernel
 * @subpackage  form
 *
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
class Xmf_Form_Element_Select_Theme extends Xmf_Form_Element_Select
{
	/**
	 * Constructor
	 *
	 * @param	string	$caption
	 * @param	string	$name
	 * @param	mixed	$value	Pre-selected value (or array of them).
	 * @param	int		$size	Number or rows. "1" makes a drop-down-list
	 */
	function __construct($caption, $name, $value = null, $size = 1)
	{
		parent::__construct($caption, $name, $value, $size);
		$this->addOptionArray(Xmf_Lists::getThemesList());
	}
}
