<?php

/**
* $Id: category.php 3433 2008-07-05 10:24:09Z malanciault $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
*/

if (!defined("XOOPS_ROOT_PATH")) {
	die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH.'/modules/publisher/include/common.php';

class PublisherCategory extends XoopsObject
{
    /**
     * @var array
	 * @access private
     */
    var $_groups_read = null;

    /**
     * @var array
	 * @access private
     */
    var $_groups_submit = null;

    /**
     * @var array
	 * @access private
     */
    var $_groups_admin = null;


    /**
     * @var array
	 * @access private
     */
    var $_categoryPath = false;

	/**
	* constructor
	*/
	function PublisherCategory()
	{
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

		//not persistent values
		$this->initVar("itemcount", XOBJ_DTYPE_INT, 0, false);
		$this->initVar('last_itemid', XOBJ_DTYPE_INT);
		$this->initVar('last_title_link', XOBJ_DTYPE_TXTBOX);

		$this->initVar("dohtml", XOBJ_DTYPE_INT, 1, false);
	}

	function notLoaded()
	{
	   return ($this->getVar('categoryid') == -1);
	}

	function assignOtherProperties()
	{
		/*
		global $xoopsUser, $publisher_permission_handler;

		if (!$publisher_permission_handler) {
			$publisher_permission_handler = xoops_getmodulehandler('permission', 'publisher')	;
		}
		$this->_groups_read = $publisher_permission_handler->getGrantedGroups('category_read', $this->categoryid());
		$this->_groups_submit = $publisher_permission_handler->getGrantedGroups('item_submit', $this->categoryid());
		*/
	}

	function checkPermission()
	{
		global $publisher_isAdmin;

		if ($publisher_isAdmin) {
			return true;
		}

		$publisherPermHandler =& xoops_getmodulehandler('permission', 'publisher');

		$categoriesGranted = $publisherPermHandler->getGrantedItems('category_read');
		if (in_array($this->categoryid(), $categoriesGranted)) {
			$ret = true;
		}
		return $ret;
	}

	function categoryid()
	{
		return $this->getVar("categoryid");
	}

	function parentid()
	{
		return $this->getVar("parentid");
	}

	function name($format = "S")
	{
		$ret = $this->getVar("name", $format);
		if (($format == 's') || ($format == 'S') || ($format == 'show')) {
			$myts = &MyTextSanitizer::getInstance();
			$ret = $myts->displayTarea($ret);
		}
		return $ret;
	}

	function description($format = "S")
	{
		return $this->getVar("description", $format);
	}

	function image($format = "S")
	{
		if ($this->getVar('image') != '') {
		 	return $this->getVar('image', $format);
		} else {
			return 'blank.png';
		}
	}

	function weight()
	{
		return $this->getVar("weight");
	}

	function template()
	{
		return $this->getVar("template", 'n');
	}

	function header($format = "S")
	{
		return $this->getVar("header", $format);
	}


	function meta_keywords($format = "S")
	{
		return $this->getVar("meta_keywords", $format);
	}

	function meta_description($format = "S")
	{
		return $this->getVar("meta_description", $format);
	}

	function short_url($format = "S")
	{
		return $this->getVar("short_url", $format);
	}

	function getCategoryPath($withAllLink = true)
	{
		if (!$this->_categoryPath) {
			$filename = "category.php";
			if ($withAllLink) {
				$ret = $this->getCategoryLink();
			} else {
				$ret = $this->name();
			}
			$parentid = $this->parentid();
			$publisher_category_handler =& xoops_getmodulehandler('category', 'publisher');
			if ($parentid != 0) {
				$parentObj =& $publisher_category_handler->get($parentid);
				if ($parentObj->notLoaded()) {
					exit;
				}
				$parentid = $parentObj->parentid();
				$ret = $parentObj->getCategoryPath($withAllLink) . " > " .$ret;
			}
			$this->_categoryPath = $ret;
        }
		return $this->_categoryPath;
	}

	function getCategoryPathForMetaTitle()
	{
        $ret = '';
        $parentid = $this->parentid();
		$publisher_category_handler =& xoops_getmodulehandler('category', 'publisher');
		if ($parentid != 0) {
			$parentObj =& $publisher_category_handler->get($parentid);
			if ($parentObj->notLoaded()) {
				exit('NOT LOADED');
			}
			$parentid = $parentObj->parentid();
			$ret = $parentObj->getCategoryPath(false);
			$ret = str_replace(' >', ' -', $ret);
		}
		return $ret;
	}

	function getGroups_read()
	{
	    if (count($this->_groups_read) < 1) {
		    $this->assignOtherProperties();
		}
		return $this->_groups_read;
	}

	function setGroups_read($groups_read = array('0'))
	{
	  $this->_groups_read = $groups_read;
	}

	function getGroups_submit()
	{
	    if (count($this->_groups_submit) < 1) {
		    $this->assignOtherProperties();
		}
		return $this->_groups_submit;
	}

	function setGroups_submit($groups_submit = array('0'))
	{
        $this->_groups_submit = $groups_submit;
	}

	function getCategoryUrl()
	{
		return publisher_seo_genUrl('category', $this->categoryid(), $this->short_url());
	}

	function getCategoryLink($class = false)
	{
	 	if ($class) {
	 		return "<a class='$class' href='" . $this->getCategoryUrl() . "'>" . $this->name() . "</a>";
	 	} else {
			return "<a href='" . $this->getCategoryUrl() . "'>" . $this->name() . "</a>";
	 	}
	}

	function store($sendNotifications = true, $force = true )
	{
		global $publisher_category_handler, $publisher_permission_handler;

		$ret = $publisher_category_handler->insert($this, $force);
		if ( $sendNotifications && $ret && ($this->isNew()) ) {
			$this->sendNotifications();
		}
		$this->unsetNew();

		// Storing permissions
		//$publisher_permission_handler->saveItem_Permissions($this->getGroups_read(), $this->categoryid(), 'category_read');
		//$publisher_permission_handler->saveItem_Permissions($this->getGroups_submit(), $this->categoryid(), 'item_submit');

//		publisher_saveCategory_Permissions($this->getGroups_read(), $this->categoryid(), 'category_read');
//		publisher_saveCategory_Permissions($this->getGroups_submit(), $this->categoryid(), 'item_submit');

		return $ret;
	}

	function sendNotifications()
	{
		global $publisher_moduleName;

		$hModule =& xoops_gethandler('module');
    	$smartModule =& $hModule->getByDirname('publisher');
    	$module_id = $smartModule->getVar('mid');

		$notification_handler = &xoops_gethandler('notification');

		$tags = array();
		$tags['MODULE_NAME'] = $publisher_moduleName;
		$tags['CATEGORY_NAME'] = $this->name();
		$tags['CATEGORY_URL'] = $this->getCategoryUrl();

		$notification_handler = &xoops_gethandler('notification');
		$notification_handler->triggerEvent('global_item', 0, 'category_created', $tags);
	}

	function toArray($category = array())
    {
		global $myts;

		$category['categoryid'] = $this->categoryid();
		$category['name'] = $this->name();
	    $category['categorylink'] = $this->getCategoryLink();
		$category['total'] = ($this->getVar('itemcount') > 0) ? $this->getVar('itemcount') : '';
		$category['description'] = $this->description();

		$category['header'] = $this->header();
		$category['meta_keywords'] = $this->meta_keywords();
		$category['meta_description'] = $this->meta_description();
		$category['short_url'] = $this->short_url();

		if ($this->getVar('last_itemid') > 0) {
		    $category['last_itemid'] = $this->getVar('last_itemid', 'n');
			$category['last_title_link'] = $this->getVar('last_title_link', 'n');
		}

		if ($this->image() != 'blank.png') {
			$category['image_path'] = publisher_getImageDir('category', false) . $this->image();

		} else {
			$category['image_path'] = '';
		}
		$category['lang_subcategories'] = sprintf(_MD_PUB_SUBCATEGORIES_INFO, $this->name());
		return $category;
	}

	function createMetaTags() {

		$publisher_metagen = new PublisherMetagen($this->name(), $this->meta_keywords(), $this->meta_description());
		$publisher_metagen->createMetaTags();
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

    function PublisherCategoryHandler(&$db)
    {
        $this->__construct($db);
    }

    function __construct(&$db)
    {
        parent::__construct($db, "publisher_categories", 'PublisherCategory', "categoryid", "name");
    }

    /**
	* retrieve an item
	*
	* @param int $id itemid of the user
	* @return mixed reference to the {@link PublisherCategory} object, FALSE if failed
	*/
	function &get($id)
	{
        $obj = parent::get($id);
        if (is_object($obj)) {
            $obj->assignOtherProperties();
		}
		return $obj;
	}

	/**
	* insert a new category in the database
	*
	* @param object $category reference to the {@link PublisherCategory} object
	* @param bool $force
	* @return bool FALSE if failed, TRUE if already present and unchanged or successful
	*/
	function insert(&$category, $force = false)
	{
		// Auto create meta tags if empty
		if (!$category->meta_keywords() || !$category->meta_description()) {
			$smartobject_metagen = new PublisherMetagen($category->name(), $category->getVar('meta_keywords'), $category->getVar('description'));
			if (!$category->meta_keywords()) {
				$category->setVar('meta_keywords', $smartobject_metagen->_keywords);
			}

			if (!$category->meta_description()) {
				$category->setVar('meta_description', $smartobject_metagen->_description);
			}

		}

		// Auto create short_url if empty
		if (!$category->short_url()) {
			$category->setVar('short_url', $smartobject_metagen->generateSeoTitle($category->name('n'), false));
		}

        $ret = parent::insert($category, $force);
        return $ret;
	}

	/**
	* delete a category from the database
	*
	* @param object $category reference to the category to delete
	* @param bool $force
	* @return bool FALSE if failed.
	*/
	function delete(&$category, $force = false)
	{
		// Deleting this category ITEMs
		global $publisher_item_handler;
		$criteria = new Criteria('categoryid', $category->categoryid());
        $publisher_item_handler->deleteAll($criteria);
        unset($criteria);


		// Deleting the sub categories
		$subcats =& $this->getCategories(0, 0, $category->categoryid());
		foreach ($subcats as $subcat) {
			$this->delete($subcat);
		}

        if (!parent::delete($category, $force)) {
			$category->setErrors('An error while deleting.');
			return false;
		}

		$hModule =& xoops_gethandler('module');
    	$smartModule =& $hModule->getByDirname('publisher');
    	$module_id = $smartModule->getVar('mid');
		xoops_groupperm_deletebymoditem ($module_id, "category_read", $category->categoryid());
		xoops_groupperm_deletebymoditem ($module_id, "item_submit", $category->categoryid());
		//xoops_groupperm_deletebymoditem ($module_id, "category_admin", $categoryObj->categoryid());

		return true;
	}

	/**
	* retrieve categories from the database
	*
	* @param object $criteria {@link CriteriaElement} conditions to be met
	* @param bool $id_as_key use the categoryid as key for the array?
	* @return array array of {@link XoopsItem} objects
	*/
	function &getObjects($criteria = null, $id_as_key = false)
	{
		$ret = array();
		$theObjects = parent::getObjects($criteria, true);

		// since we need category permissions for all these items, let's fetch them only once ;-)
		global $publisher_permission_handler;

		if (!$publisher_permission_handler) {
			$publisher_permission_handler = xoops_getmodulehandler('permission', 'publisher');
		}

		$itemsObj_array_keys = array_keys($theObjects);

		$publisher_category_group = $publisher_permission_handler->getGrantedGroupsForIds($itemsObj_array_keys);

		foreach ($theObjects as $theObject) {

			$theObject->_groups_read = isset($publisher_category_group['category_read'][$theObject->categoryid()]) ? $publisher_category_group['category_read'][$theObject->categoryid()] : array();
			$theObject->_groups_submit = isset($publisher_category_group['item_submit'][$theObject->categoryid()]) ? $publisher_category_group['item_submit'][$theObject->categoryid()] : array();

			if (!$id_as_key) {
				$ret[] =& $theObject;
			} else {
				$ret[$theObject->categoryid()] =& $theObject;
			}
			unset($theObject);
		}

		return $ret;
	}

	function &getCategories($limit = 0, $start = 0, $parentid  = 0, $sort = 'weight', $order = 'ASC', $id_as_key = true)
	{
		global $publisher_isAdmin;

		if (!isset($publisher_isAdmin)) {
			// Find if the user is admin of the module
			$publisher_isAdmin = publisher_userIsAdmin();
		}

		$criteria = new CriteriaCompo();

		$criteria->setSort($sort);
		$criteria->setOrder($order);

		if ($parentid != -1 ) {
			$criteria->add(new Criteria('parentid', $parentid));
		}
		if (!$publisher_isAdmin) {
		    $publisherPermHandler =& xoops_getmodulehandler('permission', 'publisher');

		    $categoriesGranted = $publisherPermHandler->getGrantedItems('category_read');
			$criteria->add(new Criteria('categoryid', "(".implode(',', $categoriesGranted).")", 'IN'));
		}
		$criteria->setStart($start);
		$criteria->setLimit($limit);
		$ret = $this->getObjects($criteria, $id_as_key);
		return $ret;
	}

	function getSubCatArray($category, $level, $cat_array, $cat_result)
    {
		global $theresult;

		$spaces = '';
		for ( $j = 0; $j < $level; $j++ ) {
			$spaces .= '--';
		}
		$theresult[$category['categoryid']] = $spaces . $category['name'];
		if (isset($cat_array[$category['categoryid']])) {
			$level = $level + 1;
			foreach ($cat_array[$category['categoryid']] as $parentid => $cat) {
				$this->getSubCatArray($cat, $level, $cat_array, $cat_result);
			}
		}
	}

	function &getCategoriesForSubmit()
	{
		global $publisher_isAdmin, $publisher_permission_handler, $theresult;

		$where_clause = '';

		if (!$publisher_isAdmin) {
		    $categoriesGranted = $publisher_permission_handler->getGrantedItems('item_submit');
		    $where_clause = " WHERE categoryid IN (" . implode(', ', $categoriesGranted) . ")";
		}

		$sql = "SELECT categoryid, parentid, name FROM " . $this->db->prefix('publisher_categories') . $where_clause . " ORDER BY name ASC";

		$result = $this->db->query($sql);
		if (!$result) {
			return false;
		}

		$cat_array = array();

		while ($myrow = $this->db->fetchArray($result)) {
			$cat_array[$myrow['parentid']][$myrow['categoryid']] = $myrow;
		}
		if (count($cat_array) == 0) {
			return false;
		}
		$cat_result = array();

		// Needs to have permission on at least 1 top level category
		if (!isset($cat_array[0])) {
			return false;
		}

		foreach ($cat_array[0] as $thecat) {
			$level = 0;
			$this->getSubCatArray($thecat, $level, $cat_array, $cat_result);
		}

		return $theresult;
	}

	function getCategoriesCount($parentid = 0)
	{
		global $publisher_isAdmin;

		if ($parentid == -1)  {
			return $this->getCount();
		}
		$criteria = new CriteriaCompo();
		if (isset($parentid) && ($parentid != -1)) {
		    $criteria->add(new criteria('parentid', $parentid));
		    if (!$publisher_isAdmin) {
		        $publisherPermHandler =& xoops_getmodulehandler('permission', 'publisher');

		        $categoriesGranted = $publisherPermHandler->getGrantedItems('category_read');
		        $criteria->add(new Criteria('categoryid', "(".implode(',', $categoriesGranted).")", 'IN'));
		    }
		}
		return $this->getCount($criteria);
	}

	// Get all subats and put them in an array indexed by parent id
	function getSubCats(&$categories) {
	    global $publisher_isAdmin;

		$criteria = new CriteriaCompo('parentid', "(".implode(',', array_keys($categories)).")", 'IN');
	    $ret = array();
	    if (!$publisher_isAdmin) {
	        $publisherPermHandler =& xoops_getmodulehandler('permission', 'publisher');

	        $categoriesGranted = $publisherPermHandler->getGrantedItems('category_read');
	        $criteria->add(new Criteria('categoryid', "(".implode(',', $categoriesGranted).")", 'IN'));
	    }
	    $criteria->setSort('weight');
	    $criteria->setOrder('ASC');
	    $subcats = $this->getObjects($criteria, true);
	    foreach ($subcats as $subcat_id => $subcat) {
	        $ret[$subcat->getVar('parentid')][$subcat->getVar('categoryid')] = $subcat;
	    }
	    return $ret;
	}

	/**
	* delete categories matching a set of conditions
	*
	* @param object $criteria {@link CriteriaElement}
	* @return bool FALSE if deletion failed
	*/
	function deleteAll($criteria = null)
	{
		$categories = $this->getObjects($criteria);
	    foreach ($categories as $category) {
            if (!$this->delete($category)) {
                return false;
            }
        }
		return true;
	}


	function publishedItemsCount($cat_id = 0)
	{
		return $this->itemsCount($cat_id, $status = array(_PUB_STATUS_PUBLISHED));
	}

	function itemsCount($cat_id = 0, $status = '')
	{
		global $publisher_item_handler;
		return $publisher_item_handler->getCountsByCat($cat_id, $status);
	}

}
?>
