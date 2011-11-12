<?php
// $Id$
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
include 'header.php';

$myts =& MyTextSanitizer::getInstance(); // MyTextSanitizer object

include_once XOOPS_ROOT_PATH . '/class/tree.php';
$mylinksCatHandler =& xoops_getmodulehandler('category', $xoopsModule->getVar('dirname'));
$catObjs           = $mylinksCatHandler->getAll();
$myCatTree         = new XoopsObjectTree($catObjs, 'cid', 'pid');

$xoopsOption['template_main'] = 'mylinks_index.html';
include XOOPS_ROOT_PATH . '/header.php';

//wanikoo
$xoTheme->addStylesheet('browse.php?' . mylinksGetStylePath('mylinks.css', 'include'));
$xoTheme->addScript('browse.php?' . mylinksGetStylePath('mylinks.js', 'include'));
// get all top level categories (pid=0)
$mylinksCatHandler =& xoops_getmodulehandler('category', $xoopsModule->getVar('dirname'));
$criteria = new CriteriaCompo();
$criteria->add(new Criteria('pid', 0, '='));
$criteria->setSort('title');
$catObjs = $mylinksCatHandler->getAll($criteria);

$subcatLimit = 5;
$count = 1;
foreach ($catObjs as $catObj) {
    $imgurl = '';
    if ( $catObj->getVar('imgurl') && ($catObj->getVar('imgurl') != "http://") ) {
        $imgurl = $myts->htmlSpecialChars($catObj->getVar('imgurl'));
    }
    // get the total number of subcats for this category
    $criteria = new CriteriaCompo();
    $criteria->add(new Criteria('pid', $catObj->getVar('cid'), '='));
    $childCount = intval($mylinksCatHandler->getCount($criteria));

    //now retrieve the info for the first 'subcatLimit' categories
    $criteria->setLimit($subcatLimit);
    $criteria->setSort('title');
    $childFields = array('pid', 'title');
    $childTitleArray = $mylinksCatHandler->getAll($criteria, $childFields, false, false);
    $lpLimit = min(array($subcatLimit , count($childTitleArray)));
    $subcategories = '';
    for ($i=0; $i<$lpLimit; $i++) {
        $chtitle = $myts->htmlSpecialChars($childTitleArray[$i]['title']);
        $subcategories .= ($i>0) ? ', ' : '';
        $subcategories .= "<a href='" . XOOPSMYLINKURL . "/viewcat.php?cid=" . $childTitleArray[$i]['cid'] . "'>{$chtitle}</a>";
    }
    $subcategories = ($childCount > $subcatLimit) ? $subcategories . '...' : $subcategories;

    // get number of links in each subcategory
    $totalLink = getTotalItems($catObj->getVar('cid'), 1);
    $xoopsTpl->append('categories', array('image'         => $imgurl,
                                          'id'            => $catObj->getVar('cid'),
                                          'title'         => $myts->htmlSpecialChars($catObj->getVar('title')),
                                          'subcategories' => $subcategories,
                                          'totallink'     => $totalLink,
                                          'count' => $count));
    $count++;
}

$sql = "SELECT COUNT(*) FROM " . $xoopsDB->prefix("mylinks_links") . " WHERE status>0";
list($numActiveLinks) = $xoopsDB->fetchRow($xoopsDB->query($sql));
$xoopsTpl->assign('lang_thereare', sprintf(_MD_MYLINKS_THEREARE, $numActiveLinks));

if (1 == $xoopsModuleConfig['useshots']) {
    $xoopsTpl->assign('shotwidth', $xoopsModuleConfig['shotwidth']);
    $xoopsTpl->assign('tablewidth', $xoopsModuleConfig['shotwidth'] + 10);
    $xoopsTpl->assign('show_screenshot', true);
    $xoopsTpl->assign('lang_noscreenshot', _MD_MYLINKS_NOSHOTS);
}

$xoopsTpl->assign('lang_description', _MD_MYLINKS_DESCRIPTIONC);
$xoopsTpl->assign('lang_lastupdate', _MD_MYLINKS_LASTUPDATEC);
$xoopsTpl->assign('lang_hits', _MD_MYLINKS_HITSC);
$xoopsTpl->assign('lang_rating', _MD_MYLINKS_RATINGC);
$xoopsTpl->assign('lang_ratethissite', _MD_MYLINKS_RATETHISSITE);
$xoopsTpl->assign('lang_reportbroken', _MD_MYLINKS_REPORTBROKEN);
$xoopsTpl->assign('lang_tellafriend', _MD_MYLINKS_TELLAFRIEND);
$xoopsTpl->assign('lang_modify', _MD_MYLINKS_MODIFY);
$xoopsTpl->assign('lang_latestlistings', _MD_MYLINKS_LATESTLIST);
$xoopsTpl->assign('lang_category', _MD_MYLINKS_CATEGORYC);
$xoopsTpl->assign('lang_visit', _MD_MYLINKS_VISIT);
$xoopsTpl->assign('lang_comments', _COMMENTS);

