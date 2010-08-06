<?php
/**
 * XOOPS editor
 *
 * @copyright       The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         class
 * @subpackage      editor
 * @since           2.3.0
 * @author          Taiwen Jiang <phppp@users.sourceforge.net>
 * @version         $Id: editor_registry.php 1573 2008-05-04 15:24:06Z phppp $
 */
return $config = array(
        "class"     =>    'Xmf_Form_Element_Editor_Koivi',
        "file"      =>    dirname(dirname(__FILE__)) . '/Koivi.php',
        "title"     =>    _XOOPS_EDITOR_KOIVI,
        "order"     =>    4
);
?>
