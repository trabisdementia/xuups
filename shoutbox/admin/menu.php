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
 * @package         Shoutbox
 * @author          Alphalogic <alphafake@hotmail.com>
 * @author          tank <tanksplace@comcast.net>
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: menu.php 0 2010-01-29 18:47:04Z trabis $
 */

$adminmenu[1]['title'] = _MI_SHOUTBOX_MENU_DB;
$adminmenu[1]['link'] = "admin/index.php?op=shoutboxList";
$adminmenu[2]['title'] = _MI_SHOUTBOX_MENU_FILE;
$adminmenu[2]['link'] = "admin/index.php?op=shoutboxFile";
$adminmenu[3]['title'] = _MI_SHOUTBOX_MENU_STATUS;
$adminmenu[3]['link'] = "admin/index.php?op=shoutboxStatus";
?>