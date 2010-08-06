<?php

/**
 * Contains the classes for managing clips
 *
 * @license GNU
 * @author marcan <marcan@smartfactory.ca>
 * @version $Id: clip.php,v 1.6 2005/06/02 19:50:59 fx2024 Exp $
 * @link http://www.smartfactory.ca The SmartFactory
 * @package SmartMedia
 * @subpackage Clips
 */

/** Status of an offline clip */
define("_SMEDIA_CLIP_STATUS_OFFLINE", 1);
/** Status of an online clip */
define("_SMEDIA_CLIP_STATUS_ONLINE", 2);

/**
 * SmartMedia Clip class
 *
 * Class representing a single clip object
 *
 * @package SmartMedia
 * @author marcan <marcan@smartfactory.ca>
 * @link http://www.smartfactory.ca The SmartFactory
 */

class SmartmediaClip extends XoopsObject {

    /**
     * Language of the clip
     * @var string
     */
    var $languageid;

    /**
     * {@link SmartmediaClip_text} object holding the clip's text informations
     * @var object
     * @see SmartmediaClip_text
     */
    var $clip_text = null;

    /**
     * List of all the translations already created for this clip
     * @var array
     * @see getCreatedLanguages
     */
    var $_created_languages = null;

    /**
     * Flag indicating wheter or not a new translation can be added for this clip
     *
     * If all languages of the site are also in {@link $_created_languages} then no new
     * translation can be created
     * @var bool
     * @see canAddLanguage
     */
    var $_canAddLanguage = null;

