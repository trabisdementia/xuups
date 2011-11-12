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

class Xmf_Object_Form_Element_Tray_Password extends Xmf_Form_Element_Tray
{

    /**
     * Size of the field.
     * @var	int
     * @access	private
     */
    var $_size;

    /**
     * Maximum length of the text
     * @var	int
     * @access	private
     */
    var $_maxlength;

    /**
     * Initial content of the field.
     * @var	string
     * @access	private
     */
    var $_value;

    /**
     * Constructor
     *
     * @param	string	$caption	Caption
     * @param	string	$name		"name" attribute
     * @param	int		$size		Size of the field
     * @param	int		$maxlength	Maximum length of the text
     * @param	int		$value		Initial value of the field.
     * 								<b>Warning:</b> this is readable in cleartext in the page's source!
     */

    /**
     * Constructor
     * @param	object    $object   reference to targetobject (@link IcmsPersistableObject)
     * @param	string    $key      the form name
     */
    function __construct($object, $key)
    {

        $var = $object->vars[$key];
        $control = $object->controls[$key];

        parent::__construct($var['title'] . '<br />' . _US_TYPEPASSTWICE, ' ', $key . '_password_tray');

        $password_box1 = new Xmf_Form_Element_Password('', $key . '1', 10, 32);
        $this->addElement($password_box1);

        $password_box2 = new Xmf_Form_Element_Password('', $key . '2', 10, 32);
        $this->addElement($password_box2);
    }
}