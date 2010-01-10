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
 * @version         $Id: print.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
error_reporting(0);
include 'header.php';
error_reporting(0);

if (!empty($_POST["print_data"])) {
    $print_data = unserialize(base64_decode($_POST["print_data"]));
} elseif (!empty($print_data)) {
    
} else {
    
    if (art_parse_args($args_num, $args, $args_str)) {
        $args["article"] = @$args_num[0];
    }
    
    $article_id = intval( empty($_GET["article"]) ? @$args["article"] : $_GET["article"] );
    $category_id = intval( empty($_GET["category"]) ? @$args["category"] : $_GET["category"] );
    $page = intval( empty($_GET["page"]) ? @$args["page"] : $_GET["page"] );
    
    $article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);
    $article_obj =& $article_handler->get($article_id);
    
    $category_id = empty($category_id) ? $article_obj->getVar("cat_id") : intval($category_id);
    
    $category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
    $category_obj =& $category_handler->get($category_id);
    
    if (empty($category_obj) || !$category_handler->getPermission($category_obj, "view")) {
        DIE(art_constant("MD_NOACCESS"));
    }
    
    $article_data = array();
    
    // title
    $article_data["title"] = $article_obj->getVar("art_title");
    
    $article_data["author"] =& $article_obj->getAuthor(true);
    
    // source
    $article_data["source"] = $article_obj->getVar("art_source");
    
    // publish time
    $article_data["time"] = $article_obj->getTime("l");
    
    // summary
    $article_data["summary"] = $article_obj->getSummary();
    
    // Keywords
    $article_data["keywords"] = $article_obj->getVar("art_keywords");
    
    // text of page
    $article_data["text"] =& $article_obj->getText($page, "raw");
    
    $print_data["title"] = $article_data["title"];
    $print_data["subtitle"] = $category_obj->getVar("cat_title");
    if (!empty($article_data["text"]["title"])) {
        $print_data["subsubtitle"] = "#".$page." ".$article_data["text"]["title"];
    }
    $print_data["author"] = $article_data["author"]["name"];
    $tmp = array();
    if ($article_data["source"]) $tmp[]=$article_data["source"];
    if ($article_data["author"]["author"]) $tmp[] = $article_data["author"]["author"];
    if (count($tmp)) {
        $print_data["author"] .= "(" . implode(" ", $tmp) . ")";
    }
    $print_data["date"] = $article_data["time"];
    $print_data["summary"] = "";
    if ($article_data["keywords"]) {
        $print_data["summary"] .= art_constant("MD_KEYWORDS").": ".$article_data["keywords"]."<br /><br />";
    }
    if($article_data["summary"]){
        $print_data["summary"] .= art_constant("MD_SUMMARY") . ": " . $article_data["summary"] . "<br /><br />";
    }
    $print_data["content"] = "";
    $print_data["content"] .= $article_data["text"]["body"];
    $print_data["url"] = XOOPS_URL . "/modules/" . $xoopsModule->getVar("dirname") . "/view.article.php".  URL_DELIMITER . "c" . $category_id . "/" . $article_id . "/p" . $page;
}

$print_data["image"] = XOOPS_URL . "/modules/" . $xoopsModule->getVar("dirname") . "/" . $xoopsModule->getInfo( 'image' );
$print_data["module"] = $xoopsModule->getVar("name") . " V" . $xoopsModule->getInfo( 'version' );

    header('Content-Type: text/html; charset=' . _CHARSET); 
    echo "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>\n";
    echo "<html>\n<head>\n";
    echo "<title>" . $xoopsConfig['sitename'] . "</title>\n";
    echo "<meta http-equiv='Content-Type' content='text/html; charset=" . _CHARSET . "' />\n";
    echo "<meta name='AUTHOR' content='" . $myts->htmlspecialchars($xoopsConfig['sitename']) . "' />\n";
    echo "<meta name='COPYRIGHT' content='Copyright (c) " . date('Y') . " by " . $xoopsConfig['sitename'] . "' />\n";
    echo "<meta name='DESCRIPTION' content='" . $myts->htmlspecialchars($xoopsConfig['slogan']) . "' />\n";
    echo "<meta name='GENERATOR' content='" . XOOPS_VERSION . "' />\n";
    echo "<style type='text/css'>
            body {
                color:#000000;
                background-color:#EFEFEF;
                font-family: Arial, Helvetica, sans-serif;
                font-size: 12pt;
                margin:10px;
                line-height: 120%;
            }
            a, a:visited, a:active {
                color:#000000;
                text-decoration: none;
            }
            </style>\n";
       echo "</head>\n";
    echo "<body style='background-color:#ffffff; color:#000000; font-family: Arial' onload='window.print()'>\n".
          "<div style='float:center; width: 750px; border: 1px solid #000; padding: 20px;'>\n".
            "<div style='text-align: center; display: block; margin: 0 0 6px 0; padding: 5px;'>\n".
            "<img src='" . $print_data["image"] . "' border='0' alt='" . $print_data["module"] . "' />\n".
            "<h2>" . $print_data["title"] . "</h2>\n".
            "</div>\n".
            "<div style='margin-top: 12px; margin-bottom: 12px; border-top: 2px solid #ccc;'></div>\n";
    if (!empty($print_data["subtitle"])) {
        echo "<div>" . art_constant("MD_CATEGORY") . ": " . $print_data["subtitle"] . "</div>\n";
    }
    if (!empty($print_data["subsubtitle"])) {
        echo "<div>" . art_constant("MD_SUBTITLE") . ": " . $print_data["subsubtitle"] . "</div>\n";
    }
    echo    "<div>" . art_constant("MD_AUTHOR") . ": " . $print_data["author"] . "</div>\n" .
            "<div>" . art_constant("MD_DATE") . ": " . $print_data["date"] . "</div>\n" .
            "<div style='margin-top: 12px; margin-bottom: 12px; border-top: 1px solid #ccc;'></div>\n" .
            "<div>" . $print_data["summary"] . "</div>\n" .
            "<div style='margin-top: 12px; margin-bottom: 12px; border-top: 1px solid #ccc;'></div>\n" .
            "<div>" . $print_data["content"] . "</div>\n" .
            "<div style='margin-top: 12px; margin-bottom: 12px; border-top: 2px solid #ccc;'></div>\n" .
            "<div>" . $print_data["module"] . "</div>\n" .
            "<div>URL: ".$print_data["url"] . "</div>\n" .
        "</div>\n" .
        "</body>\n</html>\n";
exit();        
?>