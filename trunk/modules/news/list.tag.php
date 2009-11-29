<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                  Copyright (c) 2005-2006 Instant Zero                     //
//                     <http://xoops.instant-zero.com/>                      //
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

/*
 * Created on 03/12/2008
 *
 * This page will display a list of articles which belong to a tag
 *
 * @package News
 * @author Herv� Thouzard of Instant Zero
 * @copyright (c) Instant Zero - http://www.instant-zero.com
 */
require_once 'header.php';
require_once XOOPS_ROOT_PATH.'/modules/news/include/functions.php';
if(!news_getmoduleoption('tags')) {
    redirect_header('index.php', 2, _ERRORS);
    exit();
}
require_once XOOPS_ROOT_PATH.'/modules/tag/list.tag.php';
?>