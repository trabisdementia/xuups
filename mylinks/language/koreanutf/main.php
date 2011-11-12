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

//%%%%%%		Module Name 'MyLinks'		%%%%%

define("_MD_MYLINKS_THANKSFORINFO", "Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´Ã«Â¥Â¼ Ã­Ë†Â¬ÃªÂ³Â Ã­â€¢Â´ Ã¬Â£Â¼Ã¬â€¦â€�Ã¬â€žÅ“ ÃªÂ°ï¿½Ã¬â€šÂ¬Ã­â€¢Â©Ã«â€¹Ë†Ã«â€¹Â¤. Ã«â€šÂ´Ã¬Å¡Â©Ã¬ï¿½â€ž Ã­â„¢â€¢Ã¬ï¿½Â¸Ã­â€¢Å“ Ã­â€ºâ€ž Ã¬Â â€¢Ã¬â€¹ï¿½Ã¬Å“Â¼Ã«Â¡Å“ Ã«â€œÂ±Ã«Â¡ï¿½Ã¬Â²ËœÃ«Â¦Â¬Ã­â€¢Â´ Ã«â€œÅ“Ã«Â¦Â¬ÃªÂ²Â Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_THANKSFORHELP", "Ã¬Â â€¢Ã«Â³Â´/Ã«ï¿½â€žÃ¬â€ºâ‚¬Ã¬ï¿½â€ž Ã¬Â£Â¼Ã¬â€¦â€�Ã¬â€žÅ“ Ã¬Â§â€žÃ¬â€¹Â¬Ã¬Å“Â¼Ã«Â¡Å“ ÃªÂ°ï¿½Ã¬â€šÂ¬Ã«â€œÅ“Ã«Â¦Â½Ã«â€¹Ë†Ã«â€¹Â¤. Ã«â€šÂ´Ã¬Å¡Â©Ã¬ï¿½â€ž Ã­â„¢â€¢Ã¬ï¿½Â¸Ã­â€¢Å“ Ã­â€ºâ€ž Ã«Â°ËœÃ¬Ëœï¿½Ã­â€¢ËœÃ«ï¿½â€žÃ«Â¡ï¿½ Ã­â€¢ËœÃªÂ²Â Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_FORSECURITY", "Ã¬â€šÂ¬Ã¬ï¿½Â´Ã­Å Â¸/Ã¬Â â€¢Ã«Â³Â´ Ã«Â³Â´Ã¬â€¢Ë†Ã¬ï¿½â€ž Ã¬Å“â€žÃ­â€¢Â´ Ã«â€¹ËœÃ¬ï¿½Ëœ IPÃ¬â„¢â‚¬ Ã¬â€¢â€žÃ¬ï¿½Â´Ã«â€�â€�Ã«Â¥Â¼ Ã¬Å¾â€žÃ¬â€¹Å“Ã¬Â ï¿½Ã¬Å“Â¼Ã«Â¡Å“ ÃªÂ¸Â°Ã«Â¡ï¿½Ã¬Â²ËœÃ«Â¦Â¬Ã­â€¢ËœÃ«Å â€� Ã¬Â ï¿½ Ã¬â€“â€˜Ã­â€¢Â´ Ã«Â°â€�Ã«Å¾ï¿½Ã«â€¹Ë†Ã«â€¹Â¤.");

define("_MD_MYLINKS_SEARCHFOR", "ÃªÂ²â‚¬Ã¬Æ’â€°");
define("_MD_MYLINKS_ANY", "Ã«Ëœï¿½Ã«Å â€�");
define("_MD_MYLINKS_SEARCH", "ÃªÂ²â‚¬Ã¬Æ’â€°");

define("_MD_MYLINKS_MAIN", "Ã«Â©â€�Ã¬ï¿½Â¸");
define("_MD_MYLINKS_SUBMITLINK", "Ã«Â§ï¿½Ã­ï¿½Â¬ Ã«â€œÂ±Ã«Â¡ï¿½");
define("_MD_MYLINKS_SUBMITLINKHEAD", "Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´Ã«Â¥Â¼ Ã«â€œÂ±Ã«Â¡ï¿½");
define("_MD_MYLINKS_POPULAR", "Ã¬ï¿½Â¸ÃªÂ¸Â°");
define("_MD_MYLINKS_TOPRATED", "ÃªÂ³Â Ã­ï¿½â€°ÃªÂ°â‚¬");

define("_MD_MYLINKS_NEWTHISWEEK", "Ã¬ï¿½Â¼Ã¬Â£Â¼Ã¬ï¿½Â¼Ã¬ï¿½Â´Ã«â€šÂ´Ã¬â€”ï¿½ Ã«â€œÂ±Ã«Â¡ï¿½Ã«ï¿½ËœÃ¬â€“Â´Ã¬Â¡Å’Ã¬ï¿½Å’");
define("_MD_MYLINKS_UPTHISWEEK", "Ã¬ï¿½Â¼Ã¬Â£Â¼Ã¬ï¿½Â¼Ã¬ï¿½Â´Ã«â€šÂ´Ã¬â€”ï¿½ Ã¬â€”â€¦ÃªÂ·Â¸Ã«Â Ë†Ã¬ï¿½Â´Ã«â€œÅ“Ã«ï¿½ËœÃ¬â€“Â´Ã¬Â¡Å’Ã¬ï¿½Å’");

