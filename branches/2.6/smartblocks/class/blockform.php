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
##  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            ##
##  GNU General Public License for more details.                             ##
##                                                                           ##
##  You should have received a copy of the GNU General Public License        ##
##  along with this program; if not, write to the Free Software              ##
##  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA ##
###############################################################################
include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
class SmartblocksBlockForm extends XoopsThemeForm {
    function createElements($target) {
        //        $plugin->doConfig($form);
        $this->addElement(new XoopsFormText(_SMARTBLOCKS_TITLE, 'title', 35, 255, $target->getVar('title', 'e')));
        $options = $target->block->getOptions();
        if ($options) {
            $this->addElement(new XoopsFormLabel(_SMARTBLOCKS_OPTIONS, $options));
        }

        // DATE
        $this->addElement(new XoopsFormDateTime(_SMARTBLOCKS_PUBLISHDATE, 'fromdate', 15, $target->getVar('fromdate', 'e')));
        $this->addElement(new XoopsFormDateTime(_SMARTBLOCKS_ENDDATE, 'todate', 15, $target->getVar('todate', 'e')));

        $always_select = new XoopsFormSelect(_SMARTBLOCKS_ALWAYSSHOW.":","alwayson",$target->getVar('showalways', 'e'));
        $always_select->addOption("yes",_SMARTBLOCKS_ALWAYS);
        $always_select->addOption("time",_SMARTBLOCKS_TIMEBASED);
        $always_select->addOption("no",_SMARTBLOCKS_OFF);

        $this->addElement($always_select);

        $placement = new XoopsFormSelect(_SMARTBLOCKS_PLACEMENT.":","placement",$target->getVar('placement', 'e'));
        $placement->addOption(1,_SMARTBLOCKS_LEFT);
        $placement->addOption(2,_SMARTBLOCKS_RIGHT);
        $placement->addOption(3,_SMARTBLOCKS_CENTER);
        $placement->addOption(4,_SMARTBLOCKS_CENTER_LEFT);
        $placement->addOption(5,_SMARTBLOCKS_CENTER_RIGHT);
        $placement->addOption(6,_SMARTBLOCKS_BCENTER);
        $placement->addOption(7,_SMARTBLOCKS_BCENTER_LEFT);
        $placement->addOption(8,_SMARTBLOCKS_BCENTER_RIGHT);
        $this->addElement($placement);

        $this->addElement(new XoopsFormText(_SMARTBLOCKS_PRIORITY.":","priority",4,5,$target->getVar('priority', 'e')));

        $falldown=&new XoopsFormCheckBox(_SMARTBLOCKS_FALLDOWN.":","falldown",$target->getVar('falldown', 'e'));
        $falldown->addOption(1,_YES);
        $this->addElement($falldown);

        $cachetime = new XoopsFormSelect(_SMARTBLOCKS_CACHETIME, 'pbcachetime', $target->getVar('pbcachetime', 'e'));
        $cache_options = array('0' => _NOCACHE,
                                '30' => sprintf(_SECONDS, 30), 
                                '60' => _MINUTE, 
                                '300' => sprintf(_MINUTES, 5), 
                                '1800' => sprintf(_MINUTES, 30), 
                                '3600' => _HOUR, 
                                '18000' => sprintf(_HOURS, 5), 
                                '86400' => _DAY, 
                                '259200' => sprintf(_DAYS, 3), 
                                '604800' => _WEEK);
        $cachetime->addOptionArray($cache_options);
        $this->addElement($cachetime);
        $this->addElement(new XoopsFormRadioYN(_SMARTBLOCKS_CACHEBYURL, 'cachebyurl', $target->getVar('cachebyurl', 'e')));


        $note=&new XoopsFormText(_SMARTBLOCKS_NOTE.":","note",50, 255, $target->getVar('note', 'e'));
        $this->addElement($note);

        $this->addElement(new XoopsFormSelectGroup(_SMARTBLOCKS_GROUPS, 'groups', true, $target->getVar('groups'), 8, true));

        if ($target->isNew() ) {
            $this->addElement(new XoopsFormHidden("blockid", $target->block->getVar('bid')));
            $this->addElement(new XoopsFormHidden("moduleid", $target->getVar('moduleid')));
            $this->addElement(new XoopsFormHidden("location", $target->getVar('location')));
        }
        $this->addElement(new XoopsFormHidden("pageblockid", $target->getVar('pageblockid')));
        $this->addElement(new XoopsFormHidden("op", "save"));

        $tray=&new XoopsFormElementTray("");
        $tray->addElement(new XoopsFormButton("", "submit", _SMARTBLOCKS_OK, "submit"));

        $cancel=&new XoopsFormButton("","cancel", _SMARTBLOCKS_CANCEL, "button");
        $cancel->setExtra("onclick=\"self.location='page.php?location=".$target->getVar('location')."&moduleid=".$target->getVar('moduleid')."';\"");
        $tray->addElement($cancel);

        $this->addElement($tray);
    }
}
?>