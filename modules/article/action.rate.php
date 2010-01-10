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
 * @version         $Id: action.rate.php 2178 2008-09-26 08:34:09Z phppp $
 */ 

include 'header.php';

$rate = intval( @$_POST["rate"] );
$article_id = intval( @$_POST["article"] );
$category_id = intval( @$_POST["category"] );
$page = intval( @$_POST["page"] );

if (empty($article_id)) {
    redirect_header("javascript:history.go(-1);", 1, art_constant("MD_INVALID"));
    exit();
}

$article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
$article_obj =& $article_handler->get($article_id);
if (!$category_handler->getPermission($category_id, "rate")) {
    $message = art_constant("MD_NOACCESS");
} else {
    $uid = (is_object($xoopsUser)) ? $xoopsUser->getVar("uid") : 0;
    $criteria = new CriteriaCompo(new Criteria("art_id", $article_id));
    $ip = art_getIP();
    if ($uid > 0) {
        $criteria->add(new Criteria("uid", $uid));
    } else {
        $criteria->add(new Criteria("rate_ip", $ip));
        $criteria->add(new Criteria("rate_time", time() - 24*3600, ">"));
    }
    $rate_handler =& xoops_getmodulehandler("rate", $GLOBALS["artdirname"]);
    if ($count = $rate_handler->getCount($criteria)) {
        $message = art_constant("MD_ALREADYRATED");
    } else {
        $rate_obj =& $rate_handler->create();
        $rate_obj->setVar("art_id", $article_id);
        $rate_obj->setVar("uid", $uid);
        $rate_obj->setVar("rate_ip", $ip);
        $rate_obj->setVar("rate_rating", $rate);
        $rate_obj->setVar("rate_time", time());
        if (!$rate_id = $rate_handler->insert($rate_obj)) {
            redirect_header("javascript:history.go(-1);", 1, art_constant("MD_NOTSAVED"));
            exit();
        }
        $article_obj =& $article_handler->get($article_id);
        $article_obj->setVar( "art_rating", $article_obj->getVar("art_rating") + $rate, true );
        $article_obj->setVar( "art_rates", $article_obj->getVar("art_rates") + 1, true );
        $article_handler->insert($article_obj, true);
        $message = art_constant("MD_ACTIONDONE");
    }
}
redirect_header(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.article.php" . URL_DELIMITER . $article_id . "/p" . $page . "/c" . $category_id, 2, $message);

include 'footer.php';
?>