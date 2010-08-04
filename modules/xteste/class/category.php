<?php

defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

class XtesteCategory extends Xmf_Object
{
    var $itemName = 'category';
    var $moduleName = 'xteste';
    var $primaryKey = 'id';

    function __construct()
    {
        parent::__construct();
        $this->initVar("id","int",null,false);
        $this->initVar("title","textbox", '');
    }

}

class XtesteCategoryHandler extends Xmf_Object_Handler
{
    function __construct(&$db)
    {
        parent::__construct($db, 'xteste_category', 'XtesteCategory', 'id', 'title');
    }

    function getCategoryArray()
    {
        $array = $this->getList();
        return $array;
    }

}