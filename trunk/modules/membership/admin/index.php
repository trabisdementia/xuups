<?php
//  Author: Trabis
//  URL: http://www.xuups.com
//  E-Mail: lusopoemas@gmail.com

include_once '../../../include/cp_header.php';
include_once 'functions.php';
//**********************************************************************************************************************************************
// **** Main
// **********************************************************************************************************************************************
$op = 'default';
if(isset($_POST['op'])) {
 $op=$_POST['op'];
} else {
	if(isset($_GET['op'])) {
		$op=$_GET['op'];
	}
}


switch ($op) {
	case 'import':
	    xoops_cp_header();
        adminmenu(1);
        echo '<h4>' . _AM_MSHIP_IMPORT . '</h4>';
        echo"<table width='100%' border='0' cellspacing='1' class='outer'><tr><td class=\"odd\">";
        echo " - <b><a href='import.php'>" . _AM_MSHIP_IMPORT_ITC . '</a></b>';
        echo "<br /><br />\n";
        echo"</td></tr></table>";
        break;

    case 'default':
    default:
        xoops_cp_header();
        adminmenu(-1);
        echo '<h4>' . _AM_MSHIP_WELCOME . '</h4>';
        break;
}

xoops_cp_footer();
?>
