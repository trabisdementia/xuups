<?php

class NewsletterMailer {
    var $dispatchid;
    var $dispatch;
    var $subject;
    var $body;
    var $fromEmail;
    var $fromName;
    var $headers = array();
    var $attachments = array();
    var $LE = "\r\n";

    function NewsletterMailer($dispatch) {
        $this->dispatch =& $dispatch;
    }
    /**
     * Send newsletter via the Mlmmj mailing list
     *
     * @param array $email
     * @return bool
     */
    function send($email) {
        return true;
    }

    /**
     * Add header to the email
     *
     * @param string $value
     */
    function addHeaders($value)
    {
        $this->headers[] = trim($value).$this->LE;
    }
}