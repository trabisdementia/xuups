<?php
// $Id$
// ------------------------------------------------------------------------ //
// XOOPS - PHP Content Management System                                    //
// Copyright (c) 2000 XOOPS.org                                             //
// <http://www.xoops.org/>                                                  //
// ------------------------------------------------------------------------ //
// ------------------------------------------------------------------------ //
// XOOPS Korean (translated by wanikoo[ wani@wanisys.net ])                 //
// <http://www.wanisys.net/>                                                //
// ------------------------------------------------------------------------ //
// This program is free software; you can redistribute it and/or modify     //
// it under the terms of the GNU General Public License as published by     //
// the Free Software Foundation; either version 2 of the License, or        //
// (at your option) any later version.                                      //
//                                                                          //
// You may not change or alter any portion of this comment or credits       //
// of supporting developers from this source code or any supporting         //
// source code which is considered copyrighted (c) material of the          //
// original comment or credit authors.                                      //
//                                                                          //
// This program is distributed in the hope that it will be useful,          //
// but WITHOUT ANY WARRANTY; without even the implied warranty of           //
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the             //
// GNU General Public License for more details.                             //
//                                                                          //
// You should have received a copy of the GNU General Public License        //
// along with this program; if not, write to the Free Software              //
// Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA  //
// ------------------------------------------------------------------------ //

// Module Info

// The name of this module
define("_MI_MYLINKS_NAME", "ë§�í�¬ì§‘");

// A brief description of this module
define("_MI_MYLINKS_DESC", "ì‚¬ì�´íŠ¸ë§�í�¬ì •ë³´ë¥¼ ê³µìœ /í�‰ê°€í•  ìˆ˜ ìžˆëŠ” ì„œë¹„ìŠ¤ë¥¼ ì œê³µí•©ë‹ˆë‹¤.");

// Names of blocks for this module (Not all module has blocks)
define("_MI_MYLINKS_BNAME1", "ì‹ ê·œ ë§�í�¬");
define("_MI_MYLINKS_BNAME2", "ë² ìŠ¤íŠ¸ ë§�í�¬");

// Sub menu titles
define("_MI_MYLINKS_SMNAME1", "ë“±ë¡�");
define("_MI_MYLINKS_SMNAME2", "ì�¸ê¸° ë§�í�¬");
define("_MI_MYLINKS_SMNAME3", "ê³ í�‰ê°€ ë§�í�¬");

// Names of admin menu items
define("_MI_MYLINKS_ADMENU2", "ë§�í�¬ì •ë³´ ì¶”ê°€/íŽ¸ì§‘");
define("_MI_MYLINKS_ADMENU3", "ì‹ ê·œíˆ¬ê³  ë§�í�¬ì •ë³´");
define("_MI_MYLINKS_ADMENU4", "ë�Šì–´ì§„ ë§�í�¬ ì‹ ê³ ");
define("_MI_MYLINKS_ADMENU5", "ìˆ˜ì • ë§�í�¬ì •ë³´");
define("_MI_MYLINKS_ADMENU6", "ë§�í�¬ ì²´í�¬");

// Title of config items
define('_MI_MYLINKS_POPULAR', 'ì�¸ê¸° ë§�í�¬ê°€ ë�˜ê¸° ìœ„í•œ ìµœì €ë°©ë¬¸ìˆ˜');
define('_MI_MYLINKS_NEWLINKS', 'ë©”ì�¸íŽ˜ì�´ì§€ì�˜ ì‹ ê·œ ë§�í�¬ì—� í‘œì‹œí•  ë§�í�¬ì •ë³´ ìˆ˜');
define('_MI_MYLINKS_PERPAGE', 'íŽ˜ì�´ì§€ë‹¹ í‘œì‹œí•  ë§�í�¬ì •ë³´ ìˆ˜');
define('_MI_MYLINKS_USESHOTS', 'ìŠ¤í�¬ë¦°ìƒ·ì�„ ì‚¬ìš©í•¨');
define('_MI_MYLINKS_USEFRAMES', 'í”„ë ˆìž„ì�„ ì‚¬ìš©í•¨');
define('_MI_MYLINKS_SHOTWIDTH', 'ìŠ¤í�¬ë¦°ìƒ·ì�˜ ê·¸ë¦¼íŒŒì�¼ í�­');
define('_MI_MYLINKS_ANONPOST','ì†�ë‹˜ì�˜ ë§�í�¬ì •ë³´ íˆ¬ê³ ë¥¼ í—ˆìš©í•¨');
define('_MI_MYLINKS_AUTOAPPROVE','ì‹ ê·œ ë§�í�¬ì •ë³´ë¥¼ ìž�ë�™ìŠ¹ì�¸í•¨');