$result = $xoopsDB->query("SELECT l.lid, l.cid, l.title, l.url, l.logourl, l.status, l.date, l.hits, l.rating, l.votes, l.comments, t.description FROM ".$xoopsDB->prefix("mylinks_links")." l, ".$xoopsDB->prefix("mylinks_text")." t where l.status>0 and l.lid=t.lid ORDER BY date DESC", $xoopsModuleConfig['newlinks'], 0);
while (list($lid, $cid, $ltitle, $url, $logourl, $status, $time, $hits, $rating, $votes, $comments, $description) = $xoopsDB->fetchRow($result)) {
    if ($xoopsUser && $xoopsUser->isAdmin($xoopsModule->mid())) {
        $isadmin   = true;
        $adminlink = "<a href='" . XOOPSMYLINKURL . "/admin/main.php?op=modLink&amp;&fct=mylinks&amp;lid={$lid}'><img src='" . mylinksGetIconURL("edit.png") . "' style='border-width: 0px;' alt='" . _MD_MYLINKS_EDITTHISLINK . "' /></a>";
    } else {
        $isadmin   = false;
        $adminlink = '';
    }

    $votestring = (1 == $votes) ? _MD_MYLINKS_ONEVOTE : sprintf(_MD_MYLINKS_NUMVOTES, $votes);
    $ltitle     = $myts->htmlSpecialChars($ltitle);
    $thisCatObj = $mylinksCatHandler->get($cid);
    $homePath   = _MD_MYLINKS_MAIN . "&nbsp;:&nbsp;";
    $itemPath    = "<a href='" . XOOPSMYLINKURL . "/viewcat.php?cid={$cid}'>" . $thisCatObj->getVar('title') . "</a>";
    $path       = '';
    $myParentID = $thisCatObj->getVar('pid');
    while ( $myParentID != 0 ) {
        $ancestorObj = $myCatTree->getByKey($myParentID);
        $path  = "<a href='" . XOOPSMYLINKURL . "/viewcat.php?cid=" . $ancestorObj->getVar('cid') . "'>" . $ancestorObj->getVar('title') . "</a>&nbsp;:&nbsp;{$path}";
        $myParentID = $ancestorObj->getVar('pid');
    }

    $path = "{$homePath}{$path}{$itemPath}";
    $path = str_replace("&nbsp;:&nbsp;", " <img src='" . mylinksGetIconURL('arrow.gif') . "' style='border-width: 0px;' alt='' /> ", $path);
    $new = newlinkgraphic($time, $status);
    $pop = popgraphic($hits);
    //by wanikoo
    $xoopsTpl->append('links', array('url'          => $myts->htmlSpecialChars($url),
                                     'id'           => $lid,
                                     'cid'          => $cid,
                                     'rating'       => number_format($rating, 2),
                                     'ltitle'       => $ltitle,
                                     'title'        => $myts->htmlSpecialChars($ltitle).$new.$pop,
                                     'category'     => $path,
                                     'logourl'      => $myts->htmlSpecialChars(trim($logourl)),
                                     'updated'      => formatTimestamp($time, "m"),
                                     'description'  => $myts->displayTarea($description, 0),
                                     'adminlink'    => $adminlink,
                                     'hits'         => $hits,
                                     'votes'        => $votestring,
                                     'comments'     => $comments,
                                     'mail_subject' => rawurlencode(sprintf(_MD_MYLINKS_INTRESTLINK, $xoopsConfig['sitename'])),
                                     'mail_body'    => rawurlencode(sprintf(_MD_MYLINKS_INTLINKFOUND, $xoopsConfig['sitename']) . ':  ' . XOOPSMYLINKURL  ."/singlelink.php?cid={$cid}&amp;lid={$lid}")));
}
//wanikoo
$xoopsTpl->assign("lang_feed", _MD_MYLINKS_FEED);
//wanikoo theme changer
$xoopsTpl->assign("lang_themechanger", _MD_MYLINKS_THEMECHANGER);
$mymylinkstheme_options = '';

foreach ($GLOBALS['mylinks_allowed_theme'] as $mymylinkstheme) {
    $mymylinkstheme_options .= "<option value='{$mymylinkstheme}'";
    if ($mymylinkstheme == $GLOBALS['mylinks_theme']) {
        $mymylinkstheme_options .= " selected='selected'";
    }
    $mymylinkstheme_options .= ">{$mymylinkstheme}</option>";
}

$mylinkstheme_select = "<select name='mylinks_theme_select' onchange='submit();' size='1'>{$mymylinkstheme_options}</select>";

$xoopsTpl->assign("mylinksthemeoption", $mylinkstheme_select);

//wanikoo search
if (file_exists(XOOPS_ROOT_PATH . "/language/{$xoopsConfig['language']}/search.php")) {
   include_once XOOPS_ROOT_PATH . "/language/{$xoopsConfig['language']}/search.php";
} else {
   include_once XOOPS_ROOT_PATH . "/language/english/search.php";
}
$xoopsTpl->assign('lang_all', _SR_ALL);
$xoopsTpl->assign('lang_any', _SR_ANY);
$xoopsTpl->assign('lang_exact', _SR_EXACT);
$xoopsTpl->assign('lang_search', _SR_SEARCH);
$xoopsTpl->assign('module_id', $xoopsModule->getVar('mid'));

//category head
$catarray = array();
if ($mylinks_show_letters) {
    $catarray['letters'] = ml_wfd_letters();
}
if ($mylinks_show_toolbar) {
    $catarray['toolbar'] = ml_wfd_toolbar();
}
$xoopsTpl->assign('catarray', $catarray);

include_once XOOPSMYLINKPATH . '/footer.php';