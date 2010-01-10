<?php
/**
 * Article module for XOOPS
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code 
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         article
 * @since           1.0
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: functions.user.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

include dirname(__FILE__) . "/vars.php";
define($GLOBALS["artdirname"] . "_FUNCTIONS_USER_LOADED", TRUE);


IF (!defined("ART_FUNCTIONS_USER")):
define("ART_FUNCTIONS_USER", 1);

load_functions("user");

/**
 * Function to a list of user names associated with their user IDs
 * 
 */
function &art_getUnameFromId( $uid, $usereal = 0, $linked = false )
{
    if (!is_array($uid)) {
        $uid = array($uid);
    }
    xoops_load("userUtility");
    $ids = XoopsUserUtility::getUnameFromIds($uid, $usereal, $linked);
    return $ids;
}

/**
 * Function to check if a user is an administrator of the module
 *
 * @return bool
 */
function art_isAdministrator( $user = -1, $mid = 0 )
{
    global $xoopsUser, $xoopsModule;

    if ( is_numeric($user) && $user == -1 ) $user =& $xoopsUser;
    if ( !is_object($user) && intval($user) < 1 ) return false;
    $uid = (is_object($user)) ? $user->getVar("uid") : intval($user);

    if (!$mid) {
        if (is_object($xoopsModule) && $GLOBALS["artdirname"] == $xoopsModule->getVar("dirname")) {
            $mid = $xoopsModule->getVar("mid");
        } else {
            $modhandler =& xoops_gethandler("module");
            $art_module =& $modhandler->getByDirname($GLOBALS["artdirname"]);
            $mid = $art_module->getVar("mid");
            unset($art_module);
        }
    }
    
    if ( is_object($xoopsModule) && $mid == $xoopsModule->getVar("mid") && is_object($xoopsUser) && $uid == $xoopsUser->getVar("uid") ) {
        return $GLOBALS["xoopsUserIsAdmin"];
    }

    $member_handler =& xoops_gethandler('member');
    $groups = $member_handler->getGroupsByUser($uid);
    
    $moduleperm_handler =& xoops_gethandler('groupperm');
    return $moduleperm_handler->checkRight('module_admin', $mid, $groups);
}

/**
 * Function to check if a user is a moderator of a category
 *
 * @return bool
 */
function art_isModerator( &$category, $user = -1 )
{
    global $xoopsUser;

    if (!is_object($category)) {
        $cat_id = intval($category);
        if ( $cat_id == 0 ) return false;
        $category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
        $category =& $category_handler->get($cat_id);
    }

    if (is_numeric($user) && $user == -1) $user =& $xoopsUser;
    if (!is_object($user) && intval($user) < 1) return false;
    $uid = (is_object($user)) ? $user->getVar("uid") : intval($user);

    return in_array($uid, $category->getVar("cat_moderator"));
}

// Adapted from PMA_getIp() [phpmyadmin project]
function art_getIP($asString = false)
{
    return mod_getIP($asString);
}
ENDIF;
?>