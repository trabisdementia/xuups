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

class Xmf_Object_Form_Element_Tray_Richfile extends Xmf_Form_Element_Tray
{
    /**
     * Get a config
     *
     * @param	string  $title   caption of the form element
     * @param	string  $key            key of the variable in the passed object
     * @param	object  $object         the passed object (target object) (@todo which object)
     */
    function __construct($title, $key, $object)
    {
        parent::__construct($title, '&nbsp;');
        if ($object->getVar('url') != '' ) {
            $caption = $object->getVar('caption') != '' ? $object->getVar('caption') : $object->getVar('url');
            $this->addElement( new Xmf_Form_Element_Label( '', _FORM_XMF_CURRENT_FILE."<a href='" . str_replace('{ICMS_URL}', ICMS_URL ,$object->getVar('url')) . "' target='_blank' >". $caption."</a><br/><br/>" ) );
            //$this->addElement( new XoopsFormLabel( '', "<br/><a href = '".SMARTOBJECT_URL."admin/file.php?op=del&fileid=".$object->id()."'>"._FORM_XUUPS_DELETE_FILE."</a>"));
        }

        if ($object->isNew()) {
            $this->addElement(new Xmf_Object_Form_Element_Upload_File($object, $key));
            $this->addElement(new Xmf_Form_Element_Label( '', '<br/><br/><small>'._FORM_XMF_URL_FILE_DSC.'</small>'));
            $this->addElement(new Xmf_Form_Element_Label( '','<br/>'._FORM_XMF_URL_FILE));
            $this->addElement(new Xmf_Object_Form_Element_Text($object, 'url_'.$key));
        }

        $this->addElement(new Xmf_Form_Element_Label( '', '<br/>'._FORM_XMF_CAPTION));
        $this->addElement(new Xmf_Object_Form_Element_Text($object, 'caption_'.$key));
        $this->addElement(new Xmf_Form_Element_Label( '', '<br/>'._FORM_XMF_DESC.'<br/>'));
        $this->addElement(new Xmf_Form_Element_Textarea('', 'desc_'.$key, $object->getVar('description')));

        if (!$object->isNew()) {
            $this->addElement(new Xmf_Form_Element_Label( '','<br/>'._FORM_XMF_CHANGE_FILE));
            $this->addElement(new Xmf_Object_Form_Element_Upload_File($object, $key));
            $this->addElement(new Xmf_Form_Element_Label( '', '<br/><br/><small>'._FORM_XMF_URL_FILE_DSC.'</small>'));
            $this->addElement(new Xmf_Form_Element_Label( '','<br/>'._FORM_XMF_URL_FILE));
            $this->addElement(new Xmf_Object_Form_Element_Text($object, 'url_'.$key));
        }
    }
}