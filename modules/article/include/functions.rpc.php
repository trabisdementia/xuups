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
 * @version         $Id: functions.rpc.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

include dirname(__FILE__)."/vars.php";
define($GLOBALS["artdirname"] . "_FUNCTIONS_RPC_LOADED", TRUE);

if (!defined("ART_FUNCTIONS_RPC")):
define("ART_FUNCTIONS_RPC", 1);

/**
 * Function to send a trackback
 *
 * @return bool
 */
function art_trackback($trackback_url, &$article)
{
    global $myts, $xoopsConfig, $xoopsModule, $xoopsModuleConfig;

    $myts =& MyTextSanitizer::getInstance();
    $title = $article->getVar("art_title");
    $excerpt = $article->getSummary();
    $blog_name = $xoopsConfig["sitename"] . "-" . $xoopsModule->getVar("name");
    if (!empty($xoopsModuleConfig["do_trackbackutf8"])) {
        $title = xoops_utf8_encode($title);
        $excerpt = xoops_utf8_encode($excerpt);
        $blog_name = xoops_utf8_encode($blog_name);
        $charset="utf-8";
    } else {
        $charset = _CHARSET;
    }
    $title1 = urlencode($title);
    $excerpt1 = urlencode($excerpt);
    $name1 = urlencode($blog_name);
    $url = urlencode(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/view.article.php" . URL_DELIMITER . $article->getVar("art_id"));
    $query_string = "title=$title1&url=$url&blog_name=$name1&excerpt=$excerpt1&charset=$charset";
    $trackback_url = parse_url($trackback_url);
    
    $http_request  = 'POST ' . $trackback_url['path'] . ($trackback_url['query'] ? '?' . $trackback_url['query'] : '') . " HTTP/1.0\r\n";
    $http_request .= "Host: " . $trackback_url["host"] . "\r\n";
    $http_request .= "Content-Type: application/x-www-form-urlencoded; charset=" . $charset . "\r\n";
    $http_request .= "Content-Length: ".strlen($query_string) . "\r\n";
    $http_request .= "User-Agent: XOOPS Article/" . XOOPS_VERSION;
    $http_request .= "\r\n\r\n";
    $http_request .= $query_string;
    if ( '' == $trackback_url['port'] ) {
        $trackback_url['port'] = 80;
    }
    $fs = @fsockopen($trackback_url['host'], $trackback_url['port'], $errno, $errstr, 4);
    @fputs($fs, $http_request);
    if ($xoopsModuleConfig["do_debug"]) {
        $debug_file = XOOPS_CACHE_PATH . "/" . $GLOBALS["artdirname"] . "_trackback.log";
        $fr = "\n*****\nRequest:\n\n$http_request\n\nResponse:\n\n";
        $fr .= "CHARSET:$charset\n";
        $fr .= "NAME:$blog_name\n";
        $fr .= "TITLE:" . $title . "\n";
        $fr .= "EXCERPT:$excerpt\n\n";
        while (!@feof($fs)) {
            $fr .= @fgets($fs, 4096);
        }
        $fr .= "\n\n";

        if ($fp = fopen($debug_file, "a")) {
            fwrite($fp, $fr);
            fclose($fp);
        } else {
        }
    }
    @fclose($fs);
    return true;
}

/**
 * Function to ping servers
 */
function art_ping($server, $id)
{
    if (is_array($server)) {
        foreach ($server as $serv) {
            art_ping($serv, $id);
        }
    }
    include_once XOOPS_ROOT_PATH . "/modules/" . $GLOBALS["artdirname"] . "/class/class-IXR.php";

    // using a timeout of 3 seconds should be enough to cover slow servers
    $client = new IXR_Client($server, false);
    $client->timeout = 3;
    $client->useragent .= ' -- XOOPS Article/' . XOOPS_VERSION;

    // when set to true, this outputs debug messages by itself
    $client->debug = false;
    
    $blogname = xoops_utf8_encode($GLOBALS['xoopsModule']->getVar("name"));
    $home = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/";
    $rss2_url = XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/xml.php" . URL_DELIMITER . "rss2.0/" . $id;
    
    if ( !$client->query('weblogUpdates.extendedPing', $blogname, $home, $rss2_url ) ) // then try a normal ping
        $client->query('weblogUpdates.ping', $blogname, $home);
}

/**
 * Function to respond to a trackback
 */
function art_trackback_response($error = 0, $error_message = '') 
{
    $moduleConfig = art_load_config();
    
    if (!empty($moduleConfig["do_trackbackutf8"])) {
        $charset = "utf-8";
        $error_message = xoops_utf8_encode($error_message);
    } else {
        $charset = _CHARSET;
    }
    header('Content-Type: text/xml; charset="' . $charset . '"');
    if ($error) {
        echo '<?xml version="1.0" encoding="' . $charset . '"?'.">\n";
        echo "<response>\n";
        echo "<error>1</error>\n";
        echo "<message>$error_message</message>\n";
        echo "</response>";
        die();
    } else {
        echo '<?xml version="1.0" encoding="' . $charset . '"?' . ">\n";
        echo "<response>\n";
        echo "<error>0</error>\n";
        echo "</response>";
    }
}
ENDIF;
?>