<?php
// $Id: index.php,v 1.3 2004/10/05 19:06:29 phppp Exp $
//  ------------------------------------------------------------------------ //
//         Xlanguage: eXtensible Language Management For Xoops               //
//             Copyright (c) 2004 Xoops China Community                      //
//                    <http://www.xoops.org.cn/>                             //
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
// Author: D.J.(phppp) php_pp@hotmail.com                                    //
// URL: http://www.xoops.org.cn                                              //
// ------------------------------------------------------------------------- //
include '../../../include/cp_header.php';

include_once(XOOPS_ROOT_PATH.'/modules/xlanguage/include/vars.php');
include_once(XOOPS_ROOT_PATH.'/modules/xlanguage/include/functions.php');

$op = "";
if ( isset( $_POST ) ){
    foreach ( $_POST as $k => $v )  {
        ${$k} = $v;
    }
}
if ( isset( $_GET ) ){
    foreach ( $_GET as $k => $v )  {
        ${$k} = $v;
    }
}

define("XLANG_CONFIG_LINK","<a href='index.php' target='_self'>"._AM_XLANG_CONFIG."</a>");

$xlanguage_handler =& xoops_getmodulehandler('language', 'xlanguage');
$xlanguage_handler->loadConfig();

switch ( $op )
{
    case "del":
        if (!isset($_POST['ok']) || $_POST['ok'] != 1 ){
            xoops_cp_header();
            echo "<h4>" . XLANG_CONFIG_LINK . "</h4>";
            xoops_confirm( array( 'op' => 'del', 'type' => $_GET['type'], 'lang_id' => intval( $_GET['lang_id'] ), 'ok' => 1 ), 'index.php', _AM_XLANG_DELETE_CFM );
        }else{
            if(isset($type)&&$type=='ext') $isBase = false;
            else $isBase = true;
            $lang =& $xlanguage_handler->get($lang_id, $isBase);
            $xlanguage_handler->delete($lang);
            redirect_header("index.php",2,_AM_XLANG_DELETED);
        }
        break;

    case "save":
        if(isset($type)&&$type=='ext') $isBase = false;
        else $isBase = true;
        if(isset($lang_id)&&$lang_id>0){
            $lang =& $xlanguage_handler->get($lang_id, $isBase);
        }else{
            $lang =& $xlanguage_handler->create(true, $isBase);
        }
        $lang_name = preg_replace("/[^a-zA-Z0-9\_\-]/", "", $lang_name);

        $lang->setVar('lang_name',$lang_name);
        $lang->setVar('lang_desc',$lang_desc);
        $lang->setVar('lang_code',$lang_code);
        $lang->setVar('lang_charset',$lang_charset);
        $lang->setVar('lang_image',$lang_image);
        if(!$isBase){
            $lang->setVar('lang_base',$lang_base);
        }
        $lang->setVar('weight',$weight);
        $xlanguage_handler->insert($lang);
        redirect_header("index.php",2,_AM_XLANG_SAVED);
        break;

    case "edit":
        xoops_cp_header();
        echo "<h4>" . XLANG_CONFIG_LINK . "</h4>";
        echo "<br />";
        echo "<h4>" . _AM_XLANG_EDITLANG . "</h4>";
        if(isset($type)&&$type=='ext') $isBase = false;
        else $isBase = true;
        if(isset($lang_id)&&$lang_id>0){
            $lang =& $xlanguage_handler->get($lang_id, $isBase);
        }elseif(isset($lang_name)){
            $lang =& $xlanguage_handler->getByName($lang_name, $isBase);
        }else{
            $lang =& $xlanguage_handler->create(true, $isBase);
        }
        $lang_name = $lang->getVar('lang_name');
        $lang_desc = $lang->getVar('lang_desc');
        $lang_code = $lang->getVar('lang_code');
        $lang_charset = $lang->getVar('lang_charset');
        $lang_image = $lang->getVar('lang_image');
        $weight = $lang->getVar('weight');
        if(!$isBase){
            $lang_base = $lang->getVar('lang_base');
        }
        include "langform.inc.php";
        break;

    case "add":
        xoops_cp_header();
        echo "<h4>" . XLANG_CONFIG_LINK . "</h4>";
        echo "<br />";
        echo "<h4>" . _AM_XLANG_ADDLANG . "</h4>";
        if(isset($type)&&$type=='ext') $isBase = false;
        else $isBase = true;
        $lang_name = '';
        $lang_desc = '';
        $lang_code = '';
        $lang_charset = '';
        $lang_image = '';
        $weight = 1;
        $lang_base = '';
        include "langform.inc.php";
        break;

    case 'createconfig':
        xlanguage_createConfig();
        redirect_header( 'index.php', 1, _AM_XLANG_CREATED );
        exit();
        break;

    case "default":
    default:
        xoops_cp_header();
        echo "<h4>" . XLANG_CONFIG_LINK . "</h4>";
        languageList();
        $configfile_status = (@is_readable(XLANGUAGE_CONFIG_FILE))?_AM_XLANG_CONFIGOK:_AM_XLANG_CONFIGNOTOK;
        echo"<table width='100%' border='0' cellspacing='1' class='outer'><tr><td class=\"odd\">";
        echo " - <b><a href='index.php?op=add&amp;type=base'>" . _AM_XLANG_ADDBASE . "</a></b><br /><br />\n";
        echo " - <b><a href='index.php?op=add&amp;type=ext'>" . _AM_XLANG_ADDEXT . "</a></b><br /><br />\n";
        echo " - <b>".$configfile_status."</b>: ".XLANGUAGE_CONFIG_FILE." (<a href='index.php?op=createconfig' title='"._AM_XLANG_CREATECONFIG."'>" . _AM_XLANG_CREATECONFIG . "</a>)<br /><br />\n";
        echo " - <b><a href='about.php'>" . _AM_XLANG_ABOUT . "</a></b>";
        echo"</td></tr></table>";
        break;
}
xoops_cp_footer();


