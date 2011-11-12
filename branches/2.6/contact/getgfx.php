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
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id$
 */

include_once dirname(__FILE__) . '/header.php';
error_reporting(0);
$GLOBALS['xoopsLogger']->activated = false;

$site_key = $GLOBALS['contact']->getConfig('contact_sitekey');
$random_num = Xmf_Request::getInt('random_num');
$datekey = date("F j");
$rcode = hexdec(md5($_SERVER['HTTP_USER_AGENT'] . $random_num . $site_key . $datekey));
$code = substr($rcode, 2, 6);
$image = ImageCreateFromJPEG("images/code_bg.jpg");
$text_color = ImageColorAllocate($image, 80, 80, 80);
Header("Content-type: image/jpeg");
ImageString($image, 5, 12, 2, $code, $text_color);
ImageJPEG($image, '', 75);
ImageDestroy($image);
die();
