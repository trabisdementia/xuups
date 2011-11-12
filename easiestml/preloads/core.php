<?php

defined('XOOPS_ROOT_PATH') or die('Restricted access');

class EasiestmlCorePreload extends XoopsPreloadItem
{
    function eventCoreIncludeCommonStart($args)
    {
        include_once dirname(dirname(__FILE__)) . '/easiestml.php';
    }

    function eventCoreIncludeCommonLanguage($args)
    {

        global $xoopsUser ;

        $easiestml_lang = @$GLOBALS['easiestml_lang'] ;

        // all mode for debug (allowed to system admin only)
        if (is_object($xoopsUser) && $xoopsUser->isAdmin(1) && !empty($_GET['easiestml_lang']) && $_GET['easiestml_lang'] == 'all') {
            return true;
        }

        $easiestml_langs = explode(',', EASIESTML_LANGS);
        $easiestml_dirs = explode(',', EASIESTML_LANGDIRS);
        // protection against some injection
        foreach ($easiestml_langs as $key => $lang) {
            if ($easiestml_lang == $lang) {
                $GLOBALS['xoopsConfig']['language'] = $easiestml_dirs[$key];
                return true;
            }
        }

        $GLOBALS['xoopsConfig']['language'] = $easiestml_dirs[EASIESTML_DEFAULT_LANG];
        return true;

    }

}
?>