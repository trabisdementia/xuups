<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

include_once dirname(__FILE__) . '/header.php';

if (!isset($_GET["email"]) || !isset($_GET["key"])) {
    redirect_header(XOOPS_URL, 2, _MA_MYINV_ERROR_BLACKLIST);
    exit();
}

$email = $_GET["email"];
$key = $_GET["key"];

$truekey = md5($email . XOOPS_ROOT_PATH);

if ($truekey != $key) {
    redirect_header(XOOPS_URL, 2, _MA_MYINV_ERROR_BLACKLIST);
    exit();
}

$bl_handler =& xoops_getmodulehandler('blacklist');
$criteria = new Criteria('bl_email',$email);

if ($bl_handler->getCount($criteria) > 0) {
    redirect_header(XOOPS_URL, 2, _MA_MYINV_ERROR_BLACKLIST);
    exit();
}

$bl = $bl_handler->create();
$bl->setVar('bl_email',$email);
$bl->setVar('bl_date', time());

if (!$bl_handler->insert($bl)){
    redirect_header(XOOPS_URL, 2, _MA_MYINV_ERROR_BLACKLIST);
    exit();
}

redirect_header(XOOPS_URL, 5, _MA_INVITER_BLACKLISTED);
exit();

?>
