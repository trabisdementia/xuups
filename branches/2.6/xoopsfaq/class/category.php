<?php
/**
 * Name: category.php
 * Description: Xoops FAQ Category Class
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package : Xoops
 * @Module : Xoops FAQ
 * @subpackage : Xoops FAQ Category
 * @since 2.3.0
 * @author John Neill
 * @version $Id$
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

/**
 * XoopsfaqCategory
 *
 * @package Xoops FAQ
 * @author John Neill
 * @copyright Copyright (c) 2009
 * @version $Id$
 * @access public
 */
class XoopsfaqCategory extends XoopsObject {
  /**
   * XoopsfaqCategory::__construct()
   */
  function __construct() {
    $this->XoopsObject();
    $this->initVar('category_id', XOBJ_DTYPE_INT, null, false);
    $this->initVar('category_title', XOBJ_DTYPE_TXTBOX, null, true, 255);
    $this->initVar('category_order', XOBJ_DTYPE_INT, 0, false);
  }

  /**
   * XoopsfaqCategory::XoopsfaqCategory()
   */
  function XoopsfaqCategory() {
    $this->__construct();
  }

  /**
   * XoopsfaqCategory::displayForm()
   *
   * @return
   */
  function displayForm() {
    include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
    $caption = ($this->isNew()) ? _AM_XOOPSFAQ_CREATENEW : sprintf(_AM_XOOPSFAQ_MODIFYITEM, $this->getVar('category_title'));

    $form = new XoopsThemeForm($caption, 'content', xoops_getenv('PHP_SELF'));
    $form->addElement(new XoopsFormHiddenToken());
    $form->addElement(new xoopsFormHidden('op', 'save'));
    $form->addElement(new xoopsFormHidden('category_id', $this->getVar('category_id', 'e')));
    // title
    $category_title = new XoopsFormText(_AM_XOOPSFAQ_E_CATEGORY_TITLE, 'category_title', 50, 150, $this->getVar('category_title', 'e'));
    $category_title->setDescription(_AM_XOOPSFAQ_E_CATEGORY_TITLE_DSC);
    $form->addElement($category_title, true);
    // order
    $category_order = new XoopsFormText(_AM_XOOPSFAQ_E_CATEGORY_WEIGHT, 'category_order', 5, 5, $this->getVar('category_order', 'e'));
    $category_order->setDescription(_AM_XOOPSFAQ_E_CATEGORY_WEIGHT_DSC);
    $form->addElement($category_order, false);

    $btnTray = new XoopsFormElementTray('', '');
    $btnSubmit = new XoopsFormButton('', 'submit', _SUBMIT, 'submit');
    $btnTray->addElement( $btnSubmit );

    $btnCancel = new XoopsFormButton('', '', _CANCEL, 'button');
    $btnCancel->setExtra('onclick="history.go(-1)"');
    $btnTray->addElement($btnCancel);
    $form->addElement($btnTray);

    $form->display();
  }
}

/**
 * XoopsfaqCategoryHandler
 *
 * @package
 * @author John
 * @copyright Copyright (c) 2009
 * @version $Id$
 * @access public
 */
class XoopsfaqCategoryHandler extends XoopsPersistableObjectHandler {
  /**
   * XoopsfaqCategoryHandler::__construct()
   *
   * @param mixed $db
   */
  function __construct(&$db) {
    parent::__construct($db, 'xoopsfaq_categories', 'XoopsfaqCategory', 'category_id', 'category_title');
  }

  /**
   * XoopsfaqCategoryHandler::XoopsfaqCategoryHandler()
   *
   * @param mixed $db
   */
  function XoopsfaqCategoryHandler(&$db) {
    $this->__construct($db);
  }

  /**
   * XoopsfaqCategoryHandler::getObj()
   *
   * @return
   */
  function &getObj() {
    $myts = &MyTextSanitizer::getInstance();
    $obj = false;
    $criteria = new CriteriaCompo();
    $obj['count'] = $this->getCount($criteria);
    if (!empty($args[0])) {
      $criteria->setSort($myts->addSlashes('ASC'));
      $criteria->setOrder($myts->addSlashes('category_id'));
      $criteria->setStart(0);
      $criteria->setLimit(0);
    }
    $obj['list'] = &$this->getObjects($criteria, false);
    return $obj;
  }

  /**
   * XoopsfaqCategoryHandler::displayAdminListing()
   *
   * @return
   */
  function displayAdminListing() {
    $objects = $this->getObj();

    $buttons = array('edit', 'delete');

    $ret = "<table style='width: 100%; border-width: 0px; padding: 2px margin: 1px;' class='outer'>\n"
         . "  <tr class='xoopsCenter'>\n"
         . "    <th style='width: 5%;'>" . _AM_XOOPSFAQ_CATEGORY_ID . "</th>\n"
         . "    <th style='text-align: left;'>" . _AM_XOOPSFAQ_CATEGORY_TITLE . "</th>\n"
         . "    <th style='width: 5%;'>" . _AM_XOOPSFAQ_CATEGORY_WEIGHT . "</th>\n"
         . "    <th style='width: 20%;'>" . _AM_XOOPSFAQ_ACTIONS . "</th>\n"
         . "  </tr>";
    if ($objects['count'] > 0) {
      foreach ($objects['list'] as $object) {
        $ret .= "  <tr class='xoopsCenter'>\n"
              . "    <td class='even'>" . $object->getVar('category_id') . "</td>\n"
              . "    <td style='text-align: left;' class='even'>" . $object->getVar('category_title') . "</td>\n"
              . "    <td style='text-align: center;' class='even'>" . $object->getVar('category_order') . "</td>\n"
              . "    <td style='text-align: center;' class='even'>";
        $ret .= xoopsFaq_getIcons($buttons, 'category_id', $object->getVar('category_id'), $extra = null);
        $ret .= "    </td>\n"
              . "  </tr>";
      }
    } else {
      $ret .= "  <tr style='text-align: center;'><td colspan='4' class='even'>" . _AM_XOOPSFAQ_NOLISTING . "</td></tr>\n";
    }
    $ret .= "  <tr style='text-align: center;'><td colspan='4' class='head'>&nbsp;</td></tr>\n"
          . "</table>\n";
    echo $ret;
  }

  /**
   * XoopsfaqCategoryHandler::DisplayError()
   *
   * @return
   */
  function displayError($errorString = '') {
    xoops_cp_header();
    xoopsFaq_AdminMenu(1);
    xoopsFaq_DisplayHeading(_AM_XOOPSFAQ_CATEGORY_HEADER, _AM_XOOPSFAQ_SUBERROR);
    if (!is_array($errorString)) {
      echo $errorString;
    } else {
      echo $errorString;
    }
    xoops_cp_footer();
    exit();
  }
}