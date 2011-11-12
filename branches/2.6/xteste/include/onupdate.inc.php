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