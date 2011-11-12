<?php
// $Id$
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author: Raul Recio (AKA UNFOR)                                            //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //

defined('XOOPS_ROOT_PATH') or die("Direct file access prohibited.");

$xpartnerDir = basename(dirname(dirname(__FILE__)));

class xoopspartnerPartners_base extends XoopsObject
{
    var $db;

    /**
     * constructor
     */
    function __construct($id = null)
    {
        $this->db =& Database::getInstance();
        $this->initVar('id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('weight', XOBJ_DTYPE_INT, null, false, 10);
        $this->initVar('hits', XOBJ_DTYPE_INT, null, true, 10);
        $this->initVar('url', XOBJ_DTYPE_TXTBOX, null, true);
        $this->initVar('image', XOBJ_DTYPE_TXTBOX, null, true);
        $this->initVar('title', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('description', XOBJ_DTYPE_TXTBOX, null, true);
        $this->initVar('status', XOBJ_DTYPE_INT, null, false, 0);
        if (!empty($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            } else {
                $this->load(intval($id));
            }
        }
    }

    /**
     * Returns category title using PHP5
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }
}

/**
 * @package kernel
 * @copyright copyright &copy; 2000 XOOPS.org
 */
class xoopspartnerPartnersHandler_base extends XoopsPersistableObjectHandler
{
    public function PartnersHandler(&$db)
    {
        $this->__construct($db);
    }

    function __construct(&$db)
    {
        $xpDir = basename(dirname(dirname(__FILE__)));
        parent::__construct($db, 'partners', strtolower($xpDir) . 'Partners', 'id');
    }
}

eval('class ' . $xpartnerDir . 'Partners extends xoopspartnerPartners_base
        {
        }

        class ' . $xpartnerDir . 'PartnersHandler extends xoopspartnerPartnersHandler_base
        {
        }
    ');