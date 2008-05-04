<?php
//  Author: SMD & Trabis
//  URL: http://www.xoopsmalaysia.org  & http://www.xuups.com
//  E-Mail: webmaster@xoopsmalaysia.org  & lusopoemas@gmail.com

include "../../mainfile.php";
include "../../header.php";
$myts =& MyTextSanitizer::getInstance();
function alpha() {
	global $sortby, $perm_letter, $xoopsConfig;
    $num = count($perm_letter) - 1;
    echo "<div align='center'>[ "; // start of HTML
    $counter = 0;
    while (list(, $ltr) = each($perm_letter)) {
   	    echo "<a href='".XOOPS_URL."/modules/membership/index.php?letter=".$ltr."&sortby=".$sortby."'>".$ltr."</a>";
   	    if ( $counter == round($num/2) ) {
       	    echo " ]\n<br />\n[ ";
       	} elseif ( $counter != $num ) {
       	    echo "&nbsp;|&nbsp;\n";
       	}
       	$counter++;
    }
    echo " ]\n</div>\n<br />\n";
}

if ( $xoopsConfig['startpage'] == "membership" ) {
	$xoopsOption['show_rblock'] =1;
	include(XOOPS_ROOT_PATH."/header.php");
	make_cblock();
	echo "<br />";
} else {
	$xoopsOption['show_rblock'] =1;
	include(XOOPS_ROOT_PATH."/header.php");
	echo "<br />";
}

$perm_letter = array (_ML_ALL, "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",_ML_OTHER);
$perm_sortby = array ("uid","user_avatar","uname","user_regdate","email","url");
$perm_orderby = array ("ASC","DESC");

$pagesize = 10;
$letter = isset($_GET['letter'])? $_GET['letter']: '';
$sortby = isset($_GET['sortby'])? $_GET['sortby']: '';
$orderby = isset($_GET['orderby'])? $_GET['orderby']: '';

if (!in_array($letter, $perm_letter)) $letter = _ML_ALL;
if (!in_array($sortby, $perm_sortby)) $sortby = "uid";
if (!in_array($orderby, $perm_orderby)) $orderby = "ASC";

$page = isset($_GET['page'])? intval($_GET['page']): 1;

$query = isset($_GET['query'])? $myts->addSlashes($_GET['query']): '';
$query = isset($_POST['query'])? $myts->addSlashes($_POST['query']): $query;

//Show last member, if there is a querry than show last member from result
if ( $query != '' ) {
        $where = "WHERE level>0 AND (uname LIKE '%$query%' OR user_icq LIKE '%$query%' ";
        $where .= "OR user_from LIKE '%$query%' OR user_sig LIKE '%$query%' ";
        $where .= "OR user_aim LIKE '%$query%' OR user_yim LIKE '%$query%' OR user_msnm like '%$query%'";
    if ( $xoopsUser ) {
   	    if ( $xoopsUser->isAdmin() ) {
  		    $where .= " OR email LIKE '%$query%'";
        }
    }
	$where .= ") ";
} else {
    $where = "WHERE level>0";
}
$result = $xoopsDB->query("SELECT uid, uname FROM ".$xoopsDB->prefix("users")." $where ORDER BY uid DESC",1,0);
list($lastuid, $lastuser) = $xoopsDB->fetchRow($result);


echo "<div align='center'><b>";
printf(_ML_WELCOMETO,$xoopsConfig['sitename']);
echo "</b><br /><br />\n";
echo _ML_GREETINGS." <a href='".XOOPS_URL."/userinfo.php?uid=".$lastuid."'>".$lastuser."</a></div>\n";

echo "<div align='center'>";
echo "</div><br /><br />";
        
echo "<table align='center'><tr><td align='right' width=58%><form action='".XOOPS_URL."/modules/membership/index.php' method='post'>";
if ( $query != '' ) {
    echo "<input type='text' size='30' name='query' value='".htmlspecialchars(stripslashes($query))."' />";
} else {
    echo "<input type='text' size='30' name='query' />";
}
echo "<input type='submit' value='"._ML_SEARCH."' /></form></td><td>";

echo "<form action='".XOOPS_URL."/modules/membership/index.php' method='post'>";
echo "<input type='submit' value='" ._ML_RESETSEARCH."' />";
echo "</form></td></tr></table>";
alpha();

$min = $pagesize * ($page - 1); 
$max = $pagesize; 
        
$count = "SELECT COUNT(uid) AS total FROM ".$xoopsDB->prefix("users")." "; // Count all the users in the db..
$select = "SELECT uid, name, uname, email, url, user_avatar, user_regdate, user_icq, user_from, user_aim, user_yim, user_msnm, user_viewemail FROM ".$xoopsDB->prefix("users")." ";
if ( ( $letter != _ML_OTHER ) AND ( $letter != _ML_ALL ) ) {
	$where = "WHERE level>0 AND uname LIKE '".$letter."%' ";
} else if ( ( $letter == _ML_OTHER ) AND ( $letter != _ML_ALL ) ) {
    $where = "WHERE level>0 AND uname REGEXP '^\[1-9]' ";
} else { 
    $where = "WHERE level>0 ";
}
$sort = "order by $sortby $orderby";


