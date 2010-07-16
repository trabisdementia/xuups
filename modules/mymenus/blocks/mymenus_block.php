<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

defined('XOOPS_ROOT_PATH') or die("XOOPS root path not defined");


include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include_once XOOPS_ROOT_PATH . '/modules/mymenus/include/functions.php';

function mymenus_block_show($options)
{
    $block = array();
    global $xoopsTpl, $xoTheme, $xoopsUser, $xoopsConfig, $xoopsLogger;
    $xoopsLogger->startTime('My Menus Block');
    $myts =& MyTextSanitizer::getInstance();

    include_once XOOPS_ROOT_PATH . '/modules/mymenus/include/functions.php';
    include_once XOOPS_ROOT_PATH . '/modules/mymenus/class/registry.php';
    include_once XOOPS_ROOT_PATH . '/modules/mymenus/class/plugin.php';
    include_once XOOPS_ROOT_PATH . '/modules/mymenus/class/builder.php';

    $registry =& MymenusRegistry::getInstance();
    $plugin =& MymenusPlugin::getInstance();
    $plugin->triggerEvent('Boot');

    $menu_id = $options[0];

    $this_handler =& xoops_getModuleHandler('menu', 'mymenus');

    $criteria = new CriteriaCompo(new Criteria('mid', $menu_id));
    $criteria->setSort('weight');
    $criteria->setOrder('ASC');
    //get menus as an array with ids as keys
    $menus = $this_handler->getAll($criteria, null, false, true);
    unset($criteria);

    foreach ($menus as $key => $menu) {
        $registry->setEntry('menu', $menu);
        $registry->setEntry('has_access', 'yes');
        $plugin->triggerEvent('HasAccess');
        if ($registry->getEntry('has_access') == 'no') {
            unset($menus[$key]);
        }
    }

    $count = count($menus);
    if ($count == 0) return $block;

    foreach ($menus as $key => $menu) {
        $registry->setEntry('link_array', $menu);
        $plugin->triggerEvent('TitleDecoration');
        $plugin->triggerEvent('AlttitleDecoration');
        $plugin->triggerEvent('LinkDecoration');
        $plugin->triggerEvent('ImageDecoration');
        $menus[$key] = $registry->getEntry('link_array');
    }

    $builder = new MymenusBuilder($menus);
    $block = $builder->render();

/*--------------------------------------------------------------*/
    //default files to load
    $css = array();
    $js = array();

    //get extra files from skins
    $skin = $options[1];
    $skin_info = mymenus_getSkinInfo($skin);

    if (isset($skin_info['css'])) {
        $css = array_merge($css, $skin_info['css']);
    }

    if (isset($skin_info['js'])) {
        $js = array_merge($js, $skin_info['js']);

    }

    $config = mymenus_getModuleConfig();
    if ($config['assign_method'] == 'xoopstpl') {
        $tpl_vars = '';
        foreach ($css as $file) {
            $tpl_vars .= "\n" . '<link rel="stylesheet" type="text/css" media="all" href="'. $file . '" />';
        }

        foreach ($js as $file) {
            $tpl_vars .= "\n" . '<script type="text/javascript" src="'. $file . '"></script>';
        }

        if (isset($skin_info['header'])) {
            $tpl_vars .= "\n" . $skin_info['header'];
        }

        $xoopsTpl->assign('xoops_module_header' , $tpl_vars . @$xoopsTpl->get_template_vars("xoops_module_header"));
    } else {
        foreach ($css as $file) {
            $xoTheme->addStylesheet($file);
        }

        foreach ($js as $file) {
            $xoTheme->addScript($file);
        }

        if (isset($skin_info['header'])) {
            $xoopsTpl->assign('xoops_footer' , @$xoopsTpl->get_template_vars("xoops_footer") . "\n" . $skin_info['header']);
        }
    }

    include_once XOOPS_ROOT_PATH . '/class/template.php';
    $blockTpl = new XoopsTpl();
    $blockTpl->assign('block', $block);
    //$blockTpl->assign('block2', $block2);
    //$blockTpl->assign('skin', $skin);
    $blockTpl->assign('config', $skin_info['config']);

    $block['content'] = $blockTpl->fetch($skin_info['template']);

    if ($options[2] == 'template') {
        $xoopsTpl->assign('xoops_menu_' . $options[3] , $block['content']);
        $block = array();
    }

    $registry->unsetAll();
    unset($registry, $plugin);
    $xoopsLogger->stopTime('My Menus Block');

    return $block;
}

