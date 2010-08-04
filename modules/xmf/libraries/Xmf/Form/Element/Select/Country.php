<?php

/**
 * A select field with countries
 *
 * @package     kernel
 * @subpackage  form
 *
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
class Xmf_Form_Element_Select_Country extends Xmf_Form_Element_Select
{
	/**
	 * Constructor
	 *
	 * @param	string	$caption	Caption
	 * @param	string	$name       "name" attribute
	 * @param	mixed	$value	    Pre-selected value (or array of them).
     *                              Legal are all 2-letter country codes (in capitals).
	 * @param	int		$size	    Number or rows. "1" makes a drop-down-list
	 */
	function __construct($caption, $name, $value = null, $size = 1)
	{
		parent::__construct($caption, $name, $value, $size);
		$this->addOptionArray(Xmf_Lists::getCountryList());
	}
}
