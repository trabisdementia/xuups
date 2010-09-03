<?php
//$Id: staffService.php,v 1.13 2005/12/01 22:36:21 ackbarr Exp $

/**
 * xhelp_staffService class
 *
 * Part of the Messaging Subsystem.  Updates staff member information.
 *
 *
 * @author Brian Wahoff <ackbarr@xoops.org>
 * @access public
 * @package xhelp
 */

class xhelpStaffService extends xhelpService
{
    /**
     * Instance of the xoopsStaffHandler
     *
     * @var    object
     * @access    private
     */
    var $_hStaff;

    /**
     * Class Constructor
     *
     * @access    public
     */
    function xhelpStaffService()
    {
        $this->_hStaff =& xhelpGetHandler('staff');
        $this->init();
    }

    /**
     * Update staff response time if first staff response
     * @param xhelpTicket $ticket Ticket for response
     * @param xhelpResponses $response Response
     * @return bool True on success, false on error
     * @access public
     */
    function new_response($ticket, $response)
    {
        global $xoopsUser;


        //if first response for ticket, update staff responsetime
        $hResponse =& xhelpGetHandler('responses');
        $hMembership =& xhelpGetHandler('membership');
        if ($hResponse->getStaffResponseCount($ticket->getVar('id')) == 1) {
            if ($hMembership->isStaffMember($response->getVar('uid'), $ticket->getVar('department'))) {
                $responseTime = abs($response->getVar('updateTime') - $ticket->getVar('posted'));
                $this->_hStaff->updateResponseTime($response->getVar('uid'), $responseTime);
            }
        }

    }

    /**
     * Update staff response time if first staff response
     * @param xhelpTicket $ticket Ticket for response
     * @param xhelpResponses $response Response
     * @param int $timespent Number of minutes spent on ticket
     * @param bool $private Is the response private?
     * @return bool True on success, false on error
     * @access public
     */
    function batch_response($tickets, $response)
    {
        global $xoopsUser;

        $update = time();
        $uid = $xoopsUser->getVar('uid');
        $hResponse =& xhelpGetHandler('responses');
        foreach ($tickets as $ticket) {
            //if first response for ticket, update staff responsetime

            $hMembership =& xhelpGetHandler('membership');
            if ($hResponse->getStaffResponseCount($ticket->getVar('id')) == 1) {
                $responseTime = abs($update - $ticket->getVar('posted'));
                $this->_hStaff->updateResponseTime($uid, $responseTime);
            }
        }


    }

    /**
     * Handler for the 'batch_status' event
     * @param array $tickets Array of xhelpTicket objects
     * @param int $newstatus New Status of all tickets
     * @return bool True on success, false on error
     * @access public
     */
    function batch_status($tickets, $newstatus)
    {
        global $xoopsUser;

        $uid = $xoopsUser->getVar('uid');

        if ($newstatus->getVar('state') == XHELP_STATE_RESOLVED) {
            $this->_hStaff->increaseCallsClosed($uid, count($tickets));
        }

    }

    /**
     * Callback function for the 'close_ticket' event
     * @param xhelpTicket $ticket Closed ticket
     * @return bool True on success, false on error
     * @access public
     */
    function close_ticket($ticket)
    {
        global $xoopsUser;

        $hMembership =& xhelpGetHandler('membership');
        if ($hMembership->isStaffMember($ticket->getVar('closedBy'), $ticket->getVar('department'))) {
            $this->_hStaff->increaseCallsClosed($ticket->getVar('closedBy'), 1);
        }
        return true;
    }

    /**
     * Callback function for the 'reopen_ticket' event
     * @param array $args Array of arguments passed to EventService
     * @return bool True on success, false on error
     * @access public
     */
    function reopen_ticket($ticket)
    {

        $hMembership =& xhelpGetHandler('membership');
        if ($hMembership->isStaffMember($ticket->getVar('closedBy'), $ticket->getVar('department'))) {
            $this->_hStaff->increaseCallsClosed($ticket->getVar('closedBy'), -1);
        }
        return true;
    }

    /**
     * Callback function for the 'new_response_rating' event
     * @param xhelpRating $rating Rating
     * @param xhelpTicket $ticket Ticket that was rated
     * @param xhelpResponse $response Response that was rated
     * @return bool True on success, false on error
     * @access public
     */
    function new_response_rating($rating, $ticket, $response)
    {
        global $xoopsUser;

        $hStaff =& xhelpGetHandler('staff');
        return $hStaff->updateRating($rating->getVar('staffid'), $rating->getVar('rating'));
    }

    /**
     * Event Handler for 'view_ticket'
     * @param xhelpTicket $ticket Ticket being viewd
     * @return bool True on success, false on error
     * @access public
     */
    function view_ticket($ticket)
    {
        $value = array();

        //Store a list of recent tickets in the xhelp_recent_tickets cookie
        if (isset($_COOKIE['xhelp_recent_tickets'])) {
            $oldvalue = explode(',', $_COOKIE['xhelp_recent_tickets']);
        } else {
            $oldvalue = array();
        }

        $value[] = $ticket->getVar('id');

        $value = array_merge($value, $oldvalue);
        $value = $this->_array_unique($value);
        $value = array_slice($value, 0, 5);
        //Keep this value for 15 days
        setcookie('xhelp_recent_tickets', implode(',', $value), time() + 15 * 24 * 60 * 60, '/');
    }

    /**
     * Event Handler for 'delete_staff' event
     * @param xhelpStaff $staff Staff member being deleted
     * @return bool True on success, false on error
     * @access public
     */
    function delete_staff($staff)
    {
        $hTicket =& xhelpGetHandler('ticket');

        return $hTicket->updateAll('ownership', 0, new Criteria('ownership', $staff->getVar('uid')));
    }

    /**
     * Only have 1 instance of class used
     * @return object {@link xhelp_staffService}
     * @access    public
     */
    function &singleton()
    {
        // Declare a static variable to hold the object instance
        static $instance;

        // If the instance is not there, create one
        if (!isset($instance)) {
            $c = __CLASS__;
            $instance = new $c;
        }
        return ($instance);
    }

    function _array_unique($array)
    {
        $out = array();

        //    loop through the inbound
        foreach ($array as $key => $value) {
            //    if the item isn't in the array
            if (!in_array($value, $out)) { //    add it to the array
                $out[$key] = $value;
            }
        }

        return $out;
    }

    function _attachEvents()
    {
        $this->_attachEvent('batch_response', $this);
        $this->_attachEvent('batch_status', $this);
        $this->_attachEvent('close_ticket', $this);
        $this->_attachEvent('delete_staff', $this);
        $this->_attachEvent('new_response', $this);
        $this->_attachEvent('new_response_rating', $this);
        $this->_attachEvent('reopen_ticket', $this);
        $this->_attachEvent('view_ticket', $this);
    }
}

?>