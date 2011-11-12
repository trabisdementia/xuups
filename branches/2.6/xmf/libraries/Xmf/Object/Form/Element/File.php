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

class Xmf_Object_Form_Element_File extends Xmf_Form_Element_File
{
    var $object;
    var $key;

    /**
     * Constructor
     * @param	object    $object   reference to targetobject (@link IcmsPersistableObject)
     * @param	string    $key      the form name
     */
    function __construct($object, $key)
    {
        $this->object = $object;
        $this->key = $key;
        parent::__construct($object->vars[$key]['title'], $key, isset($object->vars[$key]['form_maxfilesize']) ? $object->vars[$key]['form_maxfilesize'] : 0);
        $this->setExtra(" size=50");
    }


    /**
     * prepare HTML for output
     *
     * @return	string	$ret  the constructed HTML
     */
    function render()
    {
        $ret = '';
        if ($this->object->getVar($this->key) != '') {
            $ret .=	"<div>"._FORM_XUUPS_CURRENT_FILE."<a href='" . $this->object->getUploadDir().$this->object->getVar($this->key) . "' target='_blank' >". $this->object->getVar($this->key)."</a></div>" ;
        }

        $ret .= "<div><input type='hidden' name='MAX_FILE_SIZE' value='".$this->getMaxFileSize()."' />
            <input type='file' name='".$this->getName()."' id='".$this->getName()."'".$this->getExtra()." />
            <input type='hidden' name='icms_upload_file[]' id='icms_upload_file[]' value='".$this->getName()."' /></div>";

        return $ret;
    }
}