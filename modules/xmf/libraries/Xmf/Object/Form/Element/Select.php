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

class Xmf_Object_Form_Element_Select extends Xmf_Form_ELement_Select
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

        // Adding the options inside this SelectBox
        // If the custom method is not from a module, than it's from the core
        $control = $object->getVarControl($key);

        $value = isset($control['value']) ? $control['value'] : $object->getVar($key, 'e');

        parent::__construct($var['title'], $key, $value, $size, $this->multiple);

        if (isset($control['options'])) {
            $this->addOptionArray($control['options']);
        } else {
            // let's find if the method we need to call comes from an already defined object
            if (isset($control['object'])) {
                if (method_exists($control['object'], $control['method'])) {
                    if ($option_array = $control['object']->$control['method']()) {
                        // Adding the options array to the XoopsFormSelect
                        $this->addOptionArray($option_array);
                    }
                }
            } else {
                // finding the itemHandler; if none, let's take the itemHandler of the $object
                if (isset($control['itemHandler'])) {
                    if (!$control['module']) {
                        // Creating the specified core object handler
                        $control_handler =& xoops_gethandler($control['itemHandler']);
                    } else {
                        $control_handler =& xoops_getmodulehandler($control['itemHandler'], $control['module']);
                    }
                } else {
                    $control_handler =& $object->handler;
                }

                // Checking if the specified method exists
                if (method_exists($control_handler, $control['method'])) {
                    // TODO : How could I pass the parameters in the following call ...
                    if ($option_array = $control_handler->$control['method']()) {
                        // Adding the options array to the XoopsFormSelect
                        $this->addOptionArray($option_array);
                    }
                }
            }
        }
    }
}