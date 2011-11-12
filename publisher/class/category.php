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
 * @version         $Id$
 */

defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

include_once dirname(dirname(__FILE__)) . '/include/common.php';

class PublisherCategory extends XoopsObject
{
    /**
     * @var Xmf_Module_Helper
     * @access private
     */
    private $_publisher = null;

    /**
     * @var PublisherHandler
     */
    private $_handler = null;

    /**
     * @var array
     * @access private
     */
    private $_groups_read = null;

    /**
     * @var array
     * @access private
     */
    private $_groups_submit = null;

    /**
     * @var array
     * @access private
     */
    private $_categoryPath = false;

    /**
     * constructor
     */
    public function __construct()
    {
        $this->_publisher = Xmf_Module_Helper::getInstance(PUBLISHER_DIRNAME);
        $this->_handler = new PublisherHandler();

        $this->initVar("categoryid", XOBJ_DTYPE_INT, null, false);
        $this->initVar("parentid", XOBJ_DTYPE_INT, null, false);
        $this->initVar("name", XOBJ_DTYPE_TXTBOX, null, true, 100);
        $this->initVar("description", XOBJ_DTYPE_TXTAREA, null, false, 255);
        $this->initVar("image", XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar("total", XOBJ_DTYPE_INT, 1, false);
        $this->initVar("weight", XOBJ_DTYPE_INT, 1, false);
        $this->initVar("created", XOBJ_DTYPE_INT, null, false);
        $this->initVar("template", XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar("header", XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar("meta_keywords", XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar("meta_description", XOBJ_DTYPE_TXTAREA, null, false);
        $this->initVar("short_url", XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar("moderator", XOBJ_DTYPE_INT, null, false, 0);

        //not persistent values
        $this->initVar("itemcount", XOBJ_DTYPE_INT, 0, false);
        $this->initVar('last_itemid', XOBJ_DTYPE_INT);
        $this->initVar('last_title_link', XOBJ_DTYPE_TXTBOX);
        $this->initVar("dohtml", XOBJ_DTYPE_INT, 1, false);
    }

    /**
     * Allows $this->getVar('var', 's') using $this->var('s')
     *
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        $arg = isset($args[0]) ? $args[0] : null;
        return $this->getVar($method, $arg);
    }

    /**
     * @return bool
     */
    public function notLoaded()
    {
        return ($this->getVar('categoryid') == -1);
    }

    /**
     * @return void
     */
    public function assignOtherProperties()
    {
        $this->_groups_read = $this->_handler->permission()->getGrantedGroups('category_read', $this->getVar('categoryid'));
        $this->_groups_submit = $this->_handler->permission()->getGrantedGroups('item_submit', $this->getVar('categoryid'));
    }

    /**
     * @return bool
     */
    function checkPermission()
    {
        global $publisher_isAdmin, $xoopsUser;
        $ret = false;

        if ($publisher_isAdmin) {
            return true;
        }

        if (is_object($xoopsUser) && $xoopsUser->getVar('uid') == $this->getVar('moderator')) {
            return true;
        }

        $categoriesGranted = $this->_handler->permission()->getGrantedItems('category_read');
        if (in_array($this->getVar('category'), $categoriesGranted)) {
            $ret = true;
        }
        return $ret;
    }

    /**
     * @param array $groups_read
     * @return void
     */
    public function setGroups_read($groups_read = array('0'))
    {
        $this->_groups_read = $groups_read;
    }

    /**
     * @param array $groups_submit
     * @return void
     */
    public function setGroups_submit($groups_submit = array('1'))
    {
        $this->_groups_submit = $groups_submit;
    }

    /**
     * @param string $format
     * @return mixed|string
     */
    public function image($format = 's')
    {
        if ($this->getVar('image') != '') {
            return $this->getVar('image', $format);
        } else {
            return 'blank.png';
        }
    }

    function getCategoryPath($withAllLink = true)
    {
        if (!$this->_categoryPath) {
            $filename = "category.php";
            if ($withAllLink) {
                $ret = $this->getCategoryLink();
            } else {
                $ret = $this->getVar('name');
            }
            $parentid = $this->getVar('parentid');

            if ($parentid != 0) {
                $parentObj =& $this->_handler->category()->get($parentid);
                if ($parentObj->notLoaded()) {
                    exit('Object not loaded');
                }
                $ret = $parentObj->getCategoryPath($withAllLink) . " > " . $ret;
            }
            $this->_categoryPath = $ret;
        }
        return $this->_categoryPath;
    }

    /**
     * @return array|bool|mixed|string
     */
    public function getCategoryPathForMetaTitle()
    {
        $ret = '';
        $parentid = $this->getVar('parentid');

        if ($parentid != 0) {
            $parentObj =& $this->_handler->category()->get($parentid);
            if ($parentObj->notLoaded()) {
                exit('NOT LOADED');
            }
            $ret = $parentObj->getCategoryPath(false);
            $ret = str_replace(' >', ' -', $ret);
        }
        return $ret;
    }

    /**
     * @return array|null
     */
    public function getGroups_read()
    {
        if (count($this->_groups_read) < 1) {
            $this->assignOtherProperties();
        }
        return $this->_groups_read;
    }

    /**
     * @return array|null
     */
    public function getGroups_submit()
    {
        if (count($this->_groups_submit) < 1) {
            $this->assignOtherProperties();
        }
        return $this->_groups_submit;
    }

    /**
     * @return string
     */
    public function getCategoryUrl()
    {
        return publisher_seo_genUrl('category', $this->getVar('category'), $this->getVar('short_url'));
    }

    /**
     * @param bool $class
     * @return string
     */
    public function getCategoryLink($class = false)
    {
        if ($class) {
            return "<a class='$class' href='" . $this->getCategoryUrl() . "'>" . $this->getVar('name') . "</a>";
        } else {
            return "<a href='" . $this->getCategoryUrl() . "'>" . $this->getVar('name') . "</a>";
        }
    }

    /**
     * @param bool $sendNotifications
     * @param bool $force
     * @return bool
     */
    public function store($sendNotifications = true, $force = true)
    {
        $ret = $this->_handler->category()->insert($this, $force);
        if ($sendNotifications && $ret && ($this->isNew())) {
            $this->sendNotifications();
        }
        $this->unsetNew();
        return $ret;
    }

    /**
     * @return void
     */
    public function sendNotifications()
    {
        $tags = array();
        $tags['MODULE_NAME'] = $this->_publisher->getObject()->getVar('name');
        $tags['CATEGORY_NAME'] = $this->getVar('name');
        $tags['CATEGORY_URL'] = $this->getCategoryUrl();
        $this->_handler->notification()->triggerEvent('global_item', 0, 'category_created', $tags);
    }

    /**
     * @param array $category
     * @return array
     */
    public function toArray($category = array())
    {
        $category['categoryid'] = $this->getVar('category');
        $category['name'] = $this->getVar('name');
        $category['categorylink'] = $this->getCategoryLink();
        $category['categoryurl'] = $this->getCategoryUrl();
        $category['total'] = ($this->getVar('itemcount') > 0) ? $this->getVar('itemcount') : '';
        $category['description'] = $this->getVar('description');
        $category['header'] = $this->getVar('header');
        $category['meta_keywords'] = $this->getVar('meta_keywords');
        $category['meta_description'] = $this->getVar('meta_description');
        $category['short_url'] = $this->getVar('short_url');

        if ($this->getVar('last_itemid') > 0) {
            $category['last_itemid'] = $this->getVar('last_itemid', 'n');
            $category['last_title_link'] = $this->getVar('last_title_link', 'n');
        }

        if ($this->image() != 'blank.png') {
            $category['image_path'] = publisher_getImageDir('category', false) . $this->image();

        } else {
            $category['image_path'] = '';
        }
        $category['lang_subcategories'] = sprintf(_CO_PUBLISHER_SUBCATEGORIES_INFO, $this->getVar('name'));
        return $category;
    }

    /**
     * @param array $category
     * @return array
     */
    public function toArrayTable($category = array())
    {
        $category['categoryid'] = $this->getVar('category');
        $category['categorylink'] = $this->getCategoryLink();
        $category['total'] = ($this->getVar('itemcount') > 0) ? $this->getVar('itemcount') : '';
        $category['description'] = $this->getVar('description');

        if ($this->getVar('last_itemid') > 0) {
            $category['last_itemid'] = $this->getVar('last_itemid', 'n');
            $category['last_title_link'] = $this->getVar('last_title_link', 'n');
        }

        if ($this->image() != 'blank.png') {
            $category['image_path'] = publisher_getImageDir('category', false) . $this->image();

        } else {
            $category['image_path'] = '';
        }
        $category['lang_subcategories'] = sprintf(_CO_PUBLISHER_SUBCATEGORIES_INFO, $this->getVar('name'));
        return $category;
    }

    /**
     * @return void
     */
    public function createMetaTags()
    {
        $publisher_metagen = new Xmf_Metagen($this->getVar('name'), $this->getVar('meta_keywords'), $this->getVar('meta_description'), $this->getCategoryPathForMetaTitle());
        $publisher_metagen->addMetaKeywords($this->_publisher->getConfig('seo_meta_keywords'));
        $publisher_metagen->createMetaTags();
    }

    /**
     * @param int $subCatsCount
     * @return PublisherCategoryForm
     */
    public function getForm($subCatsCount = 4)
    {
        include_once dirname(__FILE__) . '/form/category.php';
        $form = new PublisherCategoryForm($this, $subCatsCount);
        return $form;
    }
}

/**
 * Categories handler class.
 * This class is responsible for providing data access mechanisms to the data source
 * of Category class objects.
 *
 * @author marcan <marcan@notrevie.ca>
 * @package Publisher
 */
class PublisherCategoryHandler extends XoopsPersistableObjectHandler
{
    /**
     * @var Xmf_Module_Helper
     * @access public
     */
    private $_publisher = null;

    /**
     * @var PublisherHandler
     */
    private $_handler = null;

    /**
     * @param XoopsDatabase $db
     */
    public function __construct(XoopsDatabase &$db)
    {
        $this->_publisher =& Xmf_Module_Helper::getInstance(PUBLISHER_DIRNAME);
        $this->_handler = new PublisherHandler();
        parent::__construct($db, "publisher_categories", 'PublisherCategory', "categoryid", "name");
    }

    /**
     * retrieve an item
     *
     * @param int $id itemid of the user
     * @return PublisherCategory reference to the {@link PublisherCategory} object, FALSE if failed
     */
    public function &get($id)
    {
        /* @var $obj PublisherCategory */
        $obj = parent::get($id);
        if (is_object($obj)) {
            $obj->assignOtherProperties();
        }
        return $obj;
    }

    /**
     * insert a new category in the database
     *
     * @param PublisherCategory $category reference to the {@link PublisherCategory} object
     * @param bool $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(PublisherCategory &$category, $force = false)
    {
        // Auto create meta tags if empty
        if (!$category->getVar('meta_keywords')|| !$category->getVar('meta_description')) {
            $publisher_metagen = new Xmf_Metagen($category->getVar('name'), $category->getVar('meta_keywords'), $category->getVar('description'));
            if (!$category->getVar('meta_keywords')) {
                $category->setVar('meta_keywords', $publisher_metagen->getKeywords());
            }

            if (!$category->getVar('meta_description')) {
                $category->setVar('meta_description', $publisher_metagen->getDescription());
            }

            // Auto create short_url if empty
            if (!$category->getVar('short_url')) {
                $category->setVar('short_url', $publisher_metagen->generateSeoTitle($category->getVar('name', 'n'), false));
            }
        }

        $ret = parent::insert($category, $force);
        return $ret;
    }

    /**
     * delete a category from the database
     *
     * @param PublisherCategory $category reference to the category to delete
     * @param bool $force
     * @return bool FALSE if failed.
     */
    function delete(PublisherCategory &$category, $force = false)
    {
        // Deleting this category ITEMs
        $criteria = new Criteria('categoryid', $category->getVar('categoryid'));
        $this->_handler->item()->deleteAll($criteria);
        unset($criteria);


        // Deleting the sub categories
        $subcats = $this->getCategories(0, 0, $category->getVar('categoryid'));
        foreach ($subcats as $subcat) {
            $this->delete($subcat);
        }

        if (!parent::delete($category, $force)) {
            $category->setErrors('An error while deleting.');
            return false;
        }
        $module_id = $this->_publisher->getObject()->getVar('mid');
        $this->_handler->groupperm()->deleteByModule($module_id, "category_read", $category->getVar('categoryid'));
        $this->_handler->groupperm()->deleteByModule($module_id, "item_submit", $category->getVar('categoryid'));
        return true;
    }

    /**
     * retrieve categories from the database
     *
     * @param CriteriaElement $criteria {@link CriteriaElement} conditions to be met
     * @param bool $id_as_key use the categoryid as key for the array?
     * @return array array of {@link XoopsItem} objects
     */
    public function getObjects(CriteriaElement $criteria = null, $id_as_key = false)
    {
        $ret = array();
        $theObjects = parent::getObjects($criteria, true);

        $itemsObj_array_keys = array_keys($theObjects);

        $publisher_category_group = $this->_handler->permission()->getGrantedGroupsForIds($itemsObj_array_keys);

        /* @var $theObject PublisherCategory */
        foreach ($theObjects as $theObject) {
            $categoryId = $theObject->getVar('categoryid');
            $theObject->setGroups_read(isset($publisher_category_group['category_read'][$categoryId])
                ? $publisher_category_group['category_read'][$categoryId] : array());
            $theObject->setGroups_submit(isset($publisher_category_group['item_submit'][$categoryId])
                ? $publisher_category_group['item_submit'][$categoryId] : array());

            if (!$id_as_key) {
                $ret[] =& $theObject;
            } else {
                $ret[$categoryId] =& $theObject;
            }
            unset($theObject);
        }

        return $ret;
    }

    /**
     * @return array
     */
    public function getAllCategoriesObj()
    {
        static $publisher_allCategoriesObj;

        if (!isset($publisher_allCategoriesObj)) {
            $publisher_allCategoriesObj = $this->getObjects(null, true);
            $publisher_allCategoriesObj[0] = array();
        }

        return $publisher_allCategoriesObj;
    }

    /**
     * @param int $limit
     * @param int $start
     * @param int $parentid
     * @param string $sort
     * @param string $order
     * @param bool $id_as_key
     * @return array
     */
    public function &getCategories($limit = 0, $start = 0, $parentid = 0, $sort = 'weight', $order = 'ASC', $id_as_key = true)
    {
        global $publisher_isAdmin, $xoopsUser;

        $criteria = new CriteriaCompo();

        $criteria->setSort($sort);
        $criteria->setOrder($order);

        if ($parentid != -1) {
            $criteria->add(new Criteria('parentid', $parentid));
        }

        if (!$publisher_isAdmin) {
            $categoriesGranted = $this->_handler->permission()->getGrantedItems('category_read');
            if (count($categoriesGranted) > 0) {
                $criteria->add(new Criteria('categoryid', '(' . implode(',', $categoriesGranted) . ')', 'IN'));
            }
            if (is_object($xoopsUser)) {
                $criteria->add(new Criteria('moderator', $xoopsUser->getVar('uid')), 'OR');
            }
        }

        $criteria->setStart($start);
        $criteria->setLimit($limit);
        $ret = $this->getObjects($criteria, $id_as_key);
        return $ret;
    }

    /**
     * @param array $category
     * @param int $level
     * @param array $cat_array
     * @param array $cat_result
     * @return void
     */
    function getSubCatArray($category, $level, $cat_array, $cat_result)
    {
        global $theresult;

        $spaces = '';
        for ($j = 0; $j < $level; $j++) {
            $spaces .= '--';
        }
        $theresult[$category['categoryid']] = $spaces . $category['name'];
        if (isset($cat_array[$category['categoryid']])) {
            $level = $level + 1;
            foreach ($cat_array[$category['categoryid']] as $cat) {
                $this->getSubCatArray($cat, $level, $cat_array, $cat_result);
            }
        }
    }

    /**
     * @return array
     */
    public function getCategoriesForSubmit()
    {
        global $publisher_isAdmin, $theresult, $xoopsUser;
        $ret = array();

        $criteria = new CriteriaCompo();
        $criteria->setSort('name');
        $criteria->setOrder('ASC');

        if (!$publisher_isAdmin) {
            $categoriesGranted = $this->_handler->permission()->getGrantedItems('item_submit');
            if (count($categoriesGranted) > 0) {
                $criteria->add(new Criteria('categoryid', '(' . implode(',', $categoriesGranted) . ')', 'IN'));
            }
            if (is_object($xoopsUser)) {
                $criteria->add(new Criteria('moderator', $xoopsUser->getVar('uid')), 'OR');
            }
        }

        $categories = $this->getAll($criteria, array('categoryid', 'parentid', 'name'), false, false);

        if (count($categories) == 0) {
            return $ret;
        }

        $cat_array = array();

        foreach ($categories as $cat) {
            $cat_array[$cat['parentid']][$cat['categoryid']] = $cat;
        }

        // Needs to have permission on at least 1 top level category
        if (!isset($cat_array[0])) {
            return $ret;
        }

        $cat_result = array();
        foreach ($cat_array[0] as $thecat) {
            $level = 0;
            $this->getSubCatArray($thecat, $level, $cat_array, $cat_result);
        }

        return $theresult; //this is a global
    }

    /**
     * @return array
     */
    function getCategoriesForSearch()
    {
        global $publisher_isAdmin, $theresult, $xoopsUser;

        $ret = array();
        $criteria = new CriteriaCompo();
        $criteria->setSort('name');
        $criteria->setOrder('ASC');

        if (!$publisher_isAdmin) {
            $categoriesGranted = $this->_handler->permission()->getGrantedItems('category_read');
            if (count($categoriesGranted) > 0) {
                $criteria->add(new Criteria('categoryid', '(' . implode(',', $categoriesGranted) . ')', 'IN'));
            }
            if (is_object($xoopsUser)) {
                $criteria->add(new Criteria('moderator', $xoopsUser->getVar('uid')), 'OR');
            }
        }

        $categories = $this->getAll($criteria, array('categoryid', 'parentid', 'name'), false, false);

        if (count($categories) == 0) {
            return $ret;
        }

        $cat_array = array();

        foreach ($categories as $cat) {
            $cat_array[$cat['parentid']][$cat['categoryid']] = $cat;
        }

        // Needs to have permission on at least 1 top level category
        if (!isset($cat_array[0])) {
            return $ret;
        }

        $cat_result = array();
        foreach ($cat_array[0] as $thecat) {
            $level = 0;
            $this->getSubCatArray($thecat, $level, $cat_array, $cat_result);
        }

        return $theresult; //this is a global
    }

    /**
     * @param int $parentid
     * @return int
     */
    public function getCategoriesCount($parentid = 0)
    {
        global $publisher_isAdmin, $xoopsUser;

        if ($parentid == -1) {
            return $this->getCount();
        }
        $criteria = new CriteriaCompo();
        if (isset($parentid) && ($parentid != -1)) {
            $criteria->add(new criteria('parentid', $parentid));
            if (!$publisher_isAdmin) {
                $categoriesGranted = $this->_handler->permission()->getGrantedItems('category_read');
                if (count($categoriesGranted) > 0) {
                    $criteria->add(new Criteria('categoryid', '(' . implode(',', $categoriesGranted) . ')', 'IN'));
                }
                if (is_object($xoopsUser)) {
                    $criteria->add(new Criteria('moderator', $xoopsUser->getVar('uid')), 'OR');
                }
            }
        }
        return $this->getCount($criteria);
    }

    /**
     * Get all subats and put them in an array indexed by parent id
     *
     * @param array $categories
     * @return array
     */
    public function getSubCats(&$categories)
    {
        global $publisher_isAdmin, $xoopsUser;

        $criteria = new CriteriaCompo('parentid', "(" . implode(',', array_keys($categories)) . ")", 'IN');
        $ret = array();
        if (!$publisher_isAdmin) {
            $categoriesGranted = $this->_handler->permission()->getGrantedItems('category_read');
            if (count($categoriesGranted) > 0) {
                $criteria->add(new Criteria('categoryid', '(' . implode(',', $categoriesGranted) . ')', 'IN'));
            }
            if (is_object($xoopsUser)) {
                $criteria->add(new Criteria('moderator', $xoopsUser->getVar('uid')), 'OR');
            }
        }
        $criteria->setSort('weight');
        $criteria->setOrder('ASC');
        $subcats = $this->getObjects($criteria, true);
        /* @var $subcat PublisherCategory */
        foreach ($subcats as $subcat) {
            $ret[$subcat->getVar('parentid')][$subcat->getVar('categoryid')] = $subcat;
        }
        return $ret;
    }

    /**
     * delete categories matching a set of conditions
     *
     * @param CriteriaElement $criteria {@link CriteriaElement}
     * @return bool FALSE if deletion failed
     */
    public function deleteAll(CriteriaElement $criteria = null)
    {
        $categories = $this->getObjects($criteria);
        foreach ($categories as $category) {
            if (!$this->delete($category)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param int $cat_id
     * @return array
     */
    public function publishedItemsCount($cat_id = 0)
    {
        return $this->itemsCount($cat_id, array(_PUBLISHER_STATUS_PUBLISHED));
    }

    /**
     * @param int $cat_id
     * @param string $status
     * @return array
     */
    public function itemsCount($cat_id = 0, $status = '')
    {
        return $this->_handler->item()->getCountsByCat($cat_id, $status);
    }

}