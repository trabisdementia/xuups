<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Xmf
 * @since           0.1
 * @author          trabis <lusopoemas@gmail.com>
 * @author          Kazumi Ono <onokazu@xoops.org>
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @author          Jan Keller Pedersen <mithrandir@xoops.org> - IDG Danmark A/S <www.idg.dk>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');
/**
 * Persistable Object Handler class.
 *
 * @author  Kazumi Ono <onokazu@xoops.org>
 * @author  Taiwen Jiang <phppp@users.sourceforge.net>
 * @author  Jan Keller Pedersen <mithrandir@xoops.org> - IDG Danmark A/S <www.idg.dk>
 * @copyright copyright (c) The XOOPS project
 * @package Kernel
 */

class Xmf_Object_Handler
{
    /**
     * holds referenced to {@link XoopsDatabase} class object
     *
     * @var object
     * @see XoopsDatabase
     * @access protected
     */
    var $db;

    /**
     * holds reference to custom extended object handler
     *
     * var object
     * @access private
     */
    /*static protected*/var $handler;

    /**
     * holds reference to predefined extended object handlers: read, stats, joint, write, sync
     *
     * The handlers hold methods for different purposes, which could be all put together inside of current class.
     * However, load codes only if they are necessary, thus they are now splitted out.
     *
     * var array of objects
     * @access private
     */
    /*static protected*/ var $handlers = array(
            'read'  => null,
            'stats' => null,
            'joint' => null,
            'write' => null,
            'sync'  => null,
        );

    /**#@+
     * Information about the class, the handler is managing
     *
     * @var string
     * @access public
     */
    var $table;
    var $keyName;
    var $className;
    var $identifierName;
    /**#@-*/

    /**
     * Constructor
     *
     * @access protected
     *
     * @param object     $db         {@link XoopsDatabase} object
     * @param string     $tablename  Name of database table
     * @param string     $classname  Name of Class, this handler is managing
     * @param string     $keyname    Name of the property, holding the key
     *
     * @return void
     */
    function __construct($db = NULL, $table = "", $className = "", $keyName = "", $identifierName = "")
    {
        $this->db = (is_object($db) && is_a($db, "XoopsDatabase")) ? $db : $GLOBALS["xoopsDB"];
        $this->table = $this->db->prefix($table);
        $this->keyName = $keyName;
        $this->className = $className;
        if ($identifierName) {
            $this->identifierName = $identifierName;
        }
    }

    /**
     * Set custom handler
     *
     * @access  protected
     *
     * @param   object  the handler
     * @param   mixed   args
     * @param   string  $path   path to class
     * @return  object of handler
     */
    function setHandler($handler = null, $args = null, $path = null)
    {
        $this->handler = null;
        if (is_object($handler)) {
            $this->handler = $handler;
        } elseif (is_string($handler)) {
            $this->handler = Xmf_Model_Factory::loadHandler($this, $handler, $args, $path);
        }

        return $this->handler;
    }

    /**
     * Load predefined handler
     *
     * @access  protected
     *
     * @param   string  $name   handler name
     * @param   mixed   $args   args
     * @return  object of handler {@link XoopsObjectAbstract}
     */
    function loadHandler($name, $args = null)
    {
        static $handlers;
        if (!isset($handlers[$name])) {
            $handlers[$name] = Xmf_Model_Factory::loadHandler($this, $name, $args);
        } else {
            $handlers[$name]->setHandler($this);
            $handlers[$name]->setVars($args);
        }

        return $handlers[$name];

        /*
        // Following code just kept as placeholder for PHP5
        if (!isset(self::$handlers[$name])) {
            self::$handlers[$name] = XoopsModelFactory::loadHandler($this, $name, $args);
        } else {
            self::$handlers[$name]->setHandler($this);
               self::$handlers[$name]->setVars($args);
        }

        return self::$handlers[$name];
        */
    }

    /**
     * Magic method for overloading of delegation
     *
     * To be enabled in XOOPS 3.0 with PHP 5
     * @access protected
     *
     * @param   string  $name    method name
     * @param   array   $args    arguments
     * @return  mixed
     */
    function __call($name, $args)
    {
        if (is_object($this->handler) && is_callable(array($this->handler, $name))) {
            return call_user_func_array(array($this->handler, $name), $args);
        }
        foreach (array_keys($this->handlers) as $_handler) {
            $handler = $this->loadHandler($_handler);
            if (is_callable(array($handler, $name))) {
                return call_user_func_array(array($handler, $name), $args);
            }
        }

        return null;
    }

