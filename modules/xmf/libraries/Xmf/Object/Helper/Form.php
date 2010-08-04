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
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Xmf
 * @since           0.1
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

class Xmf_Object_Helper_Form extends Xmf_Object_Helper_Abstract
{

    /**
     * Set control information for an instance variable
     *
     * The $options parameter can be a string or an array. Using a string
     * is the quickest way :
     *
     * $this->setControl('date', 'date_time');
     *
     * This will create a date and time selectbox for the 'date' var on the
     * form to edit or create this item.
     *
     * Here are the currently supported controls :
     *
     *      - color
     *      - country
     *      - date_time
     *      - date
     *      - email
     *      - group
     *      - group_multi
     *      - image
     *      - imageupload
     *      - label
     *      - language
     *      - parentcategory
     *      - password
     *      - select_multi
     *      - select
     *      - text
     *      - textarea
     *      - theme
     *      - theme_multi
     *      - timezone
     *      - user
     *      - user_multi
     *      - yesno
     *
     * Now, using an array as $options, you can customize what information to
     * use in the control. For example, if one needs to display a select box for
     * the user to choose the status of an item. We only need to tell IcmsPersistableObject
     * what method to execute within what handler to retreive the options of the
     * selectbox.
     *
     * $this->setControl('status', array('name' => false,
     *                                   'itemHandler' => 'item',
     *                                   'method' => 'getStatus',
     *                                   'module' => 'smartshop'));
     *
     * In this example, the array elements are the following :
     *      - name : false, as we don't need to set a special control here.
     *               we will use the default control related to the object type (defined in initVar)
     *      - itemHandler : name of the object for which we will use the handler
     *      - method : name of the method of this handler that we will execute
     *      - module : name of the module from wich the handler is
     *
     * So in this example, IcmsPersistableObject will create a selectbox for the variable 'status' and it will
     * populate this selectbox with the result from SmartshopItemHandler::getStatus()
     *
     * Another example of the use of $options as an array is for TextArea :
     *
     * $this->setControl('body', array('name' => 'textarea',
     *                                   'form_editor' => 'default'));
     *
     * In this example, IcmsPersistableObject will create a TextArea for the variable 'body'. And it will use
     * the 'default' editor, providing it is defined in the module
     * preferences : $icmsModuleConfig['default_editor']
     *
     * Of course, you can force the use of a specific editor :
     *
     * $this->setControl('body', array('name' => 'textarea',
     *                                   'form_editor' => 'koivi'));
     *
     * Here is a list of supported editor :
     *      - tiny : TinyEditor
     *      - dhtmltextarea : ImpressCMS DHTML Area
     *      - fckeditor : FCKEditor
     *      - inbetween : InBetween
     *      - koivi : Koivi
     *      - spaw : Spaw WYSIWYG Editor
     *      - htmlarea : HTMLArea
     *      - textarea : basic textarea with no options
     *
     * @param string $var name of the variable for which we want to set a control
     * @param array $options
     */

    /**
     * Get control information for an instance variable
     *
     * @param string $var
     */
    function getVarControl($key)
    {
        return isset($this->object->vars[$key]['control']) ? $this->object->vars[$key]['control'] : false;
    }


    /**
     * assign a value to a variable
     *
     * @access public
     * @param string $key name of the variable to assign
     * @param mixed $value value to assign
     */
    function assignVarControl($key, $control)
    {
        if (isset($key) && isset($this->object->vars[$key])) {
            if (is_string($control)) {
                $control = array('name' => $control);
            }
            $this->object->vars[$key]['control'] = $control;
        }
    }

    function assignVarDisplay($key, $value) {
        $this->object->assignVarKey($key, 'form_display', $value);
    }

    /**
     * Display an automatic SingleView of the object, based on the displayOnSingleView param of each vars
     *
     * @param bool $fetchOnly if set to TRUE, then the content will be return, if set to FALSE, the content will be outputed
     * @param bool $userSide for futur use, to do something different on the user side
     * @return content of the template if $fetchOnly or nothing if !$fetchOnly
     */
    function displaySingleObject($fetchOnly=false, $userSide=false, $actions=array(), $headerAsRow=true) {

        $singleview = new Xuups_Object_Single($this, $userSide, $actions, $headerAsRow);
        // add all fields mark as displayOnSingleView except the keyid
        foreach($this->vars as $key=>$var) {
            if ($key != $this->handler->keyName && $var['displayOnSingleView']) {
                $is_header = ($key == $this->handler->identifierName);
                $singleview->addRow(new Xuups_Object_Row($key, false, $is_header));
            }
        }

        if ($fetchOnly) {
            return $singleview->fetch();
        }else {
            $singleview->render();
        }
    }


    function init()
    {
        $this->object->loadHelper('caption');
        foreach ($this->object->vars as $k => $v) {
            $this->_initControls($k);
            $this->_initVars($k);
        }
        return $this->object;
    }

    function _initVars($key)
    {
       $this->assignVarDisplay($key, true);
    }

    function _initControls($key, $title = '', $description = '')
    {
        $ret = Xmf_Object_Dtype::getVarControl($this->object->vars[$key]['data_type']);
        $this->assignVarControl($key, $ret);
    }

    /**
    * Create the form for this object
    *
    * @return a {@link SmartobjectForm} object for this object
    *
    * @see IcmsPersistableObjectForm::IcmsPersistableObjectForm()
    */
    function getForm($title, $form_name, $form_action=false, $submit_button_caption = _XMF_SUBMIT, $cancel_js_action=false, $captcha=false)
    {
        $form = new Xmf_Object_Form($this->object, $form_name, $title, $form_action, null, $submit_button_caption, $cancel_js_action, $captcha);
        return $form;
    }

    /**
    * Create the secure form for this object
    *
    * @return a {@link SmartobjectForm} object for this object
    *
    * @see IcmsPersistableObjectForm::IcmsPersistableObjectForm()
    */
    function getSecureForm($title, $form_name, $form_action=false, $submit_button_caption = _XMF_SUBMIT, $cancel_js_action=false, $captcha=false)
    {
        $form = new Xmf_Object_Form_Secure($this, $form_name, $title, $form_action, null, $submit_button_caption, $cancel_js_action, $captcha);
        return $form;
    }

}