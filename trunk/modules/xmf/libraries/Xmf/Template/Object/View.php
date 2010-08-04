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
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

class Xmf_Template_Object_View extends Xmf_Template_Abstract
{
    var $_object;
    var $_userSide;
    var $_rows;
    var $_actions;
    var $_headerAsRow=true;

    /**
    * Constructor
    */
    function __construct(Xmf_Object $object, $userSide=false, $actions=array(), $headerAsRow=true)
    {
        parent::__construct($this);
        $this->setTemplate(XMF_ROOT_PATH . '/templates/xmf_object_view.html');
        $this->_object =& $object;
        $this->_userSide = $userSide;
        $this->_actions = $actions;
        $this->_headerAsRow = $headerAsRow;
    }

    function addRow(Xmf_Template_Object_Row $rowObj)
    {
        $this->_rows[] = $rowObj;
    }

    function render()
    {
        $vars = $this->_object->vars;
        $object_array = array();

        foreach ($this->_rows as $row) {
            $key = $row->getKeyName();
            if ($row->_customMethodForValue && method_exists($this->_object, $row->_customMethodForValue)) {
                $method = $row->_customMethodForValue;
                $value = $this->_object->$method();
            } else {
                $value = $this->_object->getVar($row->getKeyName());
            }
            if ($row->isHeader()) {
                $this->tpl->assign('xmf_object_view_header_caption', $this->_object->vars[$key]['title']);
                $this->tpl->assign('xmf_object_view_header_value', $value);
            } else {
                $object_array[$key]['value'] = $value;
                $object_array[$key]['header'] = $row->isHeader();
                $object_array[$key]['caption'] = $this->_object->vars[$key]['title'];
            }
        }

        $action_row = '';
        if (in_array('edit', $this->_actions)) {
            $action_row .= $this->_object->getEditItemLink(false, true, true);
        }
        if (in_array('delete', $this->_actions)) {
            $action_row .= $this->_object->getDeleteItemLink(false, true, true);
        }
        if ($action_row) {
            $object_array['zaction']['value'] = $action_row;
            $object_array['zaction']['caption'] = _CO_SOBJECT_ACTIONS;
        }

        $this->tpl->assign('xmf_object_view_header_as_row', $this->_headerAsRow);
        $this->tpl->assign('xmf_object_view_array', $object_array);

    }

}
