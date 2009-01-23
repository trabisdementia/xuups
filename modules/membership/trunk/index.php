<?php
//  Author: SMD & Trabis
//  URL: http://www.xoopsmalaysia.org  & http://www.xuups.com
//  E-Mail: webmaster@xoopsmalaysia.org  & lusopoemas@gmail.com

include "../../mainfile.php";
$myts =& MyTextSanitizer::getInstance();

$d_letter = _MA_MSHIP_ALL;
$d_sortby = "uid";
$d_orderby = "ASC";
$d_query = "";
$d_num = $xoopsModuleConfig['membersperpage'];

$perm_letter = array (_MA_MSHIP_ALL, "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",_MA_MSHIP_OTHER);
$perm_sortby = array ("uid","user_avatar","uname","user_regdate","email","url");
$perm_orderby = array ("ASC","DESC");

$pagesize = $d_num;
$letter = isset($_GET['letter'])? $_GET['letter']: '';
$sortby = isset($_GET['sortby'])? $_GET['sortby']: '';
$orderby = isset($_GET['orderby'])? $_GET['orderby']: '';

if (!in_array($letter, $perm_letter)) $letter = $d_letter;
if (!in_array($sortby, $perm_sortby)) $sortby = $d_sortby;
if (!in_array($orderby, $perm_orderby)) $orderby = $d_orderby;

$page = isset($_GET['page'])? intval($_GET['page']): 1;
$start = isset($_GET['start'])? intval($_GET['start']): 0;
$query = isset($_GET['query'])? $myts->addSlashes($_GET['query']): $d_query;
$query = isset($_POST['query'])? $myts->addSlashes($_POST['query']): $query;

$xoopsOption['template_main'] = 'membership_index.html';
include XOOPS_ROOT_PATH . '/header.php';

if ( is_object($xoopsUser) && $xoopsUser->isAdmin()) {
    $is_admin = true;
}  else {
    $is_admin = false;
}
$xoopsTpl->assign('can_edit', $is_admin);

//Show last member, if there is a querry than show last member from result
if ( $query != '' ) {
        $where = "WHERE level>0 AND (uname LIKE '%$query%' OR user_icq LIKE '%$query%' ";
        $where .= "OR user_from LIKE '%$query%' OR user_sig LIKE '%$query%' ";
        $where .= "OR user_aim LIKE '%$query%' OR user_yim LIKE '%$query%' OR user_msnm like '%$query%'";
    if ( $is_admin ) {
        $where .= " OR email LIKE '%$query%'";
    }
	$where .= ") ";
} else {
    $where = "WHERE level>0";
}
$result = $xoopsDB->query("SELECT uid, uname FROM ".$xoopsDB->prefix("users")." $where ORDER BY uid DESC",1,0);
list($lastuid, $lastuser) = $xoopsDB->fetchRow($result);

$xoopsTpl->assign('lang_welcome', sprintf(_MA_MSHIP_WELCOMETO,$xoopsConfig['sitename']));
$xoopsTpl->assign('lang_greetings', _MA_MSHIP_GREETINGS." <a href='".XOOPS_URL."/userinfo.php?uid=".$lastuid."'>".$lastuser."</a>");

        
$form_submit = "<form action='".XOOPS_URL."/modules/membership/index.php' method='post'>";
if ( $query != '' ) {
    $form_submit .= "<input type='text' size='30' name='query' value='".htmlspecialchars(stripslashes($query))."' />";
} else {
    $form_submit.= "<input type='text' size='30' name='query' />";
}
$form_submit .= "<input type='submit' value='"._MA_MSHIP_SEARCH."' /></form>";
$xoopsTpl->assign('form_submit', $form_submit);

$form_reset = "<form action='".XOOPS_URL."/modules/membership/index.php' method='post'>";
$form_reset .= "<input type='submit' value='" ._MA_MSHIP_RESETSEARCH."' />";
$form_reset .= "</form>";
$xoopsTpl->assign('form_reset', $form_reset);

