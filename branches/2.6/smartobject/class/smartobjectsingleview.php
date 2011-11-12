<?php

/**
 * Contains the classe responsible for displaying a ingle SmartObject
 *
 * @license GNU
 * @author marcan <marcan@smartfactory.ca>

 * @version $Id: smartobjectsingleview.php 839 2008-02-10 02:40:13Z malanciault $

 * @link http://smartfactory.ca The SmartFactory
 * @package SmartObject
 */


/**
 * SmartObjectRow class
 *
 * Class representing a single row of a SmartObjectSingleView
 *
 * @package SmartObject
 * @author marcan <marcan@smartfactory.ca>
 * @link http://smartfactory.ca The SmartFactory
 */
class SmartObjectRow {

    var $_keyname;
    var $_align;
    var $_customMethodForValue;
    var $_header;
    var $_class;

    function SmartObjectRow($keyname, $customMethodForValue=false, $header=false, $class=false) {
        $this->_keyname = $keyname;
        $this->_customMethodForValue = $customMethodForValue;
        $this->_header = $header;
        $this->_class = $class;
    }

    function getKeyName() {
        return $this->_keyname;
    }

    function isHeader() {
        return $this->_header;
    }
}

/**
 * SmartObjectSingleView base class
 *
 * Base class handling the display of a single object
 *
 * @package SmartObject
 * @author marcan <marcan@smartfactory.ca>
 * @link http://smartfactory.ca The SmartFactory
 */
class SmartObjectSingleView {

    var $_object;
    var $_userSide;
    var $_tpl;
    var $_rows;
    var $_actions;
    var $_headerAsRow=true;

    /**
     * Constructor
     */
    function SmartObjectSingleView(&$object, $userSide=false, $actions=array(), $headerAsRow=true)
    {
        $this->_object = $object;
        $this->_userSide = $userSide;
        $this->_actions = $actions;
        $this->_headerAsRow = $headerAsRow;
    }

    function addRow($rowObj) {
        $this->_rows[] = $rowObj;
    }

    function render($fetchOnly=false, $debug=false)
    {
        include_once XOOPS_ROOT_PATH . '/class/template.php';

        $this->_tpl = new XoopsTpl();
        $vars = $this->_object->vars;
        $smartobject_object_array = array();

        foreach ($this->_rows as $row) {
            $key = $row->getKeyName();
            if ($row->_customMethodForValue && method_exists($this->_object, $row->_customMethodForValue)) {
                $method = $row->_customMethodForValue;
                $value = $this->_object->$method();
            } else {
                $value = $this->_object->getVar($row->getKeyName());
            }
            if ($row->isHeader()) {
                $this->_tpl->assign('smartobject_single_view_header_caption', $this->_object->vars[$key]['form_caption']);
                $this->_tpl->assign('smartobject_single_view_header_value', $value);
            } else {
                $smartobject_object_array[$key]['value'] = $value;
                $smartobject_object_array[$key]['header'] = $row->isHeader();
                $smartobject_object_array[$key]['caption'] = $this->_object->vars[$key]['form_caption'];
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
            $smartobject_object_array['zaction']['value'] = $action_row;
            $smartobject_object_array['zaction']['caption'] = _CO_SOBJECT_ACTIONS;
        }

        $this->_tpl->assign('smartobject_header_as_row', $this->_headerAsRow);
        $this->_tpl->assign('smartobject_object_array', $smartobject_object_array);

        if ($fetchOnly) {
            return $this->_tpl->fetch( 'db:smartobject_singleview_display.html' );
        } else {
            $this->_tpl->display( 'db:smartobject_singleview_display.html' );
        }
    }

    function fetch($debug=false) {
        return $this->render(true, $debug);
    }
}

?>