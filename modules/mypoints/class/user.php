<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}

class MypointsUser extends XoopsObject
{
    /**
     * constructor
     */
    function MypointsUser()
    {
        $this->XoopsObject();
        $this->initVar("useruid", XOBJ_DTYPE_INT, 0);
        $this->initVar('useruname', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar("userpoints", XOBJ_DTYPE_INT,0);
    }
}

class MypointsUserHandler extends XoopsObjectHandler
{

    /**
     * Create a {@link XoopsUser}
     * 
     * @param	bool    $isNew  Flag the object as "new"?
     * 
     * @return	object
     */
    function &create($isNew = true)
    {
        $user = new MypointsUser();
        if ($isNew) {
            $user->setNew();
        }
        return $user;
    }

    /**
     * Retrieve a {@link XoopsUser}
     * 
     * @param   int $id ID
     * 
     * @return  object  {@link XoopsUser}, FALSE on fail
     **/
    function &get($id)
    {
        $user = false;
    	$id = intval($id);
        if ($id >= 0) {
            $sql = 'SELECT * FROM '.$this->db->prefix('mypoints_user').' WHERE useruid='.$id;
            if (!$result = $this->db->query($sql)) {
                return $user;
            }
            $numrows = $this->db->getRowsNum($result);
            if ($numrows == 1) {
                $user = new MypointsUser();
                $user->assignVars($this->db->fetchArray($result));
            }
        }
        return $user;
    }

    /**
     * Write a User to database
     * 
     * @param   object  &$user
     * 
     * @return  bool
     **/
    function insert(&$user)
    {
        if (strtolower(get_class($user)) != 'mypointsuser') {
            return false;
        }
        if (!$user->isDirty()) {
            return true;
        }
        if (!$user->cleanVars()) {
            return false;
        }
        foreach ($user->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        if ($user->isNew()) {
            //$useruid = $this->db->genId('mypoints_user_useruid_seq');
            $sql = sprintf("INSERT INTO %s (useruid, useruname, userpoints) VALUES (%u, %s, %u)", $this->db->prefix('mypoints_user'), $useruid, $this->db->quoteString($useruname), $userpoints);
        } else {
            $sql = sprintf("UPDATE %s SET useruname = %s, userpoints = %u WHERE useruid = %u", $this->db->prefix('mypoints_user'), $this->db->quoteString($useruname), $userpoints, $useruid);
        }
        if (!$result = $this->db->queryF($sql)) {
            return false;
        }
        /*if (empty($useruid)) {
            $useruid = $this->db->getInsertId();
        }
        $user->assignVar('useruid', $useruid);  */
        return true;
    }

    /**
     * Delete a {@link MypointsUser} from the database
     * 
     * @param   object  &$user
     * 
     * @return  bool
     **/
    function delete(&$user)
    {
        if (strtolower(get_class($user)) != 'mypointsuser') {
            return false;
        }
        $sql = sprintf("DELETE FROM %s WHERE useruid = %u", $this->db->prefix('mypoints_user'), $user->getVar('useruid'));
        if (!$result = $this->db->queryF($sql)) {
            return false;
        }
        return true;
    }

    /**
     * Get some {@link MypointsUser}s
     * 
     * @param   object  $criteria
     * @param   bool    $id_as_key  Use IDs as keys into the array?
     * 
     * @return  array   Array of {@link MypointsUser} objects
     **/
    function getObjects($criteria = null, $id_as_key = false)
    {
        $ret = array();
        $limit = $start = 0;
        $sql = 'SELECT * FROM '.$this->db->prefix('mypoints_user');
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
            $user = new MypointsUser();
            $user->assignVars($myrow);
			if (!$id_as_key) {
            	$ret[] =& $user;
			} else {
				$ret[$myrow['useruid']] =& $user;
			}
            unset($user);
        }
        return $ret;
    }
    /**
     * Count Users
     * 
     * @param   object  $criteria   {@link CriteriaElement} 
     * 
     * @return  int     Count
     **/
    function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('mypoints_user');
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
     * Delete multiple Users
     * 
     * @param   object  $criteria   {@link CriteriaElement} 
     * 
     * @return  bool
     **/
    function deleteAll($criteria = null)
    {
        $sql = 'DELETE FROM '.$this->db->prefix('mypoints_user');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
        }
        if (!$result = $this->db->queryF($sql)) {
            return false;
        }
        return true;
    }

   /**
     * Get a list of Users
     * 
     * @param   object  $criteria   {@link CriteriaElement} 
     * 
     * @return  array   Array of raw database records
     **/
    function getList($criteria = null)
    {
        $users = $this->getObjects($criteria, true);
        $ret = array();
        foreach (array_keys($users) as $i) {
            $ret[$i] = $users[$i]->getVar('useruname');
        }
        return $ret;
    }

    /**
     * Update
     * 
     * @param   object  &$user       {@link XoopsUser} object
     * @param   string  $field_name     Name of the field
     * @param   mixed   $field_value    Value to write
     * 
     * @return  bool
     **/
    function updateByField(&$user, $field_name, $field_value)
    {
        $user->unsetNew();
        $user->setVar($field_name, $field_value);
        return $this->insert($user);
    }

}
?>
