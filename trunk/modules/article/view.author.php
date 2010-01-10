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
 * @version         $Id: view.author.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";

if (art_parse_args($args_num, $args, $args_str)) {
    $args["uid"] = !empty($args["uid"]) ? $args["uid"] : @$args_num[0];
    $args["type"] = @$args_str[0];
}
$uid = intval( empty($_GET["uid"]) ? @$args["uid"] : $_GET["uid"] );
$type = empty($_GET["type"]) ? @$args["type"] : $_GET["type"];

if ( empty($uid) ) {
    $uid = is_object($xoopsUser) ? $xoopsUser->getVar("uid") : 0;
}

header("location: " . XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.list.php" . URL_DELIMITER . "u{$uid}/{$type}");
exit();
?>