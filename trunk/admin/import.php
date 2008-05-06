<?php
//  Author: Alexey Ozerov & Trabis
//  URL: http://www.ozerov.de/bigdump.php  & http://www.xuups.com
//  E-Mail: alexey@ozerov.de  & lusopoemas@gmail.com

include_once '../../../mainfile.php';
if (!is_object($xoopsUser) || (is_object($xoopsUser) && !$xoopsUser->isAdmin())){
    redirect_header(XOOPS_URL."/index.php",1,_NOPERM);
    exit();
};
error_reporting(0);
$xoopsLogger->activated = false;

$ajax             = true;   // AJAX mode: import will be done without refreshing the website
$linespersession  = 100;   // Lines to be executed per one import session
$delaypersession  = 0;     // You can specify a sleep time in milliseconds after each session
                            // Works only if JavaScript is activated. Use to reduce server overrun
$filename='';


// *******************************************************************************************
// If not familiar with PHP please don't change anything below this line
// *******************************************************************************************

if ($ajax)
  ob_start();
define ('DATA_CHUNK_LENGTH',100);  // How many chars are read per time
define ('MAX_QUERY_LINES',1);      // How many lines may be considered to be one query (except text lines)
define ('TESTMODE',false);           // Set to true to process the file without actually accessing the database

