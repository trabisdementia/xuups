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

/**
 *
 * @author      Kazumi Ono  <onokazu@xoops.org>
 * @copyright   copyright (c) 2000-2005 XOOPS.org
 */
/**
 * A hidden token field
 *
 *
 * @author      Kazumi Ono  <onokazu@xoops.org>
 * @copyright   copyright (c) 2000-2005 XOOPS.org
 */
class Xmf_Form_Element_Hidden_Token extends Xmf_Form_Element_Hidden
{
    /**
     * Constructor
     *
     * @param   string  $name   "name" attribute
     */
    function __construct($name = 'XOOPS_TOKEN', $timeout = 0){
        parent::__construct($name . '_REQUEST', $GLOBALS['xoopsSecurity']->createToken($timeout, $name));
    }
}
