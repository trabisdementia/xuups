<?php
if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

$modversion['name'] = _MI_SUBSCRIBERS_MD_NAME;
$modversion['version'] = 1.0;
$modversion['description'] = _MI_SUBSCRIBERS_MD_DSC;
$modversion['author'] = "Trabis - www.xuups.com";
$modversion['credits'] = "Mowaffaq - www.arabxoops.com";
$modversion['help'] = "";
$modversion['license'] = "GNU General Public License (GPL)";
$modversion['official'] = 0;
$modversion['dirname'] = "subscribers";

$modversion['image'] = "images/module_logo.gif";

// Admin things
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Sql file (must contain sql generated by phpMyAdmin or phpPgAdmin)
// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
// Tables created by sql file (without prefix!)
$modversion['tables'][0] = "subscribers_user";
$modversion['tables'][1] = "subscribers_message";
$modversion['tables'][2] = "subscribers_waiting";

// Search
$modversion['hasSearch'] = 0;
// Menu
$modversion['hasMain'] = 1;

// Templates
$i = 0;
$i++;
$modversion['templates'][$i]['file'] = 'subscribers_index.html';
$modversion['templates'][$i]['description'] = _MI_SUBSCRIBERS_PAGE_INDEX;


// Blocks
$i = 0;
$i++;
$modversion['blocks'][$i]['file'] = "subscribers_add.php";
$modversion['blocks'][$i]['name'] = _MI_SUBSCRIBERS_BLK_ADD;
$modversion['blocks'][$i]['description'] = "Subscription block";
$modversion['blocks'][$i]['show_func'] = "subscribers_add_show";
$modversion['blocks'][$i]['template'] = "subscribers_add.html";

// Configs
$i = 0;

//default value for Xoops editor
xoops_load('XoopsEditorHandler');
$editor_handler = XoopsEditorHandler::getInstance();

$i++;
$modversion['config'][$i]['name'] = 'editor';
$modversion['config'][$i]['title'] = '_MI_SUBSCRIBERS_CONF_EDITOR';
$modversion['config'][$i]['description'] = '_MI_SUBSCRIBERS_CONF_EDITOR_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['options'] = array_flip($editor_handler->getList());
$modversion['config'][$i]['default'] ='dhtmltextarea';

//default value for country
include_once XOOPS_ROOT_PATH . '/class/xoopslists.php';
$countries = XoopsLists::getCountryList();
unset($countries[""]);

$i++;
$modversion['config'][$i]['name'] = 'country';
$modversion['config'][$i]['title'] = '_MI_SUBSCRIBERS_CONF_COUNTRY';
$modversion['config'][$i]['description'] = '_MI_SUBSCRIBERS_CONF_COUNTRY_DSC';
$modversion['config'][$i]['formtype'] = 'select';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['options'] = array_flip($countries);
$modversion['config'][$i]['default'] ='PT';

$i++;
$modversion['config'][$i]['name'] = 'fromname';
$modversion['config'][$i]['title'] = '_MI_SUBSCRIBERS_CONF_FROMNAME';
$modversion['config'][$i]['description'] = '_MI_SUBSCRIBERS_CONF_FROMNAME_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'fromemail';
$modversion['config'][$i]['title'] = '_MI_SUBSCRIBERS_CONF_FROMEMAIL';
$modversion['config'][$i]['description'] = '_MI_SUBSCRIBERS_CONF_FROMEMAIL_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'text';
$modversion['config'][$i]['default'] = '';

$i++;
$modversion['config'][$i]['name'] = 'emailsperpack';
$modversion['config'][$i]['title'] = '_MI_SUBSCRIBERS_CONF_EMAILSPERPACK';
$modversion['config'][$i]['description'] = '_MI_SUBSCRIBERS_CONF_EMAILSPERPACK_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 10;

$i++;
$modversion['config'][$i]['name'] = 'timebpacks';
$modversion['config'][$i]['title'] = '_MI_SUBSCRIBERS_CONF_TIMEBPACKS';
$modversion['config'][$i]['description'] = '_MI_SUBSCRIBERS_CONF_TIMEBPACKS_DSC';
$modversion['config'][$i]['formtype'] = 'textbox';
$modversion['config'][$i]['valuetype'] = 'int';
$modversion['config'][$i]['default'] = 3600;
?>