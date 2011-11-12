<?php
// $Id: block.php,v 1.11 2006/09/19 15:20:41 mith Exp $
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
// Authors: Jan Keller Pedersen (AKA Mithrandir) & Jannik Nielsen (Bitkid)   //
// URL: http://www.idg.dk/ http://www.xoops.org/ http://www.web-udvikling.dk //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //
if (!defined("XOOPS_ROOT_PATH")) {
    die;
}
if (!class_exists('SmartPersistableObjectHandler')) {
    include_once(XOOPS_ROOT_PATH . "/modules/smartobject/class/smartobjecthandler.php");
}
class SmartmailBlock extends SmartObject {
    var $_block;

    function SmartmailBlock() {
        $this->initVar('nb_id',XOBJ_DTYPE_INT);
        $this->initVar('b_id',XOBJ_DTYPE_INT);
        $this->initVar('newsletterid',XOBJ_DTYPE_INT);
        $this->initVar('dispatchid',XOBJ_DTYPE_INT, 0);
        $this->initVar('nb_title',XOBJ_DTYPE_TXTBOX);
        $this->initVar('nb_position',XOBJ_DTYPE_INT);
        $this->initVar('nb_weight',XOBJ_DTYPE_INT, 0);
        $this->initVar('nb_options',XOBJ_DTYPE_ARRAY);
        //$this->initVar('nb_override',XOBJ_DTYPE_INT);
    }

    function getVar($key, $format = 's') {
        if ($key == "options") {
            $key = "nb_options";
        }
        return parent::getVar($key, $format);
    }

    /**
     * Returns a serialized string of the array with info about the NB instance
     *
     * @return string
     */
    function getValueString() {
        $ret['id']       = intval($this->getVar('nb_id'));
        $ret['block_id'] = intval($this->getVar('b_id'));
        $ret['title']    = $this->getVar('nb_title', 'e');
        $ret['position'] = intval($this->getVar('nb_position'));
        $ret['options']  = $this->getVar('nb_options', 'e');

        return serialize($ret);
    }

    /**
     * Get a {@link XoopsForm} object for creating/editing objects
     * @param mixed $action receiving page - defaults to $_SERVER['REQUEST_URI']
     * @param mixed $title title of the form
     *
     * @return object
     */
    function getForm($action = false, $title = false) {
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        if ($action == false) {
            $action = $_SERVER['REQUEST_URI'];
        }
        if ($title == false) {
            $title = $this->isNew() ? _NL_AM_ADDBLOCK : _NL_AM_EDITBLOCK;
        }
        $form = new XoopsThemeForm($title, "form", $action);

        $form->addElement(new XoopsFormLabel('Block', $this->_block->getVar('name')));

        $form->addElement(new XoopsFormText(_NL_AM_TITLE, 'block_title', 42, 42, $this->getVar('nb_title', 'e')));

        $position_select = new XoopsFormSelect('Position', 'block_pos', $this->getVar('nb_position', 'e'));
        $position_select->addOption(1, _NL_AM_BLOCK_POSITION1);
        $position_select->addOption(2, _NL_AM_BLOCK_POSITION2);
        $position_select->addOption(3, _NL_AM_BLOCK_POSITION3);
        $position_select->addOption(4, _NL_AM_BLOCK_POSITION4);
        $position_select->addOption(5, _NL_AM_BLOCK_POSITION5);
        $position_select->addOption(6, _NL_AM_BLOCK_POSITION6);
        $form->addElement($position_select);

        $form->addElement(new XoopsFormText(_NL_AM_WEIGHT, 'block_weight', 5, 5, $this->getVar('nb_weight', 'e')));

        $form->addElement(new XoopsFormLabel(_NL_AM_OPTIONS, $this->getOptions()));

        $button_tray = new XoopsFormElementTray('');
        $button_tray->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        $form->addElement($button_tray);

        if (!$this->isNew()) {
            $form->addElement(new XoopsFormHidden('nb_id', $this->getVar('nb_id')));
        }
        $form->addElement(new XoopsFormHidden('block_id', $this->_block->getVar('bid')));
        $form->addElement(new XoopsFormHidden('dispatchid', $this->getVar('dispatchid')));
        $form->addElement(new XoopsFormHidden('id', $this->getVar('newsletterid')));
        $form->addElement(new XoopsFormHidden('op', 'block_save'));
        return $form;
    }

    function setBlock(&$block) {
        $this->_block =& $block;
    }

