<?php

/**
 * Contains the SmartObjectControl class
 *
 * @license GNU
 * @author marcan <marcan@smartfactory.ca>
 * @version $Id: smartformfileuploadelement.php 2345 2008-05-21 17:49:10Z fx2024 $
 * @link http://smartfactory.ca The SmartFactory
 * @package SmartObject
 * @subpackage SmartObjectForm
 */
include_once SMARTOBJECT_ROOT_PATH."class/form/elements/smartformuploadelement.php";
class SmartFormFileUploadElement extends SmartFormUploadElement {
    function SmartFormFileUploadElement($object, $key) {
        $this->SmartFormFileElement($object, $key);
        // Override name for upload purposes
        $this->setName('upload_'.$key);
    }
    /**
     * prepare HTML for output
     *
     * @return	string	HTML
     */
    function render(){
        return "<input type='hidden' name='MAX_FILE_SIZE' value='".$this->getMaxFileSize()."' />
        <input type='file' name='upload_".$this->getName()."' id='upload_".$this->getName()."'".$this->getExtra()." />
        <input type='hidden' name='smart_upload_file[]' id='smart_upload_file[]' value='".$this->getName()."' />";
    }
}
?>
