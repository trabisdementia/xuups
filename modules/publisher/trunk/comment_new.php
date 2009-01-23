<?php 
// $Id: comment_new.php 331 2007-12-23 16:01:11Z malanciault $
// ------------------------------------------------------------------------ //
// XOOPS - PHP Content Management System                      //
// Copyright (c) 2000 XOOPS.org                           //
// <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
// //
// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
// //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
// GNU General Public License for more details.                             //
// //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------ //
include_once '../../mainfile.php';
include_once XOOPS_ROOT_PATH . "/modules/publisher/include/functions.php";

$com_itemid = isset($_GET['com_itemid']) ? intval($_GET['com_itemid']) : 0;
if ($com_itemid > 0) {
	$itemObj = new PublisherItem($com_itemid);
	$com_replytext = _POSTEDBY.'&nbsp;<b>'.publisher_getLinkedUnameFromId($itemObj->uid()) . '</b>&nbsp;'._DATE.'&nbsp;<b>'.$itemObj->dateSub().'</b><br /><br />'.$itemObj->summary();
	$bodytext = $itemObj->body();
	if ($bodytext != '') {
		$com_replytext .= '<br /><br />'.$bodytext.'';
	}
	$com_replytitle = $itemObj->title();
	include_once XOOPS_ROOT_PATH.'/include/comment_new.php';
}

?>