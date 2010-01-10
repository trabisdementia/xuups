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
 * @version         $Id: plugin.transfer.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
    exit();
}

if (!@include_once XOOPS_ROOT_PATH . "/Frameworks/transfer/transfer.php" ) return null;

// Specify the addons to skip for the module
$GLOBALS["addons_skip_module"] = array();
// Maximum items to show on page
$GLOBALS["addons_limit_module"] = 5;

class ModuleTransferHandler extends TransferHandler
{
    function ModuleTransferHandler()
    {
        $this->TransferHandler();
    }
    
    /**
     * Get valid addon list
     * 
     * @param    array    $skip    Addons to skip
     * @param    boolean    $sort    To sort the list upon 'level'
     * return    array    $list
     */
    function &getList($skip = array(), $sort = true)
    {
        $list = parent::getList($skip, $sort);
        return $list;
    }
    
    /** 
     * If need change config of an item
     * 1 parent::load_item
     * 2 $this->config
     * 3 $this->do_transfer
     */
    function do_transfer($item, &$data)
    {
        $ret = parent::do_transfer($item, $data);
    
        if ($item == "newbb" && !empty($ret["data"]["topic_id"]) ) {
            $article_handler =& xoops_getmodulehandler("article", $GLOBALS["xoopsModule"]->getVar("dirname"));
            $article_obj =& $article_handler->get($data["id"]);
            $article_obj->setVar("art_forum", $ret["data"]["topic_id"]);
            $article_handler->insert($article_obj, true);
        }
        
        return $ret;
    }
}
?>