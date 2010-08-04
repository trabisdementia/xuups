<?php
class Xmf_Form_Element_Textarea_Sourceeditor extends Xmf_Form_Element_TextArea
{
    /*
     * Editor's class instance
     */
    private $editor = null;

    /**
     * Constructor
     * @param	object    $object   reference to targetobject (@link IcmsPersistableObject)
     * @param	string    $key      the form name
     */
    function __construct($title, $key, $value, $width = '100%', $height = '400px', $editor_name = null, $language='php')
    {
        parent::__construct($title, $key, $value);

        if ($editor_name == null) {
            global $xoopsConfig;
            $editor_name = $xoopsConfig['sourceeditor_default'];
        }

        require_once XOOPS_ROOT_PATH . '/class/xoopseditor.php';

        $editor_handler = XoopsEditorHandler::getInstance('source');
        $this->editor = &$editor_handler->get($editor_name, array('name' => $key,
            'value' => $value,
            'language' => $language,
            'width' => $width,
            'height' => $height));
    }

    /**
     * Renders the editor
     * @return	string  the constructed html string for the editor
     */
    function render()
    {
        if ($this->editor) {
            return $this->editor->render();
        } else {
            return parent::render();
        }
    }

}