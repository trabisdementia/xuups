<?php
defined('XMF_EXEC') or die('Xmf was not detected');
Xmf_Language::load('form', 'xmf');

/**
 * Form control creating an autocomplete select box powered by Scriptaculous
 *
 * @copyright	The ImpressCMS Project http://www.impresscms.org/
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License (GPL)
 * @package		IcmsPersistableObject
 * @since		  1.1
 * @author		  marcan <marcan@impresscms.org>
 * @version		$Id: icmsautocompleteelement.php 8559 2009-04-11 11:34:22Z icmsunderdog $
 */


class Xmf_Form_Element_Text_Autocomplete extends Xmf_Form_Element_Text
{
    var $_include_file;

    /**
     * Constructor
     * @param	object    $object   reference to targetobject (@link IcmsPersistableObject)
     * @param	string    $key      the form name
     */
    function __construct($caption, $name, $include_file, $size, $maxlength, $value="")
    {
        $this->_include_file = $include_file;
        parent::__construct($caption, $name, $size, $maxlength, $value);
    }



    /**
     * Prepare HTML for output
     *
     * @return	string  $ret  the constructed HTML
     */
    function render()
    {
        $ret = "<input type='text' name='".$this->getName()."' id='".$this->getName()."' size='".$this->getSize()."' maxlength='".$this->getMaxlength()."' value='".$this->getValue()."'".$this->getExtra()." />";

        $ret .= '	<div class="xmf_autocomplete_hint" id="xmf_autocomplete_hint' . $this->getName() . '"></div>

          <script type="text/javascript">
          new Ajax.Autocompleter("' .$this->getName(). '","xmf_autocomplete_hint' .$this->getName(). '","' . $this->_include_file . '?key=' . $this->getName() . '");
          </script>';

        return $ret;
    }
}