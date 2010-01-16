<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Publisher
 * @subpackage      Action
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: file.php 0 2009-06-11 18:47:04Z trabis $
 */

include_once dirname(__FILE__) . '/header.php';

// if the user is not admin AND we don't allow user submission, exit
if (!$publisher_isAdmin || (
    $publisher->getConfig('perm_submit') &&
    $publisher->getConfig('perm_submit') == 1 && (
        is_object($xoopsUser) || (
            $publisher->getConfig('perm_anon_submit') && $publisher->getConfig('perm_anon_submit') == 1)
        )
    )
) {
    redirect_header("index.php", 1, _NOPERM);
    exit();
}

$op = PublisherRequest::getString('op');
$itemid = PublisherRequest::getInt('itemid');

if ($itemid == 0) {
    redirect_header("index.php", 2, _MD_PUBLISHER_NOITEMSELECTED);
    exit();
}

$itemObj = $publisher->getHandler('item')->get($itemid);
// if the selected item was not found, exit
if (!$itemObj || !(is_object($xoopsUser)) || $itemObj->getVar('uid') != $xoopsUser->getVar('uid')) {
    redirect_header("javascript:history.go(-1)", 1, _NOPERM);
    exit();
}

$false = false;
switch ($op) {
    case "uploadfile" :
        publisher_uploadFile(false, true, $false);
        exit();
        break;

    case "uploadanother" :
        publisher_uploadFile(true, true, $false);
        exit();
        break;

    case 'form':
    default:

    $xoopsOption['template_main'] = 'publisher_addfile.html';
    include_once XOOPS_ROOT_PATH . '/header.php';
    include_once PUBLISHER_ROOT_PATH . '/footer.php';

    $name = $xoopsUser ? (ucwords($xoopsUser->getVar("uname"))) : $GLOBALS['xoopsConfig']['anonymous'];

    $xoopsTpl->assign('module_home', publisher_moduleHome());

    $xoopsTpl->assign('categoryPath', _CO_PUBLISHER_ADD_FILE);
    $xoopsTpl->assign('lang_intro_title', sprintf(_MD_PUBLISHER_ADD_FILE_TITLE, $publisher->getModule()->getVar('name')));
    $xoopsTpl->assign('lang_intro_text',  sprintf(_MD_PUBLISHER_GOODDAY, $name) . sprintf(_MD_PUBLISHER_ADD_FILE_INTRO, $itemObj->title()));
    $fileObj =& $publisher->getHandler('file')->create();
    $fileObj->setVar('itemid', $itemid);
    xoops_loadLanguage('admin', 'publisher');
    $form = $fileObj->getForm();
    $form->assign($xoopsTpl);
    include_once XOOPS_ROOT_PATH . '/footer.php';
    break;
}

?>