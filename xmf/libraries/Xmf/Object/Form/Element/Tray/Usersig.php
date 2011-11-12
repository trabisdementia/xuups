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

class Xmf_Object_Form_Element_Tray_Usersig extends Xmf_Form_Element_Tray
{

    /**
     * Constructor
     * @param	object    $object   reference to targetobject (@link IcmsPersistableObject)
     * @param	string    $key      the form name
     */
    function __construct($object, $key)
    {
        $var = $object->vars[$key];
        $control = $object->controls[$key];

        parent::__construct($var['title'], '<br /><br />', $key . '_signature_tray');

        $signature_textarea = new Xmf_Form_Element_Textarea_Dhtml('', $key, $object->getVar($key, 'e'));
        $this->addElement($signature_textarea);

        $attach_checkbox = new Xmf_Form_Element_Checkbox('', 'attachsig', $object->getVar('attachsig', 'e'));
        $attach_checkbox->addOption(1, _US_SHOWSIG);
        $this->addElement($attach_checkbox);
    }
}