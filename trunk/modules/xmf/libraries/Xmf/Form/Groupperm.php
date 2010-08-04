<?php
defined('XMF_EXEC') or die('Xmf was not detected');
Xmf_Language::load('form', 'xmf');

/**
 * Renders a form for setting module specific group permissions
 *
 * @author Kazumi Ono <onokazu@myweb.ne.jp>
 * @copyright copyright (c) 2000-2003 XOOPS.org
 * @package kernel
 * @subpackage form
 */
class Xmf_Form_Groupperm extends Xmf_Form
{
    /**
     * Module ID
     *
     * @var int
     */
    var $_modid;
    /**
     * Tree structure of items
     *
     * @var array
     */
    var $_itemTree;
    /**
     * Name of permission
     *
     * @var string
     */
    var $_permName;
    /**
     * Description of permission
     *
     * @var string
     */
    var $_permDesc;

    /**
     * Whether to include anonymous users
     *
     * @var bool
     */
    var $_showAnonymous;

    /**
     * Constructor
     */
    function __construct($title, $modid, $permname, $permdesc, $url = "", $anonymous = true)
    {
        parent::__construct($title, 'groupperm_form', XOOPS_URL . '/modules/system/admin/groupperm.php', 'post');
        $this->_modid = intval($modid);
        $this->_permName = $permname;
        $this->_permDesc = $permdesc;
        $this->addElement(new Xmf_Form_Element_Hidden('modid', $this->_modid));
        if ($url != "") {
            $this->addElement(new Xmf_Form_Element_Hidden('redirect_url', $url));
        }
        $this->_showAnonymous = $anonymous;
    }

    /**
     * Adds an item to which permission will be assigned
     *
     * @param string $itemName
     * @param int $itemId
     * @param int $itemParent
     * @access public
     */
    function addItem($itemId, $itemName, $itemParent = 0)
    {
        $this->_itemTree[$itemParent]['children'][] = $itemId;
        $this->_itemTree[$itemId]['parent'] = $itemParent;
        $this->_itemTree[$itemId]['name'] = $itemName;
        $this->_itemTree[$itemId]['id'] = $itemId;
    }

    /**
     * Loads all child ids for an item to be used in javascript
     *
     * @param int $itemId
     * @param array $childIds
     * @access private
     */
    function _loadAllChildItemIds($itemId, &$childIds)
    {
        if (!empty($this->_itemTree[$itemId]['children'])) {
            $first_child = $this->_itemTree[$itemId]['children'];
            foreach ($first_child as $fcid) {
                array_push($childIds, $fcid);
                if (!empty($this->_itemTree[$fcid]['children'])) {
                    foreach ($this->_itemTree[$fcid]['children'] as $_fcid) {
                        array_push($childIds, $_fcid);
                        $this->_loadAllChildItemIds($_fcid, $childIds);
                    }
                }
            }
        }
    }

    /**
     * Renders the form
     *
     * @return string
     * @access public
     */
    function render()
    {
        // load all child ids for javascript codes
        foreach (array_keys($this->_itemTree)as $item_id) {
            $this->_itemTree[$item_id]['allchild'] = array();
            $this->_loadAllChildItemIds($item_id, $this->_itemTree[$item_id]['allchild']);
        }
        $gperm_handler =& xoops_gethandler('groupperm');
        $member_handler =& xoops_gethandler('member');
        $glist = $member_handler->getGroupList();
        foreach (array_keys($glist) as $i) {
            if ($i == XOOPS_GROUP_ANONYMOUS && !$this->_showAnonymous) continue;
            // get selected item id(s) for each group
            $selected = $gperm_handler->getItemIds($this->_permName, $i, $this->_modid);
            $ele = new Xmf_Form_Element_Checkbox_Group($glist[$i], 'perms[' . $this->_permName . ']', $i, $selected);
            $ele->setOptionTree($this->_itemTree);
            $this->addElement($ele);
            unset($ele);
        }
        $tray = new Xmf_Form_Element_Tray('');
        $tray->addElement(new Xmf_Form_Element_Button('', 'submit', _SUBMIT, 'submit'));
        $tray->addElement(new Xmf_Form_Element_Button('', 'reset', _CANCEL, 'reset'));
        $this->addElement($tray);
        $ret = '<h4>' . $this->getTitle() . '</h4>';
        if ($this->_permDesc) {
            $ret .= $this->_permDesc . '<br /><br />';
        }
        $ret .= "<form name='" . $this->getName() . "' id='" . $this->getName() . "' action='" . $this->getAction() . "' method='" . $this->getMethod() . "'" . $this->getExtra() . ">\n<table width='100%' class='outer' cellspacing='1' valign='top'>\n";
        $elements = $this->getElements();
        $hidden = '';
        foreach (array_keys($elements) as $i) {
            if (!is_object($elements[$i])) {
                $ret .= $elements[$i];
            } elseif (!$elements[$i]->isHidden()) {
                $ret .= "<tr valign='top' align='left'><td class='head'>" . $elements[$i]->getCaption();
                if ($elements[$i]->getDescription() != '') {
                    $ret .= '<br /><br /><span style="font-weight: normal;">' . $elements[$i]->getDescription() . '</span>';
                }
                $ret .= "</td>\n<td class='even'>\n" . $elements[$i]->render() . "\n</td></tr>\n";
            } else {
                $hidden .= $elements[$i]->render();
            }
        }
        $ret .= "</table>$hidden</form>";
        $ret .= $this->renderValidationJS( true );
        return $ret;
    }
}