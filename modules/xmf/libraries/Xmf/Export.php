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
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Xmf
 * @since           0.1
 * @author          trabis <lusopoemas@gmail.com>
 * @author          The SmartFactory <www.smartfactory.ca>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

class Xmf_Export
{
    var $handler;
    var $criteria;
    var $fields;
    var $format;
    var $filename;
    var $filepath;
    var $options;
    var $outputMethods = false;
    var $notDisplayFields;

    /**
     * Constructor
     *
     * @param object $objectHandler SmartObjectHandler handling the data we want to export
     * @param object $criteria containing the criteria of the query fetching the objects to be exported
     * @param array $fields fields to be exported. If FALSE then all fields will be exported
     * @param string $filename name of the file to be created
     * @param string $filepath path where the file will be saved
     * @param string $format format of the ouputed export. Currently only supports CSV
     * @param array $options options of the format to be exported in
     */
    function __construct(&$objectHandler, $criteria = null, $fields = false, $filename = false, $filepath = false, $format = 'csv', $options = false)
    {
        $this->handler = $objectHandler;
        $this->criteria = $criteria;
        $this->fields = $fields;
        $this->filename = $filename;
        $this->format = $format;
        $this->options = $options;
        $this->notDisplayFields = false;
    }

    /**
     * Renders the export
     */
    function render($filename)
    {
        $this->filename = $filename;
        $objects = $this->handler->getObjects($this->criteria);
        $rows = array();
        $columnsHeaders = array();
        $firstObject = true;
        foreach ($objects as $object) {
            $row = array();
            foreach ($object->vars as $key => $var) {
                if ((!$this->fields || in_array($key, $this->fields)) && !in_array($key, $this->notDisplayFields)) {
                    if ($this->outputMethods && (isset($this->outputMethods[$key])) && (method_exists($object, $this->outputMethods[$key]))) {
                        $method = $this->outputMethods[$key];
                        $row[$key] = $object->$method();
                    } else {
                        $row[$key] = $object->getVar($key);
                    }
                    if ($firstObject) {
                        // then set the columnsHeaders array as well
                        $columnsHeaders[$key] = $key;//$var['title'];
                    }
                }
            }
            $firstObject = false;
            $rows[] = $row;
            unset($row);
        }
        $data = array();
        $data['rows'] = $rows;
        $data['columnsHeaders'] = $columnsHeaders;
        $exportRenderer = new Xmf_Export_Renderer($data, $this->filename, $this->filepath, $this->format, $this->options);
        $exportRenderer->execute();
    }

    /**
     * Set an array contaning the alternate methods to use instead of the default getVar()
     *
     * $outputMethods array example : 'uid' => 'getUserName'...
     */
    function setOuptutMethods($outputMethods)
    {
        $this->outputMethods = $outputMethods;
    }

    /*
     * Set an array of fields that we don't want in export
     */
     function setNotDisplayFields($fields)
     {
        if (!$this->notDisplayFields) {
            if (is_array($fields)) {
                $this->notDisplayFields = $fields;
            } else {
                $this->notDisplayFields = array($fields);
            }
        } else {
            if (is_array($fields)) {
                $this->notDisplayFields = array_merge($this->notDisplayFields, $fields);
            } else {
                $this->notDisplayFields[] = $fields;
            }
        }
     }
}