<?php
// $Id: basedurl.php 159 2007-12-17 16:44:05Z malanciault $
// ------------------------------------------------------------------------ //
// 				 XOOPS - PHP Content Management System                      //
//					 Copyright (c) 2000 XOOPS.org                           //
// 						<http://www.xoops.org/>                             //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //

// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //

// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //
// URL: http://www.xoops.org/												//
// Project: The XOOPS Project                                               //
// -------------------------------------------------------------------------//

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH."/modules/smartobject/class/smartobject.php";

class SmartobjectBasedUrl extends SmartObject {


    function SmartobjectBasedUrl() {
        $this->quickInitVar('caption', XOBJ_DTYPE_TXTBOX, false);
        $this->quickInitVar('description', XOBJ_DTYPE_TXTBOX, false);
        $this->quickInitVar('url', XOBJ_DTYPE_TXTBOX, false);
    }

    function getVar($key, $format = 'e'){
        if(substr($key, 0,4) == 'url_'){
            return parent::getVar('url', $format);
        }elseif(substr($key, 0,8) == 'caption_'){
            return parent::getVar('caption', $format);
        }else{
            return parent::getVar($key, $format);
        }
    }
}

?>
