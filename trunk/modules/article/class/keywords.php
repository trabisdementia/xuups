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
 * @version         $Id: keywords.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
// The solution is not ready for HTML yet.
// Another trial: http://aidan.dotgeek.org/lib/?file=function.str_highlight.php
// -- D.J.

/*
 * Adapted from
 * ------------
 * @description     Advanced keyword highlighter, keep HTML tags safe.
 * @author(s)    Bojidar Naydenov a.k.a Bojo (bojo2000@mail.bg) & Antony Raijekov a.k.a Zeos (dev@strategma.bg)
 * @country         Bulgaria
 * @version      2.1
 * @copyright    GPL
 * @access       public
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
    exit();
}
include_once dirname(dirname(__FILE__)) . "/include/vars.php";
mod_loadFunctions("parse", $GLOBALS["artdirname"]);

art_parse_class('
class [CLASS_PREFIX]KeywordsHandler /*extends XoopsObjectHandler*/
{
    var $keywords;
    var $skip_tags = array("A", "IMG", "PRE", "QUOTE", "CODE",
                            "H1", "H2", "H3", "H4", "H5", "H6" 
                            );    //add here more, if you want to filter them

    function init()
    {
        $this->getKeywords();
        if (count($this->keywords) == 0) return false;
        else return true;
    }

    function getKeywords()
    {
        global $xoopsModuleConfig;
        static $keywords = array();
        if (count($keywords) > 0) return $keywords;
        $_keywords = art_parseLinks($xoopsModuleConfig["keywords"]);

        foreach ($_keywords as $_keyword) {
            $this->keywords[strtolower($_keyword["title"])] = $_keyword["url"];
        }
    }

    function highlighter($matches)
    {
        if (!in_array(strtoupper($matches[2]), $this->skip_tags)) {
            $replace = "<a href=\"" . $this->keywords[strtolower($matches[3])] . "\">" . $matches[3] . "</a>";
            $proceed =  preg_replace("#\b(" . $matches[3] . ")\b#si", $replace, $matches[0]);
        } else {
            $proceed = $matches[0];
        }
        return stripslashes($proceed);
    }

    function &process(&$text)
    {
        foreach ($this->keywords as $keyword => $rep) {
            $text = preg_replace_callback("#(<([A-Za-z]+)[^>]*[\>]*)*\s(" . $keyword . ")\s(.*?)(<\/\\2>)*#si", array(&$this, "highlighter"), $text);
        }
        return $text;
    }
}
');
?>