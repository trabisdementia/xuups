<?php

/**
 * Contains the SmartObjectControl class
 *
 * @license GNU
 * @author marcan <marcan@smartfactory.ca>
 * @version $Id: smartformuploadelement.php 159 2007-12-17 16:44:05Z malanciault $
 * @link http://smartfactory.ca The SmartFactory
 * @package SmartObject
 * @subpackage SmartObjectForm
 */
class SmartFormUploadElement extends XoopsFormFile {
    function SmartFormFileElement($object, $key) {
        $this->XoopsFormFile(_CO_SOBJECT_UPLOAD, $key, isset($object->vars[$key]['form_maxfilesize']) ? $object->vars[$key]['form_maxfilesize'] : 0);
        $this->setExtra(" size=50");
    }
    /**
     * prepare HTML for output
     *
     * @return	string	HTML
     */
    function render(){
        return "<input type='hidden' name='MAX_FILE_SIZE' value='".$this->getMaxFileSize()."' />
		        <input type='file' name='".$this->getName()."' id='".$this->getName()."'".$this->getExtra()." />
		        <input type='hidden' name='smart_upload_file[]' id='smart_upload_file[]' value='".$this->getName()."' />";
    }
}
?>