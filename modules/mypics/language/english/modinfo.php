<?php
// $Id: modinfo.php,v 1.3 2007/08/26 15:53:46 marcellobrandao Exp $
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
define("_MI_MYPICS_NUMBPICT_TITLE","Number of Pictures");
define("_MI_MYPICS_NUMBPICT_DESC" ,"Number of pictures a user can have in his page");
define("_MI_MYPICS_ADMENU1","Home");
define("_MI_MYPICS_ADMENU2" ,"About");
define("_MI_MYPICS_SMNAME1" ,"Submit");
define("_MI_MYPICS_THUMBW_TITLE" , "Thumb Width");
define("_MI_MYPICS_THUMBW_DESC" , "Thumbnails width in pixels<br />This means your picture thumbnail will have<br />at most this size in width<br />All proportions are maintained");
define("_MI_MYPICS_THUMBH_TITLE" , "Thumb Height");
define("_MI_MYPICS_THUMBH_DESC" , "Thumbnails Height in pixels<br />This means your picture thumbnail will have<br />at most this size in height<br />All proportions are maintained");
define("_MI_MYPICS_RESIZEDW_TITLE" , "Resized picture width");
define("_MI_MYPICS_RESIZEDW_DESC" , "Resized picture width in pixels<br />This means your picture will have<br />at most this size in width<br />All proportions are maintained<br /> The original picture if bigger than this size will <br />be resized so it wont break your template");
define("_MI_MYPICS_RESIZEDH_TITLE" , "Resized picture height");
define("_MI_MYPICS_RESIZEDH_DESC" , "Resized picture height in pixels<br />This means your picture will have<br />at most this size in height<br />All proportions are maintained<br /> The original picture if bigger than this size will <br />be resized so it wont break your template design");
define("_MI_MYPICS_ORIGINALW_TITLE" , "Max original picture width");
define("_MI_MYPICS_ORIGINALW_DESC" , "Maximum original picture width in pixels<br />This means user's original picture can't exceed <br />this size in height<br />or else it won't be uploaded");
define("_MI_MYPICS_ORIGINALH_TITLE" , "Max original picture height");
define("_MI_MYPICS_ORIGINALH_DESC" , "Maximum original picture height in pixels<br />This means user's original picture can't exceed <br />this size in height<br />or else it won't be uploaded");
define("_MI_MYPICS_PATHUPLOAD_TITLE" , "Path Uploads");
define("_MI_MYPICS_PATHUPLOAD_DESC" , "Path to your uploads directory<br />in linux should look like /var/www/uploads<br />in windows like C:/Program Files/www");
define("_MI_MYPICS_LINKPATHUPLOAD_TITLE","Link to your uploads directory");
define("_MI_MYPICS_LINKPATHUPLOAD_DESC","This is the address of the root of your uploads <br />like http://www.yoursite.com/uploads");
define("_MI_MYPICS_MAXFILEBYTES_TITLE","Max size in bytes");
define("_MI_MYPICS_MAXFILEBYTES_DESC","This the maximum size a file of your pictue can have in bytes <br />like 512000 for 500 KB");

define("_MI_MYPICS_PICPAGE_TITLE", "Pictures per page");
define("_MI_MYPICS_PICPAGE_DESC", "Number of pictures to show before using pagination");

define("_MI_MYPICS_NEWCAT_NOTIFY", "New category");
define("_MI_MYPICS_NEWCAT_NOTIFY_DSC", "New category desc");

define("_MI_MYPICS_NEWPIC_NOTIFY", "New pic Notify");
define("_MI_MYPICS_NEWPIC_NOTIFY_CAP", "New pic caption");
define("_MI_MYPICS_NEWPIC_NOTIFY_DSC", "New pic description");
define("_MI_MYPICS_NEWPIC_NOTIFY_SBJ", "New pic subject");

define("_MI_MYPICS_LAST", "Last pictures");
define("_MI_MYPICS_LAST_DSC", "Last pictures desc");

define("_MI_MYPICS_TPL_INDEX", "Index template");

?>