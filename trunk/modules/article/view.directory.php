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
 * @version         $Id: view.directory.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
include "header.php";

// Set groups, template, header for cache purposes
if (!empty($xoopsUser)) {
    $xoopsOption["cache_group"] = implode(",", $xoopsUser->groups());
}
$xoopsOption["template_main"] = art_getTemplate("directory", $xoopsModuleConfig["template"]);
$xoops_module_header = art_getModuleHeader($xoopsModuleConfig["template"]) . '
    <link rel="alternate" type="application/rss+xml" title="' . $xoopsModule->getVar('name') . ' rss" href="' . XOOPS_URL.'/modules/' . $GLOBALS["artdirname"] . '/xml.php' . URL_DELIMITER . 'rss" />
    <link rel="alternate" type="application/rss+xml" title="' . $xoopsModule->getVar('name') . ' rdf" href="' . XOOPS_URL.'/modules/' . $GLOBALS["artdirname"] . '/xml.php' . URL_DELIMITER . 'rdf" />
    <link rel="alternate" type="application/atom+xml" title="' . $xoopsModule->getVar('name') . ' atom" href="' . XOOPS_URL.'/modules/' . $GLOBALS["artdirname"] . '/xml.php' . URL_DELIMITER . 'atom" />
    ';

$xoopsOption["xoops_module_header"] = $xoops_module_header;
include_once XOOPS_ROOT_PATH . "/header.php";
include XOOPS_ROOT_PATH . "/modules/" . $xoopsModule->getVar("dirname") . "/include/vars.php";

// Following part will not be executed if cache enabled

if (art_parse_args($args_num, $args, $args_str)) {
    $args["category"] = !empty($args["category"]) ? $args["category"] : @$args_num[0];
}
$category_id = intval( empty($_GET["category"]) ? @$args["category"] : $_GET["category"] );

$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
$category_obj =& $category_handler->get($category_id);

$category_depth = 2;
$data = $category_handler->getArrayTree($category_id, "access", null, $category_depth);
$counts_article = $category_handler->getArticleCounts();

$category_data = array();
$tracks = array();
if (!$category_obj->isNew()) {
    $category_data = array(
        "id"            => $category_obj->getVar("cat_id"),
        "title"         => $category_obj->getVar("cat_title"),
        "description"     => $category_obj->getVar("cat_description"),
        "image"         => $category_obj->getImage(),
        "articles"        => intval($counts_article[$category_id])
    );
    $topic_handler =& xoops_getmodulehandler("topic", $GLOBALS["artdirname"]);
    $category_data["topics"] = $topic_handler->getCount(new Criteria("cat_id", $category_id));
    $category_data["categories"] = count( @$data["child"] );
    $tracks = $category_handler->getTrack($category_obj, true);
}

if (!empty($data["child"])):
foreach (array_keys($data["child"]) as $key) {
    if (empty($data["child"][$key])) continue;
    $data["child"][$key]["count"] = @intval($counts_article[$key]);
    if (empty($data["child"][$key]["child"])) continue;
    foreach (array_keys($data["child"][$key]["child"]) as $skey) {
        $data["child"][$key]["child"][$skey]["count"] = @intval($counts_article[$skey]);
        if ($subcats = art_getSubCategory($skey)):
        foreach (@$subcats as $subcat) {
            $data["child"][$key]["child"][$skey]["count"] += @intval($counts_article[$subcat]);
        }
        endif;
    }
}
endif;
unset($counts_article);

$xoopsTpl -> assign("modulename", $xoopsModule->getVar("name"));
$xoopsTpl -> assign_by_ref("tracks", $tracks);
$xoopsTpl -> assign_by_ref("categories", $data);
$xoopsTpl -> assign_by_ref("category", $category_data);

// Loading module meta data, NOT THE RIGHT WAY DOING IT
$xoopsTpl -> assign("xoops_module_header", $xoopsOption["xoops_module_header"]);

include_once "footer.php";
?>