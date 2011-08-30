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
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

class Xmf_Object_Helper_Table extends Xmf_Object_Helper_Abstract
{
    var $_tblcolumns;
    var $_primary;
    var $tableName;

    function init()
    {
        $this->db = $GLOBALS["xoopsDB"];
        $this->_initVarsFromTable();
    }
    /**
     * Funcin para obtener todas las columnas de una tabla de la base de datos
     * la variable {@link $_dbtable} debe ser inicializada
     * Devuelve un array con los nombres y datos de las columnas
     * @return array
     */
    protected function _getColumns(){

        static $objectColumns;
        static $primaryCols;
        if (!empty($objectColumns[get_class($this)])){
            $this->_primary = $primaryCols[get_class($this->object)];
            $this->_tblcolumns = $objectColumns[get_class($this->object)];
            return $objectColumns[get_class($this->object)];
        } else {
            if (empty($this->_tblcolumns)){
                $result = $this->db->queryF("SHOW COLUMNS IN ".$this->tableName);
                while ($row = $this->db->fetchArray($result)){
                    if ($row['Extra'] == 'auto_increment'){
                        $this->_primary = $row['Field'];
                        $primaryCols[get_class($this)] = $row['Field'];
                    }
                    $this->_tblcolumns[] = $row;
                }
            }
            $objectColumns[get_class($this)] = $this->_tblcolumns;
            return $objectColumns[get_class($this)];
        }
    }
    /**
     * Funcin para inicializar las variables
     * a partir de las columnas de una tabla
     */
    protected function _initVarsFromTable(){

        foreach ($this->_getColumns() as $k => $v){
            $efes = array();
            preg_match("/(.+)(\(([,0-9]+)\))/", $v['Type'], $efes);
            if (!isset($efes[1])){
                $efes[1] = $v['Type'];
            }
            $required = false;
            $maxlength = null;

            switch ($efes[1]){
                case 'mediumint':
                case 'int':
                case 'tinyint':
                case 'smallint':
                case 'bigint':
                case 'timestamp':
                case 'year':
                case 'bool':
                    $type = 'int';
                    $maxlength = null;
                    break;
                case 'float':
                case 'double':
                    $type = 'int';//float
                    break;
                case 'decimal':
                    $type = 'textbox';
                    $lon = null;
                    break;
                case 'time':
                    $type = 'textbox';
                    $maxlength = 8;
                    break;
                case 'datetime':
                    $type = 'textbox';
                    $maxlength = 19;
                    break;
                case 'date':
                    $type = 'textbox';
                    $maxlength = 10;
                    break;
                case 'char':
                case 'tinyblob':
                case 'tinytext':
                case 'enum':
                case 'set':
                    $type = 'textbox';
                    $maxlength = isset($len[3]) ? $len[3] : null;
                    break;
                case 'text':
                case 'blob':
                case 'mediumblob':
                case 'mediumtext':
                case 'longblob':
                case 'longtext':
                    $type = 'textarea';
                    $maxlength= null;
                    break;
                default:
                    $type = 'other';
                    $maxlength = null;
                    break;
            }

            $this->object->initVar($v['Field'], $type, $v['Default'], $required, $maxlength);
        }
    }

}