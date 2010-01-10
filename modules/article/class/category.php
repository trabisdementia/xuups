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
 * @version         $Id: category.php 2283 2008-10-12 03:36:13Z phppp $
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
    exit();
}
include_once dirname(dirname(__FILE__)) . "/include/vars.php";
mod_loadFunctions("parse", $GLOBALS["artdirname"]);

/**
 * Xcategory 
 * 
 * @author D.J. (phppp)
 * @copyright copyright &copy; 2005 XoopsForge.com
 * @package module::article
 *
 * {@link XoopsObject} 
 **/
if (!class_exists("Xcategory")) {
class Xcategory extends XoopsObject
{
    /**
     * Constructor
     */
    function Xcategory()
    {
        //$this->ArtObject();
        //$this->table = art_DB_prefix("category");
        $this->initVar("cat_id",             XOBJ_DTYPE_INT,     null, false);                // auto_increment unique ID
        $this->initVar("cat_title",         XOBJ_DTYPE_TXTBOX,     "", true);                    // category title
        $this->initVar("cat_pid",             XOBJ_DTYPE_INT,     0, false);                     // parent category ID
        $this->initVar("cat_description",     XOBJ_DTYPE_TXTAREA,    "", false);                    // description
        $this->initVar("cat_image",         XOBJ_DTYPE_SOURCE,    "", false);                    // header graphic (unique)
        $this->initVar("cat_order",         XOBJ_DTYPE_INT,     99, false);                    // display order
        $this->initVar("cat_entry",         XOBJ_DTYPE_INT,     0, false);                     // entry article ID for the category. If cat_entry is set, the article will substitute the category index page
                                                                                            // Feature designed by Skalpa
        $this->initVar("cat_template",         XOBJ_DTYPE_SOURCE,    "default", false);            // category-wide template
        $this->initVar("cat_sponsor",         XOBJ_DTYPE_TXTAREA,    "", false);                    // sponsors: url[space]title

        $this->initVar("cat_moderator",     XOBJ_DTYPE_ARRAY,     serialize(array()));        // moderators/editors
        $this->initVar("cat_track",         XOBJ_DTYPE_ARRAY,     serialize(array()));         // track back to top category, for building Bread Crumbs
        $this->initVar("cat_lastarticles",     XOBJ_DTYPE_ARRAY,     serialize(array()));         // last 10 article Ids
    }

    /**
     * get a list of parsed sponsors of the category
     * 
     * @return     array
     */
    function &getSponsor()
    {
        $sponsors = art_parseLinks($this->getVar("cat_sponsor", "e"));
        return $sponsors;
    }

    /**
     * get verified image url of the category
     * 
     * @return     string
     */
    function getImage()
    {
        mod_loadFunctions("url", $GLOBALS["artdirname"]);
        $image = art_getImageUrl($this->getVar("cat_image"));
        return $image;
    }
}
}

/**
* Category object handler class.  
* @package module::article
*
* @author  D.J. (phppp)
* @copyright copyright &copy; 2005 The XOOPS Project
*
* {@link XoopsPersistableObjectHandler} 
*
* @param CLASS_PREFIX variable prefix for the class name
*/

