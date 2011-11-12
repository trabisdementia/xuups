<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

function b_mysearch_ajaxsearch_show()
{
    global $xoTheme, $xoopsTpl;

    //load scripts
    if (!defined('MYSEARCH_INCLUDED')) {
        define('MYSEARCH_INCLUDED', '1');
        if (@is_object($xoTheme)) {
            $xoTheme->addStylesheet(XOOPS_URL.'/modules/mysearch/css/style.css');
            $xoTheme->addScript(XOOPS_URL.'/modules/mysearch/js/scriptaculous/lib/prototype.js');
            $xoTheme->addScript(XOOPS_URL.'/modules/mysearch/js/scriptaculous/src/scriptaculous.js');
        } else {
            $xoopsTpl->assign( 'xoops_module_header' , '<link rel="stylesheet" type="text/css" href="'.XOOPS_URL.'/modules/mysearch/css/style.css" /><script type="text/javascript" src="'.XOOPS_URL.'/modules/mysearch/js/scriptaculous/lib/prototype.js"></script><script type="text/javascript" src="'.XOOPS_URL.'/modules/mysearch/js/scriptaculous/src/scriptaculous.js"></script>'.@$xoopsTpl->get_template_vars("xoops_module_header") );
        }
    }

    $block = array();
    $block['lang_search'] = _MB_MYSEARCH_SEARCH;
    $block['lang_advsearch'] = _MB_MYSEARCH_ADVS;
    return $block;
}
?>
