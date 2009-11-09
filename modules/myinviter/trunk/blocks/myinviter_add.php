<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

function myinviter_add_show($options)
{
    $block = array();
    include_once XOOPS_ROOT_PATH . '/modules/myinviter/include/functions.php';
    include_once XOOPS_ROOT_PATH . '/modules/myinviter/class/openinviter.php';
    xoops_loadLanguage('main', 'myinviter');

    $email_box = isset($_POST['email_box']) ?  $_POST['email_box'] : '';
    $password_box = isset($_POST['password_box']) ?  $_POST['password_box'] : '';
    $provider_box = isset($_POST['provider_box']) ?  $_POST['provider_box'] : '';

    $inviter = new OpenInviter();
    $oi_services = $inviter->getPlugins();

    $p_selected = '';
    $plugType = '';
    if (!empty($provider_box)) {
        if (isset($oi_services['email'][$provider_box])) {
            $plugType = 'email';
        } elseif (isset($oi_services['social'][$provider_box])) {
            $plugType = 'social';
        }
    }

    $i = 0;
    foreach ($oi_services as $type => $providers) {
        $s_list[$i] = $inviter->pluginTypes[$type];
        foreach ($providers as $provider => $details) {
            $p_list[$i][$provider] = $details['name'];
            if ($provider_box == $provider) $p_selected = $provider;
        }
        $i++;
    }

    $block['services'] = $s_list;
    $block['providers'] = $p_list;
    $block['selected'] = $p_selected;
    $block['email_box'] = $email_box;
    $block['password_box'] = $password_box;
    $block['provider_box'] = $provider_box;

    myinviter_sendEmails();
    return $block;
}
?>
