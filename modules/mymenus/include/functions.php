<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

function mymenus_adminMenu($currentoption = 0, $breadcrumb = '')
{
    include_once XOOPS_ROOT_PATH . '/class/template.php';
    include XOOPS_ROOT_PATH . '/modules/mymenus/admin/menu.php';

    xoops_loadLanguage('admin', 'mymenus');
    xoops_loadLanguage('modinfo', 'mymenus');

    $tpl = new XoopsTpl();
    $tpl->assign(array('modurl'	    => XOOPS_URL . '/modules/mymenus',
        'headermenu'	=> $mymenus_headermenu,
        'adminmenu'	=> $mymenus_adminmenu,
        'current'	=> $currentoption,
        'breadcrumb'	=> $breadcrumb,
        'headermenucount' => count($mymenus_headermenu)));
    $tpl->display(XOOPS_ROOT_PATH . '/modules/mymenus/templates/static/mymenus_admin_adminmenu.html');
}

function mymenus_getModuleConfig($dirname = 'mymenus')
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

function mymenus_getSkinInfo($skin)
{
    $file = XOOPS_ROOT_PATH . "/modules/mymenus/skins/{$skin}/skin_version.php";
    $info = array();

    if (file_exists($file)) {
        include $file;
        $info =& $skinversion;
    }

    if (!isset($info['template'])) {
        $info['template'] = XOOPS_ROOT_PATH . "/modules/mymenus/templates/static/blocks/mymenus_block.html";
    } else {
        $info['template'] = XOOPS_ROOT_PATH . "/modules/mymenus/skins/{$skin}/" . $info['template'];
    }

    if (!isset($info['prefix'])) {
        $info['prefix'] = $skin;
    }

    if (isset($info['css'])) {
        $info['css'] = (array)$info['css'];
        foreach ($info['css'] as $key => $value) {
            $info['css'][$key] = XOOPS_URL . "/modules/mymenus/skins/{$skin}/{$value}" ;
        }
    }

    if (isset($info['js'])) {
        $info['js'] = (array)$info['js'];
        foreach ($info['js'] as $key => $value) {
            $info['js'][$key] = XOOPS_URL . "/modules/mymenus/skins/{$skin}/{$value}" ;
        }
    }

    if (!isset($info['config'])) {
        $info['config'] = array();
    }

    return $info;
}
