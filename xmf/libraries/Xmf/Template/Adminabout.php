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
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

class Xmf_Template_Adminabout extends Xmf_Template_Abstract
{
    var $module;
    var $paypal;
    var $logoImageUrl;
    var $logoLinkUrl;

    var $_lang_aboutTitle;
    var $_lang_author_info;
    var $_lang_developer_lead;
    var $_lang_developer_contributor;
    var $_lang_developer_website;
    var $_lang_developer_email;
    var $_lang_developer_credits;
    var $_lang_module_info;
    var $_lang_module_status;
    var $_lang_module_release_date;
    var $_lang_module_demo;
    var $_lang_module_support;
    var $_lang_module_bug;
    var $_lang_module_submit_bug;
    var $_lang_module_feature;
    var $_lang_module_submit_feature;
    var $_lang_module_disclaimer;
    var $_lang_author_word;
    var $_lang_version_history;
    var $_lang_by;

    function __construct(XoopsModule $module)
    {
        parent::__construct($this);
        $this->setTemplate(XOOPS_ROOT_PATH . '/modules/xmf/templates/xmf_adminabout.html');
        $this->module =& $module;
        $this->paypal = '6KJ7RW5DR3VTJ'; //Xoops Foundation used by default
        $this->logoLinkUrl = 'http://wwww.xoops.org';
        $this->logoImageUrl = XMF_IMAGES_URL . '/icons/32/xoopsmicrobutton.gif';
    }

    function setPaypal($value)
    {
        $this->paypal = $value;
    }

    function setLogoImageUrl($value)
    {
        $this->logoImageUrl = $value;
    }

    function setLogoLinkUrl($value)
    {
        $this->logoLinkUrl = $value;
    }

    function render()
    {
        Xmf_Language::load('about', 'xmf');
        Xmf_Language::load('modinfo', $this->module->getVar('dirname'));
        if (is_object($GLOBALS['xoTheme'])) {
            $GLOBALS['xoTheme']->addStylesheet(XMF_CSS_URL . '/admin.css');
        }

        $this->tpl->assign('module_paypal', $this->paypal);

        $this->tpl->assign('module_url', XOOPS_URL . "/modules/" . $this->module->getVar('dirname') . "/");
        $this->tpl->assign('module_image', $this->module->getInfo('image'));
        $this->tpl->assign('module_name', $this->module->getInfo('name'));
        $this->tpl->assign('module_version', $this->module->getInfo('version'));
        $this->tpl->assign('module_description', $this->module->getInfo('description'));
        $this->tpl->assign('module_status_version', $this->module->getInfo('status_version'));

        // Left headings...
        if ($this->module->getInfo('author_realname') != '') {
            $author_name = $this->module->getInfo('author') . " (" . $this->module->getInfo('author_realname') . ")";
        } else {
            $author_name = $this->module->getInfo('author');
        }

        $this->tpl->assign('module_author_name', $author_name);
        $this->tpl->assign('module_license', $this->module->getInfo('license'));
        $this->tpl->assign('module_credits', $this->module->getInfo('credits'));

        // Developers Information
        $this->tpl->assign('module_developer_lead', $this->module->getInfo('developer_lead'));
        $this->tpl->assign('module_developer_contributor', $this->module->getInfo('developer_contributor'));
        $this->tpl->assign('module_developer_website_url', $this->module->getInfo('developer_website_url'));
        $this->tpl->assign('module_developer_website_name', $this->module->getInfo('developer_website_name'));
        $this->tpl->assign('module_developer_email', $this->module->getInfo('developer_email'));

        $people = $this->module->getInfo('people');
        if ($people) {
            $this->tpl->assign('module_people_developers', isset($people['developers']) ? array_map(array($this, '_sanitize'), $people['developers']) : false);
            $this->tpl->assign('module_people_testers', isset($people['testers']) ? array_map(array($this, '_sanitize'), $people['testers']) : false);
            $this->tpl->assign('module_people_translators', isset($people['translators']) ? array_map(array($this, '_sanitize'), $people['translators']) : false);
            $this->tpl->assign('module_people_documenters', isset($people['documenters']) ? array_map(array($this, '_sanitize'), $people['documenters']) : false);
            $this->tpl->assign('module_people_other', isset($people['other']) ? array_map(array($this, '_sanitize'), $people['other']) : false);
        }
        //$this->_tpl->assign('module_developers', $this->module->getInfo('developer_email'));

        // Module Development information
        $this->tpl->assign('module_date', $this->module->getInfo('date'));
        $this->tpl->assign('module_status', $this->module->getInfo('status'));
        $this->tpl->assign('module_demo_site_url', $this->module->getInfo('demo_site_url'));
        $this->tpl->assign('module_demo_site_name', $this->module->getInfo('demo_site_name'));
        $this->tpl->assign('module_support_site_url', $this->module->getInfo('support_site_url'));
        $this->tpl->assign('module_support_site_name', $this->module->getInfo('support_site_name'));
        $this->tpl->assign('module_submit_bug', $this->module->getInfo('submit_bug'));
        $this->tpl->assign('module_submit_feature', $this->module->getInfo('submit_feature'));

        // Warning
        $this->tpl->assign('module_warning', $this->_sanitize($this->module->getInfo('warning')));

        // Author's note
        $this->tpl->assign('module_author_word', $this->module->getInfo('author_word'));

        // For changelog thanks to 3Dev
        $filename = XOOPS_ROOT_PATH . '/modules/' . $this->module->getVar('dirname') . '/changelog.txt';
        if (is_file($filename)) {
            $filesize = filesize($filename);
            $handle = fopen($filename, 'r');
            $this->tpl->assign('module_version_history', $this->_sanitize(fread($handle, $filesize)));
            fclose($handle);
        }

        if ($this->logoImageUrl && $this->logoLinkUrl){
            $this->tpl->assign('logo_image_url', $this->logoImageUrl);
            $this->tpl->assign('logo_link_url', $this->logoLinkUrl);

        }
    }

    function _sanitize($value)
    {
        $myts =& Xmf_Sanitizer::getInstance();
        return $myts->displayTarea($value, 1);
    }

}