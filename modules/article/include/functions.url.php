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
 * @version         $Id: functions.url.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

include dirname(__FILE__) . "/vars.php";
define($GLOBALS["artdirname"] . "_FUNCTIONS_URL_LOADED", TRUE);

IF (!defined("ART_FUNCTIONS_URL")):
define("ART_FUNCTIONS_URL", 1);

$GLOBALS["art_args"] = array(
                    "a"    => "article", 
                    "c"    => "category", 
                    "k"    => "keyword", 
                    "p"    => "page", 
                    "s"    => "start", 
                    "t"    => "topic", 
                    "u"    => "uid"
                    );

/**
 * Build an URL with the specified request params
 *
 * By calling $xoops->buildUrl
 */
function art_buildUrl( $url, $params = array()/*, $params_string = array(), $params_numeric = array()*/ ) 
{
    $url =  $GLOBALS["xoops"]->buildUrl($url);
    if ( !empty( $params ) ) {
        $args = array_flip($GLOBALS["art_args"]);
        foreach ( $params as $k => $v ) {
            if (isset($args[$k])) {
                $params[$k] = $args[$k] . rawurlencode($v);
            } else {
                $params[$k] = rawurlencode($v);
            }
        }
        art_define_url_delimiter();
        $url .= URL_DELIMITER . implode( '&amp;', $params );
    }
    return $url;
}


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
function art_parseUrl(&$args_numeric, &$args, &$args_string)
{
    $args_abb =& $GLOBALS["art_args"];
    $args = array();
    $args_numeric = array();
    $args_string = array();
    if (preg_match("/[^\?]*\.php[\/|\?]([^\?]*)/i", $_SERVER['REQUEST_URI'], $matches)) {
        $vars = preg_split("/[\/|&]/", $matches[1]);
        $vars = array_map("trim", $vars);
        if (count($vars) > 0) {
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
                    parse_str($var, $args);
                }
            }
        }
    }
    return (count($args) + count($args_numeric) + count($args_string));
}

/**
 * Function to get linked image located in module file folder
 * 
 * @var string     $imageName image file name
 * @var string     $imagePath full path to the image file if different from preset folder
 * @var string     $size    size parameters for pseudo thumbnail
 * @var string     $alt    alter string
 *
 * @return string linked image tag
 */
function art_getImageLink($imageName, $imagePath = null, $size = null, $alt = "")
{
    global $xoopsModuleConfig, $xoopsModule;
    
    if (empty($imageName)) return null;
    
    if (empty($size["width"]) && empty($size["height"])):
    return "<img src=\"" . art_getImageUrl($imageName, $imagePath) . "\" alt=\"" . $alt . "\" />";
    endif;
    
    if (empty($imagePath)) {
        $moduleConfig = art_load_config();
        $path_image = $moduleConfig["path_image"];
        $imageFile =  XOOPS_ROOT_PATH . "/" . $path_image . "/" . htmlspecialchars($imageName);
        $imageUrl =  XOOPS_URL . "/" . $path_image . "/" . htmlspecialchars($imageName);
    } else {
          if (!preg_match("/^" . preg_quote(XOOPS_ROOT_PATH, "/") . "/", $imagePath)) {
              $imagePath = XOOPS_ROOT_PATH . "/" . $imagePath;
          }
        $imageFile =  htmlspecialchars($imagePATH . "/" . $imageName);
        $imageUrl =  htmlspecialchars(XOOPS_URL . "/" . (preg_replace("/^" . preg_quote(XOOPS_ROOT_PATH, "/") . "/", "", $imagePath)) . "/" . $imageName);
    }
    $imageSizeString = "";
    if (!$imageSize = @getimagesize($imageFile)) {
    } elseif (!empty($size["width"]) && $size["width"] < $imageSize[0]) {
        $imageSizeString = "width: " . $size["width"]."px";
    } elseif (!empty($size["height"]) && $size["height"] < $imageSize[1]) {
        $imageSizeString = "height: " . $size["height"] . "px";
    }
    $link = "<img src=\"" . $imageUrl . "\" style=\"" . $imageSizeString . "\" alt=\"" . $alt . "\" />";
    return $link;
}


/**
 * Function to get url of an file located in module file folder
 * 
 * @var string     $imageName image file name
 * @var string     $imagePath full path to the image file if different from preset folder
 *
 * @return string image url
 */
function art_getFileUrl($imageName, $imagePath = null)
{
    global $xoopsModuleConfig, $xoopsModule;
    
    if (empty($imageName)) return null;
    
    if (empty($imagePath)) {
        $moduleConfig = art_load_config();
        $path_image = $moduleConfig["path_file"];
        $imageUrl =  XOOPS_URL . "/" . $path_image . "/" . htmlspecialchars($imageName);
    } else {
        $imageUrl =  htmlspecialchars(XOOPS_URL . "/" . (preg_replace("/^" . preg_quote(XOOPS_ROOT_PATH, "/") . "/", "", $imagePath)) . "/" . $imageName);
    }
    
    return $imageUrl;
}

/**
 * Function to get url of an image located in module utility image folder
 * 
 * @var string     $imageName image file name
 * @var string     $imagePath full path to the image file if different from preset folder
 *
 * @return string image url
 */
function art_getImageUrl($imageName, $imagePath = null)
{
    global $xoopsModuleConfig, $xoopsModule;
    
    if (empty($imageName)) return null;
    
    if (empty($imagePath)) {
        $moduleConfig = art_load_config();
        $path_image = $moduleConfig["path_image"];
        $imageUrl =  XOOPS_URL . "/" . $path_image . "/" . htmlspecialchars($imageName);
    } else {
        $imageUrl =  htmlspecialchars(XOOPS_URL . "/" . (preg_replace("/^" . preg_quote(XOOPS_ROOT_PATH, "/") . "/", "", $imagePath)) . "/" . $imageName);
    }
    
    return $imageUrl;
}
ENDIF;
?>