// Description of each config items
define('_MI_MYLINKS_POPULARDSC', 'ì�¸ê¸°ë§�í�¬ê°€ ë�˜ê¸°ìœ„í•´ í•„ìš”í•œ ë°©ë¬¸ìˆ˜ë¥¼ ì§€ì •í•´ ì£¼ì„¸ìš”!');
define('_MI_MYLINKS_NEWLINKSDSC', 'ì‹ ê·œë§�í�¬ì—� í‘œì‹œí•  ë§�í�¬ì •ë³´ ìˆ˜ë¥¼ ì§€ì •í•´ ì£¼ì„¸ìš”!');
define('_MI_MYLINKS_PERPAGEDSC', 'ë§�í�¬ì •ë³´ ë¦¬ìŠ¤íŠ¸ì—�ì„œ íŽ˜ì�´ì§€ë‹¹ í‘œì‹œí•  ë§�í�¬ì •ë³´ ìˆ˜ë¥¼ ì§€ì •í•´ ì£¼ì„¸ìš”');
define('_MI_MYLINKS_USEFRAMEDSC', 'ë§�í�¬ íŽ˜ì�´ì§€ë¥¼ í”„ë ˆìž„ë‚´ì—� í‘œì‹œí• ì§€ë¥¼ ì •í•´ ì£¼ì„¸ìš”');
define('_MI_MYLINKS_USESHOTSDSC', 'ë§�í�¬ì •ë³´ì—� ìŠ¤í�¬ë¦°ìƒ·ë�„ í‘œì‹œí•  ê²½ìš°ì—” ì˜ˆë¥¼ ì„ íƒ�í•´ ì£¼ì„¸ìš”');
define('_MI_MYLINKS_SHOTWIDTHDSC', 'ìŠ¤í�¬ë¦°ìƒ·ìš© ê·¸ë¦¼íŒŒì�¼ì�˜ ìµœëŒ€í�­ì�„ ì§€ì •í•´ ì£¼ì„¸ìš”');
define('_MI_MYLINKS_AUTOAPPROVEDSC','ì‹ ê·œ ë§�í�¬ì •ë³´ë¥¼ ìž�ë�™ìŠ¹ì�¸ì²˜ë¦¬í•˜ì‹œë ¤ë©´ ì˜ˆë¥¼ ì„ íƒ�í•´ ì£¼ì„¸ìš”');

// Text for notifications

define('_MI_MYLINKS_GLOBAL_NOTIFY', 'ëª¨ë“ˆì „ì²´');
define('_MI_MYLINKS_GLOBAL_NOTIFYDSC', 'ë‹¤ìš´ë¡œë“œ ëª¨ë“ˆ ì „ì²´ì—� ëŒ€í•œ í†µì§€ì˜µì…˜');

define('_MI_MYLINKS_CATEGORY_NOTIFY', 'í˜„ ì¹´í…Œê³ ë¦¬');
define('_MI_MYLINKS_CATEGORY_NOTIFYDSC', 'í˜„ ì¹´í…Œê³ ë¦¬ì—� ëŒ€í•œ í†µì§€ì˜µì…˜');

define('_MI_MYLINKS_LINK_NOTIFY', 'í˜„ìž¬ ë§�í�¬');
define('_MI_MYLINKS_LINK_NOTIFYDSC', 'í˜„ ë§�í�¬ì •ë³´ì—� ëŒ€í•œ í†µì§€ì˜µì…˜');

