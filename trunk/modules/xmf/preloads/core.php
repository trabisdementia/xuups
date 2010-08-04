<?php
defined('XOOPS_ROOT_PATH') or die('Restricted access');

class XmfCorePreload extends XoopsPreloadItem
{
    function eventCoreIncludeCommonEnd($args)
    {
        if (file_exists($filename = XOOPS_ROOT_PATH . '/modules/xmf/include/bootstrap.php')) {
            include_once $filename;
        }
    }
}