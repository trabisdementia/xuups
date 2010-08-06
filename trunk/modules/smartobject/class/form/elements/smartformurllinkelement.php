<?php

/**
 * Contains the SmartObjectControl class
 *
 * @license GNU
 * @author marcan <marcan@smartfactory.ca>
 * @version $Id: smartformurllinkelement.php 159 2007-12-17 16:44:05Z malanciault $
 * @link http://smartfactory.ca The SmartFactory
 * @package SmartObject
 * @subpackage SmartObjectForm
 */
class SmartFormUrlLinkElement extends XoopsFormElementTray {
    function SmartFormUrlLinkElement($form_caption, $key, $object) {
        $this->XoopsFormElementTray($form_caption, '&nbsp;' );

        $this->addElement( new XoopsFormLabel( '', '<br/>'._CO_SOBJECT_URLLINK_URL));
        $this->addElement(new SmartFormTextElement($object, 'url_'.$key));

        $this->addElement( new XoopsFormLabel( '', '<br/>'._CO_SOBJECT_CAPTION));
        $this->addElement(new SmartFormTextElement($object, 'caption_'.$key));

        $this->addElement( new XoopsFormLabel( '', '<br/>'._CO_SOBJECT_DESC.'<br/>'));
        $this->addElement(new XoopsFormTextArea('', 'desc_'.$key, $object->getVar('description')));

        $this->addElement( new XoopsFormLabel( '', '<br/>'._CO_SOBJECT_URLLINK_TARGET));
        $targ_val = $object->getVar('target');
        $targetRadio = new XoopsFormRadio('', 'target_'.$key, $targ_val!= '' ? $targ_val : '_blank');
        $control = $object->getControl('target');
        $targetRadio->addOptionArray($control['options']);

        $this->addElement($targetRadio);
    }
}
?>