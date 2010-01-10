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
 * @version         $Id: text.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
    exit();
}
include_once dirname(dirname(__FILE__)) . "/include/vars.php";
mod_loadFunctions("parse", $GLOBALS["artdirname"]);

if (!class_exists("Text")) {
class Text extends XoopsObject
{
    function Text($id = null)
    {
        //$this->ArtObject();
        //$this->table = art_DB_prefix("text");
        $this->initVar("text_id",         XOBJ_DTYPE_INT, null, false);
        $this->initVar("art_id",         XOBJ_DTYPE_INT, 0, true);
        $this->initVar("text_title",     XOBJ_DTYPE_TXTBOX, "");
        $this->initVar("text_body",     XOBJ_DTYPE_TXTAREA, "", true);

        $this->initVar("dohtml",         XOBJ_DTYPE_INT, 1);
        $this->initVar("dosmiley",         XOBJ_DTYPE_INT, 1);
        $this->initVar("doxcode",         XOBJ_DTYPE_INT, 1);
        $this->initVar("doimage",         XOBJ_DTYPE_INT, 1);
        $this->initVar("dobr",             XOBJ_DTYPE_INT, 0);        // Concerning html tags, the dobr is set to 0 by default
    }
}
}

art_parse_class('
class [CLASS_PREFIX]TextHandler extends XoopsPersistableObjectHandler
{
    function [CLASS_PREFIX]TextHandler(&$db)
    {
        $this->XoopsPersistableObjectHandler($db, art_DB_prefix("text", true), "Text", "text_id", "text_title");
    } 

    function &getByArticle($art_id, $page = 0, $tags = null)
    {
        $text = false;
        $page = intval($page);
        if (is_array($tags) && count($tags) > 0) {
            if (!in_array("text_id",$tags)) $tags[] = "text_id";
            $select = implode(",", $tags);
        } else $select = "*";

        if ($page) {
            $sql = "SELECT $select FROM " . art_DB_prefix("text") . " WHERE art_id = " . intval($art_id) . " ORDER BY text_id";
            $result = $this->db->query($sql, 1, $page-1);
            if ($result && $myrow = $this->db->fetchArray($result)) {
                $text =& $this->create(false);
                $text->assignVars($myrow);
                return $text;
            } else {
                //xoops_error($this->db->error());
                return $text;
            }
        } else {
            $sql = "SELECT $select FROM " . art_DB_prefix("text") . " WHERE art_id = " . intval($art_id) . " ORDER BY text_id";
            $result = $this->db->query($sql);
            $ret = array();
            while ($myrow = $this->db->fetchArray($result)) {
                $text =& $this->create(false);
                $text->assignVars($myrow);
                $ret[$myrow["text_id"]] = $text;
                unset($text);
            }
            return $ret;
        }
    }

    /*
    function getIdByArticle($art_id, $page = 0)
    {
        $page = intval($page);
        if ($page) {
            $sql = "SELECT text_id FROM " . art_DB_prefix("text") . " WHERE art_id = ". intval($art_id) ." ORDER BY text_id LIMIT ".(intval($page)-1).", 1";
            $result = $this->db->query($sql);
            while ($myrow = $this->db->fetchArray($result)) {
                $ret = $myrow["text_id"];
                return $ret;
            }
            $ret = null;
            return $ret;
        } else {
            $sql = "SELECT text_id FROM " . art_DB_prefix("text") . " WHERE art_id = ". intval($art_id) ." ORDER BY text_id";
            $result = $this->db->query($sql);
            $ret = array();
            while ($myrow = $this->db->fetchArray($result)) {
                $ret[] = $myrow["text_id"];
                unset($text);
            }
            return $ret;
        }
    }

    function getForPDF(&$text)
    {
        return $text->getBody(true);
    }

    function getForPrint(&$text)
    {
        return $text->getBody();
    }

    function deleteByArticle($art_id)
    {
        $sql = "DELETE FROM ".art_DB_prefix("text")." WHERE art_id = ".intval($art_id);
        if (!$result = $this->db->queryF($sql)) {
              //xoops_error($this->db->error());
            return false;
        }
        return true;
    }
    */

    /**
     * clean orphan text from database
     * 
     * @return     bool    true on success
     */
    function cleanOrphan()
    {
        return parent::cleanOrphan(art_DB_prefix("article"), "art_id");
    }
}
'
);
?>