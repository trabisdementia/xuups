<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

if (!defined("XOOPS_ROOT_PATH")) {
	die("XOOPS root path not defined");
}

class MymenusMenus extends XoopsObject
{
    /**
     * constructor
     */
    function MymenusMenus()
    {
        $this->__construct();
    }

    function __construct()
    {
        $this->initVar("id", XOBJ_DTYPE_INT);
        $this->initVar('title', XOBJ_DTYPE_TXTBOX);
    }
}

class MymenusMenusHandler extends XoopsPersistableObjectHandler
{
    function MymenusMenusHandler(&$db)
    {
        $this->__construct($db);
    }

    function __construct(&$db)
    {
        parent::__construct($db, 'mymenus_menus', 'MymenusMenus', 'id', 'title');
    }
}
