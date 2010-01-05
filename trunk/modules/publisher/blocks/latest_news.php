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
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Publisher
 * @subpackage      Blocks
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @author          Bandit-x
 * @author          Mowaffak
 * @version         $Id: latest_news.php 0 2009-06-11 18:47:04Z trabis $
 */

if (!defined('XOOPS_ROOT_PATH')) {
    die("XOOPS root path not defined");
}

include_once dirname(dirname(__FILE__)) . '/include/common.php';

function publisher_latest_news_show($options)
{
    global $xoopsTpl, $xoopsUser, $xoopsConfig, $xoTheme;

    $block = array();

    xoops_loadLanguage('main', 'publisher');
    $myts =& MyTextSanitizer::getInstance();
    $publisher =& PublisherPublisher::getInstance();

    $start = 0;
    $limit = $options[0];
    $column_count = $options[1];
    $letters = $options[2];
    $selected_stories = $options[3];
    $sort = $options[7];
	$order = publisher_getOrderBy($sort);
    $imgwidth = $options[9];
    $imgheight = $options[10];
    $border = $options[11];
    $bordercolor = $options[12];

	$block['spec']['columnwidth'] = intval(1 / $column_count * 100);

	$selectedcatids = explode(',', $options[26]);

    $allcats = false;
	if (in_array(0, $selectedcatids)) {
		$allcats = true;
	}

	// creating the ITEM objects that belong to the selected category
	if ($allcats) {
		$criteria = null;
	} else {
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('categoryid', '(' . $options[26] . ')', 'IN'));
	}

	// Use specific ITEMS
	if ($selected_stories != 0) {
        unset($criteria); //removes category option
		$criteria = new CriteriaCompo();
		$criteria->add(new Criteria('itemid', '(' . $selected_stories . ')', 'IN'));
	}

    $itemsObj = $publisher->getHandler('item')->getItems($limit, $start, array(_PUBLISHER_STATUS_PUBLISHED), -1, $sort, $order, '', true, $criteria, 'itemid');

    $scount = count($itemsObj);

    if ($scount == 0) {
	   return false;
	}

    $k = 0;
    $columns = array();
    $storieslist=array();

    foreach ($itemsObj as $itemid => $itemObj) {

        $files = $itemObj->getFiles();
	    $filescount = count($files);

        $item = array();

        $item['itemurl'] = $itemObj->getItemUrl();
        $item['title']   = $itemObj->getItemLink();
        $item['text']    = $itemObj->getBlockSummary($letters);

        $item            = $itemObj->getMainImage($item);  //returns an array

        $ls_height = '';
        if ($options[10] != 0) {
            $ls_height = 'height="' . $imgheight . '" ';
        } // set height = 0 in block option for auto height

        if ($options[13] == 'LEFT' ) {
            $imgposition = "float: left";
            $ls_margin = '-right';
        }

        if ($options[13] == 'CENTER' ){
            $imgposition = "text-align:center";
            $ls_margin = '';
        }

        if ($options[13] == 'RIGHT' ) {
            $imgposition = "float: right";
            $ls_margin = '-left';
        }


        //Image
       	if ($options[8] == 1 && $item['image_path'] != '') {
       	    $startdiv = '<div style="' . $imgposition . '"><a href="' . $item['itemurl'] . '">';
            $style    = 'style="margin' . $ls_margin . ': 10px; padding: 2px; border: ' . $border . 'px solid #' . $bordercolor . '"';
            $enddiv   = 'width="' . $imgwidth . '" ' . $ls_height . '/></a></div>';
            $image    = $startdiv . '<img ' . $style . ' src="' . $item['image_path'] . '" alt="' . $item['image_name'] . '" ' . $enddiv;

            $item['text'] = $image . $item['text'];
        }

        if (is_object($xoopsUser) && $xoopsUser->isAdmin(-1)) {
            $item['admin']  = "<a href='" . PUBLISHER_URL . "/submit.php?itemid=" . $itemObj->itemid() . "'><img src='" . PUBLISHER_URL . "/images/links/edit.gif'" . " title='" . _CO_PUBLISHER_EDIT . "' alt='" . _CO_PUBLISHER_EDIT . "' /></a>&nbsp;";
            $item['admin'] .= "<a href='" . PUBLISHER_URL . "/admin/item.php?op=del&amp;itemid=" . $itemObj->itemid() . "'><img src='" . PUBLISHER_URL . "/images/links/delete.gif'" . " title='" . _CO_PUBLISHER_DELETE . "' alt='" . _CO_PUBLISHER_DELETE . "' /></a>";
		} else {
            $item['admin'] = '';
        }

        $block['topiclink'] = '';
        /*
        if ($options[14] == 1) {
            $block['topiclink'] = '| <a href="'.XOOPS_URL.'/modules/news/topics_directory.php">'._AM_NEWS_TOPICS_DIRECTORY.'</a> ';
        }
        */
        $block['archivelink'] = '';
        /*if ($options[15] == 1) {
            $block['archivelink'] = '| <a href="'.XOOPS_URL.'/modules/news/archive.php">'._MB_PUBLISHER_NEWSARCHIVES.'</a> ';
        } */


        //TODO: Should we not show link to Anonymous?
        $block['submitlink'] = '';
        if ($options[16] == 1 && !empty($xoopsUser)) {
            $block['submitlink'] = '| <a href="' . PUBLISHER_URL . '/submit.php">' . _MB_PUBLISHER_SUBMITNEWS . '</a> ';
        }

        $item['poster'] = '';
       	if ($options[17] == 1) {
            $item['poster'] = _MB_PUBLISHER_POSTER . ' '. $itemObj->posterName();
        }

        $item['posttime'] = '';
        if ($options[18] == 1) {
            $item['posttime'] = _ON . ' ' . $itemObj->datesub();
        }

        $item['topic_title'] = '';
        if ($options[19] == 1) {
            $item['topic_title'] = $itemObj->getCategoryLink() . _MB_PUBLISHER_SP;
       	}

        $item['read'] = '';
        if ($options[20] == 1) {
            $item['read']= '&nbsp;(' . $itemObj->counter() . ' ' . _READS . ')';
       	}

        $item['more'] = '';
        if ($itemObj->body() != '' || $itemObj->comments() > 0){
      		$item['more'] = '<a href="' . $itemObj->getItemUrl() . '">' . _MB_PUBLISHER_READMORE . '</a>';
        }

        $comments = $itemObj->comments();
        if ($options[21] == 1) {
            if ($comments > 0) {
                //shows 1 comment instead of 1 comm. if comments ==1
                //langugage file modified accordingly
                if ($comments == 1) {
                    $item['comment'] = '&nbsp;' . _MB_PUBLISHER_ONECOMMENT . '</a>&nbsp;';
       	        } else {
                    $item['comment'] = '&nbsp;' . $comments . '&nbsp;' . _MB_PUBLISHER_COMMENTS . '</a>&nbsp;';
                }
            } else {
                $item['comment'] = '&nbsp;' . _MB_PUBLISHER_NO_COMMENTS . '</a>&nbsp;';
            }
        }

        $item['print'] = '';
        if ($options[22] == 1) {
            $item['print'] = '<a href="' . publisher_seo_genUrl("print", $itemObj->itemid(), $itemObj->short_url()) . '" rel="nofollow"><img src="' . PUBLISHER_URL . '/images/links/print.gif" title="' . _CO_PUBLISHER_PRINT . '" alt="' . _CO_PUBLISHER_PRINT . '" /></a>&nbsp;';
   	    }

        $item['pdf'] = '';
        if ($options[23] == 1) {
            $item['pdf'] = "<a href='" . PUBLISHER_URL . "/makepdf.php?itemid=" . $itemObj->itemid() . "' rel='nofollow'><img src='" . PUBLISHER_URL . "/images/links/pdf.gif' title='" . _CO_PUBLISHER_PDF . "' alt='" . _CO_PUBLISHER_PDF . "' /></a>&nbsp;";
   	    }

        $item['email'] = '';
        if ($options[24] == 1 && xoops_isActiveModule('tellafriend')) {
            $subject  = sprintf(_CO_PUBLISHER_INTITEMFOUND, $xoopsConfig['sitename']);
	        $subject  = $itemObj->_convert_for_japanese($subject);
	        $maillink = publisher_tellafriend($subject);

            $item['email'] = '<a href="' . $maillink . '"><img src="' . PUBLISHER_URL . '/images/links/friend.gif" title="' . _CO_PUBLISHER_MAIL . '" alt="' . _CO_PUBLISHER_MAIL . '" /></a>&nbsp;';
        }

        $block['morelink'] = '';
        if ($options[25] == 1) {
            $block['morelink'] = '<a href="' . PUBLISHER_URL.'/index.php">' . _MB_PUBLISHER_MORE_ITEMS . '</a> ';
       	}

        $block['latestnews_scroll'] = false;
        if ($options[4] == 1) {
		    $block['latestnews_scroll'] = true;
        }

        $block['scrollheight'] = $options[5];
        $block['scrollspeed'] = $options[6];

        $columns[$k][] = $item;
        $k++;

        if ($k == $column_count) {
            $k = 0;
       	}
    }

    unset($item);
    $block['columns']  = $columns;
    return $block;
}

