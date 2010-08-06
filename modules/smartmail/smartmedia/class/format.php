<?php

/**
 * Contains the classes for managing clips formats
 *
 * @license GNU
 * @author marcan <marcan@smartfactory.ca>
 * @version $Id: format.php,v 1.3 2005/06/02 13:33:37 malanciault Exp $
 * @link http://www.smartfactory.ca The SmartFactory
 * @package SmartMedia
 * @subpackage Clips
 */

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

/**
 * SmartMedia Format class
 *
 * Class representing a a clip's format object
 *
 * @package SmartMedia
 * @author marcan <marcan@smartfactory.ca>
 * @link http://www.smartfactory.ca The SmartFactory
 */
class SmartmediaFormat extends XoopsObject
{
    /**
     * Constructor
     *
     * @param int $id id of the clip to be retreieved OR array containing values to be assigned
     */
    function SmartmediaFormat($id = null)
    {
        $this->_db =& Database::getInstance();
        $this->initVar("formatid", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("template", XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar("format", XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar("ext", XOBJ_DTYPE_TXTBOX, null, false);

        if (isset($id)) {
            $objHandler =& new SmartmediaFormatHandler($this->_db);
            $obj =& $objHandler->get($id);
            foreach ($obj->vars as $k => $v) {
                $this->assignVar($k, $v['value']);
            }
        }
    }

    /**
     * @return int id of this format
     */
    function formatid()
    {
        return $this->getVar("formatid");
    }

    /**
     * @return string template of the format
     */
    function template()
    {
        $ret = $this->getVar("template", 'none');
        return $ret;
    }

    /**
     * @return string name of the format
     */
    function format()
    {
        return $this->getVar("format");
    }

    /**
     * @return string extension reprsenting this format
     */
    function ext()
    {
        return $this->getVar("ext");
    }

    /**
     * Stores the format of the clip in the database
     *
     * @param bool $force
     * @return bool true if successfully stored false if an error occured
     *
     * @see SmartmediaFormatHandler::insert()
     */
    function store($force = true)
    {
        $format_handler =& new SmartmediaFormatHandler($this->_db);
        return $format_handler->insert($this, $force);
    }

    /**
     * Get redirection messages
     *
     * This method returns the redirection messages upon success of delete of addition,
     * edition or deletion of a format
     *
     * @param string $action action related to the messages : new, edit or delete
     * @return array containing the messages
     */
    function getRedirectMsg($action)
    {
        $ret = array();
        if ($action == 'new') {
            $ret['error'] = _AM_SMEDIA_FORMAT_CREATE_ERROR;
            $ret['success'] = _AM_SMEDIA_FORMAT_CREATE_SUCCESS;
        } elseif ($action == 'edit') {
            $ret['error'] = _AM_SMEDIA_FORMAT_EDIT_ERROR;
            $ret['success'] = _AM_SMEDIA_FORMAT_EDIT_SUCCESS;
        } elseif ($action == 'delete') {
            $ret['error'] = _AM_SMEDIA_FORMAT_DELETE_ERROR;
            $ret['success'] = _AM_SMEDIA_FORMAT_DELETE_SUCCESS;
        }

        return $ret;
    }

    /**
     * Renders the template
     *
     * This methods renders the template ans replace different tags by the real values of the clip
     *
     * @param object $clipObj {@link SmartmediaClip} object
     * @return string containing the template
     */
    function render($clipObj)
    {
        $temp = $this->template();

        $temp = str_replace('{CLIP_URL}', $clipObj->file_lr(), $temp);
        $temp = str_replace('{CLIP_WIDTH}', $clipObj->width(), $temp);
        $temp = str_replace('{CLIP_HEIGHT}', $clipObj->height(), $temp);
        $temp = str_replace('{CLIP_URL}', $clipObj->autostart(), $temp);

        return $temp;
    }

}

/**
 * Format handler class.
 * This class is responsible for providing data access mechanisms to the data source
 * of Format class objects.
 *
 * @author marcan <marcan@smartfactory.ca>
 * @package SmartMedia
 */

class SmartmediaFormatHandler extends XoopsObjectHandler
{

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
    var $classname = 'smartmediaformat';

    /**
     * _db table name
     *
     * @var string
     * @access private
     */
    var $_dbtable = 'smartmedia_formats';
     
    /**
     * key field name
     *
     * @var string
     * @access private
     */
    var $_key_field = 'formatid';

    /**
     * caption field name
     *
     * @var string
     * @access private
     */
    var $_caption_field = 'format';
     

    /**
     * Constructor
     *
     * @param	object   $_db    reference to a xoops_db object
     */
    function SmartmediaFormatHandler(&$_db)
    {
        $this->_db = $_db;
    }

    /**
     * Singleton - prevent multiple instances of this class
     *
     * @param objecs &$_db {@link XoopsHandlerFactory}
     * @return object {@link SmartmediaFormatHandler}
     * @access public
     */
    function &getInstance(&$_db)
    {
        static $instance;
        if(!isset($instance)) {
            $instance = new SmartmediaFormatHandler($_db);
        }
        return $instance;
    }

    function &create($isNew = true)
    {
        $obj = new $this->classname;
        if ($isNew) {
            $obj->setNew();
        }
        return $obj;
    }

    /**
     * retrieve a Format
     *
     * @param int $id format id
     * @return mixed reference to the {@link SmartmediaFormat} object, FALSE if failed
     */
    function &get($id)
    {
        if (intval($id) > 0) {
            $sql = 'SELECT * FROM '.$this->_db->prefix($this->_dbtable).' WHERE ' . $this->_key_field . '='.$id;
            if (!$result = $this->_db->query($sql)) {
                return false;
            }
             
            $numrows = $this->_db->getRowsNum($result);
            if ($numrows == 1) {
                $obj = new $this->classname;
                $obj->assignVars($this->_db->fetchArray($result));
                return $obj;
            }
        }
        return false;
    }

    /**
     * insert a new format in the database
     *
     * @param object $obj reference to the {@link SmartmediaFormat} object
     * @param bool $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    function insert(&$obj, $force = false)
    {
        if (get_class($obj) != $this->classname) {
            return false;
        }

        if (!$obj->isDirty()) {
            return true;
        }

        if (!$obj->cleanVars()) {
            return false;
        }

        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }

        if ($obj->isNew()) {
            $sql = sprintf("INSERT INTO %s (" . $this->_key_field . ", template, format, ext) VALUES ('', %s, %s, %s)", $this->_db->prefix($this->_dbtable), $this->_db->quoteString($template), $this->_db->quoteString($format), $this->_db->quoteString($ext));
        } else {
            $id = $formatid;
            $sql = sprintf("UPDATE %s SET template = %s, format = %s, ext = %s WHERE " . $this->_key_field . " = %u", $this->_db->prefix($this->_dbtable), $this->_db->quoteString($template), $this->_db->quoteString($format), $this->_db->quoteString($ext), $id);
        }

        //echo "<br />" . $sql . "<br />";

        if (false != $force) {
            $result = $this->_db->queryF($sql);
        } else {
            $result = $this->_db->query($sql);
        }

        if (!$result) {
            return false;
        }
        if ($obj->isNew()) {
            $obj->assignVar('id', $this->_db->getInsertId());
        }

        return true;
    }

    /**
     * delete a Format from the database
     *
     * @param object $obj reference to the Format to delete
     * @param bool $force
     * @return bool FALSE if failed.
     */
    function delete(&$obj, $force = false)
    {
        if (get_class($obj) != $this->classname) {
            return false;
        }

        $sql = sprintf("DELETE FROM %s WHERE " . $this->_key_field . " = %u", $this->_db->prefix($this->_dbtable), $obj->formatid());

        //echo "<br />$sql<br />";

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
     * retrieve Format from the database
     *
     * @param object $criteria {@link CriteriaElement} conditions to be met
     * @param bool $id_as_key use the formatid as key for the array?
     * @return array array of {@link SmartmediaFormat} objects
     */
    function &getObjects($criteria = null, $id_as_key = false)
    {
        $ret = false;
        $limit = $start = 0;
        $sql = 'SELECT * FROM '.$this->_db->prefix($this->_dbtable);

        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $whereClause = $criteria->renderWhere();
             
            If ($whereClause != 'WHERE ()') {
                $sql .= ' '.$criteria->renderWhere();
                if ($criteria->getSort() != '') {
                    $sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
                }
                $limit = $criteria->getLimit();
                $start = $criteria->getStart();
            }
        }

        //echo "<br />" . $sql . "<br />";

        $result = $this->_db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }

        If (count($result) == 0) {
            return $ret;
        }

        while ($myrow = $this->_db->fetchArray($result)) {
            $obj = new $this->classname;
            $obj->assignVars($myrow);
             
            if (!$id_as_key) {
                $ret[] =& $obj;
            } else {
                $ret[$myrow['id']] =& $obj;
            }
            unset($obj);
        }
        return $ret;
    }

    function getFormats($sort='format', $order='ASC')
    {
        $criteria = new CriteriaCompo();
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $ret =& $this->getObjects($criteria);

        return $ret;
    }

    /**
     * count Formats matching a condition
     *
     * @param object $criteria {@link CriteriaElement} to match
     * @return int count of clients
     */
    function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM '.$this->_db->prefix($this->_dbtable);
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $whereClause = $criteria->renderWhere();
            If ($whereClause != 'WHERE ()') {
                $sql .= ' '.$criteria->renderWhere();
            }
        }
         
        //echo "<br />" . $sql . "<br />";

        $result = $this->_db->query($sql);
        if (!$result) {
            return 0;
        }
        list($count) = $this->_db->fetchRow($result);
        return $count;
    }

    /**
     * Change a value for a Format with a certain criteria
     *
     * @param   string  $fieldname  Name of the field
     * @param   string  $fieldvalue Value to write
     * @param   object  $criteria   {@link CriteriaElement}
     *
     * @return  bool
     **/
    function updateAll($fieldname, $fieldvalue, $criteria = null)
    {
        $set_clause = is_numeric($fieldvalue) ? $fieldname.' = '.$fieldvalue : $fieldname.' = '.$this->_db->quoteString($fieldvalue);
        $sql = 'UPDATE '.$this->_db->prefix($this->_dbtable).' SET '.$set_clause;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
        }

        //echo "<br />" . $sql . "<br />";

        if (!$result = $this->_db->queryF($sql)) {
            return false;
        }
        return true;
    }
}

?>