define("_MD_MYLINKS_POPULARITYLTOM", "Ã¬ï¿½Â¸ÃªÂ¸Â° (Ã«Â°Â©Ã«Â¬Â¸Ã¬Ë†Ëœ Ã¬Â ï¿½Ã¬ï¿½â‚¬ÃªÂ²Æ’Ã«Â¶â‚¬Ã­â€žÂ°)");
define("_MD_MYLINKS_POPULARITYMTOL", "Ã¬ï¿½Â¸ÃªÂ¸Â° (Ã«Â°Â©Ã«Â¬Â¸Ã¬Ë†Ëœ Ã«Â§Å½Ã¬ï¿½â‚¬ÃªÂ²Æ’Ã«Â¶â‚¬Ã­â€žÂ°)");
define("_MD_MYLINKS_TITLEATOZ", "Ã­Æ’â‚¬Ã¬ï¿½Â´Ã­â€¹â‚¬ (A to Z)");
define("_MD_MYLINKS_TITLEZTOA", "Ã­Æ’â‚¬Ã¬ï¿½Â´Ã­â€¹â‚¬ (Z to A)");
define("_MD_MYLINKS_DATEOLD", "Ã¬ï¿½Â¼Ã¬â€¹Å“ (Ã¬ËœÂ¤Ã«Å¾ËœÃ«ï¿½Å“ ÃªÂ²Æ’Ã«Â¶â‚¬Ã­â€žÂ°)");
define("_MD_MYLINKS_DATENEW", "Ã¬ï¿½Â¼Ã¬â€¹Å“ (Ã¬Æ’Ë†ÃªÂ²Æ’Ã«Â¶â‚¬Ã­â€žÂ°)");
define("_MD_MYLINKS_RATINGLTOH", "Ã­ï¿½â€°ÃªÂ°â‚¬ (Ã­ï¿½â€°ÃªÂ°â‚¬ÃªÂ°â‚¬ Ã«â€šÂ®Ã¬ï¿½â‚¬ ÃªÂ²Æ’Ã«Â¶â‚¬Ã­â€žÂ°)");
define("_MD_MYLINKS_RATINGHTOL", "Ã­ï¿½â€°ÃªÂ°â‚¬ (Ã­ï¿½â€°ÃªÂ°â‚¬ÃªÂ°â‚¬ Ã«â€ â€™Ã¬ï¿½â‚¬ ÃªÂ²Æ’Ã«Â¶â‚¬Ã­â€žÂ°)");

define("_MD_MYLINKS_NOSHOTS", "Ã¬Å Â¤Ã­ï¿½Â¬Ã«Â¦Â°Ã¬Æ’Â·Ã¬ï¿½â‚¬ Ã¬â€”â€ Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_EDITTHISLINK", "Ã¬ï¿½Â´ Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´Ã«Â¥Â¼ Ã­Å½Â¸Ã¬Â§â€˜Ã­â€¢Â¨");

define("_MD_MYLINKS_DESCRIPTIONC", "Ã¬â€žÂ¤Ã«Âªâ€¦: ");
define("_MD_MYLINKS_EMAILC", "Ã«Â©â€�Ã¬ï¿½Â¼Ã¬Â£Â¼Ã¬â€ Å’: ");
define("_MD_MYLINKS_CATEGORYC", "Ã¬Â¹Â´Ã­â€¦Å’ÃªÂ³Â Ã«Â¦Â¬: ");
define("_MD_MYLINKS_LASTUPDATEC", "Ã¬ÂµÅ“Ã¬Â¢â€¦ÃªÂ°Â±Ã¬â€¹Â Ã¬ï¿½Â¼Ã¬â€¹Å“: ");
define("_MD_MYLINKS_HITSC", "Ã«Â°Â©Ã«Â¬Â¸Ã¬Ë†Ëœ: ");
define("_MD_MYLINKS_RATINGC", "Ã­ï¿½â€°ÃªÂ°â‚¬: ");
define("_MD_MYLINKS_ONEVOTE", "1 Ã­â€˜Å“");
define("_MD_MYLINKS_NUMVOTES", "%s Ã­â€˜Å“");
define("_MD_MYLINKS_RATETHISSITE", "Ã¬ï¿½Â´ Ã¬â€šÂ¬Ã¬ï¿½Â´Ã­Å Â¸Ã«Â¥Â¼ Ã­ï¿½â€°ÃªÂ°â‚¬");
define("_MD_MYLINKS_MODIFY", "Ã«Â³â‚¬ÃªÂ²Â½");
define("_MD_MYLINKS_REPORTBROKEN", "Ã«ï¿½Å Ã¬â€“Â´Ã¬Â§â€ž Ã«Â§ï¿½Ã­ï¿½Â¬ Ã¬â€¹Â ÃªÂ³Â ");
define("_MD_MYLINKS_TELLAFRIEND", "Ã¬Â¹Å“ÃªÂµÂ¬Ã¬â€”ï¿½ÃªÂ²Å’ Ã¬Â¶â€�Ã¬Â²Å“");

define("_MD_MYLINKS_THEREARE", "Ã¬ï¿½Â´ Ã¬â€šÂ¬Ã¬ï¿½Â´Ã­Å Â¸Ã¬â€”ï¿½Ã«Å â€� Ã¬Â´ï¿½<b>%s</b> ÃªÂ±Â´Ã¬ï¿½Ëœ Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´ÃªÂ°â‚¬ Ã¬Â¡Â´Ã¬Å¾Â¬Ã­â€¢Â©Ã«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_LATESTLIST", "Ã¬â€¹Â ÃªÂ·Å“ Ã«Â§ï¿½Ã­ï¿½Â¬ Ã«Â¦Â¬Ã¬Å Â¤Ã­Å Â¸");

define("_MD_MYLINKS_REQUESTMOD", "Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´Ã¬ï¿½Ëœ Ã¬Ë†ËœÃ¬Â â€¢ Ã¬Å¡â€�Ã¬Â²Â­");
define("_MD_MYLINKS_LINKID", "Ã«Â§ï¿½Ã­ï¿½Â¬ ID: ");
define("_MD_MYLINKS_SITETITLE", "Ã¬â€šÂ¬Ã¬ï¿½Â´Ã­Å Â¸ Ã­Æ’â‚¬Ã¬ï¿½Â´Ã­â€¹â‚¬: ");
define("_MD_MYLINKS_SITEURL", "Ã¬â€šÂ¬Ã¬ï¿½Â´Ã­Å Â¸ URL: ");
define("_MD_MYLINKS_OPTIONS", "Ã¬ËœÂµÃ¬â€¦Ëœ: ");
define("_MD_MYLINKS_NOTIFYAPPROVE", "Ã¬ï¿½Â´ Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´ÃªÂ°â‚¬ Ã¬Å Â¹Ã¬ï¿½Â¸Ã«ï¿½Å“ ÃªÂ²Â½Ã¬Å¡Â° Ã­â€ ÂµÃ¬Â§â‚¬Ã­â€¢Â¨");
define("_MD_MYLINKS_SHOTIMAGE", "Ã¬Å Â¤Ã­ï¿½Â¬Ã«Â¦Â°Ã¬Æ’Â· Ã¬ï¿½Â´Ã«Â¯Â¸Ã¬Â§â‚¬: ");
define("_MD_MYLINKS_SENDREQUEST", "Ã«Â³Â´Ã«â€šÂ´ÃªÂ¸Â°");

