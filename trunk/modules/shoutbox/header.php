<?php

include_once dirname(dirname(dirname(__FILE__))) . '/mainfile.php';
include_once XOOPS_ROOT_PATH . '/class/template.php';
error_reporting(0);
$GLOBALS['xoopsLogger']->activated = false;
$xoopsTpl = new XoopsTpl();
$xoopsTpl->xoops_setCaching(0);

$xoopsTpl->assign(
    array(
        'xoops_theme' => $xoopsConfig['theme_set'],
        'xoops_imageurl' => XOOPS_THEME_URL.'/'.$xoopsConfig['theme_set'].'/',
        'xoops_themecss'=> xoops_getcss($xoopsConfig['theme_set']),
        'xoops_requesturi' => htmlspecialchars($GLOBALS['xoopsRequestUri'], ENT_QUOTES),
        'xoops_sitename' => htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES),
        'xoops_slogan' => htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES)
    )
);
$xoopsTpl->assign('xoops_js', '<script type="text/javascript" src="'.XOOPS_URL.'/include/xoops.js"></script>');
if (is_object($xoopsUser)) {
    $xoopsTpl->assign(array('xoops_isuser' => true, 'xoops_userid' => $xoopsUser->getVar('uid'), 'xoops_uname' => $xoopsUser->getVar('uname'), 'xoops_isadmin' => $xoopsUserIsAdmin));
} else {
    $xoopsTpl->assign(array('xoops_isuser' => false, 'xoops_isadmin' => false));
}

if (is_file('style/shoutbox.css')) {
    $xoopsTpl->assign('themecss', 'style/shoutbox.css');
} else {
    $xoopsTpl->assign('themecss', xoops_getcss());
}
?>