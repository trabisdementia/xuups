<?PHP
### =============================================================
### Mastop InfoDigital - Paix�o por Internet
### =============================================================
### Classe para Colocar as imagens da biblioteca em um Select
### =============================================================
### Developer: Fernando Santos (topet05), fernando@mastop.com.br
### Copyright: Mastop InfoDigital � 2003-2007
### -------------------------------------------------------------
### www.mastop.com.br
### =============================================================
### $Id$
### =============================================================
if (!defined('XOOPS_ROOT_PATH')) {
	die("Oooops!!");
}
include_once XOOPS_ROOT_PATH."/class/xoopsform/formselect.php";
class MastopFormSelectImage extends XoopsFormSelect
{
	/**
     * OptGroup
	 * @var array
	 * @access	private
	 */
	var $_optgroups = array();
	var $_optgroupsID = array();
	/**
	 * Construtor
	 *
	 * @param	string	$caption
	 * @param	string	$name
	 * @param	mixed	$value	Valor pr�-selecionado (ou array de valores).
	 * @param	int		$size	N�mero de Linhas. "1" d� um Select List normal de 1 op��o.
	 * @param	string	$cat	Nome da Categoria da biblioteca. Se vazio ou n�o definido, retorna todas as bibliotecas que o cara pode acessar.
	 */
	function MastopFormSelectImage($caption, $name, $value=null, $cat = null)
	{
		$this->XoopsFormSelect($caption, $name, $value);
		$this->addOptGroupArray($this->getImageList($cat));
	}

	/**
	 * Adiciona um Optgroup
     *
	 * @param	string  $value  op��es do Grupo
     * @param	string  $name   Nome do Grupo de Op��es
	 */
	function addOptGroup($value=array(), $name="&nbsp;"){
		$this->_optgroups[$name] = $value;
	}

	/**
	 * Adiciona m�ltiplos Optgroups
	 *
     * @param	array   $options    Array com nome->op��es
	 */
	function addOptGroupArray($options){
		if ( is_array($options) ) {
			foreach ( $options as $k=>$v ) {
				$this->addOptGroup($v,$k);
			}
		}
	}

	function getImageList($cat = null)
	{
		global $xoopsUser;
		$ret = array();
		if (!is_object($xoopsUser)) {
			$group = array(XOOPS_GROUP_ANONYMOUS);
		} else {
			$group =& $xoopsUser->getGroups();
		}
		$imgcat_handler =& xoops_gethandler('imagecategory');
		$catlist =& $imgcat_handler->getList($group, 'imgcat_read', 1);
		if (is_array($cat) && count($catlist) > 0) {
			foreach ($catlist as $k=>$v) {
				if (!in_array($k, $cat)) {
					unset($catlist[$k]);
				}
			}
		}elseif (is_int($cat)){
			$catlist = array_key_exists($cat, $catlist) ? array($cat=>$catlist[$cat]) : array();
		}
			$image_handler = xoops_gethandler('image');
			foreach ($catlist as $k=>$v) {
				$this->_optgroupsID[$v] = $k;
				$criteria = new CriteriaCompo(new Criteria('imgcat_id', $k));
				$criteria->add(new Criteria('image_display', 1));
				$total = $image_handler->getCount($criteria);
				if ($total > 0) {
					$imgcat =& $imgcat_handler->get($k);
					$storetype = $imgcat->getVar('imgcat_storetype');
					if ($storetype == 'db') {
						$images =& $image_handler->getObjects($criteria, false, true);
					} else {
						$images =& $image_handler->getObjects($criteria, false, false);
					}
					foreach ($images as $i) {
						if($storetype == "db"){
							$ret[$v]["/image.php?id=".$i->getVar('image_id')] = $i->getVar('image_nicename');
						}else{
							$ret[$v]["/uploads/".$i->getVar('image_name')] =  $i->getVar('image_nicename');
						}
					}
				}else{
					$ret[$v] = "";
				}
			}
		return $ret;
	}

	/**
	 * Pega todos os Optgroups
	 *
     * @return	array   Array com nome->op��es
	 */
	function getOptGroups(){
		return $this->_optgroups;
	}

	/**
	 * Pega todos os IDs dos Optgroups
	 *
     * @return	array   Array com nome->ids
	 */
	function getOptGroupsID(){
		return $this->_optgroupsID;
	}

	function render(){
		global $xoopsUser;
		if (!is_object($xoopsUser)) {
			$group = array(XOOPS_GROUP_ANONYMOUS);
		} else {
			$group =& $xoopsUser->getGroups();
		}
		$imgcat_handler =& xoops_gethandler('imagecategory');
		$catlist =& $imgcat_handler->getList($group, 'imgcat_write', 1);
		$catlist_total = count($catlist);
		$optIds = $this->getOptGroupsID();
		$ret = "<select onchange='if(this.options[this.selectedIndex].value != \"\"){ document.getElementById(\"".$this->getName()."_img\").src=\"".XOOPS_URL."\"+this.options[this.selectedIndex].value;}else{document.getElementById(\"".$this->getName()."_img\").src=\"".XOOPS_URL."/modules/".MGO_MOD_DIR."/images/spager.gif\";}'  size='".$this->getSize()."'".$this->getExtra()."";
		if ($this->isMultiple() != false) {
			$ret .= " name='".$this->getName()."[]' id='".$this->getName()."[]' multiple='multiple'>\n";
		} else {
			$ret .= " name='".$this->getName()."' id='".$this->getName()."'>\n";
		}
		$ret .= "<option value=''>"._SELECT."</option>\n";
		foreach ( $this->getOptGroups() as $nome => $valores ){
			$ret .= '\n<optgroup id="img_cat_'.$optIds[$nome].'" label="'.$nome.'">';
			if (is_array($valores)) {
				foreach ( $valores as $value => $name ) {
					$ret .= "<option value='".htmlspecialchars($value, ENT_QUOTES)."'";
					if (count($this->getValue()) > 0 && in_array($value, $this->getValue())) {
						$ret .= " selected='selected'";
						$imagem = $value;
					}
					$ret .= ">".$name."</option>\n";
				}
			}
			$ret .= '</optgroup>\n';
		}
		$browse_url = dirname(__FILE__)."/formimage_browse.php";
		$browse_url = str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $browse_url);
		$ret .= "</select>";
		$ret .= ($catlist_total > 0) ? " <input type='button' value='"._ADDIMAGE."' onclick=\"window.open('$browse_url?target=".$this->getName()."','MastopFormImage','resizable=yes,width=500,height=470,left='+(screen.availWidth/2-200)+',top='+(screen.availHeight/2-200)+'');return false;\">" : "";
		$ret .= "<br /><img id='".$this->getName()."_img' src='".((!empty($imagem)) ? XOOPS_URL.$imagem : XOOPS_URL."/modules/".MGO_MOD_DIR."/images/spacer.gif")."'>";
		return $ret;
	}
}
?>