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
 * @version         $Id: xmlpc.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
    exit();
}
include_once dirname(dirname(__FILE__)) . "/include/vars.php";
mod_loadFunctions("parse", $GLOBALS["artdirname"]);


if (!class_exists("Xmlrpc_client")) {
class Xmlrpc_client
{
    function Xmlrpc_client()
    {
    }

    function setObject(&$article)
    {
        $this->$var = $val;
    }

    function setVar($var, $val)
    {
        $this->$var = $val;
    }

    function getVar($var)
    {
        return $this->$var;
    }
}
}


if (!class_exists("Xmlrpc_server")) {
class Xmlrpc_server
{

    function Xmlrpc_server()
    {
    }

    function setVar($var, $val)
    {
        $this->$var = $val;
    }

    function getVar($var)
    {
        return $this->$var;
    }
}
}

art_parse_class('
class [CLASS_PREFIX]XmlrpcHandler
{
    function &get($type = "c")
    {
        switch (strtolower($type)) {
        case "s":
        case "server":
            return new Xmlrpc_server();
        case "c":
        case "client":
            return new Xmlrpc_client();
        }
    }

    function display(&$feed, $filename = "")
    {
        if (!is_object($feed)) return null;
        $filename = empty($filename) ? $feed->filename : $filename;
        echo $feed->saveFeed($feed->version, $filename);
    }

    function utf8_encode(&$feed)
    {
        if (!is_object($feed)) return null;
        $text = xoops_utf8_encode(serialize($feed));
        $feed = unserialize($text);
    }
}
');
?>