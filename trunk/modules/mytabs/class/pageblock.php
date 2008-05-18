<?php
// $Id: pageblock.php,v 1.1 2006/12/07 19:55:27 malanciault Exp $
###############################################################################
##                    XOOPS - PHP Content Management System                  ##
##                       Copyright (c) 2000 XOOPS.org                        ##
##                          <http://www.xoops.org/>                          ##
###############################################################################
##  This program is free software; you can redistribute it and/or modify     ##
##  it under the terms of the GNU General Public License as published by     ##
##  the Free Software Foundation; either version 2 of the License, or        ##
##  (at your option) any later version.                                      ##
##                                                                           ##
##  You may not change or alter any portion of this comment or credits       ##
##  of supporting developers from this source code or any supporting         ##
##  source code which is considered copyrighted (c) material of the          ##
##  original comment or credit authors.                                      ##
##                                                                           ##
##  This program is distributed in the hope that it will be useful,          ##
##  but WITHOUT ANY WARRANTY; without even the implied warranty of           ##
##  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            ##
##  GNU General Public License for more details.                             ##
##                                                                           ##
##  You should have received a copy of the GNU General Public License        ##
##  along with this program; if not, write to the Free Software              ##
##  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA ##
###############################################################################
include_once(XOOPS_ROOT_PATH."/modules/smartobject/include/common.php");
include_once(XOOPS_ROOT_PATH."/modules/smartobject/class/smartobject.php");
include_once(XOOPS_ROOT_PATH."/modules/smartobject/class/smartobjecthandler.php");
class MytabsPageBlock extends SmartObject {
    public $block;

    function __construct() {
        $this->initVar("pageblockid", XOBJ_DTYPE_INT);
        $this->initVar('blockid', XOBJ_DTYPE_INT);
        $this->initVar('pageid', XOBJ_DTYPE_INT);
        $this->initVar('tabid', XOBJ_DTYPE_INT);
        $this->initVar('priority', XOBJ_DTYPE_INT, 10);
        $this->initVar('showalways', XOBJ_DTYPE_TXTBOX, 'yes');
        $this->initVar('title', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('options', XOBJ_DTYPE_TXTBOX, '');
        $this->initVar('fromdate', XOBJ_DTYPE_INT);
        $this->initVar('todate', XOBJ_DTYPE_INT);
        $this->initVar('note', XOBJ_DTYPE_TXTAREA, '');
        $this->initVar('pbcachetime', XOBJ_DTYPE_INT, 0);
        $this->initVar('cachebyurl', XOBJ_DTYPE_INT, 0);
        $this->initVar('groups', XOBJ_DTYPE_ARRAY, array(XOOPS_GROUP_ANONYMOUS, XOOPS_GROUP_USERS));
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
        }
        else {
            $this->block = new XoopsBlock($blockid);
        }
        $this->block->assignVar('options', $this->getVar('options', 'n'));
        $this->block->assignVar('title', $this->getVar('title', 'n'));
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
        $form = new MytabsBlockForm('title', 'blockform', 'block.php');
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
        $ret['visible'] = $this->isVisible();

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
        'module'	=> $this->block->getVar( 'dirname' ),
        'title'		=> $this->getVar( 'title' ),
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
            $xoopsLogger->addBlock( $this->block->getVar('name') );
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

class MytabsPageBlockHandler extends SmartPersistableObjectHandler {
    private $blocks = array();

    function __construct($db) {
        parent::__construct($db, "pageblock", "pageblockid", "pageblock_title", "", "mytabs");
    }

    /**
     * Get all blocks for a given tabid - or all tabids
     *
     * @param int $tabid 0 = all tabids
     * @param array $locations optional parameter if you want to override auto-detection of location
     * 
     * @return array
     */
    function getBlocks($pageid = 0,  $not_invisible = true ) {

        if (count($this->blocks) == 0) {
            $sql = "SELECT *, pb.options, pb.title FROM ".$this->table." pb LEFT JOIN ".$this->db->prefix("newblocks")." b
                  ON pb.blockid=b.bid
		          WHERE (pb.pageid=".$pageid.")";

            if ($not_invisible) {
                // Only get blocks that can be visible
                $sql .= " AND pb.showalways IN ('yes', 'time')";
            }

            $sql .= " ORDER BY PRIORITY ASC";
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
                $this->blocks[$pageblock->getVar('tabid')][] = $pageblock;
            }
        }
        return /*$pageid > 0 ? (isset($this->blocks[$pageid]) ? $this->blocks[$pageid] : array() ) :*/ $this->blocks;
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
        $result = $this->db->query("SELECT MAX(priority) FROM ".$this->table."
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
        $result = $this->db->query("SELECT bid, b.name as name, m.name as modname  FROM ".$this->db->prefix("newblocks")." b, ".$this->db->prefix("modules")." m WHERE b.mid=m.mid AND b.mid != ".$GLOBALS['xoopsModule']->getVar('mid')." ORDER BY name");
        while (list($id, $name, $modname) = $this->db->fetchRow($result)) {
            $ret[$id] = $name." (".$modname.")";
        }
        return $ret;
    }
}
?>
