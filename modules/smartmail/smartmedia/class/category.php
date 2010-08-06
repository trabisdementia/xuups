<?php

/**
 * Contains the classes for managing categories
 *
 * @license GNU
 * @author marcan <marcan@smartfactory.ca>
 * @version $Id: category.php,v 1.3 2005/06/02 13:33:37 malanciault Exp $
 * @link http://www.smartfactory.ca The SmartFactory
 * @package SmartMedia
 * @subpackage Categories
 */

/**
 * SmartMedia Category class
 *
 * Class representing a single category object
 *
 * @package SmartMedia
 * @author marcan <marcan@smartfactory.ca>
 * @link http://www.smartfactory.ca The SmartFactory
 */
class SmartmediaCategory extends XoopsObject {

    /**
     * Language of the category
     * @var string
     */
    var $languageid;

    /**
     * {@link SmartmediaCategory_text} object holding the category's text informations
     * @var object
     * @see SmartmediaCategory_text
     */
    var $category_text = null;

    /**
     * List of all the translations already created for this category
     * @var array
     * @see getCreatedLanguages
     */
    var $_created_languages = null;

    /**
     * Flag indicating wheter or not a new translation can be added for this category
     *
     * If all languages of the site are also in {@link $_created_languages} then no new
     * translation can be created
     * @var bool
     * @see canAddLanguage
     */
    var $_canAddLanguage = null;

    /**
     * Constructor
     *
     * @param string $languageid language of the category
     * @param integer $id id of the category to be retreieved OR array containing values to be assigned
     */
    function SmartmediaCategory($languageid='default', $id = null)
    {
        $smartConfig =& smartmedia_getModuleConfig();

        $this->initVar('categoryid', XOBJ_DTYPE_INT, -1, true);
        $this->initVar('parentid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('weight', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('image', XOBJ_DTYPE_TXTBOX, null, false, 50);
        $this->initVar('default_languageid', XOBJ_DTYPE_TXTBOX, $smartConfig['default_language'], false, 50);

        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }

        if ($languageid == 'default') {
            $languageid = $this->default_languageid();
        }

        $this->loadLanguage($languageid);
    }

    /**
     * Check if the category was successfully loaded
     *
     * @return bool true if not loaded, false if correctly loaded
     */
    function notLoaded()
    {
        return ($this->categoryid()== -1);
    }

    /**
     * Loads the specified translation for this category
     *
     * If the specified language does not have any translation yet, the translation corresponding
     * to the default language will be loaded
     *
     * @param string $languageid language of the translation to load
     */
    function loadLanguage($languageid)
    {
        $this->languageid = $languageid;
        $smartmedia_category_text_handler =& smartmedia_gethandler('category_text');
        $this->category_text =& $smartmedia_category_text_handler->get($this->getVar('categoryid'), $this->languageid);

        if (!$this->category_text) {
            $this->category_text =& new SmartmediaCategory_text();
            $this->category_text->setVar('categoryid', $this->categoryid());
            $this->category_text->setVar('languageid', $languageid);
             
            $default_category_text =& $smartmedia_category_text_handler->get($this->getVar('categoryid'), $this->default_languageid());

            if ($default_category_text) {
                //$this->category_text =& $default_category_text;
                $this->category_text->setVar('title', $default_category_text->title());
                $this->category_text->setVar('description', $default_category_text->description());
                $this->category_text->setVar('meta_description', $default_category_text->meta_description());
            }
        }
    }

    /**
     * @return int id of this category
     */
    function categoryid()
    {
        return $this->getVar("categoryid");
    }

    /**
     * @return int id of parent of this category
     */
    function parentid()
    {
        return $this->getVar("parentid");
    }

    /**
     * @return string weight of this category
     */
    function weight()
    {
        return $this->getVar("weight");
    }

