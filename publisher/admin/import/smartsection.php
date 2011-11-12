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
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Publisher
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @author          Marius Scurtescu <mariuss@romanians.bc.ca>
 * @version         $Id$
 */

include_once dirname(dirname(__FILE__)) . '/admin_header.php';
$myts =& MyTextSanitizer::getInstance();

$importFromModuleName = 'smartsection';
$scriptname = "smartsection.php";

$op = 'start';
if (isset($_POST['op']) && ($_POST['op'] == 'go')) {
    $op = $_POST['op'];
}


$session = $GLOBALS['publisher']->getHelper('session');

//You can change how many items to collect before stoping script
$limit = 1000;
$button =  _AM_PUBLISHER_IMPORT;
if ($session->get('step') == 'go') {
    $button =  _AM_PUBLISHER_IMPORT_CONTINUE;
}

if ($op == 'start') {
    XoopsLoad::load('XoopsFormLoader');

    publisher_cpHeader();
    $menu = new Xmf_Template_Adminmenu($xoopsModule);
    $menu->display();
    publisher_openCollapsableBar('newsimport', 'newsimporticon', sprintf(_AM_PUBLISHER_IMPORT_FROM, $importFromModuleName), _AM_PUBLISHER_IMPORT_INFO);

    $result = $xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix("smartsection_categories"));
    list ($totalCat) = $xoopsDB->fetchRow($result);

    if ($totalCat == 0) {
        echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . _AM_PUBLISHER_IMPORT_NO_CATEGORY . "</span>";
    } else {
        include_once XOOPS_ROOT_PATH . '/class/xoopstree.php';

        $result = $xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix('smartsection_items'));
        list ($totalArticles) = $xoopsDB->fetchRow($result);

        if ($totalArticles == 0) {
            echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . sprintf(_AM_PUBLISHER_IMPORT_MODULE_FOUND_NO_ITEMS, $importFromModuleName, $totalArticles) . "</span>";
        } else {
            echo "<span style=\"color: #567; margin: 3px 0 12px 0; font-size: small; display: block; \">" . sprintf(_AM_PUBLISHER_IMPORT_MODULE_FOUND, $importFromModuleName, $totalArticles, $totalCat) . "</span>";

            $form = new XoopsThemeForm('', 'import_form', PUBLISHER_ADMIN_URL . "/import/{$scriptname}");
            $form->addElement(new XoopsFormHidden('op', 'go'));
            $form->addElement(new XoopsFormButton ('', 'import', $button, 'submit'));
            $form->display();
        }
    }

    publisher_closeCollapsableBar('newsimport', 'newsimporticon');
    xoops_cp_footer();
}

