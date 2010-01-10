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
 * @version         $Id: comment_new.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";
$com_itemid = isset($_GET['com_itemid']) ? intval($_GET['com_itemid']) : 0;
if ($com_itemid > 0) {
    $article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
    $article_obj =& $article_handler->get($com_itemid);
    $com_replytitle = $article_obj->getVar("art_title");
    include_once XOOPS_ROOT_PATH . '/include/comment_new.php';
}
?>