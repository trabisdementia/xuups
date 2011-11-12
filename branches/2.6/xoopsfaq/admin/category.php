<?php
/**
 * Name: category.php
 * Description: Category Admin file
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright::  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license::    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package::    Xoops
 * @module::     Xoops FAQ
 * @subpackage:: Xoops FAQ Admin
 * @since::      2.3.0
 * @author::     John Neill
 * @version::    $Id$
 */
include 'admin_header.php';
xoops_cp_header();

$category_handler = &xoops_getModuleHandler('category');

$op = xoopsFaq_CleanVars($_REQUEST, 'op', 'default', 'string');
switch ($op) {
  case 'edit':
//    xoops_cp_header();
    //xoopsFaq_AdminMenu(1);
    $index_admin = new ModuleAdmin();
    echo $index_admin->addNavigation('category.php');
    //xoopsFaq_DisplayHeading(_AM_XOOPSFAQ_CATEGORY_HEADER, _AM_XOOPSFAQ_CATEGORY_EDIT_DSC, false);
    xoopsFaq_DisplayHeading('', _AM_XOOPSFAQ_CATEGORY_EDIT_DSC, false);
    $category_id = xoopsFaq_CleanVars($_REQUEST, 'category_id', 0, 'int');
    $obj = (0 == $category_id) ? $category_handler->create() : $category_handler->get($category_id);
    if (is_object($obj)) {
      $obj->displayForm();
    } else {
      $category_handler->displayError(_AM_XOOPSFAQ_ERRORCOULDNOTEDITCAT);
    }
    break;

  case 'delete':
    $ok = xoopsFaq_CleanVars($_REQUEST, 'ok', 0, 'int');
    $category_id = xoopsFaq_CleanVars($_REQUEST, 'category_id', 0, 'int');
    if (1 == $ok) {
      $obj = $category_handler->get($category_id);
      if (is_object($obj)) {
        if ($category_handler->delete($obj)) {
          $sql = sprintf('DELETE FROM %s WHERE contents_cid = %u', $xoopsDB->prefix('xoopsfaq_contents'), $category_id);
          $xoopsDB->query($sql);
          // delete comments
          xoops_comment_delete($xoopsModule->getVar('mid' ), $category_id);
          redirect_header('category.php', 1, _AM_XOOPSFAQ_DBSUCCESS);
        }
      }
      $category_handler->displayError(_AM_XOOPSFAQ_ERRORCOULDNOTDELCAT);
    } else {
      xoops_cp_header();
      //xoopsFaq_AdminMenu(1);
      $index_admin = new ModuleAdmin();
      echo $index_admin->addNavigation('category.php');
      //xoopsFaq_DisplayHeading(_AM_XOOPSFAQ_CATEGORY_HEADER, _AM_XOOPSFAQ_CATEGORY_DELETE_DSC, false);
      xoopsFaq_DisplayHeading('', _AM_XOOPSFAQ_CATEGORY_DELETE_DSC, false);
      xoops_confirm(array('op' => 'delete', 'category_id' => $category_id, 'ok' => 1), 'category.php', _AM_XOOPSFAQ_RUSURECAT);
    }
    break;

  case 'save':
    if (!$GLOBALS['xoopsSecurity']->check()) {
      redirect_header($this->url, 0, $GLOBALS['xoopsSecurity']->getErrors(true));
    }
    $category_id = xoopsFaq_CleanVars($_REQUEST, 'category_id', 0, 'int');
    $obj = (0 == $category_id) ? $category_handler->create() : $category_handler->get($category_id);
    if (is_object($obj)) {
      $obj->setVar('category_title', xoopsFaq_CleanVars($_REQUEST, 'category_title', '', 'string'));
      $obj->setVar('category_order', xoopsFaq_CleanVars($_REQUEST, 'category_order', 0, 'int'));
      if ($category_handler->insert($obj, true)) {
        redirect_header('category.php', 1, _AM_XOOPSFAQ_DBSUCCESS);
      }
    }
    $category_handler->displayError(_AM_XOOPSFAQ_ERRORCOULDNOTADDCAT);
    break;

  case 'default':
  default:
//    xoops_cp_header();
    //xoopsFaq_AdminMenu(1);
    $index_admin = new ModuleAdmin();
    echo $index_admin->addNavigation('category.php');
    //xoopsFaq_DisplayHeading(_AM_XOOPSFAQ_CATEGORY_HEADER, _AM_XOOPSAQ_CATEGORY_LIST_DSC);
    xoopsFaq_DisplayHeading('', _AM_XOOPSFAQ_CATEGORY_LIST_DSC);
    $category_handler->displayAdminListing();
    break;
}
//xoopsFaq_cp_footer();
include_once 'admin_footer.php';