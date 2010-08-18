<?php
/**
 * Image Creation class for CAPTCHA
 *
 * D.J.
 */

class XoopsCaptchaImage {
    var $config	= array();

    function XoopsCaptchaImage()
    {
        //$this->name = md5( session_id() );
    }

    function &instance()
    {
        static $instance;
        if(!isset($instance)) {
            $instance = new XoopsCaptchaImage();
        }
        return $instance;
    }

    /**
     * Loading configs from CAPTCHA class
     */
    function loadConfig($config = array())
    {
        // Loading default preferences
        $this->config =& $config;
    }

    function render()
    {
        $form = "<input type='text' name='".$this->config["name"]."' id='".$this->config["name"]."' size='" . $this->config["num_chars"] . "' maxlength='" . $this->config["num_chars"] . "' value='' /> &nbsp; ". $this->loadImage();
        $rule = htmlspecialchars(XOOPS_CAPTCHA_REFRESH, ENT_QUOTES);
        if($this->config["maxattempt"]) {
            $rule .=  " | ". sprintf( constant("XOOPS_CAPTCHA_MAXATTEMPTS"), $this->config["maxattempt"] );
        }
        $form .= "&nbsp;&nbsp;<small>{$rule}</small>";

        return $form;
    }


    function loadImage()
    {
        $rule = $this->config["casesensitive"] ? constant("XOOPS_CAPTCHA_RULE_CASESENSITIVE") : constant("XOOPS_CAPTCHA_RULE_CASEINSENSITIVE");
        $ret = "<img id='captcha' src='" . XOOPS_URL. "/". $this->config["imageurl"]. "' onclick=\"this.src='" . XOOPS_URL. "/". $this->config["imageurl"]. "?refresh='+Math.random()"."\" align='absmiddle'  style='cursor: pointer;' alt='".htmlspecialchars($rule, ENT_QUOTES)."' />";

        return $ret;
    }

}
?>