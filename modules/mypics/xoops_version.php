<?php
// $Id: xoops_version.php,v 1.4 2007/08/26 18:03:53 marcellobrandao Exp $
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

$modversion['name'] = "My Pics";
$modversion['version'] = 1.0;
$modversion['description'] = "This module will allow each member to have a picture's album with an X numebr of files. The module uses the ";
$modversion['credits'] = "The XOOPS Project, Lightbox2, Komeia";
$modversion['author'] = "Marcello Brandão";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/module_logo.png";
$modversion['dirname'] = "mypics";

//Adicionado para rodar no about
$modversion['developer_website_url'] = "http://sourceforge.net/users/marcellobrandao/";
$modversion['developer_website_name'] = "Marcello Brandão in Sourceforge";
$modversion['developer_email'] = "marcello.brandao@gmail.com";
$modversion['status_version'] = "RC1";
$modversion['status'] = "RC";
$modversion['date'] = "2007-08-26";

$modversion['people']['developers'][] = "Suiço (Marcello Brandão)";
$modversion['people']['developers'][] = "Leandro Vieira";

$modversion['people']['testers'][] = "Luix (xoopstotal.com.br)";
$modversion['people']['testers'][] = "BoOot (xoopstotal.com.br)";
$modversion['people']['testers'][] = "Rodrigo (komeia)";
$modversion['people']['testers'][] = "César Felipe (komeia)";

$modversion['people']['translators'][] = "Marcello Brandão (english)";
$modversion['people']['translators'][] = "Luix (portuguesebr)";

//$modversion['people']['documenters'][] = "documenter 1";

$modversion['people']['other'][] = "Komeia (patrocínio)";

$modversion['demo_site_url'] = "";
$modversion['demo_site_name'] = "";
$modversion['support_site_url'] = "http://sourceforge.net/projects/galeriamypics/";
$modversion['support_site_name'] = "Sourceforge";
$modversion['submit_bug'] = "http://sourceforge.net/tracker/?func=add&group_id=204109&atid=988288";
$modversion['submit_feature'] = "http://sourceforge.net/tracker/?func=add&group_id=204109&atid=988291";


$modversion['hasMain'] = 1;

$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

$modversion['config'][] = array(
    'name' => 'nb_pict',
    'title' => '_MI_MYPICS_NUMBPICT_TITLE',
    'description' => '_MI_MYPICS_NUMBPICT_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => 12
);

$modversion['config'][] = array(
    'name' => 'picturesperpage',
    'title' => '_MI_MYPICS_PICPAGE_TITLE',
    'description' => '_MI_MYPICS_PICPAGE_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => 10
);

$modversion['config'][] = array(
    'name' => 'path_upload',
    'title' => '_MI_MYPICS_PATHUPLOAD_TITLE',
    'description' => '_MI_MYPICS_PATHUPLOAD_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => XOOPS_ROOT_PATH . "/uploads"
);

$modversion['config'][] = array(
    'name' => 'link_path_upload',
    'title' => '_MI_MYPICS_LINKPATHUPLOAD_TITLE',
    'description' => '_MI_MYPICS_LINKPATHUPLOAD_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'text',
    'default' => XOOPS_URL . "/uploads"
);

$modversion['config'][] = array(
    'name' => 'thumb_width',
    'title' => '_MI_MYPICS_THUMBW_TITLE',
    'description' => '_MI_MYPICS_THUMBW_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => 125
);

$modversion['config'][] = array(
    'name' => 'thumb_height',
    'title' => '_MI_MYPICS_THUMBH_TITLE',
    'description' => '_MI_MYPICS_THUMBH_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => 175
);

$modversion['config'][] = array(
    'name' => 'resized_width',
    'title' => '_MI_MYPICS_RESIZEDW_TITLE',
    'description' => '_MI_MYPICS_RESIZEDW_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => 650
);

$modversion['config'][] = array(
    'name' => 'resized_height',
    'title' => '_MI_MYPICS_RESIZEDH_TITLE',
    'description' => '_MI_MYPICS_RESIZEDH_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => 450
);

$modversion['config'][] = array(
    'name' => 'max_original_width',
    'title' => '_MI_MYPICS_ORIGINALW_TITLE',
    'description' => '_MI_MYPICS_ORIGINALW_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => 2048
);

$modversion['config'][] = array(
    'name' => 'max_original_height',
    'title' => '_MI_MYPICS_ORIGINALH_TITLE',
    'description' => '_MI_MYPICS_ORIGINALH_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => 1600
);

$modversion['config'][] = array(
    'name' => 'max_file_size',
    'title' => '_MI_MYPICS_MAXFILEBYTES_TITLE',
    'description' => '_MI_MYPICS_MAXFILEBYTES_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => 512000
);

$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

$modversion['tables'][] = 'mypics_image';

$modversion['templates'][] = array(
    'file' => 'mypics_index.html',
    'description' => _MI_MYPICS_TPL_INDEX
);

$modversion['hasComments'] = 1;
$modversion['comments']['itemName'] = 'uid';
$modversion['comments']['pageName'] = 'index.php';

// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "mypics_search";

//Notifications
$modversion['hasNotification'] = 1;
$modversion['notification']['category'][] = array(
    'name' => 'picture',
    'title' => _MI_MYPICS_NEWCAT_NOTIFY,
    'description' => _MI_MYPICS_NEWCAT_NOTIFY_DSC,
    'subscribe_from' => 'index.php',
    'item_name' => 'uid',
    'allow_bookmark' => 1
);
$modversion['notification']['event'][]= array(
    'name' => 'new_picture',
    'category' => 'picture',
    'title' => _MI_MYPICS_NEWPIC_NOTIFY,
    'caption' => _MI_MYPICS_NEWPIC_NOTIFY_CAP,
    'description' => _MI_MYPICS_NEWPIC_NOTIFY_DSC,
    'mail_template' => 'picture_newpic_notify',
    'mail_subject' =>  _MI_MYPICS_NEWPIC_NOTIFY_SBJ
);


$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'mypics_iteminfo';

$modversion['blocks'][] = array(
    'file' => 'blocks.php',
    'name' => _MI_MYPICS_LAST,
    'description' => _MI_MYPICS_LAST_DSC,
    'show_func' => 'b_mypics_lastpictures_show',
    'edit_func' => 'b_mypics_lastpictures_edit',
    'options' => '5',
    'template' => 'mypics_block_lastpictures.html'
);

?>