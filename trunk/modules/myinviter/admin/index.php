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
 * @copyright       The XUUPS Project http://www.xuups.com
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Myinviter
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: index.php 0 2009-11-14 18:47:04Z trabis $
 */

include_once dirname(__FILE__) . '/admin_header.php';

$choice = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';
switch ($choice) {
    default:
        myinviter_index();
        break;
}

function myinviter_index()
{
    xoops_cp_header();
    myinviter_adminMenu(0, _MI_MYINV_ADMENU_INDEX);
    xoops_cp_footer();
}

?>