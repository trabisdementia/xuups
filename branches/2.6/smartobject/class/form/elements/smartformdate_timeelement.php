<?php

/**
 * Contains the SmartObjectControl class
 *
 * @license GNU
 * @author marcan <marcan@smartfactory.ca>
 * @version $Id: smartformdate_timeelement.php 159 2007-12-17 16:44:05Z malanciault $
 * @link http://smartfactory.ca The SmartFactory
 * @package SmartObject
 * @subpackage SmartObjectForm
 */
class SmartFormDate_timeElement extends XoopsFormDateTime {
    function SmartFormDate_timeElement($object, $key) {
        $this->XoopsFormDateTime($object->vars[$key]['form_caption'], $key, 15, $object->getVar($key, 'e'));
    }
}
?>