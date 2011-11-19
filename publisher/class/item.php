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
 * @package         Publisher
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id$
 */

defined("XOOPS_ROOT_PATH") or die("XOOPS root path not defined");

include_once dirname(dirname(__FILE__)) . '/include/common.php';

class PublisherItem extends XoopsObject
{
    /**
     * @var Xmf_Module_Helper
     */
    private $_publisher = null;

    /**
     * @var PublisherHandler
     */
    private $_handler = null;

    /**
     * @var PublisherCategory
     */
    private $_category = null;

    /**
     * @var array
     */
    private $_groups_read = null;

    /**
     * @param int|null $id
     */
    public function __construct($id = null)
    {

        $this->_publisher = Xmf_Module_Helper::getInstance(PUBLISHER_DIRNAME);
        $this->_handler = new PublisherHandler();

        $this->initVar("itemid", XOBJ_DTYPE_INT, 0);
        $this->initVar("categoryid", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("title", XOBJ_DTYPE_TXTBOX, '', true, 255);
        $this->initVar("subtitle", XOBJ_DTYPE_TXTBOX, '', false, 255);
        $this->initVar("summary", XOBJ_DTYPE_TXTAREA, '', false);
        //$this->initVar("display_summary", XOBJ_DTYPE_INT, 1, false);
        $this->initVar("body", XOBJ_DTYPE_TXTAREA, '', false);
        $this->initVar("uid", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("author_alias", XOBJ_DTYPE_TXTBOX, '', false, 255);
        $this->initVar("datesub", XOBJ_DTYPE_INT, '', false);
        $this->initVar("status", XOBJ_DTYPE_INT, -1, false);
        $this->initVar("image", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("images", XOBJ_DTYPE_TXTBOX, '', false, 255);
        $this->initVar("counter", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("rating", XOBJ_DTYPE_OTHER, 0, false);
        $this->initVar("votes", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("weight", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("partial_view", XOBJ_DTYPE_TXTBOX, '', false);
        $this->initVar("dohtml", XOBJ_DTYPE_INT, 1, true);
        $this->initVar("dosmiley", XOBJ_DTYPE_INT, 1, true);
        $this->initVar("doimage", XOBJ_DTYPE_INT, 1, true);
        $this->initVar("dobr", XOBJ_DTYPE_INT, 1, false);
        $this->initVar("doxcode", XOBJ_DTYPE_INT, 1, true);
        $this->initVar("cancomment", XOBJ_DTYPE_INT, 1, true);
        $this->initVar("comments", XOBJ_DTYPE_INT, 0, false);
        $this->initVar("notifypub", XOBJ_DTYPE_INT, 1, false);
        $this->initVar("meta_keywords", XOBJ_DTYPE_TXTAREA, '', false);
        $this->initVar("meta_description", XOBJ_DTYPE_TXTAREA, '', false);
        $this->initVar("short_url", XOBJ_DTYPE_TXTBOX, '', false, 255);
        $this->initVar("item_tag", XOBJ_DTYPE_TXTAREA, '', false);

        // Non consistent values
        $this->initVar("pagescount", XOBJ_DTYPE_INT, 0, false);

        if (isset($id)) {
            $item = $this->_handler->item()->get($id);
            foreach ($item->vars as $k => $v) {
                $this->assignVar($k, $v['value']);
            }
            $this->assignOtherProperties();
        }
    }

    /**
     * Allows $this->getVar('var', 's') using $this->var('s')
     *
     * @param string $method
     * @param array $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        $arg = isset($args[0]) ? $args[0] : null;
        return $this->getVar($method, $arg);
    }


    /**
     * @return void
     */
    public function assignOtherProperties()
    {
        $publisher_allCategoriesObj = $this->_handler->category()->getAllCategoriesObj();
        $this->_category = $publisher_allCategoriesObj[$this->getVar('categoryid')];
        $this->_groups_read = $this->_handler->permission()->getGrantedGroups('item_read', $this->getVar('itemid'));
    }

    /**
     * @return bool
     */
    public function checkPermission()
    {
        global $publisher_isAdmin;
        $ret = false;

        if ($publisher_isAdmin) {
            return true;
        }

        $itemsGranted = $this->_handler->permission()->getGrantedItems('item_read');

        if (in_array($this->getVar('itemid'), $itemsGranted)) {
            $ret = true;
        }

        return $ret;
    }

    /**
     * @return array|null
     */
    public function getGroups_read()
    {
        if (count($this->_groups_read) < 1) {
            $this->assignOtherProperties();
        }
        return $this->_groups_read;
    }

    /**
     * @param array $groups_read
     * @return void
     */
    public function setGroups_read($groups_read = array('0'))
    {
        $this->_groups_read = $groups_read;
    }

    /**
     * @return null|PublisherCategory
     */
    public function category()
    {
        if (!isset($this->_category)) {
            $this->_category = $this->_handler->category()->get($this->getVar('categoryid'));
        }
        return $this->_category;
    }

    /**
     * @param PublisherCategory|null $category
     * @return void
     */
    public function setCategory(PublisherCategory $category = null)
    {
        $this->_category = $category;
    }

    /**
     * @param int $maxLength
     * @param string $format
     * @return mixed|string
     */
    public function title($maxLength = 0, $format = "S")
    {
        $ret = $this->getVar("title", $format);

        if ($maxLength != 0) {
            XoopsLoad::load('XoopsLocal');
            $ret = XoopsLocal::substr($ret, 0, $maxLength);
        }

        return $ret;
    }

    /**
     * @param int $maxLength
     * @param string $format
     * @return mixed|string
     */
    public function subtitle($maxLength = 0, $format = "S")
    {
        $ret = $this->getVar("subtitle", $format);

        if ($maxLength != 0) {
            XoopsLoad::load('XoopsLocal');
            $ret = XoopsLocal::substr($ret, 0, $maxLength);
        }

        return $ret;
    }

    /**
     * @param int $maxLength
     * @param string $format
     * @param string $stripTags
     * @return mixed|string
     */
    public function summary($maxLength = 0, $format = "S", $stripTags = '')
    {
        $ret = $this->getVar("summary", $format);

        if (!empty($stripTags)) {
            $ret = strip_tags($ret, $stripTags);
        }

        if ($maxLength != 0) {
            if (!XOOPS_USE_MULTIBYTES) {
                if (strlen($ret) >= $maxLength) {}
            }
        }

        return $ret;
    }

    /**
     * @param int $maxLength
     * @param bool $fullSummary
     * @return mixed|string
     */
    public function getBlockSummary($maxLength = 0, $fullSummary = false)
    {
        if ($fullSummary) {
            $ret = $this->summary(0, 's', '<br></ br>');
        } else {
            $ret = $this->summary($maxLength, 's', '<br></ br>');
        }

        //no summary? get body!
        if (strlen($ret) == 0) {
            $ret = $this->body($maxLength, 's', '<br></ br>');
        }

        return $ret;
    }

    /**
     * @param $file_name
     * @return string
     */
    public function wrappage($file_name)
    {
        $content = '';
        $page = publisher_getUploadDir(true, 'content') . $file_name;
        if (file_exists($page)) {
            // this page uses smarty template
            ob_start();
            include($page);
            $content = ob_get_contents();
            ob_end_clean();

            // Cleaning the content
            $body_start_pos = strpos($content, '<body>');
            if ($body_start_pos) {
                $body_end_pos = strpos($content, '</body>', $body_start_pos);
                $content = substr($content, $body_start_pos + strlen('<body>'), $body_end_pos - strlen('<body>') - $body_start_pos);
            }
        }

        return $content;
    }

    /**
     * This method returns the body to be displayed. Not to be used for editing
     *
     * @param int $maxLength
     * @param string $format
     * @param string $stripTags
     * @return mixed|string
     */
    public function body($maxLength = 0, $format = 'S', $stripTags = '')
    {
        $ret = $this->getVar('body', $format);

        $wrap_pos = strpos($ret, '[pagewrap=');
        if (!($wrap_pos === false)) {
            $wrap_pages = array();
            $wrap_code_length = strlen('[pagewrap=');

            while (!($wrap_pos === false)) {
                $end_wrap_pos = strpos($ret, ']', $wrap_pos);
                if ($end_wrap_pos) {
                    $wrap_page_name = substr($ret, $wrap_pos + $wrap_code_length, $end_wrap_pos - $wrap_code_length - $wrap_pos);
                    $wrap_pages[] = $wrap_page_name;
                }
                $wrap_pos = strpos($ret, '[pagewrap=', $end_wrap_pos - 1);
            }

            foreach ($wrap_pages as $page) {
                $wrap_page_content = $this->wrappage($page);
                $ret = str_replace("[pagewrap={$page}]", $wrap_page_content, $ret);
            }
        }

        if (!empty($stripTags)) {
            $ret = strip_tags($ret, $stripTags);
        }

        if ($maxLength != 0) {
            if (!XOOPS_USE_MULTIBYTES) {
                if (strlen($ret) >= $maxLength) {
                    $ret = publisher_truncateTagSafe($ret, $maxLength, $etc = '...', $break_words = false);
                }
            }
        }
        return $ret;
    }

    /**
     * @param string $dateFormat
     * @param string $format
     * @return string
     */
    public function datesub($dateFormat = '', $format = 'S')
    {
        if (empty($dateformat)) {
            $dateFormat = $this->_publisher->getConfig('format_date');
        }
        return formatTimestamp($this->getVar('datesub', $format), $dateFormat);
    }

    /**
     * @param int $realName -1 for using publisher config, false for username, true for realname
     * @return string
     */
    public function posterName($realName = -1)
    {
        Xoopsload::load('XoopsUserUtility');
        if ($realName == -1) {
            $realName = $this->_publisher->getConfig('format_realname');
        }

        $ret = $this->getVar('author_alias');
        if ($ret == '') {
            $ret = XoopsUserUtility::getUnameFromId($this->getVar('uid'), $realName);
        }

        return $ret;
    }

    /**
     * @return string
     */
    public function posterAvatar()
    {
        $ret = 'blank.gif';
        $thisUser = $this->_handler->member()->getUser($this->getVar('uid'));
        if (is_object($thisUser)) {
            $ret = $thisUser->getVar('user_avatar');
        }

        return $ret;
    }

    /**
     * @return mixed|string
     */
    public function linkedPosterName()
    {
        XoopsLoad::load('XoopsUserUtility');
        $ret = $this->getVar('author_alias');
        if ($ret == '') {
            $ret = XoopsUserUtility::getUnameFromId($this->getVar('uid'), $this->_publisher->getConfig('format_realname'), true);
        }
        return $ret;
    }
    /**
     * wrapper for item handler updateCounter
     *
     * @return bool
     */
    public function updateCounter()
    {
        return $this->_handler->item()->updateCounter($this->getvar('itemid'));
    }

    /**
     * @param bool $force
     * @return bool
     */
    public function store($force = true)
    {
        $isNew = $this->isNew();

        if (!$this->_handler->item()->insert($this, $force)) {
            return false;
        }

        if ($isNew && $this->getVar('status') == _PUBLISHER_STATUS_PUBLISHED) {
            // Increment user posts
            $user_handler = $this->_handler->user();
            $member_handler = $this->_handler->member();
            $poster = $user_handler->get($this->getVar('uid'));
            if (is_object($poster) && !$poster->isNew()) {
                $poster->setVar('posts', $poster->getVar('posts') + 1);
                if (!$member_handler->insertUser($poster, true)) {
                    $this->setErrors('Article created but could not increment user posts.');
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @return mixed
     */
    public function getCategoryName()
    {
        return $this->category()->getVar('name');
    }

    /**
     * @return string
     */
    public function getCategoryUrl()
    {
        return $this->category()->getCategoryUrl();
    }

    /**
     * @return string
     */
    public function getCategoryLink()
    {
        return $this->category()->getCategoryLink();
    }

    /**
     * @param bool $withAllLink
     * @return array|bool
     */
    public function getCategoryPath($withAllLink = true)
    {
        return $this->category()->getCategoryPath($withAllLink);
    }

    /**
     * @return string
     */
    public function getCategoryImagePath()
    {
        return publisher_getImageDir('category', false) . $this->category()->image();
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->_handler->file()->getAllFiles($this->getVar('itemid'), _PUBLISHER_STATUS_FILE_ACTIVE);
    }

    /**
     * @return string
     */
    public function getAdminLinks()
    {
        global $xoopsConfig, $xoopsUser, $publisher_isAdmin;

        $adminLinks = '';

        $groups = ($xoopsUser) ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
        $gperm_handler = $this->_handler->groupperm();

        $module_id = $this->_publisher->getObject()->getVar('mid');

        $uploadLink = '';

        // Do we have access to the parent category
        if (is_object($xoopsUser) && ($publisher_isAdmin || ($xoopsUser->uid() == $this->getVar('uid')) || $gperm_handler->checkRight('item_submit', $this->getVar('categoryid'), $groups, $module_id))) {

            if (!$publisher_isAdmin) {
                if ($xoopsUser->uid() == $this->getVar('uid')) {
                    // Edit button
                    $adminLinks .= "<a href='" . PUBLISHER_URL . "/submit.php?itemid=" . $this->getVar('itemid') . "'><img src='" . PUBLISHER_URL . "/images/links/edit.gif'" . " title='" . _CO_PUBLISHER_EDIT . "' alt='" . _CO_PUBLISHER_EDIT . "'/></a>";
                    $adminLinks .= " ";
                }

                if ($this->_publisher->getConfig('perm_clone')) {
                    // Dupplicate button
                    $adminLinks .= "<a href='" . PUBLISHER_URL . "/submit.php?op=clone&itemid=" . $this->getVar('itemid') . "'><img src='" . PUBLISHER_URL . "/images/links/clone.gif'" . " title='" . _CO_PUBLISHER_CLONE . "' alt='" . _CO_PUBLISHER_CLONE . "' /></a>";
                    $adminLinks .= " ";
                }

                // upload a file linked this article
                if ($this->_publisher->getConfig('perm_upload')) {
                    $uploadLink = "<a href='" . PUBLISHER_URL . "/file.php?itemid=" . $this->getVar('itemid') . "'><img src='" . PUBLISHER_URL . "/images/icon/file.gif' title='" . _CO_PUBLISHER_ADD_FILE . "' alt='" . _CO_PUBLISHER_ADD_FILE . "' /></a>";
                }

            } else {
                // Edit button
                $adminLinks .= "<a href='" . PUBLISHER_URL . "/submit.php?itemid=" . $this->getVar('itemid') . "'><img src='" . PUBLISHER_URL . "/images/links/edit.gif'" . " title='" . _CO_PUBLISHER_EDIT . "' alt='" . _CO_PUBLISHER_EDIT . "' /></a>";
                $adminLinks .= " ";

                // Dupplicate button
                $adminLinks .= "<a href='" . PUBLISHER_URL . "/admin/item.php?op=clone&amp;itemid=" . $this->getVar('itemid') . "'><img src='" . PUBLISHER_URL . "/images/links/clone.gif'" . " title='" . _CO_PUBLISHER_CLONE . "' alt='" . _CO_PUBLISHER_CLONE . "' /></a>";
                $adminLinks .= " ";

                // Delete button
                $adminLinks .= "<a href='" . PUBLISHER_URL . "/admin/item.php?op=del&amp;itemid=" . $this->getVar('itemid') . "'><img src='" . PUBLISHER_URL . "/images/links/delete.gif'" . " title='" . _CO_PUBLISHER_DELETE . "' alt='" . _CO_PUBLISHER_DELETE . "' /></a>";
                $adminLinks .= " ";

                // upload a file linked this article
                $uploadLink = "<a href='" . PUBLISHER_URL . "/file.php?itemid=" . $this->getVar('itemid') . "'><img src='" . PUBLISHER_URL . "/images/icon/file.gif' title='" . _CO_PUBLISHER_ADD_FILE . "' alt='" . _CO_PUBLISHER_ADD_FILE . "' /></a>";

            }
        }

        // PDF button
        $adminLinks .= "<a href='" . PUBLISHER_URL . "/makepdf.php?itemid=" . $this->getVar('itemid') . "' rel='nofollow' target='_blank'><img src='" . PUBLISHER_URL . "/images/links/pdf.gif' title='" . _CO_PUBLISHER_PDF . "' alt='" . _CO_PUBLISHER_PDF . "' /></a>";
        $adminLinks .= " ";

        // Print button
        $adminLinks .= "<a href='" . publisher_seo_genUrl("print", $this->getVar('itemid'), $this->getVar('short_url')) . "' rel='nofollow' target='_blank'><img src='" . PUBLISHER_URL . "/images/links/print.gif' title='" . _CO_PUBLISHER_PRINT . "' alt='" . _CO_PUBLISHER_PRINT . "' /></a>";
        $adminLinks .= " ";

        // Email button
        if (xoops_isActiveModule('tellafriend')) {
            $subject = sprintf(_CO_PUBLISHER_INTITEMFOUND, $xoopsConfig['sitename']);
            $subject = $this->_convert_for_japanese($subject);

            $maillink = publisher_tellafriend($subject);

            $adminLinks .= '<a href="' . $maillink . '"><img src="' . PUBLISHER_URL . '/images/links/friend.gif" title="' . _CO_PUBLISHER_MAIL . '" alt="' . _CO_PUBLISHER_MAIL . '" /></a>';
            $adminLinks .= " ";
        }

        // upload a file linked this article
        // Add a file button
        $adminLinks .= $uploadLink;
        $adminLinks .= " ";

        return $adminLinks;
    }

    /**
     * @param array $notifications
     * @return void
     */
    public function sendNotifications($notifications = array())
    {
        $notification_handler = $this->_handler->notification();

        $tags = array();
        $tags['MODULE_NAME'] = $this->_publisher->getObject()->getVar('name');
        $tags['ITEM_NAME'] = $this->title();
        $tags['ITEM_NAME'] = $this->subtitle();
        $tags['CATEGORY_NAME'] = $this->getCategoryName();
        $tags['CATEGORY_URL'] = PUBLISHER_URL . '/category.php?categoryid=' . $this->getVar('categoryid');
        $tags['ITEM_BODY'] = $this->body();
        $tags['DATESUB'] = $this->datesub();
        foreach ($notifications as $notification) {
            switch ($notification) {
                case _PUBLISHER_NOT_ITEM_PUBLISHED :
                    $tags['ITEM_URL'] = PUBLISHER_URL . '/item.php?itemid=' . $this->getVar('itemid');

                    $notification_handler->triggerEvent('global_item', 0, 'published', $tags, array(), $this->_publisher
                            ->getObject()->getVar('mid'));
                    $notification_handler->triggerEvent('category_item', $this->getVar('categoryid'), 'published', $tags,
                        array(), $this->_publisher->getObject()->getVar('mid'));
                    $notification_handler->triggerEvent('item', $this->getVar('itemid'), 'approved', $tags,
                        array(), $this->_publisher->getObject()->getVar('mid'));
                    break;

                case _PUBLISHER_NOT_ITEM_SUBMITTED :
                    $tags['WAITINGFILES_URL'] = PUBLISHER_URL . '/admin/item.php?itemid=' . $this->getVar('itemid');
                    $notification_handler->triggerEvent('global_item', 0, 'submitted', $tags, array(), $this->_publisher
                            ->getObject()->getVar('mid'));
                    $notification_handler->triggerEvent('category_item', $this->getVar('categoryid'), 'submitted', $tags,
                        array(), $this->_publisher->getObject()->getVar('mid'));
                    break;

                case _PUBLISHER_NOT_ITEM_REJECTED :
                    $notification_handler->triggerEvent('item', $this->getVar('itemid'), 'rejected', $tags,
                        array(), $this->_publisher->getObject()->getVar('mid'));
                    break;

                case -1 :
                default:
                    break;
            }
        }
    }

    /**
     * @return void
     */
    public function setDefaultPermissions()
    {
        $groups = $this->_handler->member()->getGroupList();

        $j = 0;
        $group_ids = array();
        foreach (array_keys($groups) as $i) {
            $group_ids[$j] = $i;
            $j++;
        }

        $this->_groups_read = $group_ids;
    }

    /**
     * @return bool
     */
    public function notLoaded()
    {
        return $this->getVar('itemid') == -1;
    }

    /**
     * @return array
     */
    public function partial_view()
    {
        return explode(';', $this->getVar('partial_view'));
    }

    /**
     * @param $groups_array
     * @return void
     */
    public function setPartial_view($groups_array)
    {
        if ($groups_array) {
            $this->setVar('partial_view', implode(';', $groups_array));
        } else {
            $this->setVar('partial_view', 0);
        }
    }

    /**
     * @return bool
     */
    public function showPartial_view()
    {
        global $xoopsUser;

        if (!$this->partial_view()) {
            //if no groups are setted to see p_view, get out of here
            return false;
        } elseif (is_object($xoopsUser)) {
            //get groups of current user
            $u_groups = $xoopsUser->getGroups();
        } else {
            //anonymous if it is not a user
            $u_groups = array(0 => 3);
        }
        //get groups setted for p_view
        $pv_groups = $this->partial_view();
        //get groups to wich belong user that are not setted for p_view
        $gr_with_no_pview = array_diff($u_groups, $pv_groups);

        $allowed = false;
        if (!empty($gr_with_no_pview)) {
            //determine if these groups can view the full article
            $allowed = $this->_handler->groupperm()->checkRight('item_read', $this->getVar('itemid'), $gr_with_no_pview, $this->_publisher
                    ->getObject()->getVar('mid'));
        }

        //return false if user belong to at least 1 group wich has full view
        return (empty($gr_with_no_pview) || !$allowed);
    }

    /**
     * @return string
     */
    public function getItemUrl()
    {
        return publisher_seo_genUrl('item', $this->getVar('itemid'), $this->getvar('short_url'));
    }

    /**
     * @param string $class
     * @param int $maxsize
     * @return string
     */
    public function getItemLink($class = '', $maxsize = 0)
    {
        if (!empty($class)) {
            return '<a class=' . $class . ' href="' . $this->getItemUrl() . '">' . $this->title($maxsize) . '</a>';
        } else {
            return '<a href="' . $this->getItemUrl() . '">' . $this->title($maxsize) . '</a>';
        }
    }

    /**
     * @return string
     */
    public function getWhoAndWhen()
    {
        $posterName = $this->linkedPosterName();
        $postdate = $this->datesub();
        return sprintf(_CO_PUBLISHER_POSTEDBY, $posterName, $postdate);
    }

    /**
     * @param string $body
     * @return string
     */
    public function getPlainMainText($body = null)
    {
        $ret = '';
        if (!$body) {
            $body = $this->body();
        }
        $ret .= str_replace('[pagebreak]', '<br /><br />', $body);
        return $ret;
    }

    /**
     * @param int $item_page_id
     * @param string $body
     * @return string
     */
    public function getMainText($item_page_id = -1, $body = null)
    {
        if (!$body) {
            $body = $this->body();
        }
        $body_parts = explode('[pagebreak]', $body);
        $this->setVar('pagescount', count($body_parts));
        if (count($body_parts) <= 1) {
            return $this->getPlainMainText($body);
        }

        $ret = '';

        if ($item_page_id == -1) {
            $ret .= trim($body_parts[0]);
            return $ret;
        }

        if ($item_page_id >= count($body_parts)) {
            $item_page_id = count($body_parts) - 1;
        }
        $ret .= trim($body_parts[$item_page_id]);
        return $ret;
    }

    public function getImages()
    {
        static $ret;
        $itemid = $this->getVar('itemid');
        if (!isset($ret[$itemid])) {
            $ret[$itemid]['main'] = '';
            $ret[$itemid]['others'] = array();
            $images_ids = array();
            $image = $this->getVar('image');
            $images = $this->getVar('images');
            if ($images != '') {
                $images_ids = explode('|', $images);
            }
            if ($image > 0) {
                $images_ids = array_merge($images_ids, array($image));
            }
            $imageObjs = array();
            if (count($images_ids) > 0) {
                $criteria = new CriteriaCompo(new Criteria('image_id', '(' . implode(',', $images_ids) . ')', 'IN'));
                $imageObjs = $this->_handler->image()->getObjects($criteria, true);
                unset($criteria);
            }
            foreach ($imageObjs as $id => $imageObj) {
                if ($id == $image) {
                    $ret[$itemid]['main'] = $imageObj;
                } else {
                    $ret[$itemid]['others'][] = $imageObj;
                }
                unset($imageObj);
            }
            unset($imageObjs);
        }
        return $ret[$itemid];
    }

    /**
     * @param string $display
     * @param int $max_char_title
     * @param int $max_char_summary
     * @param bool $full_summary
     * @return array
     */
    public function toArray($display = 'default', $max_char_title = 0, $max_char_summary = 0, $full_summary = false)
    {
        $item_page_id = -1;
        if (is_numeric($display)) {
            $item_page_id = $display;
            $display = 'all';
        }

        $item['itemid'] = $this->getVar('itemid');
        $item['uid'] = $this->getVar('uid');
        $item['titlelink'] = $this->getItemLink(false, $max_char_title);
        $item['subtitle'] = $this->subtitle();
        $item['datesub'] = $this->datesub();
        $item['counter'] = $this->getVar('counter');

        switch ($display) {
            case 'summary':
            case 'list':
                break;

            case 'full':
            case 'wfsection':
            case 'default':
                $item['summary'] = $this->getBlockSummary($max_char_summary, $full_summary);
                $item = $this->toArrayFull($item);
                break;

            case 'all':
                $item = $this->toArrayFull($item);
                $item = $this->toArrayAll($item, $item_page_id);
                break;
        }

        // Hightlighting searched words
        $highlight = true;
        if ($highlight && isset($_GET['keywords'])) {
            $myts =& MyTextSanitizer::getInstance();
            $keywords = $myts->htmlSpecialChars(trim(urldecode($_GET['keywords'])));
            $fields = array('title', 'maintext', 'summary');
            foreach ($fields as $field) {
                if (isset($item[$field])) {
                    $item[$field] = $this->highlight($item[$field], $keywords);
                }
            }
        }

        return $item;
    }

    /**
     * @param array $item
     * @return array
     */
    public function toArrayFull($item)
    {
        $item['title'] = $this->title();
        $item['clean_title'] = $this->title();
        $item['itemurl'] = $this->getItemUrl();
        $item['cancomment'] = $this->getVar('cancomment');
        $item['comments'] = $this->getVar('comments');
        $item['adminlink'] = $this->getAdminLinks();
        $item['categoryPath'] = $this->getCategoryPath($this->_publisher->getConfig('format_linked_path'));
        $item['who_when'] = $this->getWhoAndWhen();

        $item = $this->getMainImage($item);
        return $item;
    }

    /**
     * @param array $item
     * @param int $item_page_id
     * @return array
     */
    public function toArrayAll($item, $item_page_id)
    {
        if ($this->showPartial_view()) {
            $body = $this->_publisher->getConfig('idxcat_partial_view_text');
        } else {
            $body = $this->body();
        }
        $item['maintext'] = $this->getMainText($item_page_id, $body);
        $item = $this->getOtherImages($item);
        return $item;
    }

    /**
     * @param array $item
     * @return array
     */
    public function getMainImage($item = array())
    {
        $images = $this->getImages();
        $item['image_path'] = '';
        $item['image_name'] = '';
        if (is_object($images['main'])) {
            $dimensions = getimagesize(XOOPS_ROOT_PATH . '/uploads/' . $images['main']->getVar('image_name'));
            $item['image_width'] = $dimensions[0];
            $item['image_height'] = $dimensions[1];
            $item['image_path'] = XOOPS_URL . '/uploads/' . $images['main']->getVar('image_name');
            // check to see if GD function exist
            if (!function_exists('imagecreatetruecolor')) {
                $item['image_thumb'] = XOOPS_URL . '/uploads/' . $images['main']->getVar('image_name');
            } else {
                $item['image_thumb'] = PUBLISHER_URL . '/thumb.php?src=' . XOOPS_URL . '/uploads/' . $images['main']->getVar('image_name') . '&amp;h=180';
            }
            $item['image_name'] = $images['main']->getVar('image_nicename');
        }
        return $item;
    }

    /**
     * @param array $item
     * @return array
     */
    public function getOtherImages($item = array())
    {
        $images = $this->getImages();
        $item['images'] = array();
        $i = 0;
        /* @var $image XoopsImage */
        foreach ($images['others'] as $image) {
            $dimensions = getimagesize(XOOPS_ROOT_PATH . '/uploads/' . $image->getVar('image_name'));
            $item['images'][$i]['width'] = $dimensions[0];
            $item['images'][$i]['height'] = $dimensions[1];
            $item['images'][$i]['path'] = XOOPS_URL . '/uploads/' . $image->getVar('image_name');
            // check to see if GD function exist
            if (!function_exists('imagecreatetruecolor')) {
                $item['images'][$i]['thumb'] = XOOPS_URL . '/uploads/' . $image->getVar('image_name');
            } else {
                $item['images'][$i]['thumb'] = PUBLISHER_URL . '/thumb.php?src=' . XOOPS_URL . '/uploads/' . $image->getVar('image_name') . '&amp;w=240';
            }
            $item['images'][$i]['name'] = $image->getVar('image_nicename');
            $i++;
        }
        return $item;
    }

    /**
     * @param string $content
     * @param array $keywords
     * @return mixed
     */
    public function highlight($content, $keywords)
    {
        $keywords = explode(' ', $keywords);
        foreach ($keywords as $keyword) {
            $content = preg_replace_callback("/(" . preg_quote($keyword) . ")/si",
                array($this, '_highlighter'), $content);
        }
        return $content;
    }

    /**
     * Callback function for highlighting search results
     *
     * @param array $matches
     * @return string
     */
    private function _highlighter($matches)
    {
        $color = $this->_publisher->getConfig('format_highlight_color');
        if (substr($color, 0, 1) != '#') {
            $color = '#' . $color;
        }
        return '<span style="font-weight: bolder; background-color: ' . $color . ';">' . $matches[0] . '</span>';
    }

    /**
     * @return void
     */
    public function createMetaTags()
    {
        $publisher_metagen = new Xmf_Metagen($this->title(), $this->getVar('meta_keywords', 'n'), $this->getVar('meta_description', 'n'), $this->_category->getCategoryPath());
        $publisher_metagen->addMetaKeywords($this->_publisher->getConfig('seo_meta_keywords'));
        $publisher_metagen->createMetaTags();
    }

    /**
     * @param $str
     * @return string
     */
    private function _convert_for_japanese($str)
    {
        global $xoopsConfig;

        // no action, if not flag
        if (!defined('_PUBLISHER_FLAG_JP_CONVERT')) {
            return $str;
        }

        // no action, if not Japanese

        if ($xoopsConfig['language'] != 'japanese') {
            return $str;
        }

        // presume OS Browser
        $agent = $_SERVER["HTTP_USER_AGENT"];
        $os = '';
        $browser = '';
        if (preg_match("/Win/i", $agent)) {
            $os = 'win';
        }
        if (preg_match("/MSIE/i", $agent)) {
            $browser = 'msie';
        }

        // if msie
        if (($os == 'win') && ($browser == 'msie')) {

            // if multibyte
            if (function_exists('mb_convert_encoding')) {
                $str = mb_convert_encoding($str, 'SJIS', 'EUC-JP');
                $str = rawurlencode($str);
            }
        }

        return $str;
    }

    /**
     * @param string $title
     * @param bool $checkperm
     * @return PublisherItemForm
     */
    public function getForm($title = 'default', $checkperm = true)
    {
        include_once dirname(__FILE__) . '/form/item.php';
        $form = new PublisherItemForm($title, 'form', xoops_getenv('PHP_SELF'));
        $form->setCheckPermissions($checkperm);
        $form->createElements($this);
        return $form;
    }

    /**
     * Checks if a user has access to a selected item. if no item permissions are
     * set, access permission is denied. The user needs to have necessary category
     * permission as well.
     *
     * Also, the item needs to be Published
     *
     * @return boolean : TRUE if the no errors occured
     */
    public function accessGranted()
    {
        global $xoopsUser;

        if (publisher_userIsAdmin()) {
            return true;
        }

        if ($this->getVar('status') != _PUBLISHER_STATUS_PUBLISHED) {
            return false;
        }

        $gperm_handler = $this->_handler->groupperm();
        $groups = $xoopsUser ? $xoopsUser->getGroups() : XOOPS_GROUP_ANONYMOUS;
        $module_id = $this->_publisher->getObject()->getVar('mid');

        // Do we have access to the parent category
        if ($gperm_handler->checkRight('category_read', $this->getVar('categoryid'), $groups, $module_id)) {
            // And do we have access to the item ?
            if ($gperm_handler->checkRight('item_read', $this->getVar('itemid'), $groups, $module_id)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return void
     */
    public function setVarsFromRequest()
    {
        //Required fields
        if (isset($_REQUEST['categoryid'])) {
            $this->setVar('categoryid', Xmf_Request::getInt('categoryid'));
        }

        if (isset($_REQUEST['title'])) {
            $this->setVar('title', Xmf_Request::getString('title'));
        }

        if (isset($_REQUEST['body'])) {
            $this->setVar('body', Xmf_Request::getText('body'));
        }

        //Not required fields
        if (isset($_REQUEST['summary'])) {
            $this->setVar('summary', Xmf_Request::getText('summary'));
        }

        if (isset($_REQUEST['subtitle'])) {
            $this->setVar('subtitle', Xmf_Request::getString('subtitle'));
        }

        if (isset($_REQUEST['item_tag'])) {
            $this->setVar('item_tag', Xmf_Request::getString('item_tag'));
        }

        if (isset($_REQUEST['image_featured'])) {
            $image_item = Xmf_Request::getArray('image_item');
            $image_featured = Xmf_Request::getString('image_featured');

            //Todo: get a better image class for xoops!
            //Image hack
            $image_item_ids = array();
            global $xoopsDB;
            $sql = 'SELECT image_id, image_name FROM ' . $xoopsDB->prefix('image');
            $result = $xoopsDB->query($sql, 0, 0);
            while ($myrow = $xoopsDB->fetchArray($result)) {
                $image_name = $myrow['image_name'];
                $id = $myrow['image_id'];
                if ($image_name == $image_featured) {
                    $this->setVar('image', $id);
                }
                if (in_array($image_name, $image_item)) {
                    $image_item_ids[] = $id;
                }

            }
            $this->setVar('images', implode('|', $image_item_ids));
        }

        //$item_upload_file = isset($_FILES['item_upload_file']) ? $_FILES['item_upload_file'] : '';

        if (isset($_REQUEST['uid'])) {
            $this->setVar('uid', Xmf_Request::getInt('uid'));
        } elseif ($this->isnew()) {
            $this->setVar('uid', is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->uid() : 0);
        }

        if (isset($_REQUEST['author_alias'])) {
            $this->setVar('author_alias', Xmf_Request::getString('author_alias'));
            if ($this->getVar('autor_alias') != '') {
                $this->setVar('uid', 0);
            }
        }

        if (isset($_REQUEST['datesub'])) {
            $this->setVar('datesub', strtotime($_REQUEST['datesub']['date']) + $_REQUEST['datesub']['time']);
        } elseif ($this->isnew()) {
            $this->setVar('datesub', time());
        }

        if (isset($_REQUEST['item_short_url'])) {
            $this->setVar('short_url', Xmf_Request::getString('item_short_url'));
        }


        if (isset($_REQUEST['item_meta_keywords'])) {
            $this->setVar('meta_keywords', Xmf_Request::getString('item_meta_keywords'));
        }

        if (isset($_REQUEST['item_meta_description'])) {
            $this->setVar('meta_description', Xmf_Request::getString('item_meta_description'));
        }

        if (isset($_REQUEST['weight'])) {
            $this->setVar('weight', Xmf_Request::getInt('weight'));
        }

        if (isset($_REQUEST['allowcomments'])) {
            $this->setVar('cancomment', Xmf_Request::getInt('allowcomments'));
        } elseif ($this->isnew()) {
            $this->setVar('cancoment', $this->_publisher->getConfig('submit_allowcomments'));
        }

        if (isset($_REQUEST['status'])) {
            $this->setVar('status', Xmf_Request::getInt('status'));
        } elseif ($this->isnew()) {
            $this->setVar('status', $this->_publisher->getConfig('submit_status'));
        }

        if (isset($_REQUEST['dohtml'])) {
            $this->setVar('dohtml', Xmf_Request::getInt('dohtml'));
        } elseif ($this->isnew()) {
            $this->setVar('dohtml', $this->_publisher->getConfig('submit_dohtml'));
        }

        if (isset($_REQUEST['dosmiley'])) {
            $this->setVar('dosmiley', Xmf_Request::getInt('dosmiley'));
        } elseif ($this->isnew()) {
            $this->setVar('dosmiley', $this->_publisher->getConfig('submit_dosmiley'));
        }

        if (isset($_REQUEST['doxcode'])) {
            $this->setVar('doxcode', Xmf_Request::getInt('doxcode'));
        } elseif ($this->isnew()) {
            $this->setVar('doxcode', $this->_publisher->getConfig('submit_doxcode'));
        }

        if (isset($_REQUEST['doimage'])) {
            $this->setVar('doimage', Xmf_Request::getInt('doimage'));
        } elseif ($this->isnew()) {
            $this->setVar('doimage', $this->_publisher->getConfig('submit_doimage'));
        }

        if (isset($_REQUEST['dolinebreak'])) {
            $this->setVar('dobr', Xmf_Request::getInt('dolinebreak'));
        } elseif ($this->isnew()) {
            $this->setVar('dobr', $this->_publisher->getConfig('submit_dobr'));
        }

        if (isset($_REQUEST['notify'])) {
            $this->setVar('notifypub', Xmf_Request::getInt('notify'));
        } elseif ($this->isnew()) {

        }

        if (isset($_REQUEST['permissions_item'])) {
            $this->setGroups_read(Xmf_Request::getArray('permissions_item'));
        } elseif ($this->isnew()) {
            $this->setGroups_read($this->_handler->permission()->getGrantedGroups('category_read', $this->getVar('categoryid')));
        }

        if (isset($_REQUEST['partial_view'])) {
            $this->setPartial_view(Xmf_Request::getArray('partial_view'));
        }
    }

}

/**
 * Items handler class.
 * This class is responsible for providing data access mechanisms to the data source
 * of Q&A class objects.
 *
 * @author marcan <marcan@notrevie.ca>
 * @package Publisher
 */
class PublisherItemHandler extends XoopsPersistableObjectHandler
{
    /**
     * @var Xmf_Module_Helper
     */
    private $_publisher = null;

    /**
     * @var Publisher_handler
     */
    private $_handler = null;

    /**
     * @param XoopsDatabase $db
     */
    public function __construct($db)
    {
        parent::__construct($db, "publisher_items", 'PublisherItem', "itemid", "title");
        $this->_publisher = Xmf_Module_Helper::getInstance(PUBLISHER_DIRNAME);
        $this->_handler = new PublisherHandler();

    }

    /**
     * @param bool $isNew
     * @return object
     */
    public function &create($isNew = true)
    {
        /* @var $obj PublisherItem */
        $obj = parent::create($isNew);
        if ($isNew) {
            $obj->setDefaultPermissions();
        }
        return $obj;
    }

    /**
     * retrieve an item
     *
     * @param int $id itemid of the user
     * @return PublisherItem reference to the {@link PublisherItem} object, FALSE if failed
     */
    public function &get($id)
    {
        /* @var $obj PublisherItem */
        $obj = parent::get($id);
        if (is_object($obj)) {
            $obj->assignOtherProperties();
        }
        return $obj;
    }

    /**
     * insert a new item in the database
     *
     * @param PublisherItem $item reference to the {@link PublisherItem} object
     * @param bool $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    public function insert(PublisherItem &$item, $force = false)
    {
        if (!$item->getVar('meta_keywords') || !$item->getvar('meta_description') || !$item->getVar('short_url')) {
            $publisher_metagen = new Xmf_Metagen($item->title(), $item->getVar('meta_keywords'), $item->getVar('summary'));
            // Auto create meta tags if empty
            if (!$item->getVar('meta_keywords')) {
                $item->setVar('meta_keywords', $publisher_metagen->getKeywords());
            }
            if (!$item->getvar('meta_description')) {
                $item->setVar('meta_description', $publisher_metagen->getDescription());
            }
            // Auto create short_url if empty
            if (!$item->getVar('short_url')) {
                $item->setVar('short_url', $publisher_metagen->generateSeoTitle($item->getVar('title', 'n'), false));
            }
        }

        if (!parent::insert($item, $force)) {
            return false;
        }

        if (xoops_isActiveModule('tag')) {
            // Storing tags information
            $tag_handler =& xoops_getmodulehandler('tag', 'tag');
            $tag_handler->updateByItem($item->getVar('item_tag'), $item->getVar('itemid'), PUBLISHER_DIRNAME, 0);
        }

        // Saving permissions
        publisher_saveItemPermissions($item->getGroups_read(), $item->itemid());

        return true;
    }

    /**
     * delete an item from the database
     *
     * @param PublisherItem $item reference to the ITEM to delete
     * @param bool $force
     * @return bool FALSE if failed.
     */
    public function delete(PublisherItem &$item, $force = false)
    {
        $module_id = $this->_publisher->getObject()->getVar('mid');

        // Deleting the files
        if (!$this->_handler->file()->deleteItemFiles($item)) {
            $item->setErrors('An error while deleting a file.');
        }

        if (!parent::delete($item, $force)) {
            $item->setErrors('An error while deleting.');
            return false;
        }

        // Removing tags information
        if (xoops_isActiveModule('tag')) {
            $tag_handler =& xoops_getmodulehandler('tag', 'tag');
            $tag_handler->updateByItem('', $item->getVar('itemid'), PUBLISHER_DIRNAME, 0);
        }
        // Removing item permissions
        $this->_handler->groupperm()->deleteByModule($module_id, "item_read", $item->itemid());
        return true;
    }

    /**
     * @param CriteriaElement|null $criteria
     * @param string $id_key
     * @param array $notNullFields
     * @return array array of {@link PublisherItem} objects
     */
    public function getObjects(CriteriaElement $criteria = null, $id_key = 'none', $notNullFields = array())
    {
        $ret = array();
        $limit = $start = 0;
        $sql = 'SELECT * FROM ' . $this->db->prefix('publisher_items');

        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $whereClause = $criteria->renderWhere();

            if ($whereClause != 'WHERE ()') {
                $sql .= ' ' . $criteria->renderWhere();
                if (!empty($notNullFields)) {
                    $sql .= $this->notNullFieldClause($notNullFields, true);
                }
            } elseif (!empty($notNullFields)) {
                $sql .= " WHERE " . $this->notNullFieldClause($notNullFields);
            }
            if ($criteria->getSort() != '') {
                $sql .= ' ORDER BY ' . $criteria->getSort() . ' ' . $criteria->getOrder();
            }
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        } elseif (!empty($notNullFields)) {
            $sql .= $sql .= " WHERE " . $this->notNullFieldClause($notNullFields);
        }

        $result = $this->db->query($sql, $limit, $start);

        if (!$result || count($result) == 0) {
            return $ret;
        }

        $theObjects = array();

        while ($myrow = $this->db->fetchArray($result)) {
            $item = new PublisherItem();
            $item->assignVars($myrow);
            //$item->assignOtherProperties();

            $theObjects[$myrow['itemid']] =& $item;
            unset($item);
        }

        // since we need the categoryObj and the items permissions for all these items, let's
        // fetch them only once ;-)
        $publisher_allCategoriesObj = $this->_handler->category()->getAllCategoriesObj();

        $publisher_items_read_group = $this->_handler->permission()->getGrantedGroupsForIds('item_read');

        /* @var $theObject PublisherItem*/
        foreach ($theObjects as $theObject) {
            $theObject->setCategory(isset($publisher_allCategoriesObj[$theObject->getVar('categoryid')]) ? $publisher_allCategoriesObj[$theObject->getVar('categoryid')] : null);
            $theObject->setGroups_read(isset($publisher_items_read_group[$theObject->getvar('itemid')]) ? $publisher_items_read_group[$theObject->getVar('itemid')] : array());

            if ($id_key == 'none') {
                $ret[] =& $theObject;
            } elseif ($id_key == 'itemid') {
                $ret[$theObject->getvar('itemid')] =& $theObject;
            } else {
                $ret[$theObject->getVar($id_key)][$theObject->getVar('itemid')] =& $theObject;
            }
            unset($theObject);
        }

        return $ret;
    }

    /**
     * count items matching a condition
     *
     * @param CriteriaElement|null $criteria
     * @param array $notNullFields
     * @return int
     */
    public function getCount(CriteriaElement $criteria = null, $notNullFields = array())
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('publisher_items');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $whereClause = $criteria->renderWhere();
            if ($whereClause != 'WHERE ()') {
                $sql .= ' ' . $criteria->renderWhere();
                if (!empty($notNullFields)) {
                    $sql .= $this->notNullFieldClause($notNullFields, true);
                }
            } elseif (!empty($notNullFields)) {
                $sql .= " WHERE " . $this->notNullFieldClause($notNullFields);
            }
        } elseif (!empty($notNullFields)) {
            $sql .= " WHERE " . $this->notNullFieldClause($notNullFields);
        }

        $result = $this->db->query($sql);
        if (!$result) {
            return 0;
        }
        list($count) = $this->db->fetchRow($result);
        return $count;
    }

    /**
     * @param int $categoryid
     * @param array $status
     * @param array $notNullFields
     * @return int
     */
    public function getItemsCount($categoryid = -1, $status = array(), $notNullFields = array())
    {
        global $publisher_isAdmin;

        if (!$publisher_isAdmin) {
            $criteriaPermissions = new CriteriaCompo();

            // Categories for which user has access
            $categoriesGranted = $this->_handler->permission()->getGrantedItems('category_read');
            $grantedCategories = new Criteria('categoryid', "(" . implode(',', $categoriesGranted) . ")", 'IN');
            $criteriaPermissions->add($grantedCategories, 'AND');

            // ITEMs for which user has access
            $itemsGranted = $this->_handler->permission()->getGrantedItems('item_read');
            $grantedItem = new Criteria('itemid', "(" . implode(',', $itemsGranted) . ")", 'IN');
            $criteriaPermissions->add($grantedItem, 'AND');
        }

        if (isset($categoryid) && $categoryid != -1) {
            $criteriaCategory = new criteria('categoryid', $categoryid);
        }

        $criteriaStatus = new CriteriaCompo();
        if (!empty($status) && is_array($status)) {
            foreach ($status as $v) {
                $criteriaStatus->add(new Criteria('status', $v), 'OR');
            }
        } elseif (!empty($status) && $status != -1) {
            $criteriaStatus->add(new Criteria('status', $status), 'OR');
        }

        $criteria = new CriteriaCompo();
        if (isset($criteriaCategory)) {
            $criteria->add($criteriaCategory);
        }

        if (isset($criteriaPermissions)) {
            $criteria->add($criteriaPermissions);
        }

        if (!empty($criteriaStatus)) {
            $criteria->add($criteriaStatus);
        }

        return $this->getCount($criteria, $notNullFields);

    }

    /**
     * @param int $limit
     * @param int $start
     * @param int $categoryid
     * @param string $sort
     * @param string $order
     * @param array $notNullFields
     * @param bool $asobject
     * @param string $id_key
     * @return array
     */
    public function getAllPublished($limit = 0, $start = 0, $categoryid = -1, $sort = 'datesub', $order = 'DESC', $notNullFields = array(), $asobject = true, $id_key = 'none')
    {
        $otherCriteria = new Criteria('datesub', time(), '<=');
        return $this->getItems($limit, $start, array(
                _PUBLISHER_STATUS_PUBLISHED
            ), $categoryid, $sort, $order, $notNullFields, $asobject, $otherCriteria, $id_key);
    }

    /**
     * @param PublisherItem $obj
     * @return bool
     */
    public function getPreviousPublished(PublisherItem $obj)
    {
        $ret = false;
        $otherCriteria = new CriteriaCompo();
        $otherCriteria->add(new Criteria('datesub', $obj->getVar('datesub'), '<'));
        $objs = $this->getItems(1, 0, array(
                _PUBLISHER_STATUS_PUBLISHED
            ), $obj->getVar('categoryid'), 'datesub', 'DESC', '', true, $otherCriteria, 'none');
        if (count($objs) > 0) {
            $ret = $objs[0];
        }
        return $ret;
    }

    /**
     * @param PublisherItem $obj
     * @return bool
     */
    public function getNextPublished(PublisherItem $obj)
    {
        $ret = false;
        $otherCriteria = new CriteriaCompo();
        $otherCriteria->add(new Criteria('datesub', $obj->getVar('datesub'), '>'));
        $otherCriteria->add(new Criteria('datesub', time(), '<='));
        $objs = $this->getItems(1, 0, array(
                _PUBLISHER_STATUS_PUBLISHED
            ), $obj->getVar('categoryid'), 'datesub', 'ASC', '', true, $otherCriteria, 'none');
        if (count($objs) > 0) {
            $ret = $objs[0];
        }
        return $ret;
    }

    /**
     * Submited articles
     *
     * @param int $limit
     * @param int $start
     * @param int $categoryid
     * @param string $sort
     * @param string $order
     * @param array $notNullFields
     * @param bool $asobject
     * @param string $id_key
     * @return array
     */
    public function getAllSubmitted($limit = 0, $start = 0, $categoryid = -1, $sort = 'datesub', $order = 'DESC', $notNullFields = array(), $asobject = true, $id_key = 'none')
    {
        return $this->getItems($limit, $start,
            array(_PUBLISHER_STATUS_SUBMITTED), $categoryid, $sort, $order, $notNullFields, $asobject, null, $id_key);
    }

    /**
     * Offline articles
     *
     * @param int $limit
     * @param int $start
     * @param int $categoryid
     * @param string $sort
     * @param string $order
     * @param array $notNullFields
     * @param bool $asobject
     * @param string $id_key
     * @return array
     */
    public function getAllOffline($limit = 0, $start = 0, $categoryid = -1, $sort = 'datesub', $order = 'DESC', $notNullFields = array(), $asobject = true, $id_key = 'none')
    {
        return $this->getItems($limit, $start,
            array(_PUBLISHER_STATUS_OFFLINE), $categoryid, $sort, $order, $notNullFields, $asobject, null, $id_key);
    }

    /**
     * Rejected articles
     *
     * @param int $limit
     * @param int $start
     * @param int $categoryid
     * @param string $sort
     * @param string $order
     * @param array $notNullFields
     * @param bool $asobject
     * @param string $id_key
     * @return array
     */
    public function getAllRejected($limit = 0, $start = 0, $categoryid = -1, $sort = 'datesub', $order = 'DESC', $notNullFields = array(), $asobject = true, $id_key = 'none')
    {
        return $this->getItems($limit, $start,
            array(_PUBLISHER_STATUS_REJECTED), $categoryid, $sort, $order, $notNullFields, $asobject, null, $id_key);
    }

    /**
     * @param int $limit
     * @param int $start
     * @param array $status
     * @param int $categoryid
     * @param string $sort
     * @param string $order
     * @param array $notNullFields
     * @param bool $asobject
     * @param CriteriaElement|null $otherCriteria
     * @param string $id_key
     * @return array
     */
    function getItems($limit = 0, $start = 0, $status = array(), $categoryid = -1, $sort = 'datesub', $order = 'DESC', $notNullFields = array(), $asobject = true, CriteriaElement $otherCriteria = null, $id_key = 'none')
    {
        global $publisher_isAdmin;

        if (!$publisher_isAdmin) {
            $criteriaPermissions = new CriteriaCompo();

            // Categories for which user has access
            $categoriesGranted = $this->_handler->permission()->getGrantedItems('category_read');
            $grantedCategories = new Criteria('categoryid', "(" . implode(',', $categoriesGranted) . ")", 'IN');
            $criteriaPermissions->add($grantedCategories, 'AND');

            // Item for which user has access
            $itemsGranted = $this->_handler->permission()->getGrantedItems('item_read');
            $grantedItem = new Criteria('itemid', "(" . implode(',', $itemsGranted) . ")", 'IN');
            $criteriaPermissions->add($grantedItem, 'AND');
        }

        if (isset($categoryid) && ($categoryid != -1)) {
            $criteriaCategory = new criteria('categoryid', $categoryid);
        }

        if (!empty($status) && is_array($status)) {
            $criteriaStatus = new CriteriaCompo();
            foreach ($status as $v) {
                $criteriaStatus->add(new Criteria('status', $v), 'OR');
            }
        } elseif (!empty($status) && $status != -1) {
            $criteriaStatus = new CriteriaCompo();
            $criteriaStatus->add(new Criteria('status', $status), 'OR');
        }

        $criteria = new CriteriaCompo();
        if (isset($criteriaCategory)) {
            $criteria->add($criteriaCategory);
        }

        if (isset($criteriaPermissions)) {
            $criteria->add($criteriaPermissions);
        }

        if (isset($criteriaStatus)) {
            $criteria->add($criteriaStatus);
        }

        if (isset($otherCriteria)) {
            $criteria->add($otherCriteria);
        }

        $criteria->setLimit($limit);
        $criteria->setStart($start);
        $criteria->setSort($sort);
        $criteria->setOrder($order);

        $ret = $this->getObjects($criteria, $id_key, $notNullFields);

        return $ret;
    }

    /**
     * @param string $field
     * @param array $status
     * @param int $categoryId
     * @return bool
     */
    public function getRandomItem($field = '', $status = array(), $categoryId = -1)
    {
        $ret = false;

        $notNullFields = $field;

        // Getting the number of published Items
        $totalItems = $this->getItemsCount($categoryId, $status, $notNullFields);

        if ($totalItems > 0) {
            $totalItems = $totalItems - 1;
            $entrynumber = mt_rand(0, $totalItems);
            $item =& $this->getItems(1, $entrynumber, $status, $categoryId, $sort = 'datesub', $order = 'DESC', $notNullFields);
            if ($item) {
                $ret =& $item[0];
            }
        }
        return $ret;

    }

    /**
     * delete Items matching a set of conditions
     *
     * @param CriteriaElement|null $criteria
     * @return bool
     */
    public function deleteAll(CriteriaElement $criteria = null)
    {
        //todo resource consuming, use get list instead?
        $items = $this->getObjects($criteria);
        foreach ($items as $item) {
            $this->delete($item);
        }
        return true;
    }

    /**
     * @param $itemid
     * @return bool
     */
    public function updateCounter($itemid)
    {
        $sql = "UPDATE " . $this->db->prefix("publisher_items") . " SET counter=counter+1 WHERE itemid = " . $itemid;
        if ($this->db->queryF($sql)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param array $notNullFields
     * @param bool $withAnd
     * @return string
     */
    public function notNullFieldClause($notNullFields = array(), $withAnd = false)
    {
        $ret = '';
        if ($withAnd) {
            $ret .= " AND ";
        }
        if (!empty($notNullFields) && (is_array($notNullFields))) {
            foreach ($notNullFields as $v) {
                $ret .= " ($v IS NOT NULL AND $v <> ' ' )";
            }
        } elseif (!empty($notNullFields)) {
            $ret .= " ($notNullFields IS NOT NULL AND $notNullFields <> ' ' )";
        }
        return $ret;
    }

    /**
     * @param array $queryarray
     * @param string $andor
     * @param int $limit
     * @param int $offset
     * @param int $userid
     * @param array $categories
     * @param int $sortby
     * @param string $searchin
     * @param string $extra
     * @return array
     */
    public function getItemsFromSearch($queryarray =
        array(), $andor = 'AND', $limit = 0, $offset = 0, $userid = 0, $categories =
        array(), $sortby = 0, $searchin = "", $extra = "")
    {
        global $xoopsUser, $publisher_isAdmin;

        $ret = array();

        $gperm_handler = $this->_handler->groupperm();
        $groups = is_object($xoopsUser) ? ($xoopsUser->getGroups()) : XOOPS_GROUP_ANONYMOUS;

        $searchin = empty($searchin) ? array("title", "body", "summary") : (is_array($searchin) ? $searchin :
            array($searchin));
        if (in_array("all", $searchin) || count($searchin) == 0) {
            $searchin = array("title", "subtitle", "body", "summary", "meta_keywords");
        }

        if (is_array($userid) && count($userid) > 0) {
            $userid = array_map("intval", $userid);
            $criteriaUser = new CriteriaCompo();
            $criteriaUser->add(new Criteria('uid', '(' . implode(',', $userid) . ')', 'IN'), 'OR');
        } elseif (is_numeric($userid) && $userid > 0) {
            $criteriaUser = new CriteriaCompo();
            $criteriaUser->add(new Criteria('uid', $userid), 'OR');
        }

        $count = count($queryarray);
        if (is_array($queryarray) && $count > 0) {
            $criteriaKeywords = new CriteriaCompo();
            for ($i = 0; $i < count($queryarray); $i++) {
                $criteriaKeyword = new CriteriaCompo();
                if (in_array('title', $searchin)) {
                    $criteriaKeyword->add(new Criteria('title', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                }
                if (in_array('subtitle', $searchin)) {
                    $criteriaKeyword->add(new Criteria('subtitle', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                }
                if (in_array('body', $searchin)) {
                    $criteriaKeyword->add(new Criteria('body', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                }
                if (in_array('summary', $searchin)) {
                    $criteriaKeyword->add(new Criteria('summary', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                }
                if (in_array('meta_keywords', $searchin)) {
                    $criteriaKeyword->add(new Criteria('meta_keywords', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                }
                $criteriaKeywords->add($criteriaKeyword, $andor);
                unset($criteriaKeyword);
            }
        }

        if (!$publisher_isAdmin && (count($categories) > 0)) {
            $criteriaPermissions = new CriteriaCompo();

            // Categories for which user has access
            $categoriesGranted = $gperm_handler->getItemIds('category_read', $groups, $this->_publisher->getObject()
                    ->getVar('mid'));
            if (count($categories) > 0) {
                $categoriesGranted = array_intersect($categoriesGranted, $categories);
            }

            if (count($categoriesGranted) == 0) {
                return $ret;
            }
            $grantedCategories = new Criteria('categoryid', "(" . implode(',', $categoriesGranted) . ")", 'IN');
            $criteriaPermissions->add($grantedCategories, 'AND');

            // items for which user has access
            $itemsGranted = $gperm_handler->getItemIds('item_read', $groups, $this->_publisher->getObject()
                    ->getVar('mid'));
            if (count($itemsGranted) == 0) {
                return $ret;
            }
            $grantedItem = new Criteria('itemid', "(" . implode(',', $itemsGranted) . ")", 'IN');
            $criteriaPermissions->add($grantedItem, 'AND');

        } elseif (count($categories) > 0) {
            $criteriaPermissions = new CriteriaCompo();
            $grantedCategories = new Criteria('categoryid', "(" . implode(',', $categories) . ")", 'IN');
            $criteriaPermissions->add($grantedCategories, 'AND');
        }

        $criteriaItemsStatus = new CriteriaCompo();
        $criteriaItemsStatus->add(new Criteria('status', _PUBLISHER_STATUS_PUBLISHED));

        $criteria = new CriteriaCompo();
        if (isset($criteriaUser)) {
            $criteria->add($criteriaUser, 'AND');
        }

        if (isset($criteriaKeywords)) {
            $criteria->add($criteriaKeywords, 'AND');
        }

        if (isset($criteriaPermissions)) {
            $criteria->add($criteriaPermissions);
        }

        if (isset($criteriaItemsStatus)) {
            $criteria->add($criteriaItemsStatus, 'AND');
        }

        $criteria->setLimit($limit);
        $criteria->setStart($offset);

        if (empty($sortby)) {
            $sortby = "datesub";
        }
        $criteria->setSort($sortby);

        $order = 'ASC';
        if ($sortby == "datesub") {
            $order = 'DESC';
        }
        $criteria->setOrder($order);

        $ret = $this->getObjects($criteria);

        return $ret;
    }

    /**
     * @param array $status
     * @return array
     */
    public function getLastPublishedByCat($status = array(_PUBLISHER_STATUS_PUBLISHED))
    {
        global $publisher_isAdmin;
        $ret = array();

        $itemclause = "";
        if (!$publisher_isAdmin) {
            $items = $this->_handler->permission()->getGrantedItems('item_read');
            $itemclause = " AND itemid IN (" . implode(',', $items) . ")";
        }

        $cat = array();
        $sql = "SELECT categoryid, MAX(datesub) as date FROM " . $this->db->prefix('publisher_items') . " WHERE status IN (" . implode(',', $status) . ") {$itemclause} GROUP BY categoryid";
        $result = $this->db->query($sql);
        while ($row = $this->db->fetchArray($result)) {
            $cat[$row['categoryid']] = $row['date'];
        }
        if (count($cat) == 0) {
            return $ret;
        }

        $sql = "SELECT categoryid, itemid, title, short_url, uid, datesub FROM " . $this->db->prefix('publisher_items');
        $criteriaBig = new CriteriaCompo();
        foreach ($cat as $id => $date) {
            $criteria = new CriteriaCompo(new Criteria('categoryid', $id));
            $criteria->add(new Criteria('datesub', $date));
            $criteriaBig->add($criteria, 'OR');
            unset($criteria);
        }
        $sql .= " " . $criteriaBig->renderWhere();
        $result = $this->db->query($sql);

        while ($row = $this->db->fetchArray($result)) {
            $item = new PublisherItem();
            $item->assignVars($row);
            $ret[$row['categoryid']] =& $item;
            unset($item);
        }
        return $ret;
    }

    /**
     * @param int $parentid
     * @param int $catsCount
     * @param string $spaces
     * @return int
     */
    public function countArticlesByCat($parentid, &$catsCount, $spaces = '')
    {
        global $resultCatCounts;

        $newspaces = $spaces . '--';

        $thecount = 0;
        foreach ($catsCount[$parentid] as $subCatId => $count) {
            $thecount = $thecount + $count;

            $resultCatCounts[$subCatId] = $count;
            if (isset($catsCount[$subCatId])) {
                $thecount = $thecount + $this->countArticlesByCat($subCatId, $catsCount, $newspaces);
                $resultCatCounts[$subCatId] = $thecount;
            }
        }
        return $thecount;

    }

    /**
     * @param int $cat_id
     * @param array $status
     * @param bool $inSubCat
     * @return array
     */
    public function getCountsByCat($cat_id = 0, $status = array(), $inSubCat = false)
    {
        global $publisher_isAdmin, $resultCatCounts;
        $ret = array();
        $catsCount = array();
        $sql = 'SELECT c.parentid, i.categoryid, COUNT(*) AS count FROM ' . $this->db->prefix('publisher_items') . ' AS i INNER JOIN ' . $this->db->prefix('publisher_categories') . ' AS c ON i.categoryid=c.categoryid';
        if (intval($cat_id) > 0) {
            $sql .= ' WHERE i.categoryid = ' . intval($cat_id);
            $sql .= ' AND i.status IN (' . implode(',', $status) . ')';
        } else {
            $sql .= ' WHERE i.status IN (' . implode(',', $status) . ')';
            if (!$publisher_isAdmin) {
                $items = $this->_handler->permission()->getGrantedItems('item_read');
                $sql .= ' AND i.itemid IN (' . implode(',', $items) . ')';
            }
        }
        $sql .= ' GROUP BY i.categoryid ORDER BY c.parentid ASC, i.categoryid ASC';

        $result = $this->db->query($sql);
        if (!$result) {
            return $ret;
        }

        if (!$inSubCat) {
            while ($row = $this->db->fetchArray($result)) {
                $catsCount[$row['categoryid']] = $row['count'];
            }
            return $catsCount;
        }

        while ($row = $this->db->fetchArray($result)) {
            $catsCount[$row['parentid']][$row['categoryid']] = $row['count'];
        }

        $resultCatCounts = array();
        foreach ($catsCount[0] as $subCatId => $count) {
            $resultCatCounts[$subCatId] = $count;
            if (isset($catsCount[$subCatId])) {
                $resultCatCounts[$subCatId] = $resultCatCounts[$subCatId] + $this->countArticlesByCat($subCatId, $catsCount);
            }
        }

        return $resultCatCounts;
    }
}