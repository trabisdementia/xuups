<?php

/**
* $Id: docbook_export.php 1429 2008-04-05 02:00:06Z malanciault $
* Module: Publisher
* Author: mariuss
* Licence: GNU
*/

include_once '../../../include/cp_header.php';

$op = 'go';//'start';

if (isset($_POST['op']) && ($_POST['op'] == 'go'))
{
    $op = $_POST['op'];
}

if ($op == 'start')
{
	include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
	
	xoops_cp_header ();
    
	
	xoops_cp_footer();
	exit ();
}

if ($op == 'go')
{
    Header("Content-Disposition: attachment; filename=publisher.xml");
    Header("Connection: close");
    Header("Content-Type: text/xml; name=publisher.xml");
    
    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n";
    echo "<!DOCTYPE qandaset PUBLIC \"-//OASIS//DTD DocBook XML V4.2//EN\" \"http://www.oasis-open.org/docbook/xml/4.2/docbookx.dtd\">\r\n";
    echo "<qandaset defaultlabel=\"qanda\" Conformance=\"1.0 {module version}\">\r\n";
    
    echo "  <blockinfo>\r\n";
    echo "    <publisher>\r\n";
    echo "      <publishername>\r\n";
    echo "        {site name}\r\n";
    echo "        <ulink url=\"{site url}\"/>\r\n";
    echo "      </publishername>\r\n";
    echo "    </publisher>\r\n";
    echo "    <date>{time of export}</date>\r\n";
    echo "  </blockinfo>\r\n";
        
    echo "  <title>{module title}</title>\r\n";
    
    $resultC = $xoopsDB->query ("select * from ".$xoopsDB->prefix("publisher_categories"));
    while ($arrC = $xoopsDB->fetchArray ($resultC))
    {
        extract ($arrC, EXTR_PREFIX_ALL, 'c');
        
        echo "  <qandadiv ID=\"c$c_categoryid\" Revision=\"$c_created\">\r\n";
        echo "    <title>".encodeText ($c_name)."</title>\r\n";
        echo "    <para>".encodeText ($c_description)."</para>\r\n";
        
        $resultQ = $xoopsDB->query ("select * from ".$xoopsDB->prefix("publisher_item")." where categoryid=$c_categoryid");
        while ($arrQ = $xoopsDB->fetchArray ($resultQ))
        {
            extract ($arrQ, EXTR_PREFIX_ALL, 'q');
            
            echo "    <qandaentry ID=\"q$q_itemid\" Revision=\"$q_datesub\" Condition=\"$q_html $q_smiley $q_xcodes\" XrefLabel=\"$q_modulelink $q_contextpage\" Vendor=\"".getUserFullName ($q_uid)."\">\r\n";
            echo "      <question>\r\n";
            echo "        <para>".encodeText ($q_question)."</para>\r\n";
            if (!empty ($q_howdoi))
            {
                echo "        <note Conformance=\"howdoi\">\r\n";
                echo "          <title>{'How do I' from language file}</title>\r\n";
                echo "          <para>".encodeText ($q_howdoi)."</para>\r\n";
                echo "        </note>\r\n";
            }
            if (!empty ($q_diduno))
            {
                echo "        <note Conformance=\"diduno\">\r\n";
                echo "          <title>{'Did you know' from language file}</title>\r\n";
                echo "          <para>".encodeText ($q_diduno)."</para>\r\n";
                echo "        </note>\r\n";
            }
            echo "      </question>\r\n";
    
            $resultA = $xoopsDB->query ("select * from ".$xoopsDB->prefix("publisher_answers")." where answerid=$q_answerid");
            while ($arrA = $xoopsDB->fetchArray ($resultA))
            {
                extract ($arrA, EXTR_PREFIX_ALL, 'a');
                
                echo "      <answer ID=\"a$a_answerid\" Revision=\"$a_datesub\" Vendor=\"".getUserFullName ($a_uid)."\">\r\n";
                echo "        <para>".encodeText ($a_answer)."</para>\r\n";
                echo "      </answer>\r\n";
            }
            mysql_free_result ($resultA);
            
            echo "    </qandaentry>\r\n";
        }
        mysql_free_result ($resultQ);
        
        echo "  </qandadiv>\r\n";
    }
    
    echo "</qandaset>\r\n";
    
    exit();
}

function encodeText ( $text )
{
    return utf8_encode (htmlspecialchars ($text));
}

function getUserFullName ( $uid )
{
    global $xoopsDB;
    
    return $uid;
}
?>

