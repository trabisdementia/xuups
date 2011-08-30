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

class Xmf_Object_Form_Element_Upload_Image extends Xmf_Object_Form_Element_Upload
{

    /**
     * Constructor
     * @param	object    $object     object to be passed (@todo : Which object?)
     * @param	string    $key        key of the object to be passed
     */
    function __construct($object, $key)
    {
        parent::__construct($object, $key);
        // Override name for upload purposes
        $this->setName('upload_'.$key);
    }

    /**
     * prepare HTML for output
     *
     * @return	string	HTML
     */
    function render()
    {
        return "<input type='hidden' name='MAX_FILE_SIZE' value='".$this->getMaxFileSize()."' />
        <input type='file' name='".$this->getName()."' id='".$this->getName()."'".$this->getExtra()." />
        <input type='hidden' name='xoops_upload_image[]' id='xoops_upload_image[]' value='".$this->getName()."' />";
    }
}