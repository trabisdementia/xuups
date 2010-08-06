<?php

/**
 * Contains the basic classe for managing a category object based on SmartObject
 *
 * @license GNU
 * @author marcan <marcan@smartfactory.ca>
 * @version $Id: smartobjectcategory.php 799 2008-02-04 22:14:27Z malanciault $

 * @link http://smartfactory.ca The SmartFactory
 * @package SmartObject
 * @subpackage SmartObjectItems
 */

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}
include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartseoobject.php";
class SmartobjectCategory extends SmartSeoObject {

    var $_categoryPath;

    function SmartobjectCategory() {
        $this->initVar('categoryid', XOBJ_DTYPE_INT, '', true);
        $this->initVar('parentid', XOBJ_DTYPE_INT, '', false, null, '', false, _CO_SOBJECT_CATEGORY_PARENTID, _CO_SOBJECT_CATEGORY_PARENTID_DSC);
        $this->initVar('name', XOBJ_DTYPE_TXTBOX, '', false, null, '', false, _CO_SOBJECT_CATEGORY_NAME, _CO_SOBJECT_CATEGORY_NAME_DSC);
        $this->initVar('description', XOBJ_DTYPE_TXTAREA, '', false, null, '', false, _CO_SOBJECT_CATEGORY_DESCRIPTION, _CO_SOBJECT_CATEGORY_DESCRIPTION_DSC);
        $this->initVar('image', XOBJ_DTYPE_TXTBOX, '', false, null, '',  false, _CO_SOBJECT_CATEGORY_IMAGE, _CO_SOBJECT_CATEGORY_IMAGE_DSC);

        $this->initCommonVar('doxcode');

        $this->setControl('image', array('name' => 'image'));
        $this->setControl('parentid', array('name' => 'parentcategory'));
        $this->setControl('description', array('name' => 'textarea',
                                            'itemHandler' => false,
                                            'method' => false,
                                            'module' => false,
                                            'form_editor' => 'default'));

        // call parent constructor to get SEO fields initiated
        $this->SmartSeoObject();
    }

    /**
     * returns a specific variable for the object in a proper format
     *
     * @access public
     * @param string $key key of the object's variable to be returned
     * @param string $format format to use for the output
     * @return mixed formatted value of the variable
     */
    function getVar($key, $format = 's') {
        if ($format == 's' && in_array($key, array('description', 'image'))) {
            return call_user_func(array($this,$key));
        }
        return parent::getVar($key, $format);
    }

    function description() {
        return $this->getValueFor('description', false);
    }

    function image() {
        $ret = $this->getVar('image', 'e');
        if ($ret == '-1') {
            return false;
        } else {
            return $ret;
        }
    }

    function toArray() {
        $this->setVar('doxcode', true);
        global $myts;
        $objectArray = parent::toArray();
        if ($objectArray['image']) {
            $objectArray['image'] = $this->getImageDir() . $objectArray['image'];
        }
        return $objectArray;
    }
    /**
     * Create the complete path of a category
     *
     * @todo this could be improved as it uses multiple queries
     * @param bool $withAllLink make all name clickable
     * @return string complete path (breadcrumb)
     */
    function getCategoryPath($withAllLink=true, $currentCategory=false)	{

        include_once SMARTOBJECT_ROOT_PATH . "class/smartobjectcontroller.php";
        $controller = new SmartObjectController($this->handler);

        if (!$this->_categoryPath) {
            if ($withAllLink && !$currentCategory) {
                $ret = $controller->getItemLink($this);
            } else {
                $currentCategory = false;
                $ret = $this->getVar('name');
            }
            $parentid = $this->getVar('parentid');
            if ($parentid != 0) {
                $parentObj =& $this->handler->get($parentid);
                if ($parentObj->isNew()) {
                    exit;
                }
                $parentid = $parentObj->getVar('parentid');
                $ret = $parentObj->getCategoryPath($withAllLink, $currentCategory) . " > " .$ret;
            }
            $this->_categoryPath = $ret;
        }

        return $this->_categoryPath;
    }

}

class SmartobjectCategoryHandler extends SmartPersistableObjectHandler {

    var $allCategoriesObj = false;
    var $_allCategoriesId = false;

    function SmartobjectCategoryHandler($db, $modulename) {
        $this->SmartPersistableObjectHandler($db, 'category', 'categoryid', 'name', 'description', $modulename);
    }

    function getAllCategoriesArray($parentid=0, $perm_name=false, $sort = 'parentid', $order='ASC') {

        if (!$this->allCategoriesObj) {
            $criteria = new CriteriaCompo();
            $criteria->setSort($sort);
            $criteria->setOrder($order);
            global $xoopsUser;
            $userIsAdmin = is_object($xoopsUser) && $xoopsUser->isAdmin();

            if ($perm_name && !$userIsAdmin) {
                if (!$this->setGrantedObjectsCriteria($criteria, $perm_name)) {
                    return false;
                }
            }

            $this->allCategoriesObj =& $this->getObjects($criteria, 'parentid');
        }

        $ret = array();
        if (isset($this->allCategoriesObj[$parentid])) {
            foreach($this->allCategoriesObj[$parentid] as $categoryid=>$categoryObj) {
                $ret[$categoryid]['self'] =& $categoryObj->toArray();
                if (isset($this->allCategoriesObj[$categoryid])) {
                    $ret[$categoryid]['sub'] =& $this->getAllCategoriesArray($categoryid);
                    $ret[$categoryid]['subcatscount'] = count($ret[$categoryid]['sub']);
                }
            }
        }
        return $ret;
    }

    function getParentIds($parentid, $asString=true) {

        if (!$this->allCategoriesId) {

            $ret = array();
            $sql = 'SELECT categoryid, parentid FROM '.$this->table . " AS " . $this->_itemname . ' ORDER BY parentid';

            $result = $this->db->query($sql);

            if (!$result) {
                return $ret;
            }

            while ($myrow = $this->db->fetchArray($result)) {
                $this->allCategoriesId[$myrow['categoryid']] =  $myrow['parentid'];
            }
        }

        $retArray = array($parentid);
        while ($parentid != 0) {
            $parentid = $this->allCategoriesId[$parentid];
            if ($parentid != 0) {
                $retArray[] = $parentid;
            }
        }
        if ($asString) {
            return implode(', ', $retArray);
        } else {
            return $retArray;
        }
    }
}

?>