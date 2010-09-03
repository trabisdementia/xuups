<?php
require('../../../mainfile.php');

if (!defined('XHELP_CONSTANTS_INCLUDED')) {
    include_once(XOOPS_ROOT_PATH . '/modules/xhelp/include/constants.php');
}
require_once XHELP_JPSPAN_PATH . '/JPSpan.php'; // Including this sets up the JPSPAN constants
require_once JPSPAN . 'Server/PostOffice.php'; // Load the PostOffice server
include_once(XHELP_BASE_PATH . '/functions.php');

// Create the PostOffice server
$server = & new JPSpan_Server_PostOffice();
$server->addHandler(new xhelpWebLib());

if (isset($_SERVER['QUERY_STRING']) &&
    strcasecmp($_SERVER['QUERY_STRING'], 'client') == 0) {

    // Compress the output Javascript (e.g. strip whitespace)
    define('JPSPAN_INCLUDE_COMPRESS', TRUE);

    // Display the Javascript client
    $server->displayClient();
} else {
    // This is where the real serving happens...
    // Include error handler
    // PHP errors, warnings and notices serialized to JS
    require_once JPSPAN . 'ErrorHandler.php';

    // Start serving requests...
    $server->serve();
}

class xhelpWebLib
{
    function customFieldsByDept($deptid)
    {
        $deptid = intval($deptid);
        $hFieldDept =& xhelpGetHandler('ticketFieldDepartment');
        $fields =& $hFieldDept->fieldsByDepartment($deptid);

        $aFields = array();
        foreach ($fields as $field) {
            $aFields[] = $field->toArray();
        }

        return $aFields;
    }

    function editTicketCustFields($deptid, $ticketid)
    {
        $deptid = intval($deptid);
        $hFieldDept =& xhelpGetHandler('ticketFieldDepartment');
        $hTicket =& xhelpGetHandler('ticket');
        $ticket =& $hTicket->get($ticketid);
        $custValues =& $ticket->getCustFieldValues();
        $fields =& $hFieldDept->fieldsByDepartment($deptid);

        $aFields = array();
        foreach ($fields as $field) {
            $_arr =& $field->toArray();
            $_fieldname = $_arr['fieldname'];
            $_arr['currentvalue'] = isset($custValues[$_fieldname]) ? $custValues[$_fieldname]['key'] : '';
            $aFields[] = $_arr;

        }

        return $aFields;
    }

    function staffByDept($deptid)
    {
        $mc =& xhelpGetModuleConfig();
        $field = $mc['xhelp_displayName'] == 1 ? 'uname' : 'name';


        $deptid = intval($deptid);
        $hMembership =& xhelpGetHandler('membership');
        $staff =& $hMembership->xoopsUsersByDept($deptid);

        $aStaff = array();
        $aStaff[] = array('uid' => 0,
                          'name' => _XHELP_MESSAGE_NOOWNER);
        foreach ($staff as $s) {
            $aStaff[] = array('uid' => $s->getVar('uid'),
                              'name' => $s->getVar($field));
        }

        return $aStaff;
    }
}

?>