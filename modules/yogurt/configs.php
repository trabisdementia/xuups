<?php
// $Id: configs.php,v 1.9 2008/04/19 16:39:08 marcellobrandao Exp $
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
include_once '../../mainfile.php';
$xoopsOption['template_main'] = 'yogurt_configs.html';
include_once '../../header.php';
include_once 'class/yogurt_controler.php';

$controler = new YogurtControlerConfigs($xoopsDB,$xoopsUser);
$nbSections = $controler->getNumbersSections();

include_once 'class/yogurt_configs.php';

if(!$xoopsUser) {redirect_header('index.php');}

/**
* Factories of tribes  
*/
$configs_factory = new Xoopsyogurt_configsHandler($xoopsDB);

$uid = intval($xoopsUser->getVar('uid'));
 
$criteria = new Criteria('config_uid',$uid);
if($configs_factory->getCount($criteria)>0)
{
	$configs = $configs_factory->getObjects($criteria);
	$config = $configs[0];
	
	$pic = $config->getVar('pictures');
	$aud = $config->getVar('audio');
	$vid = $config->getVar('videos');
	$tri = $config->getVar('tribes');
	$scr = $config->getVar('scraps');
	$fri = $config->getVar('friends');
	$pcon = $config->getVar('profile_contact');
	$pgen = $config->getVar('profile_general');
	$psta = $config->getVar('profile_stats');
	
	$xoopsTpl->assign('pic',$pic);
	$xoopsTpl->assign('aud',$aud);
	$xoopsTpl->assign('vid',$vid);
	$xoopsTpl->assign('tri',$tri);
	$xoopsTpl->assign('scr',$scr);
	$xoopsTpl->assign('fri',$fri);
	$xoopsTpl->assign('pcon',$pcon);
	$xoopsTpl->assign('pgen',$pgen);
	$xoopsTpl->assign('psta',$psta);
}

