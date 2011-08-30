<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Xmf
 * @since           0.1
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

class Xmf_Export_Renderer
{
    var $data;
    var $format;
    var $filename;
    var $filepath;
    var $options;

    /**
     * Constructor
     *
     * @param array $data contains the data to be exported
     * @param string $format format of the ouputed export. Currently only supports CSV
     * @param string $filename name of the file in which the exported data will be saved
     * @param string $filepath path where the file will be saved
     * @param array $options options of the format to be exported in
     */
    function __construct($data, $filename = false, $filepath = false, $format = 'csv', $options = array('separator'=>';'))
    {
        $this->data = $data;
        $this->format = $format;
        $this->filename = $filename;
        $this->filepath = $filepath;
        $this->options = $options;
    }

    function arrayToCsvString($dataArray, $separator, $trim = 'both', $removeEmptyLines = TRUE)
    {
        if (!is_array($dataArray) || empty ($dataArray))
        return '';
        switch ($trim) {
            case 'none' :
                $trimFunction = FALSE;
                break;
            case 'left' :
                $trimFunction = 'ltrim';
                break;
            case 'right' :
                $trimFunction = 'rtrim';
                break;
            default : //'both':
                $trimFunction = 'trim';
                break;
        }
        $ret = array ();
        foreach ($dataArray as $key => $field) {
            $ret[$key] = $this->valToCsvHelper($field, $separator, $trimFunction);
        }

        return implode($separator, $ret);

    }

    function valToCsvHelper($val, $separator, $trimFunction)
    {
        if ($trimFunction)
        $val = $trimFunction ($val);
        //If there is a separator (;) or a quote (") or a linebreak in the string, we need to quote it.
        $needQuote = FALSE;
        do {
            if (strpos($val, '"') !== FALSE) {
                $val = str_replace('"', '""', $val);
                $needQuote = TRUE;
                break;
            }
            if (strpos($val, $separator) !== FALSE) {
                $needQuote = TRUE;
                break;
            }
            if ((strpos($val, "\n") !== FALSE) || (strpos($val, "\r") !== FALSE)) { // \r is for mac
                $needQuote = TRUE;
                break;
            }
        } while (FALSE);
        if ($needQuote) {
            $val = '"' . $val . '"';
        }
        return $val;
    }


    function execute()
    {
        $exportFileData = '';

        switch ($this->format) {
            case 'csv':
                $separator = isset($this->options['separator']) ? $this->options['separator'] : ';';
                $firstRow = implode($separator, $this->data['columnsHeaders']);
                $exportFileData .= $firstRow . "\r\n";

                foreach($this->data['rows'] as $cols) {
                    $exportFileData .= $this->arrayToCsvString($cols, $separator) . "\r\n";
                }
                break;
        }
        $this->saveExportFile($exportFileData);
    }

    function saveExportFile($content)
    {
        switch ($this->format) {
            case 'csv':
                $this->saveCsv($content);
                break;
        }
    }

    function saveCsv($content)
    {
        error_reporting(0);
        $GLOBALS['xoopsLogger']->activated = false;

        if (!$this->filepath) {
            $this->filepath = XOOPS_UPLOAD_PATH . '/';
        }
        if (!$this->filename) {
            $this->filename .= time();
            $this->filename .= '.csv';
        }

        $fullFileName = $this->filepath . $this->filename;

        if (!$handle = fopen($fullFileName, 'a+')) {
            trigger_error('Unable to open ' . $fullFileName, E_USER_WARNING);
        } else if (fwrite($handle, $content) === FALSE) {
            trigger_error('Unable to write in ' . $fullFileName, E_USER_WARNING);
        } else {
            $mimeType = 'text/csv';
            $file = strrev($this->filename);
            $temp_name = strtolower(strrev(substr($file,0,strpos($file,"--"))) );
            if ($temp_name == '') {
                $file_name = $this->filename;
            } else {
                $file_name = $temp_name;
            }
            $fullFileName = $this->filepath . stripslashes(trim($this->filename));

            if (ini_get('zlib.output_compression')) {
                ini_set('zlib.output_compression', 'Off');
            }

            header("Pragma: public");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);
            header("Content-Transfer-Encoding: binary");
            if (isset($mimeType)) {
                header("Content-Type: " . $mimeType);
            }

            header("Content-Disposition: attachment; filename=" . $file_name);

            if (isset($mimeType) && strstr($mimeType, "text/")) {
                $fp = fopen($fullFileName, "r");
            } else {
                $fp = fopen($fullFileName, "rb");
            }
            fpassthru($fp);
            exit();
        }
        fclose($handle);
    }
}