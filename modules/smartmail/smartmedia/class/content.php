<?php

/**
 * SmartMedia Content class
 *
 * @author marcan <marcan@smartfactory.ca>
 * @access public
 * @package SmartMedia
 */

class SmartmediaContent extends XoopsObject {

    var $languageid;

    var $content_text = null;

    var $_created_languages = null;

    var $_canAddLanguage = null;

    function SmartmediaContent($languageid='default', $id = null)
    {
        $smartConfig =& smartmedia_getModuleConfig();

        $this->initVar('id', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('language_id', XOBJ_DTYPE_TXTBOX, null, true, 50);
        $this->initVar('module_id', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('item_id', XOBJ_DTYPE_INT, 0, true);
        $this->initVar('item_type', XOBJ_DTYPE_TXTBOX, '', true, 255);
        $this->initVar('value', XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar('created_date', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('created_uid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('modified_date', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('modified_uid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('version', XOBJ_DTYPE_INT, 0, false);

        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }
    }

    function notLoaded()
    {
        return ($this->contentid()== -1);
    }

    function contentid()
    {
        return $this->getVar("contentid");
    }

    function parentid()
    {
        return $this->getVar("parentid");
    }

    function weight()
    {
        return $this->getVar("weight");
    }

    function image($format="S")
    {
        if ($this->getVar('image') != '') {
            return $this->getVar('image', $format);
        } else {
            return 'blank.png';
        }
    }

    function default_languageid($format="S")
    {
        return $this->getVar("default_languageid", $format);
    }

    // Functions to retreive text info

    function title($format="S")
    {
        $myts =& MyTextSanitizer::getInstance();
        if ((strtolower($format) == 's') || (strtolower($format) == 'show')) {
            return $myts->undoHtmlSpecialChars($this->content_text->getVar("title", 'e' ), 1);
        } elseif ((strtolower($format) == 'clean')) {
            return smartmedia_metagen_html2text($myts->undoHtmlSpecialChars($this->content_text->getVar("title")));
        } else {
            return $this->content_text->getVar("title", $format);
        }
    }

    function description($format="S")
    {
        return $this->content_text->getVar("description", $format);
    }

    function meta_description($format="S")
    {
        return $this->content_text->getVar("meta_description", $format);
    }

    // Functions to save text info
    function setTextVar($key, $value)
    {
        return $this->content_text->setVar($key, $value);
    }

    function getItemUrl()
    {
        return SMARTMEDIA_URL . "content.php?contentid=" . $this->contentid();
    }

    function getItemLink()
    {
        return "<a href='" . $this->getItemUrl() . "'>" . $this->title() . "</a>";
    }

    function store($force = true)
    {
        global $smartmedia_content_handler;
        if (!$smartmedia_content_handler->insert($this, $force)) {
            return false;
        }
        $this->content_text->setVar('contentid', $this->contentid());

        return $this->content_text->store();
    }

    function getAllLanguages($exceptDefault = false)
    {
        global $smartmedia_content_text_handler;
        $criteria = new	CriteriaCompo();
        $criteria->add(new Criteria('contentid', $this->contentid()));
        if ($exceptDefault) {
            $criteria->add(new Criteria('languageid', $this->default_languageid(), '<>'));
        }
        return $smartmedia_content_text_handler->getObjects($criteria);
    }

    function getCreatedLanguages()
    {
        if ($this->_created_languages != null) {
            return $this->_created_languages;
        }
        global $smartmedia_content_text_handler;
        $this->_created_languages =  $smartmedia_content_text_handler->getCreatedLanguages($this->contentid());
        return $this->_created_languages;
    }

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

    function adminLinks()
    {
        global $is_smartmedia_admin;
        if ($is_smartmedia_admin) {
            $ret = '';
            $ret .= '<a href="' . SMARTMEDIA_URL . 'admin/content.php?op=mod&contentid=' . $this->contentid() . '"><img src="' . smartmedia_getModuleImageDir('links', false) . 'edit.gif" alt="' . _MD_SMEDIA_CATEGORY_EDIT . '" title="' . _MD_SMEDIA_CATEGORY_EDIT . '"/></a>';
            $ret .= '<a href="' . SMARTMEDIA_URL . 'admin/content.php?op=del&contentid=' . $this->contentid() . '"><img src="' . smartmedia_getModuleImageDir('links', false) . 'delete.gif" alt="' . _MD_SMEDIA_CATEGORY_DELETE . '" title="' . _MD_SMEDIA_CATEGORY_DELETE . '"/></a>';
            return $ret;
        } else {
            return '';
        }
    }

    function toArray($content = array()) {
        $content['contentid'] = $this->contentid();
        $content['itemurl'] = $this->getItemUrl();
        $content['itemlink'] = $this->getItemLink();
        $content['parentid'] = $this->parentid();
        $content['weight'] = $this->weight();
        if ($this->getVar('image') != 'blank.png') {
            $content['image_path'] = smartmedia_getImageDir('content', false) . $this->image();
        } else {
            $content['image_path'] = false;
        }
        $smartConfig =& smartmedia_getModuleConfig();
        $content['main_image_width'] = $smartConfig['main_image_width'];
        $content['list_image_width'] = $smartConfig['list_image_width'];
        $content['adminLinks'] = $this->adminLinks();

        $content['title'] = $this->title();
        $content['clean_title'] = $content['title'];
        $content['description'] = $this->description();
        $content['meta_description'] = $this->meta_description();

        // Hightlighting searched words
        $highlight = true;
        if($highlight && isset($_GET['keywords']))
        {
            $myts =& MyTextSanitizer::getInstance();
            $keywords=$myts->htmlSpecialChars(trim(urldecode($_GET['keywords'])));
            $h= new keyhighlighter ($keywords, true , 'smartmedia_highlighter');
            $content['title'] = $h->highlight($content['title']);
            $content['description'] = $h->highlight($content['description']);
        }
        return $content;
    }






    function hasChild() {

        $smartmedia_folder_handler = smartmedia_gethandler('folder');
        $count = $smartmedia_folder_handler->getCountsByParent($this->contentid());
        if (isset($count[$this->contentid()]) && ($count[$this->contentid()] > 0)) {
            return true;
        } else {
            return false;
        }
    }

}

/**
 * SmartmediaContentHandler class
 *
 * Content Handler for SmartmediaContent class
 *
 * @author marcan <marcan@smartfactory.ca> &
 * @access public
 * @package SmartMedia
 */

class SmartmediaContentHandler extends XoopsObjectHandler {
    /**
     * Database connection
     *
     * @var	object
     * @access	private
     */
    var $_db;

    /**
     * Name of child class
     *
     * @var	string
     * @access	private
     */
    var $classname = 'smartmediacontent';

    /**
     * DB table name
     *
     * @var string
     * @access private
     */
    var $_dbtable = 'smartmedia_categories';
     
    /**
     * key field name
     *
     * @var string
     * @access private
     */
    var $_key_field = 'contentid';

    /**
     * caption field name
     *
     * @var string
     * @access private
     */
    var $_caption_field = 'title';
     
    /**
     * Module id
     *
     * @var	int
     * @access	private
     */
    var $_module_id;
     

    /**
     * Constructor
     *
     * @param	object   $db    reference to a xoopsDB object
     */
    function SmartmediaContentHandler(&$db)
    {
        $this->_db = $db;
    }

    /**
     * Singleton - prevent multiple instances of this class
     *
     * @param objecs &$db {@link XoopsHandlerFactory}
     * @return object {@link SmartmediaContentHandler}
     * @access public
     */
    function &getInstance(&$db)
    {
        static $instance;
        if(!isset($instance)) {
            $instance = new SmartmediaContentHandler($db);
        }
        return $instance;
    }

    /**
     * create a new content object
     * @return object {@link SmartmediaContent}
     * @access public
     */
    function &create()
    {
        return new $this->classname();
    }

    /**
     * retrieve a content object from the database
     * @param int $id ID of content
     * @return object {@link SmartmediaContent}
     * @access public
     */
    function &get($id, $languageid='current')
    {
        $id = intval($id);
        if($id > 0) {
            $sql = $this->_selectQuery(new Criteria('contentid', $id));

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
     * Create a "select" SQL query
     * @param object $criteria {@link CriteriaElement} to match
     * @return	string SQL query
     * @access	private
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
     * count objects matching a criteria
     *
     * @param object $criteria {@link CriteriaElement} to match
     * @return int count of objects
     * @access	public
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
     * retrieve objects from the database
     *
     * @param object $criteria {@link CriteriaElement} conditions to be met
     * @param bool $id_as_key Should the content ID be used as array key
     * @return array array of {@link SmartmediaContent} objects
     * @access	public
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
                $ret[$obj->getVar('contentid')] =& $obj;
            }
            unset($obj);
        }
        return $ret;
    }

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
     * store a content in the database
     *
     * @param object $content reference to the {@link SmartmediaContent} object
     * @param bool $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     * @access	public
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
            $contentid = $this->_db->genId($this->_db->prefix($this->_dbtable).'_uid_seq');
            $sql = sprintf("INSERT INTO %s (
			contentid, 
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
            $contentid,
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
		    WHERE contentid = %u",
            $this->_db->prefix($this->_dbtable),
            $parentid,
            $weight,
            $this->_db->quoteString($image),
            $this->_db->quoteString($default_languageid),
            $contentid);
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
        if (empty($contentid)) {
            $contentid = $this->_db->getInsertId();
        }
        $obj->assignVar('contentid', $contentid);
        return true;
    }

    /**
     * delete a Content from the database
     *
     * @param object $obj reference to the {@link SmartmediaContent} obj to delete
     * @param bool $force
     * @return bool FALSE if failed.
     * @access public
     */
    function delete(&$obj, $force = false)
    {
        if (strtolower(get_class($obj)) != $this->classname) {
            return false;
        }

        // Delete all language info for this content
        $smartmedia_content_text_handler = smartmedia_gethandler('content_text');
        $criteria = new CriteriaCompo(new Criteria('contentid', $obj->contentid()));
        if (!$smartmedia_content_text_handler->deleteAll($criteria)) {
            return false;
        }
        $sql = sprintf("DELETE FROM %s WHERE contentid = %u", $this->_db->prefix($this->_dbtable), $obj->getVar('contentid'));

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
     * delete department matching a set of conditions
     *
     * @param object $criteria {@link CriteriaElement}
     * @return bool FALSE if deletion failed
     * @access	public
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

    function onlineFoldersCount($cat_id = 0)
    {
        return $this->foldersCount($cat_id, _SMEDIA_FOLDER_STATUS_ONLINE);
    }

    function foldersCount($cat_id = 0, $status='')
    {
        $smartmedia_folder_handler = smartmedia_gethandler('folder');

        return $smartmedia_folder_handler->getCountsByParent($cat_id, $status);
    }

}
?>