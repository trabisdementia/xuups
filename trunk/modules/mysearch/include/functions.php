<?php
//  ------------------------------------------------------------------------ //
//                       mysearch - MODULE FOR XOOPS 2                        //
//                  Copyright (c) 2005-2006 Instant Zero                     //
//                     <http://xoops.instant-zero.com/>                      //
// ------------------------------------------------------------------------- //
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
if (!defined('XOOPS_ROOT_PATH')) {
    die("XOOPS root path not defined");
}

/**
 * Returns a module's option
 */
function mysearch_getmoduleoption($option, $repmodule='mysearch')
{
    global $xoopsModuleConfig, $xoopsModule;
    static $tbloptions= Array();
    if(is_array($tbloptions) && array_key_exists($option,$tbloptions)) {
        return $tbloptions[$option];
    }

    $retval=false;
    if (isset($xoopsModuleConfig) && (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $repmodule && $xoopsModule->getVar('isactive'))) {
        if(isset($xoopsModuleConfig[$option])) {
            $retval= $xoopsModuleConfig[$option];
        }

    } else {
        $module_handler =& xoops_gethandler('module');
        $module =& $module_handler->getByDirname($repmodule);
        $config_handler =& xoops_gethandler('config');
        if ($module) {
            $moduleConfig =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
            if(isset($moduleConfig[$option])) {
                $retval= $moduleConfig[$option];
            }
        }
    }
    $tbloptions[$option]=$retval;
    return $retval;
}

/**
 * Create (in a link) a javascript confirmation box
 */
function mysearch_JavascriptLinkConfirm($msg)
{
    return "onclick=\"javascript:return confirm('".str_replace("'"," ",$msg)."')\"";
}

/**
 * Verify that a field exists inside a mysql table
 *
 * @package mysearch
 * @author Instant Zero (http://xoops.instant-zero.com)
 * @copyright (c) Instant Zero
 */
function mysearch_FieldExists($fieldname,$table)
{
    global $xoopsDB;
    $result=$xoopsDB->queryF("SHOW COLUMNS FROM	$table LIKE '$fieldname'");
    return($xoopsDB->getRowsNum($result) > 0);
}

/**
 * Add a field to a mysql table
 *
 * @package mysearch
 * @author Instant Zero (http://xoops.instant-zero.com)
 * @copyright (c) Instant Zero
 */
function mysearch_AddField($field, $table)
{
    global $xoopsDB;
    $result=$xoopsDB->queryF("ALTER TABLE " . $table . " ADD $field;");
    return $result;
}

function mysearch_search($queryarray, $andor, $limit, $offset, $userid){
    global $xoopsUser;
    include_once XOOPS_ROOT_PATH.'/modules/mysearch/include/functions.php';
    include_once XOOPS_ROOT_PATH.'/modules/mysearch/class/blacklist.php';
    $mysearch_handler =& xoops_getmodulehandler('searches', 'mysearch');
    $banned=array();
    $banned=mysearch_getmoduleoption('bannedgroups');
    $uid=0;
    $datesearch=date('Y-m-d H:i:s');

    if (is_object($xoopsUser)) {
        $groups = $xoopsUser->getGroups();
        $uid=$xoopsUser->getVar('uid');
    } else {
        $groups = array(XOOPS_GROUP_ANONYMOUS);
    }

    $blacklist = new mysearch_blacklist();
    $blacklist->getAllKeywords();	// Load keywords from blacklist
    $queryarray = $blacklist->remove_blacklisted($queryarray);
    $count= count($queryarray);
    if (count(array_intersect($groups,$banned)) == 0 && $userid==0) {	// If it's not a banned user and if we are not viewing someone's profile
        if (is_array($queryarray) && $count >0) {
            for($i=0;$i<$count;$i++) {
                $mysearch = $mysearch_handler->create(true);
                $mysearch->setVar('uid',$uid);
                $mysearch->setVar('datesearch',$datesearch);
                $mysearch->setVar('keyword',$queryarray[$i]);
                $res=$mysearch_handler->insert($mysearch);
            }
        }
    }
    return '';
}

?>
