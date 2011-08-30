<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Xmf
 * @since           0.1
 * @author          Grégory Mage (Aka Mage)
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

class Xmf_Template_Adminindex extends Xmf_Template_Abstract
{

    var $_itemButton = array();
    var $_infoBox = array();
    var $_configBox = array();
    var $_obj = array();

    /**
     * Constructor
     */
    function __construct(XoopsModule $module)
    {
        parent::__construct($this);
        //$this->setTemplate(XMF_ROOT_PATH . '/templates/xmf_admin.html');
        $this->_obj =& $module;

        xoops_loadLanguage('main', 'xmf');
        if (is_object($GLOBALS['xoTheme'])) {
            $GLOBALS['xoTheme']->addStylesheet(XMF_CSS_URL . '/admin.css');
        }
    }

    function getInfo()
    {
       $infoArray = array();
        if (!isset($infoArray) or empty($infoArray)) {
            $infoArray = array();
            $infoArray['version'] = $this->getVersion();
            $infoArray['releasedate'] = $this->getReleaseDate();
            $infoArray['methods'] = $this->getClassMethods();
        }
        return $infoArray;
    }

    /**
     * Return the Module Admin class version number
     * return string version
     **/
    function getVersion()
    {
        /**
         * version is rev of this class
         */
        Include_once 'xoops_version.php';
        $version = XOOPS_FRAMEWORKS_MODULEADMIN_VERSION;
        return $version;
    }

    /**
     * Return the Module Admin class release date
     * return string version
     **/
    function getReleaseDate()
    {
        /**
         * version is rev of this class
         */
        Include_once 'xoops_version.php';
        $releasedate = XOOPS_FRAMEWORKS_MODULEADMIN_RELEASEDATE;
        return $releasedate;
    }

    /**
     * Return the available methods for the class
     *
     * @return array methods supported by this class
     */
    function getClassMethods()
    {
        $myMethods = get_class_methods(__CLASS__);
        return $myMethods;
    }

    //******************************************************************************************************************
    // renderMenuIndex
    //******************************************************************************************************************
    // Creating a menu icon in the index
    //******************************************************************************************************************
    function renderMenuIndex()
    {
        $path = XOOPS_URL . "/modules/" . $this->_obj->getVar('dirname') . "/";
        $pathsystem = XOOPS_URL . "/modules/system/";
        $this->_obj->loadAdminMenu();
        $ret = "<div class=\"rmmenuicon\">\n";
        foreach (array_keys( $this->_obj->adminmenu) as $i) {
            if ($this->_obj->adminmenu[$i]['link'] != 'admin/index.php'){
                $ret .= "<a href=\"../" . $this->_obj->adminmenu[$i]['link'] . "\" title=\"" . $this->_obj->adminmenu[$i]['title'] . "\">";
                $ret .= "<img src=\"" . $path . $this->_obj->adminmenu[$i]['icon']. "\" alt=\"" . $this->_obj->adminmenu[$i]['title'] . "\" />";
                $ret .= "<span>" . $this->_obj->adminmenu[$i]['title'] . "</span>";
                $ret .= "</a>";
            }
        }
        if ($this->_obj->getInfo('help')) {
            if (substr(XOOPS_VERSION, 0, 9) >= 'XOOPS 2.5'){
                $ret .= "<a href=\"" . $pathsystem . "help.php?mid=" . $this->_obj->getVar('mid', 's') . "&amp;" . $this->_obj->getInfo('help') . "\" title=\"" . _AM_SYSTEM_HELP . "\">";
                $ret .= "<img width=\"32px\" src=\"" . XMF_IMAGES_URL . "/icons/32/help.png\" alt=\"" . _AM_SYSTEM_HELP . "\" /> ";
                $ret .= "<span>" . _AM_SYSTEM_HELP . "</span>";
                $ret .= "</a>";
            }
        }
        $ret .= "</div>\n<div style=\"clear: both;\"></div>\n";
        return $ret;
    }
    //******************************************************************************************************************
    // renderButton
    //******************************************************************************************************************
    // Creating button
    //******************************************************************************************************************
    function renderButton($position = "right", $delimeter = "&nbsp;")
    {
        $path = XMF_IMAGES_URL . "/icons/32/";
        switch ($position)
        {
            default:
            case "right":
                $ret = "<div class=\"floatright\">\n";
                break;

            case "left":
                $ret = "<div class=\"floatleft\">\n";
                break;

            case "center":
                $ret = "<div class=\"aligncenter\">\n";
        }
        $ret .= "<div class=\"xo-buttons\">\n";
        foreach (array_keys( $this -> _itemButton) as $i) {
            $ret .= "<a class='ui-corner-all tooltip' href='" . $this -> _itemButton[$i]['link'] . "' title='" . $this -> _itemButton[$i]['title'] . "'>";
            $ret .= "<img src='" . $path . $this -> _itemButton[$i]['icon'] . "' title='" . $this -> _itemButton[$i]['title'] . "' />" . $this -> _itemButton[$i]['title'] . ' ' . $this -> _itemButton[$i]['extra'];
            $ret .= "</a>\n";
            $ret .= $delimeter;
        }
        $ret .= "</div>\n</div>\n";
        $ret .= "<br />&nbsp;<br /><br />";
        return $ret;
    }

