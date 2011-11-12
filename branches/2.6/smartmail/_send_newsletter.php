<?php
// $Id: _send_newsletter.php,v 1.2 2006/06/17 14:40:44 marcan Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

include "../../mainfile.php";

if( in_array($_SERVER['REMOTE_ADDR'], array_map('trim', implode(',', $xoopsModuleConfig['allowed_hosts']))) ) {

    $dispatch_handler = xoops_getmodulehandler('dispatch', 'smartmail');
    /* @var $dispatch_handler NewsletterDispatchHandler */
    $dispatches = $dispatch_handler->getReadyDispatches();

    header("Content-Type: text/plain; charset: iso-8859-1");
    echo "Starting cron\n";
    echo "Queue: " . count($dispatches) . "\n";

    if (count($dispatches) > 0) {
        foreach (array_keys($dispatches) as $i) {
            $newsletter = $dispatches[$i]->getNewsletter();
            if ($dispatches[$i]->send(false)) {
                echo $newsletter->getVar('newsletter_name')." Sent" . "\n";
            }
            else {
                echo $newsletter->getVar('newsletter_name')." could not be sent" . "\n";
            }
        }
    }

    echo "Done\n";
} else {
    trigger_error( 'Error', E_USER_ERROR );
}

// include XOOPS_ROOT_PATH."/footer.php";
?>