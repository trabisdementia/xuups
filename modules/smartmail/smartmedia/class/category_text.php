<?php

/**
 * Contains the classes for managing categories translations
 *
 * @license GNU
 * @author marcan <marcan@smartfactory.ca>
 * @version $Id: category_text.php,v 1.3 2005/06/02 13:33:37 malanciault Exp $
 * @link http://www.smartfactory.ca The SmartFactory
 * @package SmartMedia
 * @subpackage Categories
 */

/**
 * SmartMedia Category_text class
 *
 * @package SmartMedia
 * @author marcan <marcan@smartfactory.ca>
 * @link http://www.smartfactory.ca The SmartFactory
 */
class SmartmediaCategory_text extends XoopsObject {

    /**
     * Constructor
     *
     * @param array $id array containing values to be assigned
     */
    function SmartmediaCategory_text($id = null)
    {
        $smartConfig =& smartmedia_getModuleConfig();

        $this->initVar('categoryid', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('languageid', XOBJ_DTYPE_TXTBOX, $smartConfig['default_language'], true);
        $this->initVar("title", XOBJ_DTYPE_TXTBOX, null, false, 100);
        $this->initVar('description', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('meta_description', XOBJ_DTYPE_TXTAREA, null, false);

        $this->initVar("dohtml", XOBJ_DTYPE_INT, 1, false);
        $this->initVar("doxcode", XOBJ_DTYPE_INT, 1, false);
        $this->initVar("dosmiley", XOBJ_DTYPE_INT, 1, false);
        $this->initVar("doimage", XOBJ_DTYPE_INT, 0, false);

        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    /**
     * @return string categoryid of this translation
     */
    function categoryid($format="S")
    {
        return $this->getVar("categoryid", $format);
    }
     
    /**
     * @return string language of this translation
     */
    function languageid($format="S")
    {
        return $this->getVar("languageid", $format);
    }

    /**
     * @return string title of this category
     */
    function title($format="S")
    {
        return $this->getVar("title", $format);
    }

    /**
     * @return description title of this clip
     */
    function description($format="S")
    {
        return $this->getVar("description", $format);
    }

    /**
     * @return string meta_description of this clip
     */
    function meta_description($format="S")
    {
        return $this->getVar("meta_description", $format);
    }

    /**
     * Stores the category's translation in the database
     *
     * @param bool $force
     * @return bool true if successfully stored false if an error occured
     * @see SmartmediaCategory_textHandler::insert()
     */
    function store($force = true)
    {
        global $smartmedia_category_text_handler;
        return $smartmedia_category_text_handler->insert($this, $force);
    }

}

/**
 * Smartmedia Category_text Handler class
 *
 * Category Translations Handler responsible for handling {@link SmartmediaCategory_text} objects
 *
 * @package SmartMedia
 * @author marcan <marcan@smartfactory.ca>
 * @link http://www.smartfactory.ca The SmartFactory
 */
class SmartmediaCategory_textHandler extends XoopsObjectHandler {
    /**
     * Database connection
     *
     * @var	object
     */
    var $_db;

    /**
     * Name of child class
     *
     * @var	string
     */
    var $classname = 'smartmediacategory_text';

    /**
     * Related table name
     *
     * @var string
     */
    var $_dbtable = 'smartmedia_categories_text';

    /**
     * Constructor
     *
     * @param object $db reference to a xoopsDB object
     */
    function SmartmediaCategory_textHandler(&$db)
    {
        $this->_db = $db;
    }

    /**
     * Singleton - prevent multiple instances of this class
     *
     * @param object &$db {@link XoopsHandlerFactory}
     * @return object SmartmediaCategory_textHandler
     */
    function &getInstance(&$db)
    {
        static $instance;
        if(!isset($instance)) {
            $instance = new SmartmediaCategory_textHandler($db);
        }
        return $instance;
    }

    /**
     * Creates a new category's translation object
     * @return object SmartmediaCategory_text
     */
    function &create()
    {
        return new $this->classname();
    }

    /**
     * Retrieve a category translation object from the database
     *
     * If no $languageid is specified, the default_language set in the module's preference
     * will be used
     *
     * @param int $id id of the category
     * @param string $languageid language of the translation to retreive
     * @return object SmartmediaCategory_text
     */
    function &get($categoryid, $languageid='none')
    {
        if ($languageid=='none') {
            $smartConfig =& smartmedia_getModuleConfig();
            $languageid = $smartConfig['default_language'];
        }
        $categoryid = intval($categoryid);
        if($categoryid > 0) {
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria('categoryid', $categoryid));
            $criteria->add(new Criteria('languageid', $languageid));
            $sql = $this->_selectQuery($criteria);

            // echo "<br /> $sql <br />";

            if(!$result = $this->_db->query($sql)) {
                return false;
            }
            $numrows = $this->_db->getRowsNum($result);
            if($numrows == 1) {
                $obj = new $this->classname($this->_db->fetchArray($result));
                return $obj;
            }
        }
        return false;
    }

    /**
     * Create a "select" SQL query
     * @param object $criteria {@link CriteriaElement} to match
     * @return	string SQL query
     */
    function _selectQuery($criteria = null)
    {
        $sql = sprintf('SELECT * FROM %s', $this->_db->prefix($this->_dbtable));
        if(isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' .$criteria->renderWhere();
            if($criteria->getSort() != '') {
                $sql .= ' ORDER BY ' . $criteria->getSort() . '
                    ' .$criteria->getOrder();
            }
        }
        return $sql;
    }

    /**
     * Count objects matching a criteria
     *
     * @param object $criteria {@link CriteriaElement} to match
     * @return int count of objects
     */
    function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM '.$this->_db->prefix($this->_dbtable);
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
        }
        if (!$result =& $this->_db->query($sql)) {
            return 0;
        }
        list($count) = $this->_db->fetchRow($result);
        return $count;
    }