define("_MD_MYLINKS_VOTEAPPRE", "Ã­ï¿½â€°ÃªÂ°â‚¬(Vote)ÃªÂ°â‚¬ Ã¬ï¿½Â´Ã«Â£Â¨Ã¬â€“Â´Ã¬Â¡Å’Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_THANKURATE", "ÃªÂ·â‚¬Ã¬Â¤â€˜Ã­â€¢Å“ Ã«ï¿½â€žÃ¬â€ºâ‚¬/Ã¬Â â€¢Ã«Â³Â´ ÃªÂ°ï¿½Ã¬â€šÂ¬Ã«â€œÅ“Ã«Â¦Â½Ã«â€¹Ë†Ã«â€¹Â¤.(%s)");
define("_MD_MYLINKS_VOTEFROMYOU", "Ã«â€¹ËœÃ¬ï¿½Ëœ Ã­ï¿½â€°ÃªÂ°â‚¬Ã«Å â€� Ã­Æ’â‚¬ Ã­Å¡Å’Ã¬â€ºï¿½Ã«â€œÂ¤Ã¬ï¿½Â´ Ã«Â§ï¿½Ã­ï¿½Â¬ Ã¬â€šÂ¬Ã¬ï¿½Â´Ã­Å Â¸ Ã«Â°Â©Ã«Â¬Â¸Ã¬â€”Â¬Ã«Â¶â‚¬Ã«Â¥Â¼ ÃªÂ²Â°Ã¬Â â€¢Ã­â€¢Â  Ã«â€¢Å’Ã¬ï¿½Ëœ Ã­Å’ï¿½Ã«â€¹Â¨ÃªÂ¸Â°Ã¬Â¤â‚¬Ã¬ï¿½Â´ Ã«ï¿½Â  ÃªÂ²Æ’Ã¬Å¾â€¦Ã«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_VOTEONCE", "Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´Ã¬â€”ï¿½ Ã«Å’â‚¬Ã­â€¢Å“ Ã­ï¿½â€°ÃªÂ°â‚¬Ã«Å â€� 1Ã¬ï¿½Â¸ 1Ã­Å¡Å’Ã«Â¡Å“ Ã¬Â Å“Ã­â€¢Å“Ã«ï¿½ËœÃ¬â€“Â´ Ã¬Å¾Ë†Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_RATINGSCALE", "Ã­ï¿½â€°ÃªÂ°â‚¬Ã«Å â€� 1-10Ã¬ï¿½Ëœ Ã«Â²â€�Ã¬Å“â€žÃ¬â€”ï¿½Ã¬â€žÅ“ Ã¬â€žÂ Ã­Æ’ï¿½Ã­â€¢ËœÃ¬â€¹Å“ÃªÂ¸Â° Ã«Â°â€�Ã«Å¾ï¿½Ã«â€¹Ë†Ã«â€¹Â¤. Ã«â€ â€™Ã¬ï¿½â‚¬ Ã¬Ë†Â«Ã¬Å¾ï¿½Ã¬ï¿½Â¼Ã¬Ë†ËœÃ«Â¡ï¿½ Ã«â€ â€™Ã¬ï¿½â‚¬ Ã­ï¿½â€°ÃªÂ°â‚¬Ã«Â¥Â¼ Ã¬ï¿½ËœÃ«Â¯Â¸Ã­â€¢Â©Ã«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_BEOBJECTIVE", "ÃªÂ³ÂµÃ¬Â â€¢Ã­â€¢Å“ Ã­ï¿½â€°ÃªÂ°â‚¬Ã«Â¥Â¼ Ã«Â¶â‚¬Ã­Æ’ï¿½Ã«â€œÅ“Ã«Â¦Â½Ã«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_DONOTVOTE", "Ã¬Å¾ï¿½ÃªÂ¸Â°Ã¬Å¾ï¿½Ã¬â€¹Â Ã¬ï¿½Ëœ Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´Ã¬â€”ï¿½ Ã«Å’â‚¬Ã­â€¢Â´Ã¬â€žÂ  Ã­ï¿½â€°ÃªÂ°â‚¬Ã­â€¢ËœÃ¬â€¹Â¤ Ã¬Ë†Ëœ Ã¬â€”â€ Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_RATEIT", "Ã­ï¿½â€°ÃªÂ°â‚¬");

define("_MD_MYLINKS_INTRESTLINK", "Ã¬Å“Â Ã¬Å¡Â©Ã­â€¢Å“ Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬â€šÂ¬Ã¬ï¿½Â´Ã­Å Â¸Ã¬Â â€¢Ã«Â³Â´ÃªÂ°â‚¬ Ã«Â°Å“ÃªÂ²Â¬(%s)"); // %s is your site name
define("_MD_MYLINKS_INTLINKFOUND", "%s Ã¬â€”ï¿½Ã¬â€žÅ“ Ã«Â§Â¤Ã¬Å¡Â° Ã¬Å“Â Ã¬Å¡Â©Ã­â€¢Å“ Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬â€šÂ¬Ã¬ï¿½Â´Ã­Å Â¸Ã¬Â â€¢Ã«Â³Â´Ã«Â¥Â¼ Ã«Â°Å“ÃªÂ²Â¬Ã­â€¢ËœÃ¬Ëœâ‚¬Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤."); // %s is your site name

