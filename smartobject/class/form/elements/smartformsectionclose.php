<?php
if (!defined('XOOPS_ROOT_PATH')) {
    die("XOOPS root path not defined");
}

class SmartFormSectionClose extends XoopsFormElement {

    /**
     * Text
     * @var	string
     * @access	private
     */
    var $_value;

    function SmartFormSectionClose($sectionname, $value=false){
        $this->setName($sectionname);
        $this->_value = $value;
    }

    /**
     * Get the text
     *
     * @return	string
     */
    function getValue(){
        return $this->_value;
    }

    /**
     * Prepare HTML for output
     *
     * @return	string
     */
    function render(){
        return $this->getValue();
    }
}
?>