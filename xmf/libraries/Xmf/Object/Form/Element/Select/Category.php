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
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

class Xmf_Object_Form_Element_Select_Category extends Xmf_Form_Element_Select
{

    /**
     * Constructor
     * @param	object    $object   reference to targetobject (@link IcmsPersistableObject)
     * @param	string    $key      the form name
     */
    function __construct($object, $var)
    {
        $category_title_field = $object->handler->identifierName;
        $control = $object->getVarControl($var);

        $addNoParent = isset($control['addNoParent']) ? $control['addNoParent'] : true;
        $criteria = new Xmf_Criteria_Compo();
        $criteria->setSort("weight, " . $category_title_field);
        $category_handler = xoops_getmodulehandler('category', $object->handler->_moduleName);
        $categories = $category_handler->getObjects($criteria);

        $mytree = new Xmf_Object_Tree($categories, "category_id", "category_pid");
        parent::__construct($object->getVarKey($var, 'title'), $var, $object->getVar($var, 'e'));

        $ret = array();
        $options = $this->getOptionArray($mytree, $category_title_field, 0, "", $ret);
        if ($addNoParent) {
            $newOptions = array('0' => '----');
            foreach ($options as $k => $v) {
                $newOptions[$k] = $v;
            }
            $options = $newOptions;
        }
        $this->addOptionArray($options);
    }

    /**
     * Get options for a category select with hierarchy (recursive)
     *
     * @param object  $tree         XoopsObjectTree $tree (@link XoopsObjectTree)
     * @param string  $fieldName    The fieldname to get the option array for
     * @param int     $key          the key to get the optionarray for
     * @param string  $prefix_curr  the prefix
     * @param array   $ret          passed return array
     *
     * @return array  $ret          the constructed option array
     */
    function getOptionArray($tree, $fieldName, $key, $prefix_curr = "", &$ret)
    {
        if ($key > 0) {
            $value = $tree->_tree[$key]['obj']->getVar($tree->_myId);
            $ret[$key] = $prefix_curr.$tree->_tree[$key]['obj']->getVar($fieldName);
            $prefix_curr .= "-";
        }

        if (isset($tree->_tree[$key]['child']) && !empty($tree->_tree[$key]['child'])) {
            foreach ($tree->_tree[$key]['child'] as $childkey) {
                $this->getOptionArray($tree, $fieldName, $childkey, $prefix_curr, $ret);
            }
        }
        return $ret;
    }
}