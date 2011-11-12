<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com
include dirname(dirname(dirname(__FILE__))) . '/mainfile.php';
include dirname(__FILE__) .'/include/common.php';

include XOOPS_ROOT_PATH . '/header.php';

$helper = Xmf_Module_Helper::getInstance('xteste');
$helper->setDebug(true);

$id = Xmf_Request::getInt('id', 1);

$handler = $helper->getHandler('Post');
$obj = $handler->get($id);
$obj->loadHelper('form');
//$obj->prepareForm();

$form = $obj->getForm('mycaption', 'myname', 'form.php','submit button name', $cancel_js_action=false, $captcha=false);
$form->display();

$template = new Xmf_Template_Object_View($obj);
foreach($obj->vars as $key=>$var) {
    $template->addRow(new Xmf_Template_Object_Row($key));
}

$template->display();

include XOOPS_ROOT_PATH . '/footer.php';