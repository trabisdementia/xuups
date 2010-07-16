<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
include_once XOOPS_ROOT_PATH . '/modules/mymenus/class/registry.php';


class MymenusPlugin
{

    var $_registry;
    var $_plugins;
    var $_events;

    function MymenusPlugin()
    {
        $this->_plugins = array();
        $this->_events = array();
        $this->_registry =& MymenusRegistry::getInstance();
        $this->setPlugins();
        $this->setEvents();
    }

    function &getInstance()
    {
        static $instance = false;
        if (!$instance) {
            $instance = new MymenusPlugin();
        }
        return $instance;
    }

    function setPlugins()
    {
        if (is_dir($dir = XOOPS_ROOT_PATH . "/modules/mymenus/plugins/")) {
            $plugins_list = XoopsLists::getDirListAsArray($dir, "");
            foreach ($plugins_list as $plugin) {
                if (file_exists(XOOPS_ROOT_PATH . "/modules/mymenus/plugins/{$plugin}/{$plugin}.php")) {
                    $this->_plugins[] = $plugin;
                }
            }
        }
    }

    function setEvents()
    {
        foreach ($this->_plugins as $plugin) {
            include_once XOOPS_ROOT_PATH . "/modules/mymenus/plugins/{$plugin}/{$plugin}.php";
            $class_name = ucfirst($plugin) . 'MymenusPluginItem' ;
            if (!class_exists($class_name)) {
                continue;
            }
            $class_methods = get_class_methods($class_name);
            foreach ($class_methods as $method) {
                if (strpos($method, 'event') === 0) {
                    $event_name = strtolower(str_replace('event', '', $method));
                    $event= array('class_name' => $class_name, 'method' => $method);
                    $this->_events[$event_name][] = $event;
                }
            }
        }
    }

    function triggerEvent($event_name, $args = array())
    {
        $event_name = strtolower(str_replace('.', '', $event_name));
        if (isset($this->_events[$event_name])) {
            foreach ($this->_events[$event_name] as $event) {
                call_user_func(array($event['class_name'], $event['method']), $args);
            }
        }
    }

}


class MymenusPluginItem
{
    function MymenusPluginItem()
    {
    }

    function loadLanguage($name)
        {
        $language =  $GLOBALS['xoopsConfig']['language'];
        $path = XOOPS_ROOT_PATH . "/modules/mymenus/plugins/{$name}/language";
        if (!($ret = @include_once "{$path}/{$language}/{$name}.php")) {
            $ret = @include_once "{$path}/english/{$name}.php";
        }
        return $ret;
    }
}