header("Expires: Mon, 1 Dec 2003 01:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

@ini_set('auto_detect_line_endings', true);
@set_time_limit(0);

// Clean and strip anything we don't want from user's input [0.27b]

foreach ($_REQUEST as $key => $val) 
{
  $val = preg_replace("/[^_A-Za-z0-9-\.&= ]/i",'', $val);
  $_REQUEST[$key] = $val;
}
//
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Membership Ip-To-Contry Importer</title>
<meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1"/>
<meta http-equiv="CONTENT-LANGUAGE" content="EN"/>

<meta http-equiv="Cache-Control" content="no-cache/"/>
<meta http-equiv="Pragma" content="no-cache"/>
<meta http-equiv="Expires" content="-1"/>
<link rel="stylesheet" type="text/css" media="all" href="style.css" />


</head>

<body>
<div id="xo-banner"><img src="img/header-logo.png" alt="ImpressCMS" /></div>
<div id="xo-content">
<center>

<table width="780" cellspacing="0" cellpadding="0">
<tr><td class="transparent">

<?php

function skin_open() {
echo ('<div class="skin1">');
}

function skin_close() {
echo ('</div>');
}

skin_open();
echo ('<h1>Membership Ip-To-Country Importer</h1>');
skin_close();

$error = false;
$file  = false;

// Check PHP version

if (!$error && !function_exists('version_compare'))
{ echo ("<p class=\"error\">PHP version 4.1.0 is required for Membership Ip-To-Country Importer to proceed. You have PHP ".phpversion()." installed. Sorry!</p>\n");
  $error=true;
}

// Calculate PHP max upload size (handle settings like 10M or 100K)

if (!$error)
{ $upload_max_filesize=ini_get("upload_max_filesize");
  if (eregi("([0-9]+)K",$upload_max_filesize,$tempregs)) $upload_max_filesize=$tempregs[1]*1024;
  if (eregi("([0-9]+)M",$upload_max_filesize,$tempregs)) $upload_max_filesize=$tempregs[1]*1024*1024;
  if (eregi("([0-9]+)G",$upload_max_filesize,$tempregs)) $upload_max_filesize=$tempregs[1]*1024*1024*1024;
}

// Get the current directory

if (isset($_SERVER["CGIA"]))
  $upload_dir=dirname($_SERVER["CGIA"]);
else if (isset($_SERVER["ORIG_PATH_TRANSLATED"]))
  $upload_dir=dirname($_SERVER["ORIG_PATH_TRANSLATED"]);
else if (isset($_SERVER["ORIG_SCRIPT_FILENAME"]))
  $upload_dir=dirname($_SERVER["ORIG_SCRIPT_FILENAME"]);
else if (isset($_SERVER["PATH_TRANSLATED"]))
  $upload_dir=dirname($_SERVER["PATH_TRANSLATED"]);
else 
  $upload_dir=dirname($_SERVER["SCRIPT_FILENAME"]);

// Handle file upload

if (!$error && isset($_REQUEST["uploadbutton"]))
{ if (is_uploaded_file($_FILES["dumpfile"]["tmp_name"]) && ($_FILES["dumpfile"]["error"])==0)
  { 
    $uploaded_filename=str_replace(" ","_",$_FILES["dumpfile"]["name"]);
    $uploaded_filename=preg_replace("/[^_A-Za-z0-9-\.]/i",'',$uploaded_filename);
    $uploaded_filepath=str_replace("\\","/",$upload_dir."/".$uploaded_filename);

    if (file_exists($uploaded_filename))
    { echo ("<p class=\"error\">File $uploaded_filename already exist! Delete and upload again!</p>\n");
    }
    else if (!eregi("(\.(sql|gz|csv))$",$uploaded_filename))
    { echo ("<p class=\"error\">You may only upload .gz or .csv files.</p>\n");
    }
    else if (!@move_uploaded_file($_FILES["dumpfile"]["tmp_name"],$uploaded_filepath))
    { echo ("<p class=\"error\">Error moving uploaded file ".$_FILES["dumpfile"]["tmp_name"]." to the $uploaded_filepath</p>\n");
      echo ("<p>Check the directory permissions for $upload_dir (must be 777)!</p>\n");
    }
    else
    { echo ("<p class=\"success\">Uploaded file saved as $uploaded_filename</p>\n");
    }
  }
  else
  { echo ("<p class=\"error\">Error uploading file ".$_FILES["dumpfile"]["name"]."</p>\n");
  }
}


// Handle file deletion (delete only in the current directory for security reasons)

if (!$error && isset($_REQUEST["delete"]) && $_REQUEST["delete"]!=basename($_SERVER["SCRIPT_FILENAME"]))
{ if (eregi("(\.(sql|gz|csv))$",$_REQUEST["delete"]) && @unlink(basename($_REQUEST["delete"])))
    echo ("<p class=\"success\">".$_REQUEST["delete"]." was removed successfully</p>\n");
  else
    echo ("<p class=\"error\">Can't remove ".$_REQUEST["delete"]."</p>\n");
}


// List uploaded files in multifile mode

if (!$error && !isset($_REQUEST["fn"]) && $filename=="")
{ if ($dirhandle = opendir($upload_dir)) 
  { $dirhead=false;
    while (false !== ($dirfile = readdir($dirhandle)))
    { if ($dirfile != "." && $dirfile != ".." && $dirfile!=basename($_SERVER["SCRIPT_FILENAME"]))
      { if (!$dirhead)
        { echo ("<table width=\"100%\" cellspacing=\"2\" cellpadding=\"2\">\n");
          echo ("<tr><th>Filename</th><th>Size</th><th>Date&amp;Time</th><th>Type</th><th>&nbsp;</th><th>&nbsp;</th>\n");
          $dirhead=true;
        }
        if (eregi("\.csv$",$dirfile)){
          echo ("<tr><td>$dirfile</td><td class=\"right\">".filesize($dirfile)."</td><td>".date ("Y-m-d H:i:s", filemtime($dirfile))."</td>");
          echo ("<td>CSV</td>");
        }
        if ((eregi("\.gz$",$dirfile) && function_exists("gzopen")) || eregi("\.csv$",$dirfile))
          echo ("<td><a href=\"".$_SERVER["PHP_SELF"]."?start=1&amp;fn=".urlencode($dirfile)."&amp;foffset=0&amp;totalqueries=0\">Start Import</a> into $db_name at $db_server</td>\n <td><a href=\"".$_SERVER["PHP_SELF"]."?delete=".urlencode($dirfile)."\">Delete file</a></td></tr>\n");
      }

    }
    if ($dirhead) echo ("</table>\n");
    else echo ("<p>No uploaded files found in the working directory</p>\n");
    closedir($dirhandle); 
  }
  else
  { echo ("<p class=\"error\">Error listing directory $upload_dir</p>\n");
    $error=true;
  }
}


// Single file mode

if (!$error && !isset ($_REQUEST["fn"]) && $filename!="")
{ echo ("<p><a href=\"".$_SERVER["PHP_SELF"]."?start=1&amp;fn=".urlencode($filename)."&amp;foffset=0&amp;totalqueries=0\">Start Import</a> from $filename into $db_name at $db_server</p>\n");
}


// File Upload Form

if (!$error && !isset($_REQUEST["fn"]) && $filename=="")
{ 

// Test permissions on working directory

  do { $tempfilename=time().".tmp"; } while (file_exists($tempfilename));
  if (!($tempfile=@fopen($tempfilename,"w")))
  { echo ("<p>Upload form disabled. Permissions for the working directory <i>$upload_dir</i> <b>must be set to 777</b> in order ");
    echo ("to upload files from here. Alternatively you can upload your dump files via FTP.</p>\n");
  }
  else
  { fclose($tempfile);
    unlink ($tempfilename);
 
    echo ("<p>You can now upload your ip-to-country.csv file up to $upload_max_filesize bytes (".round ($upload_max_filesize/1024/1024)." Mbytes)  ");
    echo ("directly from your browser to the server. Alternatively you can upload your file of any size via FTP.</p>\n");
    echo ("<p>Get the latest version of Ip-To-Country list at <a href='http://ip-to-country.webhosting.info/node/view/6' target='_blank'>http://ip-to-country.webhosting.info/node/view/6</a>.</p>\n");

?>
<form method="POST" action="<?php echo ($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="$upload_max_filesize">
<p>Dump file: <input type="file" name="dumpfile" accept="*/*" size=60"></p>
<p><input type="submit" name="uploadbutton" value="Upload"></p>
</form>
<?php
  }
}

// Open the file

if (!$error && isset($_REQUEST["start"]))
{ 

// Set current filename ($filename overrides $_REQUEST["fn"] if set)

  if ($filename!="")
    $curfilename=$filename;
  else if (isset($_REQUEST["fn"]))
    $curfilename=urldecode($_REQUEST["fn"]);
  else
    $curfilename="";

// Recognize GZip filename

  if (eregi("\.gz$",$curfilename)) 
    $gzipmode=true;
  else
    $gzipmode=false;

  if ((!$gzipmode && !$file=@fopen($curfilename,"rt")) || ($gzipmode && !$file=@gzopen($curfilename,"rt")))
  { echo ("<p class=\"error\">Can't open ".$curfilename." for import</p>\n");
    $error=true;
  }

// Get the file size (can't do it fast on gzipped files, no idea how)

  else if ((!$gzipmode && @fseek($file, 0, SEEK_END)==0) || ($gzipmode && @gzseek($file, 0)==0))
  { if (!$gzipmode) $filesize = ftell($file);
    else $filesize = gztell($file);                   // Always zero, ignore
  }
  else
  { echo ("<p class=\"error\">I can't seek into $curfilename</p>\n");
    $error=true;
  }
}
// *******************************************************************************************
// DROP AND CREATE TABLES HERE
// *******************************************************************************************
if (!$error && isset($_REQUEST["start"]) && isset($_REQUEST["foffset"]) && ($_REQUEST["start"]==1) && eregi("(\.(gz|csv))$",$curfilename))
{
skin_open();
//echo "Clearing Database ... <br><br>";
	$query = $xoopsDB->queryF("DROP TABLE IF EXISTS ".$xoopsDB->prefix("mship_ips"));

	if (!$query) {
		echo "<div class=\"errorcentr\"><img src='img/no.png'>Can't clear table '".$xoopsDB->prefix("mship_ips")."'!</div>";
	} else {
		echo "<div class=\"successcentr\"><img src='img/yes.png'>Table '".$xoopsDB->prefix("mship_ips")."' Dropped !</div>";
	}

	$query = $xoopsDB->queryF("CREATE TABLE ".$xoopsDB->prefix("mship_ips")." (
    `ipstart` varchar(10) NOT NULL default '',
    `ipend` varchar(10) NOT NULL default '',
    `ccode` varchar(2) NOT NULL default '',
    `ccode2` varchar(3) NOT NULL default '',
    `cname` varchar(30) NOT NULL default '',
    PRIMARY KEY  (`ipstart`),
    KEY `ipstart` (`ipstart`),
    KEY `ipend` (`ipend`)
    ) ENGINE=MyISAM");

	if (!$query) {
		echo "<div class=\"errorcentr\"><img src='img/no.png'>Can't create table '".$xoopsDB->prefix("mship_ips")."'!</div>";
	} else {
		echo "<div class=\"successcentr\"><img src='img/yes.png'>Table '".$xoopsDB->prefix("mship_ips")."' Re-Created !</div>";
	}
skin_close();
$_REQUEST["tables"]=true;
}
// *******************************************************************************************
// START IMPORT SESSION HERE
// *******************************************************************************************

if (!$error && isset($_REQUEST["start"]) && isset($_REQUEST["foffset"]) && eregi("(\.(gz|csv))$",$curfilename))
{

// Check start and foffset are numeric values

  if (!is_numeric($_REQUEST["start"]) || !is_numeric($_REQUEST["foffset"]))
  { echo ("<p class=\"error\">UNEXPECTED: Non-numeric values for start and foffset</p>\n");
    $error=true;
  }

  if (!$error)
  { $_REQUEST["start"]   = floor($_REQUEST["start"]);
    $_REQUEST["foffset"] = floor($_REQUEST["foffset"]);
    skin_open();
    if (TESTMODE) 
      echo ("<p class=\"centr\">TEST MODE ENABLED</p>\n");
    echo ("<p class=\"centr\">Processing file: <b>".$curfilename."</b></p>\n");
    echo ("<p class=\"smlcentr\">Starting from line: ".$_REQUEST["start"]."</p>\n");	
    skin_close();
  }

// Check $_REQUEST["foffset"] upon $filesize (can't do it on gzipped files)

  if (!$error && !$gzipmode && $_REQUEST["foffset"]>$filesize)
  { echo ("<p class=\"error\">UNEXPECTED: Can't set file pointer behind the end of file</p>\n");
    $error=true;
  }

// Set file pointer to $_REQUEST["foffset"]

  if (!$error && ((!$gzipmode && fseek($file, $_REQUEST["foffset"])!=0) || ($gzipmode && gzseek($file, $_REQUEST["foffset"])!=0)))
  { echo ("<p class=\"error\">UNEXPECTED: Can't set file pointer to offset: ".$_REQUEST["foffset"]."</p>\n");
    $error=true;
  }

// Start processing queries from $file

  if (!$error)
  { $query="";
    $queries=0;
    $totalqueries=$_REQUEST["totalqueries"];
    $linenumber=$_REQUEST["start"];
    $querylines=0;
    $inparents=false;

// Stay processing as long as the $linespersession is not reached or the query is still incomplete

    while ($linenumber<$_REQUEST["start"]+$linespersession || $query!="")
    {

// Read the whole next line

      $dumpline = "";
      while (!feof($file) && substr ($dumpline, -1) != "\n")
      { if (!$gzipmode)
          $dumpline .= fgets($file, DATA_CHUNK_LENGTH);
          //$dumpline .= fgetcsv($file, 1000, ",");
        else
          $dumpline .= gzgets($file, DATA_CHUNK_LENGTH);
      }
      if ($dumpline==="") break;

     
// Create an SQL query from CSV line

        $dumpline = str_replace('","','";"',$dumpline);
        $temp = explode(';',$dumpline);
        $dumpline = sprintf("INSERT INTO %s (ipstart, ipend, ccode, ccode2, cname) VALUES (%s, %s, %s, %s, %s)", $xoopsDB->prefix('mship_ips'), $temp[0],$temp[1],$temp[2],$temp[3],$temp[4]);
        $linenumber++;

// Add the line to query

        $query .= $dumpline;
        $querylines++;
      
// Stop if query contains more lines as defined by MAX_QUERY_LINES

      if ($querylines>MAX_QUERY_LINES)
      {
        echo ("<p class=\"error\">Stopped at the line $linenumber. </p>");
        $error=true;
        break;
      }

// Execute query if end of query detected (; as last character) AND NOT in parents


        if (!TESTMODE && !$xoopsDB->queryF($query))
        { echo ("<p class=\"error\">Error at the line $linenumber: ". trim($dumpline)."</p>\n");
          echo ("<p>Query: ".trim(nl2br(htmlentities($query)))."</p>\n");
          echo ("<p>MySQL: ".mysql_error()."</p>\n");
          $error=true;
          break;
        }
        $totalqueries++;
        $queries++;
        $query="";
        $querylines=0;

      }
      //$linenumber++;
  }

// Get the current file position

  if (!$error)
  { if (!$gzipmode) 
      $foffset = ftell($file);
    else
      $foffset = gztell($file);
    if (!$foffset)
    { echo ("<p class=\"error\">UNEXPECTED: Can't read the file pointer offset</p>\n");
      $error=true;
    }
  }

// Print statistics

skin_open();

// echo ("<p class=\"centr\"><b>Statistics</b></p>\n");

  if (!$error)
  { 
    $lines_this   = $linenumber-$_REQUEST["start"];
    $lines_done   = $linenumber-1;
    $lines_tota   = count(file($curfilename));
    $lines_togo   = $lines_tota-$lines_done;
    
    $queries_this = $queries;
    $queries_done = $totalqueries;
    $queries_tota = count(file($curfilename));
    $queries_togo = $queries_tota-$totalqueries;

    $bytes_this   = $foffset-$_REQUEST["foffset"];
    $bytes_done   = $foffset;
    $kbytes_this  = round($bytes_this/1024,2);
    $kbytes_done  = round($bytes_done/1024,2);
    $mbytes_this  = round($kbytes_this/1024,2);
    $mbytes_done  = round($kbytes_done/1024,2);
   
    if (!$gzipmode)
    {
      $bytes_togo  = $filesize-$foffset;
      $bytes_tota  = $filesize;
      $kbytes_togo = round($bytes_togo/1024,2);
      $kbytes_tota = round($bytes_tota/1024,2);
      $mbytes_togo = round($kbytes_togo/1024,2);
      $mbytes_tota = round($kbytes_tota/1024,2);
      
      $pct_this   = ceil($bytes_this/$filesize*100);
      $pct_done   = ceil($foffset/$filesize*100);
      $pct_togo   = 100 - $pct_done;
      $pct_tota   = 100;

      if ($bytes_togo==0) 
      { $lines_togo   = '0'; 
        $lines_tota   = $linenumber-1; 
        $queries_togo = '0'; 
        $queries_tota = $totalqueries; 
      }

      $pct_bar    = "<div style=\"height:15px;width:$pct_done%;background-color:#000080;margin:0px;\"></div>";
    }
    else
    {
      $bytes_togo  = ' ? ';
      $bytes_tota  = ' ? ';
      $kbytes_togo = ' ? ';
      $kbytes_tota = ' ? ';
      $mbytes_togo = ' ? ';
      $mbytes_tota = ' ? ';
      
      $pct_this    = ' ? ';
      $pct_done    = ' ? ';
      $pct_togo    = ' ? ';
      $pct_tota    = 100;
      $pct_bar     = str_replace(' ','&nbsp;','<tt>[         Not available for gzipped files          ]</tt>');
    }

    echo ("
    <center>
    <table width=\"520\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\">
    <tr><th class=\"bg4\"> </th><th class=\"bg4\">Session</th><th class=\"bg4\">Done</th><th class=\"bg4\">To go</th><th class=\"bg4\">Total</th></tr>
    <tr><th class=\"bg4\">Lines</th><td class=\"bg3\">$lines_this</td><td class=\"bg3\">$lines_done</td><td class=\"bg3\">$lines_togo</td><td class=\"bg3\">$lines_tota</td></tr>
    <tr><th class=\"bg4\">Queries</th><td class=\"bg3\">$queries_this</td><td class=\"bg3\">$queries_done</td><td class=\"bg3\">$queries_togo</td><td class=\"bg3\">$queries_tota</td></tr>
    <tr><th class=\"bg4\">Bytes</th><td class=\"bg3\">$bytes_this</td><td class=\"bg3\">$bytes_done</td><td class=\"bg3\">$bytes_togo</td><td class=\"bg3\">$bytes_tota</td></tr>
    <tr><th class=\"bg4\">KB</th><td class=\"bg3\">$kbytes_this</td><td class=\"bg3\">$kbytes_done</td><td class=\"bg3\">$kbytes_togo</td><td class=\"bg3\">$kbytes_tota</td></tr>
    <tr><th class=\"bg4\">MB</th><td class=\"bg3\">$mbytes_this</td><td class=\"bg3\">$mbytes_done</td><td class=\"bg3\">$mbytes_togo</td><td class=\"bg3\">$mbytes_tota</td></tr>
    <tr><th class=\"bg4\">%</th><td class=\"bg3\">$pct_this</td><td class=\"bg3\">$pct_done</td><td class=\"bg3\">$pct_togo</td><td class=\"bg3\">$pct_tota</td></tr>
    <tr><th class=\"bg4\">% bar</th><td class=\"bgpctbar\" colspan=\"4\">$pct_bar</td></tr>
    </table>
    </center>
    \n");

// Finish message and restart the script

    if ($linenumber<$_REQUEST["start"]+$linespersession)
    { echo ("<p class=\"successcentr\">Congratulations: End of file reached, assuming OK</p>\n");
      echo ("<p class=\"centr\"><a href=\"".XOOPS_URL."/modules/membership/admin/index.php\">Go back to Membership administration page</a></p>\n");
      $error=true;
    }
    else
    { if ($delaypersession!=0)
        echo ("<p class=\"centr\">Now I'm <b>waiting $delaypersession milliseconds</b> before starting next session...</p>\n");
        if (!$ajax) 
          echo ("<script language=\"JavaScript\" type=\"text/javascript\">window.setTimeout('location.href=\"".$_SERVER["PHP_SELF"]."?start=$linenumber&fn=".urlencode($curfilename)."&foffset=$foffset&totalqueries=$totalqueries\";',500+$delaypersession);</script>\n");
        echo ("<noscript>\n");
        echo ("<p class=\"centr\"><a href=\"".$_SERVER["PHP_SELF"]."?start=$linenumber&amp;fn=".urlencode($curfilename)."&amp;foffset=$foffset&amp;totalqueries=$totalqueries\">Continue from the line $linenumber</a> (Enable JavaScript to do it automatically)</p>\n");
        echo ("</noscript>\n");
   
      echo ("<p class=\"centr\">Press <b><a href=\"".$_SERVER["PHP_SELF"]."\">STOP</a></b> to abort the import <b>OR WAIT!</b></p>\n");
    }
  }
  else 
    echo ("<p class=\"error\">Stopped on error</p>\n");

skin_close();

}

if ($error)
  echo ("<p class=\"centr\"><a href=\"".$_SERVER["PHP_SELF"]."\">Start from the beginning</a></p>\n");

if ($file && !$gzipmode) fclose($file);
else if ($file && $gzipmode) gzclose($file);

?>

<p class="centr">Original script by <a href="mailto:alexey@ozerov.de">Alexey Ozerov</a> - <a href="http://www.ozerov.de/bigdump.php" target="_blank">BigDump Home</a></p>
<p class="centr">Script modified by <a href="mailto:lusopoemas@gmail.com">Trabis</a> - <a href="http://www.xuups.com" target="_blank">Xuups Home</a></p>
<p class="centr">&nbsp;</p>
<p class="centr"><a href="<?php echo XOOPS_URL.'/modules/membership/admin/index.php';?>" target="_blank">Administration Panel</a></p>

</td></tr></table>

</center>
</div>
</body>
</html>

<?php

// *******************************************************************************************
// 				AJAX functionality starts here
// *******************************************************************************************

// Handle special situations (errors, and finish)

if ($error) 
{
  $out1 = ob_get_contents();
  ob_end_clean();
  echo $out1;
  die;
}

// Creates responses  (XML only or web page)

if (($ajax) && isset($_REQUEST['start']))
{
  if (isset($_REQUEST['ajaxrequest'])) 
  {	ob_end_clean();
		create_xml_response();
		die;
	} 
	else 
	{
	  create_ajax_script();	  
	}  
}

ob_flush();

// *******************************************************************************************
// 				AJAX utilities
// *******************************************************************************************

function create_xml_response() 
{
  global $linenumber, $foffset, $totalqueries, $curfilename,
				 $lines_this, $lines_done, $lines_togo, $lines_tota,
				 $queries_this, $queries_done, $queries_togo, $queries_tota,
				 $bytes_this, $bytes_done, $bytes_togo, $bytes_tota,
				 $kbytes_this, $kbytes_done, $kbytes_togo, $kbytes_tota,
				 $mbytes_this, $mbytes_done, $mbytes_togo, $mbytes_tota,
				 $pct_this, $pct_done, $pct_togo, $pct_tota,$pct_bar;

	//echo "Content-type: application/xml; charset='iso-8859-1'";
	header('Content-Type: application/xml');
	header('Cache-Control: no-cache');
	/*	
	echo '<?xml version="1.0"?>'."\n";
	echo '<root>'."\n";
	echo 'cos'."\n";
	echo '</root>'."\n";
	*/
	
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';
	echo "<root>";
	// data - for calculations
	echo "<linenumber>";
	echo "$linenumber";
	echo "</linenumber>";
	echo "<foffset>";
	echo "$foffset";
	echo "</foffset>";
	echo "<fn>";
	echo '"'.$curfilename.'"';
	echo "</fn>";
	echo "<totalqueries>";
	echo "$totalqueries";
	echo "</totalqueries>";
	// results - for form update
	echo "<elem1>";
	echo "$lines_this";
	echo "</elem1>";
	echo "<elem2>";
	echo "$lines_done";
	echo "</elem2>";
	echo "<elem3>";
	echo "$lines_togo";
	echo "</elem3>";
	echo "<elem4>";
	echo "$lines_tota";
	echo "</elem4>";
	
	echo "<elem5>";
	echo "$queries_this";
	echo "</elem5>";
	echo "<elem6>";
	echo "$queries_done";
	echo "</elem6>";
	echo "<elem7>";
	echo "$queries_togo";
	echo "</elem7>";
	echo "<elem8>";
	echo "$queries_tota";
	echo "</elem8>";
	
	echo "<elem9>";
	echo "$bytes_this";
	echo "</elem9>";
	echo "<elem10>";
	echo "$bytes_done";
	echo "</elem10>";
	echo "<elem11>";
	echo "$bytes_togo";
	echo "</elem11>";
	echo "<elem12>";
	echo "$bytes_tota";
	echo "</elem12>";
			
	echo "<elem13>";
	echo "$kbytes_this";
	echo "</elem13>";
	echo "<elem14>";
	echo "$kbytes_done";
	echo "</elem14>";
	echo "<elem15>";
	echo "$kbytes_togo";
	echo "</elem15>";
	echo "<elem16>";
	echo "$kbytes_tota";
	echo "</elem16>";
	
	echo "<elem17>";
	echo "$mbytes_this";
	echo "</elem17>";
	echo "<elem18>";
	echo "$mbytes_done";
	echo "</elem18>";
	echo "<elem19>";
	echo "$mbytes_togo";
	echo "</elem19>";
	echo "<elem20>";
	echo "$mbytes_tota";
	echo "</elem20>";
	
	echo "<elem21>";
	echo "$pct_this";
	echo "</elem21>";
	echo "<elem22>";
	echo "$pct_done";
	echo "</elem22>";
	echo "<elem23>";
	echo "$pct_togo";
	echo "</elem23>";
	echo "<elem24>";
	echo "$pct_tota";
	echo "</elem24>";
	
	// converting html to normal text
	$pct_bar    = htmlentities($pct_bar);	  
	echo "<elem_bar>";
	echo "$pct_bar";
	echo "</elem_bar>";
				
	echo "</root>";		
	
}

function create_ajax_script() 
{
  global $linenumber, $foffset, $totalqueries, $delaypersession, $curfilename;
	?>
	<script type="text/javascript" language="javascript">			

	// creates next action url (upload page, or XML response)
	function get_url(linenumber,fn,foffset,totalqueries) {
		return "<?php echo $_SERVER['PHP_SELF'] ?>?start="+linenumber+"&fn="+fn+"&foffset="+foffset+"&totalqueries="+totalqueries+"&ajaxrequest=true";
	}
	
	// extracts text from XML element (itemname must be unique)
	function get_xml_data(itemname,xmld) {
		return xmld.getElementsByTagName(itemname).item(0).firstChild.data;
	}
	
	// action url (upload page)
	var url_request =  get_url(<?php echo $linenumber.',"'.urlencode($curfilename).'",'.$foffset.','.$totalqueries;?>);
	var http_request = false;
	
	function makeRequest(url) {
		http_request = false;
		if (window.XMLHttpRequest) { 
		// Mozilla,...
			http_request = new XMLHttpRequest();
			if (http_request.overrideMimeType) {
				http_request.overrideMimeType("text/xml");
			}
		} else if (window.ActiveXObject) { 
		// IE
			try {
				http_request = new ActiveXObject("Msxml2.XMLHTTP");
			} catch(e) {
				try {
					http_request = new ActiveXObject("Microsoft.XMLHTTP");
				} catch(e) {}
			}
		}
		if (!http_request) {
				alert("Cannot create an XMLHTTP instance");
				return false;
		}
		http_request.onreadystatechange = server_response;
		http_request.open("GET", url, true);
		http_request.send(null);
	}
	
	function server_response() 
	{

	  // waiting for correct response
	  if (http_request.readyState != 4)
			return;
	  if (http_request.status != 200) {
	    alert("Page unavailable, or wrong url!")
			return;
		}
		
		// r = xml response
		var r = http_request.responseXML;
		
		//if received not XML but HTML with new page to show
		if (r.getElementsByTagName('root').length == 0) {                   	//*
			var text = http_request.responseText;
			document.open();
			document.write(text);		
			document.close();	
			return;		
		}
		
		// update "Starting from line: "
		document.getElementsByTagName('p').item(1).innerHTML = 
			"Starting from line: " + 
			   r.getElementsByTagName('linenumber').item(0).firstChild.nodeValue;
		
		// update table with new values
		for(i = 1; i <= 24; i++) {						
			document.getElementsByTagName('td').item(i).firstChild.data = 
				get_xml_data('elem'+i,r);
		}				
		
		// update color bar
		document.getElementsByTagName('td').item(25).innerHTML = 
			r.getElementsByTagName('elem_bar').item(0).firstChild.nodeValue;
			 
		// action url (XML response)	 
		url_request =  get_url(
			get_xml_data('linenumber',r),
			get_xml_data('fn',r),
			get_xml_data('foffset',r),
			get_xml_data('totalqueries',r));
		
		// ask for XML response	
		window.setTimeout("makeRequest(url_request)",500+<?php echo $delaypersession; ?>);
	}
	// ask for upload page
	window.setTimeout("makeRequest(url_request)",500+<?php echo $delaypersession; ?>);
	</script>
	<?php
}
?>
