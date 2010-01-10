<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

if (!defined("XOOPS_ROOT_PATH")) {
 	die("XOOPS root path not defined");
}

$modversion['name'] = _MI_SALAT_MD_NAME;
$modversion['version'] = 1.00;
$modversion['description'] = _MI_SALAT_MD_DESC;
$modversion['credits'] = "Xuups, Mohamad Magdy <mohamad_magdy_egy@hotmail.com>";
$modversion['author'] = "Xuups";
$modversion['help'] = "";
$modversion['license'] = "GPL see LICENSE";
$modversion['official'] = 0;
$modversion['image'] = "images/salat.png";
$modversion['dirname'] = "salat";

// Menu
$modversion['hasMain'] = 1;
// Admin things
$modversion['hasAdmin'] = 1;
// Search
$modversion['hasSearch'] = 0;
// Comments
$modversion['hasComments'] = 0;

// Templates
$i = 0;
$i++;
$modversion['templates'][$i]['file'] = "salat_index.html";
$modversion['templates'][$i]['description'] = _MI_SALAT_PAGE_INDEX;

// Blocks
$i = 0;
$i++;
$modversion['blocks'][$i]['file'] = "salat_block.php";
$modversion['blocks'][$i]['name'] = _MI_SALAT_BLK;
$modversion['blocks'][$i]['description'] = _MI_SALAT_BLK_DSC;
$modversion['blocks'][$i]['show_func'] = "salat_block_show";
$modversion['blocks'][$i]['template'] = "salat_block.html";

// Configs
$i = 0;
$i++;
$modversion['config'][$i]['name'] = 'data';
$modversion['config'][$i]['title'] = '_MI_SALAT_CONF_DATA';
$modversion['config'][$i]['description'] = '_MI_SALAT_CONF_DATA_DSC';
$modversion['config'][$i]['formtype'] = 'textarea';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '
Abu Dhabi,United Arab Emirates,24.4753,54.3718
Algiers,Algeria,36.7763,3.0585
Amman,Jordan,31.9566,35.9326
Baghdad,Iraq,33.325,44.422
Beirut,Lebanon,33.886944,35.513056
Cairo,Eygpt,30.058,31.229
Damascus,Syria,33.513,36.292
Djibouti,Djibouti,11.588,43.145
Doha,Qatar,25.305,51.5184
Jerusalem,Palestine,31.783333,35.216667
Khartoum,Sudan,15.633,32.533
Kuwait City,Kuwait,29.371,47.988
Manama,Bahrain,26.2152,50.5888
Mogadishu,Somalia,2.066667,45.366667
Muscat,Oman,23.61,58.54
Nouakchott,Mauritania,18.0669,-15.99
Rabat,Morocco,34.033333,-6.833333
Riyadh,Saudi Arabia,24.6464,46.742
Sanaa,Yemen,15.3547,44.2067
Tripoli,Libya,32.902222,13.185833|default
Tunis,Tunisia,36.8,10.17
Kuala Lumpur,Malaysia,101.688,3.1357';
