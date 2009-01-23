<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

if (!defined('XOOPS_ROOT_PATH')) {
	exit();
}

class MytabsPageBlock extends XoopsObject
{
    var $block;
    /**
     * constructor
     */
    function MytabsPageBlock() {
        $this->XoopsObject();
        $this->initVar("pageblockid", XOBJ_DTYPE_INT);
        $this->initVar('blockid', XOBJ_DTYPE_INT);
        $this->initVar('pageid', XOBJ_DTYPE_INT);
        $this->initVar('tabid', XOBJ_DTYPE_INT);
        $this->initVar('priority', XOBJ_DTYPE_INT, 0);
        $this->initVar('showalways', XOBJ_DTYPE_TXTBOX, 'yes');
        $this->initVar('placement', XOBJ_DTYPE_TXTBOX, 'center');
        $this->initVar('title', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('options', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('fromdate', XOBJ_DTYPE_INT);
        $this->initVar('todate', XOBJ_DTYPE_INT);
        $this->initVar('note', XOBJ_DTYPE_TXTAREA, '');
        $this->initVar('pbcachetime', XOBJ_DTYPE_INT, 0);
        $this->initVar('cachebyurl', XOBJ_DTYPE_INT, 0);
        $this->initVar('groups', XOBJ_DTYPE_ARRAY, serialize(array(XOOPS_GROUP_ANONYMOUS, XOOPS_GROUP_USERS)));
    }

    /**
     * Set block of type $blockid as this pageblock's block
     *
     * @param int $blockid
     */
    function setBlock($blockid = 0) {
        include_once(XOOPS_ROOT_PATH."/class/xoopsblock.php");
        if ($blockid == 0) {
            $this->block = new XoopsBlock($this->getVar('blockid'));
            $this->block->assignVar('options', $this->getVar('options', 'n'));
            $this->block->assignVar('title', $this->getVar('title', 'n'));
        }
        else {
            $this->block = new XoopsBlock($blockid);
            $this->block->assignVar('options', $this->block->getVar('options', 'n'));
            $this->block->assignVar('title', $this->block->getVar('title', 'n'));
        }
    }

    /**
     * Return whether this block is visible now
     *
     * @return bool
     */
    function isVisible() {
        return ($this->getVar('showalways') == "yes" || ($this->getVar('showalways') == "time" && $this->getVar('fromdate') <= time() && $this->getVar('todate') >= time()));
    }

    /**
     * Get the form for adding or editing blocks
     *
     * @return MytabsBlockForm
     */
    function getForm() {
        include_once(XOOPS_ROOT_PATH."/modules/mytabs/class/blockform.php");
        $form = new MytabsBlockForm('Block', 'blockform', 'block.php');
        $form->createElements($this);
        return $form;
    }

    /**
     * Get pageblock and block objects on array form
     *
     * @param string $format
     * @return array
     */
    function toArray($format = "s") {
        $ret = array();
        $vars = $this->getVars();
        foreach (array_keys($vars) as $key) {
            $value = $this->getVar($key, $format);
            $ret[$key] = $value;
        }

        $vars = $this->block->getVars();
        foreach (array_keys($vars) as $key) {
            $value = $this->block->getVar($key, $format);
            $ret['block'][$key] = $value;
        }

        // Special values
        $showalways = $this->getVar('showalways');
        if ($showalways == 'no'){
            $ret['unvisible'] = true;
        } elseif ($showalways == 'yes'){
            $ret['visible'] = true;
        } elseif ($showalways == 'time'){
            $check = $this->isVisible();
            if ($check){
                $ret['timebased'] = true;
            } else {
                $ret['unvisible'] = true;
            }
        }

        return $ret;
    }

    /**
     * Get content for this page block
     *
     * @param int $unique
     * @param bool $last
     * @return array
     */
    function render($template, $unique=0) {
        $block = array(
        'blockid'	=> $this->getVar( 'pageblockid' ),
        'tabid'	    => $this->getVar( 'tabid' ),
        'module'	=> $this->block->getVar( 'dirname' ),
        'title'		=> $this->getVar( 'title' ),
        'placement'	=> $this->getVar( 'placement' ),
        'weight'	=> $this->getVar( 'priority' )
        );

        $xoopsLogger =& XoopsLogger::instance();

        $bcachetime = intval( $this->getVar('pbcachetime') );
        if (empty($bcachetime)) {
            $template->caching = 0;
        } else {
            $template->caching = 2;
            $template->cache_lifetime = $bcachetime;
        }
        $tplName = ( $tplName = $this->block->getVar('template') ) ? "db:$tplName" : "db:system_block_dummy.html";

        $cacheid = 'blk_' . $this->getVar('pageblockid');

        if ($this->getVar('cachebyurl')) {
            $cacheid .= "_".md5($_SERVER['REQUEST_URI']);
        }
        if ( !$bcachetime || !$template->is_cached( $tplName, $cacheid ) ) {
            $xoopsLogger->addBlock( $this->block->getVar('title') );
            if ( ! ( $bresult = $this->block->buildBlock() ) ) {
               return false;
            }
            $template->assign( 'block', $bresult );
            $block['content'] = $template->fetch( $tplName, $cacheid );
        } else {
            $xoopsLogger->addBlock( $this->block->getVar('name'), true, $bcachetime );
            $block['content'] = $template->fetch( $tplName, $cacheid );
        }
        return $block;
    }
}

class MytabsPageBlockHandler extends XoopsObjectHandler
{
    
    function &create($isNew = true)
    {
        $pageblock = new MytabsPageBlock();
        if ($isNew) {
            $pageblock->setNew();
        }
        return $pageblock;
    }

    function &get($id)
    {
      $id = intval($id);
      $pageblock = false;
    	if ($id > 0) {
            $sql = 'SELECT * FROM '.$this->db->prefix('mytabs_pageblock').' WHERE pageblockid='.$id;
            if (!$result = $this->db->query($sql)) {
                return $pageblock;
            }
            $numrows = $this->db->getRowsNum($result);
            if ($numrows == 1) {
                $pageblock = new MytabsPageBlock();
                $pageblock->assignVars($this->db->fetchArray($result));
            }
        }
        return $pageblock;
    }

    function insert(&$pageblock)
    {
        if (!is_a($pageblock, 'mytabspageblock')) {
            return false;
        }
        if (!$pageblock->isDirty()) {
            return true;
        }
        if (!$pageblock->cleanVars()) {
            return false;
        }
        foreach ($pageblock->cleanVars as $k => $v) {
            ${$k} = $v;
        }
        if ($pageblock->isNew()) {
            $pageblockid = $this->db->genId('mytabs_pageblock_pageblockid_seq');
			$sql = sprintf("INSERT INTO %s (pageblockid, blockid, pageid, tabid, priority, placement, showalways, title, options, fromdate, todate, note, pbcachetime, cachebyurl, groups)
            VALUES (%u, %u, %u, %u, %u, %s, %s, %s, %s, %u, %u, %s, %u, %u, %s)",
            $this->db->prefix('mytabs_pageblock'), $pageblockid, $blockid, $pageid, $tabid, $priority, $this->db->quoteString($placement), $this->db->quoteString($showalways), $this->db->quoteString($title), $this->db->quoteString($options), $fromdate, $todate, $this->db->quoteString($note), $pbcachetime, $cachebyurl, $this->db->quoteString($groups));
		} else {
            $sql = sprintf("UPDATE %s SET  blockid = %u, pageid = %u, tabid = %u, priority = %u, placement = %s, showalways = %s, title = %s, options = %s, fromdate = %u, todate = %u, note = %s, pbcachetime = %u, cachebyurl = %u, groups = %s
            WHERE pageblockid = %u", $this->db->prefix('mytabs_pageblock'), $blockid, $pageid, $tabid, $priority, $this->db->quoteString($placement), $this->db->quoteString($showalways), $this->db->quoteString($title), $this->db->quoteString($options), $fromdate, $todate, $this->db->quoteString($note), $pbcachetime, $cachebyurl, $this->db->quoteString($groups), $pageblockid);
        }
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        if (empty($pageblockid)) {
            $pageblockid = $this->db->getInsertId();
        }
        $pageblock->assignVar('pageblockid', $pageblockid);
        return true;
    }


    function delete(&$pageblock)
    {
        if (!is_a($pageblock, 'mytabspageblock')) {
            return false;
        }
        $sql = sprintf("DELETE FROM %s WHERE pageblockid = %u", $this->db->prefix('mytabs_pageblock'), $pageblock->getVar('pageblockid'));
        if (!$result = $this->db->query($sql)) {
            return false;
        }
        return true;
    }

    function getObjects($criteria = null, $id_as_key = false)
    {
        $ret = array();
        $limit = $start = 0;
        $sql = 'SELECT * FROM '.$this->db->prefix('mytabs_pageblock');
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
            $pageblock = new MytabsPageBlock();
            $pageblock->assignVars($myrow);
			if (!$id_as_key) {
            	$ret[] =& $pageblock;
			} else {
				$ret[$myrow['pageblockid']] =& $pageblock;
			}
            unset($pageblock);
        }
        return $ret;
    }

    /**
     * Get all blocks for a given tabid - or all tabids
     *
     * @param int $tabid 0 = all tabids
     * @param array $locations optional parameter if you want to override auto-detection of location
     * 
     * @return array
     */
    function getBlocks($pageid = 0, $tabid = 0, $placement = '', $not_invisible = true ) {
        $blocks = array();
        $sql = "SELECT *, pb.options, pb.title FROM ".$this->db->prefix('mytabs_pageblock')." pb LEFT JOIN ".$this->db->prefix("newblocks")." b
        ON pb.blockid=b.bid
        WHERE (pb.pageid = ".$pageid.")";

        if($tabid  > 0) {
             $sql.=" AND (pb.tabid = ".$tabid.")";
        }

        if($placement != '') {
            $sql .= " AND (pb.placement = '".$placement."')";
        }

        if ($not_invisible) {
            // Only get blocks that can be visible
            $sql .= " AND (pb.showalways IN ('yes', 'time'))";
        }

        $sql .= " ORDER BY PLACEMENT, PRIORITY ASC";
        $result = $this->db->query($sql);

        if (!$result) {
            return array();
        }

        include_once(XOOPS_ROOT_PATH."/class/xoopsblock.php");
        while ($row = $this->db->fetchArray($result) ) {
            $pageblock = $this->create();
            $vars = array_keys($pageblock->getVars());
            foreach ($row as $name => $value) {
                if (in_array($name, $vars)) {
                    $pageblock->assignVar($name, $value);
                    if ($name != "options" && $name != "title") {
                        // Title and options should be set on the block
                        unset($vars[$name]);
                    }
                }
            }
            $pageblock->block = new XoopsBlock($row);
            $blocks[$pageblock->getVar('tabid')][] = $pageblock;
        }

        return $blocks;
    }

    /**
     * Insert a new page block ready to be configured
     *
     * @param int $moduleid
     * @param int $location
     * @param int $tabid
     * @param int $blockid
     * @param int $priority
     * 
     * @return MytabsPageBlock|false
     */
    function newPageBlock($pageid, $tabid, $blockid, $priority=-1) {
        if($priority==-1) {
            $priority = $this->getMaxPriority($pageid, $tabid);
        }

        $block = $this->create();
        $block->setVar('pageid', $pageid);
        $block->setVar('tabid', $tabid);
        $block->setVar('blockid', $blockid);
        $block->setVar('priority', $priority);

        if($this->insert($block)) {
            return $block;
        }
        return false;
    }

    /**
     * Get maximum priority value for a tabid
     *
     * @param int $moduleid
     * @param int $location
     * @param int $tabid
     * 
     * @return int
     */
    function getMaxPriority($pageid, $tabid) {
        $result = $this->db->query("SELECT MAX(priority) FROM ".$this->db->prefix('mytabs_pageblock')."
                WHERE pageid=".(int)$pageid."
                AND tabid=".intval($tabid));

        if($this->db->getRowsNum($result)==0) {
            $priority=1;
        }
        else {
            $row = $this->db->fetchRow($result);
            $priority = $row[0]+1;
        }
        return $priority;
    }
    

    /**
     * Get all available blocks
     *
     * @return array
     */
    function getAllBlocks() {
        $ret = array();
        $result = $this->db->query("SELECT bid, b.name as name, b.title as title, m.name as modname  FROM ".$this->db->prefix("newblocks")." b, ".$this->db->prefix("modules")." m WHERE (b.mid=m.mid) AND b.mid != ".$GLOBALS['xoopsModule']->getVar('mid')." ORDER BY modname, name");
        while (list($id, $name, $title, $modname) = $this->db->fetchRow($result)) {
            $ret[$id] = $modname." --> ".$title.' ('.$name.')';
        }
        return $ret;
    }
    
    /**
     * Get all custom blocks
     *
     * @return array
     */
    function getAllCustomBlocks() {
        $ret = array();
        $result = $this->db->query("SELECT bid, name, title FROM ".$this->db->prefix("newblocks")."  WHERE  mid = 0 ORDER BY name");
        while (list($id, $name, $title) = $this->db->fetchRow($result)) {
            $ret[$id] = $name." --> ".$title;
        }
        return $ret;
    }
}
?>
