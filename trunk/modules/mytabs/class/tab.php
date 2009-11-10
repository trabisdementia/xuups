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
        $this->initVar('tablink', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('tabrev', XOBJ_DTYPE_TXTBOX, '');
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
    
    function getTabTitle()
    {
        $title = $this->getVar('tabtitle');

        // PM detection and conversion
        if (eregi("{pm_new}", $title) 	||
            eregi("{pm_readed}", $title) 	||
            eregi("{pm_total}", $title)) {
            if (is_object($GLOBALS['xoopsUser'])) {
                $new_messages = 0;
                $old_messages = 0;
                $som = 0;
                $user_id = 0;
                $user_id = $GLOBALS['xoopsUser']->getVar('uid');
                $pm_handler =& xoops_gethandler('privmessage');
                $criteria_new = new CriteriaCompo(new Criteria('read_msg', 0));
                $criteria_new->add(new Criteria('to_userid', $GLOBALS['xoopsUser']->getVar('uid')));
                $new_messages = $pm_handler->getCount($criteria_new);
                $criteria_old = new CriteriaCompo(new Criteria('read_msg', 1));
                $criteria_old->add(new Criteria('to_userid', $GLOBALS['xoopsUser']->getVar('uid')));
                $old_messages = $pm_handler->getCount($criteria_old);
	            $som =  $old_messages +  $new_messages;
                if ($new_messages > 0) {
                    $title = preg_replace('/\{pm_new\}/',    '(<span style="color: rgb(255, 0, 0); font-weight: bold;">'.$new_messages.'</span>)', $title);
                }
                if ($old_messages > 0) {
                    $title = preg_replace('/\{pm_readed\}/', '(<span style="color: rgb(255, 0, 0); font-weight: bold;">'.$old_messages.'</span>)', $title);
                }
                if ($old_messages > 0) {
                    $title = preg_replace('/\{pm_total\}/',  '(<span style="color: rgb(255, 0, 0); font-weight: bold;">'.$som.'</span>)'         , $title);
                }
            }
            $title = preg_replace('/\{pm_new\}/',    '', $title);
            $title = preg_replace('/\{pm_readed\}/', '', $title);
            $title = preg_replace('/\{pm_total\}/',  '', $title);
	    }
        return trim($title);
    }

    function getTabLink()
    {
        $link = $this->getVar('tablink');
        if ($link == '') return $link;
        
        $user_id = $GLOBALS['xoopsUser'] ? $GLOBALS['xoopsUser']->getVar('uid') : 0;
        // Link type, taken from multimenu module
        if ((eregi("mailto:", $link))  ||
            (eregi("http://", $link))  ||
            (eregi("https://", $link)) ||
            (eregi("file://", $link))  ||
            (eregi("ftp://", $link))){

            $link = preg_replace('/\{user_id\}/', $user_id, $link);
        } else {
            $link = XOOPS_URL."/".$link;
            $link = preg_replace('/\{user_id\}/', $user_id, $link);
        }

        return $link;
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
			$sql = sprintf("INSERT INTO %s (tabid, tabpageid, tabtitle, tablink, tabrev, tabpriority, tabshowalways, tabfromdate, tabtodate, tabnote, tabgroups) VALUES (%u, %u, %s, %s, %s, %u, %s, %u, %u, %s, %s)", $this->db->prefix('mytabs_tab'), $tabid, $tabpageid, $this->db->quoteString($tabtitle), $this->db->quoteString($tablink), $this->db->quoteString($tabrev), $tabpriority, $this->db->quoteString($tabshowalways), $tabfromdate, $tabtodate, $this->db->quoteString($tabnote), $this->db->quoteString($tabgroups));
		} else {
            $sql = sprintf("UPDATE %s SET tabpageid = %u, tabtitle = %s,  tablink = %s, tabrev = %s, tabpriority = %u, tabshowalways = %s , tabfromdate = %u, tabtodate = %u, tabnote = %s , tabgroups = %s  WHERE tabid = %u", $this->db->prefix('mytabs_tab'), $tabpageid, $this->db->quoteString($tabtitle), $this->db->quoteString($tablink), $this->db->quoteString($tabrev), $tabpriority, $this->db->quoteString($tabshowalways), $tabfromdate, $tabtodate, $this->db->quoteString($tabnote), $this->db->quoteString($tabgroups), $tabid);
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