define("_MD_MYLINKS_RECEIVED", "Ã«Â§ï¿½Ã­ï¿½Â¬ Ã¬Â â€¢Ã«Â³Â´Ã«Â¥Â¼ Ã¬Â â€˜Ã¬Ë†ËœÃ­â€¢ËœÃ¬Ëœâ‚¬Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤. ÃªÂ°ï¿½Ã¬â€šÂ¬Ã­â€¢Â©Ã«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_WHENAPPROVED", "Ã¬ï¿½Â´ Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´ÃªÂ°â‚¬ Ã¬Â â€¢Ã¬â€¹ï¿½Ã¬Å“Â¼Ã«Â¡Å“ Ã¬Å Â¹Ã¬ï¿½Â¸/Ã«â€œÂ±Ã«Â¡ï¿½Ã«ï¿½Â  ÃªÂ²Â½Ã¬Å¡Â° Ã«Â©â€�Ã¬ï¿½Â¼Ã«Â¡Å“ Ã­â€ ÂµÃ¬Â§â‚¬Ã­â€¢Â´ Ã«â€œÅ“Ã«Â¦Â½Ã«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_SUBMITONCE", "Ã«ï¿½â„¢Ã¬ï¿½Â¼Ã­â€¢Å“ Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´Ã«Â¥Â¼ Ã¬Â¤â€˜Ã«Â³ÂµÃ­Ë†Â¬ÃªÂ³Â  Ã­â€¢ËœÃ¬â€¹Â¤ Ã¬Ë†Ëœ Ã¬â€”â€ Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤..");
define("_MD_MYLINKS_ALLPENDING", "Ã«ÂªÂ¨Ã«â€œÂ  Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´Ã«Å â€� Ã«â€šÂ´Ã¬Å¡Â©Ã­â„¢â€¢Ã¬ï¿½Â¸Ã­â€ºâ€ž Ã¬Â â€¢Ã¬â€¹ï¿½ Ã¬Å Â¹Ã¬ï¿½Â¸/Ã«â€œÂ±Ã«Â¡ï¿½Ã¬â€”Â¬Ã«Â¶â‚¬Ã«Â¥Â¼ ÃªÂ²Â°Ã¬Â â€¢Ã­â€¢ËœÃªÂ²Å’ Ã«ï¿½Â©Ã«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_DONTABUSE", "Ã¬â€¢â€žÃ¬ï¿½Â´Ã«â€�â€�Ã¬â„¢â‚¬ IPÃ¬Â â€¢Ã«Â³Â´Ã«Â¥Â¼ ÃªÂ¸Â°Ã«Â¡ï¿½Ã­â€¢ËœÃ¬Ëœâ‚¬Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤. Ã¬ËœÂ¬Ã«Â°â€�Ã«Â¥Â¸ Ã¬ï¿½Â´Ã¬Å¡Â©Ã¬ï¿½â€ž Ã«Â¶â‚¬Ã­Æ’ï¿½Ã«â€œÅ“Ã«Â¦Â½Ã«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_TAKESHOT", "Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´ÃªÂ°â‚¬ Ã¬Â â€¢Ã¬â€¹ï¿½Ã¬Å“Â¼Ã«Â¡Å“ Ã¬Å Â¹Ã¬ï¿½Â¸/Ã«â€œÂ±Ã«Â¡ï¿½Ã«ï¿½Â  Ã«â€¢Å’ÃªÂ¹Å’Ã¬Â§â€ž Ã¬â€¢Â½ÃªÂ°â€žÃ¬ï¿½Ëœ Ã¬â€¹Å“Ã¬ï¿½Â¼Ã¬ï¿½Â´ ÃªÂ±Â¸Ã«Â¦Â´Ã¬Ë†ËœÃ«ï¿½â€ž Ã¬Å¾Ë†Ã«Å â€� Ã¬Â ï¿½ Ã¬â€“â€˜Ã­â€¢Â´Ã«Â°â€�Ã«Å¾ï¿½Ã«â€¹Ë†Ã«â€¹Â¤.");

define("_MD_MYLINKS_RANK", "Ã¬Ë†Å“Ã¬Å“â€ž");
define("_MD_MYLINKS_CATEGORY", "Ã¬Â¹Â´Ã­â€¦Å’ÃªÂ³Â Ã«Â¦Â¬");
define("_MD_MYLINKS_HITS", "Ã«Â°Â©Ã«Â¬Â¸Ã¬Ë†Ëœ");
define("_MD_MYLINKS_RATING", "Ã­ï¿½â€°ÃªÂ°â‚¬");
define("_MD_MYLINKS_VOTE", "Ã­Ë†Â¬Ã­â€˜Å“Ã¬Ë†Ëœ");
define("_MD_MYLINKS_TOP10", "%s Top 10"); // %s is a link category title

define("_MD_MYLINKS_SEARCHRESULTS", "ÃªÂ²â‚¬Ã¬Æ’â€°ÃªÂ²Â°ÃªÂ³Â¼: <b>%s</b>:"); // %s is search keywords
define("_MD_MYLINKS_SORTBY", "Ã¬Â â€¢Ã«Â Â¬Ã¬Ë†Å“:");
define("_MD_MYLINKS_TITLE", "Ã­Æ’â‚¬Ã¬ï¿½Â´Ã­â€¹â‚¬");
define("_MD_MYLINKS_DATE", "Ã¬ï¿½Â¼Ã¬â€¹Å“");
define("_MD_MYLINKS_POPULARITY", "Ã¬ï¿½Â¸ÃªÂ¸Â°");
define("_MD_MYLINKS_CURSORTEDBY", "Ã­Ëœâ€žÃ¬Å¾Â¬ Ã¬Â â€¢Ã«Â Â¬Ã¬Ë†Å“: %s");
define("_MD_MYLINKS_PREVIOUS", "Ã¬ï¿½Â´Ã¬Â â€ž Ã­Å½ËœÃ¬ï¿½Â´Ã¬Â§â‚¬");
define("_MD_MYLINKS_NEXT", "Ã«â€¹Â¤Ã¬ï¿½Å’ Ã­Å½ËœÃ¬ï¿½Â´Ã¬Â§â‚¬");
define("_MD_MYLINKS_NOMATCH", "Ã­â€¢Â´Ã«â€¹Â¹Ã­â€¢ËœÃ«Å â€� Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´ÃªÂ°â‚¬ Ã¬Â¡Â´Ã¬Å¾Â¬Ã­â€¢ËœÃ¬Â§â‚¬ Ã¬â€¢Å Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");

define("_MD_MYLINKS_SUBMIT", "Ã«Â³Â´Ã«â€šÂ´ÃªÂ¸Â°");
define("_MD_MYLINKS_CANCEL", "Ã¬Â·Â¨Ã¬â€ Å’");