define('_MI_MYLINKS_GLOBAL_NEWCATEGORY_NOTIFY', 'ì‹ ê·œ ì¹´í…Œê³ ë¦¬');
define('_MI_MYLINKS_GLOBAL_NEWCATEGORY_NOTIFYCAP', 'ì‹ ê·œ ì¹´í…Œê³ ë¦¬ê°€ ì‹ ì„¤ë�œ ê²½ìš° í†µì§€í•¨');
define('_MI_MYLINKS_GLOBAL_NEWCATEGORY_NOTIFYDSC', 'ì‹ ê·œ ì¹´í…Œê³ ë¦¬ê°€ ì‹ ì„¤ë�œ ê²½ìš° í†µì§€í•©ë‹ˆë‹¤.');
define('_MI_MYLINKS_GLOBAL_NEWCATEGORY_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : ì‹ ê·œ ì¹´í…Œê³ ë¦¬ê°€ ì‹ ì„¤ë�˜ì—ˆìŠµë‹ˆë‹¤.');

define('_MI_MYLINKS_GLOBAL_LINKMODIFY_NOTIFY', 'ë§�í�¬ì •ë³´ ìˆ˜ì •ìš”ì²­');
define('_MI_MYLINKS_GLOBAL_LINKMODIFY_NOTIFYCAP', 'ë§�í�¬ì •ë³´ ìˆ˜ì • ìš”ì²­ì�´ ìžˆëŠ” ê²½ìš° í†µì§€í•¨');
define('_MI_MYLINKS_GLOBAL_LINKMODIFY_NOTIFYDSC', 'ë§�í�¬ì •ë³´ ìˆ˜ì • ìš”ì²­ì�´ ìžˆëŠ” ê²½ìš° í†µì§€í•©ë‹ˆë‹¤.');
define('_MI_MYLINKS_GLOBAL_LINKMODIFY_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : ë§�í�¬ì •ë³´ì—� ëŒ€í•œ ìˆ˜ì •ìš”ì²­ì�´ ìžˆì—ˆìŠµë‹ˆë‹¤.');

define('_MI_MYLINKS_GLOBAL_LINKBROKEN_NOTIFY', 'ë�Šì–´ì§„ ë§�í�¬ ì‹ ê³ ');
define('_MI_MYLINKS_GLOBAL_LINKBROKEN_NOTIFYCAP', 'ë�Šì–´ì§„ ë§�í�¬ ì‹ ê³ ê°€ ìžˆëŠ” ê²½ìš° í†µì§€í•¨');
define('_MI_MYLINKS_GLOBAL_LINKBROKEN_NOTIFYDSC', 'ë�Šì–´ì§„ ë§�í�¬ ì‹ ê³ ê°€ ìžˆëŠ” ê²½ìš° í†µì§€í•©ë‹ˆë‹¤.');
define('_MI_MYLINKS_GLOBAL_LINKBROKEN_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : ë�Šì–´ì§„ ë§�í�¬ì‹ ê³ ê°€ ìžˆì—ˆìŠµë‹ˆë‹¤.');

define('_MI_MYLINKS_GLOBAL_LINKSUBMIT_NOTIFY', 'ì‹ ê·œ ë§�í�¬ì •ë³´ íˆ¬ê³ ');
define('_MI_MYLINKS_GLOBAL_LINKSUBMIT_NOTIFYCAP', 'ì‹ ê·œ ë§�í�¬ì •ë³´ì�˜ íˆ¬ê³ ê°€ ìžˆëŠ” ê²½ìš° í†µì§€');
define('_MI_MYLINKS_GLOBAL_LINKSUBMIT_NOTIFYDSC', 'ì‹ ê·œ ë§�í�¬ì •ë³´ì�˜ íˆ¬ê³ ê°€ ìžˆëŠ” ê²½ìš° í†µì§€');
define('_MI_MYLINKS_GLOBAL_LINKSUBMIT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : ì‹ ê·œ ë§�í�¬ì •ë³´ì�˜ íˆ¬ê³ ê°€ ìžˆì—ˆìŠµë‹ˆë‹¤.');

