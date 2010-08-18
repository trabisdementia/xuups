<?php
if (!defined("XOOPS_ROOT_PATH")) {
    die("Cannot access file directly");
}
require_once(XOOPS_ROOT_PATH."/modules/smartblocks/class/resolver.php");
define("_CORD_WHITEPAPER_CUSTOMER_START", 5000);
define("_CORD_WHITEPAPER_LOCATION_START", 10000);

class CordemanonResolver extends SmartblocksResolver
{
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
        if(isset($_GET["categoryid"]) && $_GET["categoryid"]) {
            return((int)$_GET["categoryid"]);
        }
        if(isset($_GET["whitepaperid"]) && $_GET["whitepaperid"]) {
            $whitepaper_handler = xoops_getmodulehandler('whitepaper', 'cordemanon');
            $whitepaper =& $whitepaper_handler->get($_GET["whitepaperid"]);
            if ($whitepaper->isActive()) {
                $category =& $whitepaper->getCategories();
                return($category[0]+_CORD_WHITEPAPER_LOCATION_START);
            }
        }

        if(strstr($_SERVER['SCRIPT_NAME'],"search.php")) {
            return -2;
        }
        if(strstr($_SERVER['SCRIPT_NAME'],"download.php")) {
            return -3;
        }

        return -1;
    }

    /**
     * Get all locations in the module
     *
     * @return array
     */
    function getLocations() {
        if(sizeof($this->pages)==0) {
            $this->pages[]=array("location"=>-1,"name"=>"Categories","level"=>0);
            $this->getPageHelper(0,0);
            $this->pages[]=array("location"=>-2,"name"=>"Search","level"=>0);
            $this->pages[]=array("location"=>-3,"name"=>"Download","level"=>0);
            $this->pages[]=array("location"=>-4,"name"=>"Whitepapers","level"=>0);
            $this->getPageHelper(0,0,_CORD_WHITEPAPER_LOCATION_START);
            $this->pages[]=array("location"=>-5,"name"=>"Customers","level"=>0);
            $this->getCustomerHelper(1,_CORD_WHITEPAPER_CUSTOMER_START);
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
        if($location==-1) {
            return("Categories");
        }
        if($location==-2) {
            return("Search");
        }
        if($location==-3) {
            return("Download");
        }
        if($location==-4) {
            return("Whitepapers");
        }
        if($location==-5) {
            return("Customers");
        }

        if ($location > _CORD_WHITEPAPER_CUSTOMER_START && $location < _CORD_WHITEPAPER_LOCATION_START) {
            $location = $location-_CORD_WHITEPAPER_CUSTOMER_START;
            $customer_handler =& xoops_getmodulehandler('customer', 'cordemanon');
            $customer = $customer_handler->get($location, false);
            return $customer['customer_name'];
        }
        elseif ($location > _CORD_WHITEPAPER_LOCATION_START) {
            $location = $location-_CORD_WHITEPAPER_LOCATION_START;
        }
        $category_handler =& xoops_getmodulehandler('category', 'cordemanon');
        $category = $category_handler->get($location, false);
        $name=$category['category_name'];


        return($name);
    }

    /**
     * Returns a list of all parent elements of the current location
     * (including the location itself)
     *
     * @param int $location
     * @return array
     */
    function getLocationPath($location) {
        if($location < 0) {
            return(array($location));
        }

        $this->locations=array();

        if ($location >= _CORD_WHITEPAPER_CUSTOMER_START && $location < _CORD_WHITEPAPER_LOCATION_START) {
            $this->locations[] = $location;
            $this->locations[] = -5;
        }
        elseif($location >= _CORD_WHITEPAPER_LOCATION_START) {
            $this->getLocationHelper((int)$location-_CORD_WHITEPAPER_LOCATION_START, _CORD_WHITEPAPER_LOCATION_START);
            $this->locations[]=-4;
        } else {
            $this->getLocationHelper((int)$location);
            $this->locations[]=-1;
        }

        return($this->locations);
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
    function getPageHelper($parentid=0,$level=0, $offset = 0) {
        $category_handler =& xoops_getmodulehandler('category', 'cordemanon');
        $criteria = new CriteriaCompo();
        $criteria->setSort('category_name');
        $category_arr =& $category_handler->getObjects($criteria);
        include_once(XOOPS_ROOT_PATH."/class/tree.php");
        $tree = new XoopsObjectTree($category_arr, 'categoryid', 'category_parent');

        $this->traversePageTree($tree, $parentid, $level, $offset);
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
    function traversePageTree($tree, $parentid=0, $level = 0, $offset = 0) {
        $categories =& $tree->getFirstChild($parentid);
        $level++;
        foreach (array_keys($categories) as $i) {
            $this->pages[] = array(   'location' => ($categories[$i]->getVar('categoryid')+$offset),
            'name' => $categories[$i]->getVar('category_name', 'n'),
            'level' => $level);
            $this->traversePageTree($tree, $categories[$i]->getVar('categoryid'), $level, $offset);
        }
    }

    /**
     * Add locations to $this->locations
     *
     * @param int $categoryid
     * @param int $offset integer to add to location
     *
     * @return void
     */
    function getLocationHelper($categoryid, $offset=0) {
        $category_handler =& xoops_getmodulehandler('category', 'cordemanon');
        $category =& $category_handler->get($categoryid);
        if(!$category->isNew()) {
            $this->locations[] = ($category->getVar('categoryid')+$offset);
            if($category->getVar('category_parent') != 0) {
                $this->getLocationHelper($category->getVar('category_parent'), $offset );
            }
        }
    }

    /**
     * Add locations for customers
     *
     * @param int $level
     * @param int $offset
     */
    function getCustomerHelper($level,$offset) {
        $customer_handler =& xoops_getmodulehandler('customer', 'cordemanon');
        $criteria = new CriteriaCompo();
        $criteria->setSort('customer_name');
        $customers =& $customer_handler->getList($criteria);
        foreach ($customers as $id => $name) {
            $this->pages[] = array(   'location' => ($id+$offset),
            'name' => $name,
            'level' => $level);
        }
    }
}

$resolver= new CordemanonResolver();
?>
