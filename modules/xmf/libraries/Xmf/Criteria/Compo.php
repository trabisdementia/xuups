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
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: somefile.php 0 2010-05-03 18:47:04Z trabis $
 */

defined('XMF_EXEC') or die('Xmf was not detected');

/**
 * Collection of multiple {@link CriteriaElement}s
 *
 * @package     kernel
 * @subpackage  database
 *
 * @author	    Kazumi Ono	<onokazu@xoops.org>
 * @copyright	copyright (c) 2000-2003 XOOPS.org
 */
class Xmf_Criteria_Compo extends Xmf_Criteria_Element
{

    /**
     * The elements of the collection
     * @var	array   Array of {@link CriteriaElement} objects
     */
    var $criteriaElements = array();

    /**
     * Conditions
     * @var	array
     */
    var $conditions = array();

    /**
     * Constructor
     *
     * @param   object  $ele
     * @param   string  $condition
     **/
    function __construct($ele = null, $condition = 'AND')
    {
        parent::__construct();
        if (isset($ele)) {
            $this->add($ele, $condition);
        }
    }

    /**
     * Add an element
     *
     * @param   object  &$criteriaElement
     * @param   string  $condition
     *
     * @return  object  reference to this collection
     **/
    function &add(&$criteriaElement, $condition = 'AND')
    {
        if (is_object($criteriaElement)) {
            $this->criteriaElements[] =& $criteriaElement;
            $this->conditions[] = $condition;
        }
        return $this;
    }

    /**
     * Make the criteria into a query string
     *
     * @return	string
     */
    function render()
    {
        $ret = '';
        $count = count($this->criteriaElements);
        if ($count > 0) {
            $render_string = $this->criteriaElements[0]->render();
            for ($i = 1; $i < $count; $i++) {
                if (!$render = $this->criteriaElements[$i]->render()) continue;
                $render_string .= ( empty($render_string) ? "" : ' ' . $this->conditions[$i] . ' ' ) . $render;
            }
            $ret = empty($render_string) ? '' : "({$render_string})";
        }
        return $ret;
    }

    /**
     * Make the criteria into a SQL "WHERE" clause
     *
     * @return	string
     */
    function renderWhere()
    {
        $ret = $this->render();
        $ret = ($ret != '') ? 'WHERE ' . $ret : $ret;
        return $ret;
    }

    /**
     * Generate an LDAP filter from criteria
     *
     * @return string
     * @author Nathan Dial ndial@trillion21.com
     */
    function renderLdap()
    {
        $retval = '';
        $count = count($this->criteriaElements);
        if ($count > 0) {
            $retval = $this->criteriaElements[0]->renderLdap();
            for ($i = 1; $i < $count; $i++) {
                $cond = strtoupper($this->conditions[$i]);
                $op = ($cond == "OR") ? "|" : "&";
                $retval = "({$op}{$retval}" . $this->criteriaElements[$i]->renderLdap() . ")";
            }
        }
        return $retval;
    }
}