function languageList()
{
    global $xlanguage_handler;
    $lang_list =& $xlanguage_handler->getAllList();
    if ( is_array($lang_list)&&count( $lang_list ) > 0 ){
        echo"<table width='100%' border='0' cellspacing='1' class='outer'><tr><td class=\"odd\">";
        echo "<div style='text-align: center;'><b>" . _AM_XLANG_LANGLIST . "</b><br />";
        echo "<table width='100%' border='1'><tr class='bg2'><td align='center'>" . _AM_XLANG_DESC . "</td><td align='center'>" . _AM_XLANG_NAME . "</td><td align='center'>" . _AM_XLANG_CHARSET . "</td><td align='center'>" . _AM_XLANG_CODE . "</td><td align='center'>" . _AM_XLANG_IMAGE . "</td><td align='center'>" . _AM_XLANG_WEIGHT . "</td><td align='center'>" . _AM_XLANG_BASE . "</td><td align='center'>" . _EDIT . "</td><td align='center'>" . _DELETE . "</td></tr>\n";
        foreach( array_keys($lang_list) as $lang_name ) {
            $lang =& $lang_list[$lang_name];
            $isOrphan = true;
            if(isset($lang['base'])){
                echo "<tr>\n";
                echo "<td>" . $lang['base'] -> getVar('lang_desc') . "</td>\n";
                echo "<td><b>" . $lang['base'] -> getVar('lang_name') . "</b></td>\n";
                echo "<td><b>" . $lang['base'] -> getVar('lang_charset') . "</b></td>\n";
                echo "<td>" . $lang['base'] -> getVar('lang_code') . "</td>\n";
                if(is_readable(XOOPS_ROOT_PATH.'/modules/xlanguage/images/'.$lang['base'] -> getVar('lang_image'))){
                    $lang_image = $lang['base'] -> getVar('lang_image');
                }else{
                    $lang_image = 'noflag.gif';
                }
                echo "<td><img src='" . XOOPS_URL.'/modules/xlanguage/images/'.$lang_image . "' alt='".$lang['base'] -> getVar('lang_desc')."' /></td>\n";
                echo "<td>" . $lang['base'] -> getVar('weight') . "</td>\n";
                echo "<td>&#216;</td>\n";
                echo "<td><a href='index.php?op=edit&amp;type=base&amp;lang_id=" . $lang['base'] -> getVar('lang_id') . "'>" . _EDIT . "</a></td>\n";
                echo "<td><a href='index.php?op=del&amp;type=base&amp;lang_id=" . $lang['base'] -> getVar('lang_id') . "'>" . _DELETE ."</td>\n";
                echo "</tr>\n";
                $isOrphan = false;
            }
            if(!isset($lang['ext'])||count($lang['ext'])<1) continue;
            foreach($lang['ext'] as $ext){
                echo "<tr>\n";
                echo "<td>" . $ext -> getVar('lang_desc') . "</td>\n";
                echo "<td>" . $ext -> getVar('lang_name') . "</td>\n";
                echo "<td><b>" . $ext -> getVar('lang_charset') . "</b></td>\n";
                echo "<td>" . $ext -> getVar('lang_code') . "</td>\n";
                if(is_readable(XOOPS_ROOT_PATH.'/modules/xlanguage/images/'.$ext -> getVar('lang_image'))){
                    $lang_image = $ext -> getVar('lang_image');
                }else{
                    $lang_image = 'noflag.gif';
                }
                echo "<td><img src='" . XOOPS_URL.'/modules/xlanguage/images/'.$lang_image . "' alt='".$ext -> getVar('lang_desc')."' /></td>\n";
                echo "<td>" . $ext -> getVar('weight') . "</td>\n";
                $lang_base = ($isOrphan)?"<font color='red'>".$ext -> getVar('lang_base')."</font>":$ext -> getVar('lang_base');
                echo "<td><b>" . $lang_base . "</b></td>\n";
                echo "<td><a href='index.php?op=edit&amp;type=ext&amp;lang_id=" . $ext -> getVar('lang_id') . "'>" . _EDIT . "</a></td>\n";
                echo "<td><a href='index.php?op=del&amp;type=ext&amp;lang_id=" . $ext -> getVar('lang_id') . "'>" . _DELETE ."</td>\n";
                echo "</tr>\n";
            }
            echo "<tr><td colspan='9' height='2px'></td></tr>\n";
        }
        echo "</table></div>\n";
        echo"</td></tr></table>";
        echo "<br />";
    }
}
?>
