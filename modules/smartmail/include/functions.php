<?php

/**
 * $Id: functions.php,v 1.1 2006/07/07 20:23:24 marcan Exp $
 * Module: SmartShop
 * Author: The SmartFactory <www.smartfactory.ca>
 * Licence: GNU
 */
/**
 * Creates a xoops account from an email address and password
 *
 * @param string $email
 * @param string $password
 * @return {@link xoopsUser} object if success, FALSE if failure
 * @author xHelp Team
 *
 * @access public
 */
function &smartmail_XoopsAccountFromEmail($email, $name, &$password, $level, &$actkey)
{
    $member_handler =& xoops_gethandler('member');

    $unamecount = 10;
    if (strlen($password) == 0) {
        $password = substr(md5(uniqid(mt_rand(), 1)), 0, 6);
    }

    $usernames = smartmail_GenUserNames($email, $name, $unamecount);
    $newuser = false;
    $i = 0;
    while ($newuser == false) {
        $crit = new Criteria('uname', $usernames[$i]);
        $count = $member_handler->getUserCount($crit);
        if ($count == 0) {
            $newuser = true;
        } else {
            //Move to next username
            $i++;
            if ($i == $unamecount) {
                //Get next batch of usernames to try, reset counter
                $usernames = smartmail_GenUserNames($email->getEmail(), $email->getName(), $unamecount);
                $i = 0;
            }
        }

    }
     
    $xuser =& $member_handler->createUser();
    $xuser->setVar("uname",$usernames[$i]);
    $xuser->setVar("loginname", $usernames[$i]);
    $xuser->setVar("user_avatar","blank.gif");
    $xuser->setVar('user_regdate', time());
    $xuser->setVar('timezone_offset', 0);
    $actkey = substr(md5(uniqid(mt_rand(), 1)), 0, 8);
    $xuser->setVar('actkey', $actkey);
    $xuser->setVar("email",$email);
    $xuser->setVar("name", $name);
    $xuser->setVar("pass", md5($password));
    $xuser->setVar('notify_method', 2);
    $xuser->setVar("level",$level);

    if ($member_handler->insertUser($xuser)){
        //Add the user to Registered Users group
        $member_handler->addUserToGroup(XOOPS_GROUP_USERS, $xuser->getVar('uid'));
    } else {
        return false;
    }

    return $xuser;
}

/**
 * Generates an array of usernames
 *
 * @param string $email email of user
 * @param string $name name of user
 * @param int $count number of names to generate
 * @return array $names
 * @author xHelp Team
 *
 * @access public
 */
function smartmail_GenUserNames($email, $name, $count=20)
{
    $names = array();
    $userid   = explode('@',$email);


    $basename = '';
    $hasbasename = false;
    $emailname = $userid[0];

    $names[] = $emailname;

    if (strlen($name) > 0) {
        $name = explode(' ', trim($name));
        if (count($name) > 1) {
            $basename = strtolower(substr($name[0], 0, 1) . $name[count($name) - 1]);
        } else {
            $basename = strtolower($name[0]);
        }
        $basename = xoops_substr($basename, 0, 60, '');
        //Prevent Duplication of Email Username and Name
        if (!in_array($basename, $names)) {
            $names[] = $basename;
            $hasbasename = true;
        }
    }

    $i = count($names);
    $onbasename = 1;
    while ($i < $count) {
        $num = smartmail_GenRandNumber();
        if ($onbasename < 0 && $hasbasename) {
            $names[] = xoops_substr($basename, 0, 58, '').$num;

        } else {
            $names[] = xoops_substr($emailname, 0, 58, ''). $num;
        }
        $i = count($names);
        $onbasename = ~ $onbasename;
        $num = '';
    }

    return $names;

}

/**
 * Creates a random number with a specified number of $digits
 *
 * @param int $digits number of digits
 * @return return int random number
 * @author xHelp Team
 *
 * @access public
 */
function smartmail_GenRandNumber($digits = 2)
{
    smartmail_InitRand();
    $tmp = array();

    for ($i = 0; $i < $digits; $i++) {
        $tmp[$i] = (rand()%9);
    }
    return implode('', $tmp);
}

/**
 * Gives the random number generator a seed to start from
 *
 * @return void
 *
 * @access public
 */
function smartmail_InitRand()
{
    static $randCalled = FALSE;
    if (!$randCalled)
    {
        srand((double) microtime() * 1000000);
        $randCalled = TRUE;
    }
}

?>