<?php
$form = new XoopsThemeForm(_AM_SCLONE_CLONE_A_MODULE, "form", xoops_getenv('PHP_SELF'));
$form->setExtra( "enctype='multipart/form-data'" ) ;

$module_select = new XoopsFormSelect('', 'module', '', 1, false);
$plugins_handler = new SmartclonePlugins();
$module_select->addOptionArray($plugins_handler->getPluginsArray());

$plugins_tray = new XoopsFormElementTray(_AM_SCLONE_MODULE_SELECT, '');
$plugins_tray->setDescription(_AM_SCLONE_MODULE_SELECT_DSC);
$plugins_tray->addElement($module_select, true);

include_once(SMARTOBJECT_ROOT_PATH . 'class/smarttip.php');
$oTip = new SmartTip('smartclone_info1', _AM_SCLONE_WHERE_OTHER_MODULE, _AM_SCLONE_WHERE_OTHER_MODULE_EXP);
$module_selec_tip = new XoopsFormLabel('', $oTip->render(false));
$plugins_tray->addElement($module_selec_tip);

$form->addElement($plugins_tray);

$newname_text = new XoopsFormText(_AM_SCLONE_NEWNAME, 'newname', 50, 255, '');
$newname_text->setDescription(_AM_SCLONE_NEWNAME_DSC);
$form->addElement($newname_text, true);

$install_check = new XoopsFormRadioYN(_AM_SCLONE_INSTALL_CHECK, 'install', true);
$form->addElement($install_check);

$form_button_tray = new XoopsFormElementTray('', '');
$form_hidden = new XoopsFormHidden('op', '');
$form_button_tray->addElement($form_hidden);

$form_butt_create = new XoopsFormButton('', '', _GO, 'submit');
$form_butt_create->setExtra('onclick="this.form.elements.op.value=\'doclone\'"');
$form_button_tray->addElement($form_butt_create);

$butt_cancel = new XoopsFormButton('', '', _CANCEL, 'button');
$butt_cancel->setExtra('onclick="history.go(-1)"');
$form_button_tray->addElement($butt_cancel);

$form->addElement($form_button_tray);

$form->display();
?>