    /**
     * Retrieve objects from the database
     *
     * @param object $criteria {@link CriteriaElement} conditions to be met
     * @param bool $id_as_key Should the category ID be used as array key
     * @return array array of {@link SmartmediaCategory_text} objects
     */
    function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret    = array();
        $limit  = $start = 0;
        $sql    = $this->_selectQuery($criteria);
        if (isset($criteria)) {
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }

        $result = $this->_db->query($sql, $limit, $start);
        // If no records from db, return empty array
        if (!$result) {
            return $ret;
        }

        // Add each returned record to the result array
        while ($myrow = $this->_db->fetchArray($result)) {
            $obj = new $this->classname($myrow);
            if (!$id_as_key) {
                $ret[] =& $obj;
            } else {
                $ret[$obj->getVar('id')] =& $obj;
            }
            unset($obj);
        }
        return $ret;
    }

    /**
     * Get a list of created language
     *
     * @return array array containing the language name of the created translations for $clipid
     * @see SmartmediaCategory::getCreatedLanguages()
     */
    function getCreatedLanguages($categoryid)
    {
        $ret    = array();
        $sql    = sprintf('SELECT languageid FROM %s', $this->_db->prefix($this->_dbtable));
        $sql   .= " WHERE categoryid = $categoryid";

        //  echo "<br />$sql<br />";

        $result = $this->_db->query($sql);
        // If no records from db, return empty array
        if (!$result) {
            return $ret;
        }

        // Add each returned record to the result array
        while ($myrow = $this->_db->fetchArray($result)) {
            $ret[] =& $myrow['languageid'];
        }
        return $ret;
    }

    /**
     * Stores a category in the database
     *
     * @param object $obj reference to the {@link SmartmediaCategory_text} object
     * @param bool $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    function insert(&$obj, $force = false)
    {
        // Make sure object is of correct type
        if (strtolower(get_class($obj)) != $this->classname) {
            return false;
        }

        // Make sure object needs to be stored in DB
        if (!$obj->isDirty()) {
            return true;
        }

        // Make sure object fields are filled with valid values
        if (!$obj->cleanVars()) {
            return false;
        }

        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }

        // Create query for DB update
        if ($obj->isNew()) {
            $sql = sprintf("INSERT INTO %s (
			categoryid, 
			languageid, 
			title, 
			description,
			meta_description) 
			VALUES (
			%u, 
			%s, 
			%s, 
			%s,
			%s)",
            $this->_db->prefix($this->_dbtable),
            $categoryid,
            $this->_db->quoteString($languageid),
            $this->_db->quoteString($title),
            $this->_db->quoteString($description),
            $this->_db->quoteString($meta_description)
            );
        } else {
            $sql = sprintf("UPDATE %s SET
			title = %s,
		    description = %s,
		    meta_description = %s
		    WHERE categoryid = %u AND languageid = %s",
            $this->_db->prefix($this->_dbtable),
            $this->_db->quoteString($title),
            $this->_db->quoteString($description),
            $this->_db->quoteString($meta_description),
            $categoryid,
            $this->_db->quoteString($languageid)
            );
        }

        //echo "<br />$sql<br />";

        // Update DB
        if (false != $force) {
            $result = $this->_db->queryF($sql);
        } else {
            $result = $this->_db->query($sql);
        }

        if (!$result) {
            return false;
        }

        return true;
    }

    /**
     * Deletes a category translation from the database
     *
     * @param object $obj reference to the {@link SmartmediaCategoryp_text} obj to delete
     * @param bool $force
     * @return bool FALSE if failed.
     */
    function delete(&$obj, $force = true)
    {
        if (strtolower(get_class($obj)) != $this->classname) {
            return false;
        }

        $sql = sprintf("DELETE FROM %s WHERE categoryid = %u AND languageid = %s", $this->_db->prefix($this->_dbtable), $obj->getVar('categoryid'), $this->_db->quoteString($obj->getVar('languageid')));

        //echo "<br />" . $sql . "<br />";

        if (false != $force) {
            $result = $this->_db->queryF($sql);
        } else {
            $result = $this->_db->query($sql);
        }
        if (!$result) {
            return false;
        }
        return true;
    }

    /**
     * Delete categories translations matching a set of conditions
     *
     * @param object $criteria {@link CriteriaElement}
     * @return bool FALSE if deletion failed
     */
    function deleteAll($criteria = null)
    {
        $sql = 'DELETE FROM '.$this->_db->prefix($this->_dbtable);
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
        }
        if (!$result = $this->_db->query($sql)) {
            return false;
        }
        return true;
    }

}
?>