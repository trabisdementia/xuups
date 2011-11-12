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
 * @package         Mytabs
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: pageblock.php 0 2009-11-14 18:47:04Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");

class MytabsPageBlock extends XoopsObject
{
    var $block;
    /**
     * constructor
     */
    function MytabsPageBlock()
    {
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
    function setBlock($blockid = 0)
    {
        include_once XOOPS_ROOT_PATH . '/class/xoopsblock.php';
        if ($blockid == 0) {
            $this->block = new XoopsBlock($this->getVar('blockid'));
            $this->block->assignVar('options', $this->getVar('options', 'n'));
            $this->block->assignVar('title', $this->getVar('title', 'n'));
        } else {
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
    function isVisible()
    {
        return ($this->getVar('showalways') == "yes" || ($this->getVar('showalways') == "time" && $this->getVar('fromdate') <= time() && $this->getVar('todate') >= time()));
    }

    /**
     * Get the form for adding or editing blocks
     *
     * @return MytabsBlockForm
     */
    function getForm()
    {
        include_once XOOPS_ROOT_PATH . '/modules/mytabs/class/form/block.php';
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
    function toArray($format = "s")
    {
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
    function render($template, $unique = 0)
    {
        $block = array('blockid'   => $this->getVar('pageblockid'),
                       'tabid'     => $this->getVar('tabid'),
                       'module'    => $this->block->getVar('dirname'),
                       'title'     => $this->getVar('title'),
                       'placement' => $this->getVar('placement'),
                       'weight'    => $this->getVar('priority')
        );

        $xoopsLogger = XoopsLogger::getInstance();

        $bcachetime = intval( $this->getVar('pbcachetime') );
        if (empty($bcachetime)) {
            $template->caching = 0;
        } else {
            $template->caching = 2;
            $template->cache_lifetime = $bcachetime;
        }
        $tplName = ($tplName = $this->block->getVar('template')) ? "db:$tplName" : "db:system_block_dummy.html";

        $cacheid = 'blk_' . $this->getVar('pageblockid');

        if ($this->getVar('cachebyurl')) {
            $cacheid .= "_" . md5($_SERVER['REQUEST_URI']);
        }

        if (!$bcachetime || !$template->is_cached($tplName, $cacheid)) {
            $xoopsLogger->addBlock( $this->block->getVar('title') );
            if (!($bresult = $this->block->buildBlock())) {
                return false;
            }
            $template->assign('block', $bresult);
            $block['content'] = $template->fetch($tplName, $cacheid);
        } else {
            $xoopsLogger->addBlock($this->block->getVar('name'), true, $bcachetime);
            $block['content'] = $template->fetch($tplName, $cacheid);
        }
        return $block;
    }
}

class MytabsPageBlockHandler extends XoopsPersistableObjectHandler
{
    /**
     * constructor
     */
    function __construct(&$db)
    {
        parent::__construct($db, "mytabs_pageblock", 'MytabsPageBlock', "pageblockid", "title");
    }

    /**
     * Get all blocks for a given tabid - or all tabids
     *
     * @param int $tabid 0 = all tabids
     * @param array $locations optional parameter if you want to override auto-detection of location
     *
     * @return array
     */
    function getBlocks($pageid = 0, $tabid = 0, $placement = '', $remove = '', $not_invisible = true)
    {
        $blocks = array();
        $sql = "SELECT *, pb.options, pb.title FROM "
        . $this->db->prefix('mytabs_pageblock')
        . " pb LEFT JOIN "
        . $this->db->prefix("newblocks")
        ." b ON pb.blockid=b.bid WHERE (pb.pageid = " . $pageid . ")";

        if ($tabid > 0) {
            $sql .=" AND (pb.tabid = " . $tabid . ")";
        }

        if ($remove != '') {
            $sql .= " AND (pb.options NOT LIKE '%|" . $remove . "|%')";
        }

        if($placement != '') {
            $sql .= " AND (pb.placement = '" . $placement . "')";
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

        include_once XOOPS_ROOT_PATH . '/class/xoopsblock.php';

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
    function newPageBlock($pageid, $tabid, $blockid, $priority = -1)
    {
        if($priority == -1) {
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
    function getMaxPriority($pageid, $tabid)
    {
        $result = $this->db->query("
            SELECT MAX(priority) FROM "
            . $this->db->prefix('mytabs_pageblock')
            . "WHERE pageid=" . intval($pageid)
            . "AND tabid=" . intval($tabid));

            if ($this->db->getRowsNum($result) == 0) {
                $priority = 1;
            } else {
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
    function getAllBlocks()
    {
        $ret = array();
        $result = $this->db->query(
            "SELECT bid, b.name as name, b.title as title, m.name as modname  FROM "
            . $this->db->prefix("newblocks")
            . " b, "
            . $this->db->prefix("modules")
            . " m WHERE (b.mid=m.mid) ORDER BY modname, name");

            while (list($id, $name, $title, $modname) = $this->db->fetchRow($result)) {
                $ret[$id] = $modname . ' --> ' . $title . ' ('.$name.')';
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
        $result = $this->db->query("
            SELECT bid, name, title FROM "
            . $this->db->prefix("newblocks")
            . "  WHERE  mid = 0 ORDER BY name");

            while (list($id, $name, $title) = $this->db->fetchRow($result)) {
                $ret[$id] = $name . " --> " . $title;
            }
            return $ret;
    }
}
?>