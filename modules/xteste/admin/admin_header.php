<?php
include_once dirname(dirname(dirname(dirname(__FILE__)))) . '/mainfile.php';

require dirname(dirname(__FILE__)) . '/include/common.php';

$helper = Xmf_Module_Helper::getInstance('xteste');
$helper->setDebug(true);
$helper->loadLanguage('admin');
$helper->loadLanguage('modinfo2');

include_once XOOPS_ROOT_PATH . '/include/cp_header.php';