<?php
//$Id: fields.php,v 1.9 2005/12/30 15:51:14 ackbarr Exp $
include('../../../include/cp_header.php');
include_once('admin_header.php');
include_once(XOOPS_ROOT_PATH . '/class/pagenav.php');
require_once(XOOPS_ROOT_PATH . '/class/xoopsformloader.php');
require_once(XHELP_CLASS_PATH . '/xhelpForm.php');
require_once(XHELP_CLASS_PATH . '/xhelpFormRegex.php');

define('_XHELP_FIELD_MINLEN', 2);
define('_XHELP_FIELD_MAXLEN', 16777215);

global $xoopsModule;
$module_id = $xoopsModule->getVar('mid');

$op = 'default';

if ( isset( $_REQUEST['op'] ) )
{
    $op = $_REQUEST['op'];
}

switch ( $op )
{
    case "delfield":
        deleteField();
        break;
    case "editfield":
        editField();
        break;
         
    case "clearAddSession":
        clearAddSession();
        break;

    case "clearEditSession":
        clearEditSession();
        break;

    case "setFieldRequired":
        setFieldRequired();
        break;
         
    case "manageFields":
    default:
        manageFields();
        break;

}

function manageFields()
{
    global $oAdminButton, $imagearray;

    $session     =& Session::singleton();
    $regex_array =& _getRegexArray();
    $hFields     =& xhelpGetHandler('ticketField');
     
    $start = $limit = 0;

    if (isset($_GET['limit'])) {
        $limit = intval($_GET['limit']);
    }

    if (isset($_GET['start'])) {
        $start = intval($_GET['start']);
    }

    if (!$limit) {
        $limit = 15;
    }

    if (!isset($_POST['addField'])) {
        $crit = new Criteria('','');
        $crit->setLimit($limit);
        $crit->setStart($start);
        $crit->setSort('weight');
        $crit->setOrder('ASC');

        $count = $hFields->getCount($crit);
        $fields =& $hFields->getObjects($crit);

        //Display List of Current Fields, form for new field
        xoops_cp_header();
        echo $oAdminButton->renderButtons('manfields');

        if ($count) {
            $nav = new XoopsPageNav($count, $limit, $start, 'start', "op=manageFields&amp;limit=$limit");

            echo "<table width='100%' cellspacing='1' class='outer'>
                <tr><th colspan='7'><label>"._AM_XHELP_TEXT_MANAGE_FIELDS."</label></th></tr>";
            echo "<tr class='head'>
                <td>"._AM_XHELP_TEXT_ID."</td>
                <td>"._AM_XHELP_TEXT_NAME."</td>
                <td>"._AM_XHELP_TEXT_DESCRIPTION."</td>
                <td>"._AM_XHELP_TEXT_FIELDNAME."</td>
                <td>"._AM_XHELP_TEXT_CONTROLTYPE."</td>
                <td>"._AM_XHELP_TEXT_REQUIRED."</td>
                <td>"._AM_XHELP_TEXT_ACTIONS."</td>
            </tr>";

            $req_link_params = array('op' => 'setFieldRequired',
                'setrequired' => 1,
                'id' => 0);

            foreach ($fields as $field) {
                $req_link_params['id'] = $field->getVar('id');

                if ($field->getVar('required')) {
                    $req_link_params['setrequired'] = 0;
                    $req_img = $imagearray['online'];
                    $req_title = _AM_XHELP_MESSAGE_DEACTIVATE;
                } else {
                    $req_link_params['setrequired'] = 1;
                    $req_img = $imagearray['offline'];
                    $req_title = _AM_XHELP_MESSAGE_ACTIVATE;
                }

                $edit_url = xhelpMakeURI(XHELP_ADMIN_URL.'/fields.php',
                array('op' => 'editfield', 'id' => $field->getVar('id')));
                $del_url  = xhelpMakeURI(XHELP_ADMIN_URL.'/fields.php',
                array('op' => 'delfield', 'id' => $field->getVar('id')));

                echo "<tr class='even'><td>".$field->getVar('id')."</td>
                    <td>".$field->getVar('name')."</td>
                    <td>".$field->getVar('description')."</td>
                    <td>".$field->getVar('fieldname')."</td>
                    <td>".xhelpGetControlLabel($field->getVar('controltype'))."</td>
                    <td><a href='".xhelpMakeURI(XHELP_ADMIN_URL.'/fields.php', $req_link_params)."' title='$req_title'>$req_img</a></td>
                    <td><a href='$edit_url'>{$imagearray['editimg']}</a>
                        <a href='$del_url'>{$imagearray['deleteimg']}</a></td>
                    </tr>";


            }
            echo '</table>';
            //Render Page Nav
            echo "<div id='pagenav'>". $nav->renderNav(). "</div><br />";
        }

        //Get Custom Field From session (if exists)
        $field_info = $session->get('xhelp_addField');
        $field_errors = $session->get('xhelp_addFieldErrors');

        $hDepts =& xhelpGetHandler('department');
        $depts =& $hDepts->getObjects();

        foreach($depts as $obj) {
            $deptarr[$obj->getVar('id')] = $obj->getVar('department');
        }

        if (! $field_info === false) {
            //extract($field_info , EXTR_PREFIX_ALL , 'fld_');
            $fld_controltype = $field_info['controltype'];
            $fld_datatype = $field_info['datatype'];
            $fld_departments = $field_info['departments'];
            $fld_name = $field_info['name'];
            $fld_fieldname = $field_info['fieldname'];
            $fld_description = $field_info['description'];
            $fld_required = $field_info['required'];
            $fld_length = $field_info['length'];
            $fld_weight = $field_info['weight'];
            $fld_defaultvalue = $field_info['defaultvalue'];
            $fld_values = $field_info['values'];
            $fld_validation = $field_info['validation'];
        } else {
            $fld_controltype = '';
            $fld_datatype = '';
            $fld_departments = array_keys($deptarr);
            $fld_name = '';
            $fld_fieldname = '';
            $fld_description = '';
            $fld_required = '';
            $fld_length = '';
            $fld_weight = '';
            $fld_defaultvalue = '';
            $fld_values = '';
            $fld_validation = '';
        }

        if (! $field_errors === false) {
            xhelpRenderErrors($field_errors, xhelpMakeURI(XHELP_ADMIN_URL.'/fields.php', array('op'=>'clearAddSession')));
        }

        //Add Field Form
        $controls = xhelpGetControlArray();
        $control_select =& new XoopsFormSelect(_AM_XHELP_TEXT_CONTROLTYPE, 'fld_controltype', $fld_controltype);
        foreach($controls as $key=>$control) {
            $control_select->addOption($key, $control['label']);
        }


        $datatypes = array(
        _XHELP_DATATYPE_TEXT => _XHELP_DATATYPE_TEXT,
        _XHELP_DATATYPE_NUMBER_INT => _XHELP_DATATYPE_NUMBER_INT,
        _XHELP_DATATYPE_NUMBER_DEC => _XHELP_DATATYPE_NUMBER_DEC);

        $datatype_select =& new XoopsFormSelect(_AM_XHELP_TEXT_DATATYPE, 'fld_datatype', $fld_datatype);
        $datatype_select->addOptionArray($datatypes);



        $dept_select =& new XoopsFormSelect(_AM_XHELP_TEXT_DEPARTMENTS, 'fld_departments', $fld_departments, 5, true);
        foreach($depts as $obj) {
            $dept_select->addOptionArray($deptarr);
        }
        unset($depts);


        $form = new xhelpForm(_AM_XHELP_ADD_FIELD, 'add_field', xhelpMakeURI(XHELP_ADMIN_URL.'/fields.php', array('op'=>'managefields')));
        $nameEle = new XoopsFormText(_AM_XHELP_TEXT_NAME, 'fld_name', 30, 64, $fld_name);
        $nameEle->setDescription(_AM_XHELP_TEXT_NAME_DESC);
        $form->addElement($nameEle);

        $fieldnameEle = new XoopsFormText(_AM_XHELP_TEXT_FIELDNAME, 'fld_fieldname', 30, 64, $fld_fieldname);
        $fieldnameEle->setDescription(_AM_XHELP_TEXT_FIELDNAME_DESC);
        $form->addElement($fieldnameEle);

        $descriptionEle = new XoopsFormTextArea(_AM_XHELP_TEXT_DESCRIPTION, 'fld_description', $fld_description, 5, 60);
        $descriptionEle->setDescription(_AM_XHELP_TEXT_DESCRIPTION_DESC);
        $form->addElement($descriptionEle);
         
        $dept_select->setDescription(_AM_XHELP_TEXT_DEPT_DESC);
        $control_select->setDescription(_AM_XHELP_TEXT_CONTROLTYPE_DESC);
        $datatype_select->setDescription(_AM_XHELP_TEXT_DATATYPE_DESC);
         
        $form->addElement($dept_select);
        $form->addElement($control_select);
        $form->addElement($datatype_select);

        $required = new XoopsFormRadioYN(_AM_XHELP_TEXT_REQUIRED, 'fld_required', $fld_required);
        $required->setDescription(_AM_XHELP_TEXT_REQUIRED_DESC);
        $form->addElement($required);

        $lengthEle = new XoopsFormText(_AM_XHELP_TEXT_LENGTH, 'fld_length', 5, 5, $fld_length);
        $lengthEle->setDescription(_AM_XHELP_TEXT_LENGTH_DESC);
        $weightEle = new XoopsFormText(_AM_XHELP_TEXT_WEIGHT, 'fld_weight', 5, 5, $fld_weight);
        $weightEle->setDescription(_AM_XHELP_TEXT_WEIGHT_DESC);

        $form->addElement($lengthEle);
        $form->addElement($weightEle);

        $regex_control =& new xhelpFormRegex(_AM_XHELP_TEXT_VALIDATION, 'fld_valid', $fld_validation);
        $regex_control->addOptionArray($regex_array);
        $regex_control->setDescription(_AM_XHELP_TEXT_VALIDATION_DESC);

        $form->addElement($regex_control);

        $defaultValueEle = new XoopsFormText(_AM_XHELP_TEXT_DEFAULTVALUE, 'fld_defaultvalue', 30, 100, $fld_defaultvalue);
        $defaultValueEle->setDescription(_AM_XHELP_TEXT_DEFAULTVALUE_DESC);
        $form->addElement($defaultValueEle);
        $values = new XoopsFormTextArea(_AM_XHELP_TEXT_FIELDVALUES, 'fld_values', $fld_values, 5, 60);
        $values->setDescription(_AM_XHELP_TEXT_FIELDVALUES_DESC);
        $form->addElement($values);


        $btn_tray = new XoopsFormElementTray('');
        $btn_tray->addElement(new XoopsFormButton('', 'addField', _AM_XHELP_BUTTON_SUBMIT, 'submit'));

        $form->addElement($btn_tray);
        echo $form->render();

        xhelpAdminFooter();
        xoops_cp_footer();
         
    } else {
        //Validate Field Information
        $has_errors = false;
        $hField =& xhelpGetHandler('ticketField');

        $values =& _parseValues($_POST['fld_values']);

        if (!$control = xhelpGetControl($_POST['fld_controltype'])) {
            $has_errors = true;
            $errors['fld_controltype'][] = _AM_XHELP_VALID_ERR_CONTROLTYPE;
        }

        $fld_needslength = $control['needs_length'];
        $fld_needsvalues = $control['needs_values'];


        //name field filled?
        if (trim($_POST['fld_name']) == '') {
            $has_errors = true;
            $errors['fld_name'][] = _AM_XHELP_VALID_ERR_NAME;
        }

        $fld_fieldname = sanitizeFieldName($_POST['fld_fieldname']);
         
        //fieldname filled
        if (trim($fld_fieldname) == '') {
            $has_errors = true;
            $errors['fld_fieldname'][] = _AM_XHELP_VALID_ERR_FIELDNAME;
        }


        //fieldname unique?
        $crit = new CriteriaCompo(new Criteria('fieldname', $fld_fieldname));
        if ($hField->getCount($crit)) {
            $has_errors = true;
            $errors['fld_fieldname'][] = _AM_XHELP_VALID_ERR_FIELDNAME_UNIQUE;
        }

        //Length filled
        if (intval($_POST['fld_length']) == 0 && $fld_needslength == true) {
            $has_errors = true;
            $errors['fld_length'][] = sprintf(_AM_XHELP_VALID_ERR_LENGTH, 2, 16777215);
        }

        //Departments Chosen?

        //default value in value set?
        if (count($values)) {
            if (!in_array($_POST['fld_defaultvalue'], $values, true) && !array_key_exists($_POST['fld_defaultvalue'], $values) ) {
                $has_errors = true;
                $errors['fld_defaultvalue'][] = _AM_XHELP_VALID_ERR_DEFAULTVALUE;
            }

            //length larger than longest value?
            $length = intval($_POST['fld_length']);
            foreach($values as $key=>$value) {
                if (strlen($key) > $length) {
                    $has_errors = true;
                    $errors['fld_values'][] = sprintf(_AM_XHELP_VALID_ERR_VALUE_LENGTH, htmlentities($key), $length);
                }
            }

            //Values are all of the correct datatype?
        } elseif ($fld_needsvalues) {
            $has_errors = true;
            $errors['fld_values'][] = _AM_XHELP_VALID_ERR_VALUE;
        }



        if ($has_errors) {
            $afield = array();

            $afield['name'] = $_POST['fld_name'];
            $afield['description'] = $_POST['fld_description'];
            $afield['fieldname'] = $fld_fieldname;
            $afield['departments'] = $_POST['fld_departments'];
            $afield['controltype'] = $_POST['fld_controltype'];
            $afield['datatype'] = $_POST['fld_datatype'];
            $afield['required'] = $_POST['fld_required'];
            $afield['weight'] = $_POST['fld_weight'];
            $afield['defaultvalue'] = $_POST['fld_defaultvalue'];
            $afield['values'] = $_POST['fld_values'];
            $afield['length'] = $_POST['fld_length'];
            $afield['validation'] = ($_POST['fld_valid_select'] == $_POST['fld_valid_txtbox'] ? $_POST['fld_valid_select'] : $_POST['fld_valid_txtbox']);
            $session->set('xhelp_addField', $afield);
            $session->set('xhelp_addFieldErrors', $errors);
            header('Location: '. xhelpMakeURI(XHELP_ADMIN_URL.'/fields.php'));
            exit();
        }

        //Save field
        $hField =& xhelpGetHandler('ticketField');
        $field =& $hField->create();
        $field->setVar('name', $_POST['fld_name']);
        $field->setVar('description', $_POST['fld_description']);
        $field->setVar('fieldname', $fld_fieldname);
        $field->setVar('controltype', $_POST['fld_controltype']);
        $field->setVar('datatype', $_POST['fld_datatype']);
        $field->setVar('fieldlength', $_POST['fld_length']);
        $field->setVar('required', $_POST['fld_required']);
        $field->setVar('weight', $_POST['fld_weight']);
        $field->setVar('defaultvalue', $_POST['fld_defaultvalue']);
        $field->setVar('validation', ($_POST['fld_valid_select'] == $_POST['fld_valid_txtbox'] ? $_POST['fld_valid_select'] : $_POST['fld_valid_txtbox']));
        $field->addValues($values);
        $field->addDepartments($_POST['fld_departments']);


         
        if ($hField->insert($field)) {
            _clearAddSessionVars();
            redirect_header(xhelpMakeURI(XHELP_ADMIN_URL.'/fields.php'), 3, _AM_XHELP_MSG_FIELD_ADD_OK);

        } else {
            $errors = $field->getHtmlErrors();
            redirect_header(xhelpMakeURI(XHELP_ADMIN_URL.'/fields.php'), 3, _AM_XHELP_MSG_FIELD_ADD_ERR . $errors);
        }
    }
}

