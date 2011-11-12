<?php
/**
 * CBB 4.0, or newbb, the forum module for XOOPS project
 *
 * @copyright	The XOOPS Project http://xoops.sf.net
 * @license		http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author		Taiwen Jiang (phppp or D.J.) <phppp@users.sourceforge.net>
 * @since		4.00
 * @version		$Id $
 * @package		module::newbb
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
	exit();
}

class Category extends XoopsObject
{
    function Category()
    {
        $this->__construct();
    }
    
    function __construct()
    {
	    $this->XoopsObject();
        $this->initVar('cat_id',			XOBJ_DTYPE_INT);
        $this->initVar('cat_title',			XOBJ_DTYPE_TXTBOX);
        $this->initVar('cat_image',			XOBJ_DTYPE_SOURCE, "blank.gif");
        $this->initVar('cat_description',	XOBJ_DTYPE_TXTAREA);
        $this->initVar('cat_order', 		XOBJ_DTYPE_INT, 99);
        $this->initVar('cat_url', 			XOBJ_DTYPE_URL);
    }
}

class NewbbCategoryHandler extends XoopsPersistableObjectHandler
{
    function __construct(&$db) 
    {
        parent::__construct($db, "bb_categories", 'Category', 'cat_id', 'cat_title');
    }
    
    function NewbbCategoryHandler(&$db)
    {
        $this->__construct($db);
    }
        

    function getIdsByPermission($perm = "access")
    {
        $perm_handler = xoops_getmodulehandler('permission', 'newbb');
        return $perm_handler->getCategories($perm);
    }
    
    function &getByPermission($permission = "access", $tags = null, $asObject = true)
    {
        $categories = array();
	    if ( !$valid_ids = $this->getIdsByPermission($permission) ) {
		    return $categories;
	    }
        $criteria = new Criteria("cat_id", "(".implode(", ", $valid_ids).")", "IN");
        $criteria->setSort("cat_order");
        $categories = $this->getAll($criteria, $tags, $asObject);
        return $categories;
    }

    function insert(&$category)
    {
        parent::insert($category, true);
        if ($category->isNew()) {
	        $this->applyPermissionTemplate($category);
        }

        return $category->getVar('cat_id');
    }

    function delete(&$category)
    {
        global $xoopsModule;
		$forum_handler =& xoops_getmodulehandler('forum', 'newbb');
		$forum_handler->deleteAll(new Criteria("cat_id", $category->getVar('cat_id')), true, true);
        if ($result = parent::delete($category)) {
            // Delete group permissions
            return $this->deletePermission($category);
        } else {
	        $category->setErrors("delete category error: ".$sql);
            return false;
        }
    }

    /*
     * Check permission for a category
     *
     * TODO: get a list of categories per permission type
     *
     * @param	mixed (object or integer)	category object or ID
     * return	bool
     */
    function getPermission($category, $perm = "access")
    {
        if ($GLOBALS["xoopsUserIsAdmin"] && $GLOBALS["xoopsModule"]->getVar("dirname") == "newbb") {
	        return true;
        }

        $cat_id = is_object($category) ? $category->getVar('cat_id') : intval($category);
        $perm_handler =& xoops_getmodulehandler('permission', 'newbb');
        return $perm_handler->getPermission("category", $perm, $cat_id);
    }
        
    function deletePermission(&$category)
    {
		$perm_handler =& xoops_getmodulehandler('permission', 'newbb');
		return $perm_handler->deleteByCategory($category->getVar("cat_id"));
	}
    
    function applyPermissionTemplate(&$category)
    {
		$perm_handler =& xoops_getmodulehandler('permission', 'newbb');
		return $perm_handler->setCategoryPermission($category->getVar("cat_id"));
	}
}

?>