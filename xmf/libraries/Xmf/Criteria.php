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
 * @author          Kazumi Ono <onokazu@xoops.org>
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

/**
 * A single criteria
 *
 * @package     kernel
 * @subpackage  database
 *
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
class Xmf_Criteria extends Xmf_Criteria_Element
{

    /**
     * @var	string
     */
    var $prefix;
    var $function;
    var $column;
    var $operator;
    var $value;

    /**
     * Constructor
     *
     * @param   string  $column
     * @param   string  $value
     * @param   string  $operator
     **/
    function __construct($column='', $value = '', $operator = '=', $prefix = '', $function = '')
    {
        parent::__construct();
        $this->prefix = $prefix;
        $this->function = $function;
        $this->column = $column;
        $this->value = $value;
        $this->operator = $operator;
    }

    /**
     * Make a sql condition string
     *
     * @return  string
     **/
    function render()
    {
        $clause = (!empty($this->prefix) ? "{$this->prefix}." : "") . $this->column;
        if (!empty($this->function)) {
            $clause = sprintf($this->function, $clause);
        }
        if (in_array(strtoupper($this->operator), array('IS NULL', 'IS NOT NULL'))) {
            $clause .= ' ' . $this->operator;
        } else {
            if ('' === ($value = trim($this->value))) {
                return '';
            }
            if (!in_array(strtoupper($this->operator), array('IN', 'NOT IN'))) {
                if ((substr($value, 0, 1 ) != '`') && (substr($value, -1) != '`')) {
                    $value = "'{$value}'";
                } else if (!preg_match('/^[a-zA-Z0-9_\.\-`]*$/', $value)) {
                    $value = '``';
                }
            }
            $clause .= " {$this->operator} {$value}";
        }
        return $clause;
    }

    /**
     * Generate an LDAP filter from criteria
     *
     * @return string
     * @author Nathan Dial ndial@trillion21.com, improved by Pierre-Eric MENUET pemen@sourceforge.net
     */
    function renderLdap()
    {
        if ($this->operator == '>') {
            $this->operator = '>=';
        }
        if ($this->operator == '<') {
            $this->operator = '<=';
        }

        if ($this->operator == '!=' || $this->operator == '<>') {
            $operator = '=';
            $clause = "(!(" . $this->column . $operator . $this->value . "))";
        } else {
            if ($this->operator == 'IN') {
                $newvalue = str_replace(array('(', ')') , '', $this->value);
                $tab = explode(',', $newvalue);
                foreach ($tab as $uid) {
                    $clause .= "({$this->column}={$uid})";
                }
                $clause = '(|' . $clause . ')';
            } else {
                $clause = "(" . $this->column . $this->operator . $this->value . ")";
            }
        }
        return $clause;
    }

    /**
     * Make a SQL "WHERE" clause
     *
     * @return	string
     */
    function renderWhere()
    {
        $cond = $this->render();
        return empty($cond) ? '' : "WHERE {$cond}";
    }
}