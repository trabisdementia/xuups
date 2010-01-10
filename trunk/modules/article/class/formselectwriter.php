<?php
/**
 * Article module for XOOPS
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
 * @package         article
 * @since           1.0
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: formselectwriter.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
if (!defined('XOOPS_ROOT_PATH')) {
    die("XOOPS root path not defined");
}

// Limitation: Only work with javascript enabled

// RMV-NOTIFY

/**
 * A select field with a choice of available authors
 *
 * @package     Article
 *
 * @author        D.J.(phppp)
 * @copyright    copyright (c) 2000-2005 XOOPS.org
 */
class XoopsFormSelectWriter extends XoopsFormElementTray
{
    /**
     * Constructor
     *
     * @param    string    $caption
     * @param    string    $name
     * @param    mixed    $value            Pre-selected value
     */
    function XoopsFormSelectWriter($caption, $name, $value = array())
    {
        $this->XoopsFormElementTray($caption, " | ", $name);

        $select_form = new XoopsFormSelect("", $name, $value, $size = 1, $multiple = false);
        if (!empty($value)) {
            if (!is_array($value)) {
                $value = array($value);
            }
            $criteria = new CriteriaCompo(new Criteria("writer_id", "(" . implode(", ", $value) . ")", "IN"));
            $criteria->setSort('writer_name');
            $criteria->setOrder('ASC');
            $writer_handler =& xoops_getmodulehandler("writer", $GLOBALS["artdirname"]);
            $select_form->addOptionArray($writer_handler->getList($criteria));
        }

        $action_tray = new XoopsFormElementTray("", " | ");
        //$action_tray->addElement(new XoopsFormLabel('', "<a href='".XOOPS_URL."/modules/".$GLOBALS["artdirname"]."/edit.writer.php?search=1&amp;target=".$name."' target='writereditor'>"._SEARCH."</a>"));
        $action_tray->addElement(new XoopsFormLabel('', "<a href='###' onclick='return openWithSelfMain(\"" . XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/edit.writer.php?search=1\", \"writereditor\", 800, 500, null);' >" . _SEARCH . "</a>"));
        $action_tray->addElement(new XoopsFormLabel('', "<a href='###' onclick='var sel = xoopsGetElementById(\"" . $name . "\");for (var i = sel.options.length-1; i >= 0; i--) {if (sel.options[i].selected) {sel.options[i] = null;}}'>" . art_constant("MD_REMOVE") . "</a>".
            "<script type=\"text/javascript\">
            function addusers(opts) {
                var num = opts.substring(0, opts.indexOf(\":\"));
                opts = opts.substring(opts.indexOf(\":\")+1, opts.length);
                var sel = xoopsGetElementById(\"" . $name . "\");
                var arr = new Array(num);
                for (var n = 0; n < num; n++) {
                    var nm = opts.substring(0, opts.indexOf(\":\"));
                    opts = opts.substring(opts.indexOf(\":\")+1, opts.length);
                    var val = opts.substring(0, opts.indexOf(\":\"));
                    opts = opts.substring(opts.indexOf(\":\")+1, opts.length);
                    var txt = opts.substring(0, nm - val.length);
                    opts = opts.substring(nm - val.length, opts.length);
                    var added = false;
                    for (var k = 0; k < sel.options.length; k++) {
                        if (sel.options[k].value == val) {
                            added = true;
                            sel.options[k].selected = true;
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
            </script>"
            ));

        $this->addElement($select_form);
        $this->addElement($action_tray);
    }
}
?>