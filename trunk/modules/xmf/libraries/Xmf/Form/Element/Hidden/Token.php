<?php

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