define("_MD_MYLINKS_ALREADYREPORTED", "Ã«â€¹ËœÃ¬Å“Â¼Ã«Â¡Å“Ã«Â¶â‚¬Ã­â€žÂ°Ã¬ï¿½Ëœ Ã«ï¿½Å Ã¬â€“Â´Ã¬Â§â€ž Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬â€¹Â ÃªÂ³Â Ã«Å â€� Ã¬ï¿½Â´Ã«Â¯Â¸ Ã¬Â â€˜Ã¬Ë†ËœÃ«ï¿½ËœÃ¬â€“Â´Ã¬Â§â€ž Ã¬Æ’ï¿½Ã­Æ’Å“Ã¬Å¾â€¦Ã«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_MUSTREGFIRST", "Ã«Â§ï¿½Ã­ï¿½Â¬ Ã¬Â â€¢Ã«Â³Â´Ã«Â¥Â¼ Ã­Ë†Â¬ÃªÂ³Â Ã­â€¢ËœÃ¬â€¹Å“Ã«Â Â¤Ã«Â©Â´ Ã«Â¨Â¼Ã¬Â â‚¬ Ã­Å¡Å’Ã¬â€ºï¿½Ã«â€œÂ±Ã«Â¡ï¿½Ã¬ï¿½â€ž Ã­â€¢ËœÃ¬â€¦â€�Ã¬â€¢Â¼Ã«Â§Å’ Ã­â€¢Â©Ã«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_NORATING", "Ã­ï¿½â€°ÃªÂ°â‚¬Ã¬Â â€¢Ã«Â³Â´ÃªÂ°â‚¬ Ã¬â€žÂ Ã­Æ’ï¿½Ã«ï¿½ËœÃ¬â€“Â´Ã¬Å¾Ë†Ã¬Â§â‚¬ Ã¬â€¢Å Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_CANTVOTEOWN", "Ã¬Å¾ï¿½ÃªÂ¸Â°Ã¬Å¾ï¿½Ã¬â€¹Â Ã¬ï¿½Ëœ Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´Ã¬â€”ï¿½ Ã«Å’â‚¬Ã­â€¢Â´Ã¬â€žÂ  Ã­ï¿½â€°ÃªÂ°â‚¬Ã­â€¢ËœÃ¬â€¹Â¤ Ã¬Ë†Ëœ Ã¬â€”â€ Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_VOTEONCE2", "Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´Ã¬â€”ï¿½ Ã«Å’â‚¬Ã­â€¢Å“ Ã­ï¿½â€°ÃªÂ°â‚¬Ã«Å â€� 1Ã¬ï¿½Â¸ 1Ã­Å¡Å’Ã«Â¡Å“ Ã­â€¢Å“Ã¬Â â€¢Ã«ï¿½Â©Ã«â€¹Ë†Ã«â€¹Â¤.");

//%%%%%%	Module Name 'MyLinks' (Admin)	 %%%%%

