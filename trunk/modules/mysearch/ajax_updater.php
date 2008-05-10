<?php
include "../../mainfile.php";
error_reporting(0);
$xoopsLogger->activated = false;
$myts =& MyTextSanitizer::getInstance();
$mysearch_handler = xoops_getmodulehandler('searches', 'mysearch');
if (isset($_POST["query"])){
    $query = $myts->addSlashes(utf8_decode($_POST["query"]));
    $elements = $mysearch_handler->ajaxMostSearched(0,5,$query);
    if (is_array($elements) && count($elements) > 0){
        header('Content-type: text/html; charset=iso-8859-15');
        echo '<ul>';
        for ($i=0; $i<count($elements); $i++) {
            echo '<li>';
            echo strtolower($elements[$i]['keyword']);
            //echo ' ('.$elements[$i]['count'].')';
            echo '</li>';
        }
        echo '</ul>';
    }
}
?>
