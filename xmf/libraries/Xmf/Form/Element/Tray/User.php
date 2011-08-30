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
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

/**
 * user select with page navigation
 *
 * limit: Only work with javascript enabled
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         kernel
 * @subpackage      form
 * @since           2.0.0
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id$
 */

class Xmf_Form_Element_Tray_User extends Xmf_Form_Element_Tray
{
    /**
     * Constructor
     *
     * @param    string    $caption
     * @param    string    $name
     * @param    mixed    $value            Pre-selected value (or array of them).
     *                                    For an item with massive members, such as "Registered Users", "$value" should be used to store selected temporary users only instead of all members of that item
     * @param    bool    $include_anon    Include user "anonymous"?
     * @param    int        $size            Number or rows. "1" makes a drop-down-list.
     * @param    bool    $multiple       Allow multiple selections?
     */
    function __construct($caption, $name, $include_anon = false, $value = null, $size = 1, $multiple = false)
    {
        $limit = 200;
        $select_element = new Xmf_Form_Element_Select("", $name, $value, $size, $multiple);
        if ($include_anon) {
            $select_element->addOption(0, $GLOBALS["xoopsConfig"]['anonymous']);
        }
        $member_handler =& xoops_gethandler('member');
        $user_count = $member_handler->getUserCount();
        $value = is_array($value) ? $value : ( empty($value) ? array() : array($value) );
        if ($user_count > $limit && count($value) > 0) {
            $criteria = new CriteriaCompo(new Criteria("uid", "(".implode(",", $value).")", "IN"));
        } else {
            $criteria = new CriteriaCompo();
            $criteria->setLimit($limit);
        }
        $criteria->setSort('uname');
        $criteria->setOrder('ASC');
        $users = $member_handler->getUserList($criteria);
        $select_element->addOptionArray($users);
        if ($user_count <= $limit) {
            parent::__construct($caption, "", $name);
            $this->addElement($select_element);
            return;
        }

        xoops_loadLanguage("findusers");

        $js_addusers =
            "<script type=\"text/javascript\">
            function addusers(opts){
                var num = opts.substring(0, opts.indexOf(\":\"));
                opts = opts.substring(opts.indexOf(\":\")+1, opts.length);
                var sel = xoopsGetElementById(\"". $name . ($multiple ? "[]" : "") . "\");
                var arr = new Array(num);
                for (var n=0; n < num; n++) {
                    var nm = opts.substring(0, opts.indexOf(\":\"));
                    opts = opts.substring(opts.indexOf(\":\")+1, opts.length);
                    var val = opts.substring(0, opts.indexOf(\":\"));
                    opts = opts.substring(opts.indexOf(\":\")+1, opts.length);
                    var txt = opts.substring(0, nm - val.length);
                    opts = opts.substring(nm - val.length, opts.length);
                    var added = false;
                    for (var k = 0; k < sel.options.length; k++) {
                        if(sel.options[k].value == val){
                            added = true;
                            break;
                        }
                    }
                    if (added == false) {
                        sel.options[k] = new Option(txt, val);
                        sel.options[k].selected = true;
                    }
                }
                return true;
            }
            </script>";

        $token = $GLOBALS['xoopsSecurity']->createToken();
        $action_tray = new Xmf_Form_Element_Tray("", " | ");
        $action_tray->addElement(new Xmf_Form_Element_Label('', "<a href='#' onclick='var sel = xoopsGetElementById(\"" . $name . ( $multiple ? "[]" : "" ) . "\");for (var i = sel.options.length-1; i >= 0; i--) {if (!sel.options[i].selected) {sel.options[i] = null;}}; return false;'>" . _MA_USER_REMOVE . "</a>"));
        $action_tray->addElement(new Xmf_Form_Element_Label('', "<a href='#' onclick='openWithSelfMain(\"" . XOOPS_URL . "/include/findusers.php?target={$name}&amp;multiple={$multiple}&amp;token={$token}\", \"userselect\", 800, 600, null); return false;' >" . _MA_USER_MORE . "</a>" . $js_addusers));

        parent::__construct($caption, "<br /><br />", $name);
        $this->addElement($select_element);
        $this->addElement($action_tray);
    }
}