define("_MD_MYLINKS_WEBLINKSCONF", "Ã«Â§ï¿½Ã­ï¿½Â¬ Ã¬Â â€¢Ã«Â³Â´ ÃªÂ´â‚¬Ã«Â¦Â¬");
define("_MD_MYLINKS_GENERALSET", "Ã¬ï¿½Â¼Ã«Â°ËœÃ¬â€žÂ¤Ã¬Â â€¢");
define("_MD_MYLINKS_ADDMODDELETE", "Ã¬Â¹Â´Ã­â€¦Å’ÃªÂ³Â Ã«Â¦Â¬/Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´Ã¬ï¿½Ëœ Ã¬Â¶â€�ÃªÂ°â‚¬/Ã¬Ë†ËœÃ¬Â â€¢/Ã¬â€šÂ­Ã¬Â Å“");
define("_MD_MYLINKS_LINKSWAITING", "Ã¬Å Â¹Ã¬ï¿½Â¸Ã«Å’â‚¬ÃªÂ¸Â° Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´");
define("_MD_MYLINKS_BROKENREPORTS", "Ã«ï¿½Å Ã¬â€“Â´Ã¬Â§â€ž Ã«Â§ï¿½Ã­ï¿½Â¬ Ã¬â€¹Â ÃªÂ³Â ");
define("_MD_MYLINKS_MODREQUESTS", "Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´ Ã¬Ë†ËœÃ¬Â â€¢ Ã¬Å¡â€�Ã¬Â²Â­");
define("_MD_MYLINKS_SUBMITTER", "Ã­Ë†Â¬ÃªÂ³Â Ã¬Å¾ï¿½: ");
define("_MD_MYLINKS_VISIT", "Ã«Â°Â©Ã«Â¬Â¸");
define("_MD_MYLINKS_SHOTMUST", "Ã¬Å Â¤Ã­ï¿½Â¬Ã«Â¦Â°Ã¬Æ’Â· ÃªÂ·Â¸Ã«Â¦Â¼Ã­Å’Å’Ã¬ï¿½Â¼Ã¬ï¿½â‚¬ %s Ã«â€�â€�Ã«Â â€°Ã­â€ Â Ã«Â¦Â¬Ã­â€¢ËœÃ¬ï¿½Ëœ Ã­Å’Å’Ã¬ï¿½Â¼Ã¬ï¿½â€ž Ã¬â€šÂ¬Ã¬Å¡Â©Ã­â€¢Â´ Ã¬Â£Â¼Ã¬â€žÂ¸Ã¬Å¡â€�(ex. shot.gif). ÃªÂ·Â¸Ã«Â¦Â¼Ã­Å’Å’Ã¬ï¿½Â¼Ã¬ï¿½Â´ Ã¬Â¡Â´Ã¬Å¾Â¬Ã­â€¢ËœÃ¬Â§â‚¬ Ã¬â€¢Å Ã¬ï¿½â€ž Ã¬â€¹Å“Ã¬â€”ï¿½Ã«Å â€� ÃªÂ·Â¸Ã«Æ’Â¥ ÃªÂ³ÂµÃ«Â°Â±Ã¬Å“Â¼Ã«Â¡Å“ Ã«â€˜ï¿½Ã¬â€žÂ¸Ã¬Å¡â€�.");
define("_MD_MYLINKS_APPROVE", "Ã¬Å Â¹Ã¬ï¿½Â¸");
define("_MD_MYLINKS_DELETE", "Ã¬â€šÂ­Ã¬Â Å“");
define("_MD_MYLINKS_NOSUBMITTED", "Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´Ã¬ï¿½Ëœ Ã¬â€¹Â ÃªÂ·Å“Ã­Ë†Â¬ÃªÂ³Â ÃªÂ°â‚¬ Ã¬â€”â€ Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_ADDMAIN", "Ã«Â©â€�Ã¬ï¿½Â¸ Ã¬Â¹Â´Ã­â€¦Å’ÃªÂ³Â Ã«Â¦Â¬ Ã¬Å¾â€˜Ã¬â€žÂ±");
define("_MD_MYLINKS_TITLEC", "Ã­Æ’â‚¬Ã¬ï¿½Â´Ã­â€¹â‚¬: ");
define("_MD_MYLINKS_IMGURL", "Ã¬Â¹Â´Ã­â€¦Å’ÃªÂ³Â Ã«Â¦Â¬ ÃªÂ·Â¸Ã«Â¦Â¼Ã­Å’Å’Ã¬ï¿½Â¼ URL (Ã¬â€žÂ Ã­Æ’ï¿½Ã­â€¢Â­Ã«ÂªÂ©Ã¬Å¾â€¦Ã«â€¹Ë†Ã«â€¹Â¤. ÃªÂ·Â¸Ã«Â¦Â¼Ã«â€ â€™Ã¬ï¿½Â´Ã«Å â€� 50Ã­â€�Â½Ã¬â€¦â‚¬Ã«Â¡Å“ ÃªÂ³Â Ã¬Â â€¢Ã«ï¿½Â©Ã«â€¹Ë†Ã«â€¹Â¤.): ");
define("_MD_MYLINKS_ADD", "Ã¬Â¶â€�ÃªÂ°â‚¬");
define("_MD_MYLINKS_ADDSUB", "Ã¬â€žÅ“Ã«Â¸Å’ Ã¬Â¹Â´Ã­â€¦Å’ÃªÂ³Â Ã«Â¦Â¬ Ã¬Å¾â€˜Ã¬â€žÂ±");
define("_MD_MYLINKS_IN", "Ã«Â¶â‚¬Ã«ÂªÂ¨ Ã¬Â¹Â´Ã­â€¦Å’ÃªÂ³Â Ã«Â¦Â¬");
define("_MD_MYLINKS_ADDNEWLINK", "Ã¬â€¹Â ÃªÂ·Å“ Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´");
define("_MD_MYLINKS_MODCAT", "Ã¬Â¹Â´Ã­â€¦Å’ÃªÂ³Â Ã«Â¦Â¬ Ã­Å½Â¸Ã¬Â§â€˜");
define("_MD_MYLINKS_MODLINK", "Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´ Ã­Å½Â¸Ã¬Â§â€˜");
define("_MD_MYLINKS_TOTALVOTES", "Ã¬Â´ï¿½ Ã­ï¿½â€°ÃªÂ°â‚¬Ã¬Ë†Ëœ (Ã¬Â´ï¿½ Ã­ï¿½â€°ÃªÂ°â‚¬Ã¬Ë†Ëœ : %s)");
define("_MD_MYLINKS_USERTOTALVOTES", "Ã«â€œÂ±Ã«Â¡ï¿½Ã­Å¡Å’Ã¬â€ºï¿½Ã¬â€”ï¿½ Ã¬ï¿½ËœÃ­â€¢Å“ Ã­ï¿½â€°ÃªÂ°â‚¬ (Ã¬Â´ï¿½ Ã­ï¿½â€°ÃªÂ°â‚¬Ã¬Ë†Ëœ: %s)");
define("_MD_MYLINKS_ANONTOTALVOTES", "Ã¬â€ ï¿½Ã«â€¹ËœÃ¬â€”ï¿½ Ã¬ï¿½ËœÃ­â€¢Å“ Ã­ï¿½â€°ÃªÂ°â‚¬ (Ã¬Â´ï¿½ Ã­ï¿½â€°ÃªÂ°â‚¬Ã¬Ë†Ëœ: %s)");
define("_MD_MYLINKS_USER", "Ã¬â€¢â€žÃ¬ï¿½Â´Ã«â€�â€�");
define("_MD_MYLINKS_IP", "IPÃ¬Â£Â¼Ã¬â€ Å’");
define("_MD_MYLINKS_USERAVG", "Ã­ï¿½â€°ÃªÂ·Â  Ã­ï¿½â€°ÃªÂ°â‚¬Ã¬Â ï¿½");
define("_MD_MYLINKS_TOTALRATE", "Ã¬Â´ï¿½ Ã­ï¿½â€°ÃªÂ°â‚¬Ã¬Â ï¿½");
define("_MD_MYLINKS_NOREGVOTES", "Ã«â€œÂ±Ã«Â¡ï¿½Ã­Å¡Å’Ã¬â€ºï¿½Ã¬ï¿½Ëœ Ã­ï¿½â€°ÃªÂ°â‚¬ÃªÂ°â‚¬ Ã¬â€”â€ Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_NOUNREGVOTES", "Ã¬â€ ï¿½Ã«â€¹ËœÃ¬â€”ï¿½ Ã¬ï¿½ËœÃ­â€¢Å“ Ã­ï¿½â€°ÃªÂ°â‚¬ÃªÂ°â‚¬ Ã¬â€”â€ Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_VOTEDELETED", "Ã­ï¿½â€°ÃªÂ°â‚¬ Ã¬Â â€¢Ã«Â³Â´Ã«Â¥Â¼ Ã¬â€šÂ­Ã¬Â Å“Ã­â€¢ËœÃ¬Ëœâ‚¬Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_NOBROKEN", "Ã«ï¿½Å Ã¬â€“Â´Ã¬Â§â€ž Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬â€”ï¿½ Ã«Å’â‚¬Ã­â€¢Å“ Ã¬â€¹Â ÃªÂ³Â ÃªÂ°â‚¬ Ã¬â€”â€ Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_IGNOREDESC", "Ã«Â¬Â´Ã¬â€¹Å“ (Ã«ï¿½Å Ã¬â€“Â´Ã¬Â§â€ž Ã«Â§ï¿½Ã­ï¿½Â¬ Ã¬â€¹Â ÃªÂ³Â Ã«Â¥Â¼ Ã«Â¬Â´Ã¬â€¹Å“Ã­â€¢ËœÃªÂ³Â  Ã¬ï¿½Â´ <b>Ã¬â€¹Â ÃªÂ³Â Ã«Â³Â´ÃªÂ³Â </b>Ã«Â§Å’Ã¬ï¿½â€ž Ã¬â€šÂ­Ã¬Â Å“Ã­â€¢Â©Ã«â€¹Ë†Ã«â€¹Â¤.)");
define("_MD_MYLINKS_DELETEDESC", "Ã¬â€šÂ­Ã¬Â Å“ (Ã«ï¿½Å Ã¬â€“Â´Ã¬Â§â€ž Ã«Â§ï¿½Ã­ï¿½Â¬ Ã¬â€¹Â ÃªÂ³Â Ã¬â„¢â‚¬ ÃªÂ´â‚¬Ã«Â Â¨ Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´Ã«Â¥Â¼ Ã­â€¢Â¨ÃªÂ»Ëœ Ã¬â€šÂ­Ã¬Â Å“Ã­â€¢Â©Ã«â€¹Ë†Ã«â€¹Â¤.)");
define("_MD_MYLINKS_REPORTER", "Ã«Â³Â´Ã«â€šÂ¸ Ã¬â€šÂ¬Ã«Å¾Å’:");
define("_MD_MYLINKS_LINKSUBMITTER", "Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´ Ã¬Â Å“ÃªÂ³ÂµÃ¬Å¾ï¿½:");
define("_MD_MYLINKS_IGNORE", "Ã«Â¬Â´Ã¬â€¹Å“");
define("_MD_MYLINKS_LINKDELETED", "Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´Ã«Â¥Â¼ Ã¬â€šÂ­Ã¬Â Å“Ã­â€¢ËœÃ¬Ëœâ‚¬Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_BROKENDELETED", "Ã«ï¿½Å Ã¬â€“Â´Ã¬Â§â€ž Ã«Â§ï¿½Ã­ï¿½Â¬ Ã¬â€¹Â ÃªÂ³Â Ã«Â¥Â¼ Ã¬â€šÂ­Ã¬Â Å“Ã­â€¢ËœÃ¬Ëœâ‚¬Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_USERMODREQ", "Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´ Ã¬Ë†ËœÃ¬Â â€¢ Ã¬Å¡â€�Ã¬Â²Â­");
define("_MD_MYLINKS_ORIGINAL", "Ã¬Ë†ËœÃ¬Â â€¢Ã¬Â â€ž");
define("_MD_MYLINKS_PROPOSED", "Ã¬Ë†ËœÃ¬Â â€¢Ã­â€ºâ€ž");
define("_MD_MYLINKS_OWNER", "Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´ Ã¬Â Å“ÃªÂ³ÂµÃ¬Å¾ï¿½: ");
define("_MD_MYLINKS_NOMODREQ", "Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´ Ã¬Ë†ËœÃ¬Â â€¢Ã¬Å¡â€�Ã¬Â²Â­Ã¬ï¿½Â´ Ã¬â€”â€ Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_DBUPDATED", "Ã«ï¿½Â°Ã¬ï¿½Â´Ã­Æ’â‚¬Ã«Â²Â Ã¬ï¿½Â´Ã¬Å Â¤Ã«Â¥Â¼ Ã¬â€žÂ±ÃªÂ³ÂµÃ¬Â ï¿½Ã¬Å“Â¼Ã«Â¡Å“ ÃªÂ°Â±Ã¬â€¹Â Ã­â€¢ËœÃ¬Ëœâ‚¬Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤!");
define("_MD_MYLINKS_MODREQDELETED", "Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´ Ã¬Ë†ËœÃ¬Â â€¢Ã¬Å¡â€�Ã¬Â²Â­Ã¬ï¿½â€ž Ã¬â€šÂ­Ã¬Â Å“Ã­â€¢ËœÃ¬Ëœâ‚¬Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_IMGURLMAIN", "Ã¬Â¹Â´Ã­â€¦Å’ÃªÂ³Â Ã«Â¦Â¬ ÃªÂ·Â¸Ã«Â¦Â¼Ã­Å’Å’Ã¬ï¿½Â¼ URL (Ã¬â€žÂ Ã­Æ’ï¿½Ã­â€¢Â­Ã«ÂªÂ©Ã¬Å¾â€¦Ã«â€¹Ë†Ã«â€¹Â¤. ÃªÂ·Â¸Ã«Â¦Â¼Ã¬ï¿½Ëœ Ã«â€ â€™Ã¬ï¿½Â´Ã«Å â€� 50Ã­â€�Â½Ã¬â€¦â‚¬Ã«Â¡Å“ ÃªÂ³Â Ã¬Â â€¢Ã«ï¿½Â¨,Ã«Â©â€�Ã¬ï¿½Â¸ Ã¬Â¹Â´Ã­â€¦Å’ÃªÂ³Â Ã«Â¦Â¬Ã¬Å¡Â©): ");
define("_MD_MYLINKS_PARENT", "Ã«Â¶â‚¬Ã«ÂªÂ¨Ã¬Â¹Â´Ã­â€¦Å’ÃªÂ³Â Ã«Â¦Â¬:");
define("_MD_MYLINKS_SAVE", "Ã«Â³â‚¬ÃªÂ²Â½Ã¬Â â‚¬Ã¬Å¾Â¥");
define("_MD_MYLINKS_CATDELETED", "Ã¬Â¹Â´Ã­â€¦Å’ÃªÂ³Â Ã«Â¦Â¬Ã«Â¥Â¼ Ã¬â€šÂ­Ã¬Â Å“Ã­â€¢ËœÃ¬Ëœâ‚¬Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_WARNING", "WARNING: Ã¬Â â€¢Ã«Â§ï¿½Ã«Â¡Å“ Ã¬ï¿½Â´ Ã¬Â¹Â´Ã­â€¦Å’ÃªÂ³Â Ã«Â¦Â¬Ã¬â„¢â‚¬ ÃªÂ·Â¸Ã¬â€”ï¿½ Ã¬â€ ï¿½Ã­â€¢Å“ Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´ Ã«ï¿½Â°Ã¬ï¿½Â´Ã­Æ’â‚¬Ã«Â¥Â¼ Ã«ÂªÂ¨Ã«â€˜ï¿½ Ã¬â€šÂ­Ã¬Â Å“Ã­â€¢ËœÃ¬â€¹Â¤ ÃªÂ±Â´ÃªÂ°â‚¬Ã¬Å¡â€�?");
define("_MD_MYLINKS_YES", "Ã¬ËœË†");
define("_MD_MYLINKS_NO", "Ã¬â€¢â€žÃ«â€¹Ë†Ã¬Å¡â€�");
define("_MD_MYLINKS_NEWCATADDED", "Ã¬Â¹Â´Ã­â€¦Å’ÃªÂ³Â Ã«Â¦Â¬Ã«Â¥Â¼ Ã¬Â¶â€�ÃªÂ°â‚¬Ã­â€¢ËœÃ¬Ëœâ‚¬Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_ERROREXIST", "ERROR: Ã­Ë†Â¬ÃªÂ³Â Ã­â€¢ËœÃ¬â€¹Â  Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´Ã«Å â€� Ã¬ï¿½Â´Ã«Â¯Â¸ Ã«â€œÂ±Ã«Â¡ï¿½Ã«ï¿½ËœÃ¬â€“Â´Ã¬Â Â¸ Ã¬Å¾Ë†Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_ERRORTITLE", "ERROR: Ã­Æ’â‚¬Ã¬ï¿½Â´Ã­â€¹â‚¬Ã¬ï¿½â€ž Ã¬Å¾â€¦Ã«Â Â¥Ã­â€¢Â´ Ã¬Â£Â¼Ã¬â€žÂ¸Ã¬Å¡â€�!");
define("_MD_MYLINKS_ERRORDESC", "ERROR: Ã¬â€žÂ¤Ã«Âªâ€¦Ã¬ï¿½â€ž Ã¬Å¾â€¦Ã«Â Â¥Ã­â€¢Â´ Ã¬Â£Â¼Ã¬â€žÂ¸Ã¬Å¡â€�!");
define("_MD_MYLINKS_NEWLINKADDED", "Ã¬â€¹Â ÃªÂ·Å“ Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´Ã«Â¥Â¼ Ã¬Â¶â€�ÃªÂ°â‚¬Ã­â€¢ËœÃ¬Ëœâ‚¬Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_YOURLINK", "Your Website Link at %s");
define("_MD_MYLINKS_YOUCANBROWSE", "Ã«â€¹Â¤Ã¬â€“â€˜Ã­â€¢Å“ Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬â€šÂ¬Ã¬ï¿½Â´Ã­Å Â¸Ã¬Â â€¢Ã«Â³Â´ÃªÂ°â‚¬ Ã¬Å¾Ë†Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤. Ã«Â§Å½Ã¬ï¿½â‚¬ Ã¬ï¿½Â´Ã¬Å¡Â©Ã«Â°â€�Ã«Å¾ï¿½Ã«â€¹Ë†Ã«â€¹Â¤. (%s)");
define("_MD_MYLINKS_HELLO", "%s Ã«â€¹Ëœ,Ã¬â€“Â´Ã¬â€žÅ“Ã¬ËœÂ¤Ã¬â€žÂ¸Ã¬Å¡â€�");
define("_MD_MYLINKS_WEAPPROVED", "Ã«â€¹ËœÃ¬ï¿½Â´ Ã­Ë†Â¬ÃªÂ³Â Ã­â€¢ËœÃ¬â€¹Â  Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´Ã«Å â€� Ã¬Â â€¢Ã¬â€¹ï¿½Ã¬Å“Â¼Ã«Â¡Å“ Ã¬Å Â¹Ã¬ï¿½Â¸/Ã«â€œÂ±Ã«Â¡ï¿½Ã¬Â²ËœÃ«Â¦Â¬ Ã«ï¿½ËœÃ¬â€”Ë†Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");
define("_MD_MYLINKS_THANKSSUBMIT", "Ã­Ë†Â¬ÃªÂ³Â Ã­â€¢Â´ Ã¬Â£Â¼Ã¬â€¦â€�Ã¬â€žÅ“ ÃªÂ°ï¿½Ã¬â€šÂ¬Ã­â€¢Â©Ã«â€¹Ë†Ã«â€¹Â¤!");
define("_MD_MYLINKS_ISAPPROVED", "Ã«â€¹ËœÃ¬ï¿½Â´ Ã­Ë†Â¬ÃªÂ³Â Ã­â€¢ËœÃ¬â€¹Â  Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬Â â€¢Ã«Â³Â´Ã«Å â€� Ã¬Â â€¢Ã¬â€¹ï¿½Ã¬Å“Â¼Ã«Â¡Å“ Ã¬Å Â¹Ã¬ï¿½Â¸/Ã«â€œÂ±Ã«Â¡ï¿½Ã¬Â²ËœÃ«Â¦Â¬ Ã«ï¿½ËœÃ¬â€”Ë†Ã¬Å ÂµÃ«â€¹Ë†Ã«â€¹Â¤.");

