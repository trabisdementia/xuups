<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com
function xteste_edit($id = 0)
{
    $helper = Xuups_Module_Helper::getInstance('xteste');
    $obj = $helper->getHandler('Post')->get($id);
	if (!$obj->isNew()){
		$sform = $obj->getForm(_MD_STASK_LIST_EDIT, 'addlist');
		$sform->display();
	} else {
		$sform = $obj->getForm(_MD_STASK_LIST_CREATE, 'addlist');
        $sform->display();
	}
}

include dirname(dirname(dirname(__FILE__))) . '/mainfile.php';
include XOOPS_ROOT_PATH . '/modules/xuups/include/bootstrap.php';

include XOOPS_ROOT_PATH . '/header.php';

$helper = Xuups_Module_Helper::getInstance('xteste');
$op = Xuups_Request::getString('op', 'mod');
$id = Xuups_Request::getInt('id', 1);

switch ($op) {
	case "mod":
	case "changedField":
		xteste_edit($id);
		break;
	case "addlist":
        $controller = new Xuups_Object_Controller($helper->getHandler('Post'));
		$controller->storeFromDefaultForm(_MD_STASK_LIST_CREATED, _MD_STASK_LIST_MODIFIED, 'index.php');
		break;

	case "del":
        $controller = new Xuups_Object_Controller($helper->getHandler('Post'));
		$controller->handleObjectDeletionFromUserSide();
		break;

	case "view" :
	    $obj = $helper->getHandler('Post')->get($id);
        $obj->displaySingleObject();
		break;

}

include XOOPS_ROOT_PATH . '/footer.php';
?>
