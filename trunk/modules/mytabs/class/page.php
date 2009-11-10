<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}

class MytabsPage extends XoopsObject
{
    /**
     * constructor
     */
    function MytabsPage()
    {
        $this->XoopsObject();
        $this->initVar("pageid", XOBJ_DTYPE_INT);
        $this->initVar('pagetitle', XOBJ_DTYPE_TXTBOX, '');
    }
      /**
     * Get the form for adding or editing pages
     *
     * @return MytabsPageForm
     */
    function getForm() {
        include_once(XOOPS_ROOT_PATH."/modules/mytabs/class/pageform.php");
        $form = new MytabsPageForm('Page', 'pageform', 'page.php');
        $form->createElements($this);
        return $form;
    }
}

class MytabsPageHandler extends XoopsObjectHandler
{
    function &create($isNew = true)
    {
        $page = new MytabsPage();
        if ($isNew) {
            $page->setNew();
        }
        return $page;
    }

    function &get($id)
    {
      $id = intval($id);
      $page = false;
    	if ($id > 0) {
            $sql = 'SELECT * FROM '.$this->db->prefix('mytabs_page').' WHERE pageid='.$id;
            if (!$result = $this->db->query($sql)) {
                return $page;
            }
            $numrows = $this->db->getRowsNum($result);
            if ($numrows == 1) {
                $page = new MytabsPage();
                $page->assignVars($this->db->fetchArray($result));
            }
        }
        return $page;
    }

    function insert(&$page)
    {
        if (!is_a($page, 'mytabspage')) {
            return false;
        }
        if (!$page->isDirty()) {
            return true;
        }
        if (!$page->cleanVars()) {
            return false;
        }
        foreach ($page->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        if ($page->isNew()) {
            $pageid = $this->db->genId('mytabs_page_pageid_seq');
			$sql = sprintf("INSERT INTO %s (pageid, pagetitle) VALUES (%u, %s)", $this->db->prefix('mytabs_page'), $pageid, $this->db->quoteString($pagetitle));
		} else {
            $sql = sprintf("UPDATE %s SET pagetitle = %s WHERE pageid = %u", $this->db->prefix('mytabs_page'), $this->db->quoteString($pagetitle), $pageid);
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        if (empty($pageid)) {
            $pageid = $this->db->getInsertId();
        }
        $page->assignVar('pageid', $pageid);
        return true;
    }


    function delete(&$page)
    {
        if (!is_a($page, 'mytabspage')) {
            return false;
        }
        $sql = sprintf("DELETE FROM %s WHERE pageid = %u", $this->db->prefix('mytabs_page'), $page->getVar('pageid'));
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        return true;
    }

    function getObjects($criteria = null, $id_as_key = false)
    {
        $ret = array();
        $limit = $start = 0;
        $sql = 'SELECT * FROM '.$this->db->prefix('mytabs_page');
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
            $page = new MytabsPage();
            $page->assignVars($myrow);
			if (!$id_as_key) {
            	$ret[] =& $page;
			} else {
				$ret[$myrow['pageid']] =& $page;
			}
            unset($page);
        }
        return $ret;
    }
}

?>
