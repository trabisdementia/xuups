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
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Xmf
 * @since           0.1
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

class Xmf_Object_Form_Element_Select_User extends Xmf_Form_Select
{
    var $multiple = false;

    /**
     * Constructor
     * @param	object    $object   reference to targetobject (@link IcmsPersistableObject)
     * @param	string    $key      the form name
     */
    function __construct($object, $key)
    {
        $var = $object->vars[$key];
        $size = isset($var['size']) ? $var['size'] : ($this->multiple ? 5 : 1);

        parent::__construct($var['title'], $key, $object->getVar($key, 'e'), $size, $this->multiple);

        // Adding the options inside this SelectBox
        // If the custom method is not from a module, than it's from the core
        $control = $object->getControl($key);

        global $xoopsDB;
        $ret = array();
        $limit = $start = 0;
        $sql = 'SELECT uid, uname FROM '.$xoopsDB->prefix('users');
        $sql .= ' ORDER BY uname ASC';

        $result = $xoopsDB->query($sql);
        if ($result) {
            while ($myrow = $xoopsDB->fetchArray($result)) {
                $uArray[$myrow['uid']] = $myrow['uname'];
            }
        }
        $this->addOptionArray($uArray);

    }
}