    /**
     * Returns the image of this category
     *
     * If no image has been set, the function will return blank.png, so a blank image can
     * be displayed
     *
     * @param string $format format to use for the output
     * @return string low resolution image of this category
     */
    function image($format="S")
    {
        if ($this->getVar('image') != '') {
            return $this->getVar('image', $format);
        } else {
            return 'blank.png';
        }
    }

    /**
     * Returns the default language of the category
     *
     * When no translation corresponding to the selected language is available, the category's
     * information will be displayed in this language
     *
     * @return string default language of the category
     */
    function default_languageid($format="S")
    {
        return $this->getVar("default_languageid", $format);
    }

    /**
     * Returns the title of the category
     *
     * If the format is "clean", the title will be return, striped from any html tag. This clean
     * title is likely to be used in the page title meta tag or any other place that requires
     * "html less" text
     *
     * @param string $format format to use for the output
     * @return string title of the category
     */
    function title($format="S")
    {
        $myts =& MyTextSanitizer::getInstance();
        if ((strtolower($format) == 's') || (strtolower($format) == 'show')) {
            return $myts->undoHtmlSpecialChars($this->category_text->getVar("title", 'e' ), 1);
        } elseif ((strtolower($format) == 'clean')) {
            return smartmedia_metagen_html2text($myts->undoHtmlSpecialChars($this->category_text->getVar("title")));
        } else {
            return $this->category_text->getVar("title", $format);
        }
    }

    /**
     * Returns the description of the category
     *
     * @param string $format format to use for the output
     * @return string description of the category
     */
    function description($format="S")
    {
        return $this->category_text->getVar("description", $format);
    }

    /**
     * Returns the meta_description of the category
     *
     * @param string $format format to use for the output
     * @return string meta_description of the category
     */
    function meta_description($format="S")
    {
        return $this->category_text->getVar("meta_description", $format);
    }

    /**
     * Set a text variable of the category
     *
     * @param string $key of the variable to set
     * @param string $value of the field to set
     * @see SmartmediaCategory_text
     */
    function setTextVar($key, $value)
    {
        return $this->category_text->setVar($key, $value);
    }

    /**
     * Get the complete URL of this category
     *
     * @return string complete URL of this category
     */
    function getItemUrl()
    {
        return SMARTMEDIA_URL . "category.php?categoryid=" . $this->categoryid();
    }

    /**
     * Get the complete hypertext link of this category
     *
     * @return string complete hypertext link of this category
     */
    function getItemLink()
    {
        return "<a href='" . $this->getItemUrl() . "'>" . $this->title() . "</a>";
    }

    /**
     * Stores the category in the database
     *
     * This method stores the category as well as the current translation informations for the
     * category
     *
     * @param bool $force
     * @return bool true if successfully stored false if an error occured
     *
     * @see SmartmediaCategoryHandler::insert()
     * @see SmartmediaCategory_text::store()
     */
    function store($force = true)
    {
        global $smartmedia_category_handler;
        if (!$smartmedia_category_handler->insert($this, $force)) {
            return false;
        }
        $this->category_text->setVar('categoryid', $this->categoryid());

        return $this->category_text->store();
    }

    /**
     * Get all the translations created for this category
     *
     * @param bool $exceptDefault to determine if the default language should be returned or not
     * @return array array of {@link SmartmediaCategory_text}
     */
    function getAllLanguages($exceptDefault = false)
    {
        global $smartmedia_category_text_handler;
        $criteria = new	CriteriaCompo();
        $criteria->add(new Criteria('categoryid', $this->categoryid()));
        if ($exceptDefault) {
            $criteria->add(new Criteria('languageid', $this->default_languageid(), '<>'));
        }
        return $smartmedia_category_text_handler->getObjects($criteria);
    }

