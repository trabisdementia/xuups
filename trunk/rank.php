<?php
//  Author: SMD & Trabis
//  URL: http://www.xoopsmalaysia.org  & http://www.xuups.com
//  E-Mail: webmaster@xoopsmalaysia.org  & lusopoemas@gmail.com

include "../../mainfile.php";
include "../../header.php";

$db =& Database::getInstance();
echo "<br><h4 style='text-align:center;'>Member Rank</h4><br><br>
	  <table width='100%' class='head' cellpadding='4' cellspacing='1'>
	  <tr align='center'>
	  <td><font color=#666666>Rank</font></td>
	  <td><font color=#666666>Minimum Post</td>
	  <td><font color=#666666>Maximum Post</font></td>
	  <td><font color=#666666>Image</font></td></tr>";

$result = $db->query("SELECT * FROM ".$db->prefix("ranks")." where rank_special=0 ORDER BY rank_id");
$count = 0;
while ( $rank = $db->fetchArray($result) ) {
    if ($count % 2 == 0) {
        $class = 'odd';
    } else {
        $class = 'even';
    }
    echo "<tr class='$class' align='center'>
          <td>".$rank['rank_title']."</td>
          <td>".$rank['rank_min']."</td>
          <td>".$rank['rank_max']."</td>
          <td>";
    if ( $rank['rank_image'] ) {
        echo '<img src="'.XOOPS_URL.'/uploads/'.$rank['rank_image'].'" alt="" /></td>';
    } else {
        echo '&nbsp;';
    }
    echo"</tr>";
    $count++;
}
echo '</table><br /><br />';

include_once XOOPS_ROOT_PATH."/footer.php";
?>

