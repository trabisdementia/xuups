<?php
// $Id$
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

$adminMyDirName = basename(dirname(dirname(dirname(__FILE__))));

define('_AM_XPARTNERS_URL', 'URL');
define('_AM_XPARTNERS_HITS', 'Hits');
define('_AM_XPARTNERS_IMAGE', 'Image');
define('_AM_XPARTNERS_TITLE', 'Title');
define('_AM_XPARTNERS_WEIGHT', 'Weight');
define('_AM_XPARTNERS_DESCRIPTION', 'Description');
define('_AM_XPARTNERS_STATUS', 'Status');
define('_AM_XPARTNERS_ACTIVE', 'Active');
define('_AM_XPARTNERS_INACTIVE', 'Inactive');
define('_AM_XPARTNERS_REORDER', 'Sort');
define('_AM_XPARTNERS_UPDATED', 'Settings Updated!');
define('_AM_XPARTNERS_NOTUPDATED', 'Could not update settings!');
define('_AM_XPARTNERS_BESURE', 'Be sure to enter at least a title, a URL and a description.');
define('_AM_XPARTNERS_NOEXIST', "File is not a valid image file or it doesn't exist");
define('_AM_XPARTNERS_ADDPARTNER', 'Add');
define('_AM_XPARTNERS_EDITPARTNER', 'Edit');
define('_AM_XPARTNERS_SUREDELETE', 'Are you sure you want to delete this site?');
define('_AM_XPARTNERS_IMAGE_ERROR', 'Image size is larger than 150x80!');
define('_AM_XPARTNERS_ADD', 'Add Partner');
define('_AM_XPARTNERS_AUTOMATIC_SORT', 'Automatic sort');


//1.11

// About.php
define('_AM_XPARTNERS_ABOUT_RELEASEDATE', 'Released: ');
define('_AM_XPARTNERS_ABOUT_UPDATEDATE', 'Updated: ');
define('_AM_XPARTNERS_ABOUT_AUTHOR', 'Author: ');
define('_AM_XPARTNERS_ABOUT_CREDITS', 'Credits: ');
define('_AM_XPARTNERS_ABOUT_LICENSE', 'License: ');
define('_AM_XPARTNERS_ABOUT_MODULE_STATUS', 'Status: ');
define('_AM_XPARTNERS_ABOUT_WEBSITE', 'Website: ');
define('_AM_XPARTNERS_ABOUT_AUTHOR_NAME', 'Author name: ');
define('_AM_XPARTNERS_ABOUT_CHANGELOG', 'Change Log');
define('_AM_XPARTNERS_ABOUT_MODULE_INFO', 'Module Infos');
define('_AM_XPARTNERS_ABOUT_AUTHOR_INFO', 'Author Infos');
define('_AM_XPARTNERS_ABOUT_DESCRIPTION', 'Description: ');
define('_AM_XPARTNERS_EMPTYDATABASE', 'There is nothing to sort. Please add some Partners first!');

// Configuration
define('_AM_XPARTNERS_CONFIG_CHECK', 'Configuration Check');
define('_AM_XPARTNERS_CONFIG_PHP', 'Minimum PHP required: %s (your version is %s)');
define('_AM_XPARTNERS_CONFIG_XOOPS', 'Minimum XOOPS required:  %s (your version is %s)');

define('_AM_XPARTNERS_ACTIONS', 'Actions');
define('_AM_XPARTNERS_INVALIDID', 'No partner exists with this ID');

// text in admin footer
define('_AM_MYLINKS_ADMIN_FOOTER',
    "<div class='right smallsmall italic pad5'>" . "<strong>{$adminMyDirName}</strong> is maintained by the "
    . "<a class='tooltip' rel='external' href='http://xoops.org/' title='Visit XOOPS Community'>XOOPS Community</a>"
    . "</div>");