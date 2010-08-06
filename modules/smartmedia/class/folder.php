<?php

/**
 * Contains the classes for managing folders
 *
 * @license GNU
 * @author marcan <marcan@smartfactory.ca>
 * @version $Id: folder.php,v 1.3 2005/06/02 13:33:37 malanciault Exp $
 * @link http://www.smartfactory.ca The SmartFactory
 * @package SmartMedia
 * @subpackage Folders
 */

/** Status of an offline folder */
define("_SMEDIA_FOLDER_STATUS_OFFLINE", 1);
/** Status of an online folder */
define("_SMEDIA_FOLDER_STATUS_ONLINE", 2);

/**
 * SmartMedia Folder class
 *
 * Class representing a single folder object
 *
 * @package SmartMedia
 * @author marcan <marcan@smartfactory.ca>
 * @link http://www.smartfactory.ca The SmartFactory
 */
class SmartmediaFolder extends XoopsObject {

    /**
     * Language of the folder
     * @var string
     */
    var $languageid;

    /**
     * {@link SmartmediaFolder_text} object holding the folder's text informations
     * @var object
     * @see SmartmediaFolder_text
     */
    var $folder_text = null;

    /**
     * List of all the translations already created for this folder
     * @var array
     * @see getCreatedLanguages
     */
    var $_created_languages = null;