    /**
     * Get a list of created language
     *
     * @return array array containing the language name of the created translations for this category
     * @see _created_languages
     * @see SmartmediaCategory_text::getCreatedLanguages()
     */
    function getCreatedLanguages()
    {
        if ($this->_created_languages != null) {
            return $this->_created_languages;
        }
        global $smartmedia_category_text_handler;
        $this->_created_languages =  $smartmedia_category_text_handler->getCreatedLanguages($this->categoryid());
        return $this->_created_languages;
    }

    /**
     * Check to see if other translations can be added
     *
     * If all languages of the site are also in {@link $_created_languages} then no new
     * translation can be created
     *
     * @return bool true if new translation can be added false if all translation have been created
     * @see _canAddLanguage
     * @see getCreatedLanguages
     */
    function canAddLanguage()
    {
        if ($this->_canAddLanguage != null) {
            return $this->_canAddLanguage;
        }

        include_once XOOPS_ROOT_PATH."/class/xoopslists.php";
        $languageList = XoopsLists::getLangList();
        $createdLanguages = $this->getCreatedLanguages();

        $this->_canAddLanguage = (count($languageList) > count($createdLanguages));
        return $this->_canAddLanguage;
    }

    /**
     * Render the admin links for this category
     *
     * This method will create links to Edit and Delete the category. The method will also check
     * to ensure the user is admin of the module if not, the method will return an empty string
     *
     * @return string hypertext links to edit and delete the category
     * @see $is_smartmedia_admin
     */
    function adminLinks()
    {
        global $is_smartmedia_admin;
        if ($is_smartmedia_admin) {
            $ret = '';
            $ret .= '<a href="' . SMARTMEDIA_URL . 'admin/category.php?op=mod&categoryid=' . $this->categoryid() . '"><img src="' . smartmedia_getModuleImageDir('links', false) . 'edit.gif" alt="' . _MD_SMEDIA_CATEGORY_EDIT . '" title="' . _MD_SMEDIA_CATEGORY_EDIT . '"/></a>';
            $ret .= '<a href="' . SMARTMEDIA_URL . 'admin/category.php?op=del&categoryid=' . $this->categoryid() . '"><img src="' . smartmedia_getModuleImageDir('links', false) . 'delete.gif" alt="' . _MD_SMEDIA_CATEGORY_DELETE . '" title="' . _MD_SMEDIA_CATEGORY_DELETE . '"/></a>';
            return $ret;
        } else {
            return '';
        }
    }

    /**
     * Format the category information into an array
     *
     * This method puts each usefull informations of the category into an array that will be used in
     * the module template
     *
     * @return array array containing usfull informations of the clip
     */
    function toArray() {
        $category['categoryid'] = $this->categoryid();
        $category['itemurl'] = $this->getItemUrl();
        $category['itemlink'] = $this->getItemLink();
        $category['parentid'] = $this->parentid();
        $category['weight'] = $this->weight();
        if ($this->getVar('image') != 'blank.png') {
            $category['image_path'] = smartmedia_getImageDir('category', false) . $this->image();
        } else {
            $category['image_path'] = false;
        }
        $smartConfig =& smartmedia_getModuleConfig();
        $category['main_image_width'] = $smartConfig['main_image_width'];
        $category['list_image_width'] = $smartConfig['list_image_width'];
        $category['adminLinks'] = $this->adminLinks();

        $category['title'] = $this->title();
        $category['clean_title'] = $category['title'];
        $category['description'] = $this->description();
        $category['meta_description'] = $this->meta_description();

        // Hightlighting searched words
        $highlight = true;
        if($highlight && isset($_GET['keywords']))
        {
            $myts =& MyTextSanitizer::getInstance();
            $keywords=$myts->htmlSpecialChars(trim(urldecode($_GET['keywords'])));
            $h= new keyhighlighter ($keywords, true , 'smartmedia_highlighter');
            $category['title'] = $h->highlight($category['title']);
            $category['description'] = $h->highlight($category['description']);
        }
        return $category;
    }

