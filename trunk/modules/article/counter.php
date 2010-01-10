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
 * @version         $Id: counter.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";

if (empty($xoopsModuleConfig['do_counter'])) return;
$article_id = empty($_GET['article']) ? 0 : intval($_GET['article']);
if (empty($article_id)) return;
if (art_getcookie("art_" . $article_id) > 0) return;

$article_handler =& xoops_getmodulehandler('article', $xoopsModule->getVar("dirname"));
$article_obj =& $article_handler->get($article_id);
$article_obj->setVar( "art_counter", $article_obj->getVar("art_counter") + 1, true );
$article_handler->insert($article_obj, true);
art_setcookie("art_" . $article_id, time());

return;
?>