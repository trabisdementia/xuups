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
 * @version         $Id: pingback.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
    exit();
}
include_once dirname(dirname(__FILE__)) . "/include/vars.php";
mod_loadFunctions("parse", $GLOBALS["artdirname"]);

if (!class_exists("Pingback")) {
class Pingback extends XoopsObject
{
    //var $db;
    //var $table;

    function Pingback($id = null)
    {
        //$this->ArtObject();
        //$this->db =& Database::getInstance();
        //$this->table = art_DB_prefix("pingback");
        $this->initVar("pb_id", XOBJ_DTYPE_INT, null);
        $this->initVar("art_id", XOBJ_DTYPE_INT, 0, true);
        $this->initVar("pb_time", XOBJ_DTYPE_INT);
        $this->initVar("pb_host", XOBJ_DTYPE_TXTBOX);
        $this->initVar("pb_url", XOBJ_DTYPE_TXTBOX);
    }
}
}

art_parse_class('
class [CLASS_PREFIX]PingbackHandler extends XoopsPersistableObjectHandler
{
    function [CLASS_PREFIX]PingbackHandler(&$db)
    {
        $this->XoopsPersistableObjectHandler($db, art_DB_prefix("pingback", true), "Pingback", "pb_id", "pb_url");
    }

    function &getByArticle($art_id)
    {
        $sql = "SELECT * FROM " . art_DB_prefix("pingback") . " WHERE art_id = ". intval($art_id);
        $result = $this->db->query($sql);
        $ret = array();
        while ($myrow = $this->db->fetchArray($result)) {
            $pingback =& $this->create(false);
            $pingback->assignVars($myrow);
            $ret[$myrow["pb_id"]] = $pingback;
            unset($pingback);
        }
        return $ret;
    }

    function deleteByArticle($art_id)
    {
        $pingbacks = $this->getByArticle($art_id);
        if (count($pingbacks)>0) {
            foreach($pingbacks as $pb_id => $pingback) {
                $this->delete($pingback);
            }
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