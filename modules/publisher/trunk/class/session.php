<?php
/**
 * A wrapper around PHP's session functions
 * @package publisher
 * @author Harry Fuecks (PHP Anthology Volume II)
 */
 
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

include_once dirname(dirname(__FILE__)) . '/include/common.php';

class PublisherSession {
     
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
    
    function singleton()
    {
        static $_sess;
        
        if (!isset($_sess)) {
            $_sess =& new PublisherSession();
        }
        return $_sess;
    }
}
?>