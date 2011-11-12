<?php

class SmartblocksResolver
{
    var $moduleid;
    var $directory;
    var $name;
    /**
     * Resolves the current location within the module
     *
     * @return int
     */
    function resolveLocation() {
        return is_object($GLOBALS['xoopsModule']) ? $GLOBALS['xoopsModule']->getVar('mid') : 0;
    }

    /**
     * Returns array of location, each item is an array containing:
     * location - numerical identifier
     * name     - logical name
     * level    - How deep the rabbit hole went
     *
     * @return array
     */
    function getAllLocations() {
        $locations = $this->getLocations();
        //        array_unshift($locations, 0);

        return $locations;
    }

    /**
     * Get the name of a location
     *
     * @param int $location
     *
     * @return string
     */
    function getLocation($location) {
        if ($location == 0) {
            return $this->name;
        }
        return $this->getLocationName($location);
    }

    /**
     * Returns a list of all parent elements of the current location
     * (including the location itself)
     *
     * @param int $location
     *
     * @return array
     */
    function getLocationParentPath($location) {
        if ($location != 0) {
            $ret = $this->getLocationPath($location);
        }
        $ret[] = 0;
        return $ret;
    }

    function getLocations() {
        return array();
    }

    function getLocationName() {
        return "";
    }

    function getLocationPath($location) {
        return array();
    }
}

class SmartblocksResolverHandler
{
    var	$resolvers=array();
    var $module = null;
    var $locations = array();
    var $db;

    function __construct($db) {
        $this->db = $db;
    }

    /**
     * Scan for resolvers
     *
     */
    function loadResolvers()
    {
        global $xoopsConfig;
        $module_handler=&xoops_gethandler('module');

        $criteria = new CriteriaCompo(new Criteria('isactive', 1));
        $criteria->add(new Criteria('hasmain', 1));
        $modules=&$module_handler->getObjects($criteria,true);

        foreach($modules as $mid=>$module) {
            if (file_exists(XOOPS_ROOT_PATH."/modules/".$module->getVar('dirname')."/class/resolver.php")) {
                require_once(XOOPS_ROOT_PATH."/modules/".$module->getVar('dirname')."/class/resolver.php");
            }
            elseif(file_exists(XOOPS_ROOT_PATH."/modules/smartblocks/class/resolvers/".$module->getVar('dirname').".php")) {
                require_once(XOOPS_ROOT_PATH."/modules/smartblocks/class/resolvers/".$module->getVar('dirname').".php");
            }
            else {
                $resolver = new SmartblocksResolver();
            }
            $resolver->directory = $module->getVar('dirname');
            $resolver->moduleid = $module->getVar("mid");
            $resolver->name = $module->getVar("name");

            $this->resolvers[$module->getVar('dirname')] = $resolver;
        }
    }

    /**
     * Get a resolver from a module ID
     *
     * @param int $moduleid
     * @return SmartblocksResolver
     */
    function getResolverById($moduleid) {
        if ($moduleid > 0) {
            $this->getResolvers();
            foreach (array_keys($this->resolvers) as $i) {
                if($this->resolvers[$i]->moduleid == $moduleid) {
                    return($this->resolvers[$i]);
                }
            }
        }
        else {
            $resolver = new SmartblocksResolver();
            return $resolver;
        }

        return(0);
    }

    /**
     * Get resolver from a module directory
     *
     * @param string $directory
     * @return SmartblocksResolver
     */
    function getResolverByDirectory($directory) {
        $this->getResolvers();
        return($this->resolvers[$directory]);

    }

    /**
     * Get loaded resolvers
     *
     * @return array
     */
    function getResolvers() {
        if (count($this->resolvers) == 0) {
            $this->loadResolvers();
        }
        return($this->resolvers);
    }

    /**
     * Resolve current location, i.e. get an array of all page IDs for current page and its parent(s)
     *
     * @return array
     */
    function resolveLocation() {
        if(!($this->locations)) {
            if(isset($GLOBALS["xoopsModule"]) && is_object($GLOBALS["xoopsModule"]) && file_exists(XOOPS_ROOT_PATH.'/modules/'.$GLOBALS["xoopsModule"]->getVar("dirname").'/class/resolver.php')) {
                //Module has a resolver
                require_once(XOOPS_ROOT_PATH.'/modules/'.$GLOBALS["xoopsModule"]->getVar("dirname").'/class/resolver.php');
            }
            elseif(isset($GLOBALS["xoopsModule"]) && is_object($GLOBALS["xoopsModule"]) && file_exists(XOOPS_ROOT_PATH.'/modules/smartblocks/class/resolvers/'.$GLOBALS["xoopsModule"]->getVar("dirname").'.php')) {
                //Smartblocks has a resolver for this module
                require_once(XOOPS_ROOT_PATH.'/modules/smartblocks/class/resolvers/'.$GLOBALS["xoopsModule"]->getVar("dirname").'.php');
            }
            else {
                //Fall back to the resolver from the Smartblocks module
                $resolver = new SmartblocksResolver();
            }

            $location = $resolver->resolveLocation();

            $this->module = $GLOBALS["xoopsModule"];
            $this->locations = $resolver->getLocationPath($location);

            $this->locations[] = 0;

        }
        return $this->locations;
    }

    /**
     * Get all available blocks
     *
     * @return array
     */
    function getBlocks() {
        $result = $this->db->query("SELECT bid, b.name as name, m.name as modname  FROM ".$this->db->prefix("newblocks")." b, ".$this->db->prefix("modules")." m WHERE b.mid=m.mid AND b.mid != ".$GLOBALS['xoopsModule']->getVar('mid')." ORDER BY name");
        while (list($id, $name, $modname) = $this->db->fetchRow($result)) {
            $ret[$id] = $name." (".$modname.")";
        }
        return $ret;
    }
}
?>