    /**
     * Get HTML content of a block
     *
     * @param NewsletterDispatch $dispatch
     *
     * @return array|false
     */
    function buildBlock(&$dispatch) {
        global $xoopsConfig, $xoopsOption;
        $block = array();
        // get block display function
        $show_func = $this->_block->getVar('show_func');
        if ( !$show_func ) {
            return false;
        }
        // must get lang files b4 execution of the function
        if ( file_exists(XOOPS_ROOT_PATH."/modules/".$this->_block->getVar('dirname')."/blocks/".$this->_block->getVar('func_file')) ) {
            if ( file_exists(XOOPS_ROOT_PATH."/modules/".$this->_block->getVar('dirname')."/language/".$xoopsConfig['language']."/blocks.php") ) {
                include_once XOOPS_ROOT_PATH."/modules/".$this->_block->getVar('dirname')."/language/".$xoopsConfig['language']."/blocks.php";
            } elseif ( file_exists(XOOPS_ROOT_PATH."/modules/".$this->_block->getVar('dirname')."/language/english/blocks.php") ) {
                include_once XOOPS_ROOT_PATH."/modules/".$this->_block->getVar('dirname')."/language/english/blocks.php";
            }
            include_once XOOPS_ROOT_PATH."/modules/".$this->_block->getVar('dirname')."/blocks/".$this->_block->getVar('func_file');
            $options = $this->getVar("nb_options");
            if ( function_exists($show_func) ) {
                // execute the function
                $block = $show_func($options, $dispatch);
                if ( !$block ) {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
        return $block;
    }

    /**
     * (HTML-) form for setting the options of the block
     *
     * @return string HTML for the form, FALSE if not defined for this block
     **/
    function getOptions()
    {
        $edit_func = $this->_block->getVar('edit_func');
        if (!$edit_func) {
            return false;
        }
        if (file_exists(XOOPS_ROOT_PATH.'/modules/'.$this->_block->getVar('dirname').'/blocks/'.$this->_block->getVar('func_file'))) {
            if (file_exists(XOOPS_ROOT_PATH.'/modules/'.$this->_block->getVar('dirname').'/language/'.$GLOBALS['xoopsConfig']['language'].'/blocks.php')) {
                include_once XOOPS_ROOT_PATH.'/modules/'.$this->_block->getVar('dirname').'/language/'.$GLOBALS['xoopsConfig']['language'].'/blocks.php';
            } elseif (file_exists(XOOPS_ROOT_PATH.'/modules/'.$this->_block->getVar('dirname').'/language/english/blocks.php')) {
                include_once XOOPS_ROOT_PATH.'/modules/'.$this->_block->getVar('dirname').'/language/english/blocks.php';
            }
            include_once XOOPS_ROOT_PATH.'/modules/'.$this->_block->getVar('dirname').'/blocks/'.$this->_block->getVar('func_file');
            $options = $this->getVar('nb_options');
            $edit_form = $edit_func($options);
            if (!$edit_form) {
                return false;
            }
            return $edit_form;
        } else {
            return false;
        }
    }
}

class SmartmailBlockHandler extends SmartPersistableObjectHandler {
    function SmartmailBlockHandler($db) {
        parent::SmartPersistableObjectHandler($db, "block", "nb_id", "", "", "smartmail");
    }

    /**
     * Manages the blocks attached to a newsletter
     *
     * Creates blocks that aren't already attached, updates blocks that
     * are attached, and deletes blocks nolonger attached
     * @param int $newsletterid The ID of the newsletter to manage
     * @param array $blocks_array The blocks which should be attached to the newsletter
     * @return bool
     */
    function manage_blocks($newsletterid, $blocks_array){
        $criteria = new Criteria('newsletterid', $newsletterid);
        $existing_nb_obj = $this->getObjects($criteria, true);
        $existing_nbs = array_keys($existing_nb_obj);

        $current_blocks = array();
        $weight = 0;
        foreach(array_keys($blocks_array) AS $i){
            $block = $blocks_array[$i];
            if($block['id'] != 0){
                $obj = $this->get($block['id']);
            } else {
                $obj = $this->create();
            }

            $obj->setVar('newsletterid', $newsletterid);
            $obj->setVar('b_id', $block['block_id']);
            $obj->setVar('nb_title', $block['title']);
            $obj->setVar('nb_position', $block['position']);
            $obj->setVar('nb_weight', $weight);
            $obj->setVar('nb_options', $block['options']);

            $this->insert($obj);

            $current_blocks[] = intval($obj->getVar('nb_id'));

            unset($obj);
            unset($block);
            $weight++;
        }

        $deleted_blocks = array_diff($existing_nbs, $current_blocks);
        if(count($deleted_blocks) > 0){
            $criteria = new Criteria('nb_id', '(' . implode($deleted_blocks, ',') . ')', 'IN');
            return $this->deleteAll($criteria);
        }

        return true;
    }

    /**
     * Get blocks for one or more newsletters
     *
     * @param int $newsletterid
     * @param int $dispatchid
     * @param bool $edit whether to include edit links on blocks
     * @return array
     */
    function getByNewsletter($newsletterid, $dispatchid=0, $edit = false) {
        global $xoopsTpl;
        $ret = array();
        $criteria = new CriteriaCompo(new Criteria('newsletterid', $newsletterid));
        $criteria->add(new Criteria('dispatchid', "(0,".intval($dispatchid).")", "IN"));
        $criteria->setSort('nb_weight');
        $newsletterblocks = $this->getObjects($criteria);
        if (count($newsletterblocks) > 0) {
            foreach (array_keys($newsletterblocks) as $i) {
                $blockids[] = $newsletterblocks[$i]->getVar('b_id');
            }
            /**
             * @todo make this work with the ancient structure of XOOPS 2.0.13.2 (is this different in 2.0.14?)
             */
            if (!file_exists(XOOPS_ROOT_PATH."/kernel/blockinstance.php")) {
                //Using 2.0.13.2 or lower
                include_once(XOOPS_ROOT_PATH."/class/xoopsblock.php");
                $all_blocks = XoopsBlock::getAllBlocks();
                foreach (array_keys($all_blocks) as $i) {
                    $blocks[$all_blocks[$i]->getVar('bid')] = $all_blocks[$i];
                }
            }
            else {
                $block_handler = xoops_gethandler('block');
                $blocks = $block_handler->getObjects(new Criteria('bid', "(".implode(',', $blockids).")", "IN"), true);
            }
            // Get dispatch
            $smartmail_dispatch_handler = xoops_getmodulehandler('dispatch', 'smartmail');
            $dispatch = $dispatchid > 0 ? $smartmail_dispatch_handler->get($dispatchid) : $smartmail_dispatch_handler->create();
            foreach (array_keys($newsletterblocks) as $i) {
                if (isset($blocks[$newsletterblocks[$i]->getVar('b_id')])) {
                    $newsletterblocks[$i]->setBlock($blocks[$newsletterblocks[$i]->getVar('b_id')]);

                    $xoopsTpl->xoops_setCaching(0);
                    $btpl = $newsletterblocks[$i]->_block->getVar('template') != '' ? $newsletterblocks[$i]->_block->getVar('template') : "system_block_dummy.html";

                    $bresult =& $newsletterblocks[$i]->buildBlock($dispatch);
                    if (!$bresult) {
                        continue;
                    }
                    $xoopsTpl->assign_by_ref('block', $bresult);
                    $xoopsTpl->assign('newsletterblock_edit', $edit);
                    $bcontent =& $xoopsTpl->fetch('db:'.$btpl);
                    $xoopsTpl->clear_assign('block');

                    $block_info = array('title' => $newsletterblocks[$i]->getVar('nb_title'),
					'content' => $bcontent,
					'id' => $newsletterblocks[$i]->getVar('nb_id'),
					'typeid' => $newsletterblocks[$i]->_block->getVar('bid'),
					'weight' => $newsletterblocks[$i]->getVar('nb_weight'));

                    $ret[$newsletterblocks[$i]->getVar('newsletterid')][$newsletterblocks[$i]->getVar('nb_position')][] = $block_info;
                    unset($bcontent);
                }
            }
        }
        return $ret;
    }

    function getAddBlockForm($newsletterid, $dispatchid = 0) {
        include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
        $form = new XoopsThemeForm(_NL_AM_ADDBLOCK, "blockform", "blocks.php");

        $criteria = new CriteriaCompo(null);
        $criteria->setSort('name');
        if (!file_exists(XOOPS_ROOT_PATH."/kernel/blockinstance.php")) {
            //Using 2.0.13.2 or lower
            include_once(XOOPS_ROOT_PATH."/class/xoopsblock.php");
            $all_blocks = XoopsBlock::getAllBlocks();
            foreach (array_keys($all_blocks) as $i) {
                $blocks[$all_blocks[$i]->getVar('bid')] = $all_blocks[$i];
            }
        }
        else {
            $block_handler =& xoops_gethandler('block');
            $blocks =& $block_handler->getObjects($criteria, true);
        }

        $module_handler =& xoops_gethandler('module');
        $modules =& $module_handler->getObjects(null, true);

        $block_select = new XoopsFormSelect(_NL_AM_BLOCKTYPE, 'block_id');
        foreach ($blocks as $block) {
            // Rogue module blocks are known to appear from time to time
            // So we check if the module exists.
            if (isset($modules[$block->getVar('mid')])) {
                $block_arr[$block->getVar('mid')]['modname'] = $modules[$block->getVar('mid')]->getVar('name');
                $block_arr[$block->getVar('mid')]['blocks'][$block->getVar('bid')] = " - ".$block->getVar('name');
                $modnames[$block->getVar('mid')] = $modules[$block->getVar('mid')]->getVar('name');
                $bids[]=$block->getVar('bid');
            }
        }
        array_multisort($modnames, SORT_ASC, $block_arr);
        foreach (array_keys($block_arr) as $i) {
            $block_select->addOption("-".$i, $block_arr[$i]['modname'], true);
            $block_select->addOptionArray($block_arr[$i]['blocks']);
        }

        $form->addElement($block_select);

        $button_tray = new XoopsFormElementTray('');
        $button_tray->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));
        $form->addElement($button_tray);
        $form->addElement(new XoopsFormHidden("op", "block"));
        $form->addElement(new XoopsFormHidden("id", $newsletterid));
        if ($dispatchid > 0) {
            $form->addElement(new XoopsFormHidden("dispatchid", $dispatchid));
        }
        return $form;
    }
}
?>