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
 * @version         $Id: functions.parse.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

include dirname(__FILE__) . "/vars.php";
define($GLOBALS["artdirname"] . "_FUNCTIONS_PARSE_LOADED", TRUE);

if (!defined("ART_FUNCTIONS_PARSE")):
define("ART_FUNCTIONS_PARSE", 1);

/**
 * Function to parse arguments for a page according to $_SERVER['REQUEST_URI']
 * 
 * @var array $args_numeric    array of numeric variable values
 * @var array $args            array of indexed variables: name and value
 * @var array $args_string    array of string variable values
 *
 * @return bool    true on args parsed
 */

/* known issues:
 * - "/" in a string 
 * - "&" in a string 
*/
function art_parse_args(&$args_numeric, &$args, &$args_string)
{
    $args_abb = array(
                        "a"    => "article", 
                        "c"    => "category", 
                        "k"    => "keyword", 
                        "p"    => "page", 
                        "s"    => "start", 
                        "t"    => "topic", 
                        "u"    => "uid"
                        );
    $args = array();
    $args_numeric = array();
    $args_string = array();
    if (preg_match("/[^\?]*\.php[\/|\?]([^\?]*)/i", $_SERVER['REQUEST_URI'], $matches)) {
        $vars = preg_split("/[\/|&]/", $matches[1]);
        $vars = array_map("trim", $vars);
        if ( count($vars) > 0 ) {
            foreach ($vars as $var) {
                if (is_numeric($var)) {
                    $args_numeric[] = $var;
                } elseif (false === strpos($var, "=")) {
                    if (is_numeric(substr($var, 1))) {
                        $args[$args_abb[strtolower($var{0})]] = intval(substr($var, 1));
                    } else {
                        $args_string[] = urldecode($var);
                    }
                } else {
                    parse_str($var, $args_tmp);
                    $args = array_merge($args, $args_tmp);
                }
            }
        }
    }
    return (count($args) + count($args_numeric) + count($args_string) == 0) ? null : true;
}

/**
 * Function to parse class prefix
 * 
 * @var string     $class_string    string to be parsed
 * @var mixed     $pattern
 * @var mixed     $replacement
 *
 * @return bool    true on success
 */
function art_parse_class($class_string, $pattern = "", $replacement = "")
{
    if (empty($class_string)) return;
    $patterns = array("/\[CLASS_PREFIX\]/");
    $replacements = array(ucfirst(strtolower($GLOBALS["artdirname"])));
    if (!empty($pattern) && !is_array($pattern) && !is_array($replacement)) {
        $pattern = array($pattern);
        $replacement = array($replacement);
    }
    if (is_array($pattern) && count($pattern) > 0) {
        $ii = 0;
        foreach ($pattern as $pat) {
            if (!in_array($pat, $patterns)) {
                $patterns[] = $pat;
                $replacements[] = isset($replacement[$ii]) ? $replacement[$ii] : "";
            }
            $ii++;
        }
    }
    $class_string = preg_replace($patterns, $replacements, $class_string);
    eval($class_string);
    return true;
}

/**
 * Function to parse function prefix
 * 
 * @var string     $function_string    string to be parsed
 * @var mixed     $pattern
 * @var mixed     $replacement
 *
 * @return bool    true on success
 */
function art_parse_function($function_string, $pattern = "", $replacement = "")
{
    if (empty($function_string)) return;
    $patterns = array("/\[DIRNAME\]/", "/\[VAR_PREFIX\]/");
    $replacements = array($GLOBALS["artdirname"], $GLOBALS["ART_VAR_PREFIX"]);
    if (!empty($pattern) && !is_array($pattern) && !is_array($replacement)) {
        $pattern = array($pattern);
        $replacement = array($replacement);
    }
    if (is_array($pattern) && count($pattern) > 0) {
        $ii = 0;
        foreach ($pattern as $pat) {
            if (!in_array($pat, $patterns)) {
                $patterns[] = $pat;
                $replacements[] = isset($replacement[$ii]) ? $replacement[$ii] : "";
            }
            $ii++;
        }
    }
    $function_string = preg_replace($patterns, $replacements, $function_string);
    eval($function_string);
    return true;
}

/**
 * Function to parse links, links are delimited by link break, URL and title of a link are delimited by space
 * 
 * @var string     $text raw content
 *
 * @return array    associative array of link url and title
 */
function &art_parseLinks($text)
{
    $myts =& MyTextSanitizer::getInstance();
    $link_array = preg_split("/(\r\n|\r|\n)( *)/", $text);
    $links = array();
    foreach ($link_array as $link) {
        @list($url, $title) = array_map("trim", preg_split("/ /", $link, 2));
        if (empty($url)) continue;
        if (empty($title)) $title = $url;
        $links[] = array(
            "url"    => $url, 
            "title"    => $myts->htmlSpecialChars($title)
            );
    }
    return $links;
}

ENDIF;
?>