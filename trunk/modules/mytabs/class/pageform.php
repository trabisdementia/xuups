<?php
// $Id: blockform.php,v 1.1 2006/12/07 19:55:27 malanciault Exp $
###############################################################################
##                    XOOPS - PHP Content Management System                  ##
##                       Copyright (c) 2000 XOOPS.org                        ##
##                          <http://www.xoops.org/>                          ##
###############################################################################
##  This program is free software; you can redistribute it and/or modify     ##
##  it under the terms of the GNU General Public License as published by     ##
##  the Free Software Foundation; either version 2 of the License, or        ##
##  (at your option) any later version.                                      ##
##                                                                           ##
##  You may not change or alter any portion of this comment or credits       ##
##  of supporting developers from this source code or any supporting         ##
##  source code which is considered copyrighted (c) material of the          ##
##  original comment or credit authors.                                      ##
##                                                                           ##
##  This program is distributed in the hope that it will be useful,          ##
##  but WITHOUT ANY WARRANTY; without even the implied warranty of           ##
##  MERCHANpageILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            ##
##  GNU General Public License for more details.                             ##
##                                                                           ##
##  You should have received a copy of the GNU General Public License        ##
##  along with this program; if not, write to the Free Software              ##
##  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA ##
###############################################################################
include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
class MytabspageForm extends XoopsThemeForm {
    function createElements($target) {
        $this->addElement(new XoopsFormText(_AM_MYTABS_TITLE, 'pagetitle', 35, 255, $target->getVar('pagetitle', 'e')));

        // DATE
       /* $this->addElement(new XoopsFormDateTime(_AM_MYTABS_PUBLISHDATE, 'fromdate', 15, $target->getVar('fromdate', 'e')));
        $this->addElement(new XoopsFormDateTime(_AM_MYTABS_ENDDATE, 'todate', 15, $target->getVar('todate', 'e')));

        $always_select = new XoopsFormSelect(_AM_MYTABS_ALWAYSSHOW.":","alwayson",$target->getVar('showalways', 'e'));
        $always_select->addOption("yes",_AM_MYTABS_ALWAYS);
        $always_select->addOption("time",_AM_MYTABS_TIMEBASED);
        $always_select->addOption("no",_AM_MYTABS_OFF);

        $this->addElement($always_select);     */
         /*
        $placement = new XoopsFormSelect(_AM_MYTABS_PLACEMENT.":","pageid",$target->getVar('pageid', 'e'));
        $this->addElement($placement);*/

       // $this->addElement(new XoopsFormText(_AM_MYTABS_PRIORITY.":","pageorder",4,5,$target->getVar('pageorder', 'e')));


      //  $this->addElement(new XoopsFormSelectGroup(_AM_MYTABS_GROUPS, 'pagegroups', true, $target->getVar('pagegroups'), 8, true));

        if (!$target->isNew() ) {
            $this->addElement(new XoopsFormHidden("pageid", $target->getVar('pageid')));
        }
        $this->addElement(new XoopsFormHidden("op", "save"));

        $tray=&new XoopsFormElementTray("");
        $tray->addElement(new XoopsFormButton("", "submit", _AM_MYTABS_OK, "submit"));

        $cancel=&new XoopsFormButton("","cancel", _AM_MYTABS_CANCEL, "button");
        $cancel->setExtra("onclick=\"self.location='index.php?pageid=".$target->getVar('pageid')."';\"");
        $tray->addElement($cancel);

        $this->addElement($tray);
    }
}
?>
