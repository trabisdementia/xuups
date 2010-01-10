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
 * @version         $Id: spotlight.php 2283 2008-10-12 03:36:13Z phppp $
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
    exit();
}
include_once dirname(dirname(__FILE__)) . "/include/vars.php";
mod_loadFunctions("parse", $GLOBALS["artdirname"]);

if (!class_exists("Spotlight")) {
class Spotlight extends XoopsObject
{
    function Spotlight($id = null)
    {
        //$this->ArtObject();
        //$this->table = art_DB_prefix("spotlight");
        $this->initVar("sp_id", XOBJ_DTYPE_INT, 0);
        $this->initVar("art_id", XOBJ_DTYPE_INT, 0);
        $this->initVar("uid", XOBJ_DTYPE_INT, 0);
        $this->initVar("sp_time", XOBJ_DTYPE_INT);
        $this->initVar("sp_image", XOBJ_DTYPE_ARRAY, array());
        $this->initVar("sp_categories", XOBJ_DTYPE_ARRAY, array());
        $this->initVar("sp_note", XOBJ_DTYPE_TXTAREA, "");

        $this->initVar("dohtml", XOBJ_DTYPE_INT, 1);
        $this->initVar("dosmiley", XOBJ_DTYPE_INT, 1);
        $this->initVar("doxcode", XOBJ_DTYPE_INT, 1);
        $this->initVar("doimage", XOBJ_DTYPE_INT, 1);
        $this->initVar("dobr", XOBJ_DTYPE_INT, 1);
    }

    function getImage()
    {
        $image = $this->getVar("sp_image");
        if (!empty($image["file"])) {
            mod_loadFunctions("url", $GLOBALS["artdirname"]);
            $image["url"] = art_getImageUrl($image["file"]);
        } else {
            $image = array();
        }
        return $image;
    }

    function getTime($format = "")
    {
        if (empty($format)) {
            if (!is_object($GLOBALS["xoopsModule"]) || $GLOBALS["xoopsModule"]->getVar("dirname") !=$GLOBALS["artdirname"]) {
                $module_handler =& xoops_gethandler("module");
                $artModule =& $module_handler->getByDirname($GLOBALS["artdirname"]);
                $config_handler =& xoops_gethandler("config");
                $artConfig =& $config_handler->getConfigsByCat(0, $artModule->getVar("mid"));
                $format = $artConfig["timeformat"];
            } else {
                $format =$GLOBALS["xoopsModuleConfig"]["timeformat"]; 
            }
        }
        mod_loadFunctions("time", $GLOBALS["artdirname"]);
        $time = art_formatTimestamp($this->getVar("sp_time"), $format);
        return $time;
    }
}
}

art_parse_class('
class [CLASS_PREFIX]SpotlightHandler extends XoopsPersistableObjectHandler
{    
    function [CLASS_PREFIX]SpotlightHandler(&$db)
    {
        $this->XoopsPersistableObjectHandler($db, art_DB_prefix("spotlight", true), "Spotlight", "sp_id");
    }
    
    function &get()
    {
        $Spotlight =& $this->create();
        $sql = "SELECT * FROM " . art_DB_prefix("spotlight") . " ORDER BY sp_id DESC LIMIT 1";
        if (!$result = $this->db->query($sql)) {
            return $Spotlight;
        }
        $array = $this->db->fetchArray($result);
        if (empty($array)) {
            return $Spotlight;
        }
        $Spotlight->assignVars($array);
        $Spotlight->unsetNew();

        return $Spotlight;
    }
    
    /**
     * Get spotlight article
     * 
      * {@link XoopsPersistableObjectHandler} 
      *
     * @param    bool    $asArticleId    retrun article ID
     * @param    bool    $specifiedOnly    only return article market as spotlight by editors; in this case, null is returned if "recent article" is selected in spotlight admin
     * @return    array    spotlight content
     */
    function &getContent($asArticleId = true, $specifiedOnly = false)
    {
        $content = array();
        $spotlight =& $this->get();
        if (!is_object($spotlight) || !$spotlight->getVar("art_id")) {
            $content["sp_note"] = "";
            $content["image"] = null;
            $art_id = 0;
            $categories = null;
        } else {
            $content["sp_note"] = $spotlight->getVar("sp_note");
            $content["image"] = $spotlight->getImage();
            $art_id = $spotlight->getVar("art_id");
            $categories = $spotlight->getVar("sp_categories");
        }
        if (empty($art_id) && !empty($specifiedOnly)) {
            return $content;
        }
        
        $article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
        if (empty($art_id)) {
            $criteria = new CriteriaCompo(new Criteria("ac.ac_publish", 0, ">"));
            $arts =& $article_handler->getIdsByCategory($categories, 1, 0, $criteria);
            $art_id = empty($arts[0])?0:$arts[0];
        }
        
        $content["art_id"] = $art_id;
        if ($asArticleId) {
        } elseif ($art_id>0) {
            $article_obj =& $article_handler->get($art_id);
            if (!is_object($article_obj)) {
                unset($content["art_id"]);
                return $content;
            }
            $content["image"]    = empty($content["image"]) ? $article_obj->getImage() : $content["image"];
            $content["title"]    = $article_obj->getVar("art_title");
            $content["uid"]        = $article_obj->getVar("uid") ;
            $content["writer_id"] = $article_obj->getVar("writer_id") ;
            $content["time"]    = $article_obj->getTime();
            $content["views"]    = $article_obj->getVar("art_counter") ;
            $content["comments"]= $article_obj->getVar("art_comments") + $article_obj->getVar("art_trackbacks");
            $content["summary"]    = $article_obj->getSummary(true);
        } else {
            $content["summary"] = "";
        }
        return $content;
    }

    /**
     * clean orphan items from database
     * 
     * @return     bool    true on success
     */
    function cleanOrphan()
    {
        return true; // skip this step since it will remove all spotlight with "art_id = 0";
        
        //return parent::cleanOrphan(art_DB_prefix("article"), "art_id");
    }
}
'
);
?>