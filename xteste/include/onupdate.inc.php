<?php
defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

define('XTESTE_DB_VERSION', 1);
function xoops_module_update_xteste($module)
{
    $dbupdater = new Xmf_Database_Updater();
    $dbupdater->moduleUpgrade($module);
    return true;
}

function xoops_module_install_xteste($module)
{
    return xoops_module_update_xteste($module);
}

function xoops_module_pre_install_xteste($module)
{
    if (!xoops_isActiveModule('xmf')) {
        $module->setErrors('<b>Please install or reactivate XMF module</b>');
        return false;
    }
    return true;
}