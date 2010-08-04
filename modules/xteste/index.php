<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com
include dirname(dirname(dirname(__FILE__))) . '/mainfile.php';
include dirname(__FILE__) .'/include/common.php';

$xoopsOption['template_main'] = 'xteste_post.html';
include XOOPS_ROOT_PATH . '/header.php';
$files = Xmf_Lists::getFileListAsArray(dirname(__FILE__));
foreach ($files as $file) {
    echo "<a href={$file}>{$file}</a><br/>";
}


//$xoopsTpl->assign( "page", XOOPS_ROOT_PATH . '/modules/xteste/templates/' . $_GET['get'].'.html' );


$id = Xmf_Request::getInt('id', 1);

$helper = Xmf_Module_Helper::getInstance('xteste');
$helper->setDebug(true);

//Echos module name, getModule() gets module object
//echo $helper->getModule()->getVar('name') . '<br>';
//print_r($helper->getHandler('Post')->create());

$count = $helper->getHandler('Post')->getCount();
if ($count < 5) {
    $num = $count + 1;
    $obj = $helper->getHandler('Post')->create();
    $obj->setVar('title', "Post number {$num}");
    $obj->setVar('body', "This is interesting post {$num}" );
    $obj->setVar('uid', 1);
    $obj->setVar('published', 1);
    $obj->setVar('created', time());
    $obj->setVar('category_id', 2);
    $helper->getHandler('Post')->insert($obj);
    /*$handler = $helper->getHandler('Category');
    $obj = $handler->create();
    $obj->setVar('id', 2);
    $obj->setVar('title', 'Category two');
    $handler->insert($obj);*/
    //->create();
    /*$obj->setVar('title', "Category number {$num}" );
    $obj->setVar('id', $num);
    $helper->getHandler('Category')->insert($obj);*/
}
$criteria = new Xmf_Criteria();
$criteria->setLimit(5)->setStart(0)->setOrder('desc')->setSort('id');
$objs = $helper->getHandler('Post')->getObjects($criteria);
$posts = array();
foreach ($objs as $obj) {
    $posts[]['title'] =
     $obj->getVar('title')
    . '-'
    . $obj->getVar('body')
    . '-'
    . $obj->getVar('created')
    . '-'
    . $obj->getVar('uid')
    . '-'
    . $obj->getVar('category_id');
}

$xoopsTpl->assign('posts', $posts);

echo $helper->getConfig('config1') . '<br>';
echo $helper->getConfig('config2') . '<br>';
echo $helper->getConfig('config3') . '<br>'; //trows an error on log cause config3 is missing


/**
* Alternative methodto load language
* Xmf_Language::load('manifesto', 'xteste');
*/

$helper->loadLanguage('badmanifesto'); //trows error on log because language was not found
$helper->loadLanguage('manifesto');
echo _t('MA_XTESTE_HI') .'<br>';
echo _t('MA_XTESTE_GOODBYE') . '<br>';
_e('Something not translated yet!!!') . '<br>';

$helper = Xmf_Module_Helper::getInstance('nomodulehere');
$helper->setDebug(true);
$helper->getObject(); //trows an error on log because module was not found */
include XOOPS_ROOT_PATH . '/footer.php';
