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
 * @version         $Id: sitemap.plugin.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
// article plugin: D.J., http://xoopsforge.com

if (!defined("XOOPS_ROOT_PATH")) { exit(); }

include dirname(__FILE__) . "/vars.php";
include_once XOOPS_ROOT_PATH . "/modules/" . $GLOBALS["artdirname"] . "/include/functions.php";

mod_loadFunctions("parse", $GLOBALS["artdirname"]);

art_parse_function('

function b_sitemap_[DIRNAME]()
{
    art_define_url_delimiter();
    
    $sitemap = array();
    $category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
    
    if (!empty($GLOBALS["xoopsModuleConfig"]["show_subcategoris"])):
    $category_depth = 3;
    $data = $category_handler->getArrayTree(0, "access", null, $category_depth);
    if (empty($data["child"])) {
        return $sitemap;
    }
    
    $pi = -1;
    foreach (array_keys($data["child"]) as $key) {
        $_cat = array();
        $_cat["id"] = $key;
        $_cat["title"] = $data["child"][$key]["cat_title"];
        $_cat["url"] = "view.category.php" . URL_DELIMITER . $key;
        $sitemap["parent"][++$pi] = $_cat;
        unset($_cat);
        $ci = -1;
        if (empty($data["child"][$key]["child"])) continue;
        foreach (array_keys($data["child"][$key]["child"]) as $skey) {
            $_cat = array();
            $_cat["id"] = $skey;
            $_cat["title"] = $data["child"][$key]["child"][$skey]["cat_title"];
            $_cat["url"] = "view.category.php" . URL_DELIMITER . $skey;
            $_cat["image"] = 2;
            $sitemap["parent"][$pi]["child"][++$ci] = $_cat;
            unset($_cat);
            if (empty($data["child"][$key]["child"][$skey]["child"])) continue;
            foreach (array_keys($data["child"][$key]["child"][$skey]["child"]) as $ckey) {
                $subcats = art_getSubCategory($ckey);
                $_cat = array();
                $_cat["id"] = $ckey;
                $_cat["title"] = $data["child"][$key]["child"][$skey]["child"][$ckey]["cat_title"] . (empty($subcats) ? "" : " (" . count($subcats) . ")");
                $_cat["url"] = "view.category.php" . URL_DELIMITER . $ckey;
                $_cat["image"] = 3;
                $sitemap["parent"][$pi]["child"][++$ci] = $_cat;
                unset($_cat);
            }
        }
    }
    unset($data);
    else:
    $categories =& $category_handler->getTree();
    foreach ($categories as $id => $cat) {
        $sitemap["parent"][] = array("id" => $id, "title" => $cat["cat_title"], "url"=> "view.category.php" . URL_DELIMITER . $id);
    }
    unset($categories);
    endif;
    return $sitemap;
}
'
);
?>