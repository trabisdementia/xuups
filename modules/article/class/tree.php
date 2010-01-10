<?php
/**
 * Article module for XOOPS
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code 
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         article
 * @since           1.0
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: tree.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
    exit();
}
require_once XOOPS_ROOT_PATH . "/class/tree.php";

if (!class_exists("artTree")) {
class artTree extends XoopsObjectTree {

    function artTree(&$objectArr, $rootId = null)
    {
        $this->XoopsObjectTree($objectArr, "cat_id", "cat_pid", $rootId);
    }

    /**
     * Make options for a select box from
     *
     * @param   string  $fieldName   Name of the member variable from the
     *  node objects that should be used as the title for the options.
     * @param   string  $selected    Value to display as selected
     * @param   int $key         ID of the object to display as the root of select options
     * @param   string  $ret         (reference to a string when called from outside) Result from previous recursions
     * @param   string  $prefix_orig  String to indent items at deeper levels
     * @param   string  $prefix_curr  String to indent the current item
     * @return
     *
     * @access    private
     **/
    function _makeTreeItems($key, &$ret, $prefix_orig, $prefix_curr = '', $tags = null)
    {
        if ($key > 0) {
            if (count($tags)>0) foreach($tags as $tag) {
                $ret[$key][$tag] = $this->_tree[$key]['obj']->getVar($tag);
            } else {
                $ret[$key]["cat_title"] = $this->_tree[$key]['obj']->getVar("cat_title");
            }
            $ret[$key]["prefix"] = $prefix_curr;
            $prefix_curr .= $prefix_orig;
        }
        if (isset($this->_tree[$key]['child']) && !empty($this->_tree[$key]['child'])) {
            foreach ($this->_tree[$key]['child'] as $childkey) {
                $this->_makeTreeItems($childkey, $ret, $prefix_orig, $prefix_curr, $tags);
            }
        }
    }

    /**
     * Make a select box with options from the tree
     *
     * @param   string  $name            Name of the select box
     * @param   string  $fieldName       Name of the member variable from the
     *  node objects that should be used as the title for the options.
     * @param   string  $prefix          String to indent deeper levels
     * @param   string  $selected        Value to display as selected
     * @param   bool    $addEmptyOption  Set TRUE to add an empty option with value "0" at the top of the hierarchy
     * @param   integer $key             ID of the object to display as the root of select options
     * @return  string  HTML select box
     **/
    function &makeTree($prefix = '-', $key = 0, $tags = null)
    {
        //art_message($prefix);
        $ret = array();
        $this->_makeTreeItems($key, $ret, $prefix, '', $tags);
        return $ret;
    }

    /**
     * Make a select box with options from the tree
     *
     * @param   string  $name            Name of the select box
     * @param   string  $fieldName       Name of the member variable from the
     *  node objects that should be used as the title for the options.
     * @param   string  $prefix          String to indent deeper levels
     * @param   string  $selected        Value to display as selected
     * @param   bool    $addEmptyOption  Set TRUE to add an empty option with value "0" at the top of the hierarchy
     * @param   integer $key             ID of the object to display as the root of select options
     * @return  string  HTML select box
     **/
    function &makeSelBox($name, $prefix = '-', $selected = '', $EmptyOption = false, $key = 0)
    {
        $ret = '<select name=' . $name . '>';
        if (!empty($addEmptyOption)) {
            $ret .= '<option value="0">' . (is_string($EmptyOption) ? $EmptyOption : '') . '</option>';
        }
        $this->_makeSelBoxOptions("cat_title", $selected, $key, $ret, $prefix);
        $ret .= '</select>';
        return $ret;
    }
    
    
    /**
     * Make a tree for the array of a given category
     * 
     * @param   string  $key    top key of the tree
     * @param   array    $ret    the tree
     * @param   array    $tags   fields to be used
     * @param   integer    $depth    level of subcategories
     * @return  array      
     **/
    function getAllChild_array($key, &$ret, $tags = array(), $depth = 0)
    {
        if (-- $depth == 0) {
            return;
        }
        
        if (isset($this->_tree[$key]['child'])) {
            foreach ($this->_tree[$key]['child'] as $childkey) {
                if (isset($this->_tree[$childkey]['obj'])):
                if (count($tags) > 0) {
                    foreach ($tags as $tag) {
                        $ret['child'][$childkey][$tag] = $this->_tree[$childkey]['obj']->getVar($tag);
                    }
                } else {
                    $ret['child'][$childkey]["cat_title"] = $this->_tree[$childkey]['obj']->getVar("cat_title");
                }
                endif;
                
                $this->getAllChild_array($childkey, $ret['child'][$childkey], $tags, $depth);
            }
        }
    }

    /**
     * Make a tree for the array
     * 
     * @param   string  $key    top key of the tree
     * @param   array    $tags   fields to be used
     * @param   integer    $depth    level of subcategories
     * @return  array      
     **/
    function &makeArrayTree($key = 0, $tags = null, $depth = 0)
    {
        $ret = array();
        if ($depth > 0) $depth++;
        $this->getAllChild_array($key, $ret, $tags, $depth);
        return $ret;
    }
}
}
?>