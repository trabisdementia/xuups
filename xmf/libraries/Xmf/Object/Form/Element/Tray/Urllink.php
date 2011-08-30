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

class Xmf_Object_Form_Element_Tray_UrlLink extends Xmf_Form_Element_Tray
{
    /**
     * Constructor
     * @param   object    $title   the caption of the form
     * @param   string    $key            the key
     * @param   object    $object         reference to targetobject (@todo, which object will be passed here?)
     */
    function __construct($title, $key, $object)
    {
        parent::__construct($title, '&nbsp;');

        $this->addElement(new Xmf_Form_Element_Label('', '<br/>' . _FORM_XMF_URLLINK_URL));
        $this->addElement(new Xmf_Object_Form_Element_Text($object, 'url_' . $key));

        $this->addElement(new Xmf_Form_Element_Label('', '<br/>'._FORM_XMF_CAPTION));
        $this->addElement(new Xmf_Object_Form_Element_Text($object, 'caption_' . $key));

        $this->addElement(new Xmf_Form_Element_Label('', '<br/>' . _FORM_XMF_DESC . '<br/>'));
        $this->addElement(new Xmf_Form_Element_Textarea('', 'desc_' . $key, $object->getVar('description')));

        $this->addElement(new Xmf_Form_Element_Label('', '<br/>' . _FORM_XMF_URLLINK_TARGET));
        $targ_val = $object->getVar('target');
        $targetRadio = new Xmf_Form_Element_Radio('', 'target_' . $key, $targ_val!= '' ? $targ_val : '_blank');
        $control = $object->getControl('target');
        $targetRadio->addOptionArray($control['options']);

        $this->addElement($targetRadio);
    }
}

?>