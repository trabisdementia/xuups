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
 *  Publisher class
 *
 * @copyright       The XUUPS Project http://sourceforge.net/projects/xuups/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         Publisher
 * @since           1.0
 * @author          trabis <lusopoemas@gmail.com>
 * @version         $Id: blockform.php 0 2009-06-11 18:47:04Z trabis $
 */

defined('XOOPS_ROOT_PATH') or die('Restricted access');

xoops_load('XoopsForm');

/**
 * Form that will output formatted as a HTML table
 *
 * No styles and no JavaScript to check for required fields.
 */
class PublisherBlockForm extends XoopsForm
{
    function __construct()
    {
        parent::__construct('', '', '');
    }

    /**
     * create HTML to output the form as a table
     *
     * YOU SHOULD AVOID TO USE THE FOLLOWING Nocolspan METHOD, IT WILL BE REMOVED
     *
     * To use the noColspan simply use the following example:
     *
     * $colspan = new XoopsFormDhtmlTextArea( '', 'key', $value, '100%', '100%' );
     * $colspan->setNocolspan();
     * $form->addElement( $colspan );
     *
     * @return string
     */
    function render()
    {
        $ret = '<table border="0" width="100%">' . NWLINE;
        foreach ($this->getElements() as $ele) {
            if (!$ele->isHidden()) {
                if (!$ele->getNocolspan()) {
                    $ret .= '<tr valign="top" align="left"><td>';
                    $ret .= '<span style="font-weight: bold;">' . $ele->getCaption() . '</span>';
                    if ($ele_desc = $ele->getDescription()) {
                        $ret .= '<br /><br /><span style="font-weight: normal;">' . $ele_desc . '</span>';
                    }
                    $ret .= '</td><td>' . $ele->render() . '</td></tr>';
                } else {
                    $ret .= '<tr valign="top" align="left"><td colspan="2">';
                    $ret .= '<span style="font-weight: bold;">' . $ele->getCaption() . '</span>';
                    $ret .= '</td></tr><tr valign="top" align="left"><td>' . $ele->render() . '</td></tr>';
                }
            }
        }
        $ret .= '</table>';
        return $ret;
    }
}

?>