function publisher_latest_news_edit($options)
{
    $tabletag1 = '<tr><td style="padding:3px" width="37%">';
    $tabletag2 = '</td><td style="padding:3px">';
    $tabletag3 = '<tr><td style="padding-top:20px;border-bottom:1px solid #000" colspan="2">';
    $tabletag4 = '</td></tr>';

    $form  = "<table border='0' cellpadding='0' cellspacing='0'>";
	$form .= $tabletag3 . _MB_PUBLISHER_GENERALCONFIG . $tabletag4; // General Options
	$form .= $tabletag1 . _MB_PUBLISHER_DISP . $tabletag2;
    $form .= "<input type='text' name='options[]' value='" . $options[0] . "' size='4'>&nbsp;" . _MB_PUBLISHER_ITEMS . "</td></tr>";
    $form .=  $tabletag1 . _MB_PUBLISHER_COLUMNS . $tabletag2;
    $form .= "<input type='text' name='options[]' value='" . $options[1] . "' size='4'>&nbsp;" . _MB_PUBLISHER_COLUMN . "</td></tr>";
    $form .=  $tabletag1 . _MB_PUBLISHER_TEXTLENGTH . $tabletag2;
    $form .= "<input type='text' name='options[]' value='" . $options[2] . "' size='4'>&nbsp;" . _MB_PUBLISHER_LETTER . "</td></tr>";
    $form .=  $tabletag1 . _MB_PUBLISHER_SELECTEDSTORIES . $tabletag2;
    $form .= "<input type='text' name='options[]' value='" . $options[3] . "' size='16'></td></tr>";
    $form .= $tabletag1 . _MB_PUBLISHER_SCROLL . $tabletag2;
    $form .= publisher_mk_chkbox($options, 4);
    $form .= $tabletag1 . _MB_PUBLISHER_SCROLLHEIGHT . $tabletag2;
    $form .= "<input type='text' name='options[]' value='" . $options[5] . "' size='4'></td></tr>";
    $form .= $tabletag1 . _MB_PUBLISHER_SCROLLSPEED . $tabletag2;
    $form .= "<input type='text' name='options[]' value='" . $options[6] . "' size='4'></td></tr>";
    $form .= $tabletag1 . _MB_PUBLISHER_ORDER . $tabletag2;

    $form .= "<select name='options[7]'>";
    $form .= "<option value='datesub'";
    if ($options[7] == "datesub") {
        $form  .= " selected='selected'";
    }
    $form  .= ">" . _MB_PUBLISHER_DATE . "</option>";

    $form .= "<option value='counter'";
    if ($options[7] == "counter") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_PUBLISHER_HITS . "</option>";

    $form .= "<option value='weight'";
    if ($options[7] == "weight") {
        $form .= " selected='selected'";
    }
    $form .= ">" . _MB_PUBLISHER_WEIGHT . "</option>";

    $form .= "</select></td></tr>";

	$form .= $tabletag3 . _MB_PUBLISHER_PHOTOSCONFIG . $tabletag4; // Photos Options
    $form .= $tabletag1 . _MB_PUBLISHER_IMGDISPLAY . $tabletag2;
    $form .= publisher_mk_chkbox($options, 8);
    $form .=  $tabletag1 . _MB_PUBLISHER_IMGWIDTH . $tabletag2;
    $form .= "<input type='text' name='options[]' value='" . $options[9] . "' size='4'>&nbsp;" . _MB_PUBLISHER_PIXEL . "</td></tr>";
    $form .=  $tabletag1 . _MB_PUBLISHER_IMGHEIGHT . $tabletag2;
    $form .= "<input type='text' name='options[]' value='" . $options[10] . "' size='4'>&nbsp;" . _MB_PUBLISHER_PIXEL . "</td></tr>";
    $form .=  $tabletag1 . _MB_PUBLISHER_BORDER . $tabletag2;
    $form .= "<input type='text' name='options[]' value='" . $options[11] . "' size='4'>&nbsp;" . _MB_PUBLISHER_PIXEL . "</td></tr>";
    $form .=  $tabletag1 . _MB_PUBLISHER_BORDERCOLOR . $tabletag2;
    $form .= "<input type='text' name='options[]' value='" . $options[12] . "' size='8'></td></tr>";
	$form .= $tabletag1 . _MB_PUBLISHER_IMGPOSITION . $tabletag2;
    $form .= "<select name='options[]'>";
    $form .= "<option value='LEFT'";
    if ( $options[13] == 'LEFT' ) {
        $form .= " selected='selected'";
    }
    $form .= '>' . _LEFT . "</option>\n";

    $form .= "<option value='CENTER'";
    if($options[13] == 'CENTER'){
        $form .= " selected='selected'";
    }
    $form .= '>' . _CENTER . "</option>\n";

    $form .= "<option value='RIGHT'";
    if ( $options[13] == 'RIGHT' ) {
        $form .= " selected='selected'";
    }
    $form .= '>' . _RIGHT . '</option>';
    $form .= "</select></td></tr>";

	$form .= $tabletag3 . _MB_PUBLISHER_LINKSCONFIG . $tabletag4; // Links Options
    $form .= $tabletag1 . _MB_PUBLISHER_DISPLAY_TOPICLINK . $tabletag2;
    $form .= publisher_mk_chkbox($options, 14);
    $form .= $tabletag1 . _MB_PUBLISHER_DISPLAY_ARCHIVELINK . $tabletag2;
    $form .= publisher_mk_chkbox($options, 15);
    $form .= $tabletag1 . _MB_PUBLISHER_DISPLAY_SUBMITLINK . $tabletag2;
    $form .= publisher_mk_chkbox($options, 16);
    $form .= $tabletag1 . _MB_PUBLISHER_DISPLAY_POSTEDBY . $tabletag2;
    $form .= publisher_mk_chkbox($options, 17);
    $form .= $tabletag1 . _MB_PUBLISHER_DISPLAY_POSTTIME . $tabletag2;
    $form .= publisher_mk_chkbox($options, 18);
    $form .= $tabletag1 . _MB_PUBLISHER_DISPLAY_TOPICTITLE . $tabletag2;
    $form .= publisher_mk_chkbox($options, 19);
    $form .= $tabletag1 . _MB_PUBLISHER_DISPLAY_READ . $tabletag2;
    $form .= publisher_mk_chkbox($options, 20);
    $form .= $tabletag1 . _MB_PUBLISHER_DISPLAY_COMMENT . $tabletag2;
    $form .= publisher_mk_chkbox($options, 21);
    $form .= $tabletag1 . _MB_PUBLISHER_DISPLAY_PRINT . $tabletag2;
    $form .= publisher_mk_chkbox($options, 22);
    $form .= $tabletag1 . _MB_PUBLISHER_DISPLAY_PDF . $tabletag2;
    $form .= publisher_mk_chkbox($options, 23);
    $form .= $tabletag1 . _MB_PUBLISHER_DISPLAY_EMAIL . $tabletag2;
    $form .= publisher_mk_chkbox($options, 24);
    $form .= $tabletag1 . _MB_PUBLISHER_DISPLAY_MORELINK . $tabletag2;
    $form .= publisher_mk_chkbox($options, 25);

    //Select Which Categories To Show
	$form .= $tabletag3 . _MB_PUBLISHER_TOPICSCONFIG . $tabletag4; // Topics Options
	$form .= $tabletag1 . _MB_PUBLISHER_TOPICSDISPLAY . $tabletag2;
    $form .= publisher_createCategorySelect($options[26], 0, true, 'options[26]');
    $form .= '</td></tr>';

    $form .= "</table>";
    return $form;
}

