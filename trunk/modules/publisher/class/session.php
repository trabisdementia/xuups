<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/

/**
 *  Publisher class
 *
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Publisher
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @author          Harry Fuecks (PHP Anthology Volume II)
 * @version         $Id: session.php 0 2009-06-11 18:47:04Z trabis $
 */

defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

include_once dirname(dirname(__FILE__)) . '/include/common.php';

class PublisherSession
{
    /**
     * Session constructor<br />
     * Starts the session with session_start()
     * <b>Note:</b> that if the session has already started,
     * session_start() does nothing
     * @access public
     */
    function PublisherSession()
    {
        @session_start();
    }

    /**
     * Sets a session variable
     * @param string name of variable
     * @param mixed value of variable
     * @return void
     * @access public
     */
    function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Fetches a session variable
     * @param string name of variable
     * @return mixed value of session variable
     * @access public
     */
    function get($name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        } else {
            return false;
        }
    }

    /**
     * Deletes a session variable
     * @param string name of variable
     * @return void
     * @access public
     */
    function del($name)
    {
        unset($_SESSION[$name]);
    }


    /**
     * Destroys the whole session
     * @return void
     * @access public
     */
    function destroy()
    {
        $_SESSION = array();
        session_destroy();
    }

    function &getInstance()
    {
        static $_sess;
        if (!isset($_sess)) {
            $_sess = new PublisherSession();
        }
        return $_sess;
    }
}
?>