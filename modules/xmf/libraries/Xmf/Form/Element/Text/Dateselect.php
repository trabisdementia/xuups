<?php
/**
 * A text field with calendar popup
 *
 * @package     kernel
 * @subpackage  form
 *
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */

class Xmf_Form_Element_Text_Dateselect extends Xmf_Form_Element_Text
{

	function __construct($caption, $name, $size = 15, $value= 0)
	{
		$value = !is_numeric($value) ? time() : intval($value);
		parent::__construct($caption, $name, $size, 25, $value);
	}

	function render()
	{
    	$ele_name = $this->getName();
		$ele_value = $this->getValue(false);
		$jstime = formatTimestamp( $ele_value, 'F j Y, H:i:s' );
		include_once XOOPS_ROOT_PATH . '/include/calendarjs.php';
		return "<input type='text' name='".$ele_name."' id='".$ele_name."' size='".$this->getSize()."' maxlength='".$this->getMaxlength()."' value='".date("Y-m-d", $ele_value)."'".$this->getExtra()." /><input type='reset' value=' ... ' onclick='return showCalendar(\"".$ele_name."\");'>";
	}
}