    /**
     * Check to see if the category has folders in it
     *
     * @return bool TRUE if the category has folders, FALSE if not
     * @see SmartmediaFolderHandler::getCountsByParent()
     */
    function hasChild() {

        $smartmedia_folder_handler = smartmedia_gethandler('folder');
        $count = $smartmedia_folder_handler->getCountsByParent($this->categoryid());
        if (isset($count[$this->categoryid()]) && ($count[$this->categoryid()] > 0)) {
            return true;
        } else {
            return false;
        }
    }

}

/**
 * Smartmedia Category Handler class
 *
 * Category Handler responsible for handling {@link SmartmediaCategory} objects
 *
 * @package SmartMedia
 * @author marcan <marcan@smartfactory.ca>
 * @link http://www.smartfactory.ca The SmartFactory
 */

class SmartmediaCategoryHandler extends XoopsObjectHandler {
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
    var $classname = 'smartmediacategory';

    /**
     * Related table name
     *
     * @var string
     */
    var $_dbtable = 'smartmedia_categories';
     
    /**
     * key field name
     *
     * @var string
     */
    var $_key_field = 'categoryid';

    /**
     * caption field name
     *
     * @var string
     */
    var $_caption_field = 'title';
     

    /**
     * Constructor
     *
     * @param object $db reference to a xoopsDB object
     */
    function SmartmediaCategoryHandler(&$db)
    {
        $this->_db = $db;
    }

    /**
     * Singleton - prevent multiple instances of this class
     *
     * @param objecs &$db {@link XoopsHandlerFactory}
     * @return object SmartmediaCategoryHandler
     */
    function &getInstance(&$db)
    {
        static $instance;
        if(!isset($instance)) {
            $instance = new SmartmediaCategoryHandler($db);
        }
        return $instance;
    }

    /**
     * Creates a new Category object
     * @return object SmartmediaCategory
     */
    function &create()
    {
        return new $this->classname();
    }

    /**
     * Retrieves a category object from the database
     *
     * If no languageid is specified, the method will load the translation related to the current
     * language selected by the user
     *
     * @param int $id id of the folder
     * @param string $languageid language of the translation to load
     * @return mixed reference to the {@link SmartmediaCategory} object, FALSE if failed
     */
    function &get($id, $languageid='current')
    {
        $id = intval($id);
        if($id > 0) {
            $sql = $this->_selectQuery(new Criteria('categoryid', $id));

            //echo "<br />$sql<br/>";

            if(!$result = $this->_db->query($sql)) {
                return false;
            }
            $numrows = $this->_db->getRowsNum($result);
            if($numrows == 1) {
                if ($languageid == 'current') {
                    global $xoopsConfig;
                    $languageid = $xoopsConfig['language'];
                }
                $obj = new $this->classname($languageid, $this->_db->fetchArray($result));
                return $obj;
            }
        }
        return false;
    }

    /**
     * Create a "SELECT" SQL query
     *
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

        //echo "<br />$sql<br/>";

        if (!$result =& $this->_db->query($sql)) {
            return 0;
        }
        list($count) = $this->_db->fetchRow($result);
        return $count;
    }

    /**
     * Count categories belonging to a specific parentid
     *
     * If no $parentid is specified, the method will count all top level categories in the module.<br />
     * Please note that nested categories are not implemented in the module. The structure is there
     * for futur use.
     *
     * @param int $parentid category in which to count categories
     * @return int count of objects
     */
    function getCategoriesCount($parentid=0)
    {

        If ($parentid == 0)  {
            return $this->getCount();
        }
        $criteria = new CriteriaCompo();
        If (isset($parentid) && ($parentid != -1)) {
            $criteria->add(new criteria('parentid', $parentid));
        }
        return $this->getCount($criteria);
    }

