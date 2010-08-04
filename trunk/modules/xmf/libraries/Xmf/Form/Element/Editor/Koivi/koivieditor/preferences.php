<?php
/**
 * XOOPS editor
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         class
 * @subpackage      editor
 * @since           2.3.0
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: preferences.php 2264 2008-10-10 03:41:27Z phppp $
 */
//FULL TOOLBAR OPTIONS
define("_XK_P_FULLTOOLBAR", "floating,fontname,fontsize,formatblock,insertsymbols,newline,undo,redo,cut,copy,paste,pastespecial,separator,spellcheck,print, separator,bold,italic,underline,strikethrough,removeformat,separator,justifyleft,justifycenter,justifyright,justifyfull,newparagraph,separator,ltr,rtl,separator,insertorderedlist,insertunorderedlist,indent,outdent,newline,forecolor,hilitecolor,superscript,subscript,separator,quote,code,inserthorizontalrule,insertanchor,insertdate,separator,createlink,unlink,separator,insertimage,imagemanager,imageproperties,separator,createtable,cellalign,cellborders,cellcolor,toggleborders,themecss,togglemode,separator");

//SMALL TOOLBAR OPTIONS
define("_XK_P_SMALLTOOLBAR", "fontsize,forecolor,hilitecolor,separator,bold,italic,underline,strikethrough,separator,quote,code,separator,createlink,insertimage,imagemanager");

//TEXT DIRECTION(ltr / rtl)
define("_XK_P_TDIRECTION", "ltr");

//SKIN (default / xp)
define("_XK_P_SKIN", "default");


//WIDTH
define("_XK_P_WIDTH","100%");

//HEIGHT
define("_XK_P_HEIGHT","400px");

if (!defined("XOOPS_ROOT_PATH")) {
    include dirname(__FILE__) . "/../../xoopseditor.inc.php";
    if (!defined("XOOPS_UPLOAD_PATH")) {
        die("Path error!");
    }
}

/*
//PATH
$current_path = __FILE__;
if ( DIRECTORY_SEPARATOR != "/" ) $current_path = str_replace( strpos( $current_path, "\\\\", 2 ) ? "\\\\" : DIRECTORY_SEPARATOR, "/", $current_path);
define("_XK_P_PATH", substr(dirname($current_path), strlen(realpath(XOOPS_ROOT_PATH))));
*/

define("_XK_P_PATH", "/class/xoopseditor/koivi/koivieditor/");

?>