$form_letters = "[ ";
$num = count($perm_letter) - 1;
$counter = 0;
while (list(, $ltr) = each($perm_letter)) {
    $form_letters .= "<a href='".XOOPS_URL."/modules/membership/index.php?letter=".$ltr."&sortby=".$sortby."'>".$ltr."</a>";
    if ( $counter == round($num/2) ) {
        $form_letters .= " ]<br />[ ";
    } elseif ( $counter != $num ) {
        $form_letters .= "&nbsp;|&nbsp;";
    }
    $counter++;
}
$form_letters .= " ]";
$xoopsTpl->assign('form_letters', $form_letters);


$min = $start;//$pagesize * ($page - 1);
$max = $pagesize; 
        
$count = "SELECT COUNT(uid) AS total FROM ".$xoopsDB->prefix("users")." "; // Count all the users in the db..
$select = "SELECT uid, name, uname, email, url, user_avatar, user_regdate, user_icq, user_from, user_aim, user_yim, user_msnm, user_viewemail FROM ".$xoopsDB->prefix("users")." ";
if ( ( $letter != _MA_MSHIP_OTHER ) AND ( $letter != _MA_MSHIP_ALL ) ) {
	$where = "WHERE level>0 AND uname LIKE '".$letter."%' ";
} else if ( ( $letter == _MA_MSHIP_OTHER ) AND ( $letter != _MA_MSHIP_ALL ) ) {
    $where = "WHERE level>0 AND uname REGEXP '^\[1-9]' ";
} else { 
    $where = "WHERE level>0 ";
}
$sort = "order by $sortby $orderby";


if ( $query != '' ) {
    $where = "WHERE level>0 AND (uname LIKE '%$query%' OR user_icq LIKE '%$query%' ";
    $where .= "OR user_from LIKE '%$query%' OR user_sig LIKE '%$query%' ";
    $where .= "OR user_aim LIKE '%$query%' OR user_yim LIKE '%$query%' OR user_msnm LIKE '%$query%'";
   	if ( $is_admin ) {
        $where .= "OR email LIKE '%$query%'";
    }
	$where .= ") ";
}
$count_result = $xoopsDB->query($count.$where);
list($totalcount) = $xoopsDB->fetchRow($count_result);

$result = $xoopsDB->query($select.$where.$sort,$max,$min) or die($xoopsDB->error() ); // Now lets do it !!