define('_MI_MYLINKS_GLOBAL_NEWLINK_NOTIFY', 'ì‹ ê·œ ë§�í�¬ì •ë³´ ë“±ë¡�');
define('_MI_MYLINKS_GLOBAL_NEWLINK_NOTIFYCAP', 'ì‹ ê·œ ë§�í�¬ì •ë³´ê°€ ë“±ë¡�ë�˜ì–´ì§„ ê²½ìš° í†µì§€');
define('_MI_MYLINKS_GLOBAL_NEWLINK_NOTIFYDSC', 'ì‹ ê·œ ë§�í�¬ì •ë³´ê°€ ë“±ë¡�ë�˜ì–´ì§„ ê²½ìš° í†µì§€í•©ë‹ˆë‹¤.');
define('_MI_MYLINKS_GLOBAL_NEWLINK_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : ì‹ ê·œ ë§�í�¬ì •ë³´ê°€ ì •ì‹�ë“±ë¡�ë�˜ì—ˆìŠµë‹ˆë‹¤.');

define('_MI_MYLINKS_CATEGORY_LINKSUBMIT_NOTIFY', 'ì‹ ê·œ ë§�í�¬ì •ë³´ íˆ¬ê³ (íŠ¹ì • ì¹´í…Œê³ ë¦¬ë‚´)');
define('_MI_MYLINKS_CATEGORY_LINKSUBMIT_NOTIFYCAP', 'í˜„ ì¹´í…Œê³ ë¦¬ì—� ì‹ ê·œ ë§�í�¬ì •ë³´ê°€ íˆ¬ê³ ë�œ ê²½ìš° í†µì§€í•¨');
define('_MI_MYLINKS_CATEGORY_LINKSUBMIT_NOTIFYDSC', 'í˜„ ì¹´í…Œê³ ë¦¬ì—� ì‹ ê·œ ë§�í�¬ì •ë³´ê°€ íˆ¬ê³ ë�œ ê²½ìš° í†µì§€í•©ë‹ˆë‹¤.');
define('_MI_MYLINKS_CATEGORY_LINKSUBMIT_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : ì¹´í…Œê³ ë¦¬ë‚´ì—� ì‹ ê·œë§�í�¬ì •ë³´ê°€ íˆ¬ê³ ë�˜ì–´ì¡ŒìŠµë‹ˆë‹¤.');

define('_MI_MYLINKS_CATEGORY_NEWLINK_NOTIFY', 'ì‹ ê·œ ë§�í�¬ì •ë³´ ë“±ë¡�(íŠ¹ì • ì¹´í…Œê³ ë¦¬ë‚´)');
define('_MI_MYLINKS_CATEGORY_NEWLINK_NOTIFYCAP', 'í˜„ ì¹´í…Œê³ ë¦¬ì—� ë§�í�¬ì •ë³´ê°€ ì‹ ê·œë¡œ ì •ì‹�ë“±ë¡�ë�œ ê²½ìš° í†µì§€í•¨');
define('_MI_MYLINKS_CATEGORY_NEWLINK_NOTIFYDSC', 'í˜„ ì¹´í…Œê³ ë¦¬ì—� ë§�í�¬ì •ë³´ê°€ ì‹ ê·œë¡œ ì •ì‹�ë“±ë¡�ë�œ ê²½ìš° í†µì§€í•©ë‹ˆë‹¤');
define('_MI_MYLINKS_CATEGORY_NEWLINK_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : ì¹´í…Œê³ ë¦¬ì—� ë§�í�¬ì •ë³´ê°€ ì‹ ê·œë¡œ ì •ì‹�ë“±ë¡�ë�˜ì—ˆìŠµë‹ˆë‹¤.');

define('_MI_MYLINKS_LINK_APPROVE_NOTIFY', 'ë§�í�¬ì •ë³´ ìŠ¹ì�¸');
define('_MI_MYLINKS_LINK_APPROVE_NOTIFYCAP', 'ì�´ ë§�í�¬ì •ë³´ê°€ ìŠ¹ì�¸ë�œ ê²½ìš° í†µì§€í•¨');
define('_MI_MYLINKS_LINK_APPROVE_NOTIFYDSC', 'ì�´ ë§�í�¬ì •ë³´ê°€ ìŠ¹ì�¸ë�œ ê²½ìš° í†µì§€í•©ë‹ˆë‹¤.');
define('_MI_MYLINKS_LINK_APPROVE_NOTIFYSBJ', '[{X_SITENAME}] {X_MODULE} auto-notify : ë§�í�¬ì •ë³´ê°€ ì •ì‹� ìŠ¹ì�¸/ë“±ë¡�ë�˜ì—ˆìŠµë‹ˆë‹¤.');