    /**
     * Retrieve objects from the database
     *
     * @param object $criteria {@link CriteriaElement} conditions to be met
     * @param bool $id_as_key Should the category ID be used as array key
     * @return array array of {@link SmartmediaCategory} objects
     */
    function &getObjects($criteria = null, $id_as_key = false)
    {
        global $xoopsConfig;

        $ret    = array();
        $limit  = $start = 0;
        $sql    = $this->_selectQuery($criteria);

        if (isset($criteria)) {
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }

        //echo "<br />$sql<br />";

        $result = $this->_db->query($sql, $limit, $start);
        // If no records from db, return empty array
        if (!$result) {
            return $ret;
        }

        // Add each returned record to the result array
        while ($myrow = $this->_db->fetchArray($result)) {
            $obj = new $this->classname($xoopsConfig['language'], $myrow);
            if (!$id_as_key) {
                $ret[] =& $obj;
            } else {
                $ret[$obj->getVar('categoryid')] =& $obj;
            }
            unset($obj);
        }
        return $ret;
    }

    /**
     * Get a list of {@link SmartmediaCategory} objects for the search feature
     *
     * @param array $queryarray list of keywords to look for
     * @param string $andor specify which type of search we are performing : AND or OR
     * @param int $limit maximum number of results to return
     * @param int $offset at which category shall we start
     * @param int $userid userid is not used here as category creator are not tracked
     *
     * @return array array containing information about the folders mathing the search criterias
     */
    function &getObjectsForSearch($queryarray = array(), $andor = 'AND', $limit = 0, $offset = 0, $userid = 0)
    {
        global $xoopsConfig;

        $ret    = array();
        $sql    = "SELECT *
				   FROM " . $this->_db->prefix($this->_dbtable) . " AS item
				   INNER JOIN " . $this->_db->prefix($this->_dbtable) . "_text AS itemtext 
        		   ON item." . $this->_key_field . " = itemtext." . $this->_key_field;

        If ($queryarray) {
            $criteriaKeywords = new CriteriaCompo();
            for ($i = 0; $i < count($queryarray); $i++) {
                $criteriaKeyword = new CriteriaCompo();
                $criteriaKeyword->add(new Criteria('itemtext.title', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                $criteriaKeyword->add(new Criteria('itemtext.description', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                $criteriaKeywords->add($criteriaKeyword, $andor);
            }
        }

        if ($userid != 0) {
            $criteriaUser = new CriteriaCompo();
            $criteriaUser->add(new Criteria('item.uid', $userid), 'OR');
        }

        $criteria = new CriteriaCompo();

        // Languageid
        $criteriaLanguage = new CriteriaCompo();
        $criteriaLanguage->add(new Criteria('itemtext.languageid', $xoopsConfig['language']));
        $criteria->add($criteriaLanguage);

        If (!empty($criteriaUser)) {
            $criteria->add($criteriaUser, 'AND');
        }

        If (!empty($criteriaKeywords)) {
            $criteria->add($criteriaKeywords, 'AND');
        }

        $criteria->setSort('item.weight');
        $criteria->setOrder('ASC');

        if(isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' .$criteria->renderWhere();
            if($criteria->getSort() != '') {
                $sql .= ' ORDER BY ' . $criteria->getSort() . '
                    ' .$criteria->getOrder();
            }
        }

        // echo "<br />$sql<br />";

        $result = $this->_db->query($sql, $limit, $offset);
        // If no records from db, return empty array
        if (!$result) {
            return $ret;
        }

        // Add each returned record to the result array
        while ($myrow = $this->_db->fetchArray($result)) {
            $item['id'] = $myrow[$this->_key_field];
            $item['title'] = $myrow[$this->_caption_field];
            $ret[] = $item;
            unset($item);
        }
        return $ret;
    }

    /**
     * Get a list of {@link SmartmediaCategory}
     *
     * @param int $limit maximum number of results to return
     * @param int $start at which folder shall we start
     * @param int $parentid category to which belong the categories to return
     * @param string $sort sort parameter
     * @param string $order order parameter
     * @param bool $id_as_key wether or not the categoryid should be used as array key
     *
     * @return array array of {@link SmartmediaFolder}
     */
    function &getCategories($limit=0, $start=0, $parentid=0, $sort='weight', $order='ASC', $id_as_key = true)
    {
        $criteria = new CriteriaCompo();

        $criteria->setSort($sort);
        $criteria->setOrder($order);

        If ($parentid != -1 ) {
            $criteria->add(new Criteria('parentid', $parentid));
        }

        $criteria->setStart($start);
        $criteria->setLimit($limit);
        return $this->getObjects($criteria, $id_as_key);
    }

    /**
     * Stores a category in the database
     *
     * @param object $obj reference to the {@link SmartmediaCategory} object
     * @param bool $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    function insert(&$obj, $force = false)
    {
        // Make sure object is of correct type
        if (strtolower(strtolower(get_class($obj))) != $this->classname) {
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
            // Determine next auto-gen ID for table
            $categoryid = $this->_db->genId($this->_db->prefix($this->_dbtable).'_uid_seq');
            $sql = sprintf("INSERT INTO %s (
			categoryid, 
			parentid, 
			weight, 
			image,
			default_languageid) 
			VALUES (
			%u, 
			%u, 
			%u, 
			%s,
			%s)",
            $this->_db->prefix($this->_dbtable),
            $categoryid,
            $parentid,
            $weight,
            $this->_db->quoteString($image),
            $this->_db->quoteString($default_languageid));
        } else {
            $sql = sprintf("UPDATE %s SET
		    parentid = %u, 
		    weight = %u, 
		    image = %s,
		    default_languageid = %s
		    WHERE categoryid = %u",
            $this->_db->prefix($this->_dbtable),
            $parentid,
            $weight,
            $this->_db->quoteString($image),
            $this->_db->quoteString($default_languageid),
            $categoryid);
        }

        //echo "<br />" . $sql . "<br />";
        // Update DB
        if (false != $force) {
            $result = $this->_db->queryF($sql);
        } else {
            $result = $this->_db->query($sql);
        }

        if (!$result) {
            return false;
        }

        //Make sure auto-gen ID is stored correctly in object
        if (empty($categoryid)) {
            $categoryid = $this->_db->getInsertId();
        }
        $obj->assignVar('categoryid', $categoryid);
        return true;
    }

    /**
     * Deletes a category from the database
     *
     * @param object $obj reference to the {@link SmartmediaCategory} obj to delete
     * @param bool $force
     * @return bool FALSE if failed.
     */
    function delete(&$obj, $force = false)
    {
        if (strtolower(get_class($obj)) != $this->classname) {
            return false;
        }

        // Delete all language info for this category
        $smartmedia_category_text_handler = smartmedia_gethandler('category_text');
        $criteria = new CriteriaCompo(new Criteria('categoryid', $obj->categoryid()));
        if (!$smartmedia_category_text_handler->deleteAll($criteria)) {
            return false;
        }
        $sql = sprintf("DELETE FROM %s WHERE categoryid = %u", $this->_db->prefix($this->_dbtable), $obj->getVar('categoryid'));

        //echo "<br />$sql</br />";

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
     * Deletes categories matching a set of conditions
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

    /**
     * Count the number of online folders within a category
     *
     * @param int $cat_id id of the category where to look
     * @return int count of folders
     *
     * @see foldersCount()
     */
    function onlineFoldersCount($cat_id = 0)
    {
        return $this->foldersCount($cat_id, _SMEDIA_FOLDER_STATUS_ONLINE);
    }

    /**
     * Count the number of online folders within a category
     *
     * @param int $cat_id id of the folder where to look
     * @param int $status status of the folders to count
     * @return int count of folders
     */
    function foldersCount($cat_id = 0, $status='')
    {
        $smartmedia_folder_handler = smartmedia_gethandler('folder');

        return $smartmedia_folder_handler->getCountsByParent($cat_id, $status);
    }

}
?>