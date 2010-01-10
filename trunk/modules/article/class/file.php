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
 * @version         $Id: file.php 2283 2008-10-12 03:36:13Z phppp $
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}
include_once dirname(dirname(__FILE__)) . "/include/vars.php";
mod_loadFunctions("parse", $GLOBALS["artdirname"]);

if (!class_exists("Xfile")) {
class Xfile extends XoopsObject
{
    //var $db;
    //var $table;

    function Xfile($id = null)
    {
	    //$this->ArtObject();
        //$this->db =& Database::getInstance();
        $this->table = art_DB_prefix("file");
        $this->initVar("file_id", XOBJ_DTYPE_INT, null);
        $this->initVar("art_id", XOBJ_DTYPE_INT, 0, true);
        //$this->initVar("file_uid", XOBJ_DTYPE_INT, 0);
        $this->initVar("file_name", XOBJ_DTYPE_TXTBOX, "", true);
    }
}
}

// TODO: handle mysql version 4.1

art_parse_class('
class [CLASS_PREFIX]FileHandler extends XoopsPersistableObjectHandler
{
    function [CLASS_PREFIX]FileHandler(&$db)
    {
        $this->XoopsPersistableObjectHandler($db, art_DB_prefix("file", true), "Xfile", "file_id", "file_name");
    }
    
    function getCountOrphan()
    {
        $sql = "SELECT COUNT(*) as count FROM " . art_DB_prefix("file") . " WHERE art_id NOT IN ( SELECT DISTINCT art_id FROM " . art_DB_prefix("article") . ")";
        $result = $this->db->query($sql);
        $myrow = $this->db->fetchArray($result);
        return intval($myrow["count"]);
    }

    function &getOrpan($criteria = null, $tags = false)
    {
	    if (is_array($tags) && count($tags) > 0) {
		    if(!in_array("file_id", $tags)) $tags[] = "file_id";
		    $select = implode(",", $tags);
	    }
	    else $select = "*";
	    $limit = $start = null;
        $sql = "SELECT $select FROM " . art_DB_prefix("file") . " WHERE art_id NOT IN ( SELECT DISTINCT art_id FROM " . art_DB_prefix("article") . ")";
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " " . $criteria->renderWhere();
            if ($criteria->getSort() != "") {
                $sql .= " ORDER BY " . $criteria->getSort() . " " . $criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $this->db->query($sql, $limit, $start);
        $ret = array();
        while ($myrow = $this->db->fetchArray($result)) {
            $file =& $this->create(false);
            $file->assignVars($myrow);

            $ret[$myrow["file_id"]] = $file;
            unset($file);
        }
        return $ret;
    }

   	function &getOrphanByLimit($limit = 1, $start = 0, $criteria = null, $tags = false)
   	{
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
        } elseif (!empty($limit)) {
			$criteria = new CriteriaCompo();
	        $criteria->setLimit($limit);
	        $criteria->setStart($start);
        }
        $ret =& $this->getAll($criteria, $tags);
        return $ret;
   	}

    function &getByArticle($art_id)
    {
        $sql = "SELECT * FROM " . art_DB_prefix("file") . " WHERE art_id = " . intval($art_id);
        $result = $this->db->query($sql);
        $ret = array();
        while ($myrow = $this->db->fetchArray($result)) {
            $file =& $this->create(false);
            $file->assignVars($myrow);
            $ret[$myrow["file_id"]] = $file;
            unset($file);
        }
        return $ret;
    }

    function delete(&$file)
    {
	    global $xoopsModuleConfig;

        $sql = "DELETE FROM " . $file->table . " WHERE file_id =" . $file->getVar("file_id");
        if (!$result = $this->db->queryF($sql)) {
            return false;
        }
        @unlink($xoopsModuleConfig["path_file"] . "/" . $file->getVar("file_name"));
        unset($file);
        return true;
    }

    function deleteByArticle($art_id)
    {
	    $files = $this->getByArticle($art_id);
	    if (count($files) > 0) {
		    foreach ($files as $file_id => $file) {
			    $this->delete($file);
		    }
	    }
	    return true;
    }
}
');
?>