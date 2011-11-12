<?php
/**
 * Name: search.inc.php
 * Description: Search function for Xoops FAQ Module
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
 * @subpackage : Search Functions
 * @since 2.3.0
 * @author John Neill
 * @version $Id$
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

/**
 * xoopsfaq_search()
 *
 * @param mixed $queryarray
 * @param mixed $andor
 * @param mixed $limit
 * @param mixed $offset
 * @param mixed $userid
 * @return
 */
function xoopsfaq_search($queryarray, $andor, $limit, $offset, $userid) {
    global $xoopsDB;
    $ret = array();
    if ($userid != 0) {
        return $ret;
    }

    $xfDir = basename( dirname( dirname( __FILE__ ) ) ) ;
    $xfContentsHandler =& xoops_getmodulehandler('contents', $xfDir);
    $contentFields = array('contents_id', 'contents_cid', 'contents_title', 'contents_contents', 'contents_publish');
    $criteria = new CriteriaCompo();
    $criteria->add(new Criteria('contents_active', 1, '='));
    $criteria->setSort('contents_id');
    $criteria->setOrder('DESC');
    $criteria->setLimit(intval($limit));
    $criteria->setStart(intval($offset));

    if ( (is_array($queryarray)) && !empty($queryarray)) {
        $criteria->add(new Criteria('contents_title', "%{$queryarray[0]}%", 'LIKE'));
        $criteria->add(new Criteria('contents_contents', "%{$queryarray[0]}%", 'LIKE'), 'OR');
        array_shift($queryarray); //get rid of first element

        foreach ($queryarray as $query) {
            $criteria->add(new Criteria('contents_title', "%{$query}%", 'LIKE'), $andor);
            $criteria->add(new Criteria('contents_contents', "%{$query}%", 'LIKE'), 'OR');
        }
    }
    $contentArray = $xfContentsHandler->getAll($criteria, $contentFields, false);
    foreach ($contentArray as $content) {
        $ret[] = array ('image' => 'images/question2.gif',
                        'link'  => "index.php?cat_id=" . $content['contents_cid'] . "#" . $content['contents_id'],
                        'title' => $content['contents_title'],
                        'time'  => $content['contents_publish'],
                        );
    }
    unset($contentArray);
    return $ret;
}