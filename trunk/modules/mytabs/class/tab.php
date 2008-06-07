<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}

class MytabsTab extends XoopsObject
{
    /**
     * constructor
     */
    function MytabsTab()
    {
        $this->XoopsObject();
        $this->initVar("tabid", XOBJ_DTYPE_INT);
        $this->initVar("tabpageid", XOBJ_DTYPE_INT);
        $this->initVar('tabtitle', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar("tabpriority", XOBJ_DTYPE_INT,0);
        $this->initVar('tabshowalways', XOBJ_DTYPE_TXTBOX, 'yes');
        $this->initVar('tabfromdate', XOBJ_DTYPE_INT);
        $this->initVar('tabtodate', XOBJ_DTYPE_INT);
        $this->initVar('tabnote', XOBJ_DTYPE_TXTAREA, '');
        $this->initVar('tabgroups', XOBJ_DTYPE_ARRAY, serialize(array(XOOPS_GROUP_ANONYMOUS, XOOPS_GROUP_USERS)));
    }

    /**
     * Return whether this block is visible now
     *
     * @return bool
     */
    function isVisible() {
        return ($this->getVar('tabshowalways') == "yes" || ($this->getVar('tabshowalways') == "time" && $this->getVar('tabfromdate') <= time() && $this->getVar('tabtodate') >= time()));
    }

     /**
     * Get the form for adding or editing tabs
     *
     * @return MytabsTabForm
     */
    function getForm() {
        include_once(XOOPS_ROOT_PATH."/modules/mytabs/class/tabform.php");
        $form = new MytabsTabForm('Tab', 'tabform', 'tab.php');
        $form->createElements($this);
        return $form;
    }

}

class MytabsTabHandler extends XoopsObjectHandler
{
    function &create($isNew = true)
    {
        $tab = new MytabsTab();
        if ($isNew) {
            $tab->setNew();
        }
        return $tab;
    }

    function &get($id)
    {
      $id = intval($id);
      $tab = false;
    	if ($id > 0) {
            $sql = 'SELECT * FROM '.$this->db->prefix('mytabs_tab').' WHERE tabid='.$id;
            if (!$result = $this->db->query($sql)) {
                return $tab;
            }
            $numrows = $this->db->getRowsNum($result);
            if ($numrows == 1) {
                $tab = new MytabsTab();
                $tab->assignVars($this->db->fetchArray($result));
            }
        }
        return $tab;
    }

    function insert(&$tab)
    {
        if (!is_a($tab, 'mytabstab')) {
            return false;
        }
        if (!$tab->isDirty()) {
            return true;
        }
        if (!$tab->cleanVars()) {
            return false;
        }
        foreach ($tab->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        if ($tab->isNew()) {
            $tabid = $this->db->genId('mytabs_tab_tabid_seq');
			$sql = sprintf("INSERT INTO %s (tabid, tabpageid, tabtitle, tabpriority, tabshowalways, tabfromdate, tabtodate, tabnote, tabgroups) VALUES (%u, %u, %s, %u, %s, %u, %u, %s, %s)", $this->db->prefix('mytabs_tab'), $tabid, $tabpageid, $this->db->quoteString($tabtitle), $tabpriority, $this->db->quoteString($tabshowalways), $tabfromdate, $tabtodate, $this->db->quoteString($tabnote), $this->db->quoteString($tabgroups));
		} else {
            $sql = sprintf("UPDATE %s SET tabpageid = %u, tabtitle = %s, tabpriority = %u, tabshowalways = %s , tabfromdate = %u, tabtodate = %u, tabnote = %s , tabgroups = %s  WHERE tabid = %u", $this->db->prefix('mytabs_tab'), $tabpageid, $this->db->quoteString($tabtitle), $tabpriority, $this->db->quoteString($tabshowalways), $tabfromdate, $tabtodate, $this->db->quoteString($tabnote), $this->db->quoteString($tabgroups), $tabid);
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        if (empty($tabid)) {
            $tabid = $this->db->getInsertId();
        }
        $tab->assignVar('tabid', $tabid);
        return true;
    }


    function delete(&$tab)
    {
        if (!is_a($tab, 'mytabstab')) {
            return false;
        }
        $sql = sprintf("DELETE FROM %s WHERE tabid = %u", $this->db->prefix('mytabs_tab'), $tab->getVar('tabid'));
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        return true;
    }

    function getObjects($criteria = null, $id_as_key = false)
    {
        $ret = array();
        $limit = $start = 0;
        $sql = 'SELECT * FROM '.$this->db->prefix('mytabs_tab');
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
            $tab = new MytabsTab();
            $tab->assignVars($myrow);
			if (!$id_as_key) {
            	$ret[] =& $tab;
			} else {
				$ret[$myrow['tabid']] =& $tab;
			}
            unset($tab);
        }
        return $ret;
    }
}

?>

