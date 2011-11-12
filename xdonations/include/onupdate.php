<?php

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;
echo '' . XOOPS_ROOT_PATH . '<br />';
// referer check
$ref = xoops_getenv('HTTP_REFERER');
if( $ref == '' || strpos( $ref , XOOPS_URL.'/modules/system/admin.php' ) === 0 ) {
    $xypDir = basename ( dirname( dirname( __FILE__ ) ) ) ;
    include_once 'installscript.php';
//    include_once '' . $GLOBALS['XOOPS_ROOT_PATH'] . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $xypDir . DIRECTORY_SEPARATOR . 'installscript.php';
    eval( 'xoops_module_install_' . $xypDir . '();
        ' ) ;
}
?>