art_parse_class('
class [CLASS_PREFIX]CategoryHandler extends XoopsPersistableObjectHandler
{
    /**
     * Constructor
     *
     * @param object $db reference to the {@link XoopsDatabase} object     
     **/
    function [CLASS_PREFIX]CategoryHandler(&$db)
    {
        $this->XoopsPersistableObjectHandler($db, art_DB_prefix("category", true), "Xcategory", "cat_id", "cat_title");
    }

    /**
     * get IDs of latest articles of the category
     * 
     * @param     category    $category     {@link Xcategory}
     * @param     int           $limit      Max number of article IDs to fetch
     * @return     array of article IDs
     */
    function &getLastArticleIds(&$category, $limit = 0)
    {
        $art_ids = $category->getVar("cat_lastarticles");
        if ($limit > 0) @array_splice($art_ids, $limit);
        return $art_ids;
    }

    /**#@+
     *
     * set IDs of latest articles of the category in database
     * 
     * {@link CriteriaCompo} 
     *
     * @return     bool    true on success
     */
    function setLastArticleIds($cat_id = null)
    {
        if (is_array($cat_id) && count($cat_id) > 0) {
            foreach ($cat_id as $id) {
                $cat =& $this->get($id);
                $this->_setLastArticleIds($cat);
                unset($cat);
            }
        } elseif ($cat_id = intval($cat_id)) {
            $cat =& $this->get($cat_id);
            $this->_setLastArticleIds($cat);
            unset($cat);
        } else {
            $cats = $this->getAllByPermission("access", array("cat_id"));
            foreach ($cats as $id => $cat) {
                $cat =& $this->get($id);
                $this->_setLastArticleIds($cat);
            }
            unset($cats);
        }
        return true;
    }

    function _setLastArticleIds(&$category)
    {
        $criteria = new CriteriaCompo(new Criteria("ac.ac_publish", 0, ">"));
        $criteria->setSort("ac.ac_publish");
        $criteria->setOrder("DESC");
        $artConfig = art_load_config();
        $limit = MAX($artConfig["articles_perpage"], 10);
        $article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
        $articleIds = $article_handler->getIdsByCategory($category, $limit, 0, $criteria);
        $category->setVar("cat_lastarticles", $articleIds);
        unset($articleIds);
        return $this->insert($category, true);
    }
    /**#@-*/

    /**
     * insert a new category into the database
     * 
     * @param    object    $category     {@link Xcategory} reference to Xcategory
     * @param     bool     $force         flag to force the query execution despite security settings
     * @return     int     category ID
     */
    function insert(&$category, $force = true)
    {
        $cat_id = parent::insert($category, $force);
        if (!empty($category->vars["cat_pid"]["changed"])) {
            $this->updateTracks($category);
        }
        return $cat_id;
    }

    /**
     * delete an article from the database
     * 
     * {@link Article}
     * {@link Xtopic}
     * {@link Permission}
     *
     * @param    object    $category             {@link Xcategory} reference to Xcategory
     * @param     bool     $force                 flag to force the query execution despite security settings
     * @param     bool     $forceDelete         flag to force deleting articles/subcategories, otherwise move to its parent category
     * @return     bool     true on success
     */
    function delete(&$category, $force = true, $forceDelete = false)
    {
        $des_cat = ($category->getVar("cat_pid")) ? $category->getVar("cat_pid") : 0; // move to parent category
        $article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
        $articles = $article_handler->getByCategory($category);
        
        if (!empty($forceDelete) || empty($des_cat)) {
            foreach (array_keys($articles) as $id) {
                $article_handler->terminateCategory($articles[$id], $category->getVar("cat_id"));
                if (is_object($articles[$id]) && $articles[$id]->getVar("cat_id") != $category->getVar("cat_id")) {
                    $article_handler->updateCategories($articles[$id]);
                }
            }
        } else {
            $article_handler->updateAll("cat_id", $des_cat, new Criteria("cat_id", $category->getVar("cat_id")), true);
            foreach (array_keys($articles) as $id) {
                if ($des_cat > 0 && $articles[$id]->getVar("cat_id") == $category->getVar("cat_id")) {
                    $article_handler->moveCategory($articles[$id], $des_cat, $category->getVar("cat_id"));
                } else {
                    $article_handler->terminateCategory($articles[$id], $category->getVar("cat_id"));
                }
                $article_handler->updateCategories($articles[$id]);
            }
        }
        unset($articles);
        
        if (empty($forceDelete)) {
            $this->updateAll("cat_pid", $des_cat, new Criteria("cat_pid", $category->getVar("cat_id")), true);
            if (!empty($des_cat)) {
                $this->setLastArticleIds($des_cat);
            }
        } else {
            $cats = $this->getChildCategories($category->getVar("cat_id"));        
            foreach (array_keys($cats) as $id) {
                $this->delete($cats[$id], $force, $forceDelete);
            }
            unset($cats);
        }
        
        $queryFunc = empty($force) ? "query" : "queryF";
        $sql = "DELETE FROM " . art_DB_prefix("artcat") . " WHERE cat_id = " . $category->getVar("cat_id");
        $result = $this->db->{$queryFunc}($sql);
        
        $topic_handler =& xoops_getmodulehandler("topic", $GLOBALS["artdirname"]);
        $topic_handler->deleteAll(new Criteria("cat_id", $category->getVar("cat_id")));
        
        xoops_notification_deletebyitem($GLOBALS["xoopsModule"]->getVar("mid"), "category", $category->getVar("cat_id"));
        
        $sql = "DELETE FROM " . $category->table . " WHERE cat_id = " . $category->getVar("cat_id");
        if ($result = $this->db->{$queryFunc}($sql)) {

            $permission_handler =& xoops_getmodulehandler("permission", $GLOBALS["artdirname"]);
            $permission_handler->deleteByCategory($category->getVar("cat_id"));
        
            return true;
        } else {
            //xoops_error("delte category error: ".$sql);
            return false;
        }
    }

    /**
     * get a list of categories including a specified article and matching a condition
     * 
     * {@link Permission}
     *
     * @param    mixed    $art_id     article ID(s)
     * @param     object    $criteria     {@link CriteriaElement} to match
     * @return     array of categories {@link Xcategory}
     */
    function &getByArticle($art_id, $criteria = null)
    {
        $_cachedTop = array();
        $ret = array();
        if (empty($art_id)) {
            return $ret;
        }

        $sql = "SELECT c.cat_id, c.cat_title FROM " . art_DB_prefix("category") . " AS c";
        $sql .= " LEFT JOIN " . art_DB_prefix("artcat") . " AS ac ON ac.cat_id=c.cat_id";
        if (is_array($art_id) && count($art_id) > 0) {
            $sql .= " WHERE ac.art_id IN (" . implode(",", $art_id) . ")";
        } elseif (intval($art_id)) {
            $sql .= " WHERE ac.art_id = " . intval($art_id);
        } else {
            $sql .= " WHERE 1=1";
        }
        
        mod_loadFunctions("user", $GLOBALS["artdirname"]);
        if (!art_isAdministrator()) {
            $permission_handler =& xoops_getmodulehandler("permission", $GLOBALS["artdirname"]);
            $allowed_cats =& $permission_handler->getCategories();
            if (count($allowed_cats) == 0) return $ret;
            $sql .= " AND c.cat_id IN (" . implode(",", $allowed_cats) . ")";
        }
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " AND " . $criteria->render();
            if ($criteria->getSort() != "") {
                $sql .= " ORDER BY " . $criteria->getSort() . " " . $criteria->getOrder();
                $orderSet = true;
            }
        }
        if (empty($orderSet))  $sql .= " ORDER BY c.cat_id, c.cat_order";
        if (!$result = $this->db->query($sql)) {
            //xoops_error($this->db->error());
            return $ret;
        }
        while ($row = $this->db->fetchArray($result)) {
            $category =& $this->create(false);
            $category->assignVars($row);
            $ret[$category->getVar("cat_id")] = $category;
            unset($category);
        }
        return $ret;
    }

    /**
     * get all categories with specified permission
     * 
     * @param string    $permission Permission type
     * @param array        $tags     variables to fetch
     * @return    array of categories {@link Xcategory}
     */
    function &getAllByPermission($permission = "access", $tags = null)
    {
        $ret = array();
        
        mod_loadFunctions("user", $GLOBALS["artdirname"]);
        if (!art_isAdministrator()) {
            $permission_handler =&  xoops_getmodulehandler("permission", $GLOBALS["artdirname"]);
            $allowed_cats =& $permission_handler->getCategories($permission);
            if ( count($allowed_cats) == 0 ) return $ret;
            $criteria = new Criteria("cat_id", "(" . implode(",", $allowed_cats) . ")", "IN");
        } else {
            $criteria = new Criteria("1", 1);
        }
        $criteria->setSort("cat_pid ASC, cat_order");
        $criteria->setOrder("ASC");
        
        $ret = parent::getAll($criteria, $tags);
        return $ret;
    }
    
    /**
     * get child categories with specified permission
     * 
     * @param int    $category category ID
     * @param string    $permission Permission type
     * @return    array of categories {@link Xcategory}
     */
    function &getChildCategories($category = 0, $permission = "access", $tags = null)
    {
        $pid = intval($category);
        $ret = array();
        
        $criteria = new CriteriaCompo(new Criteria("cat_pid", $pid));
        $criteria->setSort("cat_order");
        mod_loadFunctions("user", $GLOBALS["artdirname"]);
        if (!art_isAdministrator()) {
            $permission_handler =&  xoops_getmodulehandler("permission", $GLOBALS["artdirname"]);
            $allowed_cats =& $permission_handler->getCategories($permission);
            if (count($allowed_cats) == 0) return $ret;
            $criteria->add(new Criteria("cat_id", "(" . implode(", ", $allowed_cats) . ")", "IN"));
        }
        
        $ret = parent::getAll($criteria, $tags);
        unset($criteria);
        return $ret;
    }

    /**
     * get all subcategories with specified permission
     * 
     * @param     int        $pid 
     * @param     string    $permission Permission type
     * @param     array    $tags         variables to fetch
     * @return    array of categories {@link Xcategory}
     */
    function &getSubCategories($pid = 0, $permission = "access", $tags = null)
    {
        $pid = intval($pid);
        $perm_string = (empty($permission)) ? "access" : $permission;
        if (!is_array($tags) || count($tags) == 0) $tags = array("cat_id", "cat_pid", "cat_title", "cat_order");
        $categories = $this->getAllByPermission($perm_string, $tags);

        require_once XOOPS_ROOT_PATH . "/modules/" . $GLOBALS["artdirname"] . "/class/tree.php";
        $tree = new artTree($categories);
        $category_array = $tree->getAllChild(0);
        unset($categories);
        return $category_array;
    }

    /**#@+
     * get all parent categories
     * 
     * @param     object    $category {@link Xcategory}
     * @param     bool    $reverse    flag for reverse order
     * @return    array of categories {@link Xcategory}
     */
    function &getSupCategories(&$category, $reverse = true)
    {
        if (!is_object($category))  {
            $category =& $this->get(intval($category));
        }
        $pid = $category->getVar("cat_pid");
        $category_array=array();
        $this->_getSup($category_array, $pid);
        if ($reverse) $category_array = array_reverse($category_array);

        return $category_array;
    }

    function _getSup(&$category_array, $id = 0)
    {
        if (empty($id)) return null;
        $category = $this->get(intval($id));
        $category_array[] = intval($id);
        $pid = $category->getVar("cat_pid");
        unset($category);
        $this->_getSup($category_array, $pid);
        return true;
    }
    /**#@-*/

    /**
     * recursively update breadcrumbs of the category and its subcategories
     * 
     * @param     object    $category {@link Xcategory}
     * @param     array    $tracks    array of parent category IDs
     * @return    bool    true on success
     */
    function updateTracks(&$category, $tracks = null)
    {
        if ($tracks === null)  $tracks = $this->getSupCategories($category);
        $this->setTrack($category, $tracks);
        $subCats = $this->getChildCategories($category->getVar("cat_id"));
        $tracks[] = $category->getVar("cat_id");
        foreach ($subCats as $id => $cat) {
            $this->updateTracks($cat, $tracks);
        }
        unset($subCats, $tracks);
        return true;
    }

    /**
     * set breadcrumbs of the category
     * 
     * @param     object    $category {@link Xcategory}
     * @param     array    $ids    array of parent category IDs
     * @return    bool    true on success
     */
    function setTrack(&$category, $ids = array())
    {
         if (!is_array($ids)) return false;
         $ids = array_map("intval", $ids);
         $track = $this->db->quoteString(serialize($ids));
        $sql = "UPDATE " . $category->table . " SET cat_track = $track WHERE cat_id=" . $category->getVar("cat_id");
        if (!$result = $this->db->queryF($sql)) {
            //xoops_error($this->db->error());
            return false;
        }
        return true;
    }

    /**
     * get breadcrumbs of the category
     * 
     * @param     object    $category {@link Xcategory}
     * @param     bool    $incCurrent    flag for including current category
     * @return    array    associative array of category IDs and titles
     */
    function &getTrack(&$category, $incCurrent = false)
    {
        $ret = array();
        if (!is_object($category)) {
            return $ret;
        }
        $tracks = $category->getVar("cat_track");
        if (!empty($tracks)) {
            $criteria = new Criteria("cat_id", "(" . implode(",", $tracks) . ")", "IN");
            $cats = $this->getList($criteria);
            foreach ($tracks as $id) {
                $ret[]=array(
                    "id"    => $id,
                    "title"    => $cats[$id]
                    );
            }
        }
        if ($incCurrent) {
            $ret[] = array(
                "id"    => $category->getVar("cat_id"),
                "title"    => $category->getVar("cat_title")
                );
        }
        return $ret;
    }

    /**
     * get a hierarchical tree of categories
     * 
     * {@link artTree} 
     *
     * @param     int        $pid     Top category ID
     * @param     string    $permission    permission type
     * @param     string    $prefix        prefix for display
     * @param     string    $tags        variables to fetch
     * @return    array    associative array of category IDs and sanitized titles
     */
    function &getTree($pid = 0, $permission = "access", $prefix = "--", $tags = array())
    {
        $pid = intval($pid);
        $perm_string = $permission;
        if (!is_array($tags) || count($tags) == 0) $tags = array("cat_id", "cat_pid", "cat_title", "cat_order");
        $categories = $this->getAllByPermission($perm_string, $tags);

        require_once XOOPS_ROOT_PATH . "/modules/" . $GLOBALS["artdirname"] . "/class/tree.php";
        $tree = new artTree($categories);
        $category_array =& $tree->makeTree($prefix, $pid, $tags);
        return $category_array;
    }

    /**
     * get a hierarchical array tree of categories
     * 
     * {@link artTree} 
     *
     * @param     int        $pid     Top category ID
     * @param     string    $permission    permission type
     * @param     string    $tags        variables to fetch
     * @param   integer    $depth    level of subcategories
     * @return    array    associative array of category IDs and sanitized titles
     */
    function &getArrayTree($pid = 0, $permission = "access", $tags = null, $depth = 0)
    {
        $pid = intval($pid);
        $perm_string = $permission;
        if (!is_array($tags) || count($tags) == 0) $tags = array("cat_id", "cat_pid", "cat_title", "cat_order");
        $categories = $this->getAllByPermission($perm_string, $tags);

        require_once XOOPS_ROOT_PATH . "/modules/" . $GLOBALS["artdirname"] . "/class/tree.php";
        $tree = new artTree($categories);
        $category_array =& $tree->makeArrayTree($pid, $tags, $depth);
        return $category_array;
    }

    /**
     * get articles matching a condition of a category
     * 
     * @param mixed        $category     array or {@link Xcategory}
     * @param int       $limit      Max number of objects to fetch
     * @param int       $start      Which record to start at
     * @param object    $criteria     {@link CriteriaElement} to match
     * @param array        $tags         variables to fetch
     * @param bool        $asObject     flag indicating as object, otherwise as array
     * @return array of articles {@link Article}
     */
       function &getArticles(&$category, $limit = 0, $start = 0, $criteria = null, $tags = null, $asObject = true)
       {
        if (is_array($tags) && count($tags) > 0) {
            $key_artid = array_search("art_id", $tags);
            if (is_numeric($key_artid)) {
                $tags[$key_artid] = "a.art_id";
            }
            if (!in_array("a.art_id", $tags)) {
                $tags[] = "a.art_id";
            }
            $select = implode(",", $tags);
        } else { 
            $select = "*";
        }
        $sql = "SELECT $select FROM " . art_DB_prefix("article") . " AS a";
        $sql .= " LEFT JOIN " . art_DB_prefix("artcat") . " AS ac ON ac.art_id=a.art_id";
        $sql .= " WHERE a.art_time_submit > 0";
        $sql .= " AND (a.cat_id = ac.cat_id OR a.art_time_publish > 0)";
        if (is_array($category) && count($category) > 0) {
            $category = array_map("intval", $category);
            $sql .= " AND ac.cat_id IN (" . implode(",", $category) . ")";
        } else {
            $cat_id = (is_object($category)) ? $category->getVar("cat_id") : intval($category);
            if ($cat_id > 0) $sql .= " AND ac.cat_id = " . intval($cat_id);
        }
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " AND " . $criteria->render();
            if ($criteria->getSort() != "") {
                $sql .= " ORDER BY " . $criteria->getSort() . " " . $criteria->getOrder();
                $orderSet = true;
            }
        }
        if (empty($orderSet)) $sql .= " ORDER BY ac.ac_publish DESC";
        $result = $this->db->query($sql, intval($limit), intval($start));
        $ret = array();
        $article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
           while ($myrow = $this->db->fetchArray($result)) {
            $article =& $article_handler->create(false);
            $article->assignVars($myrow);
            if ($asObject) {
                $ret[] = $article;
            } else {
                $_ret = array();
                foreach ($myrow as $key => $val) {
                    $_ret[$key] = isset($article->vars[$key]) ? $article->getVar($key) : $val;
                }
                //$ret[] = $article->getValues(array_keys($myrow));
                $ret[] = $_ret;
            }
            unset($article);
        }
        return $ret;
       }
       
    /**
     * count featured articles matching a condition of a category
     * 
     * {@link CriteriaCompo} 
     *
     * @param     mixed    $cat_id array or {@link Xcategory}
     * @param     object     $criteria {@link CriteriaElement} to match
     * @return     int     count of articles
     */
       function getArticleCountFeatured(&$cat_id, $criteria = null)
       {
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $criteria->add(new Criteria("ac.ac_feature", 0, ">"));
        } else {
            $criteria = new CriteriaCompo(new Criteria("ac.ac_feature", 0, ">"));
        }
        return $this->getArticleCount($cat_id, $criteria);
       }

    /**
     * count published articles matching a condition of a category
     * 
     * {@link CriteriaCompo} 
     *
     * @param     mixed    $cat_id array or {@link Xcategory}
     * @param     object     $criteria {@link CriteriaElement} to match
     * @return     int     count of articles
     */
       function getArticleCountPublished(&$cat_id, $criteria = null)
       {
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $criteria->add(new Criteria("ac.ac_publish", 0, ">"));
        } else {
            $criteria = new CriteriaCompo(new Criteria("ac.ac_publish", 0, ">"));
        }
        return $this->getArticleCount($cat_id, $criteria);
       }

    /**
     * count registered articles matching a condition of a category
     * 
     * {@link CriteriaCompo} 
     *
     * @param     mixed    $cat_id array or {@link Xcategory}
     * @param     object     $criteria {@link CriteriaElement} to match
     * @return     int     count of articles
     */
       function getArticleCountRegistered(&$cat_id, $criteria = null)
       {
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $criteria->add(new Criteria("ac.ac_register", 0, ">"));
        } else {
            $criteria = new CriteriaCompo(new Criteria("ac.ac_register", 0, ">"));
        }
        $criteria->add(new Criteria("ac.ac_publish", 0));
        return $this->getArticleCount($cat_id, $criteria);
       }

    /**
     * count articles matching a condition of a category
     * 
     * @param     mixed    $cat_id array or {@link Xcategory}
     * @param     object     $criteria {@link CriteriaElement} to match
     * @return     int     count of articles
     */
    function getArticleCount(&$cat_id, $criteria = null)
    {
        $sql = "SELECT COUNT(*) as count FROM " . art_DB_prefix("artcat") . " AS ac";
        if (is_array($cat_id) && count($cat_id) > 0) {
            $sql .= " WHERE ac.cat_id IN (" . implode(",", $cat_id) . ")";
        } elseif (is_object($cat_id)) {
            $sql .= " WHERE ac.cat_id = " . $cat_id->getVar("cat_id");
        } elseif (intval($cat_id)) {
            $sql .= " WHERE ac.cat_id = " . intval($cat_id);
        } else {
            $sql .= " WHERE 1=1";
        }
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " AND " . $criteria->render();
        }
        $result = $this->db->query($sql);
        $myrow = $this->db->fetchArray($result);
        return intval($myrow["count"]);
    }

    /**
     * count registered articles matching a condition of a list of categories, respectively
     * 
     * @param     int        $cat_id array of category IDs
     * @param     object     $criteria {@link CriteriaElement} to match
     * @return     int     count of articles
     */
       function getArticleCountsRegistered($cat_id = 0, $criteria = null)
       {
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $criteria->add(new Criteria("ac.ac_register", 0, ">"));
        } else {
            $criteria = new CriteriaCompo(new Criteria("ac.ac_register", 0, ">"));
        }
        $criteria->add(new Criteria("ac.ac_publish", 0));
        return $this->getArticleCounts($cat_id, $criteria);
       }

    /**
     * count articles matching a condition of a list of categories, respectively
     * 
     * @param     mixed    $cat_id array or {@link Xcategory}
     * @param     object     $criteria {@link CriteriaElement} to match
     * @return     array     associative array category ID and article count
     */
    function &getArticleCounts($cat_id = null, $criteria = null)
    {
        $sql = "SELECT ac.cat_id, COUNT(*) as count FROM " . art_DB_prefix("artcat") . " AS ac";
        if (is_array($cat_id) && count($cat_id) > 0) {
            $sql .= " WHERE ac.cat_id IN (" . implode(",", $cat_id) . ")";
        } elseif (intval($cat_id)) {
            $sql .= " WHERE ac.cat_id = " . intval($cat_id);
        } else {
            $sql .= " WHERE 1=1";
        }
        if (isset($criteria) && is_subclass_of($criteria, "criteriaelement")) {
            $sql .= " AND " . $criteria->render();
        }
        $sql .= " GROUP BY ac.cat_id";
        $result = $this->db->query($sql);
        $ret = array();
        while ($myrow = $this->db->fetchArray($result)) {
            $ret[$myrow["cat_id"]] = $myrow["count"];
        }
        return $ret;
    }

    /**
     * count categories with specified permission of a list of parent categories, respectively
     * 
     * @param     mixed    $cat_pid     array or category ID
     * @param     string     $permission    permission type
     * @return     array     associative array category IDs and subcategory counts
     */
    function &getCategoryCounts($cat_pid=0, $permission = "access")
    {
        $sql = "SELECT cat_pid, COUNT(*) as count FROM " . $this->table;
        if (is_array($cat_pid) && count($cat_pid) > 0) {
            $sql .= " WHERE cat_pid IN (" . implode(",", $cat_pid) . ")";
        } elseif (intval($cat_pid)) {
            $sql .= " WHERE cat_pid = " . intval($cat_pid);
        } else {
            $sql .= " WHERE 1=1";
        }
        mod_loadFunctions("user", $GLOBALS["artdirname"]);
        if (!art_isAdministrator()) {
            $permission_handler =&  xoops_getmodulehandler("permission", $GLOBALS["artdirname"]);
            $allowed_cats =& $permission_handler->getCategories($permission);
            if (count($allowed_cats) == 0) {
                $ret = array();
                return $ret;
            }
            $sql .= " AND cat_id IN (" . implode(",", $allowed_cats) . ")";
        }
        $sql .= " GROUP BY cat_pid";
        $result = $this->db->query($sql);
        $ret = array();
        while ($myrow = $this->db->fetchArray($result)) {
            $ret[$myrow["cat_pid"]] = $myrow["count"];
        }
        return $ret;
    }

    /**
     * check permission of the category
     * 
     * {@link Permission} 
     *
     * @param     mixed    $category     category ID or {@link Xcategory}
     * @param     string     $type         permission type
     * @return     bool     true on accessible
     */
    function getPermission(&$category, $type = "access")
    {
        global $xoopsUser, $xoopsModule;
        static $_cachedPerms;

        if ($GLOBALS["xoopsUserIsAdmin"] && $xoopsModule->getVar("dirname") == $GLOBALS["artdirname"]) {
            return true;
        }
        $cat_id = is_object($category)? $category->getVar("cat_id") : intval($category);

        $type = strtolower($type);
        if ("moderate" == $type) {
            mod_loadFunctions("user", $GLOBALS["artdirname"]);
            $permission = art_isModerator($category);
        } else {
            if (!isset($_cachedPerms[$type][$cat_id])) {
                $getpermission =&  xoops_getmodulehandler("permission", $GLOBALS["artdirname"]);
                $_cachedPerms[$type][$cat_id] = $getpermission->getPermission($type, $cat_id);
            }
            $permission = (!empty($_cachedPerms[$type][$cat_id])) ? 1 : 0;
        }
        return $permission;
    }

    /**
     * clean orphan art-cat links from database
     * 
     * @return     bool    true on success
     */
    function cleanOrphan()
    {
        /* for MySQL 4.1+ */
        if (version_compare( mysql_get_server_info(), "4.1.0", "ge" )):
        $sql =     "DELETE " . $this->table . " FROM " . $this->table.
                " LEFT JOIN " . $this->table . " AS aa ON " . $this->table . ".cat_pid = aa.cat_id ".
                " WHERE " . $this->table . ".cat_pid>0 AND (aa.cat_id IS NULL)";
        else:
        $this->identifierName = "cat_pid";
        $category_list = $this->getList(new Criteria("cat_pid", 0, ">"));
        $this->identifierName = "cat_title";
        if ($parent_categories = @array_values($category_list)) {
            $parent_list = $this->getIds(new Criteria("cat_id", "(" . implode(", ", $parent_categories) . ")", "IN"));
            foreach ($category_list as $cat_id => $parent_category) {
                if (in_array($parent_category, $parent_list)) continue;
                $category_obj =& $this->get($cat_id);
                $this->delete($category_obj);
                unset($category_obj);
            }
        }
        endif;
        
        if (!empty($sql) && !$result = $this->db->queryF($sql)) {
            //xoops_error("cleanOrphan error:". $sql);
        }
        
        /* for MySQL 4.1+ */
        if (version_compare( mysql_get_server_info(), "4.1.0", "ge" )):
        $sql = "DELETE FROM " . art_DB_prefix("artcat") .
                " WHERE (cat_id NOT IN ( SELECT DISTINCT cat_id FROM " . $this->table . ") )";
        else:
        $sql =     "DELETE " . art_DB_prefix("artcat") . " FROM " . art_DB_prefix("artcat") .
                " LEFT JOIN " . $this->table . " AS aa ON " . art_DB_prefix("artcat") . ".cat_id = aa.cat_id ".
                " WHERE (aa.cat_id IS NULL)";
        endif;
        if (!$result = $this->db->queryF($sql)) {
            //xoops_error("cleanOrphan error:". $sql);
        }
        return true;
    }
    
    function updateTrack($category = null, $tracks = null)
    {
        if (empty($category)) {
            $categories_obj = $this->getObjects(new Criteria("cat_pid", 0), true);
            foreach (array_keys($categories_obj) as $key) {
                $this->updateTracks($categories_obj[$key]);
            }
            unset($categories_obj);
            return true;
        }
        if ($tracks === null)  $tracks = $this->getSupCategories($category);
        $this->setTrack($category, $tracks);
        $subCats = $this->getChildCategories($category->getVar("cat_id"));
        $tracks[] = $category->getVar("cat_id");
        foreach ($subCats as $id => $cat) {
            $this->updateTracks($cat, $tracks);
        }
        unset($subCats, $tracks);
        return true;
    }
}
');
?>