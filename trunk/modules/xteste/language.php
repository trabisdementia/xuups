<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com
include dirname(dirname(dirname(__FILE__))) . '/mainfile.php';
include dirname(__FILE__) .'/include/common.php';

$xoopsOption['template_main'] = 'xteste_post.html';
include XOOPS_ROOT_PATH . '/header.php';
$helper = Xmf_Module_Helper::getInstance('xteste');
$helper->setDebug(true);
/**
* Alternative methodto load language
* Xmf_Language::load('manifesto', 'xteste');
*/

$helper->loadLanguage('badmanifesto'); //trows error on log because language was not found
$helper->loadLanguage('manifesto');
echo _t('MA_XTESTE_HI') .'<br>';
echo _t('MA_XTESTE_GOODBYE') . '<br>';
_e('Something not translated yet!!!') . '<br>';
include XOOPS_ROOT_PATH . '/footer.php';