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

class Xmf_Criteria_Element extends Xmf_Abstract
{
    /**
     * Sort order
     * @var	string
     */
    var $order = 'ASC';

    /**
     * @var	string
     */
    var $sort = '';

    /**
     * Number of records to retrieve
     * @var	int
     */
    var $limit = 0;

    /**
     * Offset of first record
     * @var	int
     */
    var $start = 0;

    /**
     * @var	string
     */
    var $groupby = '';

    /**
     * Constructor
     **/
    function __construct()
    {

    }

    /**
     * Render the criteria element
     */
    function render()
    {

    }

    /**#@+
    * Accessor
    */
    /**
     * @param	string  $sort
     */
    function setSort($sort)
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @return	string
     */
    function getSort()
    {
        return $this->sort;
    }

    /**
     * @param	string  $order
     */
    function setOrder($order)
    {
        if ('DESC' == strtoupper($order)) {
            $this->order = 'DESC';
        }
        return $this;
    }

    /**
     * @return	string
     */
    function getOrder()
    {
        return $this->order;
    }

    /**
     * @param	int $limit
     */
    function setLimit($limit = 0)
    {
        $this->limit = intval($limit);
        return $this;
    }

    /**
     * @return	int
     */
    function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param	int $start
     */
    function setStart($start = 0)
    {
        $this->start = intval($start);
        return $this;
    }

    /**
     * @return	int
     */
    function getStart()
    {
        return $this->start;
    }

    /**
     * @param	string  $group
     */
    function setGroupby($group)
    {
        $this->groupby = $group;
        return $this;
    }

    /**
     * @return	string
     */
    function getGroupby()
    {
        return $this->groupby ? " GROUP BY {$this->groupby}" : "";
    }
    /**#@-*/
}