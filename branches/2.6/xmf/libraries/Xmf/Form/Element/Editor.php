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
 * Xoops Editor element
 *
 * @copyright   The XOOPS project http://www.xoops.org/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package        core
 * @since       2.3.0
 * @author        Taiwen Jiang <phppp@users.sourceforge.net>
 * @version        $Id$
 */

class Xmf_Form_Element_Editor extends Xmf_Form_Element
{
    var $isEnabled;
    var $configs;
    var $rootPath;
    var $editor;

    /**
     * number of columns
     * @var	int
     * @access  private
     */
    var $_cols = 50;

    /**
     * number of rows
     * @var	int
     * @access  private
     */
    var $_rows = 5;

    /**
     * initial content
     * @var	string
     * @access  private
     */
    var $_value;

    /**
     * Constuctor
     *
     * @param	string  $caption    caption
     * @param	string  $name       name
     * @param	string  $value      initial content
     * @param	int     $rows       number of rows
     * @param	int     $cols       number of columns
     */
    function __construct($caption, $name, $configs = null, $nohtml = false, $OnFailure = "")
    {
        $configs["name"] = $name;

        $this->setCaption($caption);
        $this->setName($name);
        /*$this->_rows = intval($rows);
         $this->_cols = intval($cols);
         $this->setValue($value); */
        $editor_handler = Xmf_Form_Element_Editor_Handler::getInstance();
        $this->editor = $editor_handler->get($configs["editor"], $configs, $nohtml, $OnFailure);
    }

    function init($configs)
    {
        $this->rootPath = XMF_LIBRARIES_PATH . '/Form/Element/Editor';
        $this->configs = $configs;
        //$this->isActive();
    }

    /**
     * get number of rows
     *
     * @return	int
     */
    function getRows()
    {
        return $this->_rows;
    }

    /**
     * Get number of columns
     *
     * @return	int
     */
    function getCols()
    {
        return $this->_cols;
    }

    /**
     * Get initial content
     *
     * @param	bool    $encode To sanitizer the text? Default value should be "true"; however we have to set "false" for backward compat
     * @return	string
     */
    function getValue($encode = false)
    {
        return $encode ? htmlspecialchars($this->_value) : $this->_value;
    }

    /**
     * Set initial content
     *
     * @param	$value	string
     */
    function setValue($value)
    {
        $this->_value = $value;
    }

    /**
     * renderValidationJS
     * TEMPORARY SOLUTION to 'override' original renderValidationJS method
     * with custom XoopsEditor's renderValidationJS method
     */
    function renderValidationJS()
    {
        if (is_object($this->editor) && $this->isRequired()) {
            if (method_exists($this->editor,'renderValidationJS')) {
                $this->editor->setName($this->getName());
                $this->editor->setCaption($this->getCaption());
                $this->editor->_required = $this->isRequired();
                $ret = $this->editor->renderValidationJS();
                return $ret;
            } else {
                //parent::renderValidationJS();
            }
        }
        return '';
    }

    function render()
    {
        if (is_object($this->editor)) {
            return $this->editor->render();
        }
    }

    function isActive()
    {
        $this->isEnabled = true;
        return $this->isEnabled;
    }
}