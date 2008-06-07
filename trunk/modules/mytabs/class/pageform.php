<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

include_once(XOOPS_ROOT_PATH."/class/xoopsformloader.php");
class MytabspageForm extends XoopsThemeForm {
    function createElements($target) {
        $this->addElement(new XoopsFormText(_AM_MYTABS_TITLE, 'pagetitle', 35, 255, $target->getVar('pagetitle', 'e')));

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