//ver2.0
define("_MD_MYLINKS_BROWSETOTOPIC", "Ã¬â€¢Å’Ã­Å’Å’Ã«Â²Â³Ã¬Ë†Å“ Ã¬Æ’â€°Ã¬ï¿½Â¸");
define("_MD_MYLINKS_LINKS_LIST", "Ã«Â§ï¿½Ã­ï¿½Â¬Ã¬â€šÂ¬Ã¬ï¿½Â´Ã­Å Â¸ Ã«Â¦Â¬Ã¬Å Â¤Ã­Å Â¸ (%s)");

//ver3.0
define("_MD_MYLINKS_FEED", "Module Feed ");
define("_MD_MYLINKS_FEED_CAT", "Category Feed ");
define("_MD_MYLINKS_RSSFEED", "RSS-Module Feed");
define("_MD_MYLINKS_ATOMFEED", "ATOM-Module Feed");
define("_MD_MYLINKS_PDAFEED", "PDA-Module Feed");
define("_MD_MYLINKS_RSSFEED_CAT", "RSS-Category Feed");
define("_MD_MYLINKS_ATOMFEED_CAT", "ATOM-Category Feed");
define("_MD_MYLINKS_PDAFEED_CAT", "PDA-Category Feed");
define("_MD_MYLINKS_MINIMIZEBLOCK", "Click me if you want to minimize this block");
define("_MD_MYLINKS_RESTOREBLOCK", "Click me if you want to restore this block");
define("_MD_MYLINKS_GOTOTOP", "Go to Top");
define("_MD_MYLINKS_GOTOBOTTOM", "Go to Bottom");
define("_MD_MYLINKS_FULLVIEW", "detail");
define("_MD_MYLINKS_PRINT", "print it");
define("_MD_MYLINKS_PDF", "make it pdf");
define("_MD_MYLINKS_QRCODE", "make it qrcode");
define("_MD_MYLINKS_BOOKMARK", "bookmark it");
define("_MD_MYLINKS_FEEDSUBSCRIPT", "feed subscription");
define("_MD_MYLINKS_FEEDSUBSCRIPT_DESC", "Click here to subscribe this feed!");
define("_MD_MYLINKS_THEMECHANGER", "Theme Changer: ");
define("_MD_MYLINKS_INTERNALSEARCH", "Internal Search");
define("_MD_MYLINKS_EXTERNALSEARCH", "* More Search with External Search Engines *");
define("_MD_MYLINKS_EXTERNALSEARCH_KEYWORD", "<br />Keyword => %s (<font color='red'><b>%s</b></font>)");
define("_MD_MYLINKS_BOOKMARK_SERVICE", "Social Bookmark Service");
define("_MD_MYLINKS_FEEDSUBSCRIPT_SERVICE", "Feed Subscription Service");
define("_MD_MYLINKS_BOOKMARK_ADDTO", "Add this website To...");

//ver3.1
define("_MD_MYLINKS_IDERROR", "An invalid category or link was entered, please try again.");
define("_MD_MYLINKS_NORECORDFOUND", "No records found. Please check category and/or link information!");
define("_MD_MYLINKS_DISALLOW", 0);
define("_MD_MYLINKS_ALLOW", 1);
define("_MD_MYLINKS_MEMBERONLY", 2);
define("_MD_MYLINKS_COPYNOTICE", "Copyright (c) %s by %s");
define("_MD_MYLINKS_PRINTINGDISALLOWED", "You are not allowed to print.");