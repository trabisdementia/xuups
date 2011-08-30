<?php
if (defined('XMF_EXEC')) return;

if (!defined('XOOPS_ROOT_PATH')) {
    require dirname(dirname(dirname(dirname(__FILE__)))) . '/mainfile.php';
}

define('XMF_EXEC', true);

define('XMF_URL',            XOOPS_URL . '/modules/xmf');
define('XMF_CSS_URL',        XMF_URL . '/css');
define('XMF_IMAGES_URL',     XMF_URL . '/images');
define('XMF_INCLUDE_URL',    XMF_URL . '/include');
define('XMF_LANGUAGE_URL',   XMF_URL . '/language');
define('XMF_LIBRARIES_URL',  XMF_URL . '/libraries');
define('XMF_TEMPLATES_URL',  XMF_URL . '/templates');

define('XMF_ROOT_PATH',      XOOPS_ROOT_PATH . '/modules/xmf');
define('XMF_CSS_PATH',       XMF_ROOT_PATH . '/css');
define('XMF_IMAGES_PATH',    XMF_ROOT_PATH . '/images');
define('XMF_INCLUDE_PATH',   XMF_ROOT_PATH . '/include');
define('XMF_LANGUAGE_PATH',  XMF_ROOT_PATH . '/language');
define('XMF_LIBRARIES_PATH', XMF_ROOT_PATH . '/libraries');
define('XMF_TEMPLATES_PATH', XMF_ROOT_PATH . '/templates');

define('XMF_NEWLINE', "\n");

define('_GLOBAL_LEFT', 'left');
define('_GLOBAL_RIGHT', 'right');

require dirname(dirname(__FILE__)) . '/libraries/xmf/Loader.php';
spl_autoload_register(array('Xmf_Loader', 'loadClass'));

require dirname(__FILE__) . '/functions.php';
Xmf_Language::load('global', 'xmf');

global $xoops;
$xoops->urls = xmf_buildRelevantUrls();