function _formatValues($values_arr)
{
    $ret = '';
    foreach($values_arr as $key=>$value) {
        $ret .= "$key=$value\r\n";
    }
    return $ret;
}

function &_parseValues($raw_values)
{
    $_inValue = false;
    $values = array();

    if (strlen($raw_values) == 0) {
        return $values;
    }

    //Split values into name/value pairs
    $lines = explode("\r\n", $raw_values);

    //Parse each line into name=value
    foreach($lines as $line) {
        if (strlen(trim($line)) == 0) {
            continue(1);
        }
        $name = $value = '';
        $_inValue = false;
        $chrs = strlen($line);
        for ($i = 0; $i <= $chrs; $i++) {
            $chr = substr($line, $i, 1);
            if ($chr == '=' && $_inValue == false) {
                $_inValue=true;
            } else {
                if ($_inValue) {
                    $name .= $chr;
                } else {
                    $value .= $chr;
                }
            }
        }
        //Add value to array
        if ($value=='') {
            $values[$name]=$name;
        } else {
            $values[$value] = $name;
        }

        //Reset name / value vars
        $name = $value = '';
    }

    return $values;
}

function deleteField()
{
    global $_eventsrv, $oAdminButton;
    if (!isset( $_REQUEST['id'])) {
        redirect_header(xhelpMakeURI(XHELP_ADMIN_URL.'/fields.php', array('op'=> 'manageDepartments'), false), 3, _AM_XHELP_MESSAGE_NO_FIELD);
    }

    $id = intval($_REQUEST['id']);

    if (!isset($_POST['ok'])) {
        xoops_cp_header();
        echo $oAdminButton->renderButtons('manfields');
        xoops_confirm(array('op' => 'delfield', 'id' => $id, 'ok' => 1), XHELP_ADMIN_URL .'/fields.php', sprintf(_AM_XHELP_MSG_FIELD_DEL_CFRM, $id));
        xoops_cp_footer();
    } else {
        $hFields =& xhelpGetHandler('ticketField');
        $field =& $hFields->get($id);
        if($hFields->delete($field, true)){
            $_eventsrv->trigger('delete_field', array(&$field));
            header("Location: " . xhelpMakeURI(XHELP_ADMIN_URL.'/fields.php', array('op'=>'manageFields'), false));
            exit();

        } else {
            redirect_header(xhelpMakeURI(XHELP_ADMIN_URL.'/fields.php', array('op' => 'manageFields'), false), 3, $message);
        }
    }
}

