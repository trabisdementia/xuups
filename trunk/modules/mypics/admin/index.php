<?php
// $Id: index.php,v 1.4 2007/08/26 17:48:40 marcellobrandao Exp $
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
 * index.php, Principal arquivo da administração
 *
 * Este arquivo foi implementado da seguinte forma
 * Primeiro você tem várias funções
 * Depois você tem um case que vai chamar algumas destas funções de acordo com
 * o paramentro $op
 * @author Marcello Brandão <marcello.brandao@gmail.com>
 * @version 1.0
 * @package admin
 */

function mypics_about()
{
    global $xoopsModuleConfig, $xoopsModule;
    include_once dirname(dirname(__FILE__)) . '/class/about.php';
    $aboutObj = new MypicsAbout();
    $aboutObj->render();
}

function mypics_default()
{
    echo "Make sure you have configured everything under preferences tab";
    if (extension_loaded('gd')) {
        echo "<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer' style='margin-top: 15px;'>
        <tr>
        <td class='bg3'><b>All tests must be OK for the module to work:</b></td>
        </tr>
        <tr>
        <td class='even'><img src='../images/green.gif' align='baseline'> GD extension loaded: OK
        More info in: <a href='http://www.libgd.org/Main_Page'> Gd Library</a> </td>
        </tr>
        </table>
        ";
    } else {
        echo "
        <table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer' style='margin-top: 15px;'>
        <tr>
        <td class='bg3'><b>All tests must be OK for the module to work:</b></td>
        </tr>
        <tr>
        <td class='even'><img src='../images/red.gif'> GD extension loaded: FALSE
        Configure your php.ini or ask your server manager to install and enable it for you.
        More info in: <a href='http://www.libgd.org/Main_Page'>Gd Library</a> </td>
        </tr>
        </table>
        ";
    }
}

include '../../../include/cp_header.php';
include_once XOOPS_ROOT_PATH . '/Frameworks/art/functions.admin.php';

xoops_cp_header();

$op = isset($_GET['op']) ? $_GET['op'] : "";
switch ($op) {
    case "about":
        loadModuleAdminMenu(2);
        mypics_about();
        break;
    default:
        loadModuleAdminMenu(1);
        mypics_default();
        break;
}

xoops_cp_footer();
?>