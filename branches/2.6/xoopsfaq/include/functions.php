<?php
/**
 * Name: functions.php
 * Description: Module specific Functions for Xoops FAQ
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package : XOOPS
 * @Module : Xoops FAQ
 * @subpackage : Functions
 * @since 2.3.0
 * @author John Neill
 * @version $Id$
 */
defined('XOOPS_ROOT_PATH') or die('Restricted access');

/**
 * loadModuleAdminMenu()
 *
 * @param mixed $currentoption
 * @param string $breadcrumb
 * @return
 */
function xoopsFaq_AdminMenu($currentoption, $breadcrumb = '')
{
    if (!$adminmenu = $GLOBALS["xoopsModule"]->getAdminMenu()) {
        return false;
    }

    $breadcrumb = empty($breadcrumb) ? $adminmenu[$currentoption]["title"] : $breadcrumb;
    $module_link = XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/';
    $image_link = XOOPS_URL . '/modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/images';
}

/**
 * xoopsFaq_CleanVars()
 *
 * @return
 */
function xoopsFaq_CleanVars(&$global, $key, $default = '', $type = 'int')
{
    switch ($type) {
        case 'string':
            $ret = (isset($global[$key])) ? filter_var($global[$key], FILTER_SANITIZE_MAGIC_QUOTES) : $default;
            break;
        case 'int':
        default:
            $ret = (isset($global[$key])) ? filter_var($global[$key], FILTER_SANITIZE_NUMBER_INT) : $default;
            break;
    }
    if (false == $ret) {
        return $default;
    }
    return $ret;
}

/**
 * xoopsFaq_displayHeading()
 *
 * @param mixed $value
 * @return
 */
function xoopsFaq_DisplayHeading($heading = '', $subheading = '', $showbutton = true)
{
    $ret = '';

    if (!empty($heading)) {
        $ret .= '<h4>' . $heading . '</h4>';
    }

    if (!empty($subheading)) {
        $ret .= '<div style="text-align: left; margin-bottom: 5px; margin-left: 5px;">' . $subheading . '</div><br />';
    }
    if ($showbutton) {
        $ret .= '<div style="text-align: right; margin-bottom: 10px;"><input type="button" name="button" onclick=\'location="' . basename($_SERVER['SCRIPT_FILENAME']) . '?op=edit"\' value="' . _AM_XOOPSFAQ_CREATENEW . '" /></div>';
    }
    echo $ret;
}

/**
 * xoopsFaq_cp_footer()
 *
 * @return
 */
function xoopsFaq_cp_footer()
{
    global $xoopsModule;

    echo "<div style='padding-top: 16px; padding-bottom: 10px; text-align: center;'>\n"
        ."  <a href='http://xoops.org' target='_blank'>" . xoopsFaq_showImage('xoopsmicrobutton', '', '', 'gif','modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/images/admin') . "</a>\n"
        ."  " . _AM_XOOPSFAQ_ADMIN_FOOTER . ""
        ."</div>";
    xoops_cp_footer();
}

/**
 * xoopsFaq_showImage()
 *
 * @param string $name
 * @param string $title
 * @param string $align
 * @param string $ext
 * @param string $path
 * @param string $size
 * @return
 */
function xoopsFaq_showImage($name = '', $title = '', $align = 'middle', $ext = 'png', $path = '', $size = '')
{
    if (empty($path)) {
        $path = 'modules/' . $GLOBALS['xoopsModule']->getVar('dirname') . '/images';
    }
    if (!empty($name)) {
        $fullpath = XOOPS_URL . '/' . $path . '/' . $name . '.' . $ext;
        $ret = '<img src="' . $fullpath . '" ';
        if (!empty($size)) {
            $ret = '<img src="' . $fullpath . '" ' . $size;
        }
        $ret .= ' title = "' . htmlspecialchars($title) . '"';
        $ret .= ' alt = "' . htmlspecialchars($title) . '"';
        if (!empty($align)) {
            $ret .= ' style="vertical-align: ' . $align . '; border: 0px;"';
        }
        $ret .= ' />';
        return $ret;
    } else {
        return '';
    }
}

/**
 * xoopsFaq_getIcons()
 *
 * @param array $_icon_array
 * @param mixed $key
 * @param mixed $value
 * @param mixed $extra
 * @return
 */
function xoopsFaq_getIcons($_icon_array = array(), $key, $value = null, $extra = null)
{
    $ret = '';
    if ($value) {
        foreach($_icon_array as $_op => $icon) {
            $url = (!is_numeric($_op)) ? $_op . "?{$key}=" . $value : xoops_getenv('PHP_SELF') . "?op={$icon}&amp;{$key}=" . $value;
            if ($extra != null) {
                $url .= $extra;
            }
            $ret .= '<a href="' . $url . '">' . xoopsFaq_showImage($icon, xoopsFaq_getConstants('_XO_LA_' . $icon), null, 'png') . '</a>';
        }
    }
    return $ret;
}

/**
 * xoopsFaq_getConstants()
 *
 * @param mixed $_title
 * @param string $prefix
 * @param string $suffix
 * @return
 */
function xoopsFaq_getConstants($_title, $prefix = '', $suffix = '')
{
    $prefix = ($prefix != '' || $_title != 'action') ? trim($prefix) : '';
    $suffix = trim($suffix);
    return constant(strtoupper("$prefix$_title$suffix"));
}

/**
 * xoopsFaq_isEditorHTML()
 *
 * @return bool
 */
function xoopsFaq_isEditorHTML()
{
    if (isset($GLOBALS['xoopsModuleConfig']['use_wysiwyg']) && in_array($GLOBALS['xoopsModuleConfig']['use_wysiwyg'], array('tinymce', 'ckeditor', 'inbetween', 'spaw'))) {
        return true;
    }
    return false;
}