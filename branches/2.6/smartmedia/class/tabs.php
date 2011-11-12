<?php

/**
 * Contains the classe for managing tabs
 *
 * @license GNU
 * @author marcan <marcan@smartfactory.ca>
 * @version $Id: tabs.php,v 1.3 2005/06/02 13:33:37 malanciault Exp $
 * @link http://www.smartfactory.ca The SmartFactory
 * @package SmartMedia
 * @subpackage Clips
 */

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

/**
 * SmartMedia Tabs class
 *
 * Class builing clips tabs
 *
 * @package SmartMedia
 * @author marcan <marcan@smartfactory.ca>
 * @link http://www.smartfactory.ca The SmartFactory
 */

class SmartmediaTabs
{
    /**
     * Array holding all the tabs informations, caption and text
     * @var array
     */
    var $_tabs_text = array();

    /**
     * Constructor
     *
     * Initializing the tabs, parsing it in the keyhighlighter object
     *
     * @param object $clipObj {@link SmartmediaClip object}
     */
    function SmartmediaTabs($clipObj)
    {
        // Make sure object is of correct type
        if (strtolower(get_class($clipObj)) != 'smartmediaclip') {
            return false;
        }
        $tab_i = 1;
        $this->_tabs_text = array();

        $highlight = true;
        if($highlight && isset($_GET['keywords']))
        {
            $myts =& MyTextSanitizer::getInstance();
            $keywords=$myts->htmlSpecialChars(trim(urldecode($_GET['keywords'])));
            $h= new keyhighlighter ($keywords, true , 'smartmedia_highlighter');
        }

        if ($clipObj->tab_text_1()) {
            $this->_tabs_text[$tab_i]['caption'] = $clipObj->tab_caption_1();
            $this->_tabs_text[$tab_i]['text'] = $clipObj->tab_text_1();
            	
            if($highlight && isset($_GET['keywords'])) {
                //	$this->_tabs_text[$tab_i]['caption'] = $h->highlight($this->_tabs_text[$tab_i]['caption']);
                $this->_tabs_text[$tab_i]['text'] = $h->highlight($this->_tabs_text[$tab_i]['text']);
            }
            $tab_i++;
        }
        if ($clipObj->tab_text_2()) {
            $this->_tabs_text[$tab_i]['caption'] = $clipObj->tab_caption_2();
            $this->_tabs_text[$tab_i]['text'] = $clipObj->tab_text_2();
            if($highlight && isset($_GET['keywords'])) {
                //$this->_tabs_text[$tab_i]['caption'] = $h->highlight($this->_tabs_text[$tab_i]['caption']);
                $this->_tabs_text[$tab_i]['text'] = $h->highlight($this->_tabs_text[$tab_i]['text']);
            }
            $tab_i++;
        }
        if ($clipObj->tab_text_3()) {
            $this->_tabs_text[$tab_i]['caption'] = $clipObj->tab_caption_3();
            $this->_tabs_text[$tab_i]['text'] = $clipObj->tab_text_3();
            if($highlight && isset($_GET['keywords'])) {
                //$this->_tabs_text[$tab_i]['caption'] = $h->highlight($this->_tabs_text[$tab_i]['caption']);
                $this->_tabs_text[$tab_i]['text'] = $h->highlight($this->_tabs_text[$tab_i]['text']);
            }
            $tab_i++;
        }
    }

