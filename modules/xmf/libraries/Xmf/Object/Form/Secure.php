<?php
defined('XMF_EXEC') or die('Xmf was not detected');
Xmf_Language::load('form', 'xmf');

class Xmf_Object_Form_Secure extends Xmf_Object_Form
{
    function __construct(&$target, $form_name, $form_caption, $form_action, $form_fields = null, $submit_button_caption = false, $cancel_js_action = false, $captcha = false)
    {
        parent::__construct(&$target, $form_name, $form_caption, $form_action, $form_fields, $submit_button_caption, $cancel_js_action, $captcha);
        $this->addElement(new Xmf_Form_Element_Hidden_Token());
    }

}