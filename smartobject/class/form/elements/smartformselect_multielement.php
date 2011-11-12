<?php

/**
 * Contains the SmartObjectControl class
 *
 * @license GNU
 * @author marcan <marcan@smartfactory.ca>
 * @version $Id: smartformselect_multielement.php 159 2007-12-17 16:44:05Z malanciault $
 * @link http://smartfactory.ca The SmartFactory
 * @package SmartObject
 * @subpackage SmartObjectForm
 */
include_once (SMARTOBJECT_ROOT_PATH . "class/form/elements/smartformselectelement.php");

class SmartFormSelect_multiElement extends SmartFormSelectElement  {
    function SmartFormSelect_multiElement($object, $key) {
        $this->multiple = true;
        parent::SmartFormSelectElement($object, $key);
    }
}
?>