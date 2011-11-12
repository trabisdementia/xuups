<?php
// $Id: search.inc.php,v 1.4 2007/08/26 17:32:19 marcellobrandao Exp $
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

/**
 * Protection against inclusion outside the site
 */
defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

/**
 * Return search results and show images on userinfo page
 *
 * @param array $queryarray the terms to look
 * @param text $andor the conector between the terms to be looked
 * @param int $limit The number of maximum results
 * @param int $offset from wich register start
 * @param int $userid from which user to look
 * @return array $ret with all results
 */
function mypics_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB, $module;
    //getting the url to the uploads directory
    $module_handler =& xoops_gethandler('module');
    $modulo         =& $module_handler->getByDirname('mypics');
    $config_handler =& xoops_gethandler('config');
    $moduleConfig   =& $config_handler->getConfigsByCat(0, $modulo->getVar('mid'));
    $path_uploadimages = $moduleConfig['link_path_upload'];

    $ret = array();
    $sql = "SELECT id, title, created, uid, url FROM ".$xoopsDB->prefix("mypics_image")." WHERE ";
    if ($userid != 0) {
        $sql .= "(uid =" . $userid . ")";

    }

    // because count() returns 1 even if a supplied variable
    // is not an array, we must check if $querryarray is really an array
    $count = count($queryarray);
    if ($count > 0 && is_array($queryarray)) {
        $sql .= " ((title LIKE '%" . $queryarray[0] . "%')";
        for ($i = 1; $i < $count; $i++) {
            $sql .= " $andor ";
            $sql .= "(title LIKE '%" . $queryarray[$i] . "%')";
        }
        $sql .= ") ";
    }
    $sql .= "ORDER BY id DESC";
    //echo $sql;
    //printr($xoopsModules);
    $result = $xoopsDB->query($sql, $limit, $offset);
    $i = 0;
    $stringofimage = 'images/search.png" />';
    while ($myrow = $xoopsDB->fetchArray($result)) {
        if ($userid != 0) {
            if ($limit > 5) {
                $ret[$i]['image'] = "images/search.png' /><a href='".XOOPS_URL."/modules/mypics/index.php?uid=".$myrow['uid']."'><img src='".$path_uploadimages."/thumb_".$myrow['url']."' /></a><br />"."<img src=".XOOPS_URL."/modules/mypics/images/search.png" ;
                $ret[$i]['link'] = "index.php?uid=" . $myrow['uid'];
                $ret[$i]['title'] = $myrow['title'];
                //$ret[$i]['time'] = $myrow['created'];
                $ret[$i]['uid'] = $myrow['uid'];
            } else {
                $stringofimage .= '<a href="'.XOOPS_URL."/modules/mypics/index.php?uid=".$myrow['uid'].'" title="'.$myrow['title'].'"><img src="'.$path_uploadimages.'/thumb_'.$myrow['url'].'" /></a>&nbsp;' ;
            }
        } else {
            $ret[$i]['image'] = "images/search.png' /><a href='".XOOPS_URL."/modules/mypics/index.php?uid=".$myrow['uid']."'><img src='".$path_uploadimages."/thumb_".$myrow['url']."' /></a><br />"."<img src='".XOOPS_URL."/modules/mypics/images/search.png" ;
            $ret[$i]['link'] = "index.php?uid=".$myrow['uid'];
            $ret[$i]['title'] = $myrow['title'];
            //$ret[$i]['time'] = $myrow['created'];
            $ret[$i]['uid'] = $myrow['uid'];
        }
        $i++;
    }
    if ($userid != 0 && $i > 0) {
        if ($limit < 6) {
            $ret = array();
            //$ret[0]['link'] = "modules/mypics/index.php?uid=".$myrow['uid'];
            $ret[0]['title'] = "See its album";
            $ret[0]['time'] = time();
            $ret[0]['uid'] = $userid;
            $ret[0]['link'] = "index.php?uid=" . $userid;
            $stringofimage .= '<img src="' . XOOPS_URL . '/modules/mypics/images/search.png';
            $ret[0]['image'] = $stringofimage;
        }
    }
    return $ret;
}
?>