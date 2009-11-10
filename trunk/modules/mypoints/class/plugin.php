<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}

class Mypointsplugin extends XoopsObject
{
    /**
     * constructor
     */
    function Mypointsplugin()
    {
        $this->XoopsObject();
        $this->initVar("pluginid", XOBJ_DTYPE_INT);
        $this->initVar("pluginmid", XOBJ_DTYPE_INT);
        $this->initVar('pluginname', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('plugintype', XOBJ_DTYPE_TXTBOX, 'items');
        $this->initVar("pluginmulti", XOBJ_DTYPE_INT,1);
        $this->initVar("pluginisactive", XOBJ_DTYPE_INT,1);
    }
}

class MypointspluginHandler extends XoopsObjectHandler
{

    /**
     * Create a {@link Xoopsplugin}
     *
     * @param	bool    $isNew  Flag the object as "new"?
     *
     * @return	object
     */
    function &create($isNew = true)
    {
        $plugin = new Mypointsplugin();
        if ($isNew) {
            $plugin->setNew();
        }
        return $plugin;
    }

    /**
     * Retrieve a {@link Xoopsplugin}
     *
     * @param   int $id ID
     *
     * @return  object  {@link Xoopsplugin}, FALSE on fail
     **/
    function &get($id)
    {
        $plugin = false;
    	$id = intval($id);
        if ($id > 0) {
            $sql = 'SELECT * FROM '.$this->db->prefix('mypoints_plugin').' WHERE pluginid='.$id;
            if (!$result = $this->db->query($sql)) {
                return $plugin;
            }
            $numrows = $this->db->getRowsNum($result);
            if ($numrows == 1) {
                $plugin = new Mypointsplugin();
                $plugin->assignVars($this->db->fetchArray($result));
            }
        }
        return $plugin;
    }

    /**
     * Write a plugin to database
     *
     * @param   object  &$plugin
     *
     * @return  bool
     **/
    function insert(&$plugin)
    {
        if (strtolower(get_class($plugin)) != 'mypointsplugin') {
            return false;
        }
        if (!$plugin->isDirty()) {
            return true;
        }
        if (!$plugin->cleanVars()) {
            return false;
        }
        foreach ($plugin->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        if ($plugin->isNew()) {
            $pluginid = $this->db->genId('mypoints_plugin_pluginid_seq');
            $sql = sprintf("INSERT INTO %s (pluginid, pluginmid, pluginname, plugintype, pluginmulti, pluginisactive) VALUES (%u, %u, %s, %s, %u, %u)", $this->db->prefix('mypoints_plugin'), $pluginid, $pluginmid, $this->db->quoteString($pluginname), $this->db->quoteString($plugintype), $pluginmulti, $pluginisactive);
        } else {
            $sql = sprintf("UPDATE %s SET pluginmid = %u, pluginname = %s,plugintype = %s, pluginmulti = %u, pluginisactive = %u WHERE pluginid = %u", $this->db->prefix('mypoints_plugin'), $pluginmid, $this->db->quoteString($pluginname), $this->db->quoteString($plugintype), $pluginmulti, $pluginisactive, $pluginid);
        }
        if (!$result = $this->db->queryF($sql)) {
            return false;
        }
        if (empty($pluginid)) {
            $pluginid = $this->db->getInsertId();
        }
        $plugin->assignVar('pluginid', $pluginid);
        return true;
    }

    /**
     * Delete a {@link Mypointsplugin} from the database
     *
     * @param   object  &$plugin
     *
     * @return  bool
     **/
    function delete(&$plugin)
    {
        if (strtolower(get_class($plugin)) != 'mypointsplugin') {
            return false;
        }
        $sql = sprintf("DELETE FROM %s WHERE pluginid = %u", $this->db->prefix('mypoints_plugin'), $plugin->getVar('pluginid'));
        if (!$result = $this->db->queryF($sql)) {
            return false;
        }
        return true;
    }

    /**
     * Get some {@link Mypointsplugin}s
     *
     * @param   object  $criteria
     * @param   bool    $id_as_key  Use IDs as keys into the array?
     *
     * @return  array   Array of {@link Mypointsplugin} objects
     **/
    function getObjects($criteria = null, $id_as_key = false)
    {
        $ret = array();
        $limit = $start = 0;
        $sql = 'SELECT * FROM '.$this->db->prefix('mypoints_plugin');
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
            $plugin = new Mypointsplugin();
            $plugin->assignVars($myrow);
			if (!$id_as_key) {
            	$ret[] =& $plugin;
			} else {
				$ret[$myrow['pluginid']] =& $plugin;
			}
            unset($plugin);
        }
        return $ret;
    }
    /**
     * Count plugins
     *
     * @param   object  $criteria   {@link CriteriaElement}
     *
     * @return  int     Count
     **/
    function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('mypoints_plugin');
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
     * Delete multiple plugins
     *
     * @param   object  $criteria   {@link CriteriaElement}
     *
     * @return  bool
     **/
    function deleteAll($criteria = null)
    {
        $sql = 'DELETE FROM '.$this->db->prefix('mypoints_plugin');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
        }
        if (!$result = $this->db->queryF($sql)) {
            return false;
        }
        return true;
    }

   /**
     * Get a list of plugins
     *
     * @param   object  $criteria   {@link CriteriaElement}
     *
     * @return  array   Array of raw database records
     **/
    function getList($criteria = null)
    {
        $plugins = $this->getObjects($criteria, true);
        $ret = array();
        foreach (array_keys($plugins) as $i) {
            $ret[$i] = $plugins[$i]->getVar('pluginmid');
        }
        return $ret;
    }

    /**
     * Update
     *
     * @param   object  &$plugin       {@link Xoopsplugin} object
     * @param   string  $field_name     Name of the field
     * @param   mixed   $field_value    Value to write
     *
     * @return  bool
     **/
    function updateByField(&$plugin, $field_name, $field_value)
    {
        $plugin->unsetNew();
        $plugin->setVar($field_name, $field_value);
        return $this->insert($plugin);
    }
    
    function &getByModuleType($mid, $type)
    {
        $plugin = false;
    	$mid = intval($mid);
        if ($mid > 0) {
            $sql = 'SELECT * FROM '.$this->db->prefix('mypoints_plugin').' WHERE pluginmid='.$mid.' AND plugintype='.$this->db->quoteString($type);
            if (!$result = $this->db->query($sql)) {
                return $plugin;
            }
            $numrows = $this->db->getRowsNum($result);
            if ($numrows == 1) {
                $plugin = new Mypointsplugin();
                $plugin->assignVars($this->db->fetchArray($result));
            }
        }
        return $plugin;
    }
}
?>
