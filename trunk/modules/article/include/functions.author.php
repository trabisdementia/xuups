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
 * @version         $Id: functions.author.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

include dirname(__FILE__) . "/vars.php";
define($GLOBALS["artdirname"] . "_FUNCTIONS_AUTHOR_LOADED", TRUE);

if (!defined("ART_FUNCTIONS_AUTHOR")):
define("ART_FUNCTIONS_AUTHOR", 1);

/**
 * Function to a list of user names associated with their user IDs
 * 
 */
function &art_getAuthorNameFromId( $userid, $usereal = 0, $linked = false )
{
    if (!is_array($userid))  {
        $userid = array($userid);
    }
    xoops_load("userUtility");
    $users = XoopsUserUtility::getUnameFromIds($userid, $usereal);
    
    if (!empty($linked)) {
        mod_loadFunctions("url", $GLOBALS["artdirname"]);
        foreach (array_keys($users) as $uid) {
            $users[$uid] = "<a href=\"" . art_buildUrl(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.author.php", array("uid" => $uid)) . "\">" . $users[$uid] . "</a>";
        }
    }
    return $users;
}

function &art_getWriterNameFromIds( $writer_ids, $linked = false )
{
    if (!is_array($writer_ids))  {
        $writer_ids = array($writer_ids);
    }
    $userid = array_map("intval", array_filter($writer_ids));
    
    $myts =& MyTextSanitizer::getInstance();
    $users = array();
    if (count($userid) > 0) {
        $sql = 'SELECT writer_id, writer_name FROM ' . art_DB_prefix("writer"). ' WHERE writer_id IN(' . implode(",", array_unique($userid)) . ')';
        if (!$result = $GLOBALS['xoopsDB']->query($sql)) {
            //xoops_error("writer query error: " . $sql);
            return $users;
        }
        mod_loadFunctions("url", $GLOBALS["artdirname"]);
        while ($row = $GLOBALS['xoopsDB']->fetchArray($result)) {
            $uid = $row["writer_id"];
            $users[$uid] = $myts->htmlSpecialChars($row["writer_name"]);
            if ($linked) {
                $users[$uid] = '<a href="' . art_buildUrl(XOOPS_URL."/modules/" . $GLOBALS["artdirname"] . "/view.writer.php", array("writer" => $uid)) . '">' . $users[$uid] . '</a>';
            }
        }
    }
    return $users;
}

ENDIF;
?>