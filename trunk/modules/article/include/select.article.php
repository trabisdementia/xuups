<?php
/**
 * Article module for XOOPS
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code 
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         article
 * @since           1.0
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: select.article.php 2178 2008-09-26 08:34:09Z phppp $
 */
 
// Where to locate the file? Member search should be restricted
// Limitation: Only work with javascript enabled 

include "../../../mainfile.php";

$category_id = @intval($_GET["category"]);
$category_handler =& xoops_getmodulehandler("category", $GLOBALS["artdirname"]);
$category_obj =& $category_handler->get($category_id);
if ( empty($category_id) || !$category_handler->getPermission($category_obj, "moderate")) {
    redirect_header(XOOPS_URL . "/modules/" . $GLOBALS["artdirname"] . "/index.php", 2, _NOPERM);
}

include_once dirname(dirname(__FILE__)) . "/class/xoopsformloader.php";
include_once XOOPS_ROOT_PATH . "/class/pagenav.php";

include_once XOOPS_ROOT_PATH . "/header.php";

$start = @intval($_REQUEST['start']);
$limit = 100;

$name_parent = $_REQUEST["target"];
$name_current = 'article';
echo $js_additem = '
    <script type="text/javascript">
    function addItem(){
        var sel_current = xoopsGetElementById("' . $name_current . '");
        var sel_str="";
        var num = 0;
        for (var i = 0; i < sel_current.options.length; i++) {
            if (sel_current.options[i].selected) {
                var len=sel_current.options[i].text.length+sel_current.options[i].value.length;
                sel_str +=len+":"+sel_current.options[i].value+":"+sel_current.options[i].text;
                num ++;
            }
        }
        if(num == 0) {
            window.close();
            return false;
        }
        sel_str = num+":"+sel_str;
        window.opener.addItem(sel_str);
        if(multiple==0){ 
            window.close();
            window.opener.focus();
        }
        return true;
    }
    </script>
';

$form_article = new XoopsThemeForm(art_constant("MD_ARTICLE_SELECT"), "selectarticle", xoops_getenv('PHP_SELF'), "GET");

$article_handler =& xoops_getmodulehandler("article", $GLOBALS["artdirname"]);   
$criteria = new CriteriaCompo(new Criteria("cat_id", $category_id));
$article_count = $article_handler->getCount($criteria);
$criteria->setSort("art_id");
$criteria->setLimit($limit);
$criteria->setStart($start);

$select_form = new XoopsFormSelect("", $name_current);
$select_form->addOptionArray($article_handler->getList($criteria));

$select_tray = new XoopsFormElementTray("", "<br />");
$select_tray->addElement($select_form);
$nav = new XoopsPageNav($article_count, $limit, $start, "start", "target=" . $_REQUEST["target"] . "&amp;category=" . $category_id);
//$user_select_nav = new XoopsFormLabel(sprintf(_MA_SEARCH_COUNT, $usercount), $nav->renderNav(4));
$select_tray->addElement($nav->renderNav(4));

$add_button = new XoopsFormButton('', '', _ADD, 'button');
$add_button->setExtra('onclick="addItem();"') ;

$close_button = new XoopsFormButton('', '', _CLOSE, 'button');
$close_button->setExtra('onclick="window.close()"') ;

$button_tray = new XoopsFormElementTray("");
$button_tray->addElement($add_button);
$button_tray->addElement(new XoopsFormButton('', '', _CANCEL, 'reset'));
$button_tray->addElement($close_button);

$form_article->addElement($select_tray);

$form_article->addElement(new XoopsFormHidden('target', $_REQUEST["target"]));
$form_article->addElement(new XoopsFormHidden('category', $_REQUEST["category"]));
$form_article->addElement($button_tray);
$form_article->display();        

include_once XOOPS_ROOT_PATH . "/footer.php";
?>