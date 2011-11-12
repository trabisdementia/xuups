<?php
/**
 * MyLinks category.php
 *
 * Xoops mylinks - a multicategory links module
 *
 * @copyright::  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license::    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package::    mylinks
 * @subpackage:: class
 * @since::		 unknown
 * @author::     Thatware - http://thatware.org/
 * @version::    $Id$
 */
// ------------------------------------------------------------------------- //
//                XOOPS - PHP Content Management System                      //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
// Based on:                                                                 //
// myPHPNUKE Web Portal System - http://myphpnuke.com/                       //
// PHP-NUKE Web Portal System - http://phpnuke.org/                          //
// Thatware - http://thatware.org/                                           //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------- //
require_once '../../../include/cp_header.php';
include 'header.php';
$index_admin = new ModuleAdmin();

// Temporarily 'homeless' links (to be revised in admin.php breakup)
$result = $xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix("mylinks_broken") . "");
list($totalBrokenLinks) = $xoopsDB->fetchRow($result);
if ( $totalBrokenLinks > 0 ) {
    $totalBrokenLinks = "<span style='color: #ff0000; font-weight: bold'>{$totalBrokenLinks}</span>";
}
$result = $xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix("mylinks_mod") . "");
list($totalModRequests) = $xoopsDB->fetchRow($result);
if ( $totalModRequests > 0 ) {
    $totalModRequests = "<span style='color: #ff0000; font-weight: bold'>{$totalModRequests}</span>";
}
$result = $xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix("mylinks_links") . " WHERE status='0'");
list($totalNewLinks) = $xoopsDB->fetchRow($result);
if ( $totalNewLinks > 0 ) {
    $totalNewLinks = "<span style='color: #ff0000; font-weight: bold'>{$totalNewLinks}</span>";
}
$result=$xoopsDB->query("SELECT COUNT(*) FROM " . $xoopsDB->prefix("mylinks_links") . " WHERE status>0");
list($activeLinks) = $xoopsDB->fetchRow($result);

$index_admin->addLabel(_MD_MYLINKS_WEBLINKSCONF);

if ( 0 == $totalNewLinks ) {
    $index_admin->addLineLabel(_MD_MYLINKS_WEBLINKSCONF, _MD_MYLINKS_LINKSWAITING, $totalNewLinks, 'Green');
} else {
    $index_admin->addLineLabel(_MD_MYLINKS_WEBLINKSCONF, _MD_MYLINKS_LINKSWAITING, $totalNewLinks, 'Red');
}

if ( 0 == $totalBrokenLinks ) {
    $index_admin->addLineLabel(_MD_MYLINKS_WEBLINKSCONF, _MD_MYLINKS_BROKENREPORTS, $totalBrokenLinks, 'Green');
} else {
    $index_admin->addLineLabel(_MD_MYLINKS_WEBLINKSCONF, _MD_MYLINKS_BROKENREPORTS, $totalBrokenLinks, 'Red');
}

if ( 0 == $totalModRequests ) {
    $index_admin->addLineLabel(_MD_MYLINKS_WEBLINKSCONF, _MD_MYLINKS_MODREQUESTS, $totalModRequests, 'Green');
} else {
    $index_admin->addLineLabel(_MD_MYLINKS_WEBLINKSCONF, _MD_MYLINKS_MODREQUESTS, $totalModRequests, 'Red');
}

$index_admin->addLineLabel(_MD_MYLINKS_WEBLINKSCONF, _MD_MYLINKS_THEREARE, $activeLinks);


$index_admin->addConfigLabel(_AM_MYLINKS_CONFIG_CHECK);
$index_admin->addLineConfigLabel(_AM_MYLINKS_CONFIG_PHP, $xoopsModule->getInfo("min_php"), 'php');
$index_admin->addLineConfigLabel(_AM_MYLINKS_CONFIG_XOOPS, $xoopsModule->getInfo("min_xoops"), 'xoops');

echo $index_admin->addNavigation('index.php');
echo $index_admin->renderIndex();

include 'footer.php';
xoops_cp_footer();
