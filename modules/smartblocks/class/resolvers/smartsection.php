<?php
if (!defined("XOOPS_ROOT_PATH")) {
    die("Cannot access file directly");
}
require_once(XOOPS_ROOT_PATH."/modules/smartblocks/class/resolver.php");
class SmartSectionResolver extends SmartblocksResolver {
    var	$locations;
    var	$pages;

    function __construct() {
        $this->pages=array();
    }

    /**
     * Return location ID (category ID)
     *
     * @return int
     */
    function resolveLocation() {
        if(strstr($_SERVER['SCRIPT_NAME'],"item.php")) {
            $myts =& MyTextSanitizer::getInstance();
            $page_handler = xoops_getmodulehandler('item', 'smartsection');
            $page = $page_handler->get($_REQUEST['itemid']);
            return $page->getVar('categoryid');
        }
        elseif (strstr($_SERVER['SCRIPT_NAME'], "category.php")) {
            return intval($_GET['categoryid']);
        }

        return 0;
    }

    /**
     * Get all locations in the module
     *
     * @return array
     */
    function getLocations() {
        if(sizeof($this->pages)==0) {
            $this->getPageHelper(0,0);
        }
        return($this->pages);
    }


    /**
     * Return the name of a location
     *
     * @param int $location
     * @return string
     */
    function getLocationName($location) {
        $cat_handler =& xoops_getmodulehandler('category', 'smartsection');
        $cat = $cat_handler->get($location);
        return $cat->getVar('name');
    }

    /**
     * Returns a list of all parent elements of the current location
     * (including the location itself)
     *
     * @param int $location
     * @return array
     */
    function getLocationPath($location) {
        $this->locations = array();
        $this->getLocationHelper($location);
        return $this->locations;
    }

    /**
     * Private helper functions for traversing the category tree
     *
     * @param int $parentid ID to start from
     * @param int $level used in recursions
     * @param int $offset integer added to location
     *
     * @return void
     */
    function getPageHelper($parentid=0,$level=0) {
        $cat_handler =& xoops_getmodulehandler('category', 'smartsection');
        $criteria = new CriteriaCompo();
        $criteria->setSort('name');
        $cat_arr =& $cat_handler->getObjects($criteria);
        include_once(XOOPS_ROOT_PATH."/class/tree.php");
        $tree = new XoopsObjectTree($cat_arr, 'categoryid', 'parentid');

        $this->traversePageTree($tree, $parentid, $level);
    }

    /**
     * Add pages to $this->pages from a category tree
     *
     * @param XoopsObjectTree $tree
     * @param int $parentid key to start from
     * @param int $level
     * @param int $offset integer added to location
     *
     * @return void
     */
    function traversePageTree($tree, $parentid=0, $level = 0) {
        $pages =& $tree->getFirstChild($parentid);
        $level++;
        foreach (array_keys($pages) as $i) {
            $this->pages[] = array(   'location' => ($pages[$i]->getVar('categoryid')),
                                      'name' => $pages[$i]->getVar('name', 'n'),
                                      'level' => $level);
            $this->traversePageTree($tree, $pages[$i]->getVar('categoryid'), $level);
        }
    }

    /**
     * Add locations to $this->locations
     *
     * @param int $page_id
     * @param int $offset integer to add to location
     *
     * @return void
     */
    function getLocationHelper($cat_id) {
        $cat_handler =& xoops_getmodulehandler('category', 'smartsection');
        $cat =& $cat_handler->get($cat_id);
        if(is_object($cat) && !$cat->isNew()) {
            $this->locations[] = $cat->getVar('categoryid');
            if($page->getVar('parentid') != 0) {
                $this->getLocationHelper($page->getVar('parentid') );
            }
        }
    }
}

$resolver=& new SmartSectionResolver();
?>
