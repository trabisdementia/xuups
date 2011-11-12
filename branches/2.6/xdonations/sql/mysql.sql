##########################################################################
## Donations - Paypal financial management module for Xoops 2           ##
## Copyright (c) 2004 by Xoops2 Donations Module Dev Team		##
## http://dev.xoops.org/modules/xfmod/project/?group_id=1060		##
## $Id: mysql.sql,v 1.11 2004/10/15 18:05:48 blackdeath_csmc Exp $      ##
##########################################################################
##                                                                      ##
## Based on NukeTreasury for PHP-Nuke - by Dave Lawrence AKA Thrash     ##
## NukeTreasury - Financial management for PHP-Nuke                     ##
## Copyright (c) 2004 by Dave Lawrence AKA Thrash                       ##
##                       thrash@fragnastika.com                         ##
##                       thrashn8r@hotmail.com                          ##
##                                                                      ##
##########################################################################
##                                                                      ##
## This program is free software; you can redistribute it and/or modify ##
## it under the terms of the GNU General Public License as published by ##
## the Free Software Foundation; either version 2 of the License.       ##
##                                                                      ##
## This program is distributed in the hope that it will be useful, but  ##
## WITHOUT ANY WARRANTY; without even the implied warranty of           ##
## MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU     ##
## General Public License for more details.                             ##
##                                                                      ##
## You should have received a copy of the GNU General Public License    ##
## along with this program; if not, write to the Free Software          ##
## Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307  ##
## USA                                                                  ##
##########################################################################

#
# Table structure for table `donations_config`
#
# Creation: Sep 30, 2004 at 09:06 PM
# Last update: Sep 30, 2004 at 10:12 PM
#

CREATE TABLE `donations_config` (
  `name` varchar(25) NOT NULL default '',
  `subtype` varchar(20) NOT NULL default '',
  `value` varchar(200) NOT NULL default '0',
  `text` text NOT NULL,
  KEY (`name`),
  KEY (`subtype`)
) ENGINE=MyISAM;

# --------------------------------------------------------

#
# Table structure for table `donations_financial`
#
# Creation: Mar 31, 2004 at 12:11 AM
# Last update: Apr 22, 2004 at 09:25 PM
#

CREATE TABLE `donations_financial` (
  `id` int(11) NOT NULL auto_increment,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `num` varchar(16) NOT NULL default '',
  `name` varchar(128) NOT NULL default '',
  `descr` varchar(128) NOT NULL default '',
  `amount` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY (`name`)
) ENGINE=MyISAM;

#
# Dumping data for table `donations_financial`
#

# --------------------------------------------------------

############################################################
#  `receiver_id` varchar(127) NOT NULL default '', //
#  `num_cart_items` varchar(127) NOT NULL default '', //
#  `pending_reason` varchar(127) NOT NULL default '', //
#  `reason_code` varchar(127) NOT NULL default '', //
#  `payment_type` varchar(127) NOT NULL default '', //
#  `for_auction` varchar(127) NOT NULL default '', //
#  `auction_buyer_id` varchar(127) NOT NULL default '', //
#  `auction_closing_date` varchar(127) NOT NULL default '', //
#  `auction_multi_item` varchar(127) NOT NULL default '', //
#  `payer_business_name` varchar(127) NOT NULL default '', //
#  `address_name` varchar(127) NOT NULL default '', //
#  `payer_id` varchar(127) NOT NULL default '', //
#  `notify_version` varchar(127) NOT NULL default '', //
#  `verify_sign` varchar(127) NOT NULL default '', //
################################################


#
# Table structure for table `donations_transactions`
#
# Creation: Mar 31, 2004 at 12:11 AM
# Last update: Apr 23, 2004 at 10:09 PM
#

CREATE TABLE `donations_transactions` (
  `id` int(8) unsigned NOT NULL auto_increment,
  `business` varchar(50) NOT NULL default '',
  `receiver_email` varchar(127) NOT NULL default '',
  `receiver_id` varchar(127) NOT NULL default '',
  `item_name` varchar(60) NOT NULL default '',
  `item_number` varchar(40) NOT NULL default '',
  `quantity` varchar(6) NOT NULL default '',
  `invoice` varchar(40) NOT NULL default '',
  `custom` varchar(127) NOT NULL default '',
  `memo` text NOT NULL,
  `tax` varchar(10) NOT NULL default '',
  `option_name1` varchar(60) NOT NULL default '',
  `option_selection1` varchar(127) NOT NULL default '',
  `option_name2` varchar(60) NOT NULL default '',
  `option_selection2` varchar(127) NOT NULL default '',
  `num_cart_items` varchar(127) NOT NULL default '',
  `mc_gross` varchar(10) NOT NULL default '',
  `mc_fee` varchar(10) NOT NULL default '',
  `mc_currency` varchar(5) NOT NULL default '',
  `settle_amount` varchar(12) NOT NULL default '',
  `settle_currency` varchar(5) NOT NULL default '',
  `exchange_rate` varchar(10) NOT NULL default '',
  `payment_gross` varchar(10) NOT NULL default '',
  `payment_fee` varchar(10) NOT NULL default '',
  `payment_status` varchar(15) NOT NULL default '',
  `pending_reason` varchar(127) NOT NULL default '',
  `reason_code` varchar(127) NOT NULL default '',
  `payment_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `txn_id` varchar(20) NOT NULL default '',
  `parent_txn_id` varchar(20) NOT NULL default '',
  `txn_type` varchar(15) NOT NULL default '',
  `payment_type` varchar(127) NOT NULL default '',
  `for_auction` varchar(127) NOT NULL default '',
  `auction_buyer_id` varchar(127) NOT NULL default '',
  `auction_closing_date` varchar(127) NOT NULL default '',
  `auction_multi_item` varchar(127) NOT NULL default '',
  `first_name` varchar(127) NOT NULL default '',
  `last_name` varchar(127) NOT NULL default '',
  `payer_business_name` varchar(127) NOT NULL default '',
  `address_name` varchar(127) NOT NULL default '',
  `address_street` varchar(127) NOT NULL default '',
  `address_city` varchar(127) NOT NULL default '',
  `address_state` varchar(127) NOT NULL default '',
  `address_zip` varchar(20) NOT NULL default '',
  `address_country` varchar(127) NOT NULL default '',
  `address_status` varchar(15) NOT NULL default '',
  `payer_email` varchar(127) NOT NULL default '',
  `payer_id` varchar(127) NOT NULL default '',
  `payer_status` varchar(15) NOT NULL default '',
  `notify_version` varchar(127) NOT NULL default '',
  `verify_sign` varchar(127) NOT NULL default '',
  `test_ipn` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY (`txn_id`),
  KEY (`payment_date`)
) ENGINE=MyISAM;

#
# Dumping data for table `donations_transactions`
#

# --------------------------------------------------------

#
# Table structure for table `donations_translog`
#
# Creation: Mar 31, 2004 at 12:11 AM
# Last update: Apr 23, 2004 at 08:33 AM
#

CREATE TABLE `donations_translog` (
  `id` int(11) NOT NULL auto_increment,
  `log_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `payment_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `logentry` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

#
# Dumping data for table `donations_translog`
#
