<?php

/**
 * Editor handler
 *
 * @copyright   The XOOPS project http://www.xoops.org/
 * @license     http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package     core
 * @since       2.3.0
 * @author      Taiwen Jiang <phppp@users.sourceforge.net>
 */
class Xmf_Form_Element_Editor_Handler
{
    //static $instance;
    var $root_path = "";
    var $nohtml = false;
    var $allowed_editors = array();

    function __construct()
    {
        $this->root_path = XMF_LIBRARIES_PATH . '/Xmf/Form/Element/Editor';
    }

    /**
     * Access the only instance of this class
     *
     * @return    object
     *
     * @static
     * @staticvar   object
     */
    function &getInstance()
    {
        static $instance;
        if (!isset($instance)) {
            $class = __CLASS__;
            $instance = new $class();
        }
        return $instance;
    }

    /**
     * @param    string    $name        Editor name which is actually the folder name
     * @param    array     $options    editor options: $key => $val
     * @param    string    $OnFailure  a pre-validated editor that will be used if the required editor is failed to create
     * @param    bool    $noHtml        dohtml disabled
     */
    function get($name = "", $options = null, $noHtml = false, $OnFailure = "")
    {
        if ($editor = $this->_loadEditor($name, $options)) {
            return $editor;
        }
        $list = array_keys($this->getList($noHtml));
        if (empty($OnFailure) || !in_array($OnFailure, $list)) {
            $OnFailure = $list[0];
        }
        $editor = $this->_loadEditor($OnFailure, $options);
        return $editor;
    }

    function getList($noHtml = false)
    {
        xoops_load("XoopsCache");
        //$list = XoopsCache::read("editor_list");

        if (empty($list)) {
            $list = array();
            $order = array();
            $_list = Xmf_Lists::getDirListAsArray(XOOPS_ROOT_PATH .'/'. $this->root_path.'/');
            foreach ($_list as $item) {
                if ( !@include_once XOOPS_ROOT_PATH .'/'.$this->root_path.'/'.$item."/language/" . $GLOBALS["xoopsConfig"]['language'] . ".php" ) {
                    include_once XOOPS_ROOT_PATH .'/'.$this->root_path.'/'.$item."/language/english.php";
                }
                if (include XOOPS_ROOT_PATH .'/'.$this->root_path.'/'.$item.'/editor_registry.php') {
                    if (empty($config['order'])) continue;
                    $order[] = $config['order'];
                    $list[$item] = array("title" => $config["title"], "nohtml" => @$config["nohtml"]);
                }
            }
            array_multisort($order, $list);
            XoopsCache::write("editor_list", $list);
        }

        $editors = array_keys($list);
        if (!empty($this->allowed_editors)) {
            $editors = array_intersect($editors, $this->allowed_editors);
        }
        $_list = array();
        foreach ($editors as $name){
            if (!empty($noHtml) && empty($list[$name]['nohtml'])) continue;
            $_list[$name] = $list[$name]['title'];
        }
        return $_list;
    }

    function render($editor)
    {
        trigger_error(__CLASS__.'::'.__FUNCTION__.'() deprecated', E_USER_WARNING);
        return $editor->render();
    }

    function setConfig($editor, $options)
    {
        if (method_exists($editor, 'setConfig')) {
            $editor->setConfig($options);
        } else {
            foreach ($options as $key => $val) {
                $editor->$key = $val;
            }
        }
    }

    function _loadEditor($name, $options = null)
    {
        $editor = null;
        if (empty($name)) {
            return $editor;
        }
        $editor_path = XOOPS_ROOT_PATH .'/'.$this->root_path."/".$name;
        if ( !include_once $editor_path."/language/" . $GLOBALS["xoopsConfig"]['language'] . ".php" ) {
            include_once $editor_path."/language/english.php";
        }
        if (!include $editor_path . "/editor_registry.php") {
            return $editor;
        }
        if (empty($config['order'])) {
            return $editor;
        }
        include_once $config['file'];
        $editor = new $config['class']($options);
        return $editor;
    }
}