function editField()
{
    global $oAdminButton;

    $eventsrv =& xhelpNewEventService();
    $session  =& Session::singleton();
    $regex_array =& _getRegexArray();

    if (!isset( $_REQUEST['id'])) {
        redirect_header(xhelpMakeURI(XHELP_ADMIN_URL.'/fields.php', array('op'=> 'manageDepartments'), false), 3, _AM_XHELP_MESSAGE_NO_FIELD);
    }

    $fld_id = intval($_REQUEST['id']);
    $hField =& xhelpGetHandler('ticketField');
    if (! $field =& $hField->get($fld_id)) {
        redirect_header(xhelpMakeURI(XHELP_ADMIN_URL.'/fields.php', array('op'=> 'manageDepartments'), false), 3, _AM_XHELP_MESSAGE_NO_FIELD);
    }
     
    if (!isset($_POST ['editField'])) {
        //Get Custom Field From session (if exists)
        $field_info = $session->get('xhelp_editField_'.$fld_id);
        $field_errors = $session->get('xhelp_editFieldErrors_'.$fld_id);

        if ( ! $field_info === false) {
            $fld_controltype = $field_info['controltype'];
            $fld_datatype = $field_info['datatype'];
            $fld_departments = $field_info['departments'];
            $fld_name = $field_info['name'];
            $fld_fieldname = $field_info['fieldname'];
            $fld_description = $field_info['description'];
            $fld_required = $field_info['required'];
            $fld_length = $field_info['length'];
            $fld_weight = $field_info['weight'];
            $fld_defaultvalue = $field_info['defaultvalue'];
            $fld_values = $field_info['values'];
            $fld_validation = $field_info['validation'];
        } else {
            $hFDept =& xhelpGetHandler('ticketFieldDepartment');
            $depts =& $hFDept->departmentsByField($field->getVar('id'), true);

            $fld_controltype = $field->getVar('controltype');
            $fld_datatype = $field->getVar('datatype');
            $fld_departments = array_keys($depts);
            $fld_name = $field->getVar('name');
            $fld_fieldname = $field->getVar('fieldname');
            $fld_description = $field->getVar('description');
            $fld_required = $field->getVar('required');
            $fld_length = $field->getVar('fieldlength');
            $fld_weight = $field->getVar('weight');
            $fld_defaultvalue = $field->getVar('defaultvalue');
            $fld_values = _formatValues($field->getVar('fieldvalues'));
            $fld_validation = $field->getVar('validation');
        }


        //Display Field modification
        xoops_cp_header();
        echo $oAdminButton->renderButtons('manfields');
        //Edit Field Form

        $controls = xhelpGetControlArray();
        $control_select =& new XoopsFormSelect(_AM_XHELP_TEXT_CONTROLTYPE, 'fld_controltype', $fld_controltype);
        $control_select->setDescription(_AM_XHELP_TEXT_CONTROLTYPE_DESC);
        foreach($controls as $key=>$control) {
            $control_select->addOption($key, $control['label']);
        }

        $datatypes = array(
        _XHELP_DATATYPE_TEXT => _XHELP_DATATYPE_TEXT,
        _XHELP_DATATYPE_NUMBER_INT => _XHELP_DATATYPE_NUMBER_INT,
        _XHELP_DATATYPE_NUMBER_DEC => _XHELP_DATATYPE_NUMBER_DEC);

        $datatype_select =& new XoopsFormSelect(_AM_XHELP_TEXT_DATATYPE, 'fld_datatype', $fld_datatype);
        $datatype_select->setDescription(_AM_XHELP_TEXT_DATATYPE_DESC);
        $datatype_select->addOptionArray($datatypes);

        $hDepts =& xhelpGetHandler('department');
        $depts =& $hDepts->getObjects();
        $dept_select =& new XoopsFormSelect(_AM_XHELP_TEXT_DEPARTMENTS, 'fld_departments', $fld_departments, 5, true);
        $dept_select->setDescription(_AM_XHELP_TEXT_DEPT_DESC);
        foreach($depts as $obj) {
            $dept_select->addOption($obj->getVar('id'), $obj->getVar('department'));
        }
        unset($depts);

        if (! $field_errors === false) {
            xhelpRenderErrors($field_errors, xhelpMakeURI(XHELP_ADMIN_URL.'/fields.php', array('op'=>'clearEditSession', 'id'=>$fld_id)));
        }

        $form = new xhelpForm(_AM_XHELP_EDIT_FIELD, 'edit_field', xhelpMakeURI(XHELP_ADMIN_URL.'/fields.php', array('op'=>'editfield', 'id'=>$fld_id)));

        $nameEle = new XoopsFormText(_AM_XHELP_TEXT_NAME, 'fld_name', 30, 64, $fld_name);
        $nameEle->setDescription(_AM_XHELP_TEXT_NAME_DESC);
        $form->addElement($nameEle);

        $fieldnameEle = new XoopsFormText(_AM_XHELP_TEXT_FIELDNAME, 'fld_fieldname', 30, 64, $fld_fieldname);
        $fieldnameEle->setDescription(_AM_XHELP_TEXT_FIELDNAME_DESC);
        $form->addElement($fieldnameEle);

        $descriptionEle = new XoopsFormTextArea(_AM_XHELP_TEXT_DESCRIPTION, 'fld_description', $fld_description, 5, 60);
        $descriptionEle->setDescription(_AM_XHELP_TEXT_DESCRIPTION_DESC);
        $form->addElement($descriptionEle);
         
        $form->addElement($dept_select);
        $form->addElement($control_select);
        $form->addElement($datatype_select);

        $required = new XoopsFormRadioYN(_AM_XHELP_TEXT_REQUIRED, 'fld_required', $fld_required);
        $required->setDescription(_AM_XHELP_TEXT_REQUIRED_DESC);
        $form->addElement($required);

        $lengthEle = new XoopsFormText(_AM_XHELP_TEXT_LENGTH, 'fld_length', 5, 5, $fld_length);
        $lengthEle->setDescription(_AM_XHELP_TEXT_LENGTH_DESC);
        $form->addElement($lengthEle);

        $widthEle = new XoopsFormText(_AM_XHELP_TEXT_WEIGHT, 'fld_weight', 5, 5, $fld_weight);
        $widthEle->setDescription(_AM_XHELP_TEXT_WEIGHT_DESC);
        $form->addElement($widthEle);

        $regex_control =& new xhelpFormRegex(_AM_XHELP_TEXT_VALIDATION, 'fld_valid', $fld_validation);
        $regex_control->setDescription(_AM_XHELP_TEXT_VALIDATION_DESC);
        $regex_control->addOptionArray($regex_array);

        $form->addElement($regex_control);

        $defaultValueEle = new XoopsFormText(_AM_XHELP_TEXT_DEFAULTVALUE, 'fld_defaultvalue', 30, 100, $fld_defaultvalue);
        $defaultValueEle->setDescription(_AM_XHELP_TEXT_DEFAULTVALUE_DESC);
        $form->addElement($defaultValueEle);
        $values = new XoopsFormTextArea(_AM_XHELP_TEXT_FIELDVALUES, 'fld_values', $fld_values, 5, 60);
        $values->setDescription(_AM_XHELP_TEXT_FIELDVALUES_DESC);
        $form->addElement($values);


        $btn_tray = new XoopsFormElementTray('');
        $btn_tray->addElement(new XoopsFormButton('', 'editField', _AM_XHELP_BUTTON_SUBMIT, 'submit'));
        $btn_tray->addElement(new XoopsFormButton('','cancel', _AM_XHELP_BUTTON_CANCEL));
        $btn_tray->addElement(new XoopsFormHidden('id', $fld_id));

        $form->addElement($btn_tray);
        echo $form->render();

        xhelpAdminFooter();
        xoops_cp_footer();
    } else {
        //Validate Field Information
        $has_errors = false;
        $errors = array();
        $values =& _parseValues($_POST['fld_values']);

        if (!$control = xhelpGetControl($_POST['fld_controltype'])) {
            $has_errors = true;
            $errors['fld_controltype'][] = _AM_XHELP_VALID_ERR_CONTROLTYPE;
        }

        $fld_needslength = $control['needs_length'];
        $fld_needsvalues = $control['needs_values'];

        //name field filled?
        if (trim($_POST['fld_name']) == '') {
            $has_errors = true;
            $errors['fld_name'][] = _AM_XHELP_VALID_ERR_NAME;
        }

        //fieldname filled
        if (trim($_POST['fld_fieldname']) == '') {
            $has_errors = true;
            $errors['fld_fieldname'][] = _AM_XHELP_VALID_ERR_FIELDNAME;
        }

        //fieldname unique?
        $crit = new CriteriaCompo(new Criteria('id', $fld_id, '!='));
        $crit->add(new Criteria('fieldname', $_POST['fld_fieldname']));
        if ($hField->getCount($crit)) {
            $has_errors = true;
            $errors['fld_fieldname'][] = _AM_XHELP_VALID_ERR_FIELDNAME_UNIQUE;
        }

        //Length filled
        if (intval($_POST['fld_length']) == 0 && $fld_needslength == true) {
            $has_errors = true;
            $errors['fld_length'][] = sprintf(_AM_XHELP_VALID_ERR_LENGTH, _XHELP_FIELD_MINLEN, _XHELP_FIELD_MAXLEN);
        }

        //default value in value set?
        if (count($values)) {
            if (!in_array($_POST['fld_defaultvalue'], $values, true) && !array_key_exists($_POST['fld_defaultvalue'], $values) ) {
                $has_errors = true;
                $errors['fld_defaultvalue'][] = _AM_XHELP_VALID_ERR_DEFAULTVALUE;
            }

            //length larger than longest value?
            $length = intval($_POST['fld_length']);
            foreach($values as $key=>$value) {
                if (strlen($key) > $length) {
                    $has_errors = true;
                    $errors['fld_values'][] = sprintf(_AM_XHELP_VALID_ERR_VALUE_LENGTH, htmlentities($key), $length);
                }
            }
        } elseif ($fld_needsvalues) {
            $has_errors = true;
            $errors['fld_values'][] = _AM_XHELP_VALID_ERR_VALUE;
        }

        if ($has_errors) {
            $afield = array();
            $afield['name'] = $_POST['fld_name'];
            $afield['description'] = $_POST['fld_description'];
            $afield['fieldname'] = $_POST['fld_fieldname'];
            $afield['departments'] = $_POST['fld_departments'];
            $afield['controltype'] = $_POST['fld_controltype'];
            $afield['datatype'] = $_POST['fld_datatype'];
            $afield['required'] = $_POST['fld_required'];
            $afield['weight'] = $_POST['fld_weight'];
            $afield['defaultvalue'] = $_POST['fld_defaultvalue'];
            $afield['values'] = $_POST['fld_values'];
            $afield['length'] = $_POST['fld_length'];
            $afield['validation'] = ($_POST['fld_valid_select'] == $_POST['fld_valid_txtbox'] ? $_POST['fld_valid_select'] : $_POST['fld_valid_txtbox']);
            $session->set('xhelp_editField_'.$fld_id, $afield);
            $session->set('xhelp_editFieldErrors_'.$fld_id, $errors);
            //Redirect to edit page (display errors);
            header('Location: '. xhelpMakeURI(XHELP_ADMIN_URL.'/fields.php', array('op'=>'editfield', 'id'=>$fld_id), false));
            exit();

        }
        //Store Modified Field info

        $field->setVar('name', $_POST['fld_name']);
        $field->setVar('description', $_POST['fld_description']);
        $field->setVar('fieldname', $_POST['fld_fieldname']);
        $field->setVar('controltype', $_POST['fld_controltype']);
        $field->setVar('datatype', $_POST['fld_datatype']);
        $field->setVar('fieldlength', $_POST['fld_length']);
        $field->setVar('required', $_POST['fld_required']);
        $field->setVar('weight', $_POST['fld_weight']);
        $field->setVar('defaultvalue', $_POST['fld_defaultvalue']);
        $field->setVar('validation', ($_POST['fld_valid_select'] == $_POST['fld_valid_txtbox'] ? $_POST['fld_valid_select'] : $_POST['fld_valid_txtbox']));
        $field->setValues($values);
        $field->addDepartments($_POST['fld_departments']);

        if ($hField->insert($field)) {
            _clearEditSessionVars($fld_id);
            redirect_header(xhelpMakeURI(XHELP_ADMIN_URL.'/fields.php'), 3, _AM_XHELP_MSG_FIELD_UPD_OK);
        } else {
            redirect_header(xhelpMakeURI(XHELP_ADMIN_URL.'/fields.php', array('op'=>'editfield', 'id'=>$fld_id), false), 3, _AM_XHELP_MSG_FIELD_UPD_ERR);
        }
    }

}