    /**
     * Flag indicating wheter or not a new translation can be added for this folder
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
     * @param string $languageid language of the folder
     * @param int $id id of the folder to be retreieved OR array containing values to be assigned
     */
    function SmartmediaFolder($languageid='default', $id = null)
    {
        $smartConfig =& smartmedia_getModuleConfig();

        $this->initVar('folderid', XOBJ_DTYPE_INT, -1, true);
        $this->initVar('statusid', XOBJ_DTYPE_INT, _SMEDIA_FOLDER_STATUS_ONLINE, false);
        $this->initVar('created_uid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('created_date', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('modified_uid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('modified_date', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('weight', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('image_hr', XOBJ_DTYPE_TXTBOX, null, false, 50);
        $this->initVar('image_lr', XOBJ_DTYPE_TXTBOX, null, false, 50);
        $this->initVar('counter', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('default_languageid', XOBJ_DTYPE_TXTBOX, $smartConfig['default_language'], false, 50);

        $this->initVar('categoryid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('new_category', XOBJ_DTYPE_INT, 0, false);

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
     * Check if the folder was successfully loaded
     *
     * @return bool true if not loaded, false if correctly loaded
     */
    function notLoaded()
    {
        return ($this->folderid()== -1);
    }

    /**
     * Loads the specified translation for this folder
     *
     * If the specified language does not have any translation yet, the translation corresponding
     * to the default language will be loaded
     *
     * @param string $languageid language of the translation to load
     */
    function loadLanguage($languageid)
    {

        $this->languageid = $languageid;
         
        $smartmedia_folder_text_handler =& smartmedia_gethandler('folder_text');
        $this->folder_text =& $smartmedia_folder_text_handler->get($this->getVar('folderid'), $this->languageid);

        if (!$this->folder_text) {
            $this->folder_text =& new SmartmediaFolder_text();
            $this->folder_text->setVar('folderid', $this->folderid());
            $this->folder_text->setVar('languageid', $languageid);

            $default_folder_text =& $smartmedia_folder_text_handler->get($this->getVar('folderid'), $this->default_languageid());

            if ($default_folder_text) {
                //$this->folder_text =& $default_folder_text;
                $this->folder_text->setVar('title', $default_folder_text->title());
                $this->folder_text->setVar('short_title', $default_folder_text->short_title());
                $this->folder_text->setVar('summary', $default_folder_text->summary());
                $this->folder_text->setVar('description', $default_folder_text->description());
                $this->folder_text->setVar('meta_description', $default_folder_text->meta_description());
            }
        }
    }

    /**
     * @return int id of this folder
     */
    function folderid()
    {
        return $this->getVar("folderid");
    }

    /**
     * Returns the status of the folder
     *
     * Status can be {@link _SMEDIA_FOLDER_STATUS_OFFLINE} or {@link _SMEDIA_FOLDER_STATUS_ONLINE}
     * @return string status of the folder
     */
    function statusid()
    {
        return $this->getVar("statusid");
    }

    /**
     * Returns the date of creation of the folder
     *
     * The date will be formated according to the date format preference of the module
     * @return string date of creation of the folder
     */
    function created_date($dateFormat='none', $format="S")
    {
        If ($dateFormat == 'none') {
            $smartConfig =& smartmedia_getModuleConfig();
            if (isset($smartConfig['dateformat'])) {
                $dateFormat = $smartConfig['dateformat'];
            } else {
                $dateFormat = 'Y-m-d';
            }
        }

        return formatTimestamp($this->getVar('created_date', $format), $dateFormat);
    }

    /**
     * @return int uid of the user who created the folder
     */
    function created_uid()
    {
        return $this->getVar("created_uid");
    }

    /**
     * Returns the date of modification of the folder
     *
     * The date will be formated according to the date format preference of the module
     * @return string date of modification of the folder
     */
    function modified_date($dateFormat='none', $format="S")
    {
        If ($dateFormat == 'none') {
            $smartConfig =& smartmedia_getModuleConfig();
            if (isset($smartConfig['dateformat'])) {
                $dateFormat = $smartConfig['dateformat'];
            } else {
                $dateFormat = 'Y-m-d';
            }
        }

        return formatTimestamp($this->getVar('modified_date', $format), $dateFormat);
    }

    /**
     * @return int uid of the user who modified the folder
     */
    function modified_uid()
    {
        return $this->getVar("modified_uid");
    }

    /**
     * @return string weight of this clip
     */
    function weight()
    {
        return $this->getVar("weight");
    }

    /**
     * Returns the categoryid to which this folder belongs
     * @see SmartmediaCategory
     * @return string parent categoryid of this folder
     */
    function categoryid()
    {
        return $this->getVar("categoryid");
    }

    /**
     * Returns the high resolution image of this folder
     *
     * If no image has been set, the function will return blank.png, so a blank image can
     * be displayed
     *
     * @param string $format format to use for the output
     * @return string high resolution image of this folder
     */
    function image_hr($format="S")
    {
        if ($this->getVar('image_hr') != '') {
            return $this->getVar('image_hr', $format);
        } else {
            return 'blank.png';
        }
    }

    /**
     * Returns the low resolution image of this folder
     *
     * If no image has been set, the function will return blank.png, so a blank image can
     * be displayed
     *
     * @param string $format format to use for the output
     * @return string low resolution image of this folder
     */
    function image_lr($format="S")
    {
        if ($this->getVar('image_lr') != '') {
            return $this->getVar('image_lr', $format);
        } else {
            return 'blank.png';
        }
    }

    /**
     * @return int counter of this folder
     */
    function counter()
    {
        return $this->getVar("counter");
    }

    /**
     * Returns the default language of the folder
     *
     * When no translation corresponding to the selected language is available, the folder's
     * information will be displayed in this language
     *
     * @return string default language of the folder
     */
    function default_languageid($format="S")
    {
        return $this->getVar("default_languageid", $format);
    }

    /**
     * Returns the title of the folder
     *
     * If the format is "clean", the title will be return, striped from any html tag. This clean
     * title is likely to be used in the page title meta tag or any other place that requires
     * "html less" text
     *
     * @param string $format format to use for the output
     * @return string title of the folder
     */
    function title($format="S")
    {
        $myts =& MyTextSanitizer::getInstance();
        if ((strtolower($format) == 's') || (strtolower($format) == 'show')) {
            return $myts->undoHtmlSpecialChars($this->folder_text->getVar("title", 'e' ), 1);
        } elseif ((strtolower($format) == 'clean')) {
            return smartmedia_metagen_html2text($myts->undoHtmlSpecialChars($this->folder_text->getVar("title")));
        } else {
            return $this->folder_text->getVar("title", $format);
        }
    }

    /**
     * Returns the short title of the folder
     *
     * @param string $format format to use for the output
     * @return string short title of the folder
     */
    function short_title($format="S")
    {
        if ((strtolower($format) == 's') || (strtolower($format) == 'show')) {
            $myts =& MyTextSanitizer::getInstance();
            return $myts->undoHtmlSpecialChars($this->folder_text->getVar("short_title", 'e' ), 1);
        } else {
            return $this->folder_text->getVar("short_title", $format);
        }
    }

    /**
     * Returns the summary of the folder
     *
     * @param string $format format to use for the output
     * @return string summary of the folder
     */
    function summary($format="S")
    {
        return $this->folder_text->getVar("summary", $format);
    }

    /**
     * Returns the description of the folder
     *
     * @param string $format format to use for the output
     * @return string description of the folder
     */
    function description($format="S")
    {
        return $this->folder_text->getVar("description", $format);
    }

    /**
     * Returns the meta description of the folder
     *
     * @param string $format format to use for the output
     * @return string meta description of the folder
     */
    function meta_description($format="S")
    {
        return $this->folder_text->getVar("meta_description", $format);
    }

    /**
     * Set a text variable of the clip
     *
     * @param string $key of the variable to set
     * @param string $value of the field to set
     * @see SmartmediaFolder_text
     */
    function setTextVar($key, $value)
    {
        return $this->folder_text->setVar($key, $value);
    }

    /**
     * Get the complete URL of this folder
     *
     * @return string complete URL of this folder
     */
    function getItemUrl()
    {
        return SMARTMEDIA_URL . "folder.php?categoryid=" . $this->categoryid() . "&folderid=" . $this->folderid();
    }

    /**
     * Get the complete hypertext link of this folder
     *
     * @return string complete hypertext link of this folder
     */
    function getItemLink()
    {
        return "<a href='" . $this->getItemUrl() . "'>" . $this->title() . "</a>";
    }

    /**
     * Stores the folder in the database
     *
     * This method stores the folder as well as the current translation informations for the
     * folder
     *
     * @param bool $force
     * @return bool true if successfully stored false if an error occured
     *
     * @see SmartmediaFolderHandler::insert()
     * @see SmartmediaFolder_text::store()
     */
    function store($force = true)
    {
        global $smartmedia_folder_handler;
        if (!$smartmedia_folder_handler->insert($this, $force)) {
            return false;
        }
        $this->folder_text->setVar('folderid', $this->folderid());
        if (!$this->folder_text->store()) {
            return false;
        }
        return $this->linkToParent($this->categoryid());
    }

    /**
     * Get all the translations created for this folder
     *
     * @param bool $exceptDefault to determine if the default language should be returned or not
     * @return array array of {@link SmartmediaFolder_text}
     */
    function getAllLanguages($exceptDefault = false)
    {
        global $smartmedia_folder_text_handler;
        $criteria = new	CriteriaCompo();
        $criteria->add(new Criteria('folderid', $this->folderid()));
        if ($exceptDefault) {
            $criteria->add(new Criteria('languageid', $this->default_languageid(), '<>'));
        }
        return $smartmedia_folder_text_handler->getObjects($criteria);
    }

    /**
     * Get a list of created language
     *
     * @return array array containing the language name of the created translations for this folder
     * @see _created_languages
     * @see SmartmediaFolder_text::getCreatedLanguages()
     */
    function getCreatedLanguages()
    {
        if ($this->_created_languages != null) {
            return $this->_created_languages;
        }
        global $smartmedia_folder_text_handler;
        $this->_created_languages =  $smartmedia_folder_text_handler->getCreatedLanguages($this->folderid());
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
     * Link the folder to a category
     *
     * @param int $parentid id of the category to link to
     * @return string hypertext links to edit and delete the clip
     * @see SmartmediaFolderHandler::linkToParent()
     */
    function linkToParent($parentid)
    {
        if (intval($parentid) == 0) {
            return true;
        }

        global $smartmedia_folder_handler;
        return $smartmedia_folder_handler->linkToParent($parentid, $this->folderid(), $this->getVar('new_category'));
    }

    /**
     * Render the admin links for this folder
     *
     * This method will create links to Edit and Delete the folder. The method will also check
     * to ensure the user is admin of the module if not, the method will return an empty string
     *
     * @return string hypertext links to edit and delete the folder
     * @see $is_smartmedia_admin
     */
    function adminLinks()
    {
        global $is_smartmedia_admin;
        if ($is_smartmedia_admin) {
            $ret = '';
            $ret .= '<a href="' . SMARTMEDIA_URL . 'admin/folder.php?op=mod&folderid=' . $this->folderid() . '&categoryid=' . $this->categoryid() . '"><img src="' . smartmedia_getModuleImageDir('links', false) . 'edit.gif" alt="' . _MD_SMEDIA_FOLDER_EDIT . '" title="' . _MD_SMEDIA_FOLDER_EDIT . '"/></a>';
            $ret .= '<a href="' . SMARTMEDIA_URL . 'admin/folder.php?op=del&folderid=' . $this->folderid() . '&categoryid=' . $this->categoryid() . '"><img src="' . smartmedia_getModuleImageDir('links', false) . 'delete.gif" alt="' . _MD_SMEDIA_FOLDER_DELETE . '" title="' . _MD_SMEDIA_FOLDER_DELETE . '"/></a>';
            return $ret;
        } else {
            return '';
        }
    }

    /**
     * Format the folder information into an array
     *
     * This method puts each usefull informations of the folder into an array that will be used
     * in the modules template
     *
     * @return array array containing usfull informations of the folder
     */
    function toArray() {
        $folder['folderid'] = $this->folderid();
        $folder['categoryid'] = $this->categoryid();
        $folder['itemurl'] = $this->getItemUrl();
        $folder['itemlink'] = $this->getItemLink();
        $folder['weight'] = $this->weight();

        if ($this->getVar('image_hr') != 'blank.png') {
            $folder['image_hr_path'] = smartmedia_getImageDir('folder', false) . $this->image_hr();
        } else {
            $folder['image_hr_path'] = false;
        }

        $smartConfig =& smartmedia_getModuleConfig();
        $folder['main_image_width'] = $smartConfig['main_image_width'];
        $folder['list_image_width'] = $smartConfig['list_image_width'];
        $folder['image_lr_path'] = smartmedia_getImageDir('folder', false) . $this->image_lr();
        $folder['counter'] = $this->counter();
        $folder['adminLinks'] = $this->adminLinks();

        $folder['title'] = $this->title();
        $folder['clean_title'] = $folder['title'];
        $folder['short_title'] = $this->title();
        $folder['summary'] = $this->summary();
        $folder['description'] = $this->description();
        $folder['meta_description'] = $this->meta_description();

        // Hightlighting searched words
        $highlight = true;
        if($highlight && isset($_GET['keywords']))
        {
            $myts =& MyTextSanitizer::getInstance();
            $keywords=$myts->htmlSpecialChars(trim(urldecode($_GET['keywords'])));
            $h= new keyhighlighter ($keywords, true , 'smartmedia_highlighter');
            $folder['title'] = $h->highlight($folder['title']);
            $folder['summary'] = $h->highlight($folder['summary']);
            $folder['description'] = $h->highlight($folder['description']);
        }

        return $folder;
    }

    /**
     * Check to see if the folder has clips in it
     *
     * @return bool TRUE if the folder has clips, FALSE if not
     * @see SmartmediaFolderHandler::clipsCount()
     */
    function hasChild() {
        $smartmedia_folder_handler = smartmedia_gethandler('folder');
        $count = $smartmedia_folder_handler->clipsCount($this->folderid());
        if (isset($count[$this->folderid()]) && ($count[$this->folderid()] > 0)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Update the counter of the folder by one
     */
    function updateCounter()
    {
        $this->setVar('counter', $this->counter() + 1);
        $this->store();
    }
}

/**
 * Smartmedia Folder Handler class
 *
 * Folder Handler responsible for handling {@link SmartmediaFolder} objects
 *
 * @package SmartMedia
 * @author marcan <marcan@smartfactory.ca>
 * @link http://www.smartfactory.ca The SmartFactory
 */

class SmartmediaFolderHandler extends XoopsObjectHandler {
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
    var $classname = 'smartmediafolder';

    /**
     * Related table name
     *
     * @var string
     */
    var $_dbtable = 'smartmedia_folders';
     
    /**
     * Related parent table name
     *
     * @var string
     */
    var $_dbtable_parent = 'smartmedia_folders_categories';
     
    /**
     * Related child table name
     *
     * @var string
     */
    var $_dbtable_child = 'smartmedia_clips';
     
    /**
     * Parent field name
     *
     * @var string
     */
    var $_parent_field = 'categoryid';
     
    /**
     * Key field name
     *
     * @var string
     */
    var $_key_field = 'folderid';
     
    /**
     * Caption field name
     *
     * @var string
     */
    var $_caption_field = 'title';

    /**
     * Constructor
     *
     * @param object $db reference to a xoopsDB object
     */
    function SmartmediaFolderHandler(&$db)
    {
        $this->_db = $db;
    }

    /**
     * Singleton - prevent multiple instances of this class
     *
     * @param objecs &$db {@link XoopsHandlerFactory}
     * @return object SmartmediaFolderHandler
     */
    function &getInstance(&$db)
    {
        static $instance;
        if(!isset($instance)) {
            $instance = new SmartmediaFolderHandler($db);
        }
        return $instance;
    }

    /**
     * Creates a new folder object
     * @return object SmartmediaFolder
     */
    function &create()
    {
        return new $this->classname();
    }

    /**
     * Retrieve a folder object from the database
     *
     * If no languageid is specified, the method will load the translation related to the current
     * language selected by the user
     *
     * @param int $id id of the folder
     * @param string $languageid language of the translation to load
     * @return mixed reference to the {@link SmartmediaFolder} object, FALSE if failed
     */
    function &get($id, $languageid='current')
    {
        $id = intval($id);
        if($id > 0) {
            $sql = $this->_selectQuery(new Criteria('folderid', $id));

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

                // Check to see if the categoryid is in the url
                If (isset($_GET['categoryid'])) {
                    $obj->setVar('categoryid', intval($_GET['categoryid']))	;
                }

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
     * Creates a "SELECT" SQL query with INNER JOIN statement
     *
     * This methods builds a SELECT query joining the folders table to the folders_categories table.
     *
     * @param int $parentid id of the parent on which to join
     * @param object $criteria {@link CriteriaElement} to match
     * @return	string SQL query
     */
    function _selectJoinQuery($parentid, $criteria = null)
    {
        $sql = sprintf('SELECT * FROM %s AS parent INNER JOIN %s AS child ON parent.%s=child.%s', $this->_db->prefix($this->_dbtable_parent), $this->_db->prefix($this->_dbtable), $this->_key_field, $this->_key_field);
        if(isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            if ($parentid != 0) {
                $criteria->add(new Criteria($this->_parent_field, $parentid));
            }
             
            $sql .= ' ' .$criteria->renderWhere();
            if($criteria->getSort() != '') {
                $sql .= ' ORDER BY ' . $criteria->getSort() . '
                    ' .$criteria->getOrder();
            }
        } elseif ($categoryid != 0) {
            $criteria = new CriteriaCompo();
            $criteria->add(new Criteria($this->_parent_field, $parentid));
            $sql .= ' ' .$criteria->renderWhere();
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
     * Count folders belonging to a specific category
     *
     * If no categoryid is specified, the method will count all folders in the module
     *
     * @param int $categoryid category in which to count folders
     * @return int count of objects
     */
    function getfoldersCount($categoryid=0)
    {
        $criteria = new CriteriaCompo();
        If (isset($categoryid) && ($categoryid != 0)) {
            $criteria->add(new criteria('categoryid', $categoryid));
            return $this->getCount($criteria);
        } else {
            return $this->getCount();
        }
    }

    /**
     * Count the categories to which belongs a specific folder
     *
     * @param int $folderid id of the folder
     * @return int count of objects
     */
    function getParentCount($folderid)
    {
        $criteria = new CriteriaCompo();
        $criteria->add(new criteria('folderid', $folderid));
         
        $sql = 'SELECT COUNT(*) FROM '.$this->_db->prefix($this->_dbtable_parent);
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
        }

        if (!$result =& $this->_db->query($sql)) {
            return -1;
        }
        list($count) = $this->_db->fetchRow($result);

        return $count;
    }

    /**
     * Retrieve objects from the database
     *
     * @param int $categoryid id of a category
     * @param object $criteria {@link CriteriaElement} conditions to be met
     * @param bool $category_id_as_key Should the folder ID be used as array key
     * @return array array of {@link SmartmediaFolder} objects
     */
    function &getObjects($categoryid, $criteria = null, $category_id_as_key = false)
    {
        global $xoopsConfig;
         
        $smartConfig =& smartmedia_getModuleConfig();
         
        $ret    = array();
        $limit  = $start = 0;
        $sql    = $this->_selectJoinQuery($categoryid, $criteria);

        if (isset($criteria)) {
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }

        // echo "<br />$sql<br />";

        $result = $this->_db->query($sql, $limit, $start);
        // If no records from db, return empty array
        if (!$result) {
            return $ret;
        }

        // Add each returned record to the result array
        while ($myrow = $this->_db->fetchArray($result)) {
            $obj = new $this->classname($xoopsConfig['language'], $myrow);
            if (!$category_id_as_key) {
                $ret[$obj->getVar('folderid')] =& $obj;
            } else {
                $ret[$myrow['categoryid']][$obj->getVar('folderid')] =& $obj;
            }
            unset($obj);
        }
        return $ret;
    }

    /**
     * Get a list of {@link SmartmediaFolder} objects for the search feature
     *
     * @param array $queryarray list of keywords to look for
     * @param string $andor specify which type of search we are performing : AND or OR
     * @param int $limit maximum number of results to return
     * @param int $offset at which folder shall we start
     * @param int $userid userid related to the creator of the folder
     *
     * @return array array containing information about the folders mathing the search criterias
     */
    function &getObjectsForSearch($queryarray = array(), $andor = 'AND', $limit = 0, $offset = 0, $userid = 0)
    {
        global $xoopsConfig;

        $ret    = array();
        $sql    = "SELECT item." . $this->_key_field . ", itemtext." . $this->_caption_field . ", itemtext.description, parent.categoryid FROM
                   (
        			 (" . $this->_db->prefix($this->_dbtable) . " AS item
					   INNER JOIN " . $this->_db->prefix($this->_dbtable) . "_text AS itemtext 
        		       ON item." . $this->_key_field . " = itemtext." . $this->_key_field . "
        		     )
        		     INNER JOIN " . $this->_db->prefix($this->_dbtable_parent) . " AS parent
         		     ON parent." . $this->_key_field . " = item." . $this->_key_field .	"
                   )";

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

        $sql .= ' ' .$criteria->renderWhere();

        //$sql .= "GROUP BY parent." . $this->_key_field . "";

        if($criteria->getSort() != '') {
            $sql .= ' ORDER BY ' . $criteria->getSort() . '
                ' .$criteria->getOrder();
        }

        //echo "<br />$sql<br />";

        $result = $this->_db->query($sql, $limit, $offset);
        // If no records from db, return empty array
        if (!$result) {
            return $ret;
        }

        // Add each returned record to the result array
        while ($myrow = $this->_db->fetchArray($result)) {
            $item['id'] = $myrow[$this->_key_field];
            $item['title'] = $myrow[$this->_caption_field];
            $item['categoryid'] = $myrow[$this->_parent_field];

            $ret[] = $item;
            unset($item);
        }
        return $ret;
    }
     
    /**
     * Get a list of {@link SmartmediaFolder}
     *
     * @param int $limit maximum number of results to return
     * @param int $start at which folder shall we start
     * @param int $categoryid category to which belong the parent category of the clip
     * @param string $sort sort parameter
     * @param string $order order parameter
     * @param bool $category_id_as_key wether or not the categoryid should be used as array key
     *
     * @return array array of {@link SmartmediaFolder}
     */
    function &getfolders($limit=0, $start=0, $categoryid, $status='', $sort='weight', $order='ASC', $category_id_as_key = true)
    {
        $criteria = new CriteriaCompo();

        $criteria->setSort($sort);
        $criteria->setOrder($order);

        $criteria->setStart($start);
        $criteria->setLimit($limit);

        if ($status) {
            $criteria->add(new Criteria('statusid', $status));
        }
        return $this->getObjects($categoryid, $criteria, $category_id_as_key);
    }

    /**
     * Get count of folders by category
     *
     * @param int $parent_id category in which to count the folders
     *
     * @return int count of folders
     */
    function getCountsByParent($parent_id = 0, $status='none') {
        $ret = array();
        $sql = 'SELECT parent.' . $this->_parent_field . ' AS parentid, COUNT( item.' . $this->_key_field . ' ) AS count
				FROM '.$this->_db->prefix($this->_dbtable) .' AS item
				INNER JOIN '.$this->_db->prefix($this->_dbtable_parent) .' AS parent ON item.' . $this->_key_field . ' = parent.' . $this->_key_field;

        if (intval($parent_id) > 0) {
            $sql .= ' WHERE ' . $this->_parent_field . ' = '.intval($parent_id);
            if ($status != 'none') {
                $sql .= ' AND statusid = ' . $status;
            }
        } else {
            if ($status != 'none') {
                $sql .= ' WHERE statusid = ' . $status;
            }
        }
        $sql .= ' GROUP BY parent.' . $this->_parent_field;

        //echo "<br />$sql<br />";

        $result = $this->_db->query($sql);
        if (!$result) {
            return $ret;
        }
        while ($row = $this->_db->fetchArray($result)) {
            $ret[$row['parentid']] = intval($row['count']);
        }
        return $ret;
    }

    /**
     * Stores a folder in the database
     *
     * @param object $obj reference to the {@link SmartmediaFolder} object
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
            // Determine next auto-gen ID for table
            $folderid = $this->_db->genId($this->_db->prefix($this->_dbtable).'_uid_seq');
            $sql = sprintf("INSERT INTO %s (
			folderid, 
			statusid,
			created_uid,
			created_date,
			modified_uid,
			modified_date,
			weight, 
			image_lr,
			image_hr,
			counter,
			default_languageid) 
			VALUES (
			%u,
			%u,
			%u,
			%u,
			%u,
			%u,
			%u,
			%u,
			%s,
			%s,
			%s)",
            $this->_db->prefix($this->_dbtable),
            $folderid,
            $statusid,
            $created_uid,
            $created_date,
            $modified_uid,
            $modified_date,
            $weight,
            $this->_db->quoteString($image_lr),
            $this->_db->quoteString($image_hr),
            $counter,
            $this->_db->quoteString($default_languageid));
        } else {
            $sql = sprintf("UPDATE %s SET
		    statusid = %u,
		    created_uid = %u, 
		    created_date = %u,
		    modified_uid = %u,
		    modified_date = %u,
		    weight = %u, 
		    image_lr = %s,
		    image_hr = %s,	
		    counter = %u,	    
		    default_languageid = %s
		    WHERE folderid = %u",
            $this->_db->prefix($this->_dbtable),
            $statusid,
            $created_uid,
            $created_date,
            $modified_uid,
            $modified_date,
            $weight,
            $this->_db->quoteString($image_lr),
            $this->_db->quoteString($image_hr),
            $counter,
            $this->_db->quoteString($default_languageid),
            $folderid);
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
        if (empty($folderid)) {
            $folderid = $this->_db->getInsertId();
        }
        $obj->assignVar('folderid', $folderid);
        return true;
    }

    /**
     * Link a folder to a category
     *
     * If $new is TRUE, a new link will be created, if not, the existing link will be updated
     *
     * @param int $parentid id of the category to link to
     * @param int $keyid id of the folder to link
     * @param bool $new if it's a new link or not
     * @return true
     * @todo Make the method returns true if success, false if not. In order to this, the
     * receiving end of this method needs to be modified
     *
     * @see SmartmediaFolder::linkToParent()
     */
    function linkToParent($parentid, $keyid, $new=true)
    {
        if ($new) {
            $sql = "INSERT INTO " . $this->_db->prefix($this->_dbtable_parent) . " ( " . $this->_parent_field . ", " . $this->_key_field . " ) VALUES ( '$parentid', '$keyid' )";
        } else {
            $sql = "UPDATE " . $this->_db->prefix($this->_dbtable_parent) . " SET " . $this->_parent_field . "= '$parentid' WHERE " . $this->_key_field . "= '$keyid'";
        }

        //return $this->_db->queryF($sql);
        $this->_db->queryF($sql);

        return true;
    }

    /**
     * Deletes a folder from the database
     *
     * @param object $obj reference to the {@link SmartmediaFolder} obj to delete
     * @param bool $force
     * @return bool FALSE if failed.
     */
    function delete(&$obj, $force = false)
    {
        if (strtolower(get_class($obj)) != $this->classname) {
            return false;
        }

        $smartmedia_folder_text_handler = smartmedia_gethandler('folder_text');
        $criteria = new CriteriaCompo(new Criteria('folderid', $obj->folderid()));
        if (!$smartmedia_folder_text_handler->deleteAll($criteria)) {
            return false;
        }
        $sql = sprintf("DELETE FROM %s WHERE folderid = %u", $this->_db->prefix($this->_dbtable), $obj->getVar('folderid'));

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
     * Deletes a link between a folder and a category
     *
     * The method will also check, after deleting the link, if other links to this folder still
     * exists. If not, the folder itself will also be deleted
     *
     * @param object $obj reference to the {@link SmartmediaFolder} obj to delete
     * @param int $parentid id of the category which link to delete
     * @param bool $force
     *
     * @return bool FALSE if failed.
     */
    function deleteParentLink(&$obj, $parentid, $force = false)
    {
        if (strtolower(get_class($obj)) != $this->classname) {
            return false;
        }

        // Delete parent link
        $sql = sprintf("DELETE FROM %s WHERE folderid = %u and categoryid = %u", $this->_db->prefix($this->_dbtable_parent), $obj->getVar('folderid'), $parentid);

        if (false != $force) {
            $result = $this->_db->queryF($sql);
        } else {
            $result = $this->_db->query($sql);
        }
        if (!$result) {
            return false;
        }

        // Check if there is still a link to another parent, if not, also delete the folder itself
        $links_left = $this->getParentCount($obj->folderid());
        If (!isset($links_left) || ($links_left == -1)) {
            // an error occured
            return false;
        } elseif ($links_left == 0) {
            return $this->delete($obj);
        } else {
            return true;
        }
    }

    /**
     * Deletes folders matching a set of conditions
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
     * Count the number of online clips within a folder
     *
     * @param int $cat_id id of the folder where to look
     * @return int count of clips
     *
     * @see clipsCount()
     */
    function onlineClipsCount($cat_id = 0)
    {
        return $this->clipsCount($cat_id);
    }

    /**
     * Count the number of online clips within a folder
     *
     * @param int $cat_id id of the folder where to look
     * @return int count of clips
     */
    function clipsCount($cat_id = 0, $status='')
    {
        $smartmedia_clip_handler = smartmedia_gethandler('clip');

        return $smartmedia_clip_handler->getCountsByParent($cat_id, $status);
    }

}
?>