<?php
// $Id: xoopsblock.php 1099 2007-10-19 01:08:14Z dugris $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.myweb.ne.jp/, http://www.xoops.org/, http://jp.xoops.org/ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}
require_once XOOPS_ROOT_PATH."/kernel/object.php";

class MytabsXoopsBlock extends XoopsObject
{
    var $db;

    function MytabsXoopsBlock($id = null)
    {
        $this->db =& Database::getInstance();
        $this->initVar('bid', XOBJ_DTYPE_INT, null, false);
        $this->initVar('mid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('func_num', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('options', XOBJ_DTYPE_ARRAY, null, false);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, null, true, 150);
        $this->initVar('title', XOBJ_DTYPE_TXTBOX, null, false, 150);
        $this->initVar('content', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('side', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('weight', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('visible', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('block_type', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('c_type', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('isactive', XOBJ_DTYPE_INT, null, false);

        $this->initVar('dirname', XOBJ_DTYPE_TXTBOX, null, false, 50);
        $this->initVar('func_file', XOBJ_DTYPE_TXTBOX, null, false, 50);
        $this->initVar('show_func', XOBJ_DTYPE_TXTBOX, null, false, 50);
        $this->initVar('edit_func', XOBJ_DTYPE_TXTBOX, null, false, 50);

        $this->initVar('template', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('bcachetime', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('last_modified', XOBJ_DTYPE_INT, 0, false);

        if ( !empty($id) ) {
            if ( is_array($id) ) {
                $this->assignVars($id);
            } else {
                $this->load(intval($id));
            }
        }
    }

    function load($id)
    {
        $id = intval($id);
        $sql = "SELECT " .
    			"		i.instanceid, c.mid, i.options, c.name, i.title, i.side, i.weight, i.visible, ".
                "		c.isactive, c.dirname, c.func_file,".
    			"		c.show_func, c.edit_func, c.template, i.bcachetime, c.last_modified".
        		"	FROM " . $this->db->prefix("block_instance") . " AS i," .
        		"		" . $this->db->prefix("newblocks") . " AS c" .
        		"	WHERE i.bid = c.bid" .
        		"   AND c.bid = ".$id;
        $arr = $this->db->fetchArray($this->db->query($sql));
        $this->assignVars($arr);
    }

    function buildBlock()
    {
        global $xoopsConfig, $xoopsOption;
        $block = array();

        // get block display function
        $show_func = $this->getVar('show_func');
        if ( !$show_func ) {
            return false;
        }
        // must get lang files b4 execution of the function
        if ( file_exists(XOOPS_ROOT_PATH."/modules/".$this->getVar('dirname')."/blocks/".$this->getVar('func_file')) ) {
            if ( file_exists(XOOPS_ROOT_PATH."/modules/".$this->getVar('dirname')."/language/".$xoopsConfig['language']."/blocks.php") ) {
                include_once XOOPS_ROOT_PATH."/modules/".$this->getVar('dirname')."/language/".$xoopsConfig['language']."/blocks.php";
            } elseif ( file_exists(XOOPS_ROOT_PATH."/modules/".$this->getVar('dirname')."/language/english/blocks.php") ) {
                include_once XOOPS_ROOT_PATH."/modules/".$this->getVar('dirname')."/language/english/blocks.php";
            }
            include_once XOOPS_ROOT_PATH."/modules/".$this->getVar('dirname')."/blocks/".$this->getVar('func_file');
            $options = $this->getVar("options");
//            var_dump($this->getVar('title'), $this);
            if ( function_exists($show_func) ) {
                // execute the function
                $block = $show_func($options);
                if ( !$block ) {
                    return $block;
                }
            } else {
                return $block;
            }
        } else {
            return $block;
        }

        return $block;
    }

    /**
    * gets html form for editting block options
    *
    */
    function getOptions()
    {
        global $xoopsConfig;
        if ( $this->getVar("block_type") != "C" ) {
            $edit_func = $this->getVar('edit_func');
            if ( !$edit_func ) {
                return false;
            }
            if ( file_exists(XOOPS_ROOT_PATH."/modules/".$this->getVar('dirname')."/blocks/".$this->getVar('func_file')) ) {
                if ( file_exists(XOOPS_ROOT_PATH."/modules/".$this->getVar('dirname')."/language/".$xoopsConfig['language']."/blocks.php") ) {
                    include_once XOOPS_ROOT_PATH."/modules/".$this->getVar('dirname')."/language/".$xoopsConfig['language']."/blocks.php";
                } elseif ( file_exists(XOOPS_ROOT_PATH."/modules/".$this->getVar('dirname')."/language/english/blocks.php") ) {
                    include_once XOOPS_ROOT_PATH."/modules/".$this->getVar('dirname')."/language/english/blocks.php";
                }
                include_once XOOPS_ROOT_PATH.'/modules/'.$this->getVar('dirname').'/blocks/'.$this->getVar('func_file');
                $options = $this->getVar("options");
                $edit_form = $edit_func($options);
                if ( !$edit_form ) {
                    return false;
                }
                return $edit_form;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
?>
