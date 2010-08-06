<?php
require("header.php");

xoops_cp_header();

$handler = xoops_getmodulehandler('resolver');

$resolvers=$handler->getResolvers();

echo "<a href=\"javascript:flexblokTree.openAll();\">"._SMARTBLOCKS_OPEN_ALL."</a>";
echo " | ";
echo "<a href=\"javascript:flexblokTree.closeAll();\">"._SMARTBLOCKS_CLOSE_ALL."</a>";

echo "<script src=\"".XOOPS_URL."/modules/smartobject/include/dtree.js\"></script>";
echo "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"".XOOPS_URL."/modules/smartobject/include/dtree.css\">";
echo "<script>";
echo "var flexblokTree = new dTree('flexblokTree');";
echo "var flexblokTree_images = '".XOOPS_URL."/modules/smartobject/include/dtree_img/';";
?>
flexblokTree.icon = { root : flexblokTree_images + 'base.gif', folder :
flexblokTree_images + 'folder.gif', folderOpen : flexblokTree_images +
'imgfolder.gif', node : flexblokTree_images + 'imgfolder.gif', empty :
flexblokTree_images + 'empty.gif', line : flexblokTree_images +
'line.gif', join : flexblokTree_images + 'join.gif', joinBottom :
flexblokTree_images + 'joinbottom.gif', plus : flexblokTree_images +
'plus.gif', plusBottom : flexblokTree_images + 'plusbottom.gif', minus :
flexblokTree_images + 'minus.gif', minusBottom : flexblokTree_images +
'minusbottom.gif', nlPlus : flexblokTree_images + 'nolines_plus.gif',
nlMinus : flexblokTree_images + 'nolines_minus.gif' };
flexblokTree.config.useLines = true; flexblokTree.config.useIcons =
false; flexblokTree.config.useCookies = true;
flexblokTree.config.closeSameLevel = false; flexblokTree.add(0, -1, '
<?php echo _SMARTBLOCKS_SMARTBLOCKS; ?>
', 'page.php?moduleid=0&location=0');

<?php
$temp = 0;
foreach($resolvers as $resolver) {
    echo "//".$resolver->name."\n";

    $pages=$resolver->getAllLocations();
    echo "flexblokTree.add({$resolver->moduleid}, 0, '{$resolver->name}', 'page.php?moduleid={$resolver->moduleid}&location=0');\n";

    $history[0] = $resolver->moduleid;
    if(sizeof($pages)>0) {

        if(is_array($pages)) {
            foreach($pages as $page) {
                $id = ($resolver->moduleid*100000)+$page['location']; //make a unique ID
                $history[$page['level']] = $id; //set it in history
                $parent = isset($history[$page['level']-1]) ? $history[$page['level']-1] : $resolver->moduleid;
                echo "flexblokTree.add($id, $parent, '".htmlspecialchars($page['name'], ENT_QUOTES)."', 'page.php?moduleid={$resolver->moduleid}&location={$page['location']}');\n";
            }
        }
    }
    $temp++;
}
echo "document.write(flexblokTree);";
echo "</script>";

xoops_cp_footer();
?>
