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
 *  Publisher class
 *
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Publisher
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @author          John Neill <catzwolf@xoosla.com>
 * @version         $Id: themetabform.php 0 2009-06-11 18:47:04Z trabis $
 */

defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

include_once dirname(dirname(__FILE__)) . '/include/common.php';

/**
 * XoopsThemeTabForm
 *
 * @package
 * @author John
 * @copyright Copyright (c) 2009
 * @version $Id$
 * @access public
 */

class XoopsThemeTabForm extends XoopsForm
{
    var $_tabs;

    function XoopsThemeTabForm($title, $name, $action, $method = "post", $addtoken = false)
    {
        global $xoTheme;
        $xoTheme->addScript(PUBLISHER_URL . '/js/ui.core.js');
        $xoTheme->addScript(PUBLISHER_URL . '/js/ui.tabs.js');
        $xoTheme->addStylesheet(PUBLISHER_URL . '/css/jquery-ui-1.7.1.custom.css');

        parent::XoopsForm($title, $name, $action, $method, $addtoken);
    }

    /**
     * Insert an empty row in the table to serve as a seperator.
     *
     * @param string $extra HTML to be displayed in the empty row.
     * @param string $class CSS class name for <td> tag
     */
    /*function insertBreak( $extra = '', $class = '' )
     {
     $class = ($class != '') ? " class='" . htmlspecialchars( $class, ENT_QUOTES ) . "'" : '';
     // Fix for $extra tag not showing
     if ($extra) {
     $extra = "<tr><td colspan='2' $class>$extra</td></tr>";
     $this->addElement( $extra );
     } else {
     $extra = "<tr><td colspan='2' $class>&nbsp;</td></tr>";
     $this->addElement( $extra );
     }
     }  */

    /**
     * XoopsThemeTabForm::insertSplit()
     *
     * @param string $extra
     * @return
     */
    /*function insertSplit( $extra = '' )
     {
     $extra = ( $extra ) ? $extra : '&nbsp;';
     $ret = "<tr>\n<td colspan=\"2\" class=\"foot\">&nbsp;</td>\n</tr></table>\n<br />\n<br />\n
     <table width=\"100%\" class=\"outer\" cellspacing=\"1\">
     <tr>\n<th colspan=\"2\">$extra</th>\n</tr>\n";
     $this->addElement($extra);
     }
     */
    /**
     * create HTML to output the form as a theme-enabled table with validation.
     *
     * @return string
     */
    /*function render()
     {
     $ele_name = $this->getName();
     $ret = '';
     $ret = '<table><tr><th>' . $this->getTitle() . '</th></tr></table>';
     $ret .= "<form name='" . $ele_name . "' id='" . $ele_name . "' action='" . $this->getAction() . "' method='" . $this->getMethod() . "' onsubmit='return xoopsFormValidate_" . $ele_name . "();'" . $this->getExtra() . ">";
     $ret .= "<table width='100%' cellspacing='1'>";

     $ret .= "<tr><td colspan=\"2\">\n";
     $ret .= $this->_startPane( 'tab_' . $this->getTitle() );
     $hidden = '';
     $class = 'even';
     foreach ( $this->getElements() as $ele ) {
     if ( !is_object( $ele ) ) {
     $ret .= $ele;
     } elseif ( !$ele->isHidden() ) {
     if (  1==1 ) { //!$ele->getNocolspan()
     $ret .= "<tr valign='top' align='left'><td class='head' width='35%'>";
     if ( ( $caption = $ele->getCaption() ) != '' ) {
     $ret .= "<div class='xoops-form-element-caption" . ( $ele->isRequired() ? "-required" : "" ) . "'>"
     . "<span class='caption-text'>{$caption}</span>"
     . "<span class='caption-marker'>*</span>" . "</div>";
     }
     if ( ( $desc = $ele->getDescription() ) != '' ) {
     $ret .= "<div class='xoops-form-element-help'>{$desc}</div>";
     }
     $ret .= "</td><td class='$class'>" . $ele->render() . "</td></tr>\n";
     } else {
     $ret .= "<tr valign='top' align='left'><td class='head' colspan='2'>";
     if ( ( $caption = $ele->getCaption() ) != '' ) {
     $ret .= "<div class='xoops-form-element-caption" . ( $ele->isRequired() ? "-required" : "" ) . "'>"
     . "<span class='caption-text'>{$caption}</span>"
     . "<span class='caption-marker'>*</span>" . "</div>";
     }
     $ret .= "</td></tr><tr valign='top' align='left'><td class='$class' colspan='2'>" . $ele->render() . "</td></tr>";
     }
     } else {
     $hidden .= $ele->render();
     }
     }
     $ret .= $this->_endPane();
     $ret .= "</tr></table>\n$hidden\n</form>\n";
     $ret .= $this->renderValidationJS( true );
     return $ret;
     }
     */
    function assign(&$tpl)
    {
        $i = -1;
        $tab = -1;
        $elements = array();
        if (count($this->getRequired()) > 0) {
            $this->_elements[] = "<tr class='foot'><td colspan='2'>* = " . _REQUIRED . "</td></tr>";
        }
        foreach ( $this->getElements() as $ele ) {
            ++$i;

            if (is_string( $ele ) && $ele == 'addTab') {
                ++$tab;
                continue;
            }

            if (is_string( $ele ) && $ele == 'endTabs') {
                $tab = -1;
                continue;
            }

            if (is_string( $ele )) {
                $elements[$i]['body'] = $ele;
                $elements[$i]['tab'] = $tab;
                continue;
            }
            $ele_name = $ele->getName();
            $ele_description = $ele->getDescription();
            $n = $ele_name ? $ele_name : $i;
            $elements[$n]['name']       = $ele_name;
            $elements[$n]['caption']    = $ele->getCaption();
            $elements[$n]['body']       = $ele->render();
            $elements[$n]['hidden']     = $ele->isHidden() ? true : false;
            $elements[$n]['required']   = $ele->isRequired();

            if ($ele_description != '') {
                $elements[$n]['description']  = $ele_description;
            }
            $elements[$n]['tab'] = $tab;
        }
        $js = $this->renderValidationJS();
        $tpl->assign($this->getName(), array('title' => $this->getTitle(),
            'id' => 'tab_' . preg_replace('/[^a-z0-9]+/i', '', $this->getTitle()),
            'name' => $this->getName(),
            'action' => $this->getAction(),
            'method' => $this->getMethod(),
            'extra' => 'onsubmit="return xoopsFormValidate_'.$this->getName().'();"'.$this->getExtra(),
            'javascript' => $js,
            'tabs' => $this->_tabs,
            'elements' => $elements));
    }


    /**
     * XoopsThemeTabForm::startTab()
     *
     * @param mixed $tabText
     * @param mixed $paneid
     * @return
     */
    function startTab($tabText)
    {
        $this->addElement($this->_startTab($tabText));
    }

    /**
     * XoopsThemeTabForm::endTab()
     *
     * @return
     */
    function endTabs()
    {
        $this->addElement($this->_endTabs());
    }


    /**
     * Creates a tab with title text and starts that tabs page
     *
     * @param tabText $ - This is what is displayed on the tab
     * @param paneid $ - This is the parent pane to build this tab on
     */
    function _startTab($tabText)
    {
        $this->_tabs[] = $tabText;

        $ret = 'addTab';
        return $ret;
    }

    /**
     * Ends a tab page
     */
    function _endTabs()
    {
        $ret = 'endTabs';
        return $ret;
    }
}

?>