<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

// Create a list of Country Capitals
function salat_getInfos() {
    $ret = array();
    $config = salat_getModuleConfig();
    $data = $config['data'];
    $lines = explode("\n", $data);
    foreach ($lines as $line) {
        $line = trim($line);
        $infos = explode('|', $line);
        $info = split(',', trim($infos[0]));
        if (isset($infos[1])) {
            $ret[$info[0]]['default'] = true;
        }
        $ret[$info[0]]['city'] = $info[0];
        $ret[$info[0]]['country'] = $info[1];
        $ret[$info[0]]['lat']  = $info[2];
        $ret[$info[0]]['long'] = $info[3];
    }
    return $ret;
}



function salat_getModuleConfig($dirname = 'salat')
{
	static $config;
	if (!$config) {
		global $xoopsModule;
		if (isset($xoopsModule) && is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $dirname) {
			global $xoopsModuleConfig;
			$config =& $xoopsModuleConfig;
		} else {
			$hModule =& xoops_gethandler('module');
			$module = $hModule->getByDirname($dirname);
			$hConfig =& xoops_gethandler('config');
			$config = $hConfig->getConfigsByCat(0, $module->getVar('mid'));
		}
	}
	return $config;
}
