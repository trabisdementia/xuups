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

/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * A select box with available editors
 *
 * @copyright   The XOOPS project http://www.xoops.org/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package		core
 * @since       2.3.0
 * @author		Taiwen Jiang <phppp@users.sourceforge.net>
 * @version		$Id$
 */


class Xmf_Form_Element_Tray_Editor extends Xmf_Form_Element_Tray
{
    var $allowed_editors = array();
    var $form;
    var $value;
    var $name;
    var $nohtml;

    /**
     * Constructor
     *
     * @param	object	$form	the form calling the editor selection
     * @param	string	$name	editor name
     * @param	string	$value	Pre-selected text value
     * @param	bool	$noHtml	dohtml disabled
     */
    function __construct(&$form, $name = "editor", $value = null, $nohtml = false, $allowed_editors = array())
    {
        parent::__construct(_SELECT);
        $this->allowed_editors = $allowed_editors;
        $this->form		=& $form;
        $this->name		= $name;
        $this->value	= $value;
        $this->nohtml	= $nohtml;
    }

    function render()
    {
        $editor_handler = Xmf_Form_Element_Editor_Handler::getInstance();
        $editor_handler->allowed_editors = $this->allowed_editors;
        $option_select = new Xmf_Form_Element_Select("", $this->name, $this->value);
        $extra = 'onchange="if(this.options[this.selectedIndex].value.length > 0 ){
			window.document.forms.'.$this->form->getName().'.submit();
			}"';
        $option_select->setExtra($extra);
        $option_select->addOptionArray($editor_handler->getList($this->nohtml));

        $this->addElement($option_select);

        return parent::render();
    }
}