function publisher_mk_chkbox($options, $number)
{
	$chk = "";
	if ($options[$number] == 1) {
		$chk = " checked='checked'";
	}
	$chkbox = "<input type='radio' name='options[{$number}]' value='1'" . $chk . " />&nbsp;" . _YES . "&nbsp;&nbsp;";
	$chk    = "";
	if ($options[$number] == 0) {
		$chk = " checked='checked'";
	}
	$chkbox .= "<input type='radio' name='options[{$number}]' value='0'" . $chk . " />&nbsp;" . _NO . "</td></tr>";
	return $chkbox;
}

function publisher_mk_select($options, $number)
{
	$slc = "";
	if ($options[$number] == 2) {
		$slc = " checked='checked'";
	}
	$select = "<input type='radio' name='options[{$number}]' value='2'" . $slc . " />&nbsp;" . _LEFT . "&nbsp;&nbsp;";
	$slc    = "";
	if ($options[$number] == 1) {
		$slc = " checked='checked'";
	}
	$select = "<input type='radio' name='options[{$number}]' value='1'" . $slc . " />&nbsp;" . _CENTER . "&nbsp;&nbsp;";
	$slc    = "";
	if ($options[$number] == 0) {
		$slc = " checked='checked'";
	}
	$select .= "<input type='radio' name='options[{$number}]' value='0'" . $slc . " />&nbsp;" . _RIGHT . "</td></tr>";
	return $select;
}