if ($op == 'go') {
    $session->set('step', 'go');

    $module_handler =& xoops_gethandler('module');
    $moduleObj = $module_handler->getByDirname('smartsection');
    $smartsection_module_id = $moduleObj->getVar('mid');
    $gperm_handler =& xoops_gethandler('groupperm');

    if (!$session->get('total_count')) {
        $session->set('total_count', 0);
    }

    if (!$buffer = $session->get('buffer')) {
        $buffer = '';
    }

    if (!$_categoryid = $session->get('categoryid')) {
        $_categoryid = 0;
    }

    if (!$_itemid = $session->get('itemid')) {
        $_itemid = 0;
    }

    if (!$session->get('imported_categories')) {
        $session->set('imported_categories', array());
    }

    if (!$session->get('imported_articles')) {
        $session->set('imported_articles', array());
    }


    $sql = "SELECT * FROM " . $xoopsDB->prefix('smartsection_categories') . " WHERE categoryid >= " . $_categoryid . " ORDER BY categoryid ASC";
    $resultCat = $xoopsDB->query($sql);

    while ($arrCat = $xoopsDB->fetchArray($resultCat)) {

        if (!in_array($arrCat['categoryid'], $session->get('imported_categories'))) {
            $categoryObj =& $publisher->getHandler('category')->create();
            $categoryObj->setVars($arrCat);
            $error = false;

            // Copy category image
            if (($arrCat['image'] != 'blank.gif') && ($arrCat['image'] != '')) {
                copy(XOOPS_ROOT_PATH . "/uploads/smartsection/images/category/" . $arrCat['image'], XOOPS_ROOT_PATH . "/uploads/publisher/images/category/" . $arrCat['image']);
            }
            if (!$publisher->getHandler('category')->insert($categoryObj)) {
                $buffer .=  sprintf(_AM_PUBLISHER_IMPORT_CATEGORY_ERROR, $arrCat['name']) . "<br/>";
                $error = true;
            }

            $session->set('category', $arrCat['categoryid']);
            $imported_categories = $session->get('imported_categories');
            $imported_categories[] = $arrCat['categoryid'];
            $session->set('imported_categories', $imported_categories);

            $total_count = $session->get('total_count');
            $session->set('total_count', $total_count + 1);

            if ($session->get('total_count') > $limit) {
                $session->set('total_count', 0);
                $session->set('buffer', $buffer);
                redirect_header('smartsection.php', 2, _AM_PUBLISHER_IMPORTING);
            }
            if ($error) {
                continue;
            }
                //echo sprintf(_AM_PUBLISHER_IMPORT_CATEGORY_SUCCESS, $categoryObj->name()) . "<br\>";
        }


        $sql = "SELECT * FROM " . $xoopsDB->prefix('smartsection_items') . " WHERE categoryid=" . $arrCat['categoryid'] . " AND itemid >= " . $_itemid . " ORDER BY itemid ASC";
        $resultArticles = $xoopsDB->query($sql);

        while ($arrArticle = $xoopsDB->fetchArray($resultArticles)) {
            if (!in_array($arrArticle['itemid'], $session->get('imported_articles'))) {
                $error = false;

                // insert article
                $itemObj =& $publisher->getHandler('item')->create();
                $itemObj->setVars($arrArticle);

                // TODO: move article images to image manager

                // HTML Wrap
                // TODO: copy contents folder
                /*
                if ($arrArticle['htmlpage']) {
                $pagewrap_filename	= XOOPS_ROOT_PATH . "/modules/wfsection/html/" .$arrArticle['htmlpage'];
                if (file_exists($pagewrap_filename)) {
                if (copy($pagewrap_filename, XOOPS_ROOT_PATH . "/uploads/publisher/content/" . $arrArticle['htmlpage'])) {
                $itemObj->setVar('body', "[pagewrap=" . $arrArticle['htmlpage'] . "]");
                echo sprintf("&nbsp;&nbsp;&nbsp;&nbsp;" . _AM_PUBLISHER_IMPORT_ARTICLE_WRAP, $arrArticle['htmlpage']) . "<br/>";
                }
                }
                }
                */

                if (!$itemObj->store()) {
                    $buffer .= sprintf("  " . _AM_PUBLISHER_IMPORT_ARTICLE_ERROR, $arrArticle['title']) . "<br/>";
                    $error = true;
                }
                if (!$error) {
                    // Linkes files
                    $sql = "SELECT * FROM " . $xoopsDB->prefix("smartsection_files") . " WHERE itemid=" . $arrArticle['itemid'];
                    $resultFiles = $xoopsDB->query($sql);
                    $allowed_mimetypes = null;
                    while ($arrFile = $xoopsDB->fetchArray($resultFiles)) {
                        $filename = XOOPS_ROOT_PATH . "/uploads/smartsection/" . $arrFile['filename'];
                        if (file_exists($filename)) {
                            if (copy($filename, XOOPS_ROOT_PATH . "/uploads/publisher/" . $arrFile['filename'])) {
                                $fileObj = $publisher->getHandler('file')->create();
                                $fileObj->setVars($arrFile);
                                if ($fileObj->store($allowed_mimetypes, true, false)) {
                                    $buffer .= "&nbsp;&nbsp;&nbsp;&nbsp;" . sprintf(_AM_PUBLISHER_IMPORTED_ARTICLE_FILE, $arrFile['filename']) . "<br />";
                                }
                            }
                        }
                    }
                }
                $session->set('item', $arrArticle['itemid']);
                $imported_articles =  $session->get('imported_articles');
                $imported_articles[] = $arrArticle['itemid'];
                $session->set('imported_articles', $imported_articles);

                //echo "&nbsp;&nbsp;" . sprintf(_AM_PUBLISHER_IMPORTED_ARTICLE, $itemObj->title()) . "<br />";

                $total_count = $session->get('total_count');
                $session->set('total_count', $total_count + 1);
                if ($session->get('total_count') > $limit) {
                    $session->set('total_count', 0);
                    $session->set('buffer', $buffer);
                    redirect_header('smartsection.php', 2, _AM_PUBLISHER_IMPORTING);
                }

            }
        }

        // Saving category permissions
        $groupsIds = $gperm_handler->getGroupIds('category_read', $arrCat['categoryid'], $smartsection_module_id);
        publisher_saveCategoryPermissions($groupsIds, $arrCat['categoryid'], 'category_read');
        $groupsIds = $gperm_handler->getGroupIds('item_submit', $arrCat['categoryid'], $smartsection_module_id);
        publisher_saveCategoryPermissions($groupsIds, $arrCat['categoryid'], 'item_submit');

        // Saving items permissions
        publisher_overrideItemsPermissions($groupsIds, $arrCat['categoryid']);


        //echo "<br/>";
    }

    // Looping through the comments to link them to the new articles and module
    $buffer .= _AM_PUBLISHER_IMPORT_COMMENTS . "<br />";

    $publisher_module_id = $publisher->getObject()->mid();

    $comment_handler = xoops_gethandler('comment');
    $criteria = new CriteriaCompo();
    $criteria->add(new Criteria('com_modid', $smartsection_module_id));
    $comments = $comment_handler->getObjects($criteria);
    foreach ($comments as $comment) {
        $comment->setVar('com_modid', $publisher_module_id);
        $comment->setNew();
        if (!$comment_handler->insert($comment)) {
            $buffer .= "&nbsp;&nbsp;" . sprintf(_AM_PUBLISHER_IMPORTED_COMMENT_ERROR, $comment->getVar('com_title')) . "<br />";
        } else {
            $buffer .= "&nbsp;&nbsp;" . sprintf(_AM_PUBLISHER_IMPORTED_COMMENT, $comment->getVar('com_title')) . "<br />";
        }
    }

    publisher_cpHeader();
    $menu = new Xmf_Template_Adminmenu($xoopsModule);
    $menu->display();
    publisher_openCollapsableBar('newsimportgo', 'newsimportgoicon', sprintf(_AM_PUBLISHER_IMPORT_FROM, $importFromModuleName), _AM_PUBLISHER_IMPORT_RESULT);
    echo $buffer;
    echo "<br/><br/>Done.<br/>";
    echo sprintf(_AM_PUBLISHER_IMPORTED_CATEGORIES, count($session->get('imported_categories'))) . "<br/>";
    echo sprintf(_AM_PUBLISHER_IMPORTED_ARTICLES, count($session->get('imported_articles'))) . "<br/>";
    echo "<br/><a href='" . PUBLISHER_URL . "/'>" . _AM_PUBLISHER_IMPORT_GOTOMODULE . "</a><br/>";

    publisher_closeCollapsableBar('newsimportgo', 'newsimportgoicon');

    $session->destroy();
    xoops_cp_footer();
}