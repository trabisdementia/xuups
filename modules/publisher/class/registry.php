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
 *  Publisher class
 *
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Publisher
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id$
 */

defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

class PublisherRegistry {
    var $_entries;
    var $_locks;

    protected function __construct() {
        $this->_entries = array();
        $this->_locks = array();
    }

    static function &getInstance() {
        static $instance = false;
        if (!$instance) {
            $instance = new PublisherRegistry();
        }
        return $instance;
    }

    function setEntry($key, &$item) {
        if ($this->isLocked($key) == true) {
            trigger_error('Unable to set entry `' . $key . '`. Entry is locked.', E_USER_WARNING);
            return false;
        }

        $this->_entries[$key] = $item;
        return true;
    }

    function unsetEntry($key) {
        unset($this->_entries[$key]);
    }

    function getEntry($key) {
        if (isset($this->_entries[$key]) == false) {
            return null;
        }

        return $this->_entries[$key];
    }

    function isEntry($key) {
        return ($this->getEntry($key) !== null);
    }

    function lockEntry($key) {
        $this->_locks[$key] = true;
        return true;
    }

    function unlockEntry($key) {
        unset($this->_locks[$key]);
    }

    function isLocked($key) {
        return (isset($this->_locks[$key]) == true);
    }

    function unsetAll() {
        $this->_entries = array();
        $this->_locks = array();
    }

}

?>