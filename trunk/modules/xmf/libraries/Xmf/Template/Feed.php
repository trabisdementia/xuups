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
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Xmf
 * @since           0.1
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

class Xmf_Template_Feed extends Xmf_Template_Abstract
{
    public $title;
    public $url;
    public $description;
    public $language;
    public $charset;
    public $category;
    public $pubdate;
    public $webmaster;
    public $generator;
    public $copyright;
    public $lastbuild;
    public $editor;
    public $ttl;
    public $image_title;
    public $image_url;
    public $image_link;
    public $image_width;
    public $image_height;
    public $items;

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct($this);
        $this->setTemplate(XMF_ROOT_PATH . '/templates/xmf_feed.html');
        $this->disableLogger();

        global $xoopsConfig;
        $this->title = $xoopsConfig['sitename'];
        $this->url = XOOPS_URL;
        $this->description = $xoopsConfig['slogan'];
        $this->language = _LANGCODE;
        $this->charset = _CHARSET;
        $this->pubdate = date(_DATESTRING, time());
        $this->lastbuild = formatTimestamp(time(), 'D, d M Y H:i:s');
        $this->webmaster = $xoopsConfig['adminmail'];
        $this->editor = $xoopsConfig['adminmail'];
        $this->generator = XOOPS_VERSION;
        $this->copyright = 'Copyright ' . formatTimestamp( time(), 'Y' ) . ' ' . $xoopsConfig['sitename'];
        $this->ttl = 60;
        $this->image_title = $this->title;
        $this->image_url = XOOPS_URL . '/images/logo.gif';
        $this->image_link = $this->url;
        $this->image_width  = 200;
        $this->image_height = 50;
        //title link description pubdate guid category author
        $this->items = array();
    }

    /**
     * Render the feed and display it directly
     */
    function render()
    {
        $this->tpl->assign('channel_charset', $this->charset);
        $this->tpl->assign('channel_title', $this->title);
        $this->tpl->assign('channel_link', $this->url);
        $this->tpl->assign('channel_desc', $this->description);
        $this->tpl->assign('channel_webmaster', $this->webmaster);
        $this->tpl->assign('channel_editor', $this->editor);
        $this->tpl->assign('channel_category', $this->category);
        $this->tpl->assign('channel_generator', $this->generator);
        $this->tpl->assign('channel_language', $this->language);
        $this->tpl->assign('channel_lastbuild', $this->lastbuild);
        $this->tpl->assign('channel_copyright', $this->copyright);
        $this->tpl->assign('channel_ttl', $this->ttl);
        $this->tpl->assign('channel_image_url', $this->image_url);
        $this->tpl->assign('channel_image_title', $this->image_title);
        $this->tpl->assign('channel_image_url', $this->image_url);
        $this->tpl->assign('channel_image_link', $this->image_link);
        $this->tpl->assign('channel_image_width', $this->image_width);
        $this->tpl->assign('channel_image_height', $this->image_height);
        $this->tpl->assign('channel_items', $this->items);
    }
}