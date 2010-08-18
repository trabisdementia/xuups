<?php
/**
 * Text form for CAPTCHA
 *
 * D.J.
 */

class XoopsCaptchaText {
    var $config	= array();
    var $code;

    function XoopsCaptchaText()
    {
    }

    function &instance()
    {
        static $instance;
        if(!isset($instance)) {
            $instance = new XoopsCaptchaText();
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

    function setCode()
    {
        $_SESSION['XoopsCaptcha_sessioncode'] = strval( $this->code );
    }

    function render()
    {
        $form = $this->loadText()  . "&nbsp;&nbsp; <input type='text' name='".$this->config["name"]."' id='".$this->config["name"]."' size='" . $this->config["num_chars"] . "' maxlength='" . $this->config["num_chars"] . "' value='' />";
        $rule = constant("XOOPS_CAPTCHA_RULE_TEXT");
        if(!empty($rule)) {
            $form .= "&nbsp;&nbsp;<small>{$rule}</small>";
        }

        $this->setCode();

        return $form;
    }

    function loadText()
    {
        $val_a = rand(0, 9);
        $val_b = rand(0, 9);
        if($val_a > $val_b) {
            $expression = "{$val_a} - {$val_b} = ?";
            $this->code = $val_a - $val_b;
        }else{
            $expression = "{$val_a} + {$val_b} = ?";
            $this->code = $val_a + $val_b;
        }

        return "<span style='font-style: normal; font-weight: bold; font-size: 100%; font-color: #333; border: 1px solid #333; padding: 1px 5px;'>{$expression}</span>";
    }

}
?>