    /**#@+
     * Methods of native handler {@link Xmf_Object_Handler}
     */
    /**
     * create a new object
     *
     * @access protected
     *
     * @param   bool  $isNew Flag the new objects as new
     * @return  object {@link XoopsObject}
     */
    function &create($isNew = true)
    {
        $obj = new $this->className();
        if ($isNew === true) {
            $obj->setNew();
        }
        return $obj;
    }

    /**
     * Load a {@link Xmf_Object} object from the database
     *
     * @access protected
     *
     * @param   mixed    $id     ID
     * @param   array    $fields    fields to fetch
     * @return  object  {@link XoopsObject}
     **/
    function &get($id = null, $fields = null)
    {
        $object = null;
        if (empty($id)) {
            $object = $this->create();
            return $object;
        }

        if (is_array($fields) && count($fields) > 0) {
            $select = implode(",", $fields);
            if (!in_array($this->keyName, $fields)){
                $select .= ", " . $this->keyName;
            }
        } else {
            $select = "*";
        }
        $sql = "SELECT {$select} FROM {$this->table} WHERE {$this->keyName} = " . $this->db->quote($id);
        if (!$result = $this->db->query($sql)) {
            return $object;
        }

        if (!$this->db->getRowsNum($result)) {
            return $object;
        }

        $object =& $this->create(false);
        $object->assignVars($this->db->fetchArray($result));

        return $object;
    }
    /**#@-*/

    /**#@+
     * Methods of write handler {@link Xmf_Object_Write}
     */
    /**
     * insert an object into the database
     *
     * @param    object    $object     {@link XoopsObject} reference to object
     * @param     bool     $force         flag to force the query execution despite security settings
     * @return     mixed     object ID
     */
    function insert(&$object, $force = true)
    {
        $handler = $this->loadHandler("write");
        return $handler->insert($object, $force);
    }

    /**
     * delete an object from the database
     *
     * @param   object  $object {@link XoopsObject} reference to the object to delete
     * @param   bool    $force
     * @return  bool    FALSE if failed.
     */
    function delete(&$object, $force = false)
    {
        $handler = $this->loadHandler("write");
        return $handler->delete($object, $force);
    }

    /**
     * delete all objects matching the conditions
     *
     * @param    object    $criteria   {@link CriteriaElement} with conditions to meet
     * @param     bool    $force        force to delete
     * @param     bool    $asObject   delete in object way: instantiate all objects and delte one by one
     * @return bool
     */
    function deleteAll($criteria = null, $force = true, $asObject = false)
    {
        $handler = $this->loadHandler("write");
        return $handler->deleteAll($criteria, $force, $asObject);
    }

    /**
     * Change a field for objects with a certain criteria
     *
     * @param   string  $fieldname  Name of the field
     * @param   mixed   $fieldvalue Value to write
     * @param   object  $criteria   {@link CriteriaElement}
     * @param     bool    $force        force to query
     *
     * @return  bool
     **/
    function updateAll($fieldname, $fieldvalue, $criteria = null, $force = false)
    {
        $handler = $this->loadHandler("write");
        return $handler->updateAll($fieldname, $fieldvalue, $criteria, $force);
    }
    /**#@-*/

    /**#@+
     * Methods of read handler {@link Xmf_Object_Read}
     */
    /**
     * Retrieve objects from the database
     *
     * @param object    $criteria   {@link CriteriaElement} conditions to be met
     * @param bool      $id_as_key  use the ID as key for the array
     * @param bool      $as_object  return an array of objects
     *
     * @return array
     */
    function &getObjects($criteria = null, $id_as_key = false, $as_object = true)
    {
        $handler = $this->loadHandler("read");
        $ret = $handler->getObjects($criteria, $id_as_key, $as_object);
        return $ret;
    }

    /**
     * get all objects matching a condition
     *
     * @param object    $criteria {@link CriteriaElement} to match
     * @param array        $fields     variables to fetch
     * @param bool        $asObject     flag indicating as object, otherwise as array
     * @param bool      $id_as_key use the ID as key for the array
     * @return array of objects/array {@link XoopsObject}
     */
    function &getAll($criteria = null, $fields = null, $asObject = true, $id_as_key = true)
    {
        $handler = $this->loadHandler("read");
        $ret = $handler->getAll($criteria, $fields, $asObject, $id_as_key);
        return $ret;
    }

    /**
     * Retrieve a list of objects data
     *
     * @param object $criteria {@link CriteriaElement} conditions to be met
     * @param int   $limit      Max number of objects to fetch
     * @param int   $start      Which record to start at
     *
     * @return array
     */
    function getList($criteria = null, $limit = 0, $start = 0)
    {
        $handler = $this->loadHandler("read");
        $ret = $handler->getList($criteria, $limit, $start);
        return $ret;
    }

