<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com
include dirname(dirname(dirname(__FILE__))) . '/mainfile.php';
include dirname(__FILE__) .'/include/common.php';

$helper = Xmf_Module_Helper::getInstance('xteste');

$criteria = new Xmf_Criteria();
$criteria->setLimit(5)->setStart(0);
$export = new Xmf_Export($helper->getHandler('Post'), $criteria, $fields = false, $filename = false, $filepath = false, $format = 'csv', $options = false);
$export->render();