    /**
     * Constructor
     *
     * @param string $languageid language of the clip
     * @param int $id id of the clip to be retreieved OR array containing values to be assigned
     */
    function SmartmediaClip($languageid='default', $id = null)
    {
        $smartConfig =& smartmedia_getModuleConfig();

        $this->initVar('clipid', XOBJ_DTYPE_INT, -1, true);
        $this->initVar('languageid', XOBJ_DTYPE_TXTBOX, $smartConfig['default_language'], false);
        $this->initVar('folderid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('statusid', XOBJ_DTYPE_INT, _SMEDIA_CLIP_STATUS_ONLINE, false);
        $this->initVar('created_date', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('created_uid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('modified_date', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('modified_uid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('duration', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('formatid', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('width', XOBJ_DTYPE_INT, 320, false);
        $this->initVar('height', XOBJ_DTYPE_INT, 260, false);
        $this->initVar('autostart', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('weight', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('image_hr', XOBJ_DTYPE_TXTBOX, null, false, 50);
        $this->initVar('counter', XOBJ_DTYPE_INT, 0, false);
        $this->initVar('image_lr', XOBJ_DTYPE_TXTBOX, null, false, 50);
        $this->initVar('file_hr', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('file_lr', XOBJ_DTYPE_TXTBOX, null, false);
        $this->initVar('default_languageid', XOBJ_DTYPE_TXTBOX, $smartConfig['default_language'], false, 50);

        $this->initVar('folderid', XOBJ_DTYPE_INT, 0, false);

        if (isset($id)) {
            if (is_array($id)) {
                $this->assignVars($id);
            }
        } else {
            $this->setNew();
        }

        if ($languageid == 'default') {
            $languageid = $this->default_languageid();
        }

        $this->loadLanguage($languageid);
    }

    /**
     * Check if the clip was successfully loaded
     *
     * @return bool true if not loaded, false if correctly loaded
     */
    function notLoaded()
    {
        return ($this->clipid()== -1);
    }

    /**
     * Loads the specified translation for this clip
     *
     * If the specified language does not have any translation yet, the translation corresponding
     * to the default language will be loaded
     *
     * @param string $languageid language of the translation to load
     */
    function loadLanguage($languageid)
    {
        $this->languageid = $languageid;
        $smartmedia_clip_text_handler =& smartmedia_gethandler('clip_text');
        $this->clip_text =& $smartmedia_clip_text_handler->get($this->getVar('clipid'), $this->languageid);
        if (!$this->clip_text) {
            $this->clip_text =& new SmartmediaClip_text();
            $this->clip_text->setVar('clipid', $this->clipid());
            $this->clip_text->setVar('languageid', $languageid);

            $default_clip_text =& $smartmedia_clip_text_handler->get($this->getVar('clipid'), $this->default_languageid());

            if ($default_clip_text) {
                //$this->clip_text =& $default_clip_text;
                $this->clip_text->setVar('title', $default_clip_text->title());
                $this->clip_text->setVar('description', $default_clip_text->description());
                $this->clip_text->setVar('meta_description', $default_clip_text->meta_description());
                $this->clip_text->setVar('tab_caption_1', $default_clip_text->tab_caption_1());
                $this->clip_text->setVar('tab_text_1', $default_clip_text->tab_text_1());
                $this->clip_text->setVar('tab_caption_2', $default_clip_text->tab_caption_2());
                $this->clip_text->setVar('tab_text_2', $default_clip_text->tab_text_2());
                $this->clip_text->setVar('tab_caption_3', $default_clip_text->tab_caption_3());
                $this->clip_text->setVar('tab_text_3', $default_clip_text->tab_text_3());
            }
        }
    }

    /**
     * @return int id of this clip
     */
    function clipid()
    {
        return $this->getVar("clipid");
    }

    /**
     * @return string spoken language of this clip
     */
    function languageid()
    {
        return $this->getVar("languageid", $format);
    }

    /**
     * @return int duration in minutes of this clip
     */
    function duration()
    {
        return $this->getVar("duration");
    }

    /**
     * @return int format id of this clip
     * @see SmartmediaFormat
     */
    function formatid()
    {
        return $this->getVar("formatid");
    }

    /**
     * @return int width of this clip
     */
    function width()
    {
        return ($this->getVar("width") == 0 ? 320 : $this->getVar("width"));
    }

    /**
     * @return int height of this clip
     */
    function height()
    {
        return ($this->getVar("height") == 0 ? 260 : $this->getVar("height"));
    }

    /**
     * Returns the high resolution image of this clip
     *
     * If no image has been set, the function will return blank.png, so a blank image can
     * be displayed
     *
     * @param string $format format to use for the output
     * @return string high resolution image of this clip
     */
    function image_hr($format="S")
    {
        if ($this->getVar('image_hr') != '') {
            return $this->getVar('image_hr', $format);
        } else {
            return 'blank.png';
        }
    }

    /**
     * Returns the low resolution image of this clip
     *
     * If no image has been set, the function will return blank.png, so a blank image can
     * be displayed
     *
     * @param string $format format to use for the output
     * @return string low resolution image of this clip
     */
    function image_lr($format="S")
    {
        if ($this->getVar('image_lr') != '') {
            return $this->getVar('image_lr', $format);
        } else {
            return 'blank.png';
        }
    }

    /**
     * @param string $format format to use for the output
     * @return string high resolution file of the clip
     */
    function file_hr($format="S")
    {
        return $this->getVar("file_hr", $format);
    }

    /**
     * @param string $format format to use for the output
     * @return string low resolution file of the clip
     */
    function file_lr($format="S")
    {
        return $this->getVar("file_lr", $format);
    }

    /**
     * @return string weight of this clip
     */
    function weight()
    {
        return $this->getVar("weight");
    }

    /**
     * @return int counter of this clip
     */
    function counter()
    {
        return $this->getVar("counter");
    }

    /**
     * @return string wether or not the clip shall start automatically
     */
    function autostart()
    {
        return $this->getVar("autostart");
    }

    /**
     * Returns the folderid to which this clip belongs
     * @see SmartmediaFolder
     * @return string parent folderid of this clip
     */
    function folderid()
    {
        return $this->getVar("folderid");
    }

    /**
     * Returns the status of the clip
     *
     * Status can be {@link _SMEDIA_CLIP_STATUS_OFFLINE} or {@link _SMEDIA_CLIP_STATUS_ONLINE}
     * @return string status of the clip
     */
    function statusid()
    {
        return $this->getVar("statusid");
    }

    /**
     * Returns the date of creation of the clip
     *
     * The date will be formated according to the date format preference of the module
     * @return string date of creation of the clip
     */
    function created_date()
    {
        If ($dateFormat == 'none') {
            $smartConfig =& smartmedia_getModuleConfig();
            if (isset($smartConfig['dateformat'])) {
                $dateFormat = $smartConfig['dateformat'];
            } else {
                $dateFormat = 'Y-m-d';
            }
        }

        return formatTimestamp($this->getVar('created_date', $format), $dateFormat);
    }

    /**
     * @return int uid of the user who created the clip
     */
    function created_uid()
    {
        return $this->getVar("created_uid");
    }

    /**
     * Returns the date of modification of the clip
     *
     * The date will be formated according to the date format preference of the module
     * @return string date of modification of the clip
     */
    function modified_date()
    {
        $ret = $this->getVar("modified_date");
        $ret = formatTimestamp($ret, 'Y-m-d');
        return $ret;
    }

    /**
     * @return int uid of the user who modified the clip
     */
    function modified_uid()
    {
        return $this->getVar("modified_uid");
    }

    /**
     * Returns the default language of the clip
     *
     * When no translation corresponding to the selected language is available, the clip's
     * information will be displayed in this language
     *
     * @return string default language of the clip
     */
    function default_languageid($format="S")
    {
        return $this->getVar("default_languageid", $format);
    }

    /**
     * Returns the title of the clip
     *
     * If the format is "clean", the title will be return, striped from any html tag. This clean
     * title is likely to be used in the page title meta tag or any other place that requires
     * "html less" text
     *
     * @param string $format format to use for the output
     * @return string title of the clip
     */
    function title($format="S")
    {
        $myts =& MyTextSanitizer::getInstance();
        if ((strtolower($format) == 's') || (strtolower($format) == 'show')) {
            return $myts->undoHtmlSpecialChars($this->clip_text->getVar("title", 'e' ), 1);
        } elseif ((strtolower($format) == 'clean')) {
            return smartmedia_metagen_html2text($myts->undoHtmlSpecialChars($this->clip_text->getVar("title")));
        } else {
            return $this->clip_text->getVar("title", $format);
        }
    }

    /**
     * Returns the description of the clip
     *
     * @param string $format format to use for the output
     * @return string description of the clip
     */
    function description($format="S")
    {
        return $this->clip_text->getVar("description", $format);
    }

    /**
     * Returns the meta-description of the clip
     *
     * @param string $format format to use for the output
     * @return string meta-description of the clip
     */
    function meta_description($format="S")
    {
        return $this->clip_text->getVar("meta_description", $format);
    }

    /**
     * Returns the caption of the first tab for this clip
     *
     * Note that for the first tab to be displayed, the field {@link tab_text_1} needs to
     * ne not empty
     *
     * @param string $format format to use for the output
     * @return string caption of the first tab of the clip
     */
    function tab_caption_1($format="S")
    {
        return $this->clip_text->getVar("tab_caption_1", $format);
    }

    /**
     * Returns the text of the first tab for this clip
     *
     * Note that for the first tab to be displayed, this field needs to  ne not empty
     *
     * @param string $format format to use for the output
     * @return string text of the first tab of the clip
     */
    function tab_text_1($format="S")
    {
        return $this->clip_text->getVar("tab_text_1", $format);
    }


    /**
     * Returns the caption of the second tab for this clip
     *
     * Note that for the first tab to be displayed, the field {@link tab_text_2} needs to
     * ne not empty
     *
     * @param string $format format to use for the output
     * @return string caption of the second tab of the clip
     */
    function tab_caption_2($format="S")
    {
        return $this->clip_text->getVar("tab_caption_2", $format);
    }

    /**
     * Returns the text of the second tab for this clip
     *
     * Note that for the first tab to be displayed, this field needs to  ne not empty
     *
     * @param string $format format to use for the output
     * @return string text of the second tab of the clip
     */
    function tab_text_2($format="S")
    {
        return $this->clip_text->getVar("tab_text_2", $format);
    }

    /**
     * Returns the caption of the third tab for this clip
     *
     * Note that for the first tab to be displayed, the field {@link tab_text_2} needs to
     * ne not empty
     *
     * @param string $format format to use for the output
     * @return string caption of the third tab of the clip
     */
    function tab_caption_3($format="S")
    {
        return $this->clip_text->getVar("tab_caption_3", $format);
    }

    /**
     * Returns the text of the third tab for this clip
     *
     * Note that for the first tab to be displayed, this field needs to  ne not empty
     *
     * @param string $format format to use for the output
     * @return string text of the third tab of the clip
     */
    function tab_text_3($format="S")
    {
        return $this->clip_text->getVar("tab_text_3", $format);
    }

    /**
     * Set a text variable of the clip
     *
     * @param string $key of the variable to set
     * @param string $value of the field to set
     * @see SmartmediaClip_text
     */
    function setTextVar($key, $value)
    {
        $this->clip_text->setVar($key, $value);
    }

    /**
     * Get the complete URL of this clip
     *
     * @param int $categoryid category to which belong the parent folder of the clip
     * @return string complete URL of this clip
     */
    function getItemUrl($categoryid)
    {
        return SMARTMEDIA_URL . "clip.php?categoryid=" . $categoryid . "&folderid=" . $this->folderid() . "&clipid=" . $this->clipid();
    }

    /**
     * Get the complete hypertext link of this clip
     *
     * @param int $categoryid category to which belong the parent folder of the clip
     * @param int $max_title_length maximum characters allowes in the title
     * @return string complete hypertext link of this clip
     */
    function getItemLink($categoryid, $max_title_length=0)
    {
        if ($max_title_length > 0) {
            $title = xoops_substr($this->title(), 0, $max_title_length);
        } else {
            $title = $this->title();
        }

        return "<a href='" . $this->getItemUrl($categoryid) . "'>" . $title . "</a>";
    }

    /**
     * Stores the clip in the database
     *
     * This method stores the clip as well as the current translation informations for the
     * clip
     *
     * @param bool $force
     * @return bool true if successfully stored false if an error occured
     *
     * @see SmartmediaClipHandler::insert()
     * @see SmartmediaClip_text::store()
     */
    function store($force = true)
    {
        global $smartmedia_clip_handler;
        if (!$smartmedia_clip_handler->insert($this, $force)) {
            return false;
        }
        $this->clip_text->setVar('clipid', $this->clipid());
        return $this->clip_text->store();
    }

    /**
     * Get all the translations created for this clip
     *
     * @param bool $exceptDefault to determine if the default language should be returned or not
     * @return array array of {@link SmartmediaClip_text}
     */
    function getAllLanguages($exceptDefault = false)
    {
        global $smartmedia_clip_text_handler;
        $criteria = new	CriteriaCompo();
        $criteria->add(new Criteria('clipid', $this->clipid()));
        if ($exceptDefault) {
            $criteria->add(new Criteria('languageid', $this->default_languageid(), '<>'));
        }
        return $smartmedia_clip_text_handler->getObjects($criteria);
    }

    /**
     * Get a list of created language
     *
     * @return array array containing the language name of the created translations for this clip
     * @see _created_languages
     * @see SmartmediaClip_text::getCreatedLanguages()
     */
    function getCreatedLanguages()
    {
        if ($this->_created_languages != null) {
            return $this->_created_languages;
        }
        global $smartmedia_clip_text_handler;
        $this->_created_languages =  $smartmedia_clip_text_handler->getCreatedLanguages($this->clipid());
        return $this->_created_languages;
    }

    /**
     * Check to see if other translations can be added
     *
     * If all languages of the site are also in {@link $_created_languages} then no new
     * translation can be created
     *
     * @return bool true if new translation can be added false if all translation have been created
     * @see _canAddLanguage
     * @see getCreatedLanguages
     */
    function canAddLanguage()
    {
        if ($this->_canAddLanguage != null) {
            return $this->_canAddLanguage;
        }

        include_once XOOPS_ROOT_PATH."/class/xoopslists.php";
        $languageList = XoopsLists::getLangList();
        $createdLanguages = $this->getCreatedLanguages();

        $this->_canAddLanguage = (count($languageList) > count($createdLanguages));
        return $this->_canAddLanguage;
    }

    /**
     * Render the admin links for this clip
     *
     * This method will create links to Edit and Delete the clip. The method will also check
     * to ensure the user is admin of the module if not, the method will return an empty string
     *
     * @return string hypertext links to edit and delete the clip
     * @see $is_smartmedia_admin
     */
    function adminLinks()
    {
        global $is_smartmedia_admin;
        if ($is_smartmedia_admin) {
            $ret = '';
            $ret .= '<a href="' . SMARTMEDIA_URL . 'admin/clip.php?op=mod&clipid=' . $this->clipid() . '&folderid=' . $this->folderid() . '"><img src="' . smartmedia_getModuleImageDir('links', false) . 'edit.gif" alt="' . _MD_SMEDIA_CLIP_EDIT . '" title="' . _MD_SMEDIA_CLIP_EDIT . '" /></a>';
            $ret .= '<a href="' . SMARTMEDIA_URL . 'admin/clip.php?op=del&clipid=' . $this->clipid() . '&folderid=' . $this->folderid() . '"><img src="' . smartmedia_getModuleImageDir('links', false) . 'delete.gif" alt="' . _MD_SMEDIA_CLIP_DELETE . '" title="' . _MD_SMEDIA_CLIP_DELETE . '" /></a>';
            return $ret;
        } else {
            return '';
        }
    }

    /**
     * Render the template of the clip's format
     *
     * This method creates the format object associated to the clip's format and then renders
     * the template of the format
     *
     * @return string template of the clip's format
     * @see SmartmediaFormat
     * @see SmartmediaFormat::render()
     */
    function renderTemplate()
    {
        $smartmedia_format_handler = xoops_getmodulehandler('format', 'smartmedia');
        $formatObj = $smartmedia_format_handler->get($this->formatid());
        return $formatObj->render($this);
    }

    /**
     * Format the clip information into an array
     *
     * This method puts each usefull informations of the clip into an array that will be used in
     * the module template
     *
     * @param int $categoryid category to which belong the parent folder of the clip
     * @return array array containing usfull informations of the clip
     */
    function toArray($categoryid, $max_title_length=0, $forBlock=false) {
        $clip['clipid'] = $this->clipid();
        $clip['itemurl'] = $this->getItemUrl($categoryid);
        $clip['itemlink'] = $this->getItemLink($categoryid, $max_title_length);

        If ($forBlock) {
            return $clip;
        }

        $clip['duration'] = $this->duration();

        $clip['template'] = $this->renderTemplate();

        $clip['width'] = $this->width();
        $clip['height'] = $this->height();

        $clip['weight'] = $this->weight();
        $clip['counter'] = $this->counter();
        $clip['statusid'] = $this->statusid();
        $clip['autostart'] = $this->autostart();
        $clip['counter'] = $this->counter();

        if ($this->getVar('image_hr') != 'blank.png') {
            $clip['image_hr_path'] = smartmedia_getImageDir('clip', false) . $this->image_hr();
        } else {
            $clip['image_hr_path'] = false;
        }

        $smartConfig =& smartmedia_getModuleConfig();
        $clip['main_image_width'] = $smartConfig['main_image_width'];
        $clip['list_image_width'] = $smartConfig['list_image_width'];

        $clip['image_lr_path'] = smartmedia_getImageDir('clip', false) . $this->image_lr();
        $clip['file_hr_path'] = $this->file_hr();
        $clip['file_lr_path'] = $this->file_lr();

        $clip['file_hr_link'] = "<a href='" . $this->file_hr() . "' target='_blank'>" . _MD_SMEDIA_HIGH_RES_CLIP . "</a>";

        $clip['adminLinks'] = $this->adminLinks();

        $clip['title'] = $this->title();
        $clip['clean_title'] = $clip['title'];
        $clip['description'] = $this->description();
        $clip['meta_description'] = $this->meta_description();

        $clip['tab_caption_1'] = $this->tab_caption_1();
        $clip['tab_text_1'] = $this->tab_text_1();
        $clip['tab_caption_2'] = $this->tab_caption_2();
        $clip['tab_text_2'] = $this->tab_text_2();
        $clip['tab_caption_3'] = $this->tab_caption_3();
        $clip['tab_text_3'] = $this->tab_text_3();

        // Hightlighting searched words
        $highlight = true;
        if($highlight && isset($_GET['keywords']))
        {
            $myts =& MyTextSanitizer::getInstance();
            $keywords=$myts->htmlSpecialChars(trim(urldecode($_GET['keywords'])));
            $h= new keyhighlighter ($keywords, true , 'smartmedia_highlighter');
            $clip['title'] = $h->highlight($clip['title']);
            $clip['description'] = $h->highlight($clip['description']);
            $clip['tab_caption_1'] = $h->highlight($clip['tab_caption_1']);
            $clip['tab_text_1'] = $h->highlight($clip['tab_text_1']);
            $clip['tab_caption_2'] = $h->highlight($clip['tab_caption_2']);
            $clip['tab_text_2'] = $h->highlight($clip['tab_text_2']);
            $clip['tab_caption_3'] = $h->highlight($clip['tab_caption_3']);
            $clip['tab_text_3'] = $h->highlight($clip['tab_text_3']);
        }

        return $clip;
    }

    /**
     * Update the counter of the clip by one
     */
    function updateCounter()
    {
        $this->setVar('counter', $this->counter() + 1);
        $this->store();
    }

}

/**
 * Smartmedia Clip Handler class
 *
 * Clip Handler responsible for handling {@link SmartmediaClip} objects
 *
 * @package SmartMedia
 * @author marcan <marcan@smartfactory.ca>
 * @link http://www.smartfactory.ca The SmartFactory
 */

class SmartmediaClipHandler extends XoopsObjectHandler {
    /**
     * Database connection
     *
     * @var	object
     */
    var $_db;

    /**
     * Name of child class
     *
     * @var	string
     */
    var $classname = 'smartmediaclip';

    /**
     * Related table name
     *
     * @var string
     */
    var $_dbtable = 'smartmedia_clips';
     
    /**
     * DB parent table name
     *
     * @var string
     */
    var $_dbtable_parent = 'smartmedia_folders_categories';
     
    /**
     * Related parent field name
     *
     * @var string
     */
    var $_parent_field = 'folderid';
     
    /**
     * Key field name
     *
     * @var string
     */
    var $_key_field = 'clipid';

    /**
     * Caption field name
     *
     * @var string
     */
    var $_caption_field = 'title';

    /**
     * Constructor
     *
     * @param object $db reference to a xoopsDB object
     */
    function SmartmediaClipHandler(&$db)
    {
        $this->_db = $db;
    }

    /**
     * Singleton - prevent multiple instances of this class
     *
     * @param object &$db {@link XoopsHandlerFactory}
     * @return object SmartmediaClipHandler
     */
    function &getInstance(&$db)
    {
        static $instance;
        if(!isset($instance)) {
            $instance = new SmartmediaClipHandler($db);
        }
        return $instance;
    }

    /**
     * Creates a new clip object
     *
     * @return object SmartmediaClip
     */
    function &create()
    {
        return new $this->classname();
    }

    /**
     * Retrieve a clip object from the database
     *
     * If no languageid is specified, the method will load the translation related to the current
     * language selected by the user
     *
     * @param int $id id of the clip
     * @param string $languageid language of the translation to load
     * @return mixed reference to the {@link SmartmediaClip} object, FALSE if failed
     */
    function &get($id, $languageid='current')
    {
        $id = intval($id);
        if($id > 0) {
            $sql = $this->_selectQuery(new Criteria('clipid', $id));

            //echo "<br />$sql<br/>";

            if(!$result = $this->_db->query($sql)) {
                return false;
            }
            $numrows = $this->_db->getRowsNum($result);
            if($numrows == 1) {
                if ($languageid == 'current') {
                    global $xoopsConfig;
                    $languageid = $xoopsConfig['language'];
                }
                $obj = new $this->classname($languageid, $this->_db->fetchArray($result));
                return $obj;
            }
        }
        return false;
    }

    /**
     * Create a "SELECY" SQL query
     *
     * @param object $criteria {@link CriteriaElement} to match
     * @return	string SQL query
     */
    function _selectQuery($criteria = null)
    {
        $sql = sprintf('SELECT * FROM %s', $this->_db->prefix($this->_dbtable));
        if(isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' .$criteria->renderWhere();
            if($criteria->getSort() != '') {
                $sql .= ' ORDER BY ' . $criteria->getSort() . '
                    ' .$criteria->getOrder();
            }
        }
        return $sql;
    }

    /**
     * Count objects matching a criteria
     *
     * @param object $criteria {@link CriteriaElement} to match
     * @return int count of objects
     */
    function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM '.$this->_db->prefix($this->_dbtable);
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
        }
        if (!$result =& $this->_db->query($sql)) {
            return 0;
        }
        list($count) = $this->_db->fetchRow($result);
        return $count;
    }

    /**
     * Count clips belonging to a specific folder
     *
     * If no categoryid is specified, the method will count all clips in the module
     *
     * @param int $categoryid category in which to count clips
     * @return int count of objects
     */
    function getclipsCount($categoryid=0)
    {

        $criteria = new CriteriaCompo();
        If (isset($categoryid) && ($categoryid != 0)) {
            $criteria->add(new criteria('categoryid', $categoryid));
            return $this->getCount($criteria);
        } else {
            return $this->getCount();
        }
    }

    /**
     * Retrieve objects from the database
     *
     * @param object $criteria {@link CriteriaElement} conditions to be met
     * @param bool $id_as_key Should the clip ID be used as array key
     * @return array array of {@link SmartmediaClip} objects
     */
    function &getObjects($criteria = null, $category_id_as_key = false)
    {
        Global $xoopsConfig;
        $smartConfig =& smartmedia_getModuleConfig();
         
        $ret    = array();
        $limit  = $start = 0;
        $sql    = $this->_selectQuery($criteria);

        if (isset($criteria)) {
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }

        //echo "<br />$sql<br />";

        $result = $this->_db->query($sql, $limit, $start);
        // If no records from db, return empty array
        if (!$result) {
            return $ret;
        }

        // Add each returned record to the result array
        while ($myrow = $this->_db->fetchArray($result)) {
            $obj = new $this->classname($xoopsConfig['language'], $myrow);
            if (!$category_id_as_key) {
                $ret[$obj->getVar('clipid')] =& $obj;
            } else {
                $ret[$myrow['folderid']][$obj->getVar('clipid')] =& $obj;
            }
            unset($obj);
        }
        return $ret;
    }

    /**
     * Get a list of {@link SmartmediaClip} objects for the search feature
     *
     * @param array $queryarray list of keywords to look for
     * @param string $andor specify which type of search we are performing : AND or OR
     * @param int $limit maximum number of results to return
     * @param int $offset at which clip shall we start
     * @param int $userid userid related to the creator of the clip
     *
     * @return array array containing information about the clips mathing the search criterias
     */
    function &getObjectsForSearch($queryarray = array(), $andor = 'AND', $limit = 0, $offset = 0, $userid = 0)
    {
        global $xoopsConfig;

        $ret    = array();
        $sql    = "SELECT item." . $this->_key_field . ", itemtext." . $this->_caption_field . ", itemtext.description, itemtext.tab_caption_1, itemtext.tab_text_1, itemtext.tab_caption_2, itemtext.tab_text_2, itemtext.tab_caption_3, itemtext.tab_text_3, parent.categoryid, parent.folderid FROM
                   (
        			 (" . $this->_db->prefix($this->_dbtable) . " AS item
					   INNER JOIN " . $this->_db->prefix($this->_dbtable) . "_text AS itemtext 
        		       ON item." . $this->_key_field . " = itemtext." . $this->_key_field . "
        		     )
        		     INNER JOIN " . $this->_db->prefix($this->_dbtable_parent) . " AS parent
         		     ON parent." . $this->_parent_field . " = item." . $this->_parent_field .	"
                   ) 
                   ";

        If ($queryarray) {
            $criteriaKeywords = new CriteriaCompo();
            for ($i = 0; $i < count($queryarray); $i++) {
                $criteriaKeyword = new CriteriaCompo();
                $criteriaKeyword->add(new Criteria('itemtext.title', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                $criteriaKeyword->add(new Criteria('itemtext.description', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                $criteriaKeyword->add(new Criteria('itemtext.tab_caption_1', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                $criteriaKeyword->add(new Criteria('itemtext.tab_text_1', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                $criteriaKeyword->add(new Criteria('itemtext.tab_caption_2', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                $criteriaKeyword->add(new Criteria('itemtext.tab_text_2', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                $criteriaKeyword->add(new Criteria('itemtext.tab_caption_3', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                $criteriaKeyword->add(new Criteria('itemtext.tab_text_3', '%' . $queryarray[$i] . '%', 'LIKE'), 'OR');
                $criteriaKeywords->add($criteriaKeyword, $andor);
            }
        }

        if ($userid != 0) {
            $criteriaUser = new CriteriaCompo();
            $criteriaUser->add(new Criteria('item.uid', $userid), 'OR');
        }

        $criteria = new CriteriaCompo();

        // Languageid
        $criteriaLanguage = new CriteriaCompo();
        $criteriaLanguage->add(new Criteria('itemtext.languageid', $xoopsConfig['language']));
        $criteria->add($criteriaLanguage);

        If (!empty($criteriaUser)) {
            $criteria->add($criteriaUser, 'AND');
        }

        If (!empty($criteriaKeywords)) {
            $criteria->add($criteriaKeywords, 'AND');
        }

        $criteria->setSort('item.weight');
        $criteria->setOrder('ASC');

        if(isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' ' .$criteria->renderWhere();
            if($criteria->getSort() != '') {
                $sql .= ' ORDER BY ' . $criteria->getSort() . '
                    ' .$criteria->getOrder();
            }
        }

        //echo "<br />$sql<br />";

        $result = $this->_db->query($sql, $limit, $offset);
        // If no records from db, return empty array
        if (!$result) {
            return $ret;
        }

        // Add each returned record to the result array
        while ($myrow = $this->_db->fetchArray($result)) {
            $item['id'] = $myrow[$this->_key_field];
            $item['title'] = $myrow[$this->_caption_field];
            $item['folderid'] = $myrow['folderid'];
            $item['categoryid'] = $myrow['categoryid'];

            $ret[] = $item;
            unset($item);
        }
        return $ret;
    }

    /**
     * Get a list of {@link SmartmediaClip}
     *
     * @param int $limit maximum number of results to return
     * @param int $start at which clip shall we start
     * @param int $categoryid category to which belong the parent folder of the clip
     * @param string $sort sort parameter
     * @param string $order order parameter
     * @param bool $category_id_as_key wether or not the categoryid should be used as array key
     *
     * @return array array of {@link SmartmediaClip}
     */
    function &getClips($limit=0, $start=0, $categoryid=0, $sort='weight', $order='ASC', $category_id_as_key = true)
    {
        $criteria = new CriteriaCompo();

        if (isset($categoryid) && ($categoryid != 0)) {
            $criteria->add(new criteria('folderid', $categoryid));
        }

        $criteria->setSort($sort);
        $criteria->setOrder($order);

        $criteria->setStart($start);
        $criteria->setLimit($limit);
        return $this->getObjects($criteria, $category_id_as_key);
    }

    /**
     * Get a list of {@link SmartmediaClip} used in the admin index page
     *
     * @param int $start at which clip shall we start
     * @param int $limit maximum number of results to return
     * @param string $sort sort parameter
     * @param string $order order parameter
     * @param string $languagesel specific language
     *
     * @return array array of {@link SmartmediaClip}
     */
    function &getClipsFromAdmin($start=0, $limit=0, $sort='clipid', $order='ASC', $languagesel)
    {
        if($languagesel != 'all'){
            $where = "WHERE clips_text.languageid = '". $languagesel . "'";
        }
        else{
            $where = "";
        }
        Global $xoopsConfig, $xoopsDB;
        $smartConfig =& smartmedia_getModuleConfig();
        $ret    = array();
        $sql    =  "SELECT DISTINCT clips.clipid, clips.weight, clips_text.title, folders.folderid, folders_text.title AS foldertitle, categories.categoryid
					FROM (
					    " . $xoopsDB->prefix('smartmedia_clips') . " AS clips
    					INNER JOIN " . $this->_db->prefix('smartmedia_clips_text') . " AS clips_text ON clips.clipid = clips_text.clipid
  					  )
					INNER JOIN " . $this->_db->prefix('smartmedia_folders') . " AS folders ON clips.folderid=folders.folderid
    				
					INNER JOIN " . $this->_db->prefix('smartmedia_folders_text') . " AS folders_text ON folders.folderid = folders_text.folderid

   					INNER JOIN " . $this->_db->prefix('smartmedia_folders_categories') . " AS categories
					ON folders.folderid = categories.folderid "
					. $where . "
        		    ORDER BY $sort $order        
        ";

					//echo "<br />$sql<br />";
					 
					$result = $this->_db->query($sql, $limit, $start);
					// If no records from db, return empty array
					if (!$result) {
					    return $ret;
					}

					// Add each returned record to the result array
					while ($myrow = $this->_db->fetchArray($result)) {
					    $item = array();
					    $item['clipid'] = $myrow['clipid'];
					    $item['weight'] = $myrow['weight'];
					    $item['title'] = $myrow['title'];
					    $item['folderid'] = $myrow['folderid'];
					    $item['foldertitle'] = $myrow['foldertitle'];
					    $item['categoryid'] = $myrow['categoryid'];
					    $ret[] = $item;
					    unset($item);
					}
					return $ret;
    }

    /**
     * Get count of clips for the admin index page
     *
     * @param string $languagesel specific language
     *
     * @return int count of clips
     */
    function &getClipsCountFromAdmin($languagesel)
    {
        Global $xoopsConfig, $xoopsDB;
        $smartConfig =& smartmedia_getModuleConfig();

        if($languagesel== 'all'){
            $where= "";
        }
        else{
            $where = "WHERE clips_text.languageid = '" . $languagesel . "'";
        }
        $sql    =  "SELECT COUNT(DISTINCT clips.clipid)
					FROM (
					    " . $xoopsDB->prefix('smartmedia_clips') . " AS clips
    					INNER JOIN " . $this->_db->prefix('smartmedia_clips_text') . " AS clips_text ON clips.clipid = clips_text.clipid
						)
    					INNER JOIN " . $this->_db->prefix('smartmedia_folders') . " AS folders ON clips.folderid=folders.folderid
    					INNER JOIN " . $this->_db->prefix('smartmedia_folders_text') . " AS folders_text ON folders.folderid = folders_text.folderid
					INNER JOIN " . $this->_db->prefix('smartmedia_folders_categories') . " AS categories
					ON folders.folderid = categories.folderid
				    
        ".$where;

        //echo "<br />$sql<br />";

        if (!$result =& $this->_db->query($sql)) {
            return 0;
        }
        list($count) = $this->_db->fetchRow($result);
        return $count;
    }

    /**
     * Get count of clips by folder
     *
     * @param int $parent_id folderid in which to count the clips
     *
     * @return int count of clips
     */
    function getCountsByParent($parent_id = 0) {
        $ret = array();
        $sql = 'SELECT ' . $this->_parent_field . ' AS parentid, COUNT(' . $this->_key_field . ' ) AS count
				FROM '.$this->_db->prefix($this->_dbtable) .'';

        if (intval($parent_id) > 0) {
            $sql .= ' WHERE ' . $this->_parent_field . ' = '.intval($parent_id);
        }
        $sql .= ' GROUP BY ' . $this->_parent_field;

        //echo "<br />$sql<br />";

        $result = $this->_db->query($sql);
        if (!$result) {
            return $ret;
        }
        while ($row = $this->_db->fetchArray($result)) {
            $ret[$row['parentid']] = intval($row['count']);
        }
        return $ret;
    }

    /**
     * Stores a clip in the database
     *
     * @param object $obj reference to the {@link SmartmediaClip} object
     * @param bool $force
     * @return bool FALSE if failed, TRUE if already present and unchanged or successful
     */
    function insert(&$obj, $force = false)
    {
        // Make sure object is of correct type
        if (strtolower(get_class($obj)) != $this->classname) {
            return false;
        }

        // Make sure object needs to be stored in DB
        if (!$obj->isDirty()) {
            return true;
        }

        // Make sure object fields are filled with valid values
        if (!$obj->cleanVars()) {
            return false;
        }

        // Copy all object vars into local variables
        foreach ($obj->cleanVars as $k => $v) {
            ${$k} = $v;
        }

        // Create query for DB update
        if ($obj->isNew()) {
            // Determine next auto-gen ID for table
            $clipid = $this->_db->genId($this->_db->prefix($this->_dbtable).'_uid_seq');
            $sql = sprintf("INSERT INTO %s (
			clipid, 
			folderid,
			statusid,
			created_date,
			created_uid,
			modified_date,
			modified_uid, 
			languageid,
			duration,
			formatid,
			width,
			height,
			counter,
			autostart,
			image_lr,
			image_hr,
			file_lr,
			file_hr,
			weight,
			default_languageid) 
			VALUES (
			%u,
			%u,
			%u,
			%u,
			%u,
			%u,
			%u,
			%s,
			%u,
			%u,
			%u,
			%u,
			%u,
			%u,
			%s,
			%s,
			%s,
			%s,
			%u,
			%s)",
            $this->_db->prefix($this->_dbtable),
            $clipid,
            $folderid,
            $statusid,
            time(),
            $created_uid,
            time(),
            $modified_uid,
            $this->_db->quoteString($languageid),
            $duration,
            $formatid,
            $width,
            $height,
            $counter,
            $autostart,
            $this->_db->quoteString($image_lr),
            $this->_db->quoteString($image_hr),
            $this->_db->quoteString($file_lr),
            $this->_db->quoteString($file_hr),
            $weight,
            $this->_db->quoteString($default_languageid));
        } else {
            $sql = sprintf("UPDATE %s SET
		    folderid = %u,
		    statusid = %u,
		    created_date = %u,
		    created_uid = %u,
		    modified_date = %u,
		    modified_uid = %u,
		    languageid = %s,
		    duration = %u, 
		    formatid = %u,
		    width = %u,
		    height = %u,
		    counter = %u,
		    autostart = %u,
		    image_lr = %s,
		    image_hr = %s,	
		   	file_lr = %s,
		    file_hr = %s,	
		    weight = %u,
		    default_languageid = %s
		    WHERE clipid = %u",
            $this->_db->prefix($this->_dbtable),
            $folderid,
            $statusid,
            $created_date,
            $created_uid,
            time(),
            $modified_uid,
            $this->_db->quoteString($languageid),
            $duration,
            $formatid,
            $width,
            $height,
            $counter,
            $autostart,
            $this->_db->quoteString($image_lr),
            $this->_db->quoteString($image_hr),
            $this->_db->quoteString($file_lr),
            $this->_db->quoteString($file_hr),
            $weight,
            $this->_db->quoteString($default_languageid),
            $clipid);
        }

        //echo "<br />" . $sql . "<br />";

        // Update DB
        if (false != $force) {
            $result = $this->_db->queryF($sql);
        } else {
            $result = $this->_db->query($sql);
        }

        if (!$result) {
            return false;
        }

        //Make sure auto-gen ID is stored correctly in object
        if (empty($clipid)) {
            $clipid = $this->_db->getInsertId();
        }
        $obj->assignVar('clipid', $clipid);
        return true;
    }

    /**
     * Deletes a clip from the database
     *
     * @param object $obj reference to the {@link SmartmediaClip} obj to delete
     * @param bool $force
     * @return bool FALSE if failed.
     */
    function delete(&$obj, $force = false)
    {
        if (strtolower(get_class($obj)) != $this->classname) {
            return false;
        }

        $smartmedia_clip_text_handler = smartmedia_gethandler('clip_text');
        $criteria = new CriteriaCompo(new Criteria('clipid', $obj->clipid()));
        if (!$smartmedia_clip_text_handler->deleteAll($criteria)) {
            return false;
        }
        $sql = sprintf("DELETE FROM %s WHERE clipid = %u", $this->_db->prefix($this->_dbtable), $obj->getVar('clipid'));

        //echo "<br />$sql</br />";

        if (false != $force) {
            $result = $this->_db->queryF($sql);
        } else {
            $result = $this->_db->query($sql);
        }
        if (!$result) {
            return false;
        }

        return true;
    }

    /**
     * Deletes clips matching a set of conditions
     *
     * @param object $criteria {@link CriteriaElement}
     * @return bool FALSE if deletion failed
     */
    function deleteAll($criteria = null)
    {
        $sql = 'DELETE FROM '.$this->_db->prefix($this->_dbtable);
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
        }
        if (!$result = $this->_db->query($sql)) {
            return false;
        }
        return true;
    }

    function updateAll($fieldname, $fieldvalue, $criteria = null)
    {
        $set_clause = is_numeric($fieldvalue) ? $fieldname.' = '.$fieldvalue : $fieldname.' = '.$this->_db->quoteString($fieldvalue);
        $sql = 'UPDATE '.$this->_db->prefix('smartmedia_clips').' SET '.$set_clause;
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
        }
        if (!$result = $this->_db->queryF($sql)) {
            return false;
        }
        return true;
    }


}
?>