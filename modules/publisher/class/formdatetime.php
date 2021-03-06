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
 *  Publisher class
 *
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Publisher
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id$
 */
defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

include_once dirname(dirname(__FILE__)) . '/include/common.php';

class PublisherFormDateTime extends XoopsFormElementTray
{
    public function __construct($caption, $name, $size = 15, $value = 0)
    {
        parent::__construct($caption, '&nbsp;');
        $value = intval($value);
        $value = ($value > 0) ? $value : time();
        $datetime = getDate($value);
        $this->addElement(new XoopsFormTextDateSelect('', $name . '[date]', $size, $value));
        $timearray = array();
        for ($i = 0; $i < 24; $i++) {
            for ($j = 0; $j < 60; $j = $j + 10) {
                $key = ($i * 3600) + ($j * 60);
                $timearray[$key] = ($j != 0) ? $i . ':' . $j : $i . ':0' . $j;
            }
        }
        ksort($timearray);
        $timeselect = new XoopsFormSelect('', $name . '[time]', $datetime['hours'] * 3600 + 600 * floor($datetime['minutes'] / 10));
        $timeselect->addOptionArray($timearray);
        $this->addElement($timeselect);
    }
}