    /**
     * get IDs of objects matching a condition
     *
     * @param     object    $criteria {@link CriteriaElement} to match
     * @return     array of object IDs
     */
    function &getIds($criteria = null)
    {
        $handler = $this->loadHandler("read");
        $ret = $handler->getIds($criteria);
        return $ret;
    }

    /**
     * get a limited list of objects matching a condition
     *
     * {@link CriteriaCompo}
     *
     * @param int       $limit      Max number of objects to fetch
     * @param int       $start      Which record to start at
     * @param object    $criteria     {@link CriteriaElement} to match
     * @param array        $fields         variables to fetch
     * @param bool        $asObject     flag indicating as object, otherwise as array
     * @return array of objects     {@link XoopsObject}
     */
    function &getByLimit($limit = 0, $start = 0, $criteria = null, $fields = null, $asObject=true)
    {
        $handler = $this->loadHandler("read");
        $ret = $handler->getByLimit($limit, $start, $criteria, $fields, $asObject);
        return $ret;
    }
    /**#@-*/

    /**#@+
     * Methods of stats handler {@link XoopsObjectStats}
     */
    /**
     * count objects matching a condition
     *
     * @param   object  $criteria {@link CriteriaElement} to match
     * @return  int     count of objects
     */
    function getCount($criteria = null)
    {
        $handler = $this->loadHandler("stats");
        return $handler->getCount($criteria);
    }

    /**
     * Get counts of objects matching a condition
     *
     * @param object    $criteria {@link CriteriaElement} to match
     * @return array of conunts
     */
    function getCounts($criteria = null)
    {
        $handler = $this->loadHandler("stats");
        return $handler->getCounts($criteria);
    }
    /**#@-*/

    /**#@+
     * Methods of joint handler {@link Xmf_Object_Joint}
     */
    /**
     * get a list of objects matching a condition joint with another related object
     *
     * @param     object    $criteria     {@link CriteriaElement} to match
     * @param     array    $fields     variables to fetch
     * @param     bool    $asObject     flag indicating as object, otherwise as array
     * @param     string    $field_link     field of linked object for JOIN
     * @param     string    $field_object   field of current object for JOIN
     * @return     array of objects {@link XoopsObject}
     */
    function &getByLink($criteria = null, $fields = null, $asObject = true, $field_link = null, $field_object = null)
    {
        $handler = $this->loadHandler("joint");
        $ret = $handler->getByLink($criteria, $fields, $asObject, $field_link, $field_object);
        return $ret;
    }

    /**
     * Count of objects matching a condition
     *
     * @param   object $criteria {@link CriteriaElement} to match
     * @return  int count of objects
     */
    function getCountByLink($criteria = null)
    {
        $handler = $this->loadHandler("joint");
        $ret = $handler->getCountByLink($criteria);
        return $ret;
    }

    /**
     * array of count of objects matching a condition of, groupby linked object keyname
     *
     * @param   object $criteria {@link CriteriaElement} to match
     * @return  int count of objects
     */
    function getCountsByLink($criteria = null)
    {
        $handler = $this->loadHandler("joint");
        $ret = $handler->getCountsByLink($criteria);
        return $ret;
    }

    /**
     * upate objects matching a condition against linked objects
     *
     * @param   array   $data  array of key => value
     * @param   object  $criteria {@link CriteriaElement} to match
     * @return  int count of objects
     */
    function updateByLink($data, $criteria = null)
    {
        $handler = $this->loadHandler("joint");
        $ret = $handler->updateByLink($data, $criteria);
        return $ret;
    }

    /**
     * Delete objects matching a condition against linked objects
     *
     * @param   object  $criteria {@link CriteriaElement} to match
     * @return  int count of objects
     */
    function deleteByLink($criteria = null)
    {
        $handler = $this->loadHandler("joint");
        $ret = $handler->deleteByLink($criteria);
        return $ret;
    }
    /**#@-*/

    /**#@+
     * Methods of sync handler {@link Xmf_Object_Sync}
     */
    /**
     * Clean orphan objects against linked objects
     *
     * @param     string    $table_link     table of linked object for JOIN
     * @param     string    $field_link     field of linked object for JOIN
     * @param     string    $field_object   field of current object for JOIN
     * @return     bool    true on success
     */
    function cleanOrphan($table_link = "", $field_link = "", $field_object = "")
    {
        $handler = $this->loadHandler("sync");
        $ret = $handler->cleanOrphan($table_link, $field_link, $field_object);
        return $ret;
    }

    /**
     * Synchronizing objects
     *
     * @return     bool    true on success
     */
    function synchronization()
    {
        $this->cleanOrphan();
        return true;
    }
    /**#@-*/
}
