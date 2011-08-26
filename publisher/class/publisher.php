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
 * @package         Class
 * @subpackage      Utils
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: publisher.php 0 2009-06-11 18:47:04Z trabis $
 */

defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

class PublisherPublisher {
    var $registry;
    var $module;
    var $handler;
    var $config;
    var $debug;
    var $debugArray = array();

    protected function __construct($debug) {
        $this->debug = $debug;
        $this->registry =& PublisherRegistry::getInstance();
        $this->registry->setEntry('dirname', basename(dirname(dirname(__FILE__))));
    }

    static function &getInstance($debug = false) {
        static $instance = false;
        if (!$instance) {
            $instance = new PublisherPublisher($debug);
        }
        return $instance;
    }

    function &getModule() {
        if ($this->module == null) {
            $this->initModule();
        }
        return $this->module;
    }

    function getConfig($name = null) {
        if ($this->config == null) {
            $this->initConfig();
        }
        if (!$name) {
            $this->addLog("Getting all config");
            return $this->config;
        }

        if (!isset($this->config[$name])) {
            $this->addLog("ERROR :: CONFIG '{$name}' does not exist");
            return null;
        }

        $this->addLog("Getting config '{$name}' : " . $this->config[$name]);
        return $this->config[$name];
    }

    function setConfig($name = null, $value = null) {
        if ($this->config == null) {
            $this->initConfig();
        }

        $this->config[$name] = $value;

        $this->addLog("Setting config '{$name}' : " . $this->config[$name]);
        return $this->config[$name];
    }

    function &getHandler($name) {
        if (!isset($this->handler[$name . '_handler'])) {
            $this->initHandler($name);
        }
        $this->addLog("Getting handler '{$name}'");
        return $this->handler[$name . '_handler'];
    }

    function initModule() {
        global $xoopsModule;
        if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $this->registry->getEntry('dirname')) {
            $this->module =& $xoopsModule;
        } else {
            $hModule =& xoops_gethandler('module');
            $this->module =& $hModule->getByDirname($this->registry->getEntry('dirname'));
        }
        $this->addLog('INIT MODULE');
    }

    function initConfig() {
        $this->addLog('INIT CONFIG');
        global $xoopsModule;
        if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $this->registry->getEntry('dirname')) {
            global $xoopsModuleConfig;
            $this->config =& $xoopsModuleConfig;
        } else {
            $hModConfig =& xoops_gethandler('config');
            $this->config =& $hModConfig->getConfigsByCat(0, $this->getModule()->getVar('mid'));
        }
    }

    function initHandler($name) {
        $this->addLog('INIT ' . $name . ' HANDLER');
        $this->handler[$name . '_handler'] = xoops_getModuleHandler($name, $this->registry->getEntry('dirname'));
    }

    function addLog($log) {
        if ($this->debug) {
            //$this->debugArray[] = $log /*. ' -  ' . sprintf( "%.03f", $dif)*/;
            if (is_object($GLOBALS['xoopsLogger'])) {
                $GLOBALS['xoopsLogger']->addExtra($this->module->name(), $log);
            }
        }
    }

    /*
     function __destruct()
     {
     if ($this->debug) {
     $dump = '';
     foreach ($this->debugArray as $msg) {
     $dump .= $msg . '<br>';
     }
     echo $dump;
     }
     } */
}

?>