<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}

class MypointsRelation extends XoopsObject
{
    /**
     * constructor
     */
    function MypointsRelation()
    {
        $this->XoopsObject();
        $this->initVar("relationid", XOBJ_DTYPE_INT);
        $this->initVar("relationuid", XOBJ_DTYPE_INT);
        $this->initVar("relationpid", XOBJ_DTYPE_INT);
        $this->initVar("relationpoints", XOBJ_DTYPE_INT);
    }
}

class MypointsRelationHandler extends XoopsObjectHandler
{

    /**
     * Create a {@link Xoopsrelation}
     *
     * @param	bool    $isNew  Flag the object as "new"?
     *
     * @return	object
     */
    function &create($isNew = true)
    {
        $relation = new MypointsRelation();
        if ($isNew) {
            $relation->setNew();
        }
        return $relation;
    }

    /**
     * Retrieve a {@link Xoopsrelation}
     *
     * @param   int $id ID
     *
     * @return  object  {@link Xoopsrelation}, FALSE on fail
     **/
    function &get($id)
    {
        $relation = false;
    	$id = intval($id);
        if ($id > 0) {
            $sql = 'SELECT * FROM '.$this->db->prefix('mypoints_relation').' WHERE relationid='.$id;
            if (!$result = $this->db->query($sql)) {
                return $relation;
            }
            $numrows = $this->db->getRowsNum($result);
            if ($numrows == 1) {
                $relation = new MypointsRelation();
                $relation->assignVars($this->db->fetchArray($result));
            }
        }
        return $relation;
    }
    
    function &getByPluginUid($pid , $uid)
    {
        $relation = false;
    	$pid = intval($pid);
    	$uid = intval($uid);
        $sql = 'SELECT * FROM '.$this->db->prefix('mypoints_relation').' WHERE relationpid='.$pid.' AND relationuid='.$uid;
        if (!$result = $this->db->query($sql)) {
            return $relation;
        }
        $numrows = $this->db->getRowsNum($result);
        if ($numrows == 1) {
            $relation = new MypointsRelation();
            $relation->assignVars($this->db->fetchArray($result));
        }
        return $relation;
    }

    /**
     * Write a relation to database
     *
     * @param   object  &$relation
     *
     * @return  bool
     **/
    function insert(&$relation)
    {
        if (strtolower(get_class($relation)) != 'mypointsrelation') {
            return false;
        }
        if (!$relation->isDirty()) {
            return true;
        }
        if (!$relation->cleanVars()) {
            return false;
        }
        foreach ($relation->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        if ($relation->isNew()) {
            $relationid = $this->db->genId('mypoints_relation_relationid_seq');
            $sql = sprintf("INSERT INTO %s (relationid, relationuid, relationpid, relationpoints) VALUES (%u, %u, %u, %u)", $this->db->prefix('mypoints_relation'), $relationid, $relationuid, $relationpid, $relationpoints);
        } else {
            $sql = sprintf("UPDATE %s SET relationuid = %u, relationpid = %u, relationpoints = %u WHERE relationid = %u", $this->db->prefix('mypoints_relation'),  $relationuid, $relationpid, $relationpoints, $relationid);
        }
        if (!$result = $this->db->queryF($sql)) {
            return false;
        }
        if (empty($relationid)) {
            $relationid = $this->db->getInsertId();
        }
        $relation->assignVar('relationid', $relationid);
        return true;
    }

    /**
     * Delete a {@link Mypointsrelation} from the database
     *
     * @param   object  &$relation
     *
     * @return  bool
     **/
    function delete(&$relation)
    {
        if (strtolower(get_class($relation)) != 'mypointsrelation') {
            return false;
        }
        $sql = sprintf("DELETE FROM %s WHERE relationid = %u", $this->db->prefix('mypoints_relation'), $relation->getVar('relationid'));
        if (!$result = $this->db->queryF($sql)) {
            return false;
        }
        return true;
    }

    /**
     * Get some {@link Mypointsrelation}s
     *
     * @param   object  $criteria
     * @param   bool    $id_as_key  Use IDs as keys into the array?
     *
     * @return  array   Array of {@link Mypointsrelation} objects
     **/
    function getObjects($criteria = null, $id_as_key = false)
    {
        $ret = array();
        $limit = $start = 0;
        $sql = 'SELECT * FROM '.$this->db->prefix('mypoints_relation');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
            if ($criteria->getSort() != '') {
                $sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $this->db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }
        while ($myrow = $this->db->fetchArray($result)) {
            $relation = new MypointsRelation();
            $relation->assignVars($myrow);
			if (!$id_as_key) {
            	$ret[] =& $relation;
			} else {
				$ret[$myrow['relationid']] =& $relation;
			}
            unset($relation);
        }
        return $ret;
    }
    /**
     * Count relations
     *
     * @param   object  $criteria   {@link CriteriaElement}
     *
     * @return  int     Count
     **/
    function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('mypoints_relation');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
        }
        if (!$result =& $this->db->query($sql)) {
            return 0;
        }
        list($count) = $this->db->fetchRow($result);
        return $count;
    }

    /**
     * Delete multiple relations
     *
     * @param   object  $criteria   {@link CriteriaElement}
     *
     * @return  bool
     **/
    function deleteAll($criteria = null)
    {
        $sql = 'DELETE FROM '.$this->db->prefix('mypoints_relation');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
        }
        if (!$result = $this->db->queryF($sql)) {
            return false;
        }
        return true;
    }

   /**
     * Get a list of relations
     *
     * @param   object  $criteria   {@link CriteriaElement}
     *
     * @return  array   Array of raw database records
     **/
    function getList($criteria = null)
    {
        $relations = $this->getObjects($criteria, true);
        $ret = array();
        foreach (array_keys($relations) as $i) {
            $ret[$i] = $relations[$i]->getVar('relationpid');
        }
        return $ret;
    }

    /**
     * Update
     *
     * @param   object  &$relation       {@link Xoopsrelation} object
     * @param   string  $field_name     Name of the field
     * @param   mixed   $field_value    Value to write
     *
     * @return  bool
     **/
    function updateByField(&$relation, $field_name, $field_value)
    {
        $relation->unsetNew();
        $relation->setVar($field_name, $field_value);
        return $this->insert($relation);
    }
}
?>