function mymenus_block_edit($options)
{
    //Unique ID
    if (!$options[3] || (isset($_GET['op']) && $_GET['op'] == 'clone')) $options[3] = time();

    $menus_handler =& xoops_getModuleHandler('menus', 'mymenus');
    xoops_loadLanguage('admin', 'mymenus');

    $criteria = new Criteria(1, 1);
    $criteria->setSort('title');
    $criteria->setOrder('ASC');
    $menus = $menus_handler->getObjects($criteria);
    unset($criteria);

    if (count($menus) == 0) {
        $form = "<a href='" . XOOPS_URL . "/modules/mymenus/admin/admin_menus.php'>" . _AM_MYMENUS_MSG_NOMENUS . "</a>";
        return $form;
    }

    include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";

    $form = "<b>" . _MB_MYMENUS_SELECT_MENU . "</b>&nbsp;<select name='options[0]'>";
    foreach($menus as $menu){
        $form .= "<option value='" . $menu->getVar('id') . "'";
        if ($options[0] == $menu->getVar('id')) {
            $form .= " selected='selected'";
        }
        $form .= '>' . $menu->getVar('title') . "</option>\n";
    }
    $form .= "</select>\n<br /><br />";
    /*
    $form .= "<b>" . _MB_MYTABS_WIDTH . "</b>&nbsp;";
    $element = new XoopsFormText('', 'options[1]', 10, 50, $options[1]);
    $form .= $element->render();
    $form .= "\n&nbsp;&nbsp;<i>" . _MB_MYTABS_WIDTH_DSC . "</i><br /><br />";

    $form .= "<b>" . _MB_MYTABS_HEIGHT . "</b>&nbsp;";
    $element = new XoopsFormText('', 'options[2]', 10, 50, $options[2]);
    $form .= $element->render();
    $form .= "\n&nbsp;&nbsp;<i>" . _MB_MYTABS_HEIGHT_DSC . "</i><br /><br />";
    */

    $menus = XoopsLists::getDirListAsArray(XOOPS_ROOT_PATH . "/modules/mymenus/skins/", "");
    $form .= "<b>" . _MB_MYMENUS_SELECT_SKIN . "</b>&nbsp;";
    $form .= "<select name='options[1]'>";
    foreach ($menus as $menu) {
        if (file_exists(XOOPS_ROOT_PATH . '/modules/mymenus/skins/' . $menu . '/skin_version.php')) {
            $form .= "<option value='" . $menu . "'";
            if ( $options[1] == $menu ) {
                $form .= " selected='selected'";
            }
            $form .= '>' . $menu . "</option>\n";
        }
    }
    $form .= "</select>\n&nbsp;&nbsp;<i>" . _MB_MYMENUS_SELECT_SKIN_DSC . "</i><br /><br />";

    $display_options = array(
                     'block'    => _MB_MYMENUS_DISPLAY_METHOD_BLOCK,
                     'template' => _MB_MYMENUS_DISPLAY_METHOD_TEMPLATE
                    );

    $form .= "<b>" . _MB_MYMENUS_DISPLAY_METHOD . "</b>&nbsp;";
    $element = new XoopsFormSelect('', 'options[2]', $options[2], 1);
    $element->addOptionArray($display_options);
    $form .= $element->render();
    $form .= "</select>\n&nbsp;&nbsp;<i>" . _MB_MYMENUS_DISPLAY_METHOD_DSC . "</i><br /><br />";

    $form .= "<b>" . _MB_MYMENUS_UNIQUEID . "</b>&nbsp;";
    $element = new XoopsFormText('', 'options[3]', 10, 50, $options[3]);
    $form .= $element->render();
    $form .= "\n&nbsp;&nbsp;<i>" . _MB_MYMENUS_UNIQUEID_DSC . "</i><br /><br />";
    /*
    $form .= "<b>" . _MB_MYTABS_PERSIST . "</b>&nbsp";
    $element = new XoopsFormRadioYN('', 'options[4]', $options[4]);
    $form .= $element->render();
    $form .= "\n&nbsp;&nbsp;<i>" . _MB_MYTABS_PERSIST_DSC . "</i><br /><br />"; */
    /*
    $form .= "<b>" . _MB_MYTABS_PERSIST . "</b>&nbsp";
    $element = new XoopsFormRadioYN('', 'options[4]', $options[4]);
    $form .= $element->render();
    $form .= "\n&nbsp;&nbsp;<i>" . _MB_MYTABS_PERSIST_DSC . "</i><br /><br />";

    $form .= "<b>" . _MB_MYTABS_MILISEC . "</b>&nbsp;";
    $element = new XoopsFormText('', 'options[5]', 10, 50, $options[5]);
    $form .= $element->render();
    $form .= "\n&nbsp;&nbsp;<i>" . _MB_MYTABS_MILISEC_DSC . "</i><br /><br />";

    $form .= "<b>" . _MB_MYTABS_UNIQUEID . "</b>&nbsp;";
    $element = new XoopsFormText('', 'options[6]', 10, 50, $options[6]);
    $form .= $element->render();
    $form .= "\n&nbsp;&nbsp;<i>" . _MB_MYTABS_UNIQUEID_DSC . "</i><br /><br />";

    $form .= "<b>" . _MB_MYTABS_BLOCKSTITLE . "</b>&nbsp";
    $element = new XoopsFormRadioYN('', 'options[7]', $options[7]);
    $form .= $element->render();
    $form .= "\n&nbsp;&nbsp;<i>" . _MB_MYTABS_BLOCKSTITLE_DSC . "</i><br /><br />";

    $form .= "<b>" . _MB_MYTABS_ONMOUSEOVER . "</b>&nbsp";
    $element = new XoopsFormRadioYN('', 'options[8]', $options[8]);
    $form .= $element->render();
    $form .= "\n&nbsp;&nbsp;<i>" . _MB_MYTABS_ONMOUSEOVER_DSC . "</i><br /><br />";

    $form .= "<b>" . _MB_MYTABS_HIDETABS . "</b>&nbsp";
    $element = new XoopsFormRadioYN('', 'options[9]', $options[9]);
    $form .= $element->render();
    $form .= "\n&nbsp;&nbsp;<i>" . _MB_MYTABS_HIDETABS_DSC . "</i><br /><br />";

    $effects = array('none', 'fade',
                    'easeInQuad', 'easeOutQuad', 'easeInOutQuad',
                    'easeInCubic', 'easeOutCubic', 'easeInOutCubic',
                    'easeInQuart', 'easeOutQuart', 'easeInOutQuart',
                    'easeInQuint', 'easeOutQuint', 'easeInOutQuint',
                    'easeInSine', 'easeOutSine', 'easeInOutSine',
                    'easeInExpo', 'easeOutExpo', 'easeInOutExpo',
                    'easeInCirc', 'easeOutCirc', 'easeInOutCirc',
                    'easeInElastic', 'easeOutElastic', 'easeInOutElastic',
                    'easeInBack', 'easeOutBack', 'easeInOutBack',
                    'easeInBounce', 'easeOutBounce', 'easeInOutBounce'
                    );

    if (!isset($options[10])) $options[10] = 'none'; //needed for upgrades :(
    $form .= "<b>" . _MB_MYTABS_EFFECTS_IN . "</b>&nbsp;";
    $element = new XoopsFormSelect('', 'options[10]', $options[10], 3);
    $element->addOptionArray($effects);
    $form .= $element->render();
    $form .= "\n&nbsp;&nbsp;<i>" . _MB_MYTABS_EFFECTS_IN_DSC . "</i><br /><br />";

    if (!isset($options[11])) $options[11] = 0; //needed for upgrades :(
    $form .= "<b>" . _MB_MYTABS_EFFECTS_INTIME . "</b>&nbsp;";
    $element = new XoopsFormText('', 'options[11]', 10, 50, $options[11]);
    $form .= $element->render();
    $form .= "\n&nbsp;&nbsp;<i>" . _MB_MYTABS_EFFECTS_INTIME_DSC . "</i><br /><br />";

    if (!isset($options[12])) $options[12] = 'none'; //needed for upgrades :(
    $form .= "<b>" . _MB_MYTABS_EFFECTS_OUT . "</b>&nbsp;";
    $element = new XoopsFormSelect('', 'options[12]', $options[12], 3);
    $element->addOptionArray($effects);
    $form .= $element->render();
    $form .= "\n&nbsp;&nbsp;<i>" . _MB_MYTABS_EFFECTS_OUT_DSC . "</i><br /><br />";

    if (!isset($options[13])) $options[13] = 0; //needed for upgrades :(
    $form .= "<b>" . _MB_MYTABS_EFFECTS_OUTTIME . "</b>&nbsp;";
    $element = new XoopsFormText('', 'options[13]', 10, 50, $options[13]);
    $form .= $element->render();
    $form .= "\n&nbsp;&nbsp;<i>" . _MB_MYTABS_EFFECTS_OUTTIME_DSC . "</i><br /><br />";
     */
    return $form;

}
