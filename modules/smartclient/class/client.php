<?php

/**
 * $Id: client.php,v 1.11 2005/04/29 15:17:46 malanciault Exp $
 * Module: SmartClient
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

// Clients status
define("_SCLIENT_STATUS_NOTSET", -1);
define("_SCLIENT_STATUS_ALL", 0);
define("_SCLIENT_STATUS_SUBMITTED", 1);
define("_SCLIENT_STATUS_ACTIVE", 2);
define("_SCLIENT_STATUS_REJECTED", 3);
define("_SCLIENT_STATUS_INACTIVE", 4);

define("_SCLIENT_NOT_CLIENT_SUBMITTED", 1);
define("_SCLIENT_NOT_CLIENT_APPROVED", 2);

class SmartclientClient extends XoopsObject
{
    var $_extendedInfo = null;

    function SmartclientClient($id = null)
    {
        $this->_db =& Database::getInstance();
        $this->initVar("id", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("title", XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar("summary", XOBJ_DTYPE_TXTAREA, null, true);
        $this->initVar("description", XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar("contact_name", XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar("contact_email", XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar("contact_phone", XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar("adress", XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar("url", XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar("image", XOBJ_DTYPE_TXTBOX, null, true);
        $this->initVar("image_url", XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar("weight", XOBJ_DTYPE_INT, 0, false, 10);
        $this->initVar("hits", XOBJ_DTYPE_INT, null, true, 10);
        $this->initVar("hits_page", XOBJ_DTYPE_INT, null, true, 10);
        $this->initVar("status", XOBJ_DTYPE_INT, _SCLIENT_STATUS_NOTSET, false, 10);

        $this->initVar("dohtml", XOBJ_DTYPE_INT, 1, false);

        if (isset($id)) {
            $client_handler = new SmartclientClientHandler($this->_db);
            $client =& $client_handler->get($id);
            foreach ($client->vars as $k => $v) {
                $this->assignVar($k, $v['value']);
            }
        }
    }

    function id()
    {
        return $this->getVar("id");
    }

    function weight()
    {
        return $this->getVar("weight");
    }

    function hits()
    {
        return $this->getVar("hits");
    }

    function hits_page()
    {
        return $this->getVar("hits_page");
    }

    function url($format="S")
    {
        return $this->getVar('url', $format);
    }

    function image($format="S")
    {
        if ($this->getVar('image') != '') {
            return $this->getVar('image', $format);
        } else {
            return 'blank.png';
        }
    }

    function image_url($format="S")
    {
        return $this->getVar('image_url', $format);
    }

    function title($format="S")
    {
        $ret = $this->getVar("title", $format);
        If (($format=='s') || ($format=='S') || ($format=='show')) {
            $myts = &MyTextSanitizer::getInstance();
            $ret = $myts->displayTarea($ret);
        }

        return $ret;
    }

    function summary($maxLength=0, $format="S")
    {
        $ret = $this->getVar("summary", $format);

        If ($maxLength != 0) {
            if (!XOOPS_USE_MULTIBYTES) {
                if (strlen($ret) >= $maxLength) {
                    $ret = substr($ret , 0, ($maxLength -1)) . "...";
                }
            }
        }
        return $ret;
    }

    function description($format="S")
    {
        return $this->getVar('description', $format);
    }

    function contact_name($format="S")
    {
        $ret = $this->getVar("contact_name", $format);
        If (($format=='s') || ($format=='S') || ($format=='show')) {
            $myts = &MyTextSanitizer::getInstance();
            $ret = $myts->displayTarea($ret);
        }

        return $ret;
    }

    function contact_email($format="S")
    {
        $ret = $this->getVar("contact_email", $format);
        If (($format=='s') || ($format=='S') || ($format=='show')) {
            $myts = &MyTextSanitizer::getInstance();
            $ret = $myts->displayTarea($ret);
        }

        return $ret;
    }

    function contact_phone($format="S")
    {
        $ret = $this->getVar("contact_phone", $format);
        If (($format=='s') || ($format=='S') || ($format=='show')) {
            $myts = &MyTextSanitizer::getInstance();
            $ret = $myts->displayTarea($ret);
        }

        return $ret;
    }

    function adress($format="S")
    {
        $ret = $this->getVar("adress", $format);

        return $ret;
    }

    function status()
    {
        return $this->getVar("status");
    }

    function getUrlLink($forWhere)
    {
        if ($forWhere == 'block') {
            if ($this->extentedInfo()) {
                return '<a href="' . SMARTCLIENT_URL . 'client.php?id=' . $this->id() . '">';
            } else {
                if ($this->url()) {
                    return '<a href="' . $this->url() . '" target="_blank">';
                } else {
                    return '';
                }
            }
        } elseif ($forWhere == 'index') {
            if ($this->extentedInfo()) {
                return '<a href="' . SMARTCLIENT_URL . 'client.php?id=' . $this->id() . '">';
            } else {
                if ($this->url()) {
                    return '<a href="' . $this->url() . '" target="_blank">';
                } else {
                    return '';
                }
            }
        } elseif ($forWhere == 'client') {
            if ($this->url()) {
                return '<a href="' . SMARTCLIENT_URL . 'vclient.php?id=' . $this->id() . '" target="_blank">';
            } else {
                return '';
            }
        }
    }

    function getImageUrl()
    {
        if (($this->getVar('image') != '') && ($this->getVar('image') != 'blank.png') && ($this->getVar('image') != '-1')) {
            return smartclient_getImageDir('', false) . $this->image();
        } elseif (!$this->getVar('image_url')) {
            return smartclient_getImageDir('', false) . 'blank.png';
        } else {
            return $this->getVar('image_url');
        }
    }

    function getImagePath()
    {
        if (($this->getVar('image') != '') && ($this->getVar('image') != 'blank.png')) {
            return smartclient_getImageDir() . $this->image();
        } else
        return false;
    }


    function getImageLink()
    {
        $ret = "<a href='rrvclient.php?id=". $this->id() . "' target='_blank'>";
        if ($this->getVar('image') != '') {
            $ret .= "<img src='". $this->getImageUrl() ."' alt='". $this->url() ."' border='0' /></a>";
        } else {
            $ret .= "<img src='". $this->image_url() ."' alt='". $this->url() ."' border='0' /></a>";
        }
        return $ret;

    }

    function getClientLink()
    {
        if ($this->extentedInfo()){
            return SMARTCLIENT_URL . "client.php?id=" . $this->id();
        } else {
            return SMARTCLIENT_URL . "vclient.php?id=" . $this->id();
        }
    }

    function getStatusName()
    {
        switch ($this->status()) {
            case _SCLIENT_STATUS_ACTIVE :
                return  _CO_SCLIENT_ACTIVE;
                break;

            case _SCLIENT_STATUS_INACTIVE :
                return  _CO_SCLIENT_INACTIVE;
                break;

            case _SCLIENT_STATUS_REJECTED :
                return  _CO_SCLIENT_REJECTED;
                break;

            case _SCLIENT_STATUS_SUBMITTED :
                return  _CO_SCLIENT_SUBMITTED;
                break;

            case _SCLIENT_STATUS_NOTSET :
            default;
            return  _CO_SCLIENT_NOTSET;
            break;
        }
    }

    function notLoaded()
    {
        return ($this->getVar('id')== 0);
    }

    function extentedInfo()
    {
        if ($this->_extendedInfo) {
            return $this->_extendedInfo;
        }
        if (!$this->description() &&
        !$this->contact_name() &&
        !$this->contact_email() &&
        !$this->contact_phone() &&
        !$this->adress()
        ) {
            $this->_extendedInfo = false;
        } else {
            $this->_extendedInfo = true;
        }
        return $this->_extendedInfo;
    }

    function store($force = true)
    {
        $client_handler = new SmartclientClientHandler($this->_db);
        return $client_handler->insert($this, $force);
    }

    function updateHits()
    {
        $sql = "UPDATE " . $this->_db->prefix("smartclient_client") . " SET hits=hits+1 WHERE id = " . $this->id();
        If ($this->_db->queryF($sql)) {
            return true;
        } else {
            return false;
        }
    }

    function updateHits_page()
    {
        $sql = "UPDATE " . $this->_db->prefix("smartclient_client") . " SET hits_page=hits_page+1 WHERE id = " . $this->id();
        If ($this->_db->queryF($sql)) {
            return true;
        } else {
            return false;
        }
    }

    function sendNotifications($notifications=array())
    {
        $smartModule =& smartclient_getModuleInfo();
        $module_id = $smartModule->getVar('mid');

        $myts =& MyTextSanitizer::getInstance();
        $notification_handler = &xoops_gethandler('notification');

        $tags = array();
        $tags['MODULE_NAME'] = $myts->displayTarea($smartModule->getVar('name'));
        $tags['CLIENT_NAME'] = $this->title(20);
        foreach ( $notifications as $notification ) {
            switch ($notification) {

                case _SCLIENT_NOT_CLIENT_SUBMITTED :
                    $tags['WAITINGFILES_URL'] = XOOPS_URL . '/modules/' . $smartModule->getVar('dirname') . '/admin/client.php?op=mod&id=' . $this->id();
                    $notification_handler->triggerEvent('global_client', 0, 'submitted', $tags);
                    break;

                case _SCLIENT_NOT_CLIENT_APPROVED :
                    $tags['CLIENT_URL'] = XOOPS_URL . '/modules/' . $smartModule->getVar('dirname') . '/client.php?id=' . $this->id();
                    $notification_handler->triggerEvent('client', $this->id(), 'approved', $tags);
                    break;

                case -1 :
                default:
                    break;
            }
        }
    }

    function getRedirectMsg($original_status, $new_status)
    {
        $redirect_msgs = array();

        switch ($original_status) {

            case _SCLIENT_STATUS_NOTSET :
                switch ($new_status) {
                    case _SCLIENT_STATUS_ACTIVE :
                        $redirect_msgs['success'] = _AM_SCLIENT_NOTSET_ACTIVE_SUCCESS;
                        $redirect_msgs['error'] = _AM_SCLIENT_CLIENT_NOT_UPDATED;
                        break;

                    case _SCLIENT_STATUS_INACTIVE :
                        $redirect_msgs['success'] = _AM_SCLIENT_NOTSET_INACTIVE_SUCCESS;
                        $redirect_msgs['error'] = _AM_SCLIENT_CLIENT_NOT_UPDATED;
                        break;
                }
                break;


            case _SCLIENT_STATUS_SUBMITTED :
                switch ($new_status) {
                    case _SCLIENT_STATUS_ACTIVE :
                        $redirect_msgs['success'] = _AM_SCLIENT_SUBMITTED_ACTIVE_SUCCESS;
                        $redirect_msgs['error'] = _AM_SCLIENT_CLIENT_NOT_UPDATED;
                        break;

                    case _SCLIENT_STATUS_INACTIVE :
                        $redirect_msgs['success'] = _AM_SCLIENT_SUBMITTED_INACTIVE_SUCCESS;
                        $redirect_msgs['error'] = _AM_SCLIENT_CLIENT_NOT_UPDATED;
                        break;

                    case _SCLIENT_STATUS_REJECTED :
                        $redirect_msgs['success'] = _AM_SCLIENT_SUBMITTED_REJECTED_SUCCESS;
                        $redirect_msgs['error'] = _AM_SCLIENT_CLIENT_NOT_UPDATED;
                        break;
                }
                break;

            case _SCLIENT_STATUS_ACTIVE :
                switch ($new_status) {
                    case _SCLIENT_STATUS_ACTIVE :
                        $redirect_msgs['success'] = _AM_SCLIENT_ACTIVE_ACTIVE_SUCCESS;
                        $redirect_msgs['error'] = _AM_SCLIENT_CLIENT_NOT_UPDATED;
                        break;

                    case _SCLIENT_STATUS_INACTIVE :
                        $redirect_msgs['success'] = _AM_SCLIENT_ACTIVE_INACTIVE_SUCCESS;
                        $redirect_msgs['error'] = _AM_SCLIENT_CLIENT_NOT_UPDATED;
                        break;

                }
                break;

            case _SCLIENT_STATUS_INACTIVE :
                switch ($new_status) {
                    case _SCLIENT_STATUS_ACTIVE :
                        $redirect_msgs['success'] = _AM_SCLIENT_INACTIVE_ACTIVE_SUCCESS;
                        $redirect_msgs['error'] = _AM_SCLIENT_CLIENT_NOT_UPDATED;
                        break;

                    case _SCLIENT_STATUS_INACTIVE :
                        $redirect_msgs['success'] = _AM_SCLIENT_INACTIVE_INACTIVE_SUCCESS;
                        $redirect_msgs['error'] = _AM_SCLIENT_CLIENT_NOT_UPDATED;
                        break;

                }
                break;

            case _SCLIENT_STATUS_REJECTED :
                switch ($new_status) {
                    case _SCLIENT_STATUS_ACTIVE :
                        $redirect_msgs['success'] = _AM_SCLIENT_REJECTED_ACTIVE_SUCCESS;
                        $redirect_msgs['error'] = _AM_SCLIENT_CLIENT_NOT_UPDATED;
                        break;

                    case _SCLIENT_STATUS_INACTIVE :
                        $redirect_msgs['success'] = _AM_SCLIENT_REJECTED_INACTIVE_SUCCESS;
                        $redirect_msgs['error'] = _AM_SCLIENT_CLIENT_NOT_UPDATED;
                        break;

                    case _SCLIENT_STATUS_REJECTED :
                        $redirect_msgs['success'] = _AM_SCLIENT_REJECTED_REJECTED_SUCCESS;
                        $redirect_msgs['error'] = _AM_SCLIENT_CLIENT_NOT_UPDATED;
                        break;
                }
                break;
        }
        return $redirect_msgs;
    }

    function getAvailableStatus()
    {

        switch ($this->status()) {
            case _SCLIENT_STATUS_NOTSET :
                $ret = array(
                _SCLIENT_STATUS_ACTIVE =>_AM_SCLIENT_ACTIVE,
                _SCLIENT_STATUS_INACTIVE =>_AM_SCLIENT_INACTIVE
                );
                break;
            case _SCLIENT_STATUS_SUBMITTED :
                $ret = array(
                _SCLIENT_STATUS_ACTIVE =>_AM_SCLIENT_ACTIVE,
                _SCLIENT_STATUS_REJECTED =>_AM_SCLIENT_REJECTED,
                _SCLIENT_STATUS_INACTIVE =>_AM_SCLIENT_INACTIVE
                );
                break;

            case _SCLIENT_STATUS_ACTIVE :
                $ret = array(
                _SCLIENT_STATUS_ACTIVE =>_AM_SCLIENT_ACTIVE,
                _SCLIENT_STATUS_INACTIVE =>_AM_SCLIENT_INACTIVE
                );
                break;

            case _SCLIENT_STATUS_INACTIVE :
                $ret = array(
                _SCLIENT_STATUS_ACTIVE =>_AM_SCLIENT_ACTIVE,
                _SCLIENT_STATUS_INACTIVE =>_AM_SCLIENT_INACTIVE
                );
                break;

            case _SCLIENT_STATUS_REJECTED :
                $ret = array(
                _SCLIENT_STATUS_ACTIVE =>_AM_SCLIENT_ACTIVE,
                _SCLIENT_STATUS_REJECTED =>_AM_SCLIENT_REJECTED,
                _SCLIENT_STATUS_INACTIVE =>_AM_SCLIENT_INACTIVE
                );
                break;
        }
        return $ret;
    }

    function toArray($client = array()) {
        $smartConfig = smartclient_getModuleConfig();

        $client['id'] = $this->id();
        $client['hits'] = $this->hits();
        $client['hits_page'] = $this->hits_page();
        $client['url'] = $this->url();
        $client['urllink'] = $this->getUrlLink('client');
        $client['image'] = $this->getImageUrl();

        $client['title'] = $this->title();
        $client['clean_title'] = $client['title'];
        $client['summary'] = $this->summary();
        If ($this->description() != '') {
            $client['description'] = $this->description();
        } else {
            $client['description'] = $this->summary();
        }
        $client['contact_name'] = $this->contact_name();
        $client['contact_email'] = $this->contact_email('x');
        $client['contact_phone'] = $this->contact_phone();
        $client['adress'] = $this->adress();

        $image_info = smartclient_imageResize($this->getImagePath(), $smartConfig['img_max_width'], $smartConfig['img_max_height']);
        $client['img_attr'] = $image_info[3];

        $client['readmore'] = ($this->extentedInfo());


        // Hightlighting searched words
        $highlight = true;
        if($highlight && isset($_GET['keywords']))
        {
            $myts =& MyTextSanitizer::getInstance();
            $keywords=$myts->htmlSpecialChars(trim(urldecode($_GET['keywords'])));
            $h= new SmartclientKeyhighlighter ($keywords, true , 'smartclient_highlighter');
            $client['title'] = $h->highlight($client['title']);
            $client['summary'] = $h->highlight($client['summary']);
            $client['description'] = $h->highlight($client['description']);
            $client['contact_name'] = $h->highlight($client['contact_name']);
            $client['contact_email'] = $h->highlight($client['contact_email']);
            $client['contact_phone'] = $h->highlight($client['contact_phone']);
            $client['adress'] = $h->highlight($client['adress']);
        }

        return $client;
    }


}

/**
 * Client handler class.
 * This class is responsible for providing data access mechanisms to the data source
 * of Client class objects.
 *
 * @author marcan <marcan@notrevie.ca>
 * @package SmartClient
 */