function &_getRegexArray()
{
    $regex_array = array(
        '' => _AM_XHELP_TEXT_REGEX_CUSTOM,
        '^\d{3}-\d{3}-\d{4}$' => _AM_XHELP_TEXT_REGEX_USPHONE,
        '^\d{5}(-\d{4})?' => _AM_XHELP_TEXT_REGEX_USZIP,
        '^\w(?:\w|-|\.(?!\.|@))*@\w(?:\w|-|\.(?!\.))*\.\w{2,3}$' => _AM_XHELP_TEXT_REGEX_EMAIL);

    return $regex_array;
}

function setFieldRequired()
{

    $setRequired = intval($_GET['setrequired']);
    $id = intval($_GET['id']);

    $setRequired = ($setRequired <> 0 ?  1 : 0);

    $hField =& xhelpGetHandler('ticketField');

    if ($field =& $hField->get($id)) {
        $field->setVar('required', $setRequired);
        $ret = $hField->insert($field, true);
        if ($ret) {
            header('Location: ' . xhelpMakeURI(XHELP_ADMIN_URL .'/fields.php'));
        } else {
            redirect_header(xhelpMakeURI(XHELP_ADMIN_URL .'/fields.php'), 3, _AM_XHELP_MSG_FIELD_UPD_ERR);
        }
    } else {
        redirect_header(xhelpMakeURI(XHELP_ADMIN_URL .'/fields.php'), 3, _AM_XHELP_MESSAGE_NO_FIELD);
    }




}

function clearAddSession()
{
    _clearAddSessionVars();
    header('Location: ' . xhelpMakeURI(XHELP_ADMIN_URL.'/fields.php'));
}

function clearEditSession()
{
    $fieldid = $_REQUEST['id'];
    _clearEditSessionVars($fieldid);
    header('Location: ' . xhelpMakeURI(XHELP_ADMIN_URL.'/fields.php', array('op'=>'editfield', 'id'=>$fieldid), false));
}

function _clearAddSessionVars()
{
    $session = Session::singleton();
    $session->del('xhelp_addField');
    $session->del('xhelp_addFieldErrors');
}

function _clearEditSessionVars($id)
{
    $id = intval($id);
    $session = Session::singleton();
    $session->del("xhelp_editField_$id");
    $session->del("xhelp_editFieldErrors_$id");
}


?>