    /**
     * Building the tabs
     *
     * @param string $browser browser of the user
     */
    function getTabs($browser='')
    {
        if ($browser == 'moz') {
            	
            $ie = false;
            $javascript = 'href="javascript:;"';
            $curseur = '';
            //} elseif ($browser == 'ie') {
        } else {
            $ie = true;
            $javascript = "";
            $curseur = 'class="curseur"';
        }

        $tabs = array();
        $tab_i = 1;
        $unique_tab_i = 0;
        foreach ($this->_tabs_text as $tab_text)
        {
            $tab = array();
            $tab['id'] = $tab_i;
            $tab['first_layer'] = "layer" . $tab_i . "1";
            $tab['caption'] = $tab_text['caption'];
            $subtabs_text = explode('[pagebreak]', $tab_text['text']);
            $tab['count'] = count($subtabs_text);
            $tab['curseur'] = $curseur;
            $tab['javascript'] = $javascript;
            	
            $subtab_i = 1;
            foreach($subtabs_text as $subtab_text)
            {
                $subtab = array();
                $subtab['id'] = $subtab_i;
                $subtab['id_text'] = $tab['id'] . $subtab['id'];
                $subtab['id_text_next'] = $tab['id'] . $subtab['id'] + 1;
                $subtab['id_text_previous'] = $tab['id'] . $subtab['id'] - 1;
                $subtab['text'] = $subtab_text;
                $subtab['top'] = 0 - (248 * $unique_tab_i) + 4;
                $unique_tab_i++;

                if ($subtab['id_text'] == '11') {
                    $subtab['visibility'] = 'block';
                } else {
                    $subtab['visibility'] = 'none';
                }
                $subtab['layer'] = 'layer' . $subtab['id_text'];
                if (($tab['id'] == 1) && ($subtab['id'] == 1)) {
                    $subtab['show_hide1'] = "<area alt=\"\" shape=\"rect\" coords=\"2,3,117,23\" nohref=\"\">";
                    $subtab['link_show_hide1'] = "";
                    $subtab['current'] = "current";
                } else {
                    $subtab['show_hide1'] = "<area alt=\"\" shape=\"rect\" coords=\"2,3,117,23\" " . $javascript . " onclick=\"show('layer11'),hide('layer" . $subtab['id_text'] . "')\">";
                    $subtab['link_show_hide1'] = $javascript . " onclick=\"show('layer11'),hide('layer" . $subtab['id_text'] . "')\"";
                    $subtab['current'] = "";
                }
                if (($tab['id'] == 2) && ($subtab['id'] == 1)) {
                    $subtab['show_hide2'] = "<area alt=\"\" shape=\"rect\" cozords=\"120,3,224,21\" nohref=\"\">";
                    $subtab['link_show_hide2'] = "nohref=\"\"";
                    $subtab['current'] = "current";
                } else {
                    $subtab['show_hide2'] = "<area alt=\"\" shape=\"rect\" coords=\"120,3,224,21\" " . $javascript . " onclick=\"show('layer21'),hide('layer" . $subtab['id_text'] . "')\">";
                    $subtab['link_show_hide2'] = $javascript . " onclick=\"show('layer21'),hide('layer" . $subtab['id_text'] . "')\"";
                    $subtab['current'] = "";
                }
                if (($tab['id'] == 3) && ($subtab['id'] == 1)) {
                    $subtab['show_hide3'] = "<area alt=\"\" shape=\"rect\" coords=\"226,2,256,20\" nohref=\"\">";
                    $subtab['link_show_hide3'] = "nohref=\"\"";
                    $subtab['current'] = "current";
                } else {
                    $subtab['show_hide3'] = "<area alt=\"\" shape=\"rect\" coords=\"226,2,256,20\" " . $javascript . " onclick=\"show('layer31'),hide('layer" . $subtab['id_text'] . "')\">";
                    $subtab['link_show_hide3'] = $javascript . " onclick=\"show('layer31'),hide('layer" . $subtab['id_text'] . "')\"";
                    $subtab['current'] = "";
                }
                if ($subtab['id'] > 1) {
                    if ($ie) {
                        $subtab['arrow_left'] = "<a href=\" javascript:;\"  class=\"suiv_lay\" onclick=\"show('layer" . $subtab['id_text_previous'] . "'),hide('layer" . $subtab['id_text'] . "')\"><img src=\"" . SMARTMEDIA_IMAGES_URL . "400d_lay_flechg.gif\" width=\"10\" height=\"11\" border=\"0\"></a>";
                        $subtab['previous'] = "<span class=\"suiv_lay2\" onclick=\"show('layer" . $subtab['id_text_previous'] . "'),hide('layer" . $subtab['id_text'] . "')\">Précédent</span>";
                    } else {
                        $subtab['arrow_left'] = "<img src=\"" . SMARTMEDIA_IMAGES_URL . "400d_lay_flechg.gif\" onclick=\"show('layer" . $subtab['id_text_previous'] . "'),hide('layer" . $subtab['id_text'] . "')\" width=\"10\" height=\"11\" border=\"0\" class=\"curseur\">";
                        $subtab['previous'] = "<a href=\" javascript:;\" class=\"suiv_lay\" onclick=\"show('layer" . $subtab['id_text_previous'] . "'),hide('layer" . $subtab['id_text'] . "')\">Précédent</a>";
                    }
                } else {
                    $subtab['arrow_left'] = "&nbsp;";
                    $subtab['previous'] = "&nbsp;";
                }

                if ($tab['count'] > 1) {
                    $subtab['x_of'] = $subtab['id'] . "/" . $tab['count'];
                } else {
                    $subtab['x_of'] = "&nbsp;";
                }
                if ($subtab['id'] < $tab['count']) {
                    if ($ie) {
                        $subtab['next'] = "<span class=\"suiv_lay2\" onclick=\"show('layer" . $subtab['id_text_next'] . "'),hide('layer" . $subtab['id_text'] . "')\">Suivant</span>";
                        $subtab['arrow_right'] = "<img src=\"" . SMARTMEDIA_IMAGES_URL . "400d_lay_flechd.gif\" onclick=\"show('layer" . $subtab['id_text_next'] . "'),hide('layer" . $subtab['id_text'] . "')\" width=\"10\" height=\"11\"  border=\"0\" class=\"curseur\">";
                    } else {
                        $subtab['next'] = "<a href=\" javascript:;\" class=\"suiv_lay\" onclick=\"show('layer" . $subtab['id_text_next'] . "'),hide('layer" . $subtab['id_text'] . "')\">Suivant</a>";
                        $subtab['arrow_right'] = "<a href=\" javascript:;\" class=\"suiv_lay\" onclick=\"show('layer" . $subtab['id_text_next'] . "'),hide('layer" . $subtab['id_text'] . "')\"><img src=\"" . SMARTMEDIA_IMAGES_URL . "400d_lay_flechd.gif\" width=\"10\" height=\"11\" alt=\"\" border=\"0\"></a>";
                    }
                } else {
                    $subtab['next'] = "&nbsp;";
                    $subtab['arrow_right'] = "&nbsp;";
                }

                $tab['subtabs'][] = $subtab;
                $subtab_i++;
            }
            	
            $tabs[] = $tab;
            $tab_i++;
        }
        return $tabs;
    }

}

?>
