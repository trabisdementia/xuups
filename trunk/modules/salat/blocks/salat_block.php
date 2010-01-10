<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

if (!defined('XOOPS_ROOT_PATH')) {
    die("XOOPS root path not defined");
}

include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include_once XOOPS_ROOT_PATH . '/modules/salat/include/functions.php';

xoops_loadLanguage('main', 'salat');

function salat_block_show($options) {
    $block = array();
    $infos = salat_getInfos();

    $sform = new XoopsThemeForm(_MA_SALAT_GETPRAYERS , "form", XOOPS_URL . '/modules/salat/index.php');
    foreach ($infos as $info) {
        $options[$info['city']] = $info['city'] . ' - ' . $info['country'];
        if (isset($info['default'])) {
            $default = $info['city'];
        }
    }

    $city = isset($default) ? $default : '';
    $date = time();
    $timezone = 0;
    
    
    // City
    $element = new XoopsFormSelect(_MA_SALAT_SELECT_CITY, 'city', $city);
    $element->addOptionArray($options);
    $element->setExtra('width="100" style="width:100px;"');
    $sform->addElement($element);
    unset($element);

    $element = new XoopsFormTextDateSelect(_MA_SALAT_SELECT_DATE, 'date', 12, $date);
    //$element->setExtra('width="100" style="width:100px;"');
    $sform->addElement($element);
    unset($element);

    // Timezone
    $element = new XoopsFormSelectTimezone(_MA_SALAT_SELECT_TIMEZONE, 'timezone', $timezone);
    $element->setExtra('width="100" style="width:100px;"');
    $sform->addElement($element);
    unset($element);

    $sform->addElement(new XoopsFormButton('', 'get_prayers', _SUBMIT, 'submit'));

    $block['content'] = $sform->render();
    return $block;
}
