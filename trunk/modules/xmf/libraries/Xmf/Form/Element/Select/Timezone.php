<?php

/**
 * A select box with timezones
 *
 * @package     kernel
 * @subpackage  form
 *
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
class Xmf_Form_Element_Select_Timezone extends Xmf_Form_Element_Select
{
	/**
	 * Constructor
	 *
	 * @param	string	$caption
	 * @param	string	$name
	 * @param	mixed	$value	Pre-selected value (or array of them).
	 * 							Legal values are "-12" to "12" with some ".5"s strewn in ;-)
	 * @param	int		$size	Number of rows. "1" makes a drop-down-box.
	 */
	function __construct($caption, $name, $value = null, $size = 1)
	{
		parent::__construct($caption, $name, $value, $size);
		$this->addOptionArray(Xmf_Lists::getTimeZoneList());
	}
}
