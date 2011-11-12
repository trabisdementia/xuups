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

//Echos module name, getModule() gets module object
//echo $helper->getModule()->getVar('name') . '<br>';
//print_r($helper->getHandler('Post')->create());

$count = $helper->getHandler('Post')->getCount();
if ($count < 5) {
    $num = $count + 1;
    $obj = $helper->getHandler('Post')->create();
    $obj->setVar('title', "Post number {$num}" );
    $obj->setVar('body', "This is interesting post {$num}" );
    $obj->setVar('uid', 1);
    $obj->setVar('published', 1);
    $obj->setVar('created', time());
    $obj->setVar('cid', $num);
    $helper->getHandler('Post')->insert($obj);
    $obj = $helper->getHandler('Category');
}
$criteria = new Xmf_Criteria();
$criteria->setLimit(5)->setStart(2);
$objs = $helper->getHandler('Post')->getObjects($criteria);
foreach ($objs as $obj) {
    $posts[]['title'] = $obj->getVar('title') . '-' . $obj->getVar('created');
}

$xoopsTpl->assign('posts', $posts);

echo $helper->getConfig('config1') . '<br>';
echo $helper->getConfig('config2') . '<br>';
echo $helper->getConfig('config3') . '<br>'; //trows an error on log cause config3 is missing

$helper = Xmf_Module_Helper::getInstance('nomodulehere');
$helper->setDebug(true);
$helper->getObject(); //trows an error on log because module was not found */
include XOOPS_ROOT_PATH . '/footer.php';
