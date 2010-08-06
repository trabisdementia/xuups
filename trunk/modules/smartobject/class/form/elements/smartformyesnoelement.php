<?php

/**
 * Contains the SmartObjectControl class
 *
 * @license GNU
 * @author marcan <marcan@smartfactory.ca>
 * @version $Id: smartformyesnoelement.php 159 2007-12-17 16:44:05Z malanciault $
 * @link http://smartfactory.ca The SmartFactory
 * @package SmartObject
 * @subpackage SmartObjectForm
 */
class SmartFormYesnoElement extends XoopsFormRadioYN {
    function SmartFormYesnoElement($object, $key) {
        $this->XoopsFormRadioYN($object->vars[$key]['form_caption'], $key, $object->getVar($key,'e'));
    }
}
?>