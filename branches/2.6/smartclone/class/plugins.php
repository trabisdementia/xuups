<?php
class SmartclonePlugins {

    var $pluginPatterns = false;

    function getPlugin($dirname) {
        $pluginName = SMARTCLONE_ROOT_PATH . 'plugins/' . $dirname . '.php';
        if (file_exists($pluginName)) {
            include_once($pluginName);
            $this->pluginPatterns = $pluginPatterns;
            return true;
        } else {
            return false;
        }
    }

    function getPluginsArray() {
        include_once(XOOPS_ROOT_PATH . "/class/xoopslists.php");
        $aFiles = XoopsLists::getFileListAsArray(SMARTCLONE_ROOT_PATH . 'plugins/');
        $ret = array();
        foreach($aFiles as $file) {
            if (substr($file, strlen($file) - 4, 4) == '.php') {
                $pluginName = str_replace('.php', '', $file);
                $module_xoops_version_file = XOOPS_ROOT_PATH . "/modules/$pluginName/xoops_version.php";
                if (file_exists($module_xoops_version_file)) {
                    $ret[$pluginName] = $pluginName;
                }
            }
        }
        return $ret;
    }
}
?>