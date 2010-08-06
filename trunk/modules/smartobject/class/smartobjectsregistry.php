<?php

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

/**
 * SmartObjects Registry
 *
 * The SmartObjects Registry is an object containing SmartObject objects that will be reused in the same process
 *
 * @package SmartObject
 * @author marcan <marcan@smartfactory.ca>
 * @link http://smartfactory.ca The SmartFactory
 */
class SmartObjectsRegistry {

    var $_registryArray;

    /**
     * Access the only instance of this class
     *
     * @return	object
     *
     * @static
     * @staticvar   object
     */
    function &getInstance()
    {
        static $instance;
        if (!isset($instance)) {
            $instance = new SmartObjectsRegistry();
        }
        return $instance;
    }

    /**
     * Adding objects to the registry
     *
     * @param SmartPersistableObjectHandler $handler of the objects to add
     * @param CriteriaCompo $criteria to pass to the getObjects method of the handler (with id_as_key)
     *
     * @return FALSE if an error occured
     */
    function addObjectsFromHandler(&$handler, $criteria=false) {
        if (method_exists($handler, 'getObjects')) {
            $objects = $handler->getObjects($criteria, true);
            $this->_registryArray['objects'][$handler->_moduleName][$handler->_itemname] = $objects;
            return $objects;
        } else {
            return false;
        }
    }

    /**
     * Adding objects to the registry from an item name
     * This method will fetch the handler of the item / module and call the addObjectsFromHandler
     *
     * @param string $item name of the item
     * @param string $modulename name of the module
     * @param CriteriaCompo $criteria to pass to the getObjects method of the handler (with id_as_key)
     *
     * @return FALSE if an error occured
     */
    function addObjectsFromItemName($item, $modulename=false, $criteria=false) {
        if (!$modulename) {
            global $xoopsModule;
            if (!is_object($xoopsModule)) {
                return false;
            } else {
                $modulename = $xoopsModule->dirname();
            }
        }
        $object_handler = xoops_getModuleHandler($item, $modulename);

        if (method_exists($object_handler, 'getObjects')) {
            $objects = $object_handler->getObjects($criteria, true);
            $this->_registryArray['objects'][$object_handler->_moduleName][$object_handler->_itemname] = $objects;
            return $objects;
        } else {
            return false;
        }
    }

    /**
     * Fetching objects from the registry
     *
     * @param string $itemname
     * @param string $modulename
     *
     * @return the requested objects or FALSE if they don't exists in the registry
     */
    function getObjects($itemname, $modulename) {
        if (!$modulename) {
            global $xoopsModule;
            if (!is_object($xoopsModule)) {
                return false;
            } else {
                $modulename = $xoopsModule->dirname();
            }
        }
        if (isset($this->_registryArray['objects'][$modulename][$itemname])) {
            return $this->_registryArray['objects'][$modulename][$itemname];
        } else {
            // if they were not in registry, let's fetch them and add them to the reigistry
            $module_handler = xoops_getModuleHandler($itemname, $modulename);
            if (method_exists($module_handler, 'getObjects')) {
                $objects = $module_handler->getObjects();
            }
            $this->_registryArray['objects'][$modulename][$itemname] = $objects;
            return $objects;
        }
    }

    /**
     * Fetching objects from the registry, as a list : objectid => identifier
     *
     * @param string $itemname
     * @param string $modulename
     *
     * @return the requested objects or FALSE if they don't exists in the registry
     */
    function getList($itemname, $modulename) {
        if (!$modulename) {
            global $xoopsModule;
            if (!is_object($xoopsModule)) {
                return false;
            } else {
                $modulename = $xoopsModule->dirname();
            }
        }
        if (isset($this->_registryArray['list'][$modulename][$itemname])) {
            return $this->_registryArray['list'][$modulename][$itemname];
        } else {
            // if they were not in registry, let's fetch them and add them to the reigistry
            $module_handler = xoops_getModuleHandler($itemname, $modulename);
            if (method_exists($module_handler, 'getList')) {
                $objects = $module_handler->getList();
            }
            $this->_registryArray['list'][$modulename][$itemname] = $objects;
            return $objects;
        }
    }

    /**
     * Retreive a single object
     *
     * @param string $itemname
     * @param string $key
     *
     * @return the requestd object or FALSE if they don't exists in the registry
     */
    function getSingleObject($itemname, $key, $modulename=false) {
        if (!$modulename) {
            global $xoopsModule;
            if (!is_object($xoopsModule)) {
                return false;
            } else {
                $modulename = $xoopsModule->dirname();
            }
        }
        if (isset($this->_registryArray['objects'][$modulename][$itemname][$key])) {
            return $this->_registryArray['objects'][$modulename][$itemname][$key];
        } else {
            $objectHandler = xoops_getModuleHandler($itemname, $modulename);
            $object = $objectHandler->get($key);
            if (!$object->isNew()) {
                return $object;
            } else {
                return false;
            }
        }
    }
}