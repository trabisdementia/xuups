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

class Xmf_Object_Form_Element_Tray_Image extends Xmf_Form_Element_Tray_Image
{

    /**
     * Constructor
     * @param	object    $object   reference to targetobject (@link IcmsPersistableObject)
     * @param	string    $key      the form name
     */
    function __construct($object, $key)
    {
        $var = $object->vars[$key];
        $object_imageurl = $object->getImageDir();
        parent::__construct( $var['title'], ' ');

        if (isset($objectArray['image'])) {
            $objectArray['image'] = str_replace('{ICMS_URL}', ICMS_URL, $objectArray['image']);
        }

        if ($object->getVar($key,'e') != '' && (substr($object->getVar($key,'e'), 0, 4) == 'http' || substr($object->getVar($key,'e'), 0, 11) == '{XOOPS_URL}')){
            $this->addElement( new Xmf_Form_Element_Label( '', "<img src='" . str_replace('{XOOPS_URL}', XOOPS_URL, $object->getVar($key,'e')) . "' alt='' /><br/><br/>" ) );
        } else if ($object->getVar($key,'e') != ''){
            $this->addElement( new Xmf_Form_Element_Label( '', "<img src='" . $object_imageurl . $object->getVar($key,'e') . "' alt='' /><br/><br/>" ) );
        }

        $this->addElement(new Xmf_Object_Form_Element_Upload_File($object, $key));

        $this->addElement(new Xmf_Form_Element_Label( '<div style="padding-top: 8px; font-size: 80%;">'._FORM_XMF_URL_FILE_DSC.'</div>', ''));

        $this->addElement(new Xmf_Form_Element_Label( '', '<br />' . _FORM_XMF_URL_FILE));
        $this->addElement(new Xmf_Form_Element_Text('', 'url_'.$key, 50, 500));

        if (!$object->isNew()) {
            $this->addElement(new Xmf_Form_Element_Label( '', '<br /><br />'));
            $delete_check = new Xmf_Form_Element_Checkbox_Check('', 'delete_'.$key);
            $delete_check->addOption(1, '<span style="color:red;">'._FORM_XMF_DELETE.'</span>');
            $this->addElement($delete_check);
        }
    }
}