class SmartclientClientHandler extends XoopsObjectHandler
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
    var $classname = 'smartclientclient';

    /**
     * _db table name
     *
     * @var string
     * @access private
     */
    var $_dbtable = 'smartclient_client';

    /**
     * key field name
     *
     * @var string
     * @access private
     */
    var $_key_field = 'id';

    /**
     * caption field name
     *
     * @var string
     * @access private
     */
    var $_caption_field = 'title';


    /**
     * Constructor
     *
     * @param	object   $_db    reference to a xoops_db object
     */
    function SmartclientClientHandler(&$_db)
    {
        $this->_db = $_db;
    }

    /**
     * Singleton - prevent multiple instances of this class
     *
     * @param objecs &$_db {@link XoopsHandlerFactory}
     * @return object {@link SmartclientCategoryHandler}
     * @access public
     */
    function &getInstance(&$_db)
    {
        static $instance;
        if(!isset($instance)) {
            $instance = new SmartclientCategoryHandler($_db);
        }
        return $instance;
    }

    function &create($isNew = true)
    {
        $client = new SmartclientClient();
        if ($isNew) {
            $client->setNew();
        }
        return $client;
    }

    /**
     * retrieve a Client
     *
     * @param int $id clientid of the user
     * @return mixed reference to the {@link SmartclientClient} object, FALSE if failed
     */
    function &get($id)
    {
        if (intval($id) > 0) {
            $sql = 'SELECT * FROM '.$this->_db->prefix($this->_dbtable).' WHERE id='.$id;
            if (!$result = $this->_db->query($sql)) {
                return false;
            }

            $numrows = $this->_db->getRowsNum($result);
            if ($numrows == 1) {
                $client = new SmartclientClient();
                $client->assignVars($this->_db->fetchArray($result));
                return $client;
            }
        }
        return false;
    }

    /**
     * insert a new Client in the database
     *
     * @param object $client reference to the {@link SmartclientClient} object
     * @param bool $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    function insert(&$client, $force = false)
    {
        if (get_class($client) != $this->classname) {
            return false;
        }

        if (!$client->isDirty()) {
            return true;
        }

        if (!$client->cleanVars()) {
            return false;
        }

        foreach ($client->cleanVars as $k => $v) {
            ${$k} = $v;
        }

        if ($client->isNew()) {
            $sql = sprintf("INSERT INTO %s (id, weight, hits, hits_page, url, image, image_url, title, summary, description, contact_name, contact_email, contact_phone, adress, `status`) VALUES ('', %u, %u, %u, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %u)", $this->_db->prefix($this->_dbtable), $weight, $hits, $hits_page, $this->_db->quoteString($url), $this->_db->quoteString($image), $this->_db->quoteString($image_url), $this->_db->quoteString($title), $this->_db->quoteString($summary), $this->_db->quoteString($description), $this->_db->quoteString($contact_name), $this->_db->quoteString($contact_email), $this->_db->quoteString($contact_phone), $this->_db->quoteString($adress), $status);
        } else {
            $sql = sprintf("UPDATE %s SET weight = %u, hits = %u, hits_page = %u, url = %s, image = %s, image_url = %s, title = %s, summary = %s, description = %s, contact_name = %s, contact_email = %s, contact_phone = %s, adress = %s, `status` = %u WHERE id = %u", $this->_db->prefix($this->_dbtable), $weight, $hits, $hits_page, $this->_db->quoteString($url), $this->_db->quoteString($image), $this->_db->quoteString($image_url), $this->_db->quoteString($title), $this->_db->quoteString($summary), $this->_db->quoteString($description), $this->_db->quoteString($contact_name), $this->_db->quoteString($contact_email), $this->_db->quoteString($contact_phone), $this->_db->quoteString($adress), $status, $id);
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
        if ($client->isNew()) {
            $client->assignVar('id', $this->_db->getInsertId());
        }

        return true;
    }

    /**
     * delete a Client from the database
     *
     * @param object $client reference to the Client to delete
     * @param bool $force
     * @return bool FALSE if failed.
     */
    function delete(&$client, $force = false)
    {
        $clientModule =& smartclient_getModuleInfo();
        $module_id = $clientModule->getVar('mid');

        if (get_class($client) != $this->classname) {
            return false;
        }

        $sql = sprintf("DELETE FROM %s WHERE id = %u", $this->_db->prefix($this->_dbtable), $client->getVar('id'));

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
     * retrieve Clients from the database
     *
     * @param object $criteria {@link CriteriaElement} conditions to be met
     * @param bool $id_as_key use the clientid as key for the array?
     * @return array array of {@link SmartclientClient} objects
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
            $client = new SmartclientClient();
            $client->assignVars($myrow);

            if (!$id_as_key) {
                $ret[] =& $client;
            } else {
                $ret[$myrow['id']] =& $client;
            }
            unset($client);
        }
        return $ret;
    }

    /**
     * count Clients matching a condition
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

    function getClientCount($status=_SCLIENT_STATUS_ACTIVE)
    {

        If ($status != _SCLIENT_STATUS_ALL) {
            $criteriaStatus = new CriteriaCompo();
            $criteriaStatus->add(new Criteria('status', $status));
        }

        $criteria = new CriteriaCompo();
        If (isset($criteriaStatus)) {
            $criteria->add($criteriaStatus);
        }
        return $this->getCount($criteria);
    }


    function &getObjectsForSearch($queryarray = array(), $andor = 'AND', $limit = 0, $offset = 0, $userid = 0)
    {
        global $xoopsConfig;

        $ret    = array();
        $sql    = "SELECT title, id
				   FROM " . $this->_db->prefix($this->_dbtable) . "
				   ";
        if ($userid <> 0) {
            $sql .= " WHERE	uid = $userid";
        }

        If ($queryarray) {
            $criteriaKeywords = new CriteriaCompo();
            for ($i = 0; $i < count($queryarray); $i++) {
                $criteriaKeyword = new CriteriaCompo();
                $criteriaKeyword->add(new Criteria('title', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                $criteriaKeyword->add(new Criteria('summary', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                $criteriaKeyword->add(new Criteria('description', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                $criteriaKeyword->add(new Criteria('contact_name', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                $criteriaKeyword->add(new Criteria('contact_email', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                $criteriaKeyword->add(new Criteria('contact_phone', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                $criteriaKeyword->add(new Criteria('adress', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                $criteriaKeywords->add($criteriaKeyword, $andor);
                unset($criteriaKeyword);
            }
        }

        $criteria = new CriteriaCompo();

        If (!empty($criteriaKeywords)) {
            $criteria->add($criteriaKeywords, 'AND');
        }

        $criteria->setSort('title');
        $criteria->setOrder('ASC');

        if(isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' .$criteria->renderWhere();
            if($criteria->getSort() != '') {
                $sql .= ' ORDER BY ' . $criteria->getSort() . '
                    ' .$criteria->getOrder();
            }
        }

        //echo "<br />$sql<br />";

        $result = $this->_db->query($sql, $limit, $offset);
        // If no records from _db, return empty array
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


    function getClients($limit=0, $start=0, $status=_SCLIENT_STATUS_ACTIVE, $sort='title', $order='ASC', $asobject=true)
    {
        global $xoopsUser;
        If ($status != _SCLIENT_STATUS_ALL) {
            $criteriaStatus = new CriteriaCompo();
            $criteriaStatus->add(new Criteria('status', $status));
        }

        $criteria = new CriteriaCompo();
        If (isset($criteriaStatus)) {
            $criteria->add($criteriaStatus);
        }
        $criteria->setLimit($limit);
        $criteria->setStart($start);
        $criteria->setSort($sort);
        $criteria->setOrder($order);
        $ret =& $this->getObjects($criteria);

        return $ret;
    }


    function getRandomClient($status=null)
    {
        $ret = false;

        // Getting the number of clients
        $totalClients = $this->getClientCount($status);

        if ($totalClients > 0) {
            $totalClients = $totalClients - 1;
            mt_srand((double)microtime() * 1000000);
            $entrynumber = mt_rand(0, $totalClients);
            $client =& $this->getClients(1, $entrynumber, $status);
            If ($client) {
                $ret =& $client[0];
            }
        }
        return $ret;

    }


    /**
     * delete Clients matching a set of conditions
     *
     * @param object $criteria {@link CriteriaElement}
     * @return bool FALSE if deletion failed
     */
    function deleteAll($criteria = null)
    {
        $sql = 'DELETE FROM '.$this->_db->prefix('smartclient_client');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
        }
        if (!$result = $this->_db->query($sql)) {
            return false;
        }
        return true;
    }

    /**
     * Change a value for a Client with a certain criteria
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
        $sql = 'UPDATE '.$this->_db->prefix('smartclient_client').' SET '.$set_clause;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
        }
        if (!$result = $this->_db->queryF($sql)) {
            return false;
        }
        return true;
    }

    function getRandomClients($limit=0, $status=_SCLIENT_STATUS_ACTIVE)
    {
        $ret = false;
        $sql = 'SELECT id FROM '.$this->_db->prefix('smartclient_client') . ' ';
        $sql .= 'WHERE status=' . $status;

        //echo "<br />" . $sql . "<br />";

        $result = $this->_db->query($sql);

        if (!$result) {
            return $ret;
        }

        If (count($result) == 0) {
            return $ret;
        }

        $clients_ids = array();
        while ($myrow = $this->_db->fetchArray($result)) {
            $clients_ids[] = $myrow['id'];
        }

        If ((count($clients_ids) > 1)) {
            $key_arr = array_values($clients_ids);
            $key_rand = array_rand($key_arr,count($key_arr));
            $ids = implode(', ', $key_rand);
            echo $ids;



            return $ret;
        } else {
            return $ret;
        }

    }

    /*	function getFaqsFromSearch($queryarray = array(), $andor = 'AND', $limit = 0, $offset = 0, $userid = 0)
     {

     Global $xoopsUser;

     $ret = array();

     $hModule =& xoops_gethandler('module');
     $hModConfig =& xoops_gethandler('config');
     $smartModule =& $hModule->getByDirname('smartfaq');
     $module_id = $smartModule->getVar('mid');

     $gperm_handler = &xoops_gethandler('groupperm');
     $groups = ($xoopsUser) ? ($xoopsUser->getGroups()) : XOOPS_GROUP_ANONYMOUS;
     $userIsAdmin = sf_userIsAdmin();


     if ($userid != 0) {
     $criteriaUser = new CriteriaCompo();
     $criteriaUser->add(new Criteria('faq.uid', $userid), 'OR');
     $criteriaUser->add(new Criteria('answer.uid', $userid), 'OR');
     }

     If ($queryarray) {
     $criteriaKeywords = new CriteriaCompo();
     for ($i = 0; $i < count($queryarray); $i++) {
     $criteriaKeyword = new CriteriaCompo();
     $criteriaKeyword->add(new Criteria('faq.question', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
     $criteriaKeyword->add(new Criteria('answer.answer', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
     $criteriaKeywords->add($criteriaKeyword, $andor);
     }
     }

     // Categories for which user has access
     if (!$userIsAdmin) {
     $categoriesGranted = $gperm_handler->getItemIds('category_read', $groups, $module_id);
     $grantedCategories = new Criteria('faq.categoryid', "(".implode(',', $categoriesGranted).")", 'IN');
     }
     // FAQs for which user has access
     if (!$userIsAdmin) {
     $faqsGranted = $gperm_handler->getItemIds('item_read', $groups, $module_id);
     $grantedFaq = new Criteria('faq.faqid', "(".implode(',', $faqsGranted).")", 'IN');
     }

     $criteriaPermissions = new CriteriaCompo();
     if (!$userIsAdmin) {
     $criteriaPermissions->add($grantedCategories, 'AND');
     $criteriaPermissions->add($grantedFaq, 'AND');
     }

     $criteriaAnswersStatus = new CriteriaCompo();
     $criteriaAnswersStatus->add(new Criteria('answer.status', _SF_AN_STATUS_APPROVED));

     $criteriaFasStatus = new CriteriaCompo();
     $criteriaFasStatus->add(new Criteria('faq.status', _SF_STATUS_OPENED), 'OR');
     $criteriaFasStatus->add(new Criteria('faq.status', _SF_STATUS_PUBLISHED), 'OR');

     $criteria = new CriteriaCompo();
     If (!empty($criteriaUser)) {
     $criteria->add($criteriaUser, 'AND');
     }

     If (!empty($criteriaKeywords)) {
     $criteria->add($criteriaKeywords, 'AND');
     }

     If (!empty($criteriaPermissions) && (!$userIsAdmin)) {
     $criteria->add($criteriaPermissions);
     }

     If (!empty($criteriaAnswersStatus)) {
     $criteria->add($criteriaAnswersStatus, 'AND');
     }

     If (!empty($criteriaFasStatus)) {
     $criteria->add($criteriaFasStatus, 'AND');
     }

     $criteria->setLimit($limit);
     $criteria->setStart($offset);
     $criteria->setSort('faq.datesub');
     $criteria->setOrder('DESC');


     $sql = 'SELECT faq.faqid FROM '.$this->_db->prefix('smartfaq_faq') . ' as faq INNER JOIN '.$this->_db->prefix('smartfaq_answers') . ' as answer ON faq.faqid = answer.faqid';

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
     echo "- query did not work -";
     return $ret;
     }

     If (count($result) == 0) {
     return $ret;
     }

     while ($myrow = $this->_db->fetchArray($result)) {
     $faq = new sfFaq($myrow['faqid']);
     $ret[] =& $faq;
     unset($faq);
     }
     return $ret;
     }*/
}

?>
