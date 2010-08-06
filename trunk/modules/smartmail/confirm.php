<?php
// $Id: confirm.php,v 1.1 2006/06/17 12:25:45 marcan Exp $
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

include "../../mainfile.php";

$myts = MyTextSanitizer::getInstance();

$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : redirect_header(XOOPS_URL,5,_NL_MA_NOACTION);
$email = isset($_REQUEST['email']) ? $myts->addSlashes($_REQUEST["email"]) : redirect_header(XOOPS_URL,5,_NL_MA_NOEMAIL);
$code = isset($_REQUEST['code']) ? $_REQUEST['code'] : redirect_header(XOOPS_URL,5,_NL_MA_NOCODE);
$id = isset($_REQUEST['newsletterid']) ? intval($_REQUEST['newsletterid']) : redirect_header(XOOPS_URL,5,_NL_MA_NOLIST);


?>