    function addInfoBox(XMf_Template_Infobox $infoBox)
    {
        $this->_infoBox[] = $infoBox;
    }

    function addConfigBox(XMf_Template_Configbox $configBox)
    {
        $this->_configBox[] = $configBox;
    }

    function renderInfoBox()
    {
        $ret = "";
        foreach ($this->_infoBox as $item) {
            $ret .= $item->fetch();
        }
        return $ret;
    }

    function renderConfigBox()
    {
        $ret = "";
        foreach ($this->_configBox as $item) {
            $ret .= $item->fetch();
        }
        return $ret;
    }

    function addItemButton($title, $link, $icon = 'add', $extra = '')
    {
        $ret['title'] = $title;
        $ret['link'] = $link;
        $ret['icon'] = $icon . '.png';
        $ret['extra'] = $extra;
        $this -> _itemButton[] = $ret;
        return true;

    }

    //******************************************************************************************************************
    // renderIndex
    //******************************************************************************************************************
    // Creating an index
    //******************************************************************************************************************
    function render()
    {
        $ret = "<table>\n<tr>\n";
        $ret .= "<td width=\"40%\">\n";
        $ret .= $this -> renderMenuIndex();
        $ret .= "</td>\n";
        $ret .= "<td width=\"60%\">\n";
        $ret .= $this -> renderInfoBox();
        $ret .= "</td>\n";
        $ret .= "</tr>\n";
        // If you use a config label
        if ($this->_obj->getInfo('min_php') || $this->_obj->getInfo('min_xoops') || !empty($this -> _itemConfigBoxLine)){
            $ret .= "<tr>\n";
            $ret .= "<td colspan=\"2\">\n";
            $ret .= "<fieldset><legend class=\"label\">";
            $ret .= _AM_XMF_CONFIG;
            $ret .= "</legend>\n";
            // php version
            $path = XMF_IMAGES_URL . "/icons/16/";
            if ($this->_obj->getInfo('min_php')){
                if (phpversion() < $this->_obj->getInfo('min_php')){
                    $ret .= "<span style='color : red; font-weight : bold;'><img src='" . $path . "off.png' >" . sprintf(_AM_XMF_CONFIG_PHP, $this->_obj->getInfo('min_php'), phpversion()) . "</span>\n";
                }else{
                    $ret .= "<span style='color : green;'><img src='" . $path . "on.png' >" . sprintf(_AM_XMF_CONFIG_PHP, $this->_obj->getInfo('min_php'), phpversion()) . "</span>\n";
                }
                $ret .= "<br />";
            }
            // xoops version
            if ($this->_obj->getInfo('min_xoops')){
                if (substr(XOOPS_VERSION, 6, strlen(XOOPS_VERSION)-6) < $this->_obj->getInfo('min_xoops')){
                    $ret .= "<span style='color : red; font-weight : bold;'><img src='" . $path . "off.png' >" . sprintf(_AM_XMF_CONFIG_XOOPS, $this->_obj->getInfo('min_xoops'), substr(XOOPS_VERSION, 6, strlen(XOOPS_VERSION)-6)) . "</span>\n";
                }else{
                    $ret .= "<span style='color : green;'><img src='" . $path . "on.png' >" . sprintf(_AM_XMF_CONFIG_XOOPS, $this->_obj->getInfo('min_xoops'), substr(XOOPS_VERSION, 6, strlen(XOOPS_VERSION)-6)) . "</span>\n";
                }
                $ret .= "<br />";
            }
            $ret .= $this->renderConfigBox();

            $ret .= "</fieldset>\n";
            $ret .= "</td>\n";
            $ret .= "</tr>\n";
        }
        $ret .= "</table>\n";

        return $this->tpl->assign('dummy_content', $ret);
    }

}
?>