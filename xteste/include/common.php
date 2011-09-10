<?php
//This is handled by xmf preload

if (!xoops_isActiveModule('xmf')) {
    if (file_exists($file = dirname(dirname(dirname(__FILE__))) . '/xmf/include/bootstrap.php')) {
        include_once $file;
        echo 'Please install or reactivate XMF module';
    } else {
        redirect_header(XOOPS_URL, 5, 'Please install XMF module');
    }
}
?>
