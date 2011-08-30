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
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Xmf
 * @since           0.1
 * @author          trabis <lusopoemas@gmail.com>
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

/**
 * Object write handler class.
 *
 * @author      Taiwen Jiang <phppp@users.sourceforge.net>
 * @copyright   The XOOPS project http://www.xoops.org/
 *
 * {@link XoopsObjectAbstract}
 *
 */

class Xmf_Model_Write extends Xmf_Model_Abstract
{
    /**
     * Clean values of all variables of the object for storage.
     * also add slashes and quote string whereever needed
     *
     * CleanVars only contains changed and cleaned variables
     * Reference is used for PHP4 compliance
     *
     * @return bool true if successful
     * @access public
     */
    function cleanVars(&$object)
    {
        $ts =& Xmf_Sanitizer::getInstance();
        $errors = array();

        $vars = $object->getVars();
        $object->cleanVars = array();
        foreach ($vars as $k => $v) {
            if(!$v["changed"]) {
                continue;
            }
            $cleanv = $v['value'];
            $cleanv = Xmf_Object_Dtype::cleanVars($object, $k, $v, $cleanv);
            $object->cleanVars[$k] = $cleanv;
        }
        if (!empty($errors)) {
            $object->setErrors($errors);
        }
        $object->unsetDirty();
        //print_r($errors);exit();
        return empty($errors) ? true : false;
    }

    /**
     * insert an object into the database
     *
     * @param    object    $object     {@link XoopsObject} reference to object
     * @param     bool     $force         flag to force the query execution despite security settings
     * @return     mixed     object ID
     */
    function insert(&$object, $force = true)
    {
        if (!$object->isDirty()) {
            trigger_error("Data entry is not inserted - the object '" . get_class($object). "' is not dirty", E_USER_NOTICE);
            return $object->getVar($this->handler->keyName);
        }
        if (!$this->cleanVars($object)) {
            trigger_error("Insert failed in method 'cleanVars' of object '" . get_class($object). "'", E_USER_WARNING);
            return $object->getVar($this->handler->keyName);
        }
        $queryFunc = empty($force) ? "query" : "queryF";

        if ($object->isNew()) {
            $sql = "INSERT INTO `" . $this->handler->table . "`";
            if (!empty($object->cleanVars)) {
                $keys = array_keys($object->cleanVars);
                $vals = array_values($object->cleanVars);
                $sql .= " (`" . implode("`, `", $keys) . "`) VALUES (" . implode(",", $vals) .")";
            } else {
                trigger_error("Data entry is not inserted - no variable is changed in object of '" . get_class($object) . "'", E_USER_NOTICE);
                return $object->getVar($this->handler->keyName);
            }
            if (!$result = $this->handler->db->{$queryFunc}($sql)) {
                return false;
            }
            if ( !$object->getVar($this->handler->keyName) && $object_id = $this->handler->db->getInsertId() ) {
                $object->assignVar($this->handler->keyName, $object_id);
            }
        } elseif (!empty($object->cleanVars)) {
            $keys = array();
            foreach ($object->cleanVars as $k => $v) {
                $keys[] = " `{$k}` = {$v}";
            }
            $sql = "UPDATE `" . $this->handler->table . "` SET " . implode(",", $keys) . " WHERE `" . $this->handler->keyName . "` = " . $this->handler->db->quote($object->getVar($this->handler->keyName));
            if (!$result = $this->handler->db->{$queryFunc}($sql)) {
                return false;
            }
        }
        return $object->getVar($this->handler->keyName);
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
        if (is_array($this->handler->keyName)) {
            $clause = array();
            for ($i = 0; $i < count($this->handler->keyName); $i++) {
                $clause[] = "`" . $this->handler->keyName[$i] . "` = " . $this->handler->db->quote($object->getVar($this->handler->keyName[$i]));
            }
            $whereclause = implode(" AND ", $clause);
        } else {
            $whereclause = "`" . $this->handler->keyName . "` = " . $this->handler->db->quote($object->getVar($this->handler->keyName));
        }
        $sql = "DELETE FROM `" . $this->handler->table . "` WHERE " . $whereclause;
        $queryFunc = empty($force) ? "query" : "queryF";
        $result = $this->handler->db->{$queryFunc}($sql);

        return empty($result) ? false : true;
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
        if ($asObject) {
            $objects = $this->handler->getAll($criteria);
            $num = 0;
            foreach (array_keys($objects) as $key) {
                $num += $this->delete($objects[$key], $force) ? 1 : 0;
            }
            unset($objects);
            return $num;
        }

        $queryFunc = empty($force) ? "query" : "queryF";
        $sql = 'DELETE FROM ' . $this->handler->table;
        if (!empty($criteria)) {
            if (is_subclass_of($criteria, 'xmf_criteria_element')) {
                $sql .= ' ' . $criteria->renderWhere();
            } else {
                return false;
            }
        }
        if (!$this->handler->db->{$queryFunc}($sql)) {
            return false;
        }
        return $this->handler->db->getAffectedRows();
    }

    /**
     * Change a field for objects with a certain criteria
     *
     * @param   string  $fieldname  Name of the field
     * @param   mixed   $fieldvalue Value to write
     * @param   object  $criteria   {@link CriteriaElement}
     * @param   bool    $force      force to query
     *
     * @return  bool
     **/
    function updateAll($fieldname, $fieldvalue, $criteria = null, $force = false)
    {
        $set_clause = "`{$fieldname}` = ";
        if ( is_numeric( $fieldvalue ) ) {
            $set_clause .=  $fieldvalue;
        } elseif ( is_array( $fieldvalue ) ) {
            $set_clause .= $this->handler->db->quote( implode( ',', $fieldvalue ) );
        } else {
            $set_clause .= $this->handler->db->quote( $fieldvalue );
        }
        $sql = 'UPDATE `' . $this->handler->table . '` SET ' . $set_clause;
        if (isset($criteria) && is_subclass_of($criteria, 'xmf_criteria_element')) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        $queryFunc = empty($force) ? "query" : "queryF";
        $result = $this->handler->db->{$queryFunc}($sql);

        return empty($result) ? false : true;
    }
}