<?php
defined('XMF_EXEC') or die('Restricted access on ' . __FILE__);
function _e($string, $default = null)
{
    echo Xmf_Language::_($string, $default);
}

function _t($string, $default = null)
{
    return Xmf_Language::_($string, $default);
}
function xmf_getmodulehandler($item, $dirname)
{
    $helper = Xmf_Module_Helper::getInstance($dirname);
    return $helper->getHandler($item);
}

function xmf_getModuleConfig($dirname)
{
    $helper = Xmf_Module_Helper::getInstance($dirname);
    return $helper->getConfig();
}

function xmf_getModuleInfo($dirname)
{
    $helper = Xmf_Module_Helper::getInstance($dirname);
    return $helper->getModule();
}

function xmf_get_page_before_form()
{
    global $xoops;
    return isset($_POST['xmf_page_before_form']) ? $_POST['xmf_page_before_form'] : $xoops->urls['previouspage'];
}

function xmf_buildRelevantUrls() {
    $http = ((strpos(XOOPS_URL, "https://")) === false) ? ("http://") : ("https://");
    $phpself = $_SERVER['PHP_SELF'];
    $httphost = $_SERVER['HTTP_HOST'];
    $querystring = $_SERVER['QUERY_STRING'];
    if ($querystring != '') {
        $querystring = '?' . $querystring;
    }
    $currenturl = $http . $httphost . $phpself . $querystring;
    $urls = array ();
    $urls['http'] = $http;
    $urls['httphost'] = $httphost;
    $urls['phpself'] = $phpself;
    $urls['querystring'] = $querystring;
    $urls['full_phpself'] = $http . $httphost . $phpself;
    $urls['full'] = $currenturl;
    $urls['previouspage'] = '';
    if (array_key_exists( 'HTTP_REFERER', $_SERVER) && isset($_SERVER['HTTP_REFERER'])) {
        $urls['previouspage'] = $_SERVER['HTTP_REFERER'];
    }
    return $urls;
}

function xmf_conv_nr2local($number)
{
    return $number;
}

function xmf_showButtons( $butt_align = 'right', $butt_id = 'button', $class_id = 'formbutton' , $button_array = array() ) {
    if ( !is_array( $button_array ) ) {
        return false;
    }
    $ret = "<div style='text-align: $butt_align; margin-bottom: 12px;'>\n";
    $ret .= "<form id='{$butt_id}' action='showbuttons'>\n";
    foreach ( $button_array as $k => $v ) {
        $ret .= "<input type='button' style='cursor: hand;' class='{$class_id}'  name='" . trim( $v ) . "' onclick=\"location='" . htmlspecialchars( trim( $k ), ENT_QUOTES ) . "'\" value='" . trim( $v ) . "' />&nbsp;&nbsp;";
    }
    $ret .= "</form>\n";
    $ret .= "</div>\n";
    echo $ret;
}

function xmf_showImage( $name = '', $title = '', $align = 'middle', $ext = 'png', $path = '', $size = '' ) {
    if ( empty( $path ) ) {
        $path = 'modules/xmf/images/actions';
    }
    if ( !empty( $name ) ) {
        $fullpath = XOOPS_URL . '/' . $path . '/' . $name . '.' . $ext;
        $ret = '<img src="' . $fullpath . '" ';
        if ( !empty( $size ) ) {
            $ret = '<img src="' . $fullpath . '" ' . $size;
        }
        // $title = ( !empty( $title ) ) ? htmlspecialchars( $title ) : htmlspecialchars( $name );
        $ret .= ' title = "' . $title . '"';
        $ret .= ' alt = "' . $title . '"';
        if ( !empty( $align ) ) {
            $ret .= ' style="vertical-align: ' . $align . '; border: 0px;"';
        }
        $ret .= ' />';
        return $ret;
    } else {
        return '';
    }
}