//Hum, why is this?
if ( $letter != "front" ) {
    $pagenav_args = '';
    //if ($d_num != $num) $pagenav_args .='&num='.$num;
    if ($d_letter != $letter) $pagenav_args .='&letter='.$letter;
    if ($d_query != $query) $pagenav_args .='&query='.$query;
    if ($d_orderby != $orderby) $pagenav_args .='&orderby='.$orderby;

    $xoopsTpl->assign('sort_avatar', "<a href='".XOOPS_URL."/modules/membership/index.php?sortby=user_avatar".$pagenav_args."'>"._MA_MSHIP_AVATAR."</a>");
    $xoopsTpl->assign('sort_nickname', "<a href='".XOOPS_URL."/modules/membership/index.php?sortby=uname".$pagenav_args."'>"._MA_MSHIP_NICKNAME."</a>");
    $xoopsTpl->assign('sort_regdate', "<a href='".XOOPS_URL."/modules/membership/index.php?sortby=user_regdate".$pagenav_args."'>"._MA_MSHIP_REGDATE."</a>");
    $xoopsTpl->assign('sort_email', "<a href='".XOOPS_URL."/modules/membership/index.php?sortby=email".$pagenav_args."'>"._MA_MSHIP_EMAIL."</a>");
    $xoopsTpl->assign('sort_pm', "<a href='".XOOPS_URL."/modules/membership/index.php?sortby=email".$pagenav_args."'>"._MA_MSHIP_PM."</a>");
    $xoopsTpl->assign('sort_url', "<a href='".XOOPS_URL."/modules/membership/index.php?sortby=url".$pagenav_args."'>"._MA_MSHIP_URL."</a>");
    if ( $is_admin ) {
        $xoopsTpl->assign('functions', "<a href='".XOOPS_URL."/modules/membership/index.php?sortby=email".$pagenav_args."'>"._MA_MSHIP_FUNCTIONS."</a>");
    }

    if ($d_sortby != $sortby) $pagenav_args .='&sortby='.$sortby;

    $num_users = $xoopsDB->getRowsNum($result); //number of users per sorted and limit query
    if ( $totalcount > 0  ) {
        while ( $userinfo = $xoopsDB->fetchArray($result) ) {
			$userinfo = new XoopsUser($userinfo['uid']);
			$user = array();
			$avatar = $userinfo->user_avatar();
			if ($avatar == 'blank.gif' &&  $xoopsModuleConfig['defaultavatar']){
                $user['avatar'] = "<img src='".XOOPS_URL."/modules/membership/images/davatar.gif' alt='' width='64' height='64' />";
            } else {
                $user['avatar'] = "<img src='".XOOPS_URL."/uploads/".$userinfo->user_avatar()."' alt='' width='64' height='64' />";
            }
            $user['nickname'] = "<a href='".XOOPS_URL."/userinfo.php?uid=".$userinfo->uid()."'>".$userinfo->uname("E")."</a>";
			$user['regdate'] = formatTimeStamp($userinfo->user_regdate(),"m");
			$showmail = 0;
			if ( $userinfo->user_viewemail() ) {
				$showmail = 1;
			} else {
				if ( $is_admin ) {
				    $showmail = 1;
				}
			}
			if ( $showmail ){
				$user['email']  = "<a href='mailto:".$userinfo->email("E")."'>";
                $user['email'] .= "<img src='".XOOPS_URL."/images/icons/email.gif' border='0' alt='".sprintf(_SENDEMAILTO,$userinfo->uname("E"))."' /></a>";
			} else {
				$user['email'] = "";
			}

			if ( $xoopsUser ) {
				$user['pm']  = "<a href='javascript:openWithSelfMain(\"".XOOPS_URL."/pmlite.php?send2=1&to_userid=".$userinfo->uid()."\",\"pmlite\",450,370);'>";
                $user['pm'] .= "<img src='".XOOPS_URL."/images/icons/pm.gif' border='0' alt='".sprintf(_SENDPMTO,$userinfo->uname("E"))."' /></a>";
            } else {
				$user['pm']  = "";
			}
			if ( $userinfo->url("E") ) {
			    $user['url'] = "<a href='".$userinfo->url("E")."' target=new><img src='".XOOPS_URL."/images/icons/www.gif' border='0' alt='"._VISITWEBSITE."' /></a>";
            } else {
			     $user['url'] = "";
			}
            if ( $is_admin ) {
                $user['functions']  = "[ <a href='".XOOPS_URL."/modules/system/admin.php?fct=users&op=reactivate&uid=".$userinfo->uid()."&op=modifyUser'>"._MA_MSHIP_EDIT."</a> | ";
                $user['functions'] .= "<a href='".XOOPS_URL."/modules/system/admin.php?fct=users&op=delUser&uid=".$userinfo->uid()."'>"._MA_MSHIP_DELETE."</a> ]";
            }
            $xoopsTpl->append('users', $user);
            unset ($user);

        }

    //$countstring = ($totalcount != 1 )?_MA_PUB_NSTORIES:_MA_PUB_NSTORY;
    //$xoopsTpl->assign('stories_count', $totalcount.' '.$countstring);

    if ( $totalcount > $pagesize ) {
        include_once XOOPS_ROOT_PATH.'/class/pagenav.php';
        $pagenav = new XoopsPageNav($totalcount, $pagesize, $start, 'start', ltrim($pagenav_args,'&'));
        $xoopsTpl->assign('pagenav', $pagenav->renderNav());
    } else {
        $xoopsTpl->assign('pagenav', '');
    }

    } else {
        $xoopsTpl->assign('no_results', sprintf(_MA_MSHIP_NOUSERFOUND,$letter));
    }
}

include(XOOPS_ROOT_PATH."/footer.php");

?>