if ( $query != '' ) {
    $where = "WHERE level>0 AND (uname LIKE '%$query%' OR user_icq LIKE '%$query%' ";
    $where .= "OR user_from LIKE '%$query%' OR user_sig LIKE '%$query%' ";
    $where .= "OR user_aim LIKE '%$query%' OR user_yim LIKE '%$query%' OR user_msnm LIKE '%$query%'";
   	if ( $xoopsUser ) {
		if ( $xoopsUser->isAdmin() ) {
		  $where .= "OR email LIKE '%$query%'";
		}
    }
	$where .= ") ";
}
$count_result = $xoopsDB->query($count.$where);
list($num_rows_per_order) = $xoopsDB->fetchRow($count_result);

$result = $xoopsDB->query($select.$where.$sort,$max,$min) or die($xoopsDB->error() ); // Now lets do it !!
echo "<br />";
//Hum, why is this?
if ( $letter != "front" ) {

	echo "<table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%' class='head'><tr><td>\n";
	echo "<table width='100%' border='0' cellspacing='1' cellpadding='4'><tr>\n";
	echo "<td align='center'><span ><b><a href='".XOOPS_URL."/modules/membership/index.php?letter=".$letter."&sortby=user_avatar&orderby=".$orderby."&query=".$query."'>"._ML_AVATAR."</a></b></span></td>\n";
    echo "<td align='center'><span ><b><a href='".XOOPS_URL."/modules/membership/index.php?letter=".$letter."&sortby=uname&orderby=".$orderby."&query=".$query."'>"._ML_NICKNAME."</a></b></span></td>\n";

	echo "<td align='center'><span ><b><a href='".XOOPS_URL."/modules/membership/index.php?letter=".$letter."&sortby=user_regdate&orderby=".$orderby."&query=".$query."'>"._ML_REGDATE."</a></b></span></td>\n";
    echo "<td align='center'><span ><b><a href='".XOOPS_URL."/modules/membership/index.php?letter=".$letter."&sortby=email&orderby=".$orderby."&query=".$query."'>"._ML_EMAIL."</a></b></span></td>\n";
	echo "<td align='center'><span ><b><a href='".XOOPS_URL."/modules/membership/index.php?letter=".$letter."&sortby=email&orderby=".$orderby."&query=".$query."'>"._ML_PM."</a></b></span></td>\n";
    echo "<td align='center'><span ><b><a href='".XOOPS_URL."/modules/membership/index.php?letter=".$letter."&sortby=url&orderby=".$orderby."&query=".$query."'>"._ML_URL."</a></b></span></td>\n";
    $cols = 7;
    if ( $xoopsUser ) {
		if ( $xoopsUser->isAdmin() ) {
            $cols = 8;
           	echo "<td align='center'><span ><b><a href='".XOOPS_URL."/modules/membership/index.php?letter=".$letter."&sortby=email&orderby=".$orderby."&query=".$query."'>"._ML_FUNCTIONS."</a></b></span></td>\n";
		}
    }
    echo "</tr>";
    $a = 0;
    $dcolor_A = "odd";
    $dcolor_B = "even";

    $num_users = $xoopsDB->getRowsNum($result); //number of users per sorted and limit query
    if ( $num_rows_per_order > 0  ) {
        while ( $userinfo = $xoopsDB->fetchArray($result) ) {
			$userinfo = new XoopsUser($userinfo['uid']);
            $dcolor = ($a == 0 ? $dcolor_A : $dcolor_B);
            echo "<tr class='".$dcolor."'>\n";
			echo "<td align='center'><img src='".XOOPS_URL."/uploads/".$userinfo->user_avatar()."' alt='' width='64' height='64' />&nbsp;</td>\n";
			echo "<td align='center'><a href='".XOOPS_URL."/userinfo.php?uid=".$userinfo->uid()."'>".$userinfo->uname("E")."</a>&nbsp;</td>\n";
            echo "\n";
			echo "<td align='center'>".formatTimeStamp($userinfo->user_regdate(),"m")."&nbsp;</td>\n";
			$showmail = 0;
			if ( $userinfo->user_viewemail() ) {
				$showmail = 1;
			} else {
				if ( $xoopsUser ) {
					if ( $xoopsUser->isAdmin() ) {
						$showmail = 1;
					}
				}
			}
			if ( $showmail ){
				echo "<td align='center'><a href='mailto:".$userinfo->email("E")."'><img src='".XOOPS_URL."/images/icons/email.gif' border='0' alt='";
				printf(_SENDEMAILTO,$userinfo->uname("E"));
				echo "' /></a></td>\n";
			} else {
				echo "<td>&nbsp;</td>\n";
			}
			echo "<td align='center'>";
			if ( $xoopsUser ) {
				echo "<a href='javascript:openWithSelfMain(\"".XOOPS_URL."/pmlite.php?send2=1&to_userid=".$userinfo->uid()."\",\"pmlite\",450,370);'>";
				echo "<img src='".XOOPS_URL."/images/icons/pm.gif' border='0' alt='";
				printf(_SENDPMTO,$userinfo->uname("E"));
				echo "' /></a>";
			} else {
				echo "&nbsp;";
			}
			echo "</td>\n";
			if ( $userinfo->url("E") ) {
                echo "<td align='center'><a href='".$userinfo->url("E")."' target=new><img src='".XOOPS_URL."/images/icons/www.gif' border='0' alt='"._VISITWEBSITE."' /></a></td>\n";
			} else {
				echo "<td>&nbsp;</td>\n";
			}
            if ( $xoopsUser ) {
				if ( $xoopsUser->isAdmin() ) {
                    echo "<td align='center'>[ <a href='".XOOPS_URL."/modules/system/admin.php?fct=users&op=reactivate&uid=".$userinfo->uid()."&op=modifyUser'>"._ML_EDIT."</a> | \n";
                    echo "<a href='".XOOPS_URL."/modules/system/admin.php?fct=users&op=delUser&uid=".$userinfo->uid()."'>"._ML_DELETE."</a> ]</td>\n";
				}
            }
           	echo "</tr>";
           	$a = ($dcolor == $dcolor_A ? 1 : 0);
        } // end while ()
		echo "</table></td></tr></table>";
        // start of next/prev/row links.
		echo "<br /><br />";
        echo "\n<table height='20' width='100%' cellspacing='0' cellpadding='0' border='0' ><tr><td class='bg1'>";
        if ( $num_rows_per_order > $pagesize ) {
            $total_pages = ceil($num_rows_per_order / $pagesize); // How many pages are we dealing with here ??
            $prev_page = $page - 1;
            if ( $prev_page > 0 ) {
                echo "<td align='left' width='15%'><a href='".XOOPS_URL."/modules/membership/index.php?letter=".$letter."&sortby=".$sortby."&query=".$query."&page=".$prev_page."'>";
                echo "<<($prev_page)</a></td>";
            } else {
                echo "<td width='15%'>&nbsp;</td>\n";
            }
            echo "<td align='center' width='70%'>";
            echo "</td>";
            $next_page = $page + 1;
            if ( $next_page <= $total_pages ) {
                echo "<td align='right' width='15%'><a href='".XOOPS_URL."/modules/membership/index.php?letter=".$letter."&sortby=".$sortby."&orderby=".$orderby."&query=".$query."&page=".$next_page."'>";
                echo "(".$next_page.")>></a></td>";
            } else {
                echo "<td width='15%'>&nbsp;</td>\n";
            }
            /* Added a numbered page list, only shows up to 50 pages. */
            echo "</tr><tr><td colspan='3' align='center'>";
            echo " <small>[ </small>";
            for ( $n = 1; $n < $total_pages; $n++ ) {
                if ( $n == $page ) {
                    echo "<small><b>$n</b></small></a>";
                } else {
                    echo "<a href='".XOOPS_URL."/modules/membership/index.php?letter=".$letter."&sortby=".$sortby."&orderby=".$orderby."&query=".$query."&page=".$n."'>";
                    echo "<small>$n</small></a>";
                }
                if ( $n >= 50 ) {  // if more than 50 pages are required, break it at 50.
                    $break = true;
                    break;
                } else {  // guess not.
                    echo "<small> | </small>";
                }
            }
            if(!isset($break)) { // are we sopposed to break ?
                if ( $n == $page ) {
                    echo "<small><b>$n</b></small></a>";
                } else {
                    echo "<a href='".XOOPS_URL."/modules/membership/index.php?letter=".$letter."&sortby=".$sortby."&orderby=".$orderby."&query=".$query."&page=".$total_pages."'>";
                    echo "<small>$n</small></a>";
                }
            }
            echo " <small>]</small> ";
            echo "</td></td></tr>";
        }else{
            echo "<td align='center'>";
            echo "</td></td></tr>";
        }
        echo "</table>\n";
        // end of next/prev/row links
    } else {
        echo "<tr><td class='bg3' colspan='".$cols."' align='center'><br />\n";
        echo "<b>";
        printf(_ML_NOUSERFOUND,$letter);
        echo "</b>\n";
        echo "<br /></td></tr>\n";
   	    echo "</table></td></tr></table><br />\n";
    }
}

include(XOOPS_ROOT_PATH."/footer.php");

?>