function xmf_getImage( $value ) {
    if ( $value != 'blank.png' || $value != 'blank.gif' ) {
        $image = explode( '|', $value );
        $image = ( is_array( $image ) ) ? $image[0] : $value ;
        return $image;
    } else {
        return '';
    }
}


function xmf_getIcons( $_icon_array = array(), $key, $value = null, $extra = null ) {
    $ret = '';
    if ( $value ) {
        foreach( $_icon_array as $_op => $_icon ) {
            $url = ( !is_numeric( $_op ) ) ? $_op . "?{$key}=" . $value : xoops_getenv( 'PHP_SELF' ) . "?op={$_icon}&amp;{$key}=" . $value;
            if ( $extra != null ) {
                $url .= $extra;
            }
            $ret .= "<a href='" . $url . " '>" . xmf_showImage( $_icon, _t('_form_xmf_' . $_icon ), null, 'png' ) . "</a>";
        }
    }
    return $ret;
}

function xmf_getEditors() {
    $filename = XOOPS_ROOT_PATH . '/class/xoopseditor/xoopseditor.php';
    if (!file_exists($filename)) {
        return false;
    }
    include_once $filename;
    $xoopseditor_handler = XoopsEditorHandler::getInstance();

    return array_flip($xoopseditor_handler->getList());
}

function xmf_getTablesArray($moduleName, $items) {
    $ret = array();
    foreach ($items as $item) {
        $ret[] = $moduleName . '_' . $item;
    }
    $ret[] = $moduleName . '_meta';
    return $ret;
}

/**
 * Store a cookie
 *
 * @param string $name name of the cookie
 * @param string $value value of the cookie
 * @param int $time duration of the cookie
 */
function xmf_setCookieVar($name, $value, $time = 0)
{
    if($time == 0) {$time = time() + 3600 * 24 * 365;}
    setcookie($name, $value, $time, '/');
}

/**
 * Get a cookie value
 *
 * @param string $name name of the cookie
 * @param string $default value to return if cookie not found
 *
 * @return string value of the cookie or default value
 */
function xmf_getCookieVar($name, $default = '')
{
    $name = str_replace('.', '_', $name);
    if((isset($_COOKIE[$name])) && ($_COOKIE[$name] > '')) {return $_COOKIE[$name];}
    else {return $default;}
}

function xmf_getMeta($key, $moduleName = false) {
    if (!$moduleName) {
        $moduleName = xmf_getCurrentModuleName();
    }
    $xoopsDB = & Database :: getInstance();
    $sql = sprintf("SELECT metavalue FROM %s WHERE metakey=%s", $xoopsDB->prefix($moduleName . '_meta'), $xoopsDB->quoteString($key));
    $ret = $xoopsDB->query($sql);
    if (!$ret) {
        $value = false;
    } else {
        list ($value) = $xoopsDB->fetchRow($ret);
    }
    return $value;
}

function xmf_setMeta($key, $value, $moduleName = false) {
    if (!$moduleName) {
        $moduleName = xmf_getCurrentModuleName();
    }
    $xoopsDB = & Database :: getInstance();
    $ret = xmf_getMeta($key, $moduleName);
    if ($ret === '0' || $ret > 0) {
        $sql = sprintf("UPDATE %s SET metavalue = %s WHERE metakey = %s", $xoopsDB->prefix($moduleName . '_meta'), $xoopsDB->quoteString($value), $xoopsDB->quoteString($key));
    } else {
        $sql = sprintf("INSERT INTO %s (metakey, metavalue) VALUES (%s, %s)", $xoopsDB->prefix($moduleName . '_meta'), $xoopsDB->quoteString($key), $xoopsDB->quoteString($value));
    }
    $ret = $xoopsDB->queryF($sql);
    if (!$ret) {
        return false;
    }
    return true;
}

function xmf_getCurrentModuleName() {
    global $xoopsModule;
    if (is_object($xoopsModule)) {
        return $xoopsModule->getVar('dirname');
    } else {
        return false;
    }
}
