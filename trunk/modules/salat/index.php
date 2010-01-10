<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

include_once dirname(__FILE__) . '/../../mainfile.php';

include_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
include_once XOOPS_ROOT_PATH . '/modules/salat/include/functions.php';

$xoopsOption['template_main'] = 'salat_index.html';
include_once XOOPS_ROOT_PATH . '/header.php';

$step = isset($_POST['get_prayers']) ? 'get_prayers' : '';

$city = isset($_POST['city']) ?  $_POST['city'] : '';
$date = isset($_POST['date']) ?  $_POST['date'] : time();
$timezone = isset($_POST['timezone']) ?  $_POST['timezone'] : 0;

$infos = salat_getInfos();

switch ($step){
    case 'get_prayers':

        $date = strtotime($date);
        $datetime = getDate($date);

        @ini_set('zend.ze1_compatibility_mode', '1');
        include dirname(__FILE__) . '/class/salat.class.php';

        $Salat = new Salat();
        $Salat->setLocation($infos[$city]['long'], $infos[$city]['lat'], $timezone);
        $Salat->setDate($datetime['mday'], $datetime['mon'], $datetime['year']);
        $times = $Salat->getPrayTime();
        ksort($times);
        $prayers =  array(
                            _MA_SALAT_PRAYERS_FAJR,
                            _MA_SALAT_PRAYERS_SUNRISE,
                            _MA_SALAT_PRAYERS_ZUHR,
                            _MA_SALAT_PRAYERS_ASR,
                            _MA_SALAT_PRAYERS_MAGHRIB,
                            _MA_SALAT_PRAYERS_ISHA
                         );

        $xoopsTpl->assign('times', $times);
        $xoopsTpl->assign('prayers', $prayers);

        break;

    default:
        break;
}

$sform = new XoopsThemeForm(_MA_SALAT_GETPRAYERS , "form", xoops_getenv('PHP_SELF'));

foreach ($infos as $info) {
    $options[$info['city']] = $info['city'] . ' - ' . $info['country'];
    if (isset($info['default'])) {
        $default = $info['city'];
    }
}

$city = (isset($default) && $city == '') ? $default : $city;
// City
$element = new XoopsFormSelect(_MA_SALAT_SELECT_CITY, 'city', $city);
$element->addOptionArray($options);
$sform->addElement($element);
unset($element);

$element = new XoopsFormTextDateSelect(_MA_SALAT_SELECT_DATE, 'date', 15, $date);
$sform->addElement($element);
unset($element);

// Timezone
$element = new XoopsFormSelectTimezone(_MA_SALAT_SELECT_TIMEZONE, 'timezone', $timezone);
$sform->addElement($element);
unset($element);

$sform->addElement(new XoopsFormButton('', 'get_prayers', _SUBMIT, 'submit'));

$xoopsTpl->assign('form', $sform->render());

include_once XOOPS_ROOT_PATH . '/footer.php';
