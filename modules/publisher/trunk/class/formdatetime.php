<?php

/**
* $Id: formdatetime.php 331 2007-12-23 16:01:11Z malanciault $
* Module: Espace1
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

/**
 * This control neeeed to be created as the minutes were "ceiled" in the Xoopsformdatetime, and
 * for publisher, we need them "floored"
 */

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

/**
 * Date and time selection field
 * 
 * @author	Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 * 
 * @package     kernel
 * @subpackage  form
 */
class PublisherFormDateTime extends XoopsFormElementTray
{

	function PublisherFormDateTime($caption, $name, $size = 15, $value=0)
	{
		$this->XoopsFormElementTray($caption, '&nbsp;');
		$value = intval($value);
		$value = ($value > 0) ? $value : time();
		$datetime = getDate($value);
		$this->addElement(new XoopsFormTextDateSelect('', $name.'[date]', $size, $value));
		$timearray = array();
		for ($i = 0; $i < 24; $i++) {
			for ($j = 0; $j < 60; $j = $j + 10) {
				$key = ($i * 3600) + ($j * 60);
				$timearray[$key] = ($j != 0) ? $i.':'.$j : $i.':0'.$j;
			}
		}
		ksort($timearray);
		$timeselect = new XoopsFormSelect('', $name.'[time]', $datetime['hours'] * 3600 + 600 * floor($datetime['minutes'] / 10));
		$timeselect->addOptionArray($timearray);
		$this->addElement($timeselect);
	}
}

?>
