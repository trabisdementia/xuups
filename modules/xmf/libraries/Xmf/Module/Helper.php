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
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Xmf
 * @since           0.1
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

class Xmf_Module_Helper
{
    protected $dirname;
    protected $object;
    protected $handler;
    protected $config;
    protected $debug;

    private function __construct($dirname)
    {
        $this->dirname = $dirname;
    }

    public static function &getInstance($dirname = 'notsetyet')
    {
        static $instance = array();
        if (!isset($instance[$dirname])) {
            $instance[$dirname] = new self($dirname);
        }
        return $instance[$dirname];

    }

    public function &getObject()
    {
        if ($this->object == null) {
            $this->initObject();
        }
        if (!is_object($this->object)) {
            $this->addLog("ERROR :: Module '{$this->dirname}' does not exist");
        }
        return $this->object;
    }

    public function &getConfig($name = null) {
        if ($this->config == null) {
            $this->initConfig();
        }
        if (!$name) {
            $this->addLog("getting all config");
            return $this->config;
        }

        if (!isset($this->config[$name])) {
            $this->addLog("ERROR :: Config '{$name}' does not exist");
            $ret = null;
            return $ret;
        }

        $this->addLog("Getting config '{$name}' : " .$this->config[$name]);
        return $this->config[$name];
    }

    public function setConfig($name = null, $value = null) {
        if ($this->config == null) {
            $this->initConfig();
        }

        $this->config[$name] = $value;

        $this->addLog("Setting config '{$name}' : " . $this->config[$name]);
        return $this->config[$name];
    }

    public function &getHandler($name)
    {
        $ret = false;
        //$name = ucfirst(strtolower($name));
        $name = strtolower($name);
        if (!isset($this->handler[$name . '_handler'])) {
            $this->initHandler($name);
        }

        if (!isset($this->handler[$name . '_handler'])) {
            $this->addLog("ERROR :: Handler '{$name}' does not exist");
        }  else {
            $this->addLog("Getting handler '{$name}'");
            $ret = $this->handler[$name . '_handler'];
        }
        return $ret;
    }

    protected function initObject()
    {
        global $xoopsModule;
        if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $this->dirname) {
            $this->object =& $xoopsModule;
        } else {
            $hModule =& xoops_gethandler('module');
            $this->object =& $hModule->getByDirname($this->dirname);
        }
        $this->addLog('INIT MODULE OBJECT');
    }

    protected function initConfig()
    {
        $this->addLog('INIT CONFIG');
        global $xoopsModule;
        if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $this->dirname) {
            global $xoopsModuleConfig;
            $this->config =& $xoopsModuleConfig;
        } else {
            $hModConfig =& xoops_gethandler('config');
            $this->config =& $hModConfig->getConfigsByCat(0, $this->getModule()->getVar('mid'));
        }
    }

    protected function initHandler($name)
    {
        $this->addLog('INIT ' . $name . ' HANDLER');

        if (!isset($this->handler[$name . '_handler'])) {
            /*if ( file_exists( $hnd_file = XOOPS_ROOT_PATH . "/modules/{$this->dirname}/Object/Handler/{$name}.php" ) ) {
                include_once $hnd_file;
            }
            if ( file_exists( $hnd_file = XOOPS_ROOT_PATH . "/modules/{$this->dirname}/Object/{$name}.php" ) ) {
                include_once $hnd_file;
            }
            $class = ucfirst(strtolower($this->dirname)) . '_Object_Handler_' . $name;
            */
            if (file_exists($hnd_file = XOOPS_ROOT_PATH . "/modules/{$this->dirname}/class/{$name}.php")) {
                include_once $hnd_file;
            }
            $class = ucfirst(strtolower($this->dirname)) . ucfirst(strtolower($name)) . 'Handler';
            if (class_exists($class)) {
                $this->handler[$name . '_handler'] = new $class($GLOBALS['xoopsDB']);
                $this->addLog("Loading class '{$class}'");
            } else {
                $this->addLog("ERROR :: Class '{$class}' could not be loaded");
            }
        }
    }

    public function loadLanguage($name, $language = null)
    {
        if ($ret = Xmf_Language::load($name, $this->dirname, $language)) {
            $this->addLog("Loading language '{$name}'");
        } else {
            $this->addLog("ERROR :: Language '{$name}' could not be loaded");
        }
    }

    public function setDebug($bool = true)
    {
        $this->debug = (bool)$bool;
    }

    public function addLog($log)
    {
        if ($this->debug) {
            if (is_object($GLOBALS['xoopsLogger'])) {
                $GLOBALS['xoopsLogger']->addExtra(is_object($this->object) ? $this->object->name() : $this->dirname, $log);
            }
        }
    }
}
