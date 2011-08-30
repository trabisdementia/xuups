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
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Xmf
 * @since           0.1
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

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