//linking style and js
/**
* Adding to the module js and css of the lightbox and new ones
*/
$xoTheme->addStylesheet(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/include/yogurt.css');
$xoTheme->addStylesheet(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/css/jquery.tabs.css');
// what browser they use if IE then add corrective script.
if(ereg('msie', strtolower($_SERVER['HTTP_USER_AGENT']))) {$xoTheme->addStylesheet(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/css/jquery.tabs-ie.css');}
//$xoTheme->addStylesheet(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/css/lightbox.css');
//$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/js/prototype.js');
//$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/js/scriptaculous.js?load=effects'); 
//$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/lightbox/js/lightbox.js');
$xoTheme->addStylesheet(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/include/jquery.lightbox-0.3.css');
$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/include/jquery.js');
$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/include/jquery.lightbox-0.3.js');
$xoTheme->addScript(XOOPS_URL.'/modules/'.$xoopsModule->getVar('dirname').'/include/yogurt.js');

//permissions
$xoopsTpl->assign('allow_scraps',$controler->checkPrivilegeBySection('scraps'));
$xoopsTpl->assign('allow_friends',$controler->checkPrivilegeBySection('friends'));
$xoopsTpl->assign('allow_tribes',$controler->checkPrivilegeBySection('tribes'));
$xoopsTpl->assign('allow_pictures',$controler->checkPrivilegeBySection('pictures'));
$xoopsTpl->assign('allow_videos',$controler->checkPrivilegeBySection('videos'));

$xoopsTpl->assign('allow_audios',$controler->checkPrivilegeBySection('audio'));

//form
$xoopsTpl->assign('lang_whocan',_MD_YOGURT_WHOCAN);
$xoopsTpl->assign('lang_configtitle',_MD_YOGURT_CONFIGSTITLE);
$xoopsTpl->assign('lang_configprofilestats',_MD_YOGURT_CONFIGSPROFILESTATS);
$xoopsTpl->assign('lang_configprofilegeneral',_MD_YOGURT_CONFIGSPROFILEGENERAL);
$xoopsTpl->assign('lang_configprofilecontact',_MD_YOGURT_CONFIGSPROFILECONTACT);
$xoopsTpl->assign('lang_configfriends',_MD_YOGURT_CONFIGSFRIENDS);
$xoopsTpl->assign('lang_configscraps',_MD_YOGURT_CONFIGSSCRAPS);
$xoopsTpl->assign('lang_configsendscraps',_MD_YOGURT_CONFIGSSCRAPSSEND);
$xoopsTpl->assign('lang_configtribes',_MD_YOGURT_CONFIGSTRIBES);
$xoopsTpl->assign('lang_configaudio',_MD_YOGURT_CONFIGSAUDIOS); 
$xoopsTpl->assign('lang_configvideos',_MD_YOGURT_CONFIGSVIDEOS);
$xoopsTpl->assign('lang_configpictures',_MD_YOGURT_CONFIGSPICTURES);
$xoopsTpl->assign('lang_only_me',_MD_YOGURT_CONFIGSONLYME);
$xoopsTpl->assign('lang_only_friends',_MD_YOGURT_CONFIGSONLYEFRIENDS);
$xoopsTpl->assign('lang_only_users',_MD_YOGURT_CONFIGSONLYEUSERS);
$xoopsTpl->assign('lang_everyone',_MD_YOGURT_CONFIGSEVERYONE);

$xoopsTpl->assign('lang_cancel',_MD_YOGURT_CANCEL);

//xoopsToken
$xoopsTpl->assign('token',$GLOBALS['xoopsSecurity']->getTokenHTML());

//scraps
//$xoopsTpl->assign('scraps',$scraps);
$xoopsTpl->assign('lang_answerscrap',_MD_YOGURT_ANSWERSCRAP);

//Owner data
$xoopsTpl->assign('uid_owner',$controler->uidOwner);
$xoopsTpl->assign('owner_uname',$controler->nameOwner);
$xoopsTpl->assign('isOwner',$controler->isOwner);
$xoopsTpl->assign('isanonym',$controler->isAnonym);

//numbers
$xoopsTpl->assign('nb_tribes',$nbSections['nbTribes']);
$xoopsTpl->assign('nb_photos',$nbSections['nbPhotos']);
$xoopsTpl->assign('nb_videos',$nbSections['nbVideos']);
$xoopsTpl->assign('nb_scraps',$nbSections['nbScraps']);
$xoopsTpl->assign('nb_friends',$nbSections['nbFriends']);
$xoopsTpl->assign('nb_audio',$nbSections['nbAudio']); 

//navbar
$xoopsTpl->assign('module_name',$xoopsModule->getVar('name'));
$xoopsTpl->assign('lang_mysection',_MD_YOGURT_CONFIGSTITLE);
$xoopsTpl->assign('section_name',_MD_YOGURT_CONFIGSTITLE);
$xoopsTpl->assign('lang_home',_MD_YOGURT_HOME);
$xoopsTpl->assign('lang_photos',_MD_YOGURT_PHOTOS);
$xoopsTpl->assign('lang_friends',_MD_YOGURT_FRIENDS);
$xoopsTpl->assign('lang_audio',_MD_YOGURT_AUDIOS);
$xoopsTpl->assign('lang_videos',_MD_YOGURT_VIDEOS);
$xoopsTpl->assign('lang_scrapbook',_MD_YOGURT_SCRAPBOOK);
$xoopsTpl->assign('lang_profile',_MD_YOGURT_PROFILE);
$xoopsTpl->assign('lang_tribes',_MD_YOGURT_TRIBES);
$xoopsTpl->assign('lang_configs',_MD_YOGURT_CONFIGSTITLE);

//xoopsToken
$xoopsTpl->assign('token',$GLOBALS['xoopsSecurity']->getTokenHTML());

include '../../footer.php';
?>