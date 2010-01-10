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
 * @version         $Id: rate.php 2283 2008-10-12 03:36:13Z phppp $
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
    exit();
}
include_once dirname(dirname(__FILE__)) . "/include/vars.php";
mod_loadFunctions("parse", $GLOBALS["artdirname"]);

if (!class_exists("Rate")) {
class Rate extends XoopsObject
{
    //var $db;
    //var $table;

    function Rate($id = null)
    {
        //$this->ArtObject();
        //$this->table = art_DB_prefix("rate");
        $this->initVar("rate_id", XOBJ_DTYPE_INT, null, false);
        $this->initVar("art_id", XOBJ_DTYPE_INT, 0, true);
        $this->initVar("uid", XOBJ_DTYPE_INT, 0);
        $this->initVar("rate_ip", XOBJ_DTYPE_INT);
        $this->initVar("rate_rating", XOBJ_DTYPE_INT);
        $this->initVar("rate_time", XOBJ_DTYPE_INT);
    }
}
}

art_parse_class('
class [CLASS_PREFIX]RateHandler extends XoopsPersistableObjectHandler
{
    function [CLASS_PREFIX]RateHandler(&$db)
    {
        $this->XoopsPersistableObjectHandler($db, art_DB_prefix("rate", true), "Rate", "rate_id");
    }
    
    function &getByArticle($art_id, $criteria = null)
    {
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $criteria->add(new Criteria("art_id", intval($art_id)), "AND");
        } else {
            $criteria = new CriteriaCompo(new Criteria("art_id", intval($art_id)));
        }
        $ret =& $this->getAll($criteria);
        return $ret;
    }

    function deleteByArticle($art_id)
    {
        if (is_array($art_id)) {
            if (count($art_id) > 0) {
                $art_id = array_map("intval", $art_id);
                $where = " WHERE art_id IN (" . implode(",", $art_id) . ")";
            } else {
                return false;
            }
        } elseif (!empty($art_id)) {
            $where = " WHERE art_id= " . intval($art_id);
        } else {
            return false;
        }
        $sql = "DELETE FROM " . art_DB_prefix("rate") . $where;
        if (!$result = $this->db->queryF($sql)) {
            return false;
        }
        return true;
    }

    /**
     * clean orphan items from database
     * 
     * @return     bool    true on success
     */
    function cleanOrphan()
    {
        return parent::cleanOrphan(art_DB_prefix("article"), "art_id");
    }
}
');
?>