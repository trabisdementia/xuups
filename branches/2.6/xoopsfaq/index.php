<?php
/**
 * Name: index.php
 * Description: Dispaly user side code, categories and faq answers
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
 * @package : XOOPS
 * @Module : Xoops FAQ
 * @subpackage : User side code
 * @since 2.3.0
 * @author John Neill
 * @version $Id$
 */
include_once 'header.php';

$category_handler = &xoops_getModuleHandler('category');
$content_handler = &xoops_getModuleHandler('contents');

$cat_id = xoopsFaq_CleanVars($_GET, 'cat_id', 0, 'int');
if ($cat_id < 1) {
  $xoopsOption['template_main'] = 'xoopsfaq_index.html';
  include_once XOOPS_ROOT_PATH . '/header.php';
  /**
   * Display Categories and a list of Answers Max 10
   */
  $objects = $category_handler->getObj();
  if ($objects['count'] > 0) {
    foreach ($objects['list'] as $object) {
      $category = array();
      $category['id'] = $object->getVar('category_id');
      $category['name'] = $object->getVar('category_title');
      $contentsObj = $content_handler->getPublished($object->getVar('category_id'));
      if ($contentsObj['count']) {
        foreach ($contentsObj['list'] as $content) {
          $category['questions'][] = array('link' => $content->getVar('contents_id'), 'title' => $content->getVar('contents_title'));
        }
      }
      $xoopsTpl->append_by_ref('categories', $category);
      unset($category);
    }
  }
} else {
  $xoopsOption['template_main'] = 'xoopsfaq_category.html';
  include_once XOOPS_ROOT_PATH . '/header.php';
  /**
   * Display answers to a specific category
   */
  $category = $category_handler->get($cat_id);
  $xoopsTpl->assign('category_name', $category->getVar('category_title'));

  $contentsObj = $content_handler->getPublished($cat_id);
  if ($contentsObj['count']) {
    foreach ($contentsObj['list'] as $obj) {
      $question['title'] = $obj->getVar('contents_title');
      $question['id'] = $obj->getVar('contents_id');
      $question['answer'] = $obj->getVar('contents_contents');
      $xoopsTpl->append('questions', $question);
    }
  }
  include XOOPS_ROOT_PATH . '/include/comment_view.php';
}

include 'footer.php';