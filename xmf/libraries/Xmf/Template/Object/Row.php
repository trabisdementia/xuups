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
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Xmf
 * @since           0.1
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

class Xmf_Template_Object_Row
{
    var $_keyname;
    var $_align;
    var $_customMethodForValue;
    var $_header;
    var $_class;

    function __construct($keyname, $customMethodForValue = false, $header = false, $class = false)
    {
        $this->_keyname = $keyname;
        $this->_customMethodForValue = $customMethodForValue;
        $this->_header = $header;
        $this->_class = $class;
    }

    function getKeyName()
    {
        return $this->_keyname;
    }

    function isHeader()